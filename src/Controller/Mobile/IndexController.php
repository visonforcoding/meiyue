<?php

namespace App\Controller\Mobile;

use App\Controller\Mobile\AppController;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;

/**
 * Index Controller
 *
 * @property \App\Model\Table\IndexTable $Index
 * @property \App\Controller\Component\SmsComponent $Sms
 * @property \App\Controller\Component\WxComponent $Wx
 * @property \App\Controller\Component\EncryptComponent $Encrypt
 * @property \App\Controller\Component\PushComponent $Push
 * @property \App\Controller\Component\BdmapComponent $Bdmap
 * @property \App\Controller\Component\BusinessComponent $Business
 */
class IndexController extends AppController {

    /**
     * Index method
     * 发现首页
     * @return \Cake\Network\Response|null
     */
    public function index() {
        $this->set([
            'user' => $this->user,
            'pageTitle' => '发现-美约'
        ]);
    }

    
    /**
     * 土豪榜
     */
    public function findRichList() {
        $UserTable = TableRegistry::get('User');
        $query = $UserTable->find()->select(['id','avatar','nick','recharge'])
                              ->where(['enabled'=>1,'gender'=>1])
                              ->orderDesc('recharge')
                              ->offset(0)
                              ->limit(3);
        if($this->user){
            $user_id = $this->user->id;
            $query->contain([
                            'Fans'=>function($q)use($user_id){
                                return $q->where(['user_id'=>$user_id]);
                            }
                        ]);
        }
        $top3 = $query->toArray();
        $this->set([
            'user' => $this->user,
            'pageTitle' => '美约',
            'top3'=>$top3
        ]);
    }

    /**
     * 获取土豪榜
     */
    public function getRichList($page){
        $UserTable = TableRegistry::get('User');
        $query = $UserTable->find()->select(['id','avatar','nick','recharge'])
                          ->where(['enabled'=>1,'gender'=>1])
                          ->orderDesc('recharge')
                          ->limit(10);
        if($this->user){
            $user_id = $this->user->id;
            $query->contain([
                            'Fans'=>function($q)use($user_id){
                                return $q->where(['user_id'=>$user_id]);
                            }
                        ]);
        }
        if($page=1){
            $query->offset(3);
        }else{
            $query->page($page);
        }                                
        $richs = $query->toArray();                
        return $this->Util->ajaxReturn(['richs'=>$richs]);                            
    }
    /**
     * 发现列表
     */
    public function findList() {
        $this->loadComponent('Business');
        $skills = $this->Business->getTopSkill();
        $this->set([
            'pageTitle' => '发现',
            'skills' => $skills
        ]);
    }

    public function getUserList($page) {
        $limit = 10;
        $userCoord = $this->coord;
        $userCoord_arr = explode(',', $userCoord);
        $userCoord_lng = $userCoord_arr[0];
        $userCoord_lat = $userCoord_arr[1];
        $UserTable = \Cake\ORM\TableRegistry::get('User');
        $skill = $this->request->query('skill');
        $query = $UserTable->find();
        $query = $query->select(['id', 'nick', 'distance' =>
            "getDistance($userCoord_lng,$userCoord_lat,login_coord_lng,login_coord_lat)", 'birthday',
            'profession', 'login_time', 'avatar', 'login_coord_lng', 'login_coord_lat']);
        $query->hydrate(false);
        if ($skill) {
            $query->matching('UserSkills.Skill', function($q)use($skill) {
                return $q->where(['parent_id' => $skill]);
            });
        }
        $query->where(['enabled' => 1, 'status' => 3, 'gender' => 2]);
        //身高范围
        $heightL = $this->request->query('heightL');
        $heightR = $this->request->query('heightR');
        //年龄范围
        $ageL = $this->request->query('ageL');
        $ageR = $this->request->query('ageR');
        $birthdayL = Time::now()->year - intval($ageL);
        $birthdayR = Time::now()->year - intval($ageR);
        if($ageL&&$ageR){
            $query->where(['year(`birthday`) >='=>$birthdayR,'year(`birthday`) <='=>$birthdayL]);
        }
        if($heightL&&$heightR){
            $query->where(['height >='=>$heightL,'height <='=>$heightR]);
        }
        $query->order(['distance' => 'asc', 'login_time' => 'desc']);
        $query->limit(intval($limit))
                ->page(intval($page));
        $query->formatResults(function($items)use($userCoord) {
            return $items->map(function($item)use($userCoord) {
                        $item['distance'] = $item['distance'] >= 1000 ?
                                round($item['distance'] / 1000, 1) . 'km' : round($item['distance']) . 'm';
                        $item['avatar'] = createImg($item['avatar']) . '?w=434';
                        $item['age'] = (Time::now()->year) - ((new Time($item['birthday']))->year);
                        //时间语义化转换
                        $item['login_time'] = (new Time($item['login_time']))->timeAgoInWords(
                                [ 'accuracy' => [
                                        'year' => 'year',
                                        'month' => 'month',
                                        'week' => 'week',
                                        'day' => 'day',
                                        'hour' => 'hour'
                                    ], 'end' => '+10 year']
                        );
                        return $item;
                    });
        });
        $users = $query->toArray();
        return $this->Util->ajaxReturn(['users' => $users]);
    }

