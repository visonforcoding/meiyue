<?php
namespace App\Controller\Component;

use App\Model\Entity\Payorder;
use Cake\Controller\Component;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use PackType;
use PayOrderType;
use SerRight;
use ServiceType;

/**
 * 项目业务组件
 * Business component  
 */
class BusinessComponent extends Component
{
    
    const REDIS_HASH_KEY = 'meiyue_im_pool_hash';
    const REDIS_SET_KEY = 'meiyue_im_pool';
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    /**
     * 获取1级技能标签 从缓存或数据库当中
     */
    public function getTopSkill(){
        $skills = \Cake\Cache\Cache::read('topskill');
        if(!$skills){
            $SkillTable = \Cake\ORM\TableRegistry::get('Skill');
            $skills = $SkillTable->find()->hydrate(true)->where(['parent_id'=>0])->toArray();
            if($skills){
                \Cake\Cache\Cache::write('topskill',$skills);
            } 
        }
        return $skills;
    }


    /**
     * 获取我的排名对象
     * @param string $type
     * @return mixed|null
     */
    public function getMyTop($type = 'week', $userid) {

        $mytop = null;
        //获取我的排名
        $FlowTable = TableRegistry::get('Flow');
        $query = $FlowTable->find();
        $query->contain(['User' => function($q) use($userid) {
            return $q->select(['id','avatar','nick','phone','gender','birthday'])
                ->where(['User.id' => $userid]);
        }])
            ->select(['total' => 'sum(amount)'])
            ->where(['user_id' => $userid])
            ->map(function($row) {
                $row['user']['age'] = getAge($row['user']['birthday']);
                $row['ishead'] = false;
                return $row;
            });
        $mytop = $query->first();
        $mytop->user->age = getAge($mytop->user->birthday);
        $mytop->ishead = true;
        if(!$mytop->total) {
            //如果魅力值为0则不参与排名
            return null;
        }

        //获取我的排名对象
        $where = Array(
        );
        if('week' == $type) {
            $where['Flow.create_time >='] = new Time('last sunday');
        } else if('month' == $type) {
            $da = new Time();
            $where['Flow.create_time >='] =
                new Time(new Time($da->year . '-' . $da->month . '-' . '01 00:00:00'));
        }
        $where['User.gender'] = 2;
        $where['User.id !='] = $mytop->user->id;
        $iquery = $FlowTable
            ->find('all')
            ->contain([
                'User'
            ])
            //->select(['total' => 'sum(amount)'])
            ->where($where)
            ->group('Flow.user_id')
            ->having(['sum(amount) >= ' => $mytop->total]);

        //计算排名
        $mytop->index = $iquery->count() + 1;
        return $mytop;
    }


    /**
     * @author: kebin
     * 与美女聊天、查看美女动态
     * 检查是否有权限
     * data必须参数：
     *      int userid 使用者id
     *      int usedid 作用对象id
     *      int type   使用类型，见ServiceType类
     * 返回结果：
     *      Array('status' => case [, 'rest' => int]) //case 2时有rest返回
     *          case 0:不合法参数
     *          case 1:可以访问（已经消耗过额度）
     *          case 2:可以访问（尚未消耗额度）
     *          case 3:不可以访问（没有额度可以消耗）
     */
    public function checkRight($userid = null, $usedid = null, $type = null) {
        if(
            $userid === null
            &&$usedid === null
            &&$type === null
            &&!ServiceType::containType($type)
        ) {
            return Array(
                'status' => 0,
                'msg' => '非法参数'
            );
        }

        //检查是否有权限看
        $usedPackTb = TableRegistry::get('UsedPackage');
        $usedPack = $usedPackTb
            ->find()
            ->select('id')
            ->where(
                [
                    'user_id' => $userid,
                    'used_id' => $usedid,
                    'type' => $type,
                    'deadline >' => new Time()
                ])
            ->first();
        if($usedPack) {
            return SerRight::OK_CONSUMED;
        } else {
            $userPackTb = TableRegistry::get('UserPackage');
            $key = "sum(" . ServiceType::getDBRestr($type) . ")";
            $userPack = $userPackTb
                ->find()
                ->select(['rest' => $key])
                ->where(
                    [
                        'deadline >' => new Time(),
                    ])
                ->first();
            if($userPack) {
                $rest = $userPack->rest;
                if($rest > 0) {
                    return SerRight::NO_HAVENUM;
                }
            }
            return SerRight::NO_HAVENONUM;
        }
    }


