<?php
namespace App\Controller\Mobile;

use Cake\ORM\TableRegistry;
use Cake\I18n\Time;


/**
 * DateOrder Controller  约单处理
 *
 * @property \App\Model\Table\DateOrderTable $DateOrder
 * @property \App\Controller\Component\BdmapComponent $Bdmap
 * @property \App\Controller\Component\SmsComponent $Sms
 */
class DateOrderController extends AppController
{
    
    public function initialize() {
        parent::initialize();
        $this->loadComponent('Sms');
    }

    /**
     * 约会支付详情页--赴约流程
     * @param int $id
     */
    public function join($id = null)
    {

        $dateTable = TableRegistry::get("Date");
        $date = $dateTable->get($id, ['contain' => ['UserSkill' =>function($q){
            return $q->contain(['Skill', 'Cost']);}, 'Tags', 'User' => function ($q) {
            return $q->select(['nick', 'birthday', 'gender', 'money', 'avatar']);
        }]]);
        $this->set(['date' => $date, 'user' => $this->user, 'pageTitle' => '美约-约会详情']);


    }


    /**
     * 约技能
     * 1.生成约单
     * 2.扣除男方预约金
     * 3.生成男方扣除资金流水
     * @param type $skill_id
     */
    public function orderSkill($skill_id){
        $this->handCheckLogin();
       $UserSkillTable = TableRegistry::get('UserSkill');
       $data = $UserSkillTable->get($skill_id,[
           'contain'=>[
               'User'=>function($q){
                    return $q->select(['id','avatar','birthday','nick','truename','phone']);
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
               'status'=>'3',
               'user_skill_id'=>$data['user_skill_id'],
               'site'=>$data['place_name'],
               'site_lat'=>$data['coord_lat'],
               'site_lng'=>$data['coord_lng'],
               'price'=>$price,
               'amount'=>$amount,
               'pre_pay'=>$pre_pay,
               'pre_precent'=>$pre_precent,
               'prepay_time'=> date('Y-m-d H:i:s'),
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
               'type_msg'=>'约技能支付预约金',
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
               $this->Sms->sendByQf106($date->user->phone,'用户'.$user->nick.'已支付了您的'.$date->skill->name.'技能预约费,请尽快前往平台确认');
               return $this->Util->ajaxReturn(['status'=>true,'redirect_url'=>'/date-order/order-success/'.$dateorder->id]);
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
     * 赴约会
     * 1.生成约单
     * 2.扣除男方预约金
     * 3.生成男方扣除资金流水
     * @param type $skill_id
     */
    public function orderDate($date_id){
        $this->handCheckLogin();
        if($this->request->is('post')){
            $DateTb = TableRegistry::get('Date');
            $date = $DateTb->get($date_id,[
                'contain'=>[
                    'User'=>function($q){
                        return $q
                            ->select([
                                'id',
                                'avatar',
                                'birthday',
                                'nick',
                                'truename',
                                'phone'
                            ]);
                    },
                ]
            ]);
            $lasth = ($date->end_time->hour-$date->start_time->hour);
            $price = $date->price;
            $amount = $price*$lasth;
            if($this->user->money<$amount){
                return $this->Util->ajaxReturn(false,'余额不足');
            }
            //生成约单
            $DateorderTable = TableRegistry::get('Dateorder');
            $dateorder = $DateorderTable->newEntity([
                'consumer_id'=>  $this->user->id,
                'dater_id'=>$date->user->id,
                'dater_name'=>  $date->user->nick,
                'date_time'=>  $lasth,
                'consumer'=>  $this->user->nick,
                'status'=>10,
                'date_id' => $date->id,
                'user_skill_id'=>$date->user_skill_id,
                'site'=>$date->site,
                'site_lat'=>$date->site_lat,
                'site_lng'=>$date->site_lng,
                'price'=>$price,
                'amount'=>$amount,
                'pre_pay'=>0,
                'pre_precent'=>0,
                'prepay_time'=> new Time(),
                'start_time'=>$date->start_time,
                'end_time'=>$date->end_time,
            ]);
            //扣除 预约金
            $pre_amount = $this->user->money;
            $this->user->money = $this->user->money - $amount;
            $user = $this->user;
            $after_amount = $this->user->money;
            //生成流水
            $FlowTable = TableRegistry::get('Flow');
            $flow = $FlowTable->newEntity([
                'user_id'=>0,
                'buyer_id'=>$this->user->id,
                'type'=>17,
                'type_msg'=>'赴约支付约会金',
                'income'=>2,
                'amount'=>$amount,
                'price'=>$price,
                'pre_amount'=>$pre_amount,
                'after_amount'=>$after_amount,
                'paytype'=>1,   //余额支付
                'remark'=> '赴约支出'
            ]);

            $transRes = $DateorderTable
                ->connection()
                ->transactional(
                    function() use (&$flow,$FlowTable,&$dateorder,$DateorderTable,$user, $DateTb, $date){
                        $date->status = 1;
                        $UserTable = TableRegistry::get('User');
                        $saveDateorder = $DateorderTable->save($dateorder);
                        $saveDate = $DateTb->save($date);
                        $flow->relate_id = $dateorder->id;
                        return $FlowTable->save($flow)&&$saveDateorder&&$saveDate&&$UserTable->save($user);
                });
            if($transRes){
                $this->Sms->sendByQf106($date->user->phone,
                    '用户【'
                    .$user->nick
                    .'】已支付了您的约会【'
                    .$date->title
                    .'】,祝约会愉快'
                );
                return $this->Util->ajaxReturn([
                    'status'=>true,
                    'redirect_url'=>'/date-order/order-success/'.$dateorder->id
                ]);
            }else{
                errorMsg($flow, '失败');
                errorMsg($dateorder, '失败');
                return $this->Util->ajaxReturn(false,'赴约失败');
            }
        }
        return $this->Util->ajaxReturn(false,'非法操作');
    }

    
    /**
     * 预约技能成功
     * @param type $dataorder_id
     */
    public function orderSuccess($dataorder_id){
        $this->set([
            'order_id'=>$dataorder_id,
            'pageTitle'=>'预约成功'
        ]);
    }


    /**
     * 选择地点
     */
    public function findPlace($page){
        $this->loadComponent('Bdmap');
        $places = $this->Bdmap->placeSearchNearBy('咖啡', $this->coord,$page);
        return $this->Util->ajaxReturn(['places'=>$places]);
    }
    
    /**
     * 取消约单 不同的节点不同的处理 处于状态3时
     * 男方支付完预付金
     * 女方拒绝接单和男方取消订单 都退回预约金给男方
     */
    public function cancelDateOrder3(){
        $this->handCheckLogin();
        $order_id = $this->request->data('order_id');
        $DateorderTable = \Cake\ORM\TableRegistry::get('Dateorder');
        $dateorder = $DateorderTable->get($order_id,[
            'contain'=>[
                'Buyer'=>function($q){
                    return $q->select(['phone','id','money']);
                }
                ,'Dater'=>function($q){
                    return $q->select(['id','nick','money']);
                }
                ,'UserSkill.Skill'
            ]
        ]);
         //订单状态更改
         if($dateorder->status!=3){
             throw new Exception('请求非法');
         }       
        if($this->user->gender==1){
                //男士已支付预约金 女士确认接单之前
                //退还男士预约金
                //订单状态更改
                $dateorder->status = 4;
                $type = 5;
                $remark = '男士取消订单退回预约金';
        }else{
            //男士
            $dateorder->status = 5;
            $type = 6;
            $remark = '女士取消订单退回预约金';
        }        
        
        //返还预约金
        $pre_pay = $dateorder->pre_pay;
        $pre_amount = $dateorder->buyer->money;
        $dateorder->buyer->money = $dateorder->buyer->money+$dateorder->pre_pay;
        $after_amount = $dateorder->buyer->money;
        $dateorder->dirty('buyer',true);
         //生成流水
        $FlowTable = TableRegistry::get('Flow');
        $flow = $FlowTable->newEntity([
           'user_id'=> $dateorder->buyer->id,
           'buyer_id'=>  0,
           'relate_id'=>$dateorder->id,
           'type'=>$type,
           'type_msg'=>'取消约单退回预约金',
           'income'=>1,
           'amount'=>$pre_pay,
           'price'=>$pre_pay,
           'pre_amount'=>$pre_amount,
           'after_amount'=>$after_amount,
           'paytype'=>2, 
           'remark'=> $remark
        ]);
         $transRes = $DateorderTable->connection()
                 ->transactional(function()use(&$flow,$FlowTable,&$dateorder,$DateorderTable){
               return $FlowTable->save($flow)&&$DateorderTable->save($dateorder);      
        });
       if($transRes){
            return $this->Util->ajaxReturn(true,'取消成功');
           }else{
            return $this->Util->ajaxReturn(false,'取消失败');
        }
        
    }
    
    /**
     * 取消约单 不同的节点不同的处理 处于状态7时
     * 女方有2个操作 拒绝和接受  拒绝->退回预约金给男方  扣除女方10%约单金额
     * 男方只有1个操作   支付
     * 1.订单状态更改 ->8
     * 2.退回男方预付金
     * 3.扣除女方10%违约金
     * 4.男方退回资金流水
     * 5.女方扣除资金流水
     */
    public function cancelDateOrder7(){
        $this->handCheckLogin();
        $order_id = $this->request->data('order_id');
        $DateorderTable = \Cake\ORM\TableRegistry::get('Dateorder');
        $dateorder = $DateorderTable->get($order_id,[
            'contain'=>[
                'Buyer'=>function($q){
                    return $q->select(['phone','id','money']);
                }
                ,'Dater'=>function($q){
                    return $q->select(['id','nick','money']);
                }
                ,'UserSkill.Skill'
            ]
        ]);
         //订单状态更改
         if($dateorder->status!=7){
             throw new Exception('请求非法');
         }       
        if($this->user->gender==2){
                //男士已支付预约金 女士确认接单之前
                //退还男士预约金
                $dateorder->status = 4;
                $type = 7;
        }else{
            throw new Exception('身份认证不通过');
        }
        //订单状态更改
        $dateorder->status = 8;
        //返还预约金
        $pre_pay = $dateorder->pre_pay;
        $m_pre_money = $dateorder->buyer->money;
        $dateorder->buyer->money = $dateorder->buyer->money+$dateorder->pre_pay;
        $m_after_amount = $dateorder->buyer->money;
        
        $dateorder->dirty('buyer',true);
         //生成流水
        $FlowTable = TableRegistry::get('Flow');
        $m_flow = $FlowTable->newEntity([
           'user_id'=> $dateorder->buyer->id,
           'buyer_id'=>  0,
           'relate_id'=>$dateorder->id,
           'type'=>$type,
           'type_msg'=>'取消约单退回预约金',
           'income'=>1,
           'amount'=>$pre_pay,
           'price'=>$pre_pay,
           'pre_amount'=>$m_pre_money,
           'after_amount'=>$m_after_amount,
           'paytype'=>2, 
           'remark'=> '女士在接受订单后取消订单退回预约金'
        ]);
        //扣除违约金
        $breach_amount = 0.1*$dateorder->amount;
        $w_pre_amount = $dateorder->dater->money;
        $dateorder->dater->money = $dateorder->dater->money-$breach_amount;
        $w_after_amount = $dateorder->dater->money;
        $dateorder->dirty('dater',true);
        //女方的资金流水
        $w_flow = $FlowTable->newEntity([
           'user_id'=> 0,
           'buyer_id'=>  $dateorder->dater->id,
           'relate_id'=>$dateorder->id,
           'type'=>$type,
           'type_msg'=>'取消约单违约金',
           'income'=>2,
           'amount'=>$breach_amount,
           'price'=>$breach_amount,
           'pre_amount'=>$w_pre_amount,
           'after_amount'=>$w_after_amount,
           'paytype'=>1, 
           'remark'=> '女士在接受订单后取消订单扣除10%的约单金额作为惩罚'
        ]);
        $transRes = $DateorderTable->connection()
                 ->transactional(function()use(&$w_flow,$FlowTable,&$m_flow,&$dateorder,$DateorderTable){
               return $FlowTable->save($m_flow)&&$DateorderTable->save($dateorder)&&$FlowTable->save($w_flow);      
        });
       if($transRes){
            return $this->Util->ajaxReturn(true,'取消成功');
           }else{
            return $this->Util->ajaxReturn(false,'取消失败');
        }
        
    }
    
    
      /**
     * 取消约单 不同的节点不同的处理 处于状态10时
     * 在约会之前双方才可取消
     * 开始前2个小时 前与后 规则不同
     * 男士退单 ： 
     */
    public function cancelDateOrder10(){
        $this->handCheckLogin();
        $order_id = $this->request->data('order_id');
        $DateorderTable = \Cake\ORM\TableRegistry::get('Dateorder');
        $dateorder = $DateorderTable->get($order_id,[
            'contain'=>[
                'Buyer'=>function($q){
                    return $q->select(['phone','id','money']);
                }
                ,'Dater'=>function($q){
                    return $q->select(['id','nick','money']);
                }
                ,'UserSkill.Skill'
            ]
        ]);
         if(strtotime($dateorder->start_time)<time()){
             //已到约会时间
             return $this->Util->ajaxReturn(false,'已到约会时间不可取消约单');
             
         }       
         //订单状态更改
         if($dateorder->status!=10){
             throw new Exception('请求非法');
         }       
        $FlowTable = TableRegistry::get('Flow');
        if($this->user->gender==2){
                //男士已支付预约金 女士确认接单之前
                //退还男士预约金
                $dateorder->status = 12;
                $type = 8;
                $remark = '女士在接受订单后取消订单退回预约金';
                
                //返还全额 约单价格
                $m_pre_money = $dateorder->buyer->money;
                $m_amount = $dateorder->amount;
                $dateorder->buyer->money = $dateorder->buyer->money+$dateorder->amount;
                $m_after_amount = $dateorder->buyer->money;
                $m_income = 1;
                //扣除违约金
                $breach_amount = 0.2*$dateorder->amount;
                $w_pre_amount = $dateorder->dater->money;
                $w_amount = $breach_amount;
                $dateorder->dater->money = $dateorder->dater->money-$breach_amount;
                $w_after_amount = $dateorder->dater->money;
                $w_income = 2;
                
                   //生成流水
                $m_flow = $FlowTable->newEntity([
                   'user_id'=> $dateorder->buyer->id,
                   'buyer_id'=>  0,
                   'relate_id'=>$dateorder->id,
                   'type'=> $type,
                   'type_msg'=>'取消违约金退款',
                   'income'=>$m_income,
                   'amount'=>$m_amount,
                   'price'=>$m_amount,
                   'pre_amount'=>$m_pre_money,
                   'after_amount'=>$m_after_amount,
                   'paytype'=>2, 
                   'remark'=> $remark
                ]);

                //女方的资金流水
                $w_flow = $FlowTable->newEntity([
                   'user_id'=> 0,
                   'buyer_id'=>  $dateorder->dater->id,
                   'relate_id'=>$dateorder->id,
                   'type'=>$type,
                   'type_msg'=>'取消违约金退款',
                   'income'=>$w_income,
                   'amount'=>$w_amount,
                   'price'=>$w_amount,
                   'pre_amount'=>$w_pre_amount,
                   'after_amount'=>$w_after_amount,
                   'paytype'=>1, 
                   'remark'=> $remark
                ]);
        }else{
            $dateorder->status = 11;
            $type = 9;
            $type_msg = '取消约单退回约单金额';
            if((strtotime($dateorder->start_time)-time())>= 2*60*60){
                //2小时外
                $m_remark = '男士在接受订单后约会时间2小时之外取消订单退回70%约单金';
                $w_remark = '男士在接受订单后约会时间2小时之外取消订单退回30%约单金';
                 //返还男士70%约单价格
                $m_pre_money = $dateorder->buyer->money;
                $m_amount = 0.7*$dateorder->amount;
                $dateorder->buyer->money = $dateorder->buyer->money+$m_amount;
                $m_after_amount = $dateorder->buyer->money;
                $m_income = 1;
                //返还女士30%的约单价格
                $w_amount = 0.3*$dateorder->amount;
                $w_pre_amount = $dateorder->dater->money;
                $dateorder->dater->money = $dateorder->dater->money-$w_amount;
                $w_after_amount = $dateorder->dater->money;
                $w_income = 1;
               
            }else{
                $m_remark = '男士在接受订单后约会时间2小时之内取消订单退回30%约单金';
                $w_remark = '男士在接受订单后约会时间2小时之内取消订单退回70%约单金';
                 //返还男士30%约单价格
                $m_pre_money = $dateorder->buyer->money;
                $m_amount = 0.7*$dateorder->amount;
                $dateorder->buyer->money = $dateorder->buyer->money+$m_amount;
                $m_after_amount = $dateorder->buyer->money;
                $m_income = 1;
                //返还女士70%的约单价格
                $w_amount = 0.3*$dateorder->amount;
                $w_pre_amount = $dateorder->dater->money;
                $dateorder->dater->money = $dateorder->dater->money-$w_amount;
                $w_after_amount = $dateorder->dater->money;
                $w_income = 1;
            }
              //生成流水
                $m_flow = $FlowTable->newEntity([
                   'user_id'=> $dateorder->buyer->id,
                   'buyer_id'=>  0,
                   'relate_id'=>$dateorder->id,
                   'type'=>$type,
                   'type_msg'=>$type_msg,
                   'income'=>$m_income,
                   'amount'=>$m_amount,
                   'price'=>$m_amount,
                   'pre_amount'=>$m_pre_money,
                   'after_amount'=>$m_after_amount,
                   'paytype'=>1, 
                   'remark'=> $m_remark
                ]);

                //女方的资金流水
                $w_flow = $FlowTable->newEntity([
                   'user_id'=> $dateorder->dater->id,
                   'buyer_id'=>  0,
                   'relate_id'=>$dateorder->id,
                   'type'=>$type,
                   'type_msg'=>$type_msg,
                   'income'=>$w_income,
                   'amount'=>$w_amount,
                   'price'=>$w_amount,
                   'pre_amount'=>$w_pre_amount,
                   'after_amount'=>$w_after_amount,
                   'paytype'=>1, 
                   'remark'=> $w_remark
                ]);
        }
        
        $dateorder->dirty('buyer',true);
        $dateorder->dirty('dater',true);
        $transRes = $DateorderTable->connection()
                 ->transactional(function()use(&$w_flow,$FlowTable,&$m_flow,&$dateorder,$DateorderTable){
               return $FlowTable->save($m_flow)&&$DateorderTable->save($dateorder)&&$FlowTable->save($w_flow);      
        });
       if($transRes){
            return $this->Util->ajaxReturn(true,'取消成功');
           }else{
            return $this->Util->ajaxReturn(false,'取消失败');
        }
        
    }
    
    
}
