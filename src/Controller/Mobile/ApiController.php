<?php

namespace App\Controller\Mobile;

use App\Controller\Mobile\AppController;
use Wpadmin\Utils\UploadFile;

/**
 * Api Controller  用于app接口
 *
 * @property \App\Model\Table\ApiTable $Api
 * @property \App\Controller\Component\WxComponent $Wx
 * @property \App\Controller\Component\EncryptComponent $Encrypt
 * @property \App\Controller\Component\UtilComponent $Util
 *
 */
class ApiController extends AppController {

    const TOKEN = '64e3f4e947776b2d6a61ffbf8ad05df4';

    protected $noAcl = [
        'upload', 'wxtoken', 'ckregister', 'recordphone', 'saveuserbasicpic',
        'saveuserbasicvideo', 'getmapusers', 'gettoken'
    ];

    public function initialize() {
        parent::initialize();
        $this->autoRender = false;
    }

    public function beforeFilter(\Cake\Event\Event $event) {
        parent::beforeFilter($event);
        return $this->checkAcl();
    }

    protected function jsonResponse($status, $msg = '', $statusCode = 200) {
        $this->autoRender = false;
        $this->response->type('json');
        if (is_array($status) && !empty($status)) {
            if (!array_key_exists('code', $status)) {
                $status['code'] = 200;
            }
            $json = json_encode($status, JSON_UNESCAPED_UNICODE);
        } else {
            $json = json_encode(array('status' => $status, 'msg' => $msg, 'code' => $statusCode), JSON_UNESCAPED_UNICODE);
        }
        echo $json;
        exit();
    }

    protected function checkAcl() {
        //\Cake\Log\Log::debug('接口debug', 'devlog');
        //\Cake\Log\Log::debug($this->request->data(), 'devlog');
        if (!$this->request->isPost()) {
            return $this->jsonResponse(false, '请求受限', 405);
        }
        if (!in_array(strtolower($this->request->param('action')), $this->noAcl)) {
            if (!$this->request->data('timestamp') || !$this->request->data('access_token')) {
                return $this->jsonResponse(false, '参数不正确', 412);
            }
            if (!$this->checkSign($this->request->data())) {
                return $this->jsonResponse(false, '验证不通过', 401);
            }
        } else {
            return $this->baseCheckAcl();
        }
    }

    protected function baseCheckAcl() {
        //\Cake\Log\Log::debug('接口debug', 'devlog');
        //\Cake\Log\Log::debug($this->request->data(), 'devlog');
        $timestamp = $this->request->data('timestamp');
        $access_token = $this->request->data('access_token');
        if (!$timestamp || !$access_token) {
            return $this->jsonResponse(false, '参数不正确', 412);
        }
        $timediff = time() - $timestamp;
        if ($timediff > 30 * 60) {
            return $this->jsonResponse(false, '时间参数过期', 408);
        }
        $sign = strtoupper(md5($timestamp . self::TOKEN));
        \Cake\Log\Log::debug($sign);
        if ($sign != $access_token) {
            return $this->jsonResponse(false, '验证不通过', 401);
        }
    }

    /**
     *  生成签名
     * @param type $params
     * @return type
     */
    protected function setSign($params) {
        ksort($params);
        $stringA = urldecode(http_build_query($params)); //不要转义的
        $stringB = $stringA . '&key=' . self::TOKEN;
        $sign = strtoupper(md5($stringB));
        return $sign;
    }

    protected function baseSign($time) {
        return strtoupper(md5($time . self::TOKEN));
    }

    public function test() {
        $this->jsonResponse(['access_token' => $this->setSign($this->request->data())]);
    }

    public function baseTest() {
        $time = time();
        return $this->jsonResponse(['access_token' => $this->baseSign($time), 'time' => $time]);
    }

    /**
     *  验证签名
     * @param type $params
     * @return type
     */
    protected function checkSign($params) {
        $access_token = $params['access_token'];
        unset($params['access_token']);
        ksort($params);
        $stringA = urldecode(http_build_query($params)); //不要转义的
        $stringB = $stringA . '&key=' . self::TOKEN;
        $sign = strtoupper(md5($stringB));
        return $access_token == $sign;
    }