    /**
     * @author: kebin
     * 名额充足的情况下
     * 直接消耗一个名额
     * data必须参数：
     *      int userid 使用者id
     *      int usedid 作用对象id
     *      int type   使用类型，见ServiceType类
     */
    function consumeRightD($userid, $usedid, $type)
    {
        $userPackTb = TableRegistry::get("UserPackage");
        $key = ServiceType::getDBRestr($type);
        $userPack = $userPackTb
            ->find()
            ->where(
                [
                    'user_id' => $userid,
                    $key.' >' => 0,
                    'deadline >' => new Time(),
                ])
            ->orderAsc('create_time')
            ->first();
        if($userPack) {
            $userPack->$key --;
            //生成消费记录
            $usedPackTb = TableRegistry::get("UsedPackage");
            $usedPack = $usedPackTb
                ->newEntity([
                    'user_id' => $userPack->user_id,
                    'used_id' => $usedid,
                    'package_id' => $userPack->id,
                    'type' => $type,
                    'deadline' => $userPack->deadline,
                ]);
            $transRes = $usedPackTb
                ->connection()
                ->transactional(
                    function() use ($userPack, $userPackTb, $usedPack, $usedPackTb){
                        $upackres = $userPackTb->save($userPack);
                        $dpackres = $usedPackTb->save($usedPack);
                        return $upackres&&$dpackres;
                    });
            if($transRes) {
                return true;
            }
        }
        return false;
    }


    /**
     * @author: kebin
     * 会检查权限和名额剩余
     * 如果已经消费了则直接返回true而不消费名额
     * 消耗一个名额
     * data必须参数：
     *      int userid 使用者id
     *      int usedid 作用对象id
     *      int type   使用类型，见ServiceType类
     */
    public function consumeRight($userid, $usedid, $type)
    {
        $chres = $this->checkRight($userid, $usedid, $type);
        if($chres == SerRight::OK_CONSUMED) {
            return true;
        } else if($chres == SerRight::NO_HAVENUM) {
            return $this->consumeRightD($userid, $usedid, $type);
        }
        return false;
    }
    
     /**
     * 处理订单业务
     * @param \App\Model\Entity\Order $order
     * @param float $realFee 实际支付金额
     * @param int $payType 支付方式 1微信2支付宝
     * @param string $out_trade_no 第三方平台交易号
     */
    public function handOrder(\App\Model\Entity\Payorder $order,$realFee,$payType,$out_trade_no) {
        if ($order->type == PayOrderType::CHONGZHI) {
            //处理预约
            return $this->handType1Order($order,$realFee,$payType,$out_trade_no);
        } elseif ($order->type == PayOrderType::BUY_TAOCAN) {
            //购买套餐成功
            return $this->handPackPay($order,$realFee,$payType,$out_trade_no);
        } elseif ($order->type == PayOrderType::VIEW_WEIXIN) {
            //支付微信查看金成功
            return $this->handViewWxPay($order,$realFee,$payType,$out_trade_no);
        }
    }
    
     /**
     * 处理type1  直接充值 支付订单状态更改  改变余额  生成流水
     * @param \App\Model\Entity\Order $order
     */
    protected function handType1Order(\App\Model\Entity\Payorder $order,$realFee,$payType,$out_trade_no) {
        $order->fee = $realFee;  //实际支付金额
        $order->paytype = $payType;  //实际支付方式
        $flowPayType = $payType==1?'3':'4';
        $order->out_trade_no = $out_trade_no;  //第三方订单号
        $order->status = 1;
        $pre_amount = $order->user->money;
        $order->user->money += $order->price;    //专家余额+
        $order->user->recharge +=$realFee;
        $order->dirty('user', true);  //这里的seller 一定得是关联属性 不是关联模型名称 可以理解为实体
        $OrderTable = \Cake\ORM\TableRegistry::get('Payorder');
        $FlowTable = \Cake\ORM\TableRegistry::get('Flow');
        $flow = $FlowTable->newEntity([
            'user_id' => $order->user_id,
            'type' => 4,
            'relate_id'=>$order->id,   //关联的订单id
            'type_msg' => '账户充值',
            'income' => 1,
            'amount' => $realFee,
            'price'=>$order->price,
            'pre_amount' => $pre_amount,
            'after_amount' => $order->user->money,
            'paytype'=>$flowPayType,
            'status' => 1,
            'remark' => '普通充值'.$order->price.'美币'
        ]);
        $transRes = $OrderTable->connection()->transactional(function()use(&$order, $OrderTable, $FlowTable, &$flow) {
            return $OrderTable->save($order) &&  $FlowTable->save($flow);
        });
        if ($transRes) {
            //向专家和买家发送一条短信
            //资金流水记录
            return true;
        }else{
            \Cake\Log\Log::debug($order->errors(),'devlog');
            \Cake\Log\Log::debug($flow->errors(),'devlog');
            dblog('recharge','充值回调业务处理失败',$order->id);
            return false;
        }
    }


