<?php

/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller\Mobile;

use Cake\Controller\Controller;
use Cake\Event\Event;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 * @property \App\Controller\Component\UtilComponent $Util
 * @property \App\Controller\Component\WxComponent $Wx
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    /**
     * 无需验证登录的action
     * @var array 
     */
    private $firewall;
    protected $user;
    /**
     * 登录坐标
     * @var type 
     */
    protected $coord;

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize() {
        parent::initialize();
        $this->viewBuilder()->layout('layout');
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Util');
        //\Cake\Log\Log::debug($this->request->cookie('token_uin'),'devlog');
        //无需登录的
        $this->firewall = array(
            ['user', 'login'],
            ['user', 'register'],
            ['news', 'index'],
            ['news', 'view'],
            ['chat', 'chatlist'],
        );
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return void
     */
    public function beforeRender(Event $event) {
        $wxConfig = [];
        if ($this->request->is('weixin')) {
            $this->loadComponent('Wx');
            $wxConfig = $this->Wx->wxconfig(['onMenuShareTimeline', 'onMenuShareAppMessage', 'scanQRCode',
                'chooseImage', 'uploadImage', 'previewImage','getLocation','openLocation'], false);
        }
        $isLogin = 'no';
        if ($this->user) {
            $isLogin = 'yes';
        }
        $this->set(compact('isLogin'));
        $this->set(compact('wxConfig'));
        if (!array_key_exists('_serialize', $this->viewVars) &&
                in_array($this->response->type(), ['application/json', 'application/xml'])) {
            $this->set('_serialize', true);
        }
    }

    public function beforeFilter(Event $event) {
        $this->user = $this->request->session()->read('User.mobile');
        $UserTable = \Cake\ORM\TableRegistry::get('User');
        if($this->user){
            $this->user = $UserTable->findById($this->user->id)->first();
        }
        $this->coord = $this->request->cookie('coord')?$this->request->cookie('coord'):'114.044555,22.6453';
        //$this->coord = $this->request->cookie('coord');
        $coord_time = $this->request->cookie('coord_time');
        if(time()-$coord_time>30*60&&$this->user){
            //30分钟有活动 更新坐标
            $coord = $this->getPosition();
            if($coord){
                $this->user->login_coord_lng = $coord[0];
                $this->user->login_coord_lat = $coord[1];
                $UserTable->save($this->user);
            }
        }
        if (!$this->user && $this->request->isLemon()) {
            //debug($this->request->cookie('login_token'));
        }
        return $this->checkLogin();
    }

    /**
     * 检查用户登录
     * @return type
     */
    private function checkLogin() {
        $controller = strtolower($this->request->param('controller'));
        $action = strtolower($this->request->param('action'));
        $request_aim = [$controller, $action];
        if (!in_array($request_aim, [['user', 'login'], ['user', 'register']])) {
            //静默登陆
            $this->wxBaseLogin();
            $this->baseLogin();
        }
        if (in_array($request_aim, $this->firewall) ||
                in_array($controller, ['user', 'wx', 'pay', 'api', 
                    'home', 'index', 'activity', 'date', 'dateorder', 'user','test'])) {
            return true;
        }
        return $this->handCheckLogin();
    }

    /**
     * app 的静默(自动)登录
     */
    protected function baseLogin() {
        //\Cake\Log\Log::debug('进入APP登录自动登录','devlog');
        $user = $this->request->session()->check('User.mobile');
        $url = '/' . $this->request->url;
        if ($this->request->isLemon() && $this->request->cookie('token_uin') && !$user) {
            //如果是APP，获取user_token 自动登录
            $user_token = $this->request->cookie('token_uin');
            $UserTable = \Cake\ORM\TableRegistry::get('User');
            $user = $UserTable->find()->where(['user_token' => $user_token, 'enabled' => 1, 'is_del' => 0])->first();
            if ($user) {
                $this->request->session()->write('User.mobile', $user);
                $this->response->cookie([
                    'name' => 'login_stauts',
                    'value' => 'yes',
                    'path' => '/',
                    'expire' => time() + 1200
                ]);
                $this->user = $this->request->session()->read('User.mobile');
            }
        }
    }

    /**
     * 处理检测登陆
     * @return type
     */
    protected function handCheckLogin() {
        $user = $this->request->session()->check('User.mobile');
        $url = '/' . $this->request->url;
        if ($this->request->isLemon() && $this->request->cookie('token_uin') && !$user) {
            //如果是APP，获取user_token 自动登录
            $user_token = $this->request->cookie('token_uin');
            $UserTable = \Cake\ORM\TableRegistry::get('User');
            $user = $UserTable->find()->where(['user_token' => $user_token, 'enabled' => 1, 'is_del' => 0])->first();
            if ($user) {
                $this->request->session()->write('User.mobile', $user);
                $this->response->cookie([
                    'name' => 'login_stauts',
                    'value' => 'yes',
                    'path' => '/',
                    'expire' => time() + 1200
                ]);
                $this->user = $this->request->session()->read('User.mobile');
            }
        }
        if (!$user) {
            if ($this->request->is('ajax')) {
                $url = $this->request->referer();
                $login_url = '/user/login?redirect_url=' . $url;  //最好 url——encode一下,  先注意验证一下url带有问号参数的情况
                $this->autoRender = false;
                $this->response->type('json');
                $this->response->body(json_encode(['status' => false, 'msg' => '请先登录', 'code' => 403, 'redirect_url' => $login_url]));
                $this->response->send();
                return $this->response->stop();
            }
            $url = urlencode($url);
            $this->redirect('/user/login?redirect_url=' . $url); //return $response object
            $this->response->send();
            return $this->response->stop();
            //header("location:".'/user/login');
        }
    }

    /**
     * 微信的静默登录
     * @return type
     */
    protected function wxBaseLogin() {
        if (!$this->request->is(['ajax', 'post'])) {
            if ($this->request->isWeixin() && empty($this->user) && !$this->request->session()->check('Login.wxbase')) {
                if ($this->request->query('code')) {
                    //若是来自于微信的回传
                    $this->loadComponent('Wx');
                    $res = $this->Wx->getUser();
                    //微信静默登录
                    \Cake\Log\Log::debug('静默登录', 'devlog');
                    \Cake\Log\Log::debug($res, 'devlog');
                    $this->request->session()->write('Login.wxbase', true);
                    $user = false;
                    $UserTable = \Cake\ORM\TableRegistry::get('User');
                    if (isset($res->unionid)) {
                        $union_id = $res->unionid;
                        $user = $UserTable->find()->where(['union_id' => $union_id, 'enabled' => 1, 'is_del' => 0])->first();
                    }
                    if (!isset($res->unionid) && isset($res->openid)) {
                        $open_id = $res->openid;
                        $user = $UserTable->find()->where(['wx_openid' => $open_id, 'enabled' => 1, 'is_del' => 0])->first();
                    }
                    if ($user) {
                        //通过微信 获取到 在平台上有绑定的用户  就默认登录
                        if (empty($user->union_id) && isset($res->unionid)) {
                            $user->union_id = $res->unionid;
                            $UserTable->save($user);
                        }
                        if (empty($user->wx_openid) && isset($res->openid)) {
                            $user->wx_openid = $res->openid;
                            $UserTable->save($user);
                        }
                        $this->request->session()->write('User.mobile', $user);
                        $this->response->cookie([
                            'name' => 'login_stauts',
                            'value' => 'yes',
                            'path' => '/',
                            'expire' => time() + 1200
                        ]);
                    } else {
                        $this->request->session()->write('Login.wxinfo', $res);
                    }
                }
                //如果是微信 静默授权页获取openid
                \Cake\Log\Log::debug('进行静默登陆', 'devlog');
                $this->loadComponent('Wx');
                //$this->request->session()->delete('Login.wxbase');  //每次还是会进行静默登陆，但是不会死循环
                return $this->Wx->getUserJump(true, true);  //跳转至微信服务器
            }
        }
    }


    /**
     * 获取坐标
     */
    protected function getPosition() {

        $position = explode(',', $this->coord);
        return $position;

    }
}
