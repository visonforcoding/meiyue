<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use ServiceType;

/**
 * 项目业务组件
 * Business component  
 */
class BusinessComponent extends Component
{
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
        $FlowTable = \Cake\ORM\TableRegistry::get('Flow');
        $query = $FlowTable->find();
        $query->contain(['User' => function($q) use($userid) {
            return $q->select(['id','avatar','nick','phone','gender','birthday'])
                ->where(['User.id' => $userid]);
        }])
            ->select(['total' => 'sum(amount)'])
            ->where(['income' => 1])
            ->map(function($row) {
                $row['user']['age'] = getAge($row['user']['birthday']);
                $row['ishead'] = false;
                return $row;
            });
        $mytop = $query->first();
        $mytop->user->age = getAge($mytop->user->birthday);
        $mytop->ishead = true;

        //获取我的排名对象
        $where = Array(
            'income' => 1
        );
        if('week' == $type) {
            $where['Flow.create_time >='] = new Time('last sunday');
        } else if('month' == $type) {
            $da = new Time();
            $where['Flow.create_time >='] = new Time(new Time($da->year . '-' . $da->month . '-' . '01 00:00:00'));
        }
        $iquery = $FlowTable->find('list')
            ->contain([
                'User'=>function($q) use($mytop) {
                    return $q->where(['gender'=>2, 'User.id !=' => $mytop->user->id]);
                },
            ])
            ->select(['total' => 'sum(amount)'])
            ->where($where)
            ->group('Flow.user_id')
            ->having(['total >= ' => $mytop->total]);

        //计算排名
        $mytop->index = $iquery->count() + 1;
        return $mytop;
    }


    /**
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
        if($usedPack->id) {
            return Array(
                'status' => 1,
                'msg' => '已经消耗过名额了'
            );
        } else {
            $userPackTb = TableRegistry::get('UserPackage');
            $key = "sum(" + ServiceType::getDBRestr($type) + ")";
            $userPack = $userPackTb
                ->find()
                ->select(['rest' => $key])
                ->where(
                    [
                        'deadline >' => new Time(),
                    ])
                ->first();
            $rest = $userPack->rest;
            if($rest > 0) {
                return Array(
                    'status' => 2,
                    'rest' => $rest,
                    'msg' => '有名额但尚未消耗'
                );
            }
            return Array(
                'status' => 3,
                '没有名额可以消耗'
            );
        }
    }


    /**
     * 直接消耗一个名额
     * data必须参数：
     *      int userid 使用者id
     *      int usedid 作用对象id
     *      int type   使用类型，见ServiceType类
     */
    public function consumeRightD($userid, $usedid, $type)
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
     * 消耗一个名额
     * data必须参数：
     *      int userid 使用者id
     *      int usedid 作用对象id
     *      int type   使用类型，见ServiceType类
     */
    public function consumeRight($userid, $usedid, $type)
    {
        $chres = $this->checkRight($userid, $usedid, $type);
        switch($chres['status']) {
            case 0:
                return false;
            case 1:
                return true;
            case 2:
                return consumeRightD($userid, $usedid, $type);
            case 3:
                return false;
        }
    }
    
     /**
     * 处理订单业务
     * @param \App\Model\Entity\Order $order
     * @param float $realFee 实际支付金额
     * @param int $payType 支付方式 1微信2支付宝
     * @param string $out_trade_no 第三方平台交易号
     */
    public function handOrder(\App\Model\Entity\Payorder $order,$realFee,$payType,$out_trade_no) {
        if ($order->type == 1) {
            //处理预约
            return $this->handType1Order($order,$realFee,$payType,$out_trade_no);
        } elseif ($order->type == 2) {
            // 处理报名
            return $this->handApplyOrder($order,$realFee,$payType,$out_trade_no);
        }
    }
    
     /**
     * 处理type1  直接充值  改变余额 生成流水
     * @param \App\Model\Entity\Order $order
     */
    protected function handType1Order(\App\Model\Entity\Payorder $order,$realFee,$payType,$out_trade_no) {
        $order->fee = $realFee;  //实际支付金额
        $order->paytype = $payType;  //实际支付方式
        $flowPayType = $payType==1?'3':'4';
        $order->out_trade_no = $out_trade_no;  //第三方订单号
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
            'amount' => $order->price,
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
}
