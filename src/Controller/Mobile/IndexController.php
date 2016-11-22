<?php

namespace App\Controller\Mobile;

use App\Controller\Mobile\AppController;
use Cake\I18n\Time;

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
            'pageTitle' => '发现-美约'
        ]);
    }

    public function findRichList() {
        $FlowTable = \Cake\ORM\TableRegistry::get('Flow');
        $limit = 10;
        $top3 = $FlowTable->find()
                    ->contain([
                        'User'=>function($q){
                                return $q->select(['id','avatar','nick']);
                            },
                     ])
                    ->select(['user_id','total'=>'sum(amount)'])
                     ->where(['type'=>4])                
                    ->group('user_id')               
                    ->orderDesc('total')
                     ->offset(0)               
                    ->limit(3)
                    ->toArray();
        $this->set([
            'pageTitle' => '土豪榜-美约',
            'top3'=>$top3
        ]);
    }

    /**
     * 获取土豪榜
     */
    public function getRichList($page){
        $FlowTable = \Cake\ORM\TableRegistry::get('Flow');
        $limit = 10;
        $query = $FlowTable->find()
                    ->contain([
                        'User'=>function($q){
                                return $q->select(['id','avatar','nick','phone','gender'])->where(['gender'=>1]);
                            },
                     ])
                    ->select(['user_id','total'=>'sum(amount)'])
                    ->where(['type'=>4])                
                    ->group('user_id')
                    ->orderDesc('total')
                    ->limit($limit);
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
        $height = $this->request->query('height');
        $query->where(['enabled' => 1, 'status']);
        $query->order(['distance' => 'asc', 'login_time' => 'desc']);
        $query->limit(intval($limit))
                ->page(intval($page));
        $query->formatResults(function($items)use($userCoord) {
            return $items->map(function($item)use($userCoord) {
                        $item['distance'] = $item['distance'] >= 1000 ?
                                round($item['distance'] / 1000, 1) . 'km' : round($item['distance']) . 'm';
                        $item['avatar'] = createImg($item['avatar']) . '?w=184&h=184&fit=stretch';
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
            'contain' => ['UserSkills', 'UserSkills.Skill', 'UserSkills.Cost']
        ]);
        $distance = getDistance($userCoord, $user->login_coord_lng, $user->login_coord_lat);
        $user->avatar = createImg($user->avatar) . '?w=184&h=184&fit=stretch';
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
        $UserSkillTable = \Cake\ORM\TableRegistry::get('UserSkill');
        $this->loadComponent('Business');
        $topSkills = $this->Business->getTopSkill();
        $userSkills = $UserSkillTable->find()->contain(['Skill'])->where(['user_id' => $id])->toArray();
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

}
