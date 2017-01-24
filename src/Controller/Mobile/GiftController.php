<?php

namespace App\Controller\Mobile;

use App\Controller\Mobile\AppController;
use Cake\ORM\TableRegistry;

/**
 * Gift Controller
 * 送礼物
 * @property \App\Model\Table\GiftTable $Gift
 * @property \App\Controller\Component\NetimComponent $Netim
 */
class GiftController extends AppController
{
    /**
     * 活动-头牌-支持她-送礼物页面
     * Index method
     * @return \Cake\Network\Response|null
     */
    public function index($id)
    {
        //被支持者信息
        $userTb = TableRegistry::get("User");
        $user = $userTb->get($id, ['select' => ['id', 'nick', 'avatar']]);
        $gifts = $this->Gift->find('all')->orderAsc('price');
        $this->set([
            'user' => $user,
            'me' => $this->user,
            'gifts' => $gifts->toArray(),
            'pageTitle' => '礼物',
        ]);
    }


    /**
     * 活动-头牌-支持她-送礼物接口
     * @param $uid 被支持者id
     * @param $gid 礼物id
     */
    public function send($uid, $gid) {

        if($this->request->is("POST")) {

            $gift = $this->Gift->get($gid);
            if(!$gift) {
                return $this->Util->ajaxReturn(false, '礼物不存在');
            }
            //检查用户余额是否充足
            if($gift->price > $this->user->money) {
                return $this->Util->ajaxReturn(false, '钱包余额不足,立即充值');
            }

            //生成支持记录
            $supportTb = TableRegistry::get("Support");
            $support = $supportTb->newEntity(Array(
                'supporter_id' => $this->user->id,
                'supported_id' => $uid
            ));

            //修改支付方费用
            $outpre_money = $this->user->money;
            $this->user->money = $this->user->money - $gift->price;
            $outafter_money = $this->user->money;
            $this->user->recharge = $this->user->recharge + $gift->price;
            $out_user = $this->user;
            //修改收款方费用
            $userTb = TableRegistry::get('User');
            $in_user = $userTb->get($uid);
            if(!$in_user) {
                return $this->Util->ajaxReturn(false, '用户不存在');
            }
            $inpre_money = $in_user->money;
            $in_user->money = $in_user->money + $gift->price;
            $inafter_money = $in_user->money;
            $in_user->charm = $in_user->charm + $gift->price;
            //生成流水
            $FlowTable = TableRegistry::get('Flow');
            $inflow = [
                'user_id'=> $uid,
                'buyer_id'=>  0,
                'type'=>14,
                'type_msg'=>'礼物（'.$gift->name.')',
                'income'=>1,
                'amount'=>$gift->price,
                'price'=>$gift->price,
                'pre_amount'=>$inpre_money,
                'after_amount'=>$inafter_money,
                'paytype'=>1,   //余额支付
                'remark'=> '礼物名称['.$gift->name.']|礼物价格['.$gift->price.']'
            ];
            $outflow = [
                'user_id'=> 0,
                'buyer_id'=>  $this->user->id,
                'type'=>14,
                'type_msg'=>'送礼物（'.$gift->name.')',
                'income'=>2,
                'amount'=>$gift->price,
                'price'=>$gift->price,
                'pre_amount'=>$outpre_money,
                'after_amount'=>$outafter_money,
                'paytype'=>1,   //余额支付
                'remark'=> '礼物名称['.$gift->name.']|礼物价格['.$gift->price.']'
            ];
            $transRes = $supportTb->connection()->transactional(
                function() use ($supportTb, $support, $FlowTable, $inflow, $outflow, $userTb, $in_user, $out_user){
                    $inflow = $FlowTable->newEntity($inflow);
                    $outflow = $FlowTable->newEntity($outflow);
                    $supres = $supportTb->save($support);
                    if($supres) {
                        $inflow->relate_id = $supres->id;
                        $outflow->relate_id = $supres->id;
                    }
                    $inflores = $FlowTable->save($inflow);
                    $outflores = $FlowTable->save($outflow);
                    $inures = $userTb->save($in_user);
                    $ouures = $userTb->save($out_user);
                    return $supres&&$inflores&&$outflores&&$inures&&$ouures;
                });

            if($transRes) {
                $this->loadComponent('Netim');
                $this->Netim->giftMsg($out_user, $in_user, $gift);
                 return $this->Util->ajaxReturn([
                   'status'=>true,
                   'code'=>202,    //唤起聊天 
                   'obj'=>$in_user,
                   'msg'=>'谢谢您的礼物，么么哒^u^',
                       ]);
            }
            return $this->Util->ajaxReturn(false, '操作失败');

        }
        return $this->Util->ajaxReturn(false, '非法操作');

    }

    /**
     * View method
     * @param string|null $id Date id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {

    }


}