    /**
     * 上传接口
     * @return type
     */
    public function upload() {
        $this->autoRender = false;
        $dir = 'tmp';
        $extra_data = $this->request->data('extra_param');
        $extra_data_json = json_decode($extra_data);
        //\Cake\Log\Log::debug($extra_data_json, 'devlog');
        if (is_object($extra_data_json)) {
            if (isset($extra_data_json->dir)) {
                $dir = $extra_data_json->dir;
            }
        }
        //\Cake\Log\Log::debug($this->request->data(), 'devlog');
        $res = $this->Util->uploadFiles($dir);
        if ($res) {// 上传错误提示错误信息
            $response['status'] = true;
            $response['msg'] = $res['msg'];
            $response['path'] = $res['info'][0]['path'];
            $response['urlpath'] = $this->Util->getServerDomain() . $res['info'][0]['path'];
        } else {// 上传成功 获取上传文件信息
            $response['status'] = false;
            $response['msg'] = $res['msg'];
        }
        return $this->jsonResponse($response);
    }

    /**
     * 中控的access_token 分发接口
     * @return string
     */
    public function wxtoken() {
        $wxconfig = \Cake\Core\Configure::read('weixin');
        $master_ip = $wxconfig['master_ip'];
        $master_domain = $wxconfig['master_domain'];
        if ($this->request->env('SERVER_ADDR') != $master_ip ||
                $this->request->env('SERVER_NAME') != $master_domain) {
            //非中控服务器请求 保证中控服务器才能进行本地的获取 
            \Cake\Log\Log::notice('非中控请求调取接口', 'devlog');
            return 'false';
        }
        $this->loadComponent('Wx');
        $this->loadComponent('Encrypt');
        $token = $this->Wx->getAccessToken();
        \Cake\Log\Log::debug('中控服务器获取token', 'devlog');
        \Cake\Log\Log::debug($token, 'devlog');
        $en_token = $this->Encrypt->encrypt($token);
        \Cake\Log\Log::debug($en_token, 'devlog');
        \Cake\Log\Log::debug($this->Encrypt->decrypt($en_token), 'devlog');
        $this->response->body($en_token);
        $this->response->send();
        $this->response->stop();
    }

    /**
     * 检测通讯录中的手机号是否注册
     */
    public function ckRegister() {
        $user_token = $this->request->data('user_token');
        $phones = $this->request->data('phones');
        $phones_arr = explode('|', $phones);
        //从redis中获取数据 集合
        $redis = new \Redis();
        $redis_conf = \Cake\Core\Configure::read('redis_server');
        $redis->connect($redis_conf['host'], $redis_conf['port']);
        $members = $redis->sGetMembers('phones');
        $register_phones = array_intersect($phones_arr, $members);
        $register_phones = array_values($register_phones);
        if ($register_phones) {
            $status = true;
        } else {
            $status = false;
        }
        $PhonelogTable = \Cake\ORM\TableRegistry::get('Phonelog');
        $phonelog = $PhonelogTable->find()->where(['user_token' => $user_token, 'type' => 1])->first();
        if (!$phonelog) {
            //只第一次存储
            $log = $PhonelogTable->newEntity([
                'user_token' => $user_token,
                'type' => 1,
                'phones' => $phones,
                'create_time' => date('Y-m-d H:i:s')
            ]);
            $PhonelogTable->save($log);
        }
        $this->jsonResponse([
            'status' => $status,
            'results' => [
                'phones' => $register_phones
            ]
        ]);
    }

    /**
     * 记录发送的手机号
     */
    public function recordPhone() {
        $user_token = $this->request->data('user_token');
        $phones = $this->request->data('phones');
        $PhonelogTable = \Cake\ORM\TableRegistry::get('Phonelog');
        $log = $PhonelogTable->newEntity([
            'user_token' => $user_token,
            'type' => 2,
            'phones' => $phones,
            'create_time' => date('Y-m-d H:i:s')
        ]);
        if ($PhonelogTable->save($log)) {
            $this->jsonResponse(true, 'ok');
        } else {
            $this->jsonResponse(false, 'fail');
        }
    }

