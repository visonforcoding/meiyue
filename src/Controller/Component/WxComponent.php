<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;

/**
 * Wx component  wx组件 
 *  获取access_token,用户openId, jsapi 签名信息
 * @author caowenpeng <caowenpeng1990@126.com>
 * @property \App\Controller\Component\EncryptComponent $Encrypt
 */
class WxComponent extends Component {

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    public $components = ['Encrypt'];

    const TOKEN_NAME = 'wx.access_token';
    const WEIXIN_API_URL = 'https://api.weixin.qq.com/cgi-bin/';
    const JSAPI_TICKET_NAME = 'wx.jsapi_ticket';
    const MASTER_TOKEN_API = '/get-token';

    protected $app_id;
    protected $app_secret;
    protected $wxconfig;
    /**
     * 中控服务器ip
     * @var type 
     */
    protected $master_ip;  
    /**
     * 中空服务器域名
     * @var type 
     */
    protected $master_domain;

    public function initialize(array $config) {
        parent::initialize($config);
        $wxconfig = \Cake\Core\Configure::read('weixin');
        $this->app_id = $wxconfig['appID'];
        $this->app_secret = $wxconfig['appsecret'];
        $this->master_ip = $wxconfig['master_ip'];
        $this->master_domain = $wxconfig['master_domain'];
        $this->wxconfig = $wxconfig;
    }

    /**
     *  验证服务器安全性  微信验证服务器是你的服务器 验证通过输出微信返回的字符串
     * @param type $token  公众号上填写的token值 
     * @return boolean
     */
    public function checkSignature($token) {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $token = $token;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        if ($tmpStr == $signature) {
            echo $_GET['echostr'];
            exit();
        } else {
            return false;
        }
    }

    /**
     * 
     * 前往微信验证页 前去获取code
     * @param type $base  是否base 静默获取
     * @param string $redirect_url 跳转url
     */
    public function getUserJump($base=false,$self=false) {
        if(!$base){
            $redirect_url = 'http://' . $_SERVER['SERVER_NAME'] . '/mobile/wx/getUserCode';
            $scope = 'snsapi_userinfo';
        }else{
            $redirect_url = 'http://' . $_SERVER['SERVER_NAME'] .'/wx/getUserCodeBase';
            if($self){
               $redirect_url = $this->request->scheme().'://'.$_SERVER['SERVER_NAME'].'/'.$this->request->url; 
            }
            $scope = 'snsapi_base';
        }
        $wx_code_url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='
                . $this->app_id . '&redirect_uri=' . urlencode($redirect_url) . '&response_type=code&scope='.$scope.'&state=STATE#wechat_redirect';
        \Cake\Log\Log::debug($wx_code_url,'devlog');
        \Cake\Log\Log::debug(urldecode($redirect_url),'devlog');
        $this->_registry->getController()->redirect($wx_code_url);
    }

    /**
     * 通过返回的code 获取access_token 再异步获取openId 和 用户信息
     * @return boolean|stdClass 出错则返回false 成功则返回带有openId 的用户信息 json std对象
     */
    public function getUser($code=null,$isApp=false) {
        $code = !empty($code)?$code:$this->request->query('code');
        $httpClient = new \Cake\Network\Http\Client(['ssl_verify_peer' => false]);
        $appid = $this->app_id;
        $app_secret = $this->app_secret;
        if($isApp){
            $wxconfig = $this->wxconfig;
            $appid = $wxconfig['AppID'];
            $app_secret = $wxconfig['AppSecret'];
        }
        //\Cake\Log\Log::debug($code,'devlog');
        $wx_accesstoken_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $appid . '&secret=' . $app_secret .
                '&code=' . $code . '&grant_type=authorization_code';
        $response = $httpClient->get($wx_accesstoken_url);
        //\Cake\Log\Log::debug('获取weixin信息第二步','devlog');
        //\Cake\Log\Log::debug($response,'devlog');
        if ($response->isOk()) {
            $open_id = json_decode($response->body())->openid;
            if($isApp){
                $access_token = json_decode($response->body())->access_token;
                $wx_user_url = 'https://api.weixin.qq.com/sns/userinfo?access_token=' . $access_token . '&openid=' . $open_id . '&lang=zh_CN';
            }else{
                $access_token = $this->getAccessToken(); //并不是返回的access_token  真尼玛B的
                $wx_user_url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token=' . $access_token . '&openid=' . $open_id . '&lang=zh_CN';
                //该接口地址能获取到union_id
            }
            $res = $httpClient->get($wx_user_url);
//            \Cake\Log\Log::debug('获取weixin信息第二步','devlog');
//            \Cake\Log\Log::debug($res,'devlog');
            if ($res->isOk()) { 
                \Cake\Log\Log::debug($res->body(),'devlog');
                $union_res = json_decode($res->body());
                if(property_exists($union_res, 'errcode')){
                    //第二步获取失败
                    \Cake\Log\Log::error('获取weixin用户信息时unionId接口返回结果显示有误','devlog');
                    return json_decode($response->body());
                }
                return json_decode($res->body());
            } else {
                \Cake\Log\Log::error('获取weixin用户信息时unionId接口请求失败');
                return json_decode($response->body());
            }
        } else {
            return false;
        }
    }