    /**
     * 购买套餐支付成功后处理接口
     */
    public function handPackPay(Payorder $order, $realFee, $payType, $out_trade_no)
    {
        $packTb = TableRegistry::get('Package');
        $pack = $packTb->get($order->relate_id);
        //更新支付单信息
        $order->fee = $realFee;  //实际支付金额
        $order->paytype = $payType;  //实际支付方式
        $flowPayType = $payType==1?'3':'4';
        $order->out_trade_no = $out_trade_no;  //第三方订单号
        $order->status = 1;
        $pre_amount = $order->user->money;
        $order->user->money += $pack->vir_money;    //专家余额+
        if($pack->type == PackType::VIP) {
            $order->user->recharge .= $realFee;
        }
        $order->user->recharge += $realFee;
        $order->dirty('user', true);  //这里的seller 一定得是关联属性 不是关联模型名称 可以理解为实体
        $OrderTable = TableRegistry::get('Payorder');

        //生成流水记录
        $FlowTable = TableRegistry::get('Flow');
        $flow = $FlowTable->newEntity([
            'user_id' => $order->user_id,
            'type' => 15,  //购买套餐
            'relate_id'=>$order->id,   //关联的订单id
            'type_msg' => '套餐购买',
            'income' => 1,
            'amount' => $realFee,
            'price'=>$order->price,
            'pre_amount' => $pre_amount,
            'after_amount' => $order->user->money,
            'paytype'=>$flowPayType,
            'status' => 1,
            'remark' => '套餐购买'
        ]);

        //生成套餐购买记录
        //查询当前用户账户下套餐的最长有效期
        $addDays = $pack->vali_time + 1;
        $deadline = new Time("+$addDays day");
        $deadline->hour = 0;
        $deadline->second = 0;
        $deadline->minute = 0;
        $userPackTb = TableRegistry::get('UserPackage');
        $query = $userPackTb
            ->find()
            ->select(['longestdl' => 'max(deadline)'])
            ->where([
                'user_id' => $order->user->id,
                'deadline >' => new Time()
            ]);
        $ownPach = $query->first();
        //计算出最长有效期
        //是否需要更新UserPackage表和UsedPackage表该用户的截止日期标志
        $udFlag = false;
        if($ownPach->longestdl) {
            $longestdl = new Time($ownPach->longestdl);
            if($deadline > $longestdl) {
                //购买的套餐以最长截止日期为准
                $udFlag = true;
            } else {
                $deadline = $longestdl;
            }
        }
        $userPack = $userPackTb->newEntity([
            'title' => $pack->title,
            'user_id' => $order->user->id,
            'package_id' => $pack->id,
            'chat_num' => $pack->chat_num,
            'rest_chat' => $pack->chat_num,
            'browse_num' => $pack->browse_num,
            'rest_browse' => $pack->browse_num,
            'type' => $pack->type,
            'cost' => $pack->price,
            'vir_money' => $pack->vir_money,
            'deadline' => $deadline,
        ]);
        $user = $order->user;
        $transRes = $userPackTb
            ->connection()
            ->transactional(
                function() use ($FlowTable, $flow, $OrderTable, $order, $user, $userPack, $userPackTb, $udFlag, $deadline){
                    $updateUsedres = true;
                    $updateUseres = true;
                    //更新UserPackage表和UsedPackage表该用户的截止日期
                    //如果用户买了新的套餐，该套餐截止日期比现有的长，则更新所有未过期的已购买套餐
                    if($udFlag) {
                        $usedPackTb = TableRegistry::get('UsedPackage');
                        $updateUsedres = $usedPackTb
                            ->query()
                            ->update()
                            ->set(['deadline' => $deadline])
                            ->where(['user_id' => $user->id, 'deadline >=' => new Time()])
                            ->execute();

                        $updateUseres = $userPackTb
                            ->query()
                            ->update()
                            ->set(['deadline' => $deadline])
                            ->where(['user_id' => $user->id, 'deadline >=' => new Time()])
                            ->execute();
                    }
                    $useres = TableRegistry::get('User')->save($user);
                    $flowres = $FlowTable->save($flow);
                    return
                        $flowres
                        &&$useres
                        &&$userPackTb->save($userPack)
                        &&$updateUsedres
                        &&$updateUseres;
                });

        if ($transRes) {
            //向专家和买家发送一条短信
            //资金流水记录
            return true;
        }else{
            \Cake\Log\Log::debug($order->errors(),'devlog');
            \Cake\Log\Log::debug($flow->errors(),'devlog');
            dblog('recharge','套餐回调业务处理失败',$order->id);
            return false;
        }
    }