    /**
     * 保存用户基本图片
     */
    public function saveUserBasicPic() {
        set_time_limit(0);
        $data = $this->request->data();
        $user_id = $this->request->data('user_id');
        $param = $this->request->data('param');
        $UserTable = \Cake\ORM\TableRegistry::get('User');
        $user = $UserTable->get($user_id);
        if (!$user_id || !$user) {
            $this->jsonResponse(false, '身份认证失败');
        }
        $res = $this->Util->uploadFiles('user/images');
        $images = [];

        if ($res['status']) {
            $infos = $res['info'];
            foreach ($infos as $key => $info) {
                $images[] = $info['path'];
            }
            if ($param) {
                $param = json_decode($param);
                if(!$param){
                    $this->jsonResponse(false, '参数不正确');
                }
                if (property_exists($param, 'action')) {
                    if ($param->action == 'add_tracle_pic') {
                        //处理发图片动态
                        $tracle_type = 1;
                        $MovementTable = \Cake\ORM\TableRegistry::get('Movement');
                        $movement = $MovementTable->newEntity([
                            'user_id' => $user_id,
                            'images' => serialize($images),
                            'body' => $param->tracle_body,
                            'type' => $tracle_type
                        ]);
                        if ($MovementTable->save($movement)) {
                            $this->jsonResponse(true, '保存成功');
                        } else {
                            $this->jsonResponse(true, $movement->errors());
                            dblog('movement', '动态保存失败', $movement->errors());
                        }
                    }
                    if ($param->action == 'update_basic_pic'||$param->action=='add_basic_pic') {
                        $user->images = serialize($images);
                        if ($UserTable->save($user)) {
                            $this->jsonResponse(true, '保存成功');
                        } else {
                            dblog('user', '基本图片保存失败', $user->errors());
                            $this->jsonResponse(false, $user->errors());
                        }
                    }
                }
            } else {
                $user->images = serialize($images);
                if ($UserTable->save($user)) {
                    $this->jsonResponse(true, '保存成功');
                } else {
                    dblog('user', '基本图片保存失败', $user->errors());
                    $this->jsonResponse(false, $user->errors());
                }
            }
            $this->jsonResponse(false, '成功调取接口');
        } else {
            $this->jsonResponse($res);
        }
    }

    /**
     * 保存用户基本视频
     */
    public function saveUserBasicVideo() {
        set_time_limit(0);
        $data = $this->request->data();
        $user_id = $this->request->data('user_id');
        $UserTable = \Cake\ORM\TableRegistry::get('User');
        $user = $UserTable->findById($user_id)->first();
        $param = $this->request->data('param');
        if (!$user_id || !$user) {
            $this->jsonResponse(false, '身份认证失败');
        }
        $res = $this->Util->uploadFiles('user/video');
        if ($res['status']) {
            $infos = $res['info'];
            foreach ($infos as $key => $info) {
                if ($info['key'] == 'video') {
                    $data['video'] = $info['path'];
                }
                if ($info['key'] == 'cover') {
                    $data['video_cover'] = $info['path'];
                }
            }
            if ($param) {
                $param = json_decode($param);
                if (property_exists($param, 'action')) {
                    if ($param->action == 'add_tracle_video') {
                        //处理发视频动态
                        $tracle_type = 2;
                        $MovementTable = \Cake\ORM\TableRegistry::get('Movement');
                        $movement = $MovementTable->newEntity([
                            'user_id' => $user_id,
                            'video' => $data['video'],
                            'video_cover' => $data['video_cover'],
                            'body' => $param->tracle_body,
                            'type' => $tracle_type
                        ]);
                        if ($MovementTable->save($movement)) {
                            $this->jsonResponse(true, '保存成功');
                        } else {
                            $this->jsonResponse(true, $movement->errors());
                            dblog('movement', '动态保存失败', $movement->errors());
                        }
                    }

                    if ($param->action == 'up_auth_video') {
                        //处理上传认证视频
                        $user->auth_video = $data['video'];
                        $user->auth_video_cover = $data['video_cover'];
                        $user->auth_status = 1;   //待审核
                        if ($UserTable->save($user)) {
                            $this->jsonResponse(true, '保存成功');
                        } else {
                            $this->jsonResponse(true, $user->errors());
                        }
                    }

                    if ($param->action == 'update_basic_video') {
                        $user->video = $data['video'];
                        $user->video_cover = $data['video_cover'];
                        if ($UserTable->save($user)) {
                            $this->jsonResponse(true, '保存成功');
                        } else {
                            $this->jsonResponse(true, $user->errors());
                        }
                    }
                }
            } else {
                $user = $UserTable->patchEntity($user, $data);
                if ($UserTable->save($user)) {
                    $this->jsonResponse(true, '保存成功');
                } else {
                    $this->jsonResponse(true, $user->errors());
                }
            }
            $this->jsonResponse(false, '成功调取接口');
        } else {
            $this->jsonResponse($res);
        }
    }

