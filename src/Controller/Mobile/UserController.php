<?php

namespace App\Controller\Mobile;

use App\Controller\Mobile\AppController;

/**
 * User Controller
 *
 * @property \App\Model\Table\UserTable $User
 */
class UserController extends AppController {

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index() {
        $user = $this->paginate($this->User);

        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    public function login() {
        $redirect_url = empty($this->request->query('redirect_url')) ? '/user/index' : $this->request->query('redirect_url');
        if (in_array($redirect_url, ['/home/my-install', '/user/login'])) {
            $redirect_url = '/user/index';
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $phone = $this->request->data('phone');
            $UserTable = \Cake\ORM\TableRegistry::get('User');
            if ($phone) {
                //密码登录
                $user = $UserTable->find()->where(['phone' => $phone, 'enabled' => 1, 'is_del' => 0])->first();
                $pwd = $this->request->data('pwd');
                if (!$user) {
                    return $this->Util->ajaxReturn(['status' => false, 'msg' => '该手机号未注册或被禁用']);
                }
                if (!(new \Cake\Auth\DefaultPasswordHasher)->check($pwd, $user->pwd)) {
                    return $this->Util->ajaxReturn(false, '密码不正确');
                } else {
                    $this->request->session()->write('User.mobile', $user);
                    $user_token = false;
                    $bind_wx = false;
                    if ($this->request->is('lemon')) {
                        $this->request->session()->write('Login.login_token', $user->user_token);
                        $user_token = $user->user_token;
                    }
                    if ($this->request->is('weixin') && !$user->wx_openid) {
                        $bind_wx = true;
                    }
                    return $this->Util->ajaxReturn(['status' => true, 'redirect_url' => $redirect_url, 
                        'token_uin' => $user_token, 'bind_wx' => $bind_wx,'msg'=>'登入成功']);
                }
            } else {
                return $this->Util->ajaxReturn(['status' => false, 'msg' => '请输入手机号']);
            }
        }
    }

    /**
     * 用户注册
     */
    public function register() {
        if ($this->request->is('ajax')) {
            $user = $this->User->newEntity();
            $data = $this->request->data();
            $data['enabled'] = 1;
            $ckReg = $this->User->find()->where(['phone' => $data['phone']])->first();
            if ($ckReg) {
                return $this->Util->ajaxReturn(false, '该手机号已经注册过');
            }
            $data['user_token'] = md5(uniqid());
            if ($this->request->is('weixin')) {
                $data['device'] = 'weixin';
            }
            if ($this->request->session()->read('reg.wx_bind') && $this->request->session()->check('reg.wx_openid')) {
                //第一次微信登录的完善信息
                if ($this->request->session()->check('reg.wx_unionid')) {
                    $data['union_id'] = $this->request->session()->read('reg.wx_unionid');
                }
                if ($this->request->is('lemon')) {
                    $data['app_wx_openid'] = $this->request->session()->read('reg.wx_openid');
                } else {
                    $data['wx_openid'] = $this->request->session()->read('reg.wx_openid');
                }
                if ($this->request->session()->check('reg.avatar')) {
                    $data['avatar'] = $this->request->session()->read('reg.avatar');
                }
            }
            $user = $this->User->patchEntity($user, $data);
            if ($this->User->save($user)) {
                $jumpUrl = '/user/index';
                $msg = '注册成功';
                if ($this->request->is('weixin')) {
                    $jumpUrl = '/wx/bindWx';
                    $msg = '注册成功,前往绑定微信';
                }
                $this->request->session()->write('User.mobile', $user);
                $this->user = $user;
                $user_token = false;
                if ($this->request->is('lemon')) {
                    $this->request->session()->write('Login.login_token', $user->user_token);
                    $user_token = $user->user_token;
                }
                //redis push 记录
                return $this->Util->ajaxReturn(['status' => true, 'msg' => $msg, 'url' => $jumpUrl]);
            } else {
                \Cake\Log\Log::error($user->errors());
                return $this->Util->ajaxReturn(['status' => false, 'msg' => getMessage($user->errors())]);
            }
        }
        $this->set([
            'pageTitle' => '注册'
        ]);
    }

    public function sendVcode() {
        $this->loadComponent('Sms');
        $mobile = $this->request->data('phone');
        $code = createRandomCode(4, 2); //创建随机验证码
        $content = '您的动态验证码为' . $code;
        $codeTable = \Cake\ORM\TableRegistry::get('smsmsg');
        $vcode = $codeTable->find()->where("`phone` = '$mobile'")->orderDesc('create_time')->first();
        if (empty($vcode) || (time() - strtotime($vcode['time'])) > 30) {
            //30s 的间隔时间
            $ckSms = $this->Sms->sendByQf106($mobile, $content, $code);
            if ($ckSms) {
                $this->request->session()->write('UserLoginVcode', ['code' => $code, 'time' => time()]);
                return $this->Util->ajaxReturn(true, '发送成功');
            }
        } else {
            return $this->Util->ajaxReturn(false, '30秒后再发送');
        }
    }

}
