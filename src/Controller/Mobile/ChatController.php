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
            $this->set([
                'pageTitle'=>'消息'
            ]);      
            return $this->render('chat_list_nologin');
        }
        $UserTable = TableRegistry::get('User');
        $users = $UserTable->find()
                            ->select(['id','nick','avatar','imtoken','imaccid'])
                            ->where(['imtoken !='=>'','id !='=>  $this->user->id])
                            ->formatResults(function($items) {
                                return $items->map(function($item) {
                                            $item['avatar'] = 'http://m-my.smartlemon.cn' . createImg($item['avatar']) .
                                                    '?w=184&h=184&fit=stretch';
                                            return $item;
                                        });
                            })
                            ->toArray();
        $this->set([
            'pageTitle'=>'消息',
            'users'=>$users,
            'user' => $this->user,
        ]);
    }
    
    
    /**
     * 返回
     * @return type
     */
    public function getSesList(){
        $accids = $this->request->data('accids');
        $UserTable = TableRegistry::get('User');
        $users = $UserTable->find()->select(['id','nick','avatar','imaccid'])
                           ->where(['imaccid in'=>$accids])
                           ->formatResults(function($items) {
                                return $items->map(function($item) {
                                            $item['avatar'] = $this->Util->getServerDomain() . createImg($item['avatar']) .
                                                    '?w=184';
                                            return $item;
                                        });
                            })
                           ->toArray();
        return $this->Util->ajaxReturn(['users'=>$users]);
    }
    
}
