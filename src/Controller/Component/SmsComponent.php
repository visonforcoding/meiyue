<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Core\Configure;
use Cake\Network\Http\Client;
use Cake\Utility\Xml;

/**
 * Sms component 短信组件
 * @property \App\Controller\Component\NetimComponent $Netim
 */
class SmsComponent extends Component {

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = ['engine'=>'Netim'];
    
    
    
    
    
    public function send($mobile,$content,$code=''){
        $config = $this->config();
        $engine = $config['engine'];
        $func = 'sendBy'.$engine;
        return $this->$func($mobile,$content,$code);
    }

    /**
     * Qf106 平台短信接口
     * 只做简单发短信功能 具体业务和防止恶意刷短信 需结合在业务层处理
     * @param string $mobile 要发送到的手机号
     * @param string $content 发送的内容
     * @param string $code 验证码 可选
     * @return bool true 成功 false 失败
     */
    public function sendByQf106($mobile, $content, $code = '') {
        $smsConfig = Configure::read('sms');
        if (!$smsConfig) {
            throw new \Exception('未配置短信平台信息');
        }
        $http = new Client();
        $requestData = [
            'userid' => $smsConfig['userid'],
            'account' => $smsConfig['account'],
            'password' => $smsConfig['password'],
            'content' => $smsConfig['password'],
            'mobile' => $mobile,
            'content' => $content
        ];
        $url = 'http://www.qf106.com/sms.aspx?action=send';
        $response = $http->post($url, $requestData);
        if ($response->isOk()) {
            $body = Xml::toArray(Xml::build($response->body()));
            //\Cake\Log\Log::debug($body);
            if ($body['returnsms']['successCounts']) {
                $smsTable = \Cake\ORM\TableRegistry::get('Smsmsg');
                $sms = $smsTable->newEntity([
                    'phone' => $mobile,
                    'code' => $code,
                    'content' => $content,
                    'expire_time' => time() + 60 * 10,
                    'create_time' => date('Y-m-d H:i:s')
                ]);
                $smsTable->save($sms);
                return true;
            } else {
                \Cake\Log\Log::error('【短信接口】:' . $body['returnsms']['message']);
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Qf106 平台短信接口(群发)
     * 只做简单发短信功能 具体业务和防止恶意刷短信 需结合在业务层处理
     * @param string $mobile 要发送到的手机号，用半角逗号隔开
     * @param string $content 发送的内容
     * @param string $code 验证码 可选
     * @return bool true 成功 false 失败
     */
    public function sendManyByQf106($mobile, $content, $code = '') {
        $smsConfig = Configure::read('sms');
        if (!$smsConfig) {
            throw new \Exception('未配置短信平台信息');
        }
        $http = new Client();
        $requestData = [
            'userid' => $smsConfig['userid'],
            'account' => $smsConfig['account'],
            'password' => $smsConfig['password'],
            'content' => $smsConfig['password'],
            'mobile' => $mobile,
            'content' => $content
        ];
        $url = 'http://www.qf106.com/sms.aspx?action=send';
        $response = $http->post($url, $requestData);
        if ($response->isOk()) {
            $body = Xml::toArray(Xml::build($response->body()));
            //\Cake\Log\Log::debug($body);
            if ($body['returnsms']['successCounts']) {
                $smsTable = \Cake\ORM\TableRegistry::get('smsmsg');
                $mobile_arr = explode(',', $mobile);
                $query = $smsTable->query()->insert(['phone', 'code', 'content', 'create_time']);
                $value = [
                    'code' => $code,
                    'content' => $content,
                    'create_time' => date('Y-m-d H:i:s')
                ];
                foreach ($mobile_arr as $k => $v) {
                    $value['phone'] = $v;
                    $query->values($value);
                }
                $query->execute();
                return true;
            } else {
                \Cake\Log\Log::error('【短信接口】:' . $body['returnsms']['message']);
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Qf106 平台短信接口
     * 只做简单发短信功能 具体业务和防止恶意刷短信 需结合在业务层处理
     * @param array $mobiles 要发送到的手机号
     * @param string $content 发送的内容
     * @param string $code 验证码 可选
     * @return bool true 成功 false 失败
     */
    public function sendByNetim($mobiles, $content, $code = '') {
        $Netim = new \App\Pack\Netim('dc1119190917f764270bafbfb46cc563', 'f31facd3243c');
        $result = $Netim->sendSMSTemplate('3033570', $mobiles, [$content]);
        //\Cake\Log\Log::debug($body);
        if(!$result->isOk()){
            \Cake\Log\Log::error('网易云信短信发送失败','devlog');
            dblog('Sms','网易云信短信发送失败');
            return false;
        }
        $body = json_decode($result->body());
        if ($body->code=='200') {
            $smsTable = \Cake\ORM\TableRegistry::get('smsmsg');
            $query = $smsTable->query()->insert(['phone', 'code', 'content', 'create_time']);
            $value = [
                'code' => $code,
                'content' => $content,
                'expire_time' => time() + 60 * 10,
                'create_time' => date('Y-m-d H:i:s')
            ];
            foreach ($mobiles as $k => $v) {
                $value['phone'] = $v;
                $query->values($value);
            }
            $query->execute();
            return true;
        } else {
            \Cake\Log\Log::error('【短信接口】:');
            \Cake\Log\Log::error($result->body());
            return false;
        }
    }

}