    /**
     * 支付微信查看金成功处理接口
     */
    public function handViewWxPay(Payorder $order, $realFee, $payType, $out_trade_no)
    {
        //更新订单状态消息及用户信息
        $order->fee = $realFee;  //实际支付金额
        $order->paytype = $payType;  //实际支付方式
        $flowPayType = $payType==1?'3':'4';
        $order->out_trade_no = $out_trade_no;  //第三方订单号
        $order->status = 1;
        $order->user->recharge += $realFee;
        $order->dirty('user', true);  //这里的seller 一定得是关联属性 不是关联模型名称 可以理解为实体
        $OrderTable = TableRegistry::get('Payorder');
        //生成流水
        $FlowTable = TableRegistry::get('Flow');
        $flow = $FlowTable->newEntity([
            'user_id'=>0,
            'buyer_id'=>$order->user->id,
            'type'=>18,
            'type_msg'=>getFlowType('18'),
            'income'=>2,
            'amount'=>100,
            'price'=>100,
            'pre_amount'=>0,
            'after_amount'=>0,
            'paytype'=> $flowPayType,   //余额支付
            'remark'=> getFlowType('18')
        ]);
        //生成查看记录
        $anhao = '美约'.mt_rand(10000, 99999);
        $wxorderTb = TableRegistry::get('Wxorder');
        $wxorder = $wxorderTb->newEntity([
            'user_id' => $this->user->id,
            'wxer_id' => $order->relate_id,
            'anhao' => $anhao
        ]);
        $transRes = $FlowTable->connection()->transactional(function() use ($OrderTable, $order, $flow, $FlowTable, $wxorderTb, $wxorder){
            return $OrderTable->save($order)&&$FlowTable->save($flow)&&$wxorderTb->save($wxorder);
        });
        if($transRes) {
            return true;
        } else {
            return false;
        }
    }

    
    /**
     * 获取网易im token 和accid
     */
    public function getNetim(){
        $RedisConf = \Cake\Core\Configure::read('Redis.default');
        $redis = new \Redis();
        $redis->connect($RedisConf['host'], $RedisConf['port']);
        $accid = $redis->sPop(self::REDIS_SET_KEY);
        $token = $redis->hGet(self::REDIS_HASH_KEY,$accid);
        if($accid===false){
            return false;
        }
        return [
            'accid'=>$accid,
            'token'=>$token
        ];
    }
    
     /**
     * 生成  支付订单
     */
    public function createPayorder($user,$param,$type=1){
        $PayorderTable = TableRegistry::get('Payorder');
        if($type==1){
            $payorder = $PayorderTable->newEntity([
                'user_id'=> $user->id,
                'title'=>'美约美币充值',
                'order_no'=>time() . $user->id . createRandomCode(4, 1),
                'price'=>  $param['mb'],
                'remark'=>  '充值美币'.$param['mb'].'个',
            ]);
        }
        $res = $PayorderTable->save($payorder);
        if($res){
            return $res;
        }else{
            return false;
        }
    }
}
