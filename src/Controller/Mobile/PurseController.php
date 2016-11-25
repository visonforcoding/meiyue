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
        ]);
    }
    
}
