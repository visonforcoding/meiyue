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
        $netim_conf = \Cake\Core\Configure::read('netim');
        $imkey = $netim_conf['app_key'];
        if(!$this->user){
            $this->set([
                'pageTitle'=>'消息'
            ]);      
            return $this->render('chat_list_nologin');
        }
        $this->set([
            'pageTitle'=>'消息',
            'user' => $this->user,
            'imkey'=>$imkey,
        ]);
    }
    
    
    /**
     * 聊天页
     */
    public function chatDetail()
    {
        
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
                                            $item['avatar'] = $this->Util->getServerDomain() . 
                                                    createImg($item['avatar']) .
                                                    '?w=184';
                                            return $item;
                                        });
                            })
                           ->toArray();
        return $this->Util->ajaxReturn(['users'=>$users]);
    }


    public function meiyueMessage()
    {
        $this->set([
            'pageTitle'=>'平台消息',
        ]);
    }
}
