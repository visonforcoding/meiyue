<?php

namespace App\Controller\Mobile;

use App\Controller\Mobile\AppController;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use PackType;

/**
 * Purse Controller 钱包
 *
 * @property \App\Model\Table\UserTable $User
 * @property \App\Controller\Component\SmsComponent $Sms
 */
class PurseController extends AppController {

    public function initialize() {
        parent::initialize();
    }

    
    /**
     * 充值
     */
    public function recharge(){
        $packTb = TableRegistry::get('Package');
        $redurl = $this->request->query('redurl');
        $packs = $packTb
            ->find()
            ->where(['is_used' => 1, 'type' => PackType::RECHARGE])
            ->orderDesc('show_order');
        $this->set([
            'packs' => $packs,
            'redurl' => $redurl,
            'pageTitle'=>'充值'
        ]);
    }
    
    
    /**
     * 生成  支付订单
     */
    public function createPayorder(){
        $PayorderTable = TableRegistry::get('Payorder');
        $redurl = $this->request->query('redurl');
        $payorder = $PayorderTable->newEntity([
            'user_id'=>  $this->user->id,
            'title'=>'美约美币充值',
            'order_no'=>time() . $this->user->id . createRandomCode(4, 1),
            'price'=>  $this->request->data('mb'),
            'fee'=>  $this->request->data('mb'),
            'remark'=>  '充值美币'.$this->request->data('mb').'个',
        ]);
        if($PayorderTable->save($payorder)){
            return $this->Util->ajaxReturn(['status'=>true,'redirect_url'=>'/wx/pay/'.$payorder->id.'?redurl='.$redurl,]);
        }else{
            return $this->Util->ajaxReturn(['status'=>false,'msg'=>  errorMsg($payorder, '服务器出错')]);
        }
    }

}
