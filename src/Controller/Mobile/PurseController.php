<?php

namespace App\Controller\Mobile;

use App\Controller\Mobile\AppController;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;

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
        $this->set([
            'pageTitle'=>'充值'
        ]);
    }
    
    
    /**
     * 生成  支付订单
     */
    public function createPayorder(){
        $PayorderTable = TableRegistry::get('Payorder');
        $payorder = $PayorderTable->newEntity([
            'user_id'=>  $this->user->id,
            'title'=>'美约美币充值',
            'order_no'=>time() . $this->user->id . createRandomCode(4, 1),
            'price'=>  $this->request->data('mb'),
            'remark'=>  '充值美币'.$this->request->data('mb').'个',
        ]);
        if($PayorderTable->save($payorder)){
            return $this->Util->ajaxReturn(['status'=>true,'redirect_url'=>'/wx/pay/'.$payorder->id]);
        }else{
            return $this->Util->ajaxReturn(['status'=>false,'msg'=>  errorMsg($payorder, '服务器出错')]);
        }
    }
    
}
