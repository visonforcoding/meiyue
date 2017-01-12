<?php

namespace App\Controller\Mobile;

use App\Controller\Mobile\AppController;
use App\Model\Table\FlowTable;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Database\Type\FloatType;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Cake\Controller\Controller;
use PackType;
use SerRight;
use ServiceType;
use UserStatus;

/**
 * User Controller
 *
 * @property \App\Model\Table\UserTable $User
 * @property \App\Controller\Component\BusinessComponent $Business
 * @property \App\Controller\Component\SmsComponent $Sms
 * @property \App\Controller\Component\NetimComponent $Netim
 */
class UserController extends AppController {

    /**
     * Index method
     *  个人中心首页
     * @return \Cake\Network\Response|null
     */
    public function index() {
//        $this->viewBuilder()->autoLayout(false);
//        return $this->render('test');
        if (!$this->request->is('lemon')) {
            //$this->handCheckLogin();
        }
        if (!$this->user) {
            $this->set([
                'pageTitle' => '登录'
            ]);
            return $this->render('nologin');
        }
        $template = 'index';
        $pack = null;
        if ($this->user->gender == 1) {
            $template = 'home_m';
            $packTb = TableRegistry::get('UserPackage');
            $pack = $packTb->find()->where([
                'OR' => [
                    'rest_chat >' => 0,
                    'rest_browse >' =>0
                ],
                'deadline >=' => new Time()
            ])->orderDesc('cost')->first();
        }
        $fanTb = TableRegistry::get('UserFans');
        $fans = $fanTb->find()->where(['following_id' => $this->user->id])->count();
        $followers = $fanTb->find()->where(['user_id' => $this->user->id])->count();

        $this->set([
            'facount' => $fans,
            'focount' => $followers,
            'pack' => $pack
        ]);
        $this->set([
            'pageTitle' => '美约-我的',
            'user' => $this->user
        ]);
        $this->render($template);
    }


