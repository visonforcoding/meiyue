<?php

namespace App\Pack;

class Netim {

    protected $appkey;
    protected $appSecret;

    const TEXT_MSG = 0;
    const IMG_MSG = 1;
    const AUDIO_MSG = 2;
    const VIDEO_MSG = 3;
    const POS_MSG = 4;
    const FILE_MSG = 5;
    /**
     * 自定义消息
     */
    const CUSTOM_MSG = 100;

    public function __construct() {
        $conf = \Cake\Core\Configure::read('netim');
        $this->appkey = $conf['app_key'];
        $this->appSecret = $conf['app_secret'];
    }

    /**
     * 创建云信ID
     * 1.第三方帐号导入到云信平台；
     * 2.注意accid，name长度以及考虑管理秘钥token
     * @param  $accid     [云信ID，最大长度32字节，必须保证一个APP内唯一（只允许字母、数字、半角下划线_、@、半角点以及半角-组成，不区分大小写，会统一小写处理）]
     * @param  $token     [云信ID可以指定登录token值，最大长度128字节，并更新，如果未指定，会自动生成token，并在创建成功后返回]
     * @param  $name      [云信ID昵称，最大长度64字节，用来PUSH推送时显示的昵称]
     * @param  $props     [json属性，第三方可选填，最大长度1024字节]
     * @param  $icon      [云信ID头像URL，第三方可选填，最大长度1024]
     * @return $result    [返回array数组对象]
     */
    public function createUserId($accid, $token = '', $name = '', $props = '{}', $icon = '') {
        $url = 'https://api.netease.im/nimserver/user/create.action';
        $data = array(
            'accid' => $accid,
            'name' => $name,
            'props' => $props,
            'icon' => $icon,
            'token' => $token
        );
        $res = $this->httpPost($url, $data);
        if ($res->isOk()) {
            return json_decode($res->body());
        } else {
            return false;
        }
    }

    /**
     * im 的通用请求方法
     * @param type $url
     * @param type $data
     * @return \Cake\Http\Client\Response
     */
    protected function httpPost($url, $data) {
        $nonce = createRandomCode(16);
        $timestamp = time();
        $checksum = sha1($this->appSecret . $nonce . $timestamp);
        $httpClient = new \Cake\Http\Client([
            'ssl_verify_peer' => false,
        ]);
        return $httpClient->post($url, $data, [
                    'headers' => [
                        'AppKey' => $this->appkey,
                        'Nonce' => $nonce,
                        'CurTime' => $timestamp,
                        'CheckSum' => $checksum,
                    ]
        ]);
    }

    /**
     * 更新token
     * @param type $accid
     * @return boolean
     */
    public function updateUserId($accid, $token = '') {
        $data['accid'] = $accid;
        $url = 'https://api.netease.im/nimserver/user/refreshToken.action';
        if ($token) {
            $data['token'] = $token;
            $url = 'https://api.netease.im/nimserver/user/update.action';
        }
        $res = $this->httpPost($url, $data);
        if ($res->isOk()) {
            return json_decode($res->body());
        } else {
            return false;
        }
    }

    /**
     * 注册或更新im
     */
    public function registerIm($accid, $mtoken = '') {
        $token = false;
        $res = $this->createUserId($accid, $mtoken);
        if (!$res) {
            return false;
        }
        if ($res->code != 200) {
            if ($res->desc == 'already register') {
                $res = $this->updateUserId($accid, $mtoken);
                if (!$res) {
                    return false;
                }
            }
        }
        if ($res->code == 200) {
            $token = $res->info->token;
        }
        if ($token) {
            return $token;
        }
        return false;
    }
    
    /**
     * 发送消息 单体
     * @param type $from  发送方 accid
     * @param type $to  接收方  accid
     * @param array $body 消息体
     * @param type $type  消息类型
     * @param type $ope   发个人 or 发群
     * @return bool 
     */
    public function sendMsg($from, $to, $body, $type = self::CUSTOM_MSG,$ope = 0) {
        $url = 'https://api.netease.im/nimserver/msg/sendMsg.action';
        $body['md5'] = md5(time());
        $body = json_encode($body);
        $data = [
            'from'=>$from,
            'to'=>$to,
            'body'=>$body,
            'type'=>$type,
            'ope'=>$ope,
        ];
        $res = $this->httpPost($url, $data);
        if($res->isOk()){
            $resp = json_decode($res->body());
            if($resp->code==200){
                \Cake\Log\Log::info('Netim sendMsg'.$res->body(),'devlog');
                return true;
            }else{
                \Cake\Log\Log::error('Netim sendMsg'.$res->body(),'devlog');
                return false;
            }
        }else{
             return false;
        }
    }
    
    
    /**
     * 生成自定义消息
     * @param type $type  消息类型  5自定义普通消息   6礼物消息
     * @param type $from  发送者消息
     * @param type $to    接收者消息
     * @param array $param 额外
     * @return array Description
     */
    public function generateCustomMsg($type,$from,$to,$param = []){
       $data = [];
       $data['type'] = $type;
       $data['data'] = [
         'from'=>$from,
         'to'=>$to,
       ];
       if($type == '6'){
           $data['gift_type'] =  $param['gift_type'];
       }
       return $data;
    }
    
    /**
     * 生成自定义消息体   
     * @param type $body  消息内容
     * @param type $link  消息链接
     * @param type $link_text  消息链接文字
     * @param type $prefix  消息前缀
     * @return array
     */
    public function generateCustomMsgBody($body,$link,$link_text,$prefix){
        return [
            'msg_body'=>$body,
            'msg_link'=>$link,
            'msg_link_text'=>$link_text,
            'msg_prefix'=>$prefix
        ];
    }
    
    /**
     *  文本消息
     * @param string $body
     * @return type
     */
    public function generateTextMsgBody($body){
        return [
          'msg'=>$body  
        ];
    }

}
