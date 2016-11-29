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
 * @property \App\Controller\Component\NetimComponent $Netim
 */
class TestController extends AppController {


    public function test() {
        //var_dump(round1214 / 1000);
        //var_dump(round('42.99687156342637',1));
        debug($this->Util->getServerDomain());
        exit();
    }
    
    
    /**
     * 订单的自动检测
     */
    public function checkOrder(){
        $Daterorder = \Cake\ORM\TableRegistry::get('Dateorder');
        $orders = $Daterorder->find()
                            ->contain([
                                'Buyer' => function($q) {
                                    return $q->select(['phone', 'id', 'money']);
                                }, 
                                'Dater' => function($q) {
                                    return $q->select(['id', 'nick', 'money']);
                                }, 
                                'UserSkill.Skill'
                            ])
                            ->where(['Dateorder.status in'=>['3','7','10']])
                            ->toArray();
        foreach ($orders as $key => $order) {
            switch ($order->status) {
                case 3:
                    //男方支付完预约金
                    $this->handStatus3($order);
                    break;
                case 7:
                    $this->handStatus7($order);
                    break;
                case 10:
                    $this->handStatus10($order);
                    break;
                default:
                    break;
            }
        }
        exit();
    }
    
    /**
     * 处理状态3  预约金退回给用户账户中
     */
    protected function handStatus3(\App\Model\Entity\Dateorder $order){
        $DateorderTable = \Cake\ORM\TableRegistry::get('Dateorder');
        $FlowTable = \Cake\ORM\TableRegistry::get('Flow');
        if ((time()-strtotime($order->prepay_time)) >= 30 * 60 && 
                (time()-strtotime($order->prepay_time)) < 60 * 60) {
                    //超过30分钟  人工干预
        }
        
        if ((time()-strtotime($order->start_time)) >= 60 * 60) {
            //超过60分钟  自动退单 
            //1.订单状态改变
            //2.退回预约金
            $order->status = 6;
            $m_pre_money = $order->buyer->money;
            $m_amount = $order->pre_pay;
            $order->buyer->money = $order->buyer->money+$order->pre_pay;
            $m_after_amount = $order->buyer->money;
            $m_income = 1;
            
            //生成流水
            $m_flow = $FlowTable->newEntity([
               'user_id'=> $order->buyer->id,
               'buyer_id'=>  0,
               'relate_id'=>$order->id,
               'type'=>10,
               'type_msg'=>'自动退单退款',
               'income'=>$m_income,
               'amount'=>$m_amount,
               'price'=>$m_amount,
               'pre_amount'=>$m_pre_money,
               'after_amount'=>$m_after_amount,
               'paytype'=>2, 
               'remark'=> '支付完预约金后60分钟无响应,自动退单'
            ]);
            
            $order->dirty('buyer',true);
            $transRes = $DateorderTable->connection()
                    ->transactional(function()use($FlowTable,&$m_flow,&$order,$DateorderTable){
                return $FlowTable->save($m_flow)&&$DateorderTable->save($order);      
            });
            if($transRes){
                dblog('dateorder','1条约单被执行状态3操作','dateorder_id:'.$order->id);
            }else{
                dblog('dateorder','1条订单执行状态3操作失败','dateorder_id:'.$order->id);
            }
        }
    }
    /**
     * 处理状态7  预约金打到美女账户中
     */
    protected function handStatus7(\App\Model\Entity\Dateorder $order){
        $DateorderTable = \Cake\ORM\TableRegistry::get('Dateorder');
        $FlowTable = \Cake\ORM\TableRegistry::get('Flow');
        
        if ((time()-strtotime($order->receive_time)) >= 6*60 * 60) {
            //超过6小时 未支付尾款  预约金自动打到美女账户中 
            //1.订单状态改变
            //2.女方获得预约金
            $order->status = 9;   //消费者超时未付尾款 
            $w_pre_money = $order->dater->money;
            $w_amount = $order->pre_pay;
            $order->dater->money = $order->dater->money+$w_amount;
            $w_after_amount = $order->dater->money;
            $w_income = 1;
            
            //生成流水
            $w_flow = $FlowTable->newEntity([
               'user_id'=> $order->dater->id,
               'buyer_id'=>  0,
               'relate_id'=>$order->id,
               'type'=>11,
               'type_msg'=>'违约预约金',
               'income'=>$w_income,
               'amount'=>$w_amount,
               'price'=>$w_amount,
               'pre_amount'=>$w_pre_money,
               'after_amount'=>$w_after_amount,
               'paytype'=>2, 
               'remark'=> '接受约单后6小时未支付尾款'
            ]);
            
            $order->dirty('dater',true);
            $transRes = $DateorderTable->connection()
                    ->transactional(function()use($FlowTable,&$w_flow,&$order,$DateorderTable){
                return $FlowTable->save($w_flow)&&$DateorderTable->save($order);      
            });
            if($transRes){
                dblog('dateorder','1条约单被执行状态7操作','dateorder_id:'.$order->id);
            }else{
                dblog('dateorder','1条订单执行状态7操作失败','dateorder_id:'.$order->id);
            }
        }
    }
    /**
     * 处理状态10  约单总金给美女  订单完成
     */
    protected function handStatus10(\App\Model\Entity\Dateorder $order){
        $DateorderTable = \Cake\ORM\TableRegistry::get('Dateorder');
        $FlowTable = \Cake\ORM\TableRegistry::get('Flow');
        
        if ((time()-strtotime($order->end_time)) >= 24*60 * 60) {
            //超过24小时 双方无操作 约单金额自动打到美女账户中 
            //1.订单状态改变
            //2.女方获得约单金
            $order->status = 14;   //订单完成 
            $w_pre_money = $order->dater->money;
            $w_amount = $order->amount;
            $order->dater->money = $order->dater->money+$w_amount;
            $w_after_amount = $order->dater->money;
            $w_income = 1;
            
            //生成流水
            $w_flow = $FlowTable->newEntity([
               'user_id'=> $order->dater->id,
               'buyer_id'=>  0,
               'relate_id'=>$order->id,
               'type'=>12,
               'type_msg'=>'约技能收款',
               'income'=>$w_income,
               'amount'=>$w_amount,
               'price'=>$w_amount,
               'pre_amount'=>$w_pre_money,
               'after_amount'=>$w_after_amount,
               'paytype'=>2, 
               'remark'=> '24小时无操作订单自动完成'
            ]);
            
            $order->dirty('dater',true);
            $transRes = $DateorderTable->connection()
                    ->transactional(function()use($FlowTable,&$w_flow,&$order,$DateorderTable){
                return $FlowTable->save($w_flow)&&$DateorderTable->save($order);      
            });
            if($transRes){
                dblog('dateorder','1条约单被执行状态10操作','dateorder_id:'.$order->id);
            }else{
                dblog('dateorder','1条订单执行状态10操作失败','dateorder_id:'.$order->id);
            }
        }
    }
    
    public function getImId($id){
        $this->loadComponent('Netim');
        $this->Netim->registerIm($id);
    }
}
