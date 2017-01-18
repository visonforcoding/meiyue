<?php
namespace App\Controller\Component;

use App\Model\Entity\Payorder;
use App\Model\Entity\User;
use Cake\Controller\Component;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use MsgpushType;
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
    public $components = ['Push'];
    protected $_defaultConfig = [];

    /**
     * 获取1级技能标签 从缓存或数据库当中
     */
    public function getTopSkill(){
        $skills = \Cake\Cache\Cache::read('topskill');
        if(!$skills){
            $SkillTable = \Cake\ORM\TableRegistry::get('Skill');
            $skills = $SkillTable->find()->hydrate(true)->where(['parent_id IS' => null])->toArray();
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
        $mwhere = ['user_id' => $userid, 'income' => 1];
        if('week' == $type) {
            $mwhere['Flow.create_time >='] = new Time('last sunday');
        } else if('month' == $type) {
            $da = new Time();
            $mwhere['Flow.create_time >='] =
                new Time(new Time($da->year . '-' . $da->month . '-' . '01 00:00:00'));
        }
        $FlowTable = TableRegistry::get('Flow');
        $query = $FlowTable->find();
        $query->contain([
            'User' => function($q) use($userid) {
                return $q->select(['id','avatar','nick','phone','gender','birthday'])
                        ->where(['User.id' => $userid]);
            },
            'User.Upacks',
            'User.Supporteds',
        ])
            ->select(['total' => 'sum(amount)'])
            ->where($mwhere)
            ->map(function($row) {
                $row['user']['age'] = getAge($row['user']['birthday']);
                $row['total'] = intval($row['total']);
                $row['ishead'] = false;
                $row['isHongRen'] = false;
                if((count($row['user']['supporteds']) >= 100) && (count($row['user']['upacks'] >= 100))) {
                    $row['isHongRen'] = true;
                }
                return $row;
            });
        $mytop = $query->first();
        if($mytop) {
            $mytop->user->age = isset($mytop->user->birthday)?getAge($mytop->user->birthday):'xx';
            $mytop->ishead = true;
            if(!$mytop->total) {
                //如果魅力值为0则不参与排名
                return null;
            }

            //获取我的排名对象
            $where = ['income' => 1];
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
        }
        return $mytop;
    }


    /**
     * 获取用户vip等级
     */
    public function getVIP(User $user)
    {
        //累计充值3万元=钻石
        if($user->recharge >= 30000) {
            return \VIPlevel::ZUANSHI_VIP;
        }
        //累计充值1万元=白金
        else if($user->recharge >= 10000) {
            return \VIPlevel::BAIJIN_VIP;
        }
        //累计充值3999=黄金
        else if($user->recharge >= 3999) {
            return \VIPlevel::HUANGJIN_VIP;
        }

        $upackTb = TableRegistry::get('UserPackage');
        $validpack = $upackTb->find()->where([
            'user_id' => $user->id,
            'type' => PackType::VIP,
            'deadline >' => new Time(),
            'OR' => ['rest_chat >' => 0, 'rest_browse >' => 0]
        ])->first();
        if($validpack) {
            return \VIPlevel::COMMON_VIP;
        }
        return \VIPlevel::NOT_VIP;
    }


    /**
     * 检测是否美约红人
     * 规则：100个被查看动态&&收到100个礼物
     * @return boolean
     */
    public function isMYHongRen(User $user)
    {
        if($user->gender == 1) {
            return false;
        }
        $usedPackTb = TableRegistry::get('UsedPackage');
        $supportTb = TableRegistry::get('Support');
        $usednum = $usedPackTb->find()->where(['used_id' => $user->id])->count();
        $supportnum = $supportTb->find()->where(['supported_id' => $user->id])->count();
        if(($usednum >= 100) && ($supportnum >= 100)) {
            return true;
        }
        return false;
    }


    /**
     * 检测是否显示土豪徽章
     * 规则：土豪排名前100
     * @return boolean
     */
    public function isTuHao(User $user)
    {
        if($user->gender == 2) {
            return false;
        }
        $userTb = TableRegistry::get('User');
        $mypaiming = $userTb->find()
                ->select(['recharge'])
                ->where(['recharge >' => $user->recharge, 'gender' => 1])
                ->count() + 1;
        if($mypaiming <= 100) {
            return true;
        }
        return false;
    }


    /**
     * 检测是否显示活跃徽章
     * 规则：连续7天登录
     * @return boolean
     */
    public function isActive(User $user)
    {
        return false;
    }


    /**
     * 获取用于显示的徽章数组
     *
     */
    public function getShown(User $user)
    {
        $shown = [
            'isHongRen' => false,
            'isTuHao' => false,
            'isActive' => false,
            'vipLevel' => \VIPlevel::NOT_VIP
        ];
        if(!$user) {
            return $shown;
        }
        if($user->gender == 1) {
            $shown['isHongRen'] = $this->isMYHongRen($user);
            $shown['vipLevel'] = $this->getVIP($user);
        } else {
            $shown['isTuHao'] = $this->isTuHao($user);
        }
        $shown['isActive'] = $this->isActive($user);
        return $shown;
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
            return 0;
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
                        'user_id' => $userid,
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
            return $this->handType1Order($order,$realFee,$payType,$out_trade_no);
        } elseif ($order->type == PayOrderType::BUY_TAOCAN || $order->type == PayOrderType::BUY_CHONGZHI_TAOCAN) {
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
            $this->shareIncome($realFee, $order->user,$order->id);
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
        $order->user->money += $pack->vir_money;
        $packTypeStr = PackType::getPackageType(PackType::RECHARGE);
        $flowType = 15;  //购买vip套餐
        if($pack->type == PackType::VIP) {
            $packTypeStr = PackType::getPackageType(PackType::VIP);
        } else if($pack->type == PackType::RECHARGE) {
            $flowType = 16;  //购买充值套餐
            $order->user->recharge += $realFee;
            $packTypeStr = PackType::getPackageType(PackType::RECHARGE);
        }
        $order->dirty('user', true);  //这里的seller 一定得是关联属性 不是关联模型名称 可以理解为实体
        $OrderTable = TableRegistry::get('Payorder');

        //生成流水记录
        $FlowTable = TableRegistry::get('Flow');
        $flow = $FlowTable->newEntity([
            'user_id' => $order->user_id,
            'type' => $flowType,  //购买套餐
            'relate_id'=>$order->id,   //关联的订单id
            'type_msg' => '购买'.$packTypeStr,
            'income' => 1,
            'amount' => $realFee,
            'price'=> $order->price,
            'pre_amount' => $pre_amount,
            'after_amount' => $order->user->money,
            'paytype'=>$flowPayType,
            'status' => 1,
            'remark' => '购买'.$packTypeStr
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
            'honour_name' => $pack->honour_name,
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
                    $orderes = $OrderTable->save($order);
                    $useres = TableRegistry::get('User')->save($user);
                    $flowres = $FlowTable->save($flow);
                    return
                        $flowres
                        &&$orderes
                        &&$useres
                        &&$userPackTb->save($userPack)
                        &&$updateUsedres
                        &&$updateUseres;
                });

        if ($transRes) {
            //向专家和买家发送一条短信
            //资金流水记录
            if($order->type == PackType::RECHARGE) {
                $this->shareIncome($realFee, $order->user);
            }
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

        //修改收款方费用
        $userTb = TableRegistry::get('User');
        $in_user = $userTb->get($order->relate_id);
        if(!$in_user) {
            return $this->Util->ajaxReturn(false, '用户不存在');
        }
        $in_user->money = $in_user->money + $realFee;
        $in_user->charm = $in_user->charm + $realFee;
        //生成流水
        $FlowTable = TableRegistry::get('Flow');
        $flow = $FlowTable->newEntity([
            'user_id'=>$order->relate_id,
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
            'user_id' => $order->user->id,
            'wxer_id' => $order->relate_id,
            'anhao' => $anhao
        ]);
        $transRes = $FlowTable->connection()->transactional(function() use ($OrderTable, $order, $flow, $FlowTable, $wxorderTb, $wxorder, $in_user, $userTb){
            return $OrderTable->save($order)&&$FlowTable->save($flow)&&$wxorderTb->save($wxorder)&&$userTb->save($in_user);
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


    /**
     * 生成用户邀请码
     * @param $uid
     */
    public function createInviteCode($uid)
    {
        $before = $uid + 111111;
        $after = dechex($before);
        return ''.$after;
    }

    /**
     * 根据邀请码产生邀请关系
     * 邀请码 incode
     * 注册人id  uid
     */
    public function create2Invit($incode, $uid)
    {
        $inviterTb = TableRegistry::get('User');
        $inviter = $inviterTb->find()->select(['id', 'is_agent'])->where(['invit_code' => $incode])->first();
        if($inviter && ($inviter->is_agent == 1)) {
            $invTb = TableRegistry::get('Inviter');
            $inv = $invTb->find()->where(['invited_id' => $uid])->first();
            if(!$inv) {
                $inv = $invTb->newEntity([
                    'inviter_id' => $inviter->id,
                    'invited_id' => $uid,
                    'status' => 1,
                ]);
                $invTb->save($inv);
            }
        }
    }


    /**
     * 创建分成收入
     * @param $amount 收入/充值
     * @param App\Model\Entity\User $invited 被邀请者
     * @param int $relate_id 关联id
     */
    public function shareIncome($amount, \App\Model\Entity\User $invited, $relate_id = 0)
    {
        $cz_percent = 0.15;  //男性充值上家获得分成比例
        $sr_percent = 0.10;  //女性收入上家获得分成比例
        $invtb = TableRegistry::get('Inviter');
        $inv = $invtb->find()->contain(['Invitor'])->where(['invited_id' => $invited->id])->first();
        if($inv) {
            $invitor = $inv->invitor;
            if($invitor->is_agent == 2) {
                return false;
            }
            $admoney = 0;
            if($invited->gender == 1) {
                $admoney = $amount * $cz_percent;
                $type = 19;  //好友充值美币
            } else {
                $admoney = $amount * $sr_percent;
                $type = 20;  //好友获得收入
            }
            $inv->income += $admoney;
            $preAmount = $invitor->money;
            $invitor->money += $admoney;
            $afterAmount = $invitor->money;
            //生成流水
            $FlowTable = TableRegistry::get('Flow');
            $flow = $FlowTable->newEntity([
                'user_id'=> $invitor->id,
                'buyer_id'=> 0,
                'type'=> $type,
                'type_msg'=> getFlowType($type),
                'income'=> 1,
                'relate_id'=> $relate_id,
                'amount'=> $admoney,
                'price'=> $admoney,
                'pre_amount'=> $preAmount,
                'after_amount'=> $afterAmount,
                'paytype'=>1,   //余额支付
                'remark'=> getFlowType($type)
            ]);
            $inv->dirty('invitor', true);
            $transRes = $FlowTable->connection()->transactional(
                function() use ($FlowTable, &$flow, $invtb, &$inv){
                    $flores = $FlowTable->save($flow);
                    $ires = $invtb->save($inv);
                    return $flores&&$ires;
                }
            );
            return $transRes;
        }
        return false;
    }

    /**
     * 发送平台消息-单发
     * @param int $uid 推送对象
     * @param array $message 推送消息体
     *      [
     *          'towho' => 推送说明(直接调用MsgpushType::TO_**类型的，例如，约会过程的通知使用MsgpushType::TO_DATER),
     *          'title' => string 标题,
     *          'body' => string 消息体,
     *          'to_url' => string 跳转链接,
     *      ]
     * @param boolean $umeng 是否推送消息
     * @return int 例如：MsgpushTye::ERROR_NOUSER
     */
    public function sendSMsg($uid, $message = [], $umeng = false)
    {
        return $this->sendMsg([$uid], $message, $umeng);
    }

    /**
     * 发送平台消息-群发
     * @param array $uids 推送对象集
     * @param array $message 推送消息体
     *      [
     *          'towho' => 推送说明(直接调用MsgpushType::TO_**类型的，例如，约会过程的通知使用MsgpushType::TO_DATER),
     *          'title' => string 标题,
     *          'body' => string 消息体,
     *          'to_url' => string 跳转链接,
     *      ]
     * @param boolean $umeng 是否推送消息
     * @return int 例如：MsgpushTye::ERROR_NOUSER
     */
    public function sendMsg($uids = [], $message = [], $umeng = false)
    {
        if($umeng) {
            $title = isset($message['body'])?$message['body']:'';
            $content = ' ';
            $ticker = isset($message['body'])?$message['body']:'';
            $utb = TableRegistry::get("User");
            $users = $utb->find('list')->where(['id IN' => $uids])->toArray();
            $alias = implode($users, ',');
            if(count($uids) >= 50) {
                $res = $this->Push->sendFile($title, $content, $ticker, str_replace(',', "\n", $alias), 'MY', false);
            } else if(count($uids > 0)) {
                $res = $this->Push->sendAlias($alias, $title, $content, $ticker, 'MY', false);
            }
        }
        return $this->sendPtMsg($uids, $message);
    }


    /**
     * 发送平台消息-单发
     * @param int $uid 推送对象
     * @param array $message 推送消息体
     *      [
     *          'towho' => 推送说明(直接调用MsgpushType::TO_**类型的，例如，约会过程的通知使用MsgpushType::TO_DATER),
     *          'title' => string 标题,
     *          'body' => string 消息体,
     *          'to_url' => string 跳转链接,
     *      ]
     * @return int 例如：MsgpushTye::ERROR_NOUSER
     */
    public function sendSPtMsg($uid, $message = [])
    {
        return $this->sendPtMsg([$uid], $message);
    }


    /**
     * 发送平台消息-群发
     * @param array $uids 推送对象集
     * @param array $message 推送消息体
     *      [
     *          'towho' => 推送说明(直接调用MsgpushType::TO_**类型的，例如，约会过程的通知使用MsgpushType::TO_DATER),
     *          'title' => string 标题,
     *          'body' => string 消息体,
     *          'to_url' => string 跳转链接,
     *      ]
     * @return int 例如：MsgpushTye::ERROR_NOUSER
     */
    public function sendPtMsg($uids = [], $message = [])
    {
        $ptmsgtb = TableRegistry::get('Ptmsg');
        $ptmsg = $ptmsgtb->newEntity();
        if(count($uids) <= 0) {
            return MsgpushType::ERROR_NOUSER;
        }
        $ptmsg = $ptmsgtb->patchEntity($ptmsg, $message);
        $ptmsg->msg_type = MsgpushType::TO_CUSTOM;
        $res = $ptmsgtb->connection()->transactional(function() use($ptmsg, $ptmsgtb, $uids) {
            $msgpushTb = TableRegistry::get('Msgpush');
            $ptres = $ptmsgtb->save($ptmsg);
            $msgres = false;
            if($ptres) {
                $msgpushes = [];
                foreach($uids as $uid) {
                    $msgpushes[] = [
                        'msg_id' => $ptmsg->id,
                        'user_id' => $uid,
                        'is_read' => 0,
                        'is_del' => 0
                    ];
                }
                $msgpushes = $msgpushTb->newEntities($msgpushes);
                $msgres = $msgpushTb->saveMany($msgpushes);
            }
            return $msgres&&$ptres;
        });
        if ($res) {
            return MsgpushType::SUCCESS;
        } else {
            return MsgpushType::FAILD;
        }
    }
}
