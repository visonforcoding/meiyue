<?php

namespace App\Controller\Mobile;

use App\Controller\Mobile\AppController;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;

/**
 * Userc Controller 个人中心
 *
 * @property \App\Model\Table\UserTable $User
 * @property \App\Controller\Component\SmsComponent $Sms
 */
class UsercController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadModel('User');
    }

    /**
     * 美女粉丝
     */
    public function fans($page=null) {
        if($this->request->is('json')){
            $limit = 10;
            $UserFansTable = \Cake\ORM\TableRegistry::get('UserFans');
            $fans = $UserFansTable->find()->hydrate(false)->contain(['User'=>function($q){
                    return $q->select(['id','birthday','avatar','nick']);
            }])->where(['following_id' => $this->user->id])->limit(intval($limit))
                    ->page(intval($page))->formatResults(function($items) {
                return $items->map(function($item) {
                            $item['user']['avatar'] = createImg($item['user']['avatar']) . '?w=44&h=44&fit=stretch';
                            $item['user']['age'] = (Time::now()->year) - $item['user']['birthday']->year;
                            return $item;
                        });
            })->toArray();
            $this->set(['fans' => $fans]);
        }
        $this->set(['pageTitle'=>'我的粉丝']);
    }


    /**
     * 我的-我的派对
     */
    public function myActivitys()
    {

    }


    /**
     * 我的-我的派对-分页获取我的派对列表
     */
    public function getActsInPage($page) {

        $actRTable = TableRegistry::get('Actregistration');
        $limit = 10;
        $where = ['user_id' => $this->user->id, 'Actregistration.status' => 1];
        $query = $this->request->query('query');
        switch ($query) {
            case 1:
                $where = array_merge($where, ['Activity.end_time <=' => new Time()]);
                break;
            case 2:
                $where = array_merge($where, ['Activity.end_time >'=>new Time()]);
                break;
            default:
                break;
        }
        $datas = $actRTable->find()
            ->contain(['Activity'])
            ->where($where)
            ->limit($limit)
            ->page($page)
            ->map(function($row) {

                $row->date = getYMD($row->activity->start_time);
                $row->time = getHIS($row->activity->start_time, $row->activity->end_time);
                $curdatetime = new Time();
                $row->bustr = '';
                if($row->activity->end_time > $curdatetime) {

                    $row->bustr = '已经结束';

                } else if ($row->activity->start < $curdatetime) {

                    $row->bustr = '即将开启';

                } else if (($row->activity->start < $curdatetime) && ($curdatetime < $row->activity->end)) {

                    $row->bustr = '正在进行';

                }

                return $row;

            })
            ->toArray();
        return $this->Util->ajaxReturn(['datas'=>$datas]);

    }


    /**
     * 我的-我的技能-列表
     */
    public function userSkillsIndex()
    {

        $userSkillTable = \Cake\ORM\TableRegistry::get('UserSkill');
        $query = $userSkillTable->find()->contain(['Skill', 'Cost'])
            ->select(['id', 'is_used', 'Skill.name', 'Cost.money'])
            ->where(['user_id' => $this->user->id, 'is_checked' => 1]);
        $userskills = $query->toArray();
        $is_all_used = true;
        foreach ($userskills as $item) {

            if($item['is_used'] == 0) {

                $is_all_used = false;

            }

        }
        $this->set(['userskills' => $userskills, 'is_all_used' => $is_all_used, 'user' => $this->user, 'pageTitle' => '美约-我的技能']);

    }


    /**
     * 我的-我的技能-添加、编辑技能页面
     */
    public function userSkillsView($action, $userskill_id = null)
    {

        $page_titles = Array(

            'add' => '美约-添加技能',
            'edit' => '美约-编辑技能',

        );

        $userSkillTable = \Cake\ORM\TableRegistry::get('UserSkill');;
        $userskill = null;
        if('edit' == $action) {

            $userskill = $userSkillTable->get($userskill_id, ['contain' => ['Skill', 'Cost', 'Tags']]);

        }
        $this->set(['userskill' => $userskill, 'user' => $this->user, 'pageTitle' => $page_titles[$action]]);
        $this->render('user_skills_view');

    }


    /**
     * 我的-我的技能-添加技能接口
     */
    public function userSkillSave($user_skill_id = null)
    {

        $userSkillTable = \Cake\ORM\TableRegistry::get('UserSkill');

        if($this->request->is("POST")) {

            //约定有用户技能id参数的为修改
            $userSkill = $userSkillTable->newEntity();
            $userSkill = $userSkillTable->patchEntity($userSkill, $this->request->data);
            $userSkill->user_id = $this->user->id;
            $userSkill->is_checked = 2;
            if(isset($user_skill_id)) {

                $userSkill->id = $user_skill_id;

            }
            if ($userSkillTable->save($userSkill)) {
                return $this->Util->ajaxReturn(true, "发布成功");
            } else {
                return $this->Util->ajaxReturn(false, getMessage($userSkill->errors()));
            }

        }

    }


    /**
     * 我的-我的技能-批量修改使用技能上线状态
     */
    public function updateUsedStatus($is_used, $user_skill_id = null) {

        $userSkillTable = \Cake\ORM\TableRegistry::get('UserSkill');
        if(!$user_skill_id) {

            $res = $userSkillTable->updateAll(['is_used' => $is_used], ['user_id' => $this->user->id, 'is_checked' => 1]);

        } else {

            $res = $userSkillTable->updateAll(['is_used' => $is_used], ['user_id' => $this->user->id, 'is_checked' => 1, 'id' => $user_skill_id]);

        }

        if ($res) {
            return $this->Util->ajaxReturn(true);
        } else {
            return $this->Util->ajaxReturn(false, '操作失败');
        }

    }

    
    /**
     * 我的订单
     */
    public function dateorder(){
        $this->set([
            'pageTitle'=>'我的粉丝',
            'user'=>  $this->user,
            ]);
        
    }
    
    /**
     * 我的订单列表
     */
    public function getDateorders($page){
       $DateorderTable = \Cake\ORM\TableRegistry::get('Dateorder');
       $limit = 10;
       $where = [];
       $query = $this->request->query('query');
       if($this->user->gender==1){
         $where = ['consumer_id'=>  $this->user->id];
       }else{
         $where = ['dater_id'=>  $this->user->id];  
       }
       if($query>1){
           switch ($query) {
               case 2:
                   $where[] = ['Dateorder.status in'=>['3','7']];
                   break;
               case 3:
                   $where[] = ['Dateorder.status in'=>['10','13']];
                   break;
               default:
                   break;
           }
       }
        $orders = $DateorderTable->find()
                  ->contain([
                      'Dater'=>function($q){
                        return $q->select(['avatar']);
                      },'UserSkill','UserSkill.Skill'
                  ])
                  ->where($where)
                  ->orderDesc('Dateorder.create_time')
                  ->limit($limit)
                  ->page($page)
                  ->toArray();
       return $this->Util->ajaxReturn(['orders'=>$orders]);
       
    }
    
    
    /***
     * 美女接受订单
     * 1.订单状态更改->7
     * 2.短信通知男方
     */
    public function receiveOrder(){
        $orderid = $this->request->data('orderid');
        $DateorderTable = \Cake\ORM\TableRegistry::get('Dateorder');
        $dateorder = $DateorderTable->get($orderid,[
            'contain'=>[
                'Buyer'=>function($q){
                    return $q->select(['phone','id']);
                }
                ,'Dater'=>function($q){
                    return $q->select(['id','nick']);
                }
                ,'UserSkill.Skill'
            ]
        ]);
        if($dateorder){
            $dateorder->status = 7;
            if($DateorderTable->save($dateorder)){
                $this->loadComponent('Sms');
                $this->Sms->sendByQf106($dateorder->buyer->phone, $dateorder->dater->nick.
                        '已接受你发出的【'.$dateorder->user_skill->skill->name.'】邀请，请您尽快支付尾款.');
                return $this->Util->ajaxReturn(true,'成功接受');
            }
        }
        return $this->Util->ajaxReturn(false,'服务器开小差');
    }
    
    /**
     * 预约订单详情
     */
    public function orderDetail($id){
        $DateorderTable = \Cake\ORM\TableRegistry::get('Dateorder');
        $order = $DateorderTable->get($id,[
            'contain'=>[
                'Buyer'=>function($q){
                    return $q->select(['phone','id','avatar','nick','birthday']);
                }
                ,'Dater'=>function($q){
                    return $q->select(['id','nick','avatar','birthday']);
                }
                ,'UserSkill.Skill','Dater.Tags'
            ]
        ]);
        $this->set([
            'order'=>$order,
            'user'=>  $this->user,
            'pageTitle'=>'订单详情'
        ]);                      
        
    }
    
    /**
     * 支付约单尾款
     * 1.订单状态改变
     * 2.扣除用户余额
     * 3.生成交易流水
     * 4.短信通知
     */
    public function orderPayall(){
        $order_id = $this->request->data('order');
        $DateorderTable = \Cake\ORM\TableRegistry::get('Dateorder');
        $order = $DateorderTable->get($order_id,[
            'contain'=>[
                'Buyer'=>function($q){
                    return $q->select(['phone','id','avatar','nick','birthday','money']);
                }
                ,'Dater'=>function($q){
                    return $q->select(['id','nick','avatar','birthday','phone']);
                }
                ,'UserSkill.Skill','Dater.Tags'
            ]
        ]);
        //订单状态改变->10
        $order->status = 10;        
        //扣除尾款
        $payment = $order->amount - $order->pre_pay;
        //交易流水
        $pre_amount = $this->user->money;
        if($this->user->money < $payment){
            return $this->Util->ajaxReturn(['status'=>false,'code'=>'110','账户美币不足']);
        }
        $this->user->money = $this->user->money - $payment;
        $user = $this->user;
        $after_amount = $this->user->money;
        //生成流水
        $FlowTable = \Cake\ORM\TableRegistry::get('Flow');
        $flow = $FlowTable->newEntity([
           'user_id'=>0,
           'buyer_id'=>  $this->user->id,
           'relate_id'=>$order->id,
           'type'=>2,
           'type_msg'=>'约技能支付尾款',
           'income'=>2,
           'amount'=>$payment,
           'price'=>$payment,
           'pre_amount'=>$pre_amount,
           'after_amount'=>$after_amount,
           'paytype'=>1,   //余额支付
           'remark'=> '约技能支付尾款'
       ]);
        $transRes = $DateorderTable->connection()->transactional(function()use(&$flow,$FlowTable,&$order,$DateorderTable,$user){
               $UserTable = \Cake\ORM\TableRegistry::get('User');
               return $FlowTable->save($flow)&&$DateorderTable->save($order)&&$UserTable->save($user);
           });
        if($transRes){
            $this->loadComponent('Sms');
            $this->Sms->sendByQf106($order->dater->phone, $order->buyer->nick.
                    '已支付您的【'.$order->user_skill->skill->name.'】技能约单尾款，请及时赴约.');
            return $this->Util->ajaxReturn(true,'成功支付尾款');
        }else{
            errorMsg($flow, '失败');
            errorMsg($dateorder, '失败');
            return $this->Util->ajaxReturn(false,'支付尾款失败');
        }
        
    }
    
    
    /**
     * 赴约成功
     * 女方：
     *      1.状态更改
     *      2.通知男方
     * 男方：
     *     1.结束约单 
     *     2.女方收到全款
     *     3.收款资金流水
     */
    public function orderGo(){
        $this->handCheckLogin();
        $order_id = $this->request->data('order');
        $DateorderTable = \Cake\ORM\TableRegistry::get('Dateorder');
        $order = $DateorderTable->get($order_id,[
            'contain'=>[
                'Buyer'=>function($q){
                    return $q->select(['phone','id','avatar','nick','birthday','money']);
                }
                ,'Dater'=>function($q){
                    return $q->select(['id','nick','avatar','birthday','phone','money']);
                }
                ,'UserSkill.Skill'
            ]
        ]);
        if($this->user->gender==2){
            $order->status = 13;
            if($DateorderTable->save($order)){
                $this->loadComponent('Sms');
                $this->Sms->sendByQf106($order->buyer->phone, $order->dater->nick.
                        '已到达约会目的地，请及时到场赴约.');
                return $this->Util->ajaxReturn(true,'成功接受');
            }
        }else{
            $order->status = 14; //订单完成
            //女方收款
            $pre_amount = $order->dater->money;
            $order->dater->money = $order->amount+$pre_amount;
            $order->dirty('dater',true);
            //资金流水
            //生成流水
            $FlowTable = \Cake\ORM\TableRegistry::get('Flow');
            $flow = $FlowTable->newEntity([
               'user_id'=>$order->dater_id,
               'buyer_id'=>  0,
               'relate_id'=>$order->id,
               'type'=>3,
               'type_msg'=>'约技能收款',
               'income'=>1,
               'amount'=>$order->amount,
               'price'=>$order->amount,
               'pre_amount'=>$pre_amount,
               'after_amount'=>$order->dater->money,
               'paytype'=>1,   //余额支付
               'remark'=> '约技收取尾款'
            ]);
           $transRes = $DateorderTable->connection()->transactional(function()use(&$flow,$FlowTable,&$order,$DateorderTable){
               $UserTable = \Cake\ORM\TableRegistry::get('User');
               return $FlowTable->save($flow)&&$DateorderTable->save($order);
           });
            if($transRes){
                return $this->Util->ajaxReturn(true,'订单完成');
            }else{
                errorMsg($flow, '失败');
                errorMsg($order, '失败');
                return $this->Util->ajaxReturn(false,'订单完成失败');
            }
        }
        return $this->Util->ajaxReturn(false,'服务器开小差');
    }
    
    
    /**
     * 我的钱包
     */
    public function myPurse(){
        
    }
}
