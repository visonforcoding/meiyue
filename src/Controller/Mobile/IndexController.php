<?php

namespace App\Controller\Mobile;

use App\Controller\Mobile\AppController;
use App\Utils\umeng\Umeng;
use Cake\Utility\Security;
use App\Utils\Word\TrieTree;
use Cake\I18n\Time;

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
     * 发现首页
     * @return \Cake\Network\Response|null
     */
    public function index() {
//        echo json_encode(['images'=>['1'=>'http://1.jpg','2'=>'http://2.jpg']]);exit();
//        $this->viewBuilder()->layout('layout_sui');
        //$umengObj = new Umeng($key, $secret);
        //var_dump($umengObj);
        //set_time_limit(0);
        $this->set([
            'pageTitle' => '发现-美约'
        ]);
    }

    /**
     * 发现列表
     */
    public function findList() {
        $this->set([
            'pageTitle' => '发现'
        ]);
    }

    public function getUserList($page) {
        $limit = 10;
        $UserTable = \Cake\ORM\TableRegistry::get('User');
        $query = $UserTable->find()->select(['id', 'nick', 'birthday', 'profession', 'login_time', 'avatar', 'login_coord']);
        $query->hydrate(false);
        $query->where(['enabled' => 1, 'status' => 3]);
        $query->order(['login_time' => 'desc']);
        $query->limit(intval($limit))
                ->page(intval($page));
        $query->formatResults(function($items) {
            return $items->map(function($item) {
                        //时间语义化转换
                        $item['age'] = (Time::now()->year)-((new Time($item['birthday']))->year);
                        $item['login_time'] = (new Time($item['login_time']))->timeAgoInWords(
                                [ 'accuracy' => [
                                        'year' => 'year',
                                        'month' => 'month',
                                        'week' => 'week',
                                        'day' => 'day',
                                        'hour' => 'hour'
                                    ], 'end' => '+10 year']
                        );
                        return $item;
                    });
        });
        $users = $query->toArray();
        return $this->Util->ajaxReturn(['users' => $users]);
    }

    public function demo() {
        //GlideHelper::image('/upload/user/avatar/2016-10-28/58102ba461a5e.jpg');
        //$this->loadComponent('Bdmap');
        //$res = $this->Bdmap->placeSearchNearBy('咖啡', '22.64322,114.0322');
        $this->set([
            'pageTitle' => '测试'
        ]);
    }

    public function getParam() {
        $time = time();
        $sign = strtoupper(md5($time . '64e3f4e947776b2d6a61ffbf8ad05df4'));
        debug([
            'time' => $time,
            'sign' => $sign
        ]);
        exit();
    }

}