    public function login() {
        $redirect_url = empty($this->request->query('redirect_url')) ? '/index/index' : $this->request->query('redirect_url');
        if (in_array($redirect_url, ['/home/my-install', '/user/login', '/user/index'])) {
            $redirect_url = '/index/index';
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
                    if($user->reg_step!=9){
                        //注册未完成
                        return $this->Util->ajaxReturn(['status'=>false,'msg'=>'注册未完成,请继续注册步骤',
                            'code'=>201,'redirect_url'=>'/user/reg-basic-info-'.$user->reg_step.'/'.$user->id]);
                    }
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
                    if($this->request->is('weixin')&&$user->gender==2){
                        //女性不让登录微信
                         return $this->Util->ajaxReturn(['status' => false, 'msg' => '女性用户请在APP端登录']);
                    }
                    $data['login_time'] = date('Y-m-d H:i:s');
                    if ($coord) {
                        $data['login_coord'] = $coord;
                    }
                    $user = $this->User->patchEntity($user, $data);
                    $this->User->save($user);
                    if (($redirect_url == '/index/index' || $redirect_url == '/') && $user->gender == '2') {
                        //女性用户首页
                        $redirect_url = '/index/find-rich-list';
                    }
                    return $this->Util->ajaxReturn(['status' => true, 'redirect_url' => $redirect_url,
                                'user'=>$user,
                                'token_uin' => $user_token, 'bind_wx' => $bind_wx, 'msg' => '登入成功']);
                }
            } else {
                return $this->Util->ajaxReturn(['status' => false, 'msg' => '请输入手机号']);
            }
        }

        $this->set([
            'pageTitle' => '美约-登录',
            'invite_code' => $this->request->query('ivc')
        ]);
    }

    /**
     * 用户注册
     */
    public function register() {
        $gender = $this->request->query('gender') ? $this->request->query('gender') : 1;
        if ($this->request->is('ajax')) {
            //验证验证码
            $data = $this->request->data();
            $data['gender'] = $gender;
            $SmsTable = \Cake\ORM\TableRegistry::get('Smsmsg');
            $sms = $SmsTable->find()->where(['phone'])->orderDesc('create_time')->first();
            //验证码验证
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
            //默认昵称
            $counts = $this->User->find()->count();
            $nickname = '美约'.  str_pad($counts,6, 0,STR_PAD_LEFT);
            $user->nick = $nickname;
            $user->truename = $nickname;
            //默认头像
            $user->avatar = '/mobile/images/m_avatar_2.png';
            //定位记录
            $coord = $this->getPosition();
            if($coord){
                $user->login_coord_lng = $coord[0];
                $user->login_coord_lat = $coord[1];
            }
            //从im 池中获取im 账号绑定
            $this->loadComponent('Business');
            $im = $this->Business->getNetim();
            if ($im) {
                $user->imaccid = $im['accid'];
                $user->imtoken = $im['token'];
            }
            //登录时间
            $user->login_time = date('Y-m-d H:i:s');
            $user = $this->User->patchEntity($user, $data);
            if($this->request->query('gender')==1){
                //男性则直接登录
                $user->reg_step = 9;  //注册完毕
                $user->status = 0;
                $user->is_agent = 1;  //默认不是经纪人
            }else{
                $user->reg_step = 1;
                $user->status = 1;
                $user->is_agent = 1; //默认是经纪人
            }
            if ($this->User->save($user)) {
                if($data['incode']) {
                    $this->loadComponent('Business');
                    $this->Business->create2Invit($data['incode'], $user->id);
                }
                $jumpUrl = '/user/m-reg-basic-info';
                if ($user->gender == 2) {
                    $jumpUrl = '/user/reg-basic-info-1/'.$user->id;
                }
                $msg = '注册成功';
                $this->user = $user;
                $user_token = false;
                if($this->request->query('gender')==1){
                    //男性则直接登录
                    $this->request->session()->write('User.mobile', $user);
                    $is_login = true;
                    if ($this->request->is('lemon')) {
                        $this->request->session()->write('Login.login_token', $user->user_token);
                        $user_token = $user->user_token;
                    }
                    unset($user->pwd);
                    $user->avatar = $this->Util->getServerDomain().$user->avatar;
                }else{
                    $is_login = false;
                    $user = false;
                }
                return $this->Util->ajaxReturn([
                          'status' => true, 
                          'msg' => $msg, 
                          'url' => $jumpUrl,
                          'user'=>$user,
                          'is_login'=>$is_login
                    ]);
            } else {
                \Cake\Log\Log::error($user->errors());
                return $this->Util->ajaxReturn(['status' => false, 'msg' => getMessage($user->errors())]);
            }
        }
        if($this->request->is('weixin')){
            
        }
        $this->set([
            'gender' => $gender,
            'pageTitle' => '美约-注册'
        ]);
    }
    
 
    public function mRegBasicInfo(){
        $user = $this->user;
        if ($this->request->is('post')) {
            $user = $this->User->get($user['id']);
            $data = $this->request->data();
            $user = $this->User->patchEntity($user, $data);
            if ($this->User->save($user)) {
                return $this->Util->ajaxReturn(true, '保存成功');
            } else {
                return $this->Util->ajaxReturn(false, '保存失败');
            }
        }
          $this->set([
            'pageTitle' => '美约-基本信息填写'
        ]);
    }

    /**
     * 女性注册第一步
     */
    public function regBasicInfo1($id) {
        $user = $this->User->get($id);
        if ($this->request->is('post')) {
            $user = $this->User->get($user['id']);
            $data = $this->request->data();
            $data['bwh'] =  $data['bwh_b'].'/'.$data['bwh_w'].'/'.$data['bwh_h'];
            $data['hometown'] = getCity($data['hometown']);
            $data['city'] = getCity($data['city']);
            $user = $this->User->patchEntity($user, $data);
            $user->reg_step = 2;
            if ($this->User->save($user)) {
                $this->loadComponent('Netim');
                $this->Netim->addUpInfoQueue($user->id);
                return $this->Util->ajaxReturn(true, '保存成功');
            } else {
                return $this->Util->ajaxReturn(false, '保存失败');
            }
        }
        $this->set([
            'user'=>$user,
            'pageTitle' => '美约-基本信息填写'
        ]);
    }

    /**
     * 女性注册第二步
     */
    public function regBasicInfo2($id) {
        $user = $this->User->get($id);
        if ($this->request->is('post')) {
            $user = $this->User->get($user->id);
            $user = $this->User->patchEntity($user, $this->request->data());
            $user->reg_step = 3;
            $user->auth_status = 1;
            if ($this->User->save($user)) {
                return $this->Util->ajaxReturn(true, '保存成功');
            }
            return $this->Util->ajaxReturn(false, '保存失败');
        }
        $this->set([
            'user'=>$user,
            'pageTitle' => '真人视频认证'
        ]);
    }

    
    
    /**
     * 女性注册第三步
     */
    public function regBasicInfo3($id) {
        $user = $this->User->get($id);
        $this->set([
            'user'=>$user,
            'pageTitle' => '美约-基本图片上传'
        ]);
    }
    
    public function wRegLogin($id){
        $user = $this->User->get($id);
        $user->reg_step = 9;
        if($this->User->save($user)){
            return $this->Util->ajaxReturn(['status'=>true, 'msg'=>'保存成功','user'=>$user]);
        }
        return $this->Util->ajaxReturn(false, '保存失败');
    }

    /**
     * 女性注册第四步
     */
    public function regBasicInfo4() {
        $user = $this->user;
        if ($this->request->is('post')) {
            $user = $this->User->get($user->id);
            $user = $this->User->patchEntity($user, $this->request->data());
            if ($this->User->save($user)) {
                return $this->Util->ajaxReturn(true, '保存成功');
            }
            return $this->Util->ajaxReturn(false, '保存失败');
        }
        $this->set([
            'pageTitle' => '美约-完善信息'
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
            $this->loadComponent('Business');
            $im = $this->Business->getNetim();
            if ($im) {
                $user->imaccid = $im['accid'];
                $user->imtoken = $im['token'];
            }
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
            $avatar = $this->request->data('avatar');
            $user->avatar = $avatar;
            if ($this->User->save($user)) {
                $this->loadComponent('Netim');
                $this->Netim->addUpInfoQueue($user->id);
                return $this->Util->ajaxReturn(['status' => true, 'msg' => '保存成功', 'realUrl' => $this->Util->getServerDomain().$avatar]);
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
            $user = $this->User->get($user->id);
            $user = $this->User->patchEntity($user, $this->request->data());
            $user->id_status = UserStatus::CHECKING;
            if ($this->User->save($user)) {
                return $this->Util->ajaxReturn(true, '保存成功');
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
    public function regBasicPic() {
        $this->handCheckLogin();
        $user = $this->user;
        if ($this->request->is('post')) {
            $res = $this->Util->uploadFiles('user/idcard');
            $images = [];
            if ($res['status']) {
                $infos = $res['info'];
                foreach ($infos as $key => $info) {
                    if ($info['key'] == 'video') {
                        $data['video'] = $info['path'];
                    }
                    if (preg_match('/image_.*/', $info['key'])) {
                        $images[] = $info['path'];
                    }
                }
                $user->images = json_encode($images);
                if ($this->User->save($auth)) {
                    return $this->Util->ajaxReturn(true, '保存成功');
                }
            }
            return $this->Util->ajaxReturn(false, '保存失败');
        }
        $this->set([
            'pageTitle' => '美约-身份审核',
            'user' => $user
        ]);
    }

    /**
     * 美约认证
     */
    public function regIdentify() {
        $this->set([
            'pageTitle' => '美约-美约认证'
        ]);
    }

    /**
     * 
     * @param type $type  验证码类型
     * @return type
     */
    public function sendVcode($type = null) {
        $this->loadComponent('Sms');
        $mobile = $this->request->data('phone');
        if ($type == 1) {   //注册验证码
            $ckReg = $this->User->find()->where(['phone' => $mobile])->first();
            if ($ckReg) {
                return $this->Util->ajaxReturn(['status' => false,
                    'msg' => '该手机号已经注册过,请直接登录', 'code' => '201'
                ]);
            }
        } else if($type == 2) {
            $ckReg = $this->User->find()->where(['phone' => $mobile])->first();
            if ($ckReg) {
                return $this->Util->ajaxReturn([
                    'status' => false,
                    'msg' => '该手机号已经绑定过'
                ]);
            }
        }
        $code = createRandomCode(4, 2); //创建随机验证码
        $content = '您的动态验证码为' . $code . ',请妥善保管，切勿泄露给他人，该验证码10分钟内有效';
        $codeTable = \Cake\ORM\TableRegistry::get('smsmsg');
        $vcode = $codeTable->find()->where("`phone` = '$mobile'")->orderDesc('create_time')->first();
        if (empty($vcode) || (time() - strtotime($vcode['time'])) > 30) {
            //30s 的间隔时间
            $ckSms = $this->Sms->send($mobile, $content, $code);
            if ($ckSms) {
                return $this->Util->ajaxReturn(true, '发送成功');
            }else{
                return $this->Util->ajaxReturn(false,'服务器开了小差');
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

    /**
     * 加关注
     */
    public function follow() {
        $this->handCheckLogin();
        if ($this->request->is('post')) {
            $following_id = $this->request->data('id');
            $user_id = $this->user->id;
            if ($following_id == $user_id) {
                return $this->Util->ajaxReturn(false, '不可关注自己');
            }
            $follower = $this->User->find()->select(['id', 'gender'])->where(['id' => $following_id])->first();
            if (!$follower) {
                return $this->Util->ajaxReturn(false, '您所关注的用户不存在');
            }
            if ($this->user->gender == $follower->gender) {
                if ($this->user == '1') {
                    return $this->Util->ajaxReturn(false, '男性只可关注女性');
                } else {
                    return $this->Util->ajaxReturn(false, '女性只可关注男性');
                }
            }
            $FansTable = \Cake\ORM\TableRegistry::get('UserFans');
            //判断是否关注过
            $fans = $FansTable->find()->where("`user_id` = '$user_id' and `following_id` = '$following_id'")->first();
            if ($fans) {
                //查看是否被该用户关注过 关注过则为取消关注操作
                $follower = $FansTable->find()->where("`user_id` = '$following_id' and `following_id` = '$user_id'")->first();
                if ($follower) {
                    //有被关注，改变互相关注状态
                    $follower->type = 1;
                    $transRes = $FansTable->connection()
                            ->transactional(function()use($FansTable, $follower, $fans) {
                        //开启事务
                        return $FansTable->delete($fans) && $FansTable->save($follower);
                    });
                } else {
                    $transRes = $FansTable->delete($fans);
                }
                if (!$transRes) {
                    return $this->Util->ajaxReturn(false, '取消关注失败');
                } else {
                    return $this->Util->ajaxReturn(['status'=>true, 'msg'=>'取消关注成功','action'=>'unfocus']);
                }
            } else {
                //查看是否被该用户关注过
                $follower = $FansTable->find()->where("`user_id` = '$following_id' and `following_id` = '$user_id'")->first();
                $newfans = $FansTable->newEntity();
                $newfans->user_id = $user_id;
                $newfans->following_id = $following_id;
                if ($follower) {
                    //有被关注
                    $follower->type = 2;  //关系标注为互为关注
                    $newfans->type = 2;
                    $transRes = $FansTable->connection()
                            ->transactional(function()use($FansTable, $follower, $newfans) {
                        //开启事务
                        return $FansTable->save($newfans) && $FansTable->save($follower);
                    });
                    if (!$transRes) {
                        return $this->Util->ajaxReturn(false, '关注失败');
                    }
                } else {
                    $newfans->type = 1;
                    if (!$FansTable->save($newfans)) {
                        return $this->Util->ajaxReturn(['status'=>false, 'msg'=>'关注失败']);
                    }
                }
                //发送一条关注消息给被关注者
                //$this->loadComponent('Business');
                //$this->Business->usermsg($this->user->id, $following_id, '您有新的关注者', '', 1, $newfans->id);
                //更新被关注者粉丝数  列表方便显示
                //$follower_user = $this->User->get($following_id);
                //$fansCount = $FansTable->find()->where("`following_id` = '$following_id'")->count();
                //$follower_user->fans = $fansCount;
                //$this->User->save($follower_user);
                //$me = $this->User->get($user_id);
                //$followCount = $FansTable->find()->where(['user_id' => $user_id])->count();
                //$me->focus_nums = $followCount;
                //$this->User->save($me);
                return $this->Util->ajaxReturn(['status'=>true, 'msg'=>'关注成功','action'=>'focus']);
            }
        }
    }

    /**
     * 评选
     */
    public function voted($id = null) {
        $this->handCheckLogin();
        $this->loadComponent('Business');
        $title = '我的评选';
        $isme = true;
        if ($id) {
            $title = '她的评选';
            $isme = false;
        } else {
            $id = $this->user->id;
        }
        $wektop = $this->Business->getMyTop('week', $id);
        $montop = $this->Business->getMyTop('month', $id);
        $this->set([
            'isme' => $isme,
            'user' => $this->user,
            'herid' => $id,
            'wektop' => $wektop,
            'montop' => $montop,
            'pageTitle' => $title
        ]);
    }

    /**
     * 我的评选-谁支持我
     * @param $id
     */
    public function support() {
        $this->handCheckLogin();
        $spTb = TableRegistry::get('Support');
        $supports = $spTb
                ->find()
                ->select(['supporter_id', 'spcount' => 'count(1)'])
                ->where(['supported_id' => $this->user->id])
                ->orderDesc('create_time')
                ->group('supporter_id')
                ->toArray();
        $supporterids = [];
        $sortFlows = [];
        foreach ($supports as $item) {
            $supporterids[] = $item->supporter_id;
        }
        if (count($supporterids) > 0) {
            $flowsTb = TableRegistry::get('Flow');
            $flows = $flowsTb
                    ->find()
                    ->contain([
                        'Buyer' => function($q) {
                            return $q->select(['id', 'avatar', 'nick', 'phone', 'gender', 'birthday']);
                        }])
                    ->select(['total' => 'sum(amount)'])
                    ->where(['buyer_id IN' => $supporterids, 'type' => 14])
                    ->group('buyer_id')
                    ->toArray();
            foreach ($flows as $item) {
                $sortFlows[$item->buyer->id] = $item;
            }
        }
        $this->set([
            'supports' => $supports,
            'flows' => $sortFlows,
            'pageTitle' => '支持我的人'
        ]);
    }

    /**
     * ajax 检测登陆
     */
    public function clogin() {
        $this->handCheckLogin();
        return $this->Util->ajaxReturn(true);
    }

    public function forget() {
        $this->set([
            'pageTitle' => '忘记密码'
        ]);
    }


    /**
     * 男性
     */
    public function maleHomepage($uid)
    {
        $user = $this->User->find()
            ->contain([
                'Fans',
                'Follows',
                'Upacks' => function($q) {
                    return $q->orderDesc('create_time')->limit(1);
                },
            ])
            ->where(['id' => $uid])
            ->map(function($row) {
                if(count($row['upacks'])) {
                    $row->upakname = $row['upacks'][0]['title'];
                }
                $row->facount = count($row->fans);
                $row->focount = count($row->follows);
                return $row;
            })
            ->first();

        //访客数统计
        if(isset($this->user)) {
            if($this->user->gender == 2) {
                $visitorTb = TableRegistry::get("Visitor");
                $visitor = $visitorTb->find()->where(['visitor_id' => $this->user->id, 'visited_id' => $uid])->first();
                $userdirty = false; //更新用户信息标志
                if(!$visitor) {
                    $visitor = $visitorTb->newEntity([
                        'visitor_id' => $this->user->id,
                        'visited_id' => $uid,
                    ]);
                    $user->visitnum ++;
                    $userdirty = true;
                }
                $UserTable = $this->User;
                $res = $visitorTb->connection()->transactional(function() use ($userdirty, $visitorTb, $visitor, $UserTable, $user){
                    $vres = $visitorTb->save($visitor);
                    $ures = true;
                    if($userdirty) {
                        $ures = $UserTable->save($user);
                    }
                    return $vres&&$ures;
                });
            }
        }

        $this->set([
            'user' => $user,
            'pageTitle' => '个人主页'
        ]);
    }


    public function usedPack()
    {
        $this->set([
            'pageTitle' => '付费查看记录'
        ]);
    }


    /**
     * 获取付费记录
     */
    public function getUsedPacks($page = 1)
    {
        $this->handCheckLogin();
        $query = $this->request->query('query');
        $where = ['user_id' => $this->user->id];
        $contain = ['Used' => function($q) {
            return $q->select(['id', 'nick', 'gender', 'birthday', 'avatar']);
        }];
        $limit = 10;
        switch ($query) {
            case 1:
                $where = array_merge($where, ['type' => 1]);
                break;
            case 2:
                $where = array_merge($where, ['type'=> 2]);
                break;
            default:
                break;
        }
        $tb = TableRegistry::get('UsedPackage');
        $ups = $tb->find()
            ->contain($contain)
            ->where($where)
            ->orderDesc('UsedPackage.create_time')
            ->limit($limit)
            ->page($page)
            ->map(function($row) {
                $row->used->age = getAge($row->used->birthday);
                $row->deadline = getYMD($row->deadline);
                return $row;
            });

        return $this->Util->ajaxReturn(['datas' => $ups->toArray(), 'status' => true]);
    }


    /**
     * 忘记密码步骤1
     */
    public function forgetPwd1()
    {
        $data = $this->request->data();
        if($this->request->is("ajax") && $data['phone']) {
            //验证是否注册
            $user = $this->User->find()->where(['phone' => $data['phone']])->count();
            if(!$user) {
                $jumpUrl = '/user/login';
                return $this->Util->ajaxReturn(['status' => true , 'msg' => '用户不存在', 'url' => $jumpUrl]);
            }
            //验证验证码
            $SmsTable = TableRegistry::get('Smsmsg');
            $sms = $SmsTable->find()->where(['phone' => $data['phone']])->orderDesc('create_time')->first();
            if (!$sms) {
                return $this->Util->ajaxReturn(['status' => false, 'msg' => '验证码错误']);
            } else {
                if ($sms->code != $data['vcode']) {
                    return $this->Util->ajaxReturn(['status' => false, 'msg' => '验证码错误']);
                }
                if ($sms->expire_time < time()) {
                    return $this->Util->ajaxReturn(['status' => false, 'msg' => '验证码已过期']);
                }
            }
            $this->request->session()->write('PASS_VCODE_PHONE', $data['phone']);
            $jumpUrl = '/user/forget-pwd2/';
            return $this->Util->ajaxReturn(['status' => true, 'msg' => '验证成功', 'url' => $jumpUrl]);
        }
        $this->set([
            'user' => $this->user,
            'pageTitle'=>'忘记密码'
        ]);
    }

    /**
     * 忘记密码步骤2
     */
    public function forgetPwd2()
    {
        $phone = $this->request->session()->read('PASS_VCODE_PHONE');
        if($this->request->is('POST') && $phone) {
            $data = $this->request->data();
            $pwd1 = $data['newpwd1'];
            $pwd2 = $data['newpwd2'];
            if($pwd1 && $pwd2 && ($pwd1 == $pwd2)) {
                $query = $this->User->query();
                $res = $query->update()
                    ->set(['pwd' => (new DefaultPasswordHasher)->hash($pwd1)])
                    ->where(['phone' => $phone])
                    ->execute();
                $jumpUrl = '/user/login';
                if($res) {
                    return $this->Util->ajaxReturn(['status' => true, 'msg' => '密码重置成功', 'url' => $jumpUrl]);
                } else {
                    return $this->Util->ajaxReturn(false, '密码重置失败');
                }
            } else {
                return $this->Util->ajaxReturn(false, '密码有误');
            }
        }
        $this->set([
            'pageTitle'=>'忘记密码'
        ]);
    }


    /**
     * 分享
     */
    public function share()
    {
        if($this->user) {
            if(!$this->user->invit_code) {
                $this->loadComponent('Business');
                $this->user->invit_code = $this->Business->createInviteCode($this->user->id);
                $this->User->save($this->user);
            }
            /*$invsTb = TableRegistry::get('Inviter');
            $invs = $invsTb->find()->where(['inviter_id' => $this->user->id, 'status' => 1])->count();
            if($invs) {
                $this->user->has_invs = true;
            } else {
                $this->user->has_invs = false;
            }*/
        }
        $this->set([
            'user' => $this->user,
            'pageTitle'=>'成为美约合伙人'
        ]);
    }


    /**
     * 已邀请到的人
     */
    public function shareList() {
        $this->handCheckLogin();
        $flowTb = TableRegistry::get('Flow');
        $flows = $flowTb->find()->select(['total' => 'sum(amount)'])->where(['user_id' => $this->user->id, 'type IN' => [19, 20]]);
        $invitTable = TableRegistry::get('Inviter');
        $invitcount = $invitTable->find()->where(['inviter_id' => $this->user->id])->count();
        $total = $flows->first()->total;
        $this->set([
            'user' => $this->user,
            'total' => $total,
            'count' => $invitcount,
            'pageTitle'=>'已成功邀请的人'
        ]);
    }


    /**
     * 我的-我的派对-分页获取我的派对列表
     */
    public function getInvits($page) {
        $this->handCheckLogin();
        $invitTable = TableRegistry::get('Inviter');
        $limit = 10;
        $datas = $invitTable->find()
            ->contain([
                'Invited' => function($q) {
                    return $q->select(['id', 'avatar', 'nick', 'gender', 'recharge', 'charm']);
                },
            ])
            ->where(['inviter_id' => $this->user->id])
            ->limit($limit)
            ->page($page)
            ->map(function($row) {
                return $row;
            });
        return $this->Util->ajaxReturn(['datas'=>$datas]);

    }


    /**
     * 检查私聊权限
     * @param $uid
     * @return \Cake\Network\Response|null
     */
    public function checkChat($uid)
    {
        $this->handCheckLogin();
        if($this->request->is('POST')) {
            $this->loadComponent('Business');
            //检查权限和名额剩余
            $res = $this->Business->checkRight($this->user->id, $uid, ServiceType::CHAT);
            $accid = '';
            if($res == SerRight::OK_CONSUMED) {
                $user = $this->User->get($uid);
                $accid = $user->imaccid;
            }
            return $this->Util->ajaxReturn(['right' => $res, 'accid' => $accid]);
        }
    }

    /**
     * 私聊
     */
    public function consumeChat($uid)
    {
        $this->handCheckLogin();
        $this->loadComponent('Business');
        //检查权限和名额剩余
        $res = $this->Business->consumeRight($this->user->id, $uid, ServiceType::CHAT);
        if($res) {
            $user = $this->User->get($uid);
            $accid = $user->imaccid;
            return $this->Util->ajaxReturn(['status' => $res, 'msg' => '操作成功', 'accid' => $accid]);
        }
        return $this->Util->ajaxReturn(['status' => $res, 'msg' => '操作失败']);
    }


    /**
     * 清除基本视频与图片字段
     */
    public function clearBasicPv()
    {
        $this->handCheckLogin();
        if($this->request->is('POST')) {
            $res = $this->User->query()->update()->set(['images' => '', 'video' => ''])->where(['id' => $this->user->id])->execute();
            if($res) {
                return $this->Util->ajaxReturn(['status' => true, 'msg' => '操作成功']);
            } else {
                return $this->Util->ajaxReturn(['status' => false, 'msg' => '操作失败']);
            }
        }
        return $this->Util->ajaxReturn(['status' => false, 'msg' => '操作失败']);
    }


    /**
     * 申请成为经纪人
     */
    public function want2bAgent()
    {
        $this->handCheckLogin();
        if($this->request->is('POST')) {
            if($this->user->is_agent == 1) {
                return $this->Util->ajaxReturn(['status' => false, 'msg' => '你已经是经纪人,无需申请']);
            }
            if($this->user->is_agent == 3) {
                return $this->Util->ajaxReturn(['status' => false, 'msg' => '已经申请过，无需重复申请']);
            }
            $res = $this->User->query()->update()->set(['is_agent' => 3])->where(['id' => $this->user->id])->execute();
            if($res) {
                return $this->Util->ajaxReturn(['status' => true, 'msg' => '申请成功']);
            } else {
                return $this->Util->ajaxReturn(['status' => false, 'msg' => '申请失败']);
            }
        }
    }


    /**
     * 查看我的个人主页
     */
    public function MyHomepage($uid)
    {
        $user = $this->User->find()
            ->contain([
                'UserSkills' => function($q) {
                    return $q->where(['is_used' => 1, 'is_checked' => 1]);
                },
                'UserSkills.Skill',
                'UserSkills.Cost',
                'Fans',
                'Dates' => function($q) {
                    return $q->where(['status IN' => [1, 2], 'end_time >' => new Time()]);
                },
                'Actreg.Activity' => function($q) {
                    return $q->where(['Actreg.status' => 1, 'Activity.end_time >' => new Time()]);
                },
                'Follows',
                'Upacks' => function($q) {
                    return $q->where([
                        'OR' => [
                            'rest_chat >' => 0,
                            'rest_browse >' =>0
                        ],
                        'deadline >=' => new Time()
                    ])->orderDesc('cost')->limit(1);
                },
                'Tags' => function($q) {
                    return $q->select(['name'])->where(['parent_id !=' => 0]);
                }
            ])
            ->where(['id' => $uid])
            ->map(function($row) {
                $row->age = getAge($row->birthday);
                $row->birthday = getMD($row->birthday);
                $row->hasjoin = false;
                if(count($row->dates) || count($row->actreg)) {
                    $row->hasjoin = true;
                }
                if(count($row['upacks'])) {
                    $row->upakname = $row['upacks'][0]['title'];
                }
                $row['upackname'] = null;
                if(count($row['upacks'])) {
                    $upk = $row['upacks'][0];
                    $row['upackname'] = $upk->honour_name;
                }
                $row['upacks'] = [];
                $row->facount = count($row->fans);
                $row->focount = count($row->follows);
                return $row;
            })
            ->first();

        $title = '预览TA的主页';
        if($user->id == $uid) {
            $title = '预览我的主页';
        }
        $this->set([
            'pageTitle' => $title,
            'user' => $user,
        ]);
        if($this->user->gender == 2) {
            $this->render('/Mobile/User/my_fhomepage');
        }
    }

}
        