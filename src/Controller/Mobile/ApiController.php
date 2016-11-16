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
        'saveuserbasicvideo', 'getmapusers'
    ];

    public function initialize() {
        parent::initialize();
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
        \Cake\Log\Log::debug('接口debug', 'devlog');
        \Cake\Log\Log::debug($this->request->data(), 'devlog');
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
        \Cake\Log\Log::debug('接口debug', 'devlog');
        \Cake\Log\Log::debug($this->request->data(), 'devlog');
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
            $response['status'] = false;
            $response['msg'] = $res['msg'];
            $response['path'] = $res['info'][0]['path'];
            $response['urlpath'] = $this->Util->getServerDomain().$res['info'][0]['path'];
        } else {// 上传成功 获取上传文件信息
            $response['status'] = true;
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
            $user->images = serialize($images);
            if ($UserTable->save($user)) {
                $this->jsonResponse(true, '保存成功');
            } else {
                $this->jsonResponse(true, $user->errors());
            }
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
            $user = $UserTable->patchEntity($user, $data);
            if ($UserTable->save($user)) {
                $this->jsonResponse(true, '保存成功');
            } else {
                $this->jsonResponse(true, $user->errors());
            }
        } else {
            $this->jsonResponse($res);
        }
    }

    /**
     * 获取地图上的用户
     */
    public function getMapUsersD() {
        $lng = $this->request->data('lng');
        $lat = $this->request->data('lat');
        $UserTable = \Cake\ORM\TableRegistry::get('User');
        $users = $UserTable->find()->select(['id', 'avatar', 'login_coord_lng', 'login_coord_lat'])
                ->where(["getDistance($lng,$lat,login_coord_lng,login_coord_lat) <=" => 1000])
                ->where(['gender'=>2])
                ->limit(10)->formatResults(function($items) {
                    return $items->map(function($item) {
                                $item['avatar'] = 'http://m-my.smartlemon.cn/' . createImg($item['avatar']) . 
                                        '?w=184&h=184&fit=stretch';
                                return $item;
                            });
                })
                ->toArray();
        $this->jsonResponse(['result' => $users]);
    }

    public function getMapUsers() {
        $lng = $this->request->data('lng');
        $lat = $this->request->data('lat');
        $UserTable = \Cake\ORM\TableRegistry::get('User');
        $users = $UserTable->find()->select(['id', 'avatar', 'login_coord_lng', 'login_coord_lat'])
//                ->where(["getDistance($lng,$lat,login_coord_lng,login_coord_lat) <=" => 1000])
                ->where(['gender'=>2])
                ->limit(10)->formatResults(function($items)use($lng,$lat) {
                    return $items->map(function($item)use($lng,$lat) {
                                $item['id'] = mt_rand(1,100);
                                $item['avatar'] = 'http://m-my.smartlemon.cn' . createImg($item['avatar']) . 
                                        '?w=184&h=184&fit=stretch';
                                $item['login_coord_lng'] = $lng+  randomFloat()*0.1;
                                $item['login_coord_lat'] = $lat+  randomFloat()*0.1;
                                return $item;
                            });
                })
                ->toArray();
        $this->jsonResponse(['result' => $users]);
    }

}
