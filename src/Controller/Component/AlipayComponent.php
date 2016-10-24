<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;

/**
 * 支付宝
 * Alipay component
 * @property \App\Controller\Component\BusinessComponent $Business
 * @property \App\Controller\Component\UtilComponent $Util
 */
class AlipayComponent extends Component {

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    public $components = ['Business','Util'];

    /**
     * 合作者id
     * @var type 
     */
    protected $partner;

    /**
     *  异步通知url
     * @var type 
     */
    protected $notify_url;

    /**
     * 卖家支付宝帐号
     * @var type 
     */
    protected $seller_id;

    /**
     * 私钥
     * @var type 
     */
    protected $private_key;

    /**
     * 支付宝公钥
     * @var type 
     */
    protected $alipay_public_key;

    public function initialize(array $config) {
        parent::initialize($config);
        $conf = \Cake\Core\Configure::read('alipay');
        $this->partner = $conf['partner'];
        $this->seller_id = $conf['seller_id'];
        $this->private_key = file_get_contents($conf['private_key']);
        $this->sslkey_path = $conf['sslkey_path'];
        $this->alipay_public_key = file_get_contents($conf['alipay_public_key']);
        $this->notify_url = $this->request->scheme() . '://' . $_SERVER['SERVER_NAME'] . $conf['notify_url'];
    }

    /**
     * 生成支付参数
     * @param type $order_no
     * @param type $order_title
     * @param type $order_fee
     * @param type $order_body
     * @return string
     */
    public function setPayParameter($order_no, $order_title, $order_fee, $order_body) {
        $params = [
            'service' => 'mobile.securitypay.pay',
            'partner' => $this->partner,
            '_input_charset' => 'utf-8',
            'notify_url' => $this->notify_url,
            'out_trade_no' => "$order_no",
            'subject' => $order_title,
            'payment_type' => '1',
            'seller_id' => $this->seller_id,
            'total_fee' => $order_fee,
            'body' => $order_body,
        ];
        ksort($params);
        $stringA = $this->buildLinkString($params); //不要转义的
        //$stringB = $stringA . '&key=' . $this->key;
        //$sign = strtoupper(md5($stringB));
        $res = openssl_get_privatekey($this->private_key);
        openssl_sign($stringA, $sign, $res);
        openssl_free_key($res);
        //base64编码
        $sign = urlencode(base64_encode($sign));
        $stringB = $stringA . '&sign="' . $sign . '"&sign_type="RSA"';
        return $stringB;
    }

    /**
     * 
     * @param type $params
     */
    public function buildLinkString($params) {
        $string = '';
        foreach ($params as $key => $value) {
            $string.= $key . '="' . $value . '"&';
        }
        //去掉最后一个&字符
        $string = substr($string, 0, count($string) - 2);

        //如果存在转义字符，那么去掉转义
        if (get_magic_quotes_gpc()) {
            $string = stripslashes($string);
        }
        return $string;
    }
    /**
     * 说起来你可能不信，支付宝这一步拼接字符串又不需要引号，而它的demo版例子其实错的，我*
     * @param type $params
     */
    public function buildLinkStringNoQuota($params) {
        $string = '';
        foreach ($params as $key => $value) {
            $string.= $key . '=' . $value . '&';
        }
        //去掉最后一个&字符
        $string = substr($string, 0, count($string) - 2);

        //如果存在转义字符，那么去掉转义
        if (get_magic_quotes_gpc()) {
            $string = stripslashes($string);
        }
        return $string;
    }

    /**
     * RSA验签
     * @param $data 接收的数据
     * return 验证结果
     */
    public function rsaVerify($data) {
        $sign = $data['sign'];
        $para_filter = array();
        //过滤不被签名的数据
        foreach ($data as $key => $val) {
            if ($key == "sign" || $key == "sign_type" || $val == "") {
                continue;
            } else {
                $para_filter[$key] = $data[$key];
            }
        }
        //排序
        ksort($para_filter);
        reset($para_filter);
        $dataWait = $this->buildLinkStringNoQuota($para_filter);
        $res = openssl_get_publickey($this->alipay_public_key);
        $result =  openssl_verify($dataWait, base64_decode($sign), $res);
        $result = (bool) $result;
        openssl_free_key($res);
        if(!$result){
            \Cake\Log\Log::error(__FUNCTION__,'devlog');
            \Cake\Log\Log::error('验签失败','devlog');
        }
        return $result;
    }

    /**
     * 支付宝的回调验证，验证通过则进行 接下来的业务处理
     * @return boolean
     */
    public function notifyVerify() {
        \Cake\Log\Log::error(__FUNCTION__,'devlog');
        if (!$this->request->is('post')) {//判断POST来的数组是否为空
            \Cake\Log\Log::error('支付宝回调请求方式错误','devlog');
            return false;
        } else {
            //生成签名结果
            $data = $this->request->data();
            \Cake\Log\Log::debug($data,'devlog');
            $isSign = $this->rsaVerify($data);
            if ($isSign && !empty($data['notify_id'])) {
                //获取支付宝远程服务器ATN结果（验证是否是支付宝发来的消息）
                \Cake\Log\Log::error('验证通过，开始验证ANT结果','devlog');
                $responseTxt = 'false';
                $notify_id = $data['notify_id'];
                $httpClient = new \Cake\Network\Http\Client(['ssl_verify_peer' => false]);
                $verifyAlipayUrl = 'https://mapi.alipay.com/gateway.do?service=notify_verify&partner=' . $this->partner . '&notify_id=' . $notify_id;
                $response = $httpClient->get($verifyAlipayUrl);
                if (!$response->isOk()) {
                    \Cake\Log\Log::error('请求支付宝验证来源失败', 'devlog');
                    \Cake\Log\Log::error($response, 'devlog');
                    return false;
                }
                $responseTxt = $response->body();
                \Cake\Log\Log::debug($responseTxt,'devlog');
                if (preg_match("/true$/i", $responseTxt) && $isSign) {
                    return true;
                } else {
                    return false;
                }
            } else {
                \Cake\Log\Log::error('支付宝支付验签失败','devlog');
                return false;
            }
        }
    }

    /**
     * 回调处理
     */
    public function notify() {
        $data = $this->request->data();
        if (isset($data['trade_status']) && $data['trade_status'] == 'TRADE_SUCCESS') {
            //支付宝端成功
            $order_no = $data['out_trade_no'];
            $OrderTable = \Cake\ORM\TableRegistry::get('Order');
            $order = $OrderTable->find()->contain(['Sellers', 'Users'])->where(['Lmorder.status' => 0, 'order_no' => $order_no])->first();
            $output = 'fail';
            if ($order) {
                $realFee = $data['total_fee'];
                $out_trade_no = $data['trade_no'];
                $res = $this->Business->handOrder($order, $realFee, 2, $out_trade_no);
                if($res){
                    $output = 'success';
                }
            } else {
                \Cake\Log\Log::error('支付宝交易回调查询订单失败,订单号:' . $order_no, 'devlog');
                $this->Util->dblog('order', '支付宝交易回调查询订单失败,订单号:' . $order_no, $data);
            }
            $this->response->body($output);
            $this->response->send();
            $this->response->stop();
        } else {
            \Cake\Log\Log::error('支付宝交易回调状态异常,状态值:' . $data['out_trade_no'], 'devlog');
            $this->Util->dblog('order','支付宝交易回调状态异常,状态值:' . $data['out_trade_no'], $data);
        }
    }

}
