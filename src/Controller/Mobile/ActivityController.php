<?php
namespace App\Controller\Mobile;
use Cake\Datasource\ResultSetInterface;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use CarouselPosition;
use League\Flysystem\Exception;

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
    public function index($curtab = 'date')
    {
        if($this->user) {
            if($this->user->gender == 2) {
                $this->render('findex');
            }
        }
        $carouselTb = TableRegistry::get('Carousel');
        $carousel = $carouselTb->find()->where(['position' => CarouselPosition::TOP_BIGIMG, 'status' => 1])->first();
        $this->set([
            'curtab' => $curtab,
            "user" => $this->user,
            "carousel" => $carousel,
            'pageTitle' => '美约-活动'
        ]);
    }


    public function findex($curtab = 'date')
    {
        if($this->user) {
            if($this->user->gender == 1) {
                $this->render('index');
            }
        }
        $carouselTb = TableRegistry::get('Carousel');
        $carousel = $carouselTb->find()->where(['position' => CarouselPosition::TOP_BIGIMG, 'status' => 1])->first();
        $this->set([
            'curtab' => $curtab,
            "user" => $this->user,
            "carousel" => $carousel,
            'pageTitle' => '美约-活动'
        ]);
    }


    /**
     *  派对列表
     * @return \Cake\Network\Response|null
     */
    public function getAllDatasInPage($page) {
        $limit = 10;
        //添加用户参与活动状态
        $acts = [];
        if($this->user) {
            $actTb = TableRegistry::get('Actregistration');
            $acts = $actTb->find()
                ->select(['activity_id'])
                ->where(['user_id' => $this->user->id, 'status' => 1])
                ->toArray();
        }

        $datas = $this->Activity
            ->find("all")
            ->where([
                'status' => 1,
                'Activity.start_time >' => new Time()
            ]);
        $datas->limit($limit);
        $datas->page($page);
        $datas->formatResults(function(ResultSetInterface $results) use($acts) {
            return $results->map(function($row) use($acts) {
                $row->time = getFormateDT($row->start_time, $row->end_time);
                $row->joined = false; //参与标志
                $row->notjoin = true; //没参与标志
                $row->norest = false; //人数已满标志
                if(!$row->male_rest || !$row->female_rest) {
                    $row->joined = false; //参与标志
                    $row->notjoin = false; //没参与标志
                    $row->norest = true; //人数已满标志
                }
                foreach($acts as $act) {
                    if($row->id == $act->activity_id) {
                        $row->joined = true;
                        $row->notjoin = false;
                        $row->norest = false;
                        break;
                    }
                }
                return $row;
            });

        });

        $carousel = null;
        if($page = 1) {
            $carouselTb = TableRegistry::get('Carousel');
            $carousel = $carouselTb->find()->where(['position' => CarouselPosition::ACTIVITY])->first();
        }

        return $this->Util->ajaxReturn([
            'datas' => $datas->toArray(),
            'carousel' => $carousel,
            'status' => true
        ]);
    }


    /**
     * @param string|null $id Activity id.
     * @param int|0 $action 是否可取消0不可取消，1可取消.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null, $action = 0)
    {
        $activity = $this->Activity->get($id, ['contain' => ['Actregistrations'=> function($q){
            return $q
                ->contain([
                    'User' => function($q) {
                        return $q->select(['User.id', 'User.gender']);}
                ])
                ->where(['Actregistrations.status' => 1]);
        }]]);

        //底部按钮显示状态：0#我要报名 1#人数已满 2#我要取消 3#报名成功（此时是不可以取消的）
        $botBtSts = 0;
        $regist_item = null;
        //检查报名人数是否已满
        if($this->user) {
            if($this->user->gender == 1) {
                if($activity['male_rest'] == 0) {
                    $botBtSts = 1;
                }
            } else {
                if($activity['female_rest'] == 0) {
                    $botBtSts = 1;
                }
            }

            //检查是否已经参与
            $actregistrations = $activity['actregistrations'];
            foreach ($actregistrations as $actregistration) {
                if($this->user->id == $actregistration['user']['id']
                    && $actregistration['cancel_time'] == null) {
                    $botBtSts = 2;
                    $regist_item = $actregistration;
                    break;
                }
            }

            $current_time = new Time();
            //检查是否在规定可取消时间
            if($current_time->diffInDays($activity['start_time'], false) > $activity['cancelday'] && ($botBtSts == 2)) {
                $botBtSts = 3;
            }

            //检查是否过期
            $curtime = new Time();
            if($activity->start_time < $curtime && $activity->end_time > $curtime) {
                $botBtSts = 4;  //活动已开始
            } else if($activity->end_time < $curtime) {
                $botBtSts = 5;  //活动已结束
            }
        }

        $this->set([
            'regist_item' => $regist_item,
            'botBtSts' => $botBtSts,
            'cancancle' => $action,
            'user' => $this->user,
            'activity' => $activity,
            'pageTitle' => '美约-活动详情'
        ]);
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
                    if($current_time->diffInDays($start_time, false) >= $actre['activity']['cancelday']) {
                        $return_count = $actre['cost'] - $actre['punish'];
                        //生成流水
                        //扣除 报名费用
                        $pre_amount = $this->user->money;
                        $this->user->money = $this->user->money + $return_count;
                        $this->user -= $return_count;
                        $user = $this->user;
                        $after_amount = $this->user->money;
                        //生成流水
                        $FlowTable = TableRegistry::get('Flow');
                        $flow = $FlowTable->newEntity([
                            'user_id'=> $this->user->id,
                            'buyer_id'=> 0,
                            'type'=>13,
                            'type_msg'=>'取消派对返还',
                            'income'=>1,
                            'amount'=>$return_count, //支付金额
                            'price'=>$actre['cost'],  //订单金额
                            'pre_amount'=>$pre_amount,
                            'after_amount'=>$after_amount,
                            'paytype'=>1,   //余额支付
                            'remark'=> "派对取消返还金额:"
                                    .$actre['punish_percent']."%（即".$actre['punish'].")",
                        ]);
                        $activityTable = $this->Activity;
                        $activity = $actre['activity'];
                        if($user->gender == 1) {
                            $activity->male_rest += $actre['num'];
                        } else {
                            $activity->female_rest += $actre['num'];
                        }
                        $transRes = $actreTable
                            ->connection()
                            ->transactional(function()use(&$flow,$FlowTable,&$actre,$actreTable,&$activity,$activityTable,&$user){
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
                    } else {
                        return $this->Util->ajaxReturn(false, '无法取消！');
                    }
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
            $this->set([
                'user' => $this->user,
                'lim' => $lim,
                'price' => $price,
                'activity' => $activity,
                'pageTitle' => '美约-活动支付'
            ]);
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
            $count = $actregistrationTable
                ->find()
                ->where([
                    'user_id' => $this->user->id,
                    'activity_id' => $id,
                    'cancel_time' => null
                ])
                ->count();
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
            if($this->user->money < $price * $num && $price) {
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
            $this->user->consumed .= $price * $num;
            $user = $this->user;
            $after_amount = $this->user->money;
            //生成流水
            $FlowTable = TableRegistry::get('Flow');
            $flow = $FlowTable->newEntity([
                'user_id'=>0,
                'buyer_id'=>  $this->user->id,
                'type'=>13,
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
            $transRes = $actregistrationTable
                ->connection()
                ->transactional(
                    function() use (
                        &$flow,
                        $FlowTable,
                        &$actregistration,
                        $actregistrationTable,
                        &$activity,
                        $activityTable,
                        &$user
                    ){
                        $UserTable = TableRegistry::get('User');
                        $saveActr = $actregistrationTable->save($actregistration);
                        $flow->relate_id = $actregistration['id'];
                        $saveAct = $activityTable->save($activity);
                        return $FlowTable->save($flow)
                                &&$saveActr
                                &&$saveAct
                                &&$UserTable->save($user);
                    });

            if($transRes){
                return $this->Util->ajaxReturn(true,'参加成功');
            }else{
                return $this->Util->ajaxReturn(false,'参加失败');
            }
        }

    }


    /**
     * 活动-派对-已报名
     * @param $activity_id
     */
    public function memIndex($activity_id) {

        if($activity_id) {

            $actreTable = TableRegistry::get('Actregistration');
            $actres = $actreTable->find('all',
                [
                    'contain' => ['User' => function($q) {
                            return $q->select(['id', 'nick', 'birthday', 'gender', 'avatar', 'recharge']);
                        }
                    ]
                ])
                ->where(['activity_id' => $activity_id, 'Actregistration.status' => 1]);

        }
        $this->set(['pageTitle' => '美约-派对已报名', 'actres' => $actres]);

    }


    /**
     * 活动-头牌
     */
    public function getTopList($type = 'week')
    {
        try {
            $this->loadComponent('Business');
            $FlowTable = \Cake\ORM\TableRegistry::get('Flow');
            $user = null;
            if($this->user) {
                $user = $this->user;
            }
            $limit = 10;
            $where = Array(
            );

            if('week' == $type) {
                $where['Flow.create_time >='] = new Time('last sunday');
            } else if('month' == $type) {
                $da = new Time();
                $where['Flow.create_time >='] =
                    new Time(
                        new Time($da->year . '-' . $da->month . '-' . '01 00:00:00')
                    );
            }

            $i = 1;
            $query = $FlowTable->find()
                ->contain([
                    'User'=>function($q){
                        return $q
                            ->select(['id','avatar','nick','phone','gender','birthday'])
                            ->where(['gender'=>2]);
                    },
                ])
                ->select(['user_id','total'=>'sum(amount)'])
                ->where($where)
                ->group('user_id')
                ->orderDesc('total')
                ->limit($limit)
                ->map(function($row) use(&$i, $user) {
                    $row['user']['age'] = getAge($row['user']['birthday']);
                    $row['index'] = $i;
                    $row['ishead'] = false;
                    if($user) {
                        $row['ismale'] = ($user->gender == 1)?true:false;
                    }
                    $i++;
                    return $row;
                });
            $tops = $query->toArray();
            $mytop = Array();

            if($user) {
                if($user->gender == 2) {
                    $mytop = $this->Business->getMyTop($type, $this->user->id);
                }
            }
            return $this->Util->ajaxReturn(['datas'=>$tops, 'mydata' => $mytop, 'status' => true]);
        } catch(Exception $e) {
            return $this->Util->ajaxReturn(false, '服务器大姨妈啦~~');
        }

    }


    /**
     * 活动-头牌-土豪榜
     */
    public function getRichList()
    {

        try {
            $userTb = TableRegistry::get('User');
            //我关注过的人
            $user = null;
            $followlist = [];
            $mypaiming = null;
            if($this->user) {
                //获取我的排名
                //该算法需要优化
                if($this->user->recharge > 0 && $this->user->gender == 1) {
                    $mypaiming = $userTb->find()->select(['recharge'])->where(['recharge >' => $this->user->recharge, 'gender' => 1])->count() + 1;
                    $this->user->paiming = $mypaiming;
                }
                $user = $this->user;
                $followTb = TableRegistry::get('UserFans');
                if($user) {
                    $followlist = $followTb->find('all')->where(['user_id' => $this->user->id])->toArray();
                }
            }
            $i = 1;
            $richs = $userTb->find()
                ->select(['recharge', 'consumed', 'nick', 'id', 'avatar'])
                ->where(['recharge >' => 0])
                ->orderDesc('recharge')
                ->limit(10)
                ->map(function($row) use(&$i, $followlist, $user) {
                    //检查是否关注
                    $row['followed'] = false;
                    if($user) {
                        foreach($followlist as $item) {
                            if($item->following_id == $row->id) {
                                $row['followed'] = true;
                            }
                        }
                    }

                    //判断我的性别
                    $row['ismale'] = true;
                    if(!$user || $user->gender == 2) {
                        $row['ismale'] = false;
                    }
                    $row['index'] = $i;
                    $i++;
                    return $row;
                });
            //旧的算法
            /*$FlowTable = \Cake\ORM\TableRegistry::get('Flow');
            $followTb = TableRegistry::get('UserFans');
            $followlist = [];
            if($user) {
                $followTb->find('all')->where(['user_id' => $this->user->id]);
            }
            $i = 1;
            $query = $FlowTable->find()
                ->contain([
                    'Buyer'=>function($q){
                        return $q->select(['id','avatar','nick','phone','gender', 'birthday'])
                            ->where(['gender'=>1]);
                    },
                ])
                ->select(['buyer_id','total'=>'sum(amount)'])
                ->where(['type'=>4])
                ->group('buyer_id')
                ->orderDesc('total')
                ->map(function($row) use(&$i, $followlist, $user) {
                    //检查是否关注
                    $row['followed'] = false;
                    foreach($followlist as $item) {
                        if($item->following_id == $row->buyer->id) {
                            $row['followed'] = true;
                        }
                    }
                    //判断我的性别
                    $row['ismale'] = true;
                    if(!$user || $user->gender == 2) {
                        $row['ismale'] = false;
                    }
                    $row['buyer']['age'] = getAge($row['buyer']['birthday']);
                    $row['index'] = $i;
                    if($i == 1) {
                        $row['ishead'] = true;
                    } else {
                        $row['ishead'] = false;
                    }
                    $i++;
                    return $row;
                });*/
            return $this->Util->ajaxReturn(['datas'=>$richs, 'mydata' => $this->user, 'status' => true]);
        } catch(Exception $e) {
            return $this->Util->ajaxReturn(false, '服务器大姨妈啦~~');
        }
    }
}
