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
        $unread = $this->checkRead();
        if(!$this->user){
            $this->set([
                'pageTitle'=>'消息'
            ]);      
            return $this->render('chat_list_nologin');
        }
        $this->set([
            'pageTitle'=>'消息',
            'user' => $this->user,
            'unread' => $unread,
            'imkey'=>$imkey,
            'domain'=> $this->Util->getServerDomain()
        ]);
    }
    
    
    /**
     * 聊天页
     */
    public function chatDetail($accid)
    {
        $UserTable = TableRegistry::get('User');
        $to_user = $UserTable->find()->select(['nick','avatar','id'])->where(['imaccid'=>$accid])->first();
        $netim_conf = \Cake\Core\Configure::read('netim');
        $imkey = $netim_conf['app_key'];
        $this->set([
            'imkey'=>$imkey,
            'to_user'=>$to_user,
            'pageTitle'=>$to_user->nick,
            'user'=> $this->user
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
                                            $item['avatar'] = generateImgUrl($item['avatar']) .
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
            'user' => $this->user,
            'pageTitle'=>'平台消息',
        ]);
    }

    /**
     *获取我的平台消息
     */
    public function getMessages($page = null)
    {
        $limit = 10;
        $msgpush = TableRegistry::get('Msgpush');
        $datas = $msgpush->find()
            ->hydrate(false)
            ->contain(['Ptmsg' => function ($q) {
                return $q->where(['is_del' => 0]);
            }])
            ->orderDesc('Ptmsg.create_time')
            ->where(['user_id' => $this->user->id])
            ->limit(intval($limit))
            ->page(intval($page))
            ->formatResults(function ($items) {
                return $items->map(function ($item) {
                    $createTime = new Time($item['create_time']);
                    $item['create_time'] = $createTime->i18nFormat('yyyy-MM-dd HH:mm');
                    return $item;
                });
            })
            ->toArray();
        //修改数据已读状态
        $msgpush->query()->update()
            ->set(['is_read' => 1])
            ->where(['user_id' => $this->user->id])
            ->limit(intval($limit))
            ->page(intval($page))
            ->execute();
        return $this->Util->ajaxReturn(['datas' => $datas]);
    }


    /**
     * 检查是否有未读消息
     */
    protected function checkRead()
    {
        $uid = $this->request->data("uid");
        $msgpush = TableRegistry::get('Msgpush');
        $num = $msgpush->find()
            ->where(['user_id' => $uid, 'is_read' => 0])
            ->count();
        return $num;
    }
}