    /**
     * 获取accessToken
     */
    public function getAccessToken() {
        \Cake\Log\Log::notice('获取普通accessToken','devlog');
        $httpClient = new \Cake\Network\Http\Client(['ssl_verify_peer' => false]);
        if($this->request->env('SERVER_ADDR')!=$this->master_ip||
                $this->request->env('SERVER_NAME')!=$this->master_domain){
            //非中控服务器请求
            //\Cake\Log\Log::notice('非中控请求','devlog');
            return $this->handMasterRequest();
        }
        $access_token = \Cake\Cache\Cache::read(self::TOKEN_NAME);
        $url = self::WEIXIN_API_URL . 'token?grant_type=client_credential&appid=' . $this->app_id . '&secret=' . $this->app_secret;
        $isExpires = true;   //过期标志
        if (is_array($access_token)) {
            $isExpires = ($access_token['expires_in']-time())<2200 ? true : false;
            if($isExpires){
                \Cake\Log\Log::debug('access_token过期:','devlog');
            }
        }
        if ($access_token === false || $isExpires) {
            \Cake\Log\Log::warning('微信接口token重新请求','devlog');
            $response = $httpClient->get($url);
            if ($response->isOk()) {
                $body = json_decode($response->body());
                \Cake\Log\Log::debug($body,'devlog');
                if (!property_exists($body, 'access_token')) {
                    \Cake\Log\Log::error('未获取access_token属性','devlog');
                    \Cake\Log\Log::error($response,'devlog');
                    return false;
                }
                $token = $body->access_token;
                $expires = $body->expires_in;
                $expires = time() + $expires;
                \Cake\Log\Log::debug('重新获取access_token成功','devlog');
                \Cake\Log\Log::debug($body,'devlog');
                \Cake\Cache\Cache::write(self::TOKEN_NAME, [
                    'access_token' => $token,
                    'expires_in' => $expires,
                    'ctime' => date('Y-m-d H:i:s')
                ]);
                return $token;
            } else {
                \Cake\Log\Log::error($response);
                return FALSE;
            }
        } else {
            \Cake\Log\Log::debug($access_token);
            return $access_token['access_token'];
        }
    } 
    
    /**
     * 中控获取机制
     * 如若开发服a、b和线上服务器c .其中有任意1个在另一个获取access_token后获取了，由于使用的是相同的appid 等信息，
     * 所以前一个获取的服务器的token便会在，5分钟之后失效，由于没有超出7200秒的过期时间又不会重新获取，所以便会出现
     * 经常性的有access_token 失效的情况。
     * 中控服务器用来解决此问题，原理是保证线上和开发服务器使用的access_token是同一份。正式服务器取(或中控服务器)本地的文件缓存，非
     * 正式(中控)服务器便采取接口形式从中控(线上)服务器获取access_token .
     * 其中为了保证access_token安全，接口调用会有token 和时效验证，并且token还会被rsa加密，需用相同salt和key解密。
     * 防止http 抓包盗用。
     * @author caowenpeng <caowenpeng1990@126.com>
     * @return boolean
     */
    protected function handMasterRequest(){
        $httpClient = new \Cake\Network\Http\Client(['ssl_verify_peer' => false]);
        $api_url = 'http://'.$this->master_domain.self::MASTER_TOKEN_API;
        $time = time();
        $res = $httpClient->post($api_url,[
            'timestamp'=>$time,
            'access_token'=>strtoupper(md5($time . 'dBkuJtWzHuPJFtTjZqHJugGP'))
        ]);
        if(!$res->isOk()){
            return false;
        }else{
            return $this->Encrypt->decrypt($res->body());
        }
    }

