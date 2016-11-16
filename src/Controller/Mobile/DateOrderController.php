<?php
namespace App\Controller\Mobile;

use Cake\ORM\TableRegistry;
use Cake\I18n\Time;


/**
 * DateOrder Controller
 *
 * @property \App\Model\Table\DateOrderTable $DateOrder
 * @property \App\Controller\Component\BdmapComponent $Bdmap
 */
class DateOrderController extends AppController
{

    /**
     * 约会支付详情页--赴约流程
     * @param int $id
     */
    public function join($id = null)
    {

        $dateTable = TableRegistry::get("Date");
        $date = $dateTable->get($id, ['contain' => ['UserSkill' =>function($q){
            return $q->contain(['Skill', 'Cost']);}, 'Tags', 'User' => function ($q) {
            return $q->select(['nick', 'birthday', 'gender', 'money']);
        }]]);
        $this->set(['date' => $date, 'user' => $this->user, 'pageTitle' => '美约-约会详情']);


    }


    /**
     * 约会支付接口--赴约流程
     *
     */
    public function joinPay()
    {

    }
    
    /**
     * 约技能
     * 1.生成约单
     * 2.扣除男方预约金
     * 3.生成男方扣除资金流水
     * @param type $skill_id
     */
    public function orderSkill($skill_id){
       $UserSkillTable = TableRegistry::get('UserSkill');
       $data = $UserSkillTable->get($skill_id,[
           'contain'=>[
               'User'=>function($q){
                    return $q->select(['id','avatar','birthday','nick','truename']);
               },
               'Skill'=>function($q){
                    return $q->select(['skill_id'=>'Skill.id','name']);
               },        
               'Tags','Cost'      
           ]    
       ]);
       if($this->request->is('post')){
           $this->handCheckLogin();
           $date = $data;
           $data = $this->request->data();
           $lasth = ((new Time($data['end_time']))->hour-(new Time($data['start_time']))->hour);
           if($lasth<3){
               return $this->Util->ajaxReturn(false,'约会时长至少要3个小时');
           }
           $price = $date->cost->money;
           $amount = $price*$lasth;
           $pre_precent = 0.2;
           $pre_pay = $amount*$pre_precent;
           if($this->user->money<$pre_pay){
               return $this->Util->ajaxReturn(false,'余额不足支付预约金');
           }
           $DateorderTable = TableRegistry::get('Dateorder');
           //生成约单
           $dateorder = $DateorderTable->newEntity([
               'consumer_id'=>  $this->user->id,
               'dater_id'=>$date->user->id,
               'dater_name'=>  $date->user->truename,
               'date_time'=>  $lasth,
               'consumer'=>  $this->user->truename,
               'user_skill_id'=>$data['user_skill_id'],
               'site'=>$data['place_name'],
               'site_lat'=>$data['coord_lat'],
               'site_lng'=>$data['coord_lng'],
               'price'=>$price,
               'amount'=>$amount,
               'pre_pay'=>$pre_pay,
               'pre_precent'=>$pre_precent,
               'start_time'=>$data['start_time'],
               'end_time'=>$data['end_time'],
           ]);
           //扣除 预约金
           $pre_amount = $this->user->money;
           $this->user->money = $this->user->money - $pre_pay;
           $user = $this->user;
           $after_amount = $this->user->money;
           //生成流水
           $FlowTable = TableRegistry::get('Flow');
           $flow = $FlowTable->newEntity([
               'user_id'=>0,
               'buyer_id'=>  $this->user->id,
               'type'=>1,
               'type_msg'=>'约技能支出',
               'income'=>2,
               'amount'=>$pre_pay,
               'price'=>$pre_pay,
               'pre_amount'=>$pre_amount,
               'after_amount'=>$after_amount,
               'paytype'=>1,   //余额支付
               'remark'=> '约技能支出'
           ]);
           
           $transRes = $DateorderTable->connection()->transactional(function()use(&$flow,$FlowTable,&$dateorder,$DateorderTable,$user){
               $UserTable = TableRegistry::get('User');
               $saveDate = $DateorderTable->save($dateorder);
               $flow->relate_id = $dateorder->id;
               return $FlowTable->save($flow)&&$saveDate&&$UserTable->save($user);
           });
           if($transRes){
               return $this->Util->ajaxReturn(true,'预约成功');
           }else{
               errorMsg($flow, '失败');
               errorMsg($dateorder, '失败');
               return $this->Util->ajaxReturn(false,'预约失败');
           }
        }
       $this->set([
           'pageTitle'=> '约他',
           'data'=>$data,
           'user'=>  $this->user
       ]);    
    }
    
    /**
     * 预约技能成功
     * @param type $dataorder_id
     */
    public function orderSuccess($dataorder_id){
        
    }


    /**
     * 选择地点
     */
    public function findPlace($page){
        $this->loadComponent('Bdmap');
        $places = $this->Bdmap->placeSearchNearBy('咖啡', $this->coord,$page);
        return $this->Util->ajaxReturn(['places'=>$places]);
    }
}
