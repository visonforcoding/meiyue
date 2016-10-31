<?php

namespace App\Controller\Mobile;

use App\Controller\Mobile\AppController;
use App\Utils\umeng\Umeng;
use Cake\Utility\Security;
use App\Utils\Word\TrieTree;

/**
 * Index Controller
 *
 * @property \App\Model\Table\IndexTable $Index
 * @property \App\Controller\Component\SmsComponent $Sms
 * @property \App\Controller\Component\WxComponent $Wx
 * @property \App\Controller\Component\EncryptComponent $Encrypt
 * @property \App\Controller\Component\PushComponent $Push
 * @property \App\Controller\Component\BdmapComponent $Bdmap
 */
class IndexController extends AppController {
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index() {
        $this->viewBuilder()->layout('layout_sui');
        //$umengObj = new Umeng($key, $secret);
        //var_dump($umengObj);
        //set_time_limit(0);
    }
    
    public function demo(){
       //GlideHelper::image('/upload/user/avatar/2016-10-28/58102ba461a5e.jpg');
       $this->loadComponent('Bdmap');
       $res = $this->Bdmap->placeSearchNearBy('咖啡', '22.64322,114.0322');
       debug($res);
    }

    public function test() {
        $this->autoRender = false;
        $cipher = 'NDk3MzYyNmI3YzI0YjMwZDU4MTViZTliOTVhNGRlYzZhOTk3ZmZlZmQwNmNlOTI1NjExODU1ZDAwNTJiMzEwZaD0xBasVESkYgXn99ZSMnBRdwanx0YcQse1r6cbGC1Z';
        $this->loadComponent('Encrypt');
        $str = $this->Encrypt->decrypt($cipher);
        debug($str);
    }

    public function setphone() {
        $this->autoRender = false;
        $redis = new \Redis();
        $redis_conf = \Cake\Core\Configure::read('redis_server');
        $redis->connect($redis_conf['host'], $redis_conf['port']);
        $UserTable = \Cake\ORM\TableRegistry::get('User');
        $users = $UserTable->find()->hydrate(false)->select(['phone'])->where(['is_del' => 0, 'enabled' => '1'])->toArray();
        foreach ($users as $user) {
            if (empty($user['phone'])) {
                continue;
            }
            $redis->sAdd('phones', $user['phone']);
        }
        debug($redis->sGetMembers('phones'));
    }

}
