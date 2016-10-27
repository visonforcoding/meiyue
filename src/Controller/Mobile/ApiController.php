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
 *
 */
class ApiController extends AppController {

    const TOKEN = 'dBkuJtWzHuPJFtTjZqHJugGP';

    protected $noAcl = [
        'upload', 'wxtoken', 'ckregister','recordphone'
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
            $json = json_encode($status);
        } else {
            $json = json_encode(array('status' => $status, 'msg' => $msg, 'code' => $statusCode));
        }
        echo $json;
        exit();
    }

    protected function checkAcl() {
        \Cake\Log\Log::debug('接口debug');
        \Cake\Log\Log::debug($this->request->data());
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
            //return $this->baseCheckAcl();
        }
    }

    protected function baseCheckAcl() {
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
        $dir = 'app';
        $extra_data = $this->request->data('extra_param');
        $extra_data_json = json_decode($extra_data);
        \Cake\Log\Log::debug($extra_data_json, 'devlog');
        if (is_object($extra_data_json)) {
            if (isset($extra_data_json->dir)) {
                $dir = $extra_data_json->dir;
            }
        }
        \Cake\Log\Log::debug($this->request->data(), 'devlog');
        $today = date('Y-m-d');
        $urlpath = '/upload/' . $dir . '/' . $today . '/';
        $savePath = ROOT . '/webroot' . $urlpath;
        $upload = new UploadFile(); // 实例化上传类
        $upload->maxSize = 31457280; // 设置附件上传大小
        $upload->allowExts = array('jpg', 'gif', 'png', 'jpeg', 'zip', 'ppt',
            'pptx', 'doc', 'docx', 'xls', 'xlsx', 'webp'); // 设置附件上传类型
        $upload->savePath = $savePath; // 设置附件上传目录
        $isZip = false;
        if (isset($extra_data_json->zip)) {
            if ($extra_data_json->zip) {
                //缩略图处理
                $isZip = true;
                $upload->thumb = true;
                $upload->thumbMaxWidth = '60';
                $upload->thumbMaxHeight = '60';
            }
        }
        $upload->savePath = $savePath; // 设置附件上传目录
        if (!$upload->upload()) {// 上传错误提示错误信息
            $response['status'] = false;
            $response['msg'] = $upload->getErrorMsg();
        } else {// 上传成功 获取上传文件信息
            $info = $upload->getUploadFileInfo();
            $response['status'] = true;
            $response['path'] = $urlpath . $info[0]['savename'];
            if ($isZip) {
                $response['thumbpath'] = $urlpath . $upload->thumbPrefix . $info[0]['savename'];
                $response['smallpath'] = $urlpath . $upload->smallPrefix . $info[0]['savename'];
            }
            $response['msg'] = '上传成功!';
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
        if($PhonelogTable->save($log)){
            $this->jsonResponse(true, 'ok');
        }else{
            $this->jsonResponse(false,'fail');
        }
        
    }

}
