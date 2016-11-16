<?php
namespace App\Controller\Mobile;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;

/**
 * Activity Controller
 *
 * @property \App\Model\Table\ActivityTable $Activity
 */
class ActivityController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index($user_id = null)
    {
        if($this->request->is("post")) {

            $datas = $this->Activity->find("all")->where(['status' => 1, 'Activity.start_time >' => new Time()]);
            if($user_id) {

                $datas = $datas->where(['Date.user_id' => $user_id]);
                if(isset($this->request->data['status'])) {

                    $datas->where(["Date.status" => $this->request->data['status']]);

                }

            }
            return $this->Util->ajaxReturn(['datas' => $datas->toArray(), 'status' => true]);

        }
        $this->set(["user" => $this->user, 'pageTitle' => '美约-活动']);
    }


    /**
     * @param string|null $id Activity id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->handCheckLogin();
        $activity = $this->Activity->get($id, ['contain' => ['Actregistrations'=> function($q){
            return $q->contain(['User' => function($q) { return $q->select(['User.id', 'User.gender']);}])
                ->where(['Actregistrations.status' => 1]);
        }]]);

        //检查是否已经参与
        $regist_item = null;
        $actregistrations = $activity['actregistrations'];
        foreach ($actregistrations as $actregistration) {
            if($this->user->id == $actregistration['user']['id'] && $actregistration['cancel_time'] == null) {
                $regist_item = $actregistration;
                break;
            }
        }

        //检查报名人数是否已满
        $lim_flag = false;
        if($this->user->gender == 1) {

            if($activity['male_rest'] == 0) {

                $lim_flag = true;

            }

        } else {

            if($activity['female_rest'] == 0) {

                $lim_flag = true;

            }
        }

        $this->set(['lim_flag' => $lim_flag, 'regist_item' => $regist_item, 'user' => $this->user, 'activity' => $activity, 'pageTitle' => '美约-活动详情']);
    }


    /**
     * 1.返还扣除惩罚金后的报名费余额部分
     * 2.生成流水
     * 3.标记报名表项取消时间
     * 4.修改活动参加人数
     */
    public function cancel($id = null) {

        if($this->request->is("POST")) {

            if($id != null) {

                $actreTable = TableRegistry::get('Actregistration');
                if($actreTable) {

                    //检查当前时间是否在派对开始前XX小时
                    $actre = $actreTable->get($id, ['contain' => 'Activity']);
                    $start_time = $actre['activity']['start_time'];
                    $current_time = new Time();
                    if($current_time->diffInDays($start_time, false) >= 3) {

                        $return_count = $actre['cost'] - $actre['punish'];
                        //生成流水
                        //扣除 报名费用
                        $pre_amount = $this->user->money;
                        $this->user->money = $this->user->money + $return_count;
                        $user = $this->user;
                        $after_amount = $this->user->money;
                        //生成流水
                        $FlowTable = TableRegistry::get('Flow');
                        $flow = $FlowTable->newEntity([
                            'user_id'=>0,
                            'buyer_id'=>  $this->user->id,
                            'type'=>$FlowTable::TYPE_ACTREGIST,
                            'type_msg'=>'取消派对返还',
                            'income'=>2,
                            'amount'=>$return_count, //支付金额
                            'price'=>$actre['cost'],  //订单金额
                            'pre_amount'=>$pre_amount,
                            'after_amount'=>$after_amount,
                            'paytype'=>1,   //余额支付
                            'remark'=> "扣除报名费".$actre['punish_percent']."%（即".$actre['punish'].")",
                        ]);


                        $activityTable = $this->Activity;
                        $activity = $actre['activity'];

                        if($user->gender == 1) {

                            $activity->male_rest += $actre['num'];

                        } else {

                            $activity->female_rest += $actre['num'];

                        }

                        $transRes = $actreTable->connection()->transactional(function()use($flow,$FlowTable,&$actre,$actreTable,$activity,$activityTable,$user){
                            $UserTable = TableRegistry::get('User');
                            //标记报名表项取消时间
                            $actre['cancel_time'] = new Time();
                            $actre['status'] = 2;

                            $saveActr = $actreTable->save($actre);
                            $flow->relate_id = $actre['id'];
                            $saveAct = $activityTable->save($activity);
                            return $FlowTable->save($flow)&&$saveActr&&$saveAct&&$UserTable->save($user);
                        });
                        if($transRes) {

                            return $this->Util->ajaxReturn(true, '取消成功');

                        }

                    }
                    return $this->Util->ajaxReturn(false, '操作失败');

                }

            }

        }
        return $this->Util->ajaxReturn(false, '操作失败');

    }


    public function payView($id = null) {

        if($id) {
            $this->handCheckLogin();
            $activity = $this->Activity->get($id);

            $price = 0;
            $lim = 0;
            if($this->user->gender == 1) {

                $price = $activity['male_price'];
                $lim = $activity['male_lim'];

            } else {

                $price = $activity['female_price'];
                $lim = $activity['female_lim'];

            }
            $this->set(['user' => $this->user, 'lim' => $lim, 'price' => $price,'activity' => $activity, 'pageTitle' => '美约-活动支付']);

        }

    }

    /**
     * 参加派对支付接口
     * 1.生成报名表
     * 2.扣除用户报名费用
     * 3.生成流水
     * 4.修改派对信息
     * @param $id
     * @param int $num
     * @return \Cake\Network\Response|null
     */
    public function mpay($id, $num = 1) {

        //参加活动
        if($this->request->is("POST")) {

            $this->handCheckLogin();
            $activity = $this->Activity->get($id, ['contain' => ['Actregistrations'=> function($q){
                return $q->contain(['User' => function($q) { return $q->select(['User.id', 'User.gender']);}])
                    ->where(['Actregistrations.status' => 1]);
            }]]);
            //检查是否参与过
            $actregistrationTable = TableRegistry::get('Actregistration');
            $count = $actregistrationTable->find()->where(['user_id' => $this->user->id, 'activity_id' => $id, 'cancel_time' => null])->count();
            if($count > 0) {

                return $this->Util->ajaxReturn(false, '您已经参与过了！');

            }

            //获取需要费用
            //检查报名人数是否已满
            $price = 0;
            if($this->user->gender == 1) {

                $price = $activity['male_price'];
                if($activity->male_rest == 0) {

                    return $this->Util->ajaxReturn(false, '报名人数已满！');

                }

            } else {

                $price = $activity['female_price'];
                if($activity->female_rest == 0) {

                    return $this->Util->ajaxReturn(false, '报名人数已满！');

                }
            }
            //判断余额是否充足
            if($this->user->money < $price * $num) {

                return $this->Util->ajaxReturn(false, '美币余额不足！');

            }

            //生成报名表
            $actregistration = $actregistrationTable->newEntity([
                'user_id' => $this->user->id,
                'activity_id' => $activity['id'],
                'status' => 1,
                'cost' => $price * $num,
                'punish' => $price * $num * $activity['punish_percent'] / 100,
                'punish_percent' => $activity['punish_percent'],
                'num' => $num
            ]);
            //生成流水
            //扣除 报名费用
            $pre_amount = $this->user->money;
            $this->user->money = $this->user->money - $price * $num;
            $user = $this->user;
            $after_amount = $this->user->money;
            //生成流水
            $FlowTable = TableRegistry::get('Flow');
            $flow = $FlowTable->newEntity([
                'user_id'=>0,
                'buyer_id'=>  $this->user->id,
                'type'=>$FlowTable::TYPE_ACTREGIST,
                'type_msg'=>'报名派对支出',
                'income'=>2,
                'amount'=>$price * $num,
                'price'=>$price * $num,
                'pre_amount'=>$pre_amount,
                'after_amount'=>$after_amount,
                'paytype'=>1,   //余额支付
                'remark'=> '数量*'.$num
            ]);

            //修改活动表项
            if($user->gender == 1) {

                if($activity->male_rest < $num) {

                    return $this->Util->ajaxReturn(false,'报名名额不足！');

                }
                $activity->male_rest -= $num;

            } else {

                if($activity->female_rest < $num) {

                    return $this->Util->ajaxReturn(false,'报名名额不足！');

                }
                $activity->female_rest -= $num;

            }

            $activityTable = $this->Activity;
            $transRes = $actregistrationTable->connection()->transactional(function()use($flow,$FlowTable,&$actregistration,$actregistrationTable,$activity,$activityTable,$user){
                $UserTable = TableRegistry::get('User');
                $saveActr = $actregistrationTable->save($actregistration);
                $flow->relate_id = $actregistration['id'];
                $saveAct = $activityTable->save($activity);
                return $FlowTable->save($flow)&&$saveActr&&$saveAct&&$UserTable->save($user);
            });

            if($transRes){
                return $this->Util->ajaxReturn(true,'参加成功');
            }else{
                errorMsg($flow, '失败');
                errorMsg($actregistration, '失败');
                return $this->Util->ajaxReturn(false,'参加失败');
            }
            return $this->Util->ajaxReturn(true, '参加成功');

        }

    }
}
