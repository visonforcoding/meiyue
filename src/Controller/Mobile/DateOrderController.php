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
 * @property \App\Controller\Component\NetimComponent $Netim
 * @property \App\Controller\Component\BusinessComponent $Business
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
        $share_desc = \Cake\Cache\Cache::read('DATE_SHARE_DESC');
        if(!$share_desc) {
            $setTb = TableRegistry::get('Setting');
            $setting = $setTb->find()->where(['type' => \Sysetting::DATE_SHARE_DESC])->first();
            if($setting) {
                $share_desc = $setting;
                \Cake\Cache\Cache::write('DATE_SHARE_DESC', $setting);
            }
        }
        $dateTable = TableRegistry::get("Date");
        $date = $dateTable->get($id, ['contain' => ['UserSkill' =>function($q){
            return $q->contain(['Skill', 'Cost']);}, 'Tags', 'User' => function ($q) {
            return $q->select(['nick', 'birthday', 'gender', 'money', 'avatar']);
        }]]);
        $this->set(['share' => $share_desc, 'date' => $date, 'user' => $this->user, 'pageTitle' => '约会详情']);
    }

    
    
    /**
     * 约技能生成订单
     * 
     */
    public function orderSkillCreateOrder(){
       $this->handCheckLogin();
       $UserSkillTable = TableRegistry::get('UserSkill');
       $request = $this->request->data();
       $date = $UserSkillTable->get($request['user_skill_id'],[
           'contain'=>[
               'User'=>function($q){
                    return $q->select(['id','avatar','birthday','nick','truename','phone']);
               },
//               'Skill'=>function($q){
//                    return $q->select(['skill_id'=>'Skill.id','name','q_key','poi_cls']);
//               },        
               'Cost'      
           ]    
       ]);
       $lasth = getLast((new Time($request['start_time'])), (new Time($request['end_time'])));
       $price = $date->cost->money;
       $amount = $price*$lasth;
       $pre_precent = 0.2;    //预约金比例
       $pre_pay = $amount*$pre_precent;
       $DateorderTable = TableRegistry::get('Dateorder');
       //生成约单
       $dateorder = $DateorderTable->newEntity([
           'consumer_id'=>  $this->user->id,
           'dater_id'=>$date->user->id,
           'dater_name'=>  $date->user->nick,
           'date_time'=>  $lasth,
           'consumer'=>  $this->user->nick,
           'status'=>'1',
           'user_skill_id'=>$request['user_skill_id'],
           'site'=>$request['place_name'],
           'site_lat'=>$request['coord_lat'],
           'site_lng'=>$request['coord_lng'],
           'price'=>$price,
           'amount'=>$amount,
           'pre_pay'=>$pre_pay,
           'pre_precent'=>$pre_precent,
           'start_time'=>$request['start_time'],
           'end_time'=>$request['end_time'],
       ]);
       $res = $DateorderTable->save($dateorder);
       if($res){
           if($this->user->money < $pre_pay){
               return $this->Util->ajaxReturn([
                   'status'=>false,
                   'msg'=>'钱包余额不足,立即充值',
                   'code'=>201,
                   'redirect_url'=>'/wx/pay/0/'.$pre_pay.'?redurl=/date-order/order-detail/'.$res->id
//                   'redirect_url'=>'/wx/pay/0/'.$pre_pay
                   ]);
           }
           //成功生成订单
           return $this->Util->ajaxReturn(['status'=>true,'msg'=>'预约成功','order_id'=>$res->id]);
       }else{
           //
           errorMsg($dateorder,'服务器开小差');
           return $this->Util->ajaxReturn(false,'服务器开小差');
       }
    }
    
    public function test(){
        return $this->Util->ajaxReturn(false,'test');
    }

    /**
     * 约她
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
                    return $q->select(['skill_id'=>'Skill.id','name','q_key','poi_cls']);
               },        
               'Tags','Cost'      
           ]    
       ]);
  
       $this->set([
           'pageTitle'=> '约会详情',
           'data'=>$data,
           'user'=>  $this->user
       ]);    
    }
    
    
    /**
     * 约技能  支付预约金
     * 2.扣除男方预约金
     * 3.生成男方扣除资金流水
     * @param type $skill_id
     */
    public function orderPay($order_id){
         if($this->request->is('post')){
           $this->handCheckLogin();
           $DateorderTable = TableRegistry::get('Dateorder');
           $dateorder = $DateorderTable->get($order_id,[
               'contain'=>[
                   'Dater'=>function($q){
                        return $q->select(['id','phone','nick','imaccid','avatar']);
                   },
                   'Buyer'=>function($q){
                        return $q->select(['id','phone','nick','imaccid','avatar']);
                   },
                   'UserSkill.Skill'        
               ]
           ]);
           $pre_pay = $dateorder->pre_pay;
           if($this->user->money < $dateorder->pre_pay){
               return $this->Util->ajaxReturn([
                   'status'=>false, 'msg'=>'钱包余额不足,立即充值',
                   'code'=>'201','redirect_url'=>'/wx/pay/0/'.$dateorder->pre_pay.'?redurl=/date-order/order-detail/'.$dateorder->id,
//                   'code'=>'201','redirect_url'=>'/wx/pay/0/'.$dateorder->pre_pay
                   ]);
           }
           $dateorder->status = 3;
           $dateorder->prepay_time = date('Y-m-d H:i:s');

           //生成约单
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
           
           $transRes = $DateorderTable->connection()->transactional(function()use(
                   &$flow,$FlowTable,&$dateorder,$DateorderTable,$user){
               $UserTable = TableRegistry::get('User');
               $saveDate = $DateorderTable->save($dateorder);
               $flow->relate_id = $dateorder->id;
               return $FlowTable->save($flow)&&$saveDate&&$UserTable->save($user);
           });
           if($transRes){
               $this->Sms->send($dateorder->dater->phone,
                       '用户'.  $this->user->nick.'已支付了您的'.
                       $dateorder->user_skill->skill->name.'技能预约费,请尽快前往平台确认');
               
               //发送im 消息
               $this->loadComponent('Netim');
               $this->Netim->prepayMsg($dateorder);
               $dateorder->dater->avatar = $this->Util->getServerDomain().$dateorder->dater->avatar;
               return $this->Util->ajaxReturn([
                   'status'=>true,
                   'redirect_url'=>'/date-order/order-success/'.$dateorder->id,
                   'code'=>202,    //唤起聊天 
                   'obj'=>$dateorder->dater,
                   'msg'=>'支付成功',    
                       ]);
           }else{
               errorMsg($flow, '失败');
               errorMsg($dateorder, '失败');
               return $this->Util->ajaxReturn(false,'预约失败');
           }
        }
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
                            ->select(['id','avatar','birthday','nick','truename','phone']);
                    },
                ]
            ]);
            $lasth = getLast($date->start_time, $date->end_time);
            $price = $date->price;
            $amount = $price*$lasth;
            if($this->user->money<$amount){
                return $this->Util->ajaxReturn(['status' => false, 'msg' => '钱包余额不足,立即充值', 'errorStatus' => 1]);
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
                $this->Sms->send($date->user->phone,
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
     * @param type $id   技能id  lm_skill表
     * @param type $page 页码
     * @return type
     */
    public function findPlace($id,$page){
        $tag = $this->request->query('tag');
        $SkillTable = TableRegistry::get('Skill');
        $skill = $SkillTable->get($id);
        $query = $skill->q_key;
        $this->loadComponent('Bdmap');
        $places = $this->Bdmap->placeSearchNearBy($query, $this->coord,$page,$tag);
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
                    return $q->select(['gender', 'phone','id','money']);
                }
                ,'Dater'=>function($q){
                    return $q->select(['gender', 'id', 'nick', 'money']);
                }
                ,'UserSkill.Skill'
            ]
        ]);
         //订单状态更改
         if($dateorder->status!=3){
             return $this->Util->ajaxReturn(false,'订单已被更改，您无法进行此操作');
         }
         $dateorder->close_time = date('Y-m-d H:i:s');
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
           if($this->user->gender==1){
               return $this->Util->ajaxReturn(true,'取消成功');
           } else {
               return $this->Util->ajaxReturn(true,'拒绝成功');
           }
       }else{
           if($this->user->gender==1){
               return $this->Util->ajaxReturn(false,'取消失败');
           } else {
               return $this->Util->ajaxReturn(false,'拒绝失败');
           }
       }
        
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
                    return $q->select(['phone','id','nick','imaccid','avatar']);
                }
                ,'Dater'=>function($q){
                    return $q->select(['id','nick','nick','imaccid','avatar']);
                }
                ,'UserSkill.Skill'
            ]
        ]);
        if($dateorder){
            $dateorder->status = 7;
            $dateorder->receive_time = date('Y-m-d H:i:s');
            if($DateorderTable->save($dateorder)){
                $this->loadComponent('Sms');
                $this->Sms->send($dateorder->buyer->phone, $dateorder->dater->nick.
                        '已接受你发出的【'.$dateorder->user_skill->skill->name.'】邀请，请您尽快支付尾款.');
                
                $this->loadComponent('Netim');
                $this->Netim->receiveMsg($dateorder);
                $dateorder->buyer->avatar = $this->Util->getServerDomain().$dateorder->buyer->avatar;
                return $this->Util->ajaxReturn([
                   'status'=>true,
                   'code'=>202,    //唤起聊天 
                   'obj'=>$dateorder->buyer,
                   'msg'=>'接单成功',]);
            }
        }
        return $this->Util->ajaxReturn(false,'服务器开小差');
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
                    return $q->select(['phone','id','avatar','nick','birthday','money','imaccid']);
                }
                ,'Dater'=>function($q){
                    return $q->select(['id','nick','avatar','birthday','phone','imaccid']);
                }
                ,'UserSkill.Skill','Dater.Tags'
            ]
        ]);
        if($order->status !=7){
            return $this->Util->ajaxReturn(false,'订单已被更改，您无法进行此操作');
        }        
        //订单状态改变->10
        $order->status = 10;        
        //扣除尾款
        $payment = $order->amount - $order->pre_pay;
        //交易流水
        $pre_amount = $this->user->money;
        if($this->user->money < $payment){
            return $this->Util->ajaxReturn(['status'=>false,'code'=>'201','msg'=>'钱包余额不足,立即充值']);
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
            $this->Sms->send($order->dater->phone, $order->buyer->nick.
                    '已支付您的【'.$order->user_skill->skill->name.'】技能约单尾款，请及时赴约.');
            $this->loadComponent('Netim');
            $this->Netim->payallMsg($order);
            $order->dater->avatar = $this->Util->getServerDomain().$order->dater->avatar;
            return $this->Util->ajaxReturn([
                   'status'=>true,
                   'redirect_url'=>'/date-order/order-success/'.$order->id,
                   'code'=>202,    //唤起聊天 
                   'msg'=>'支付成功',
                   'obj'=>$order->dater
                       ]);
        }else{
            errorMsg($flow, '失败');
            errorMsg($dateorder, '失败');
            return $this->Util->ajaxReturn(false,'支付失败');
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
              return $this->Util->ajaxReturn(false,'订单已被更改，您无法进行此操作');
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
        $dateorder->close_time = date('Y-m-d H:i:s');
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
        //扣除违约金   10%
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
     * 取消约单 不同的节点不同的处理 处于状态10(男性已支付尾款)时
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
              return $this->Util->ajaxReturn(false,'订单已被更改，您无法进行此操作');
         }
        $dateorder->close_time = date('Y-m-d H:i:s');
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
                $w_income = 2;    //支出
                
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
                $dateorder->dater->money = $dateorder->dater->money+$w_amount;
                $w_after_amount = $dateorder->dater->money;
                $w_income = 1;
               
            }else{
                $m_remark = '男士在接受订单后约会时间2小时之内取消订单退回30%约单金';
                $w_remark = '男士在接受订单后约会时间2小时之内取消订单退回70%约单金';
                 //返还男士30%约单价格
                $m_pre_money = $dateorder->buyer->money;
                $m_amount = 0.3*$dateorder->amount;
                $dateorder->buyer->money = $dateorder->buyer->money+$m_amount;
                $m_after_amount = $dateorder->buyer->money;
                $m_income = 1;
                //返还女士70%的约单价格
                $w_amount = 0.7*$dateorder->amount;
                $w_pre_amount = $dateorder->dater->money;
                $dateorder->dater->money = $dateorder->dater->money+$w_amount;
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

                //女方的资金流水（收入）
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
           if($this->user->gender==1){
               //男性取消  女性有收入 邀请人获得提成
               $this->loadComponent('Business');
               $this->Business->shareIncome($w_amount,$dateorder->dater,$dateorder->id);
           }
            return $this->Util->ajaxReturn(true,'取消成功');
           }else{
               errorMsg($w_flow,'1');
               errorMsg($m_flow,'1');
               errorMsg($dateorder,'1');
            return $this->Util->ajaxReturn(false,'取消失败');
        }
        
    }
    
    /**
     * 删除订单  假删除
     */
    public function removeOrder(){
        $this->handCheckLogin();
        $order_id = $this->request->data('order_id');
        $DateorderTable = \Cake\ORM\TableRegistry::get('Dateorder');
        $dateorder = $DateorderTable->get($order_id);
        if($dateorder->is_del>0){
            $dateorder->is_del = 3; 
        }else{
            $dateorder->is_del = $this->user->gender;
        }
        if($DateorderTable->save($dateorder)){
            return $this->Util->ajaxReturn(true,'成功删除');
        }else{
            return $this->Util->ajaxReturn(true,'服务器开小差');
        }
    }
    
    /**
     * 赴约成功 男女
     */
    public function goOrder(){
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
                $this->Sms->send($order->buyer->phone, $order->dater->nick.
                        '已到达约会目的地，请及时到场赴约.');
                return $this->Util->ajaxReturn(true,'成功接受');
            }
        }else{
            if($order->start_time > new \Cake\I18n\Time()){
                return $this->Util->ajaxReturn(false,'还未到达约会时间不可进行此操作');
            }    
            //男
            $order->status = 15; //订单完成
            $order->close_time = date('Y-m-d H:i:s');
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
                if($this->user->gender==1){
                    //男性取消  女性有收入 邀请人获得提成
                    \Cake\Log\Log::debug('进行提成处理','devlog');
                    $this->loadComponent('Business');
                    $this->Business->shareIncome($order->amount,$order->dater,$order->id);
                }
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
     * 评价页
     */
    public function appraise($id){
        $DateorderTable = \Cake\ORM\TableRegistry::get('Dateorder');
        $order = $DateorderTable->get($id,[
            'contain'=>[
                 'Dater' => function($q) {
                            return $q->select(['id', 'nick', 'money','avatar']);
                    },
                  'UserSkill.Skill'           
            ]
        ]);
        if($this->request->is('ajax')){
            $order->status = 16; //已评价
            $order = $DateorderTable->patchEntity($order,  $this->request->data());
            if($DateorderTable->save($order)){
                return $this->Util->ajaxReturn(true,'评价成功');
            }else{
                return $this->Util->ajaxReturn(true,'服务器开小差');
            }
            
        }            
        $this->set([
            'order'=>$order,
            'pageTitle'=>'评价'
        ]);
    }
    /**
     * 评价页
     */
    public function viewAppraise($id){
        $DateorderTable = \Cake\ORM\TableRegistry::get('Dateorder');
        $order = $DateorderTable->get($id,[
            'contain'=>[
                 'Dater' => function($q) {
                            return $q->select(['id', 'nick', 'money','avatar']);
                    },
                  'UserSkill.Skill'           
            ]
        ]);
        $this->set([
            'order'=>$order,
            'pageTitle'=>'评价'
        ]);
    }
    
    
     /**
     * 预约订单详情
     */
    public function orderDetail($id){
        $DateorderTable = TableRegistry::get('Dateorder');
        $order = $DateorderTable->get($id,[
            'contain'=>[
                'Buyer'=>function($q){
                    return $q->select(['phone','id','avatar','nick','birthday']);
                }
                ,'Dater'=>function($q){
                    return $q->select(['id','nick','avatar','birthday']);
                }
                ,'UserSkill.Skill','Dater.Tags','Date'
            ]
        ]);
        $lasth = getLast((new Time($order->start_time)), (new Time($order->end_time)));
        if($this->user->gender==1){
             if((strtotime($order->start_time)-time())>= 2*60*60){
                 //2小时开外
                $refuse_msg = '将只退回约单金额的70%,剩余的30%将打至对方账户作为补偿';
             }else{
                $refuse_msg = '将只退回约单金额的30%,剩余的70%将打至对方账户作为补偿';
             }
        }else{
            $refuse_msg = '将会扣除约单金额的20%作为惩罚';
        }
        $start_time = clone $order->start_time;
        $expire_time = $start_time->addHours(24)->i18nFormat('M月d日H时');
        $this->set([
            'order'=>$order,
            'user'=>  $this->user,
            'pageTitle'=>'订单详情',
            'refuse_msg'=>$refuse_msg,
            'lasth'=>$lasth,
            'expire_time'=>$expire_time
        ]);                      
        
    }
    
    /**
     * 订单评价
     */
    public function showAppraise($id){
        $DateorderTable = TableRegistry::get('Dateorder');
        $order = $DateorderTable->get($id,[
            'select'=>['appraise_time','appraise_match','appraise_service'],
            'contain'=>[
                'Dater'=>function($q){
                    return $q->select(['id','nick','avatar','birthday']);
                }
                ,'UserSkill.Skill'
            ]
        ]);
        $this->set([
            'order'=>$order,
            'pageTitle'=>'评价'
        ]);
    }
}
