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
class ChatController extends AppController {

    public function initialize() {
        parent::initialize();
    }

    
    /**
     * 消息列表
     */
    public function chatList(){
        if(!$this->user){
            return $this->render('chat_list_nologin');
        }
        $UserTable = TableRegistry::get('User');
        $users = $UserTable->find()
                            ->select(['id','nick','avatar','imtoken'])
                            ->where(['imtoken !='=>'','id !='=>  $this->user->id])->toArray();
        $this->set([
            'pageTitle'=>'消息',
            'users'=>$users
        ]);
    }
    
}