    public function homepage($id) {
        //个人信息
        $userCoord = $this->coord;
        $UserTable = \Cake\ORM\TableRegistry::get('User');
        $user = $UserTable->get($id, [
            'contain' => [
                'UserSkills' => function($q) {
                    return $q->where(['is_used' => 1, 'is_checked' => 1]);
                },
                'UserSkills.Skill',
                'UserSkills.Cost'
            ]
        ]);
        $distance = getDistance($userCoord, $user->login_coord_lng, $user->login_coord_lat);
        $age = (Time::now()->year) - ((new Time($user->birthday))->year);
        $birthday = date('m-d', strtotime($user->birthday));

        $isFollow = false;  //是否关注
        if ($this->user) {
            $UserFansTable = \Cake\ORM\TableRegistry::get('UserFans');
            $follow = $UserFansTable->find()->where(['user_id' => $this->user->id, 'following_id' => $id])->count();
            if ($follow) {
                $isFollow = true;
            }
        }
        //若登录
        $this->set([
            'pageTitle' => '发现-主页',
            'user' => $user,
            'age' => $age,
            'distance' => $distance,
            'birthday' => $birthday,
            'isFollow' => $isFollow,
        ]);
    }

    /**
     * 约她  技能列表
     * @param type $id
     */
    public function findSkill($id) {
        $UserSkillTable = TableRegistry::get('UserSkill');
        $this->loadComponent('Business');
        $topSkills = $this->Business->getTopSkill();
        $userSkills = $UserSkillTable->find()
            ->contain(['Skill', 'Cost'])
            ->where(['user_id' => $id, 'is_used' => 1, 'is_checked' => 1])
            ->toArray();
        $this->set([
            'pageTitle' => '约她',
            'topSkills' => $topSkills,
            'userSkills' => $userSkills
        ]);
    }

    public function demo() {
        //GlideHelper::image('/upload/user/avatar/2016-10-28/58102ba461a5e.jpg');
        //$this->loadComponent('Bdmap');
        //$res = $this->Bdmap->placeSearchNearBy('咖啡', '22.64322,114.0322');
        $this->set([
            'pageTitle' => '测试'
        ]);
    }

    public function getParam() {
        $time = time();
        $sign = strtoupper(md5($time . '64e3f4e947776b2d6a61ffbf8ad05df4'));
        debug([
            'time' => $time,
            'sign' => $sign
        ]);
        exit();
    }

    public function test() {
        //var_dump(round1214 / 1000);
        //var_dump(round('42.99687156342637',1));
        debug($this->Util->getServerDomain());
        exit();
    }


    /**
     * 检查查看微信权限
     */
    public function checkWxRig($wxerid = null) {
        $this->handCheckLogin();
        if($this->request->is('POST') && $wxerid) {
            $wxorderTb = TableRegistry::get('Wxorder');
            $wxorder = $wxorderTb->find()
                ->contain(['Wxer' => function($q) {
                    return $q->select(['wxid', 'nick']);
                }])
                ->where(['user_id' => $this->user->id, 'wxer_id' => $wxerid])
                ->first();
            if($wxorder) {
                return $this->Util->ajaxReturn([
                    'status' => true,
                    'msg' => '已经支付',
                    'userwx' => $wxorder
                ]);
            }else {
                return $this->Util->ajaxReturn(false, '尚未支付');
            }
        }
    }


    /**
     * 查看微信支付
     */
    /*public function pay4wx($wxerid = null) {
        $this->handCheckLogin();
        if(!$wxerid) {
            return $this->Util->ajaxReturn(false, '非法操作');
        }

        if(!$wxerid) {
            return $this->Util->ajaxReturn(false, '非法操作');
        }
        //扣除 预约金
        $pre_amount = $this->user->money;
        $this->user->money = $this->user->money - 100;
        $user = $this->user;
        $after_amount = $this->user->money;
        //生成流水
        $FlowTable = TableRegistry::get('Flow');
        $flow = $FlowTable->newEntity([
            'user_id'=>0,
            'buyer_id'=>  $this->user->id,
            'type'=>18,
            'type_msg'=>getFlowType('18'),
            'income'=>2,
            'amount'=>100,
            'price'=>100,
            'pre_amount'=>$pre_amount,
            'after_amount'=>$after_amount,
            'paytype'=>1,   //余额支付
            'remark'=> getFlowType('18')
        ]);
        //生成查看记录
        $anhao = '美约'.mt_rand(10000, 99999);
        $wxorderTb = TableRegistry::get('Wxorder');
        $wxorder = $wxorderTb->newEntity([
            'user_id' => $this->user->id,
            'wxer_id' => $wxerid,
            'anhao' => $anhao
        ]);
        $transRes = $FlowTable->connection()->transactional(function() use ($flow, $FlowTable, $user, $wxorderTb, $wxorder){
            $UserTable = TableRegistry::get('User');
            return $FlowTable->save($flow)&&$wxorderTb->save($wxorder)&&$UserTable->save($user);
        });
        if($transRes) {
            return $this->Util->ajaxReturn(true, '支付成功');
        } else {
            return $this->Util->ajaxReturn(false, '支付失败');
        }
    }*/


    /**
     * 查看微信支付
     * 生成  支付订单
     */
    public function createPayorder($wxerid){
        $this->handCheckLogin();
        if($this->request->is('POST')) {
            $PayorderTable = TableRegistry::get('Payorder');
            $payorder = $PayorderTable->newEntity([
                'user_id'=>  $this->user->id,
                'relate_id' => $wxerid,
                'type' => PayOrderType::VIEW_WEIXIN,   //查看美女微信
                'title'=>'查看美女微信',
                'order_no'=>time() . $this->user->id . createRandomCode(4, 1),
                'price'=> 100,
                'remark'=> '查看美女微信',
            ]);
            if($PayorderTable->save($payorder)){
                return $this->Util->ajaxReturn(['status' => true, 'msg' => '支付单生成成功', 'orderid' => $payorder->id]);
            }else{
                return $this->Util->ajaxReturn(['status' => false, 'msg' => '支付单生成失败']);
            }
        }
    }

}
