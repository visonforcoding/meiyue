<?php

namespace App\Controller\Mobile;

use App\Controller\Mobile\AppController;
use Cake\ORM\TableRegistry;

/**
 * Gift Controller
 * 送礼物
 * @property \App\Model\Table\GiftTable $Gift
 *
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
                return $this->Util->ajaxReturn(false, '余额不足');
            }

            //生成支持记录
            $supportTb = TableRegistry::get("Support");
            $support = $supportTb->newEntity(Array(
                'supporter_id' => $this->user->id,
                'supported_id' => $uid
            ));

            //修改支付方费用
            $out_pre_amount = $this->user->money;
            $this->user->money = $this->user->money - $gift->price;
            $out_user = $this->user;
            $out_after_amount = $this->user->money;
            //修改收款方费用
            $userTb = TableRegistry::get('User');
            $in_user = $userTb->get($uid);
            if(!$in_user) {
                return $this->Util->ajaxReturn(false, '用户不存在');
            }
            $in_pre_amount = $in_user->money;
            $in_user->money = $in_user->money + $gift->price;
            $in_after_amount = $in_user->money;
            //生成流水
            $FlowTable = TableRegistry::get('Flow');
            $out_flow = [
                'user_id'=> $uid,
                'buyer_id'=>  $this->user->id,
                'type'=>14,
                'type_msg'=>'送礼物',
                'income'=>2,
                'amount'=>$gift->price,
                'price'=>$gift->price,
                'pre_amount'=>$out_pre_amount,
                'after_amount'=>$out_after_amount,
                'paytype'=>1,   //余额支付
                'remark'=> '礼物名称['.$gift->name.']|礼物价格['.$gift->price.']'
            ];
            $in_flow = [
                'user_id'=> $uid,
                'buyer_id'=>  $this->user->id,
                'type'=>14,
                'type_msg'=>'收礼物',
                'income'=>1,
                'amount'=>$gift->price,
                'price'=>$gift->price,
                'pre_amount'=>$in_pre_amount,
                'after_amount'=>$in_after_amount,
                'paytype'=>1,   //余额支付
                'remark'=> '礼物名称['.$gift->name.']|礼物价格['.$gift->price.']'
            ];

            $transRes = $supportTb->connection()->transactional(
                function() use ($supportTb, $support, $FlowTable, $out_flow, $in_flow, $userTb, $in_user, $out_user){
                    $mulflows = $FlowTable->newEntities([$out_flow, $in_flow]);
                    $supres = $supportTb->save($support);
                    $flores = $FlowTable->saveMany($mulflows);
                    $inures = $userTb->save($in_user);
                    $ouures = $userTb->save($out_user);
                    return $supres&&$flores&&$inures&&$ouures;
                });

            if($transRes) {
                return $this->Util->ajaxReturn(true, '感谢您的支持');
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
