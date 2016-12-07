<?php

namespace App\Pack;

class Netim {

    protected $appkey;
    protected $appSecret;

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
    public function createUserId($accid, $token='', $name = '', $props = '{}', $icon = '') {
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
     * 
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
    public function updateUserId($accid, $token='') {
        $data['accid'] = $accid;
        $url = 'https://api.netease.im/nimserver/user/refreshToken.action';
        if($token){
            $data['token'] = $token;
            $url = 'https://api.netease.im/nimserver/user/update.action';
        }
        $res = $this->httpPost($url,$data);
        if ($res->isOk()) {
            return json_decode($res->body());
        } else {
            return false;
        }
    }

    /**
     * 注册或更新im
     */
    public function registerIm($accid, $mtoken='') {
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

}