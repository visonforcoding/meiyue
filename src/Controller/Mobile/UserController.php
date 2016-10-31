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
        $this->set([
            'pageTitle' => '美约-我的'
        ]);
    }

    public function login() {
        $redirect_url = empty($this->request->query('redirect_url')) ? '/user/index' : $this->request->query('redirect_url');
        if (in_array($redirect_url, ['/home/my-install', '/user/login'])) {
            $redirect_url = '/user/index';
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $phone = $this->request->data('phone');
            $coord = $this->request->cookie('coord');
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
                    $data['login_time'] = date('Y-m-d H:i:s');
                    if ($coord) {
                        $data['login_coord'] = $coord;
                    }
                    $user = $this->User->patchEntity($user, $data);
                    $this->User->save($user);
                    return $this->Util->ajaxReturn(['status' => true, 'redirect_url' => $redirect_url,
                                'token_uin' => $user_token, 'bind_wx' => $bind_wx, 'msg' => '登入成功']);
                }
            } else {
                return $this->Util->ajaxReturn(['status' => false, 'msg' => '请输入手机号']);
            }
        }
        $this->set([
            'pageTitle' => '美约-登录'
        ]);
    }

    /**
     * 用户注册
     */
    public function register() {
        if ($this->request->is('ajax')) {
            //验证验证码
            $data = $this->request->data();
            $data['gender'] = $this->request->query('gender') ? $this->request->query('gender') : 1;
            $SmsTable = \Cake\ORM\TableRegistry::get('Smsmsg');
            $sms = $SmsTable->find()->where(['phone'])->orderDesc('create_time')->first();
            if (!$sms) {
                return $this->Util->ajaxReturn(false, '验证码错误');
            } else {
                if ($sms->code != $data['vcode']) {
                    return $this->Util->ajaxReturn(false, '验证码错误');
                }
                if ($sms->expire_time < time()) {
                    return $this->Util->ajaxReturn(false, '验证码已过期');
                }
            }
            $user = $this->User->newEntity();
            $data['enabled'] = 1;

            $ckReg = $this->User->find()->where(['phone' => $data['phone']])->first();
            if ($ckReg) {
                return $this->Util->ajaxReturn(false, '该手机号已经注册过');
            }
            $data['user_token'] = md5(uniqid());
            if ($this->request->is('weixin')) {
                $data['device'] = 'weixin';
            }
            $user = $this->User->patchEntity($user, $data);
            if ($this->User->save($user)) {
                $jumpUrl = '/user/reg-identify';
                $msg = '注册成功';
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
            'pageTitle' => '美约-注册'
        ]);
    }

    /**
     * 注册检测性别
     */
    public function regCheckSex() {
        $this->handCheckLogin();
        if ($this->request->is('post')) {
            $gender = 1;
            $redirect_url = '/user/reg-user-info';
            if ($this->request->data('sex') == '女') {
                $gender = 2;
                $redirect_url = '/user/reg-identify';
            }
            $user_id = $this->user->id;
            $user = $this->User->get($user_id);
            $user = $this->User->patchEntity($user, ['gender' => $gender]);
            if ($this->User->save($user)) {
                return $this->Util->ajaxReturn(['status' => true, 'msg' => '设置成功', 'redirect_url' => '/user/reg-user-info']);
            } else {
                return $this->Util->ajaxReturn(false, errorMsg($user, '服务器出错'));
            }
        }
    }

    /**
     * 注册填写用户信息页  头像上传
     */
    public function regUserInfo() {
        $this->handCheckLogin();
        $user = $this->user;
        if ($this->request->is('post')) {
            $res = $this->Util->uploadFiles('user/avatar');
            if ($res['status']) {
                $avatar = $res['info'][0]['path'];
                $user->avatar = $avatar;
                if ($this->User->save($user)) {
                    return $this->Util->ajaxReturn(true, '保存成功');
                }
            }
            return $this->Util->ajaxReturn(false, '保存失败');
        }
        $this->set([
            'pageTitle' => '美约-认证信息填写',
            'user' => $user
        ]);
    }

    /**
     * 注册填写用户信息页  头像上传
     */
    public function regBasicInfo() {
        $this->handCheckLogin();
        $user = $this->user;
        if ($this->request->is('post')) {
            $user = $this->User->get($user['id']);
            $user = $this->User->patchEntity($user, $this->request->data());
            if ($this->User->save($user)) {
                return $this->Util->ajaxReturn(true, '保存成功');
            } else {
                return $this->Util->ajaxReturn(false, '保存失败');
            }
        }
        $this->set([
            'pageTitle' => '美约-认证信息填写',
            'user' => $user
        ]);
    }

    /**
     * 审核认证
     */
    public function regAuth() {
        $this->handCheckLogin();
        $user = $this->user;
        if ($this->request->is('post')) {
            $res = $this->Util->uploadFiles('user/idcard');
            $data['user_id'] = $user->id;
            $AuthTable = \Cake\ORM\TableRegistry::get('UserAuth');
            if ($res['status']) {
                $infos = $res['info'];
                foreach ($infos as $key => $info) {
                    $data[$info['key']] = $info['path'];
                }
                $auth = $AuthTable->newEntity($data);
                if ($AuthTable->save($auth)) {
                    return $this->Util->ajaxReturn(true, '保存成功');
                }
            }
            return $this->Util->ajaxReturn(false, '保存失败');
        }
        $this->set([
            'pageTitle' => '美约-身份审核',
        ]);
    }
    
    
    /**
     * 基本照片和视频
     */
    public function regBasicPic(){
        
    }

    /**
     * 美约认证
     */
    public function regIdentify() {
        $this->set([
            'pageTitle' => '美约-美约认证'
        ]);
    }

    public function sendVcode() {
        $this->loadComponent('Sms');
        $mobile = $this->request->data('phone');
        $code = createRandomCode(4, 2); //创建随机验证码
        $content = '您的动态验证码为' . $code . ',请妥善保管，切勿泄露给他人，该验证码10分钟内有效';
        $codeTable = \Cake\ORM\TableRegistry::get('smsmsg');
        $vcode = $codeTable->find()->where("`phone` = '$mobile'")->orderDesc('create_time')->first();
        if (empty($vcode) || (time() - strtotime($vcode['time'])) > 30) {
            //30s 的间隔时间
            $ckSms = $this->Sms->sendByQf106($mobile, $content, $code);
            if ($ckSms) {
                return $this->Util->ajaxReturn(true, '发送成功');
            }
        } else {
            return $this->Util->ajaxReturn(false, '30秒后再发送');
        }
    }

    /**
     * 登出
     */
    public function loginOut() {
        $this->viewBuilder()->autoLayout(false);
        $this->request->session()->delete('User.mobile');
        $this->request->session()->destroy();
        return $this->redirect('/user/login?loginout=1');
    }

    /**
     * 用户信息页
     */
    public function userinfo() {
        
    }

    /**
     * 从微信端获取图片
     * @param type $id
     * @return type
     */
    public function getWxPic() {
        $this->loadComponent('Wx');
        $ids = $this->request->data('ids');
        $imgpaths = [];
        \Cake\Log\Log::notice($ids, 'devlog');
        foreach ($ids as $id) {
            $token = $this->Wx->getAccessToken();
            $url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=' . $token . '&media_id=' . $id;
            $httpClient = new \Cake\Network\Http\Client();
            $response = $httpClient->get($url);
            if ($response->isOk()) {
                $res = $response->body();
            }
            $today = date('Y-m-d');
            $path = 'upload/user/avatar/' . $today;
            $uniqid = uniqid();
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }
            \Intervention\Image\ImageManagerStatic::make($res)
                    ->save(WWW_ROOT . $path . '/' . $uniqid . '.jpg');
            $imgpath = '/' . $path . '/' . $uniqid . '.jpg';
            $imgpaths[] = $imgpath;
        }
        if ($res) {
            \Cake\Log\Log::notice($imgpaths, 'devlog');
            return $this->Util->ajaxReturn(['status' => true, 'msg' => '头像上传成功', 'path' => $imgpaths]);
        } else {
            return $this->Util->ajaxReturn(false, '头像上传失败');
        }
    }

}