    /**
     * 获取jsapi_ticket
     */
    public function getJsapiTicket() {
        $jsapi_tickt = \Cake\Cache\Cache::read(self::JSAPI_TICKET_NAME);
        if (is_array($jsapi_tickt)) {
            $isExpires = $jsapi_tickt['expires_in'] <= time() ? true : false;
        }
        if ($jsapi_tickt !== false && !$isExpires) {
            //存在缓存并且没过期
            return $jsapi_tickt['jsapi_ticket'];
        }
        //否则 再次请求获取
        $access_token = $this->getAccessToken();
        if (!$access_token) {
            \Cake\Log\Log::error('获取access_token 出错');
            return false;
        }
        $httpClient = new \Cake\Network\Http\Client(['ssl_verify_peer' => false]);
        $url = self::WEIXIN_API_URL . 'ticket/getticket?access_token=' . $access_token . '&type=jsapi';
        $response = $httpClient->get($url);
        if (!$response->isOk()) {
            \Cake\Log\Log::error('请求获取jsapi_ticket出错');
            \Cake\Log\Log::error($response);
            return false;
        }
        $body = json_decode($response->body());
        if ($body->errmsg == 'ok') {
            $expires = $body->expires_in;
            $expires = time() + $expires;
            \Cake\Cache\Cache::write(self::JSAPI_TICKET_NAME, [
                'jsapi_ticket' => $body->ticket,
                'expires_in' => $expires,
                'ctime' => date('Y-m-d H:i:s')
            ]);
            return $body->ticket;
        } else {
            \Cake\Log\Log::error('获取jsapi_ticket返回信息有误');
            \Cake\Log\Log::error($body);
            return false;
        }
    }

    
    /**
     * 用于jsapi 调用的 签名等信息
     * @return type
     */
    public function setJsapiSignature() {
        $ticket = $this->getJsapiTicket();
        $noncestr = createRandomCode(16, 3);
        $timestamp = time();
        $url = $this->request->scheme().'://'.$_SERVER['SERVER_NAME'].$this->request->here(false);
        $param = [
            'noncestr' => $noncestr,
            'jsapi_ticket' => $ticket,
            'timestamp' => $timestamp,
            'url' => $url
        ];
        ksort($param);
        $signature = sha1(urldecode(http_build_query($param))); //不要转义的
        return [
            'signature' => $signature,
            'nonceStr' => $noncestr,
            'timestamp' => $timestamp,
            'appId'=>  $this->app_id,
        ];
    }
    
    /**
     * 微信配置信息
     * @param array $apiList @link http://mp.weixin.qq.com/wiki/11/74ad127cc054f6b80759c40f77ec03db.html 所有api参数名列表
     * @param boolean $debug
     * @return array
     */
    public function wxconfig(array $apiList, $debug=true){
        $wxsign = $this->setJsapiSignature();
        $wxsign['debug'] = $debug;
        $wxsign['jsApiList'] = $apiList;
        return $wxsign;
    }

    
    /**
     *  处理微信上传
     */
    public function wxUpload($id) {
        $dir = $this->request->query('dir');
        $zip = $this->request->query('zip');
        $today = date('Y-m-d');
        $urlpath = '/upload/tmp/' . $today . '/';
        if (!empty($dir)) {
            $urlpath = '/upload/' . $dir . '/' . $today . '/';
        }
        $savePath = ROOT . '/webroot' . $urlpath;
        if (!is_dir($savePath)) {
            mkdir($savePath, 0777, true);
        }
        $uniqid = uniqid();
        $filename = $uniqid.'.jpg';
        $token = $this->getAccessToken();
        $url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=' . $token . '&media_id=' . $id;
        $httpClient = new \Cake\Network\Http\Client();
        $response = $httpClient->get($url);
        if($response->isOk()){
            $res = $response->body();
            \Cake\Log\Log::debug($res,'devlog');
        }
       $image = \Intervention\Image\ImageManagerStatic::make($res);
        if($zip){
            $image->resize(60,60);
            $filename = 'thumb_'.$uniqid.'.jpg';
        }
        $image->save($savePath.$filename);
        return $urlpath.$filename;
    }

}