    /**
     * 获取地图上的用户
     */
    public function getMapUsers() {
        $lng = $this->request->data('lng');
        $lat = $this->request->data('lat');
        $UserTable = \Cake\ORM\TableRegistry::get('User');
        $users = $UserTable->find()->select(['id', 'avatar', 'login_coord_lng', 'login_coord_lat',
                        'distance' => "getDistance($lng,$lat,login_coord_lng,login_coord_lat)"])
                ->where(['gender' => 2, 'status' => 3])
                ->orderDesc('distance')
                ->limit(10)->formatResults(function($items) {
                    return $items->map(function($item) {
                                $item['avatar'] = $this->Util->getServerDomain() . createImg($item['avatar']) .
                                        '?w=184&h=184&fit=stretch';
                                $item['link'] = '/index/homepage/' . $item['id'];
                                return $item;
                            });
                })
                ->toArray();
        $this->jsonResponse(['result' => $users]);
    }

    public function getMapUsersF() {
        $pos_arr = ['114.127843,22.60722'];
        $lng = $this->request->data('lng');
        $lat = $this->request->data('lat');
        $UserTable = \Cake\ORM\TableRegistry::get('User');
        $users = $UserTable->find()->select(['id', 'avatar', 'login_coord_lng', 'login_coord_lat',
                    'distance' => "getDistance($lng,$lat,login_coord_lng,login_coord_lat)",])
                ->where(['gender' => 2])
                ->orderDesc('distance')
                ->limit(10)->formatResults(function($items)use($lng, $lat) {
                    return $items->map(function($item)use($lng, $lat) {
                                $item['id'] = mt_rand(1, 100);
                                $item['avatar'] = 'http://m-my.smartlemon.cn' . createImg($item['avatar']) .
                                        '?w=184&h=184&fit=stretch';
                                return $item;
                            });
                })
                ->toArray();
        $res = [];
        foreach($pos_arr as $key=>$pos){
            $c = explode(',', $pos);
            $users[$key]->login_coord_lng = (float) $c[0];
            $users[$key]->login_coord_lat = (float) $c[1];
            $res[] = $users[$key];
        }
        $this->jsonResponse(['result' => $res]);
    }

    /**
     * app登录
     */
    public function getToken() {
        $u = $this->request->data('u');
        $p = $this->request->data('p');
        $lng = $this->request->data('lng');
        $lat = $this->request->data('lat');
        if (!$u || !$p) {
            $this->jsonResponse(false, '缺少必要的参数');
        }
        $UserTable = \Cake\ORM\TableRegistry::get('User');
        $user = $UserTable->find()->select(['imaccid', 'user_token', 'gender', 'pwd', 'imtoken', 'avatar', 'reg_step', 'id'])
                ->where(['phone' => $u, 'enabled' => 1, 'is_del' => 0])
                ->first();
        $pwd = $this->request->data('pwd');
        if (!$user) {
            $this->jsonResponse(['status' => false, 'msg' => '该手机号未注册或被禁用']);
        }
        if (!(new \Cake\Auth\DefaultPasswordHasher)->check($p, $user->pwd)) {
            $this->jsonResponse(false, '密码不正确');
        } else {
            if ($user->reg_step != 9) {
                //注册未完成
                $this->jsonResponse(['status' => false, 'msg' => '注册未完成,请继续注册步骤',
                    'code' => 201, 'redirect_url' => '/user/reg-basic-info-' . $user->reg_step . '/' . $user->id]);
            }
            $user_token = $user->user_token;
            $data['login_time'] = date('Y-m-d H:i:s');
            if ($lng && $lat) {
                $data['login_coord_lng'] = $lng;
                $data['login_coord_lat'] = $lat;
            }
            $user = $UserTable->patchEntity($user, $data);
            $UserTable->save($user);
            $redirect_url = '/index/index';
            if (($redirect_url == '/index/index' || $redirect_url == '/') && $user->gender == '2') {
                //女性用户首页
                $redirect_url = '/index/find-rich-list';
            }
            unset($user->pwd);
            $user->avatar = $this->Util->getServerDomain() . $user->avatar;
            $this->jsonResponse(['status' => true, 'redirect_url' => $redirect_url,
                'token_uin' => $user_token, 'msg' => '登入成功', 'user' => $user]);
        }
    }

}
