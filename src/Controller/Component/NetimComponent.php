<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use App\Pack\Netim;

/**
 * Netim component  云信消息
 */
class NetimComponent extends Component {

    public $components = ['Util'];

    /**
     * 
     *  
     */
    protected $Netim;

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    protected $appkey;
    protected $appSecret;

    public function initialize(array $config) {
        parent::initialize($config);
        $this->Netim = new Netim();
    }

    
    /**
     * 
     * @param \App\Model\Entity\Dateorder $order
     * @return type
     */
    public function prepayMsg(\App\Model\Entity\Dateorder $order) {
        $from_prefix = '';
        $from_link = $this->Util->getServerDomain() . '/date-order/order-detail/' . $order->id;
        $from_body = '我已发出约单，快来确认吧！';
        $from_link_text = '查看详情';
        $from_msg = $this->Netim->generateCustomMsgBody($from_body, $from_link, $from_link_text, $from_prefix);

        $to_prefix = '[' . $order->user_skill->skill->name . ']';
        $to_link = $from_link;
        $lasth = $order->end_time->hour - $order->start_time->hour;
        $to_body = '我希望约您在' . $order->site . '，时间为' . $order->start_time . '~' . $order->end_time .
                '，共' . $lasth . '个小时，已预付诚意金' . $order->pre_pay . '美币，期待您赴约。';
        $to_link_text = '查看详情';
        $to_msg = $this->Netim->generateCustomMsgBody($to_body, $to_link, $to_link_text, $to_prefix);
        $msg = $this->Netim->generateCustomMsg(5, $from_msg, $to_msg);
        $res = $this->Netim->sendMsg($order->buyer->imaccid, $order->dater->imaccid, $msg);
        if (!$res) {
            \Cake\Log\Log::error($res,'devlog');
            dblog('prepayMsg', 'server发送im消息失败', $res);
        }
        return $res;
    }
    
    
    public function payallMsg(\App\Model\Entity\Dateorder $order){
        $from_prefix = '';
        $from_link = $this->Util->getServerDomain() . '/date-order/order-detail/' . $order->id;
        $from_body = '我已付完尾款,我们不见不散！';
        $from_link_text = '查看详情';
        $from_msg = $this->Netim->generateCustomMsgBody($from_body, $from_link, $from_link_text, $from_prefix);

        $to_prefix = '';
        $to_link = $from_link;
        $to_body = '我已付完尾款,我们不见不散！';
        $to_link_text = '查看详情';
        $to_msg = $this->Netim->generateCustomMsgBody($to_body, $to_link, $to_link_text, $to_prefix);
        $msg = $this->Netim->generateCustomMsg(5, $from_msg, $to_msg);
        $res = $this->Netim->sendMsg($order->buyer->imaccid, $order->dater->imaccid, $msg);
        if (!$res) {
            \Cake\Log\Log::error($res,'devlog');
            dblog('prepayMsg', 'server发送im消息失败', $res);
        }
        return $res;
    }




    /**
     * 发送礼物消息
     * @param type $from
     * @param type $to
     * @param type $gift
     * @return type
     */
    public function giftMsg($from,$to,$gift) {
        $from_prefix = '';
        $from_link = $this->Util->getServerDomain() . '/date-order/order-detail/';
        $from_body = '送你一辆布加迪！';
        $from_link_text = '查看详情';
        $from_msg = $this->Netim->generateCustomMsgBody($from_body, $from_link, $from_link_text, $from_prefix);

        $to_prefix = '[布加迪]';
        $to_link = $from_link;
        $to_body = '对方送了你一辆布加迪';
        $to_link_text = '查看详情';
        $to_msg = $this->Netim->generateCustomMsgBody($to_body, $to_link, $to_link_text, $to_prefix);
        $msg = $this->Netim->generateCustomMsg(6, $from_msg, $to_msg,['gift_type'=>  intval($gift)]);
        debug($msg);
        $res = $this->Netim->sendMsg($from, $to, $msg, Netim::CUSTOM_MSG,0);
        if (!$res) {
            dblog('prepayMsg', 'server发送im消息失败', $res);
        }
        return $res;
    }

}
