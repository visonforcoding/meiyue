<?php
namespace App\Controller\Mobile;

use App\Model\Entity\Activity;
use App\Model\Entity\Actregistration;
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
        $carouselTb = TableRegistry::get('Carousel');
        $carousel = $carouselTb->find()->where(['position' => CarouselPosition::TOP_BIGIMG, 'status' => 1])->first();
        $this->set([
            'curtab' => $curtab,
            "user" => $this->user,
            "carousel" => $carousel,
            'pageTitle' => '美约-活动'
        ]);
        if ($this->user) {
            if ($this->user->gender == 2) {
                $this->render('findex');
            }
        }
    }


    public function findex($curtab = 'date')
    {
        $carouselTb = TableRegistry::get('Carousel');
        $carousel = $carouselTb->find()->where(['position' => CarouselPosition::TOP_BIGIMG, 'status' => 1])->first();
        $this->set([
            'curtab' => $curtab,
            "user" => $this->user,
            "carousel" => $carousel,
            'pageTitle' => '美约-活动'
        ]);
        if ($this->user) {
            if ($this->user->gender == 1) {
                $this->render('index');
            }
        }
    }


    /**
     *  派对列表
     * @return \Cake\Network\Response|null
     */
    public function getAllDatasInPage($page)
    {
        $limit = 10;
        //添加用户参与活动状态
        $datas = $this->Activity
            ->find("all")
            ->where([
                'status' => 1,
            ]);
        $datas->limit($limit);
        $datas->orderDesc('Activity.start_time');
        $datas->page($page);
        $datas->formatResults(function (ResultSetInterface $results) {
            return $results->map(function ($row) {
                $row->time = getFormateDT($row->start_time, $row->end_time);
                $row->isend = false;
                $startTime = new Time($row->start_time);
                $curTime = new Time();
                if ((($row->male_rest == 0) && ($row->female_rest == 0)) || ($startTime <= $curTime)) {
                    $row->isend = true;
                }
                return $row;
            });

        });
        $carousel = null;
        if ($page = 1) {
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
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $activity = $this->Activity->get($id);
        //状态：0#未登录 1#我要报名(男) 2#我要报名(女) 3报名结束(男女) 4#您已报名,审核中(女) 5#您已报名,审核不通过(女) 6#报名成功(女)
        $actstatus = $this->getActStatus($activity);;
        $this->set([
            'user' => $this->user,
            'actstatus' => $actstatus,
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
    public function cancel($id = null)
    {
        $this->handCheckLogin();
        if ($this->request->is("POST")) {
            if ($id != null) {
                $actreTable = TableRegistry::get('Actregistration');
                $FlowTable = TableRegistry::get('Flow');
                $actre = $actreTable->get($id, ['contain' => 'Activity']);
                //标记报名表项取消时间
                $actre['cancel_time'] = new Time();
                $actre['status'] = 2;
                //检查当前时间是否在派对开始前XX小时
                $start_time = $actre['activity']['start_time'];
                $current_time = new Time();
                if ($current_time->diffInDays($start_time, false) >= $actre['activity']['cancelday']) {
                    $user = null;
                    $flow = null;
                    if ($this->user->gender == 1) {
                        $return_count = $actre['cost'] - $actre['punish'];
                        //生成流水
                        //扣除 报名费用
                        $pre_amount = $this->user->money;
                        $this->user->money = $this->user->money + $return_count;
                        $user = $this->user;
                        $after_amount = $this->user->money;
                        //生成流水
                        $flow = $FlowTable->newEntity([
                            'user_id' => $this->user->id,
                            'buyer_id' => 0,
                            'type' => 13,
                            'type_msg' => '取消派对返还',
                            'income' => 1,
                            'amount' => $return_count, //支付金额
                            'price' => $actre['cost'],  //订单金额
                            'pre_amount' => $pre_amount,
                            'after_amount' => $after_amount,
                            'paytype' => 1,   //余额支付
                            'remark' => "派对取消返还金额:"
                                . $actre['punish_percent'] . "%（即" . $actre['punish'] . ")",
                        ]);
                        $actre->activity->male_rest += $actre['num'];
                    } else {
                        $actre->activity->female_rest += $actre['num'];
                    }
                    $actre->dirty('activity', true);
                    $transRes = $actreTable
                        ->connection()
                        ->transactional(function () use ($flow, $FlowTable, $actre, $actreTable, $user) {
                            $UserTable = TableRegistry::get('User');
                            $saveUseres = true;
                            $flowres = true;
                            $saveActr = $actreTable->save($actre);
                            if($flow) {
                                $flow->relate_id = $actre['id'];
                                $flowres = $FlowTable->save($flow);
                            }
                            if($user) {
                                $saveUseres = $UserTable->save($user);
                            }

                            return  $flowres && $saveActr && $saveUseres;
                        });
                    if ($transRes) {
                        return $this->Util->ajaxReturn(true, '取消成功');
                    } else {
                        return $this->Util->ajaxReturn(false, '取消失败');
                    }
                } else {
                    return $this->Util->ajaxReturn(false, '无法取消！');
                }
            }
        }
        return $this->Util->ajaxReturn(false, '操作失败');
    }


    public function payView($id)
    {
        $this->handCheckLogin();
        $activity = $this->Activity->get($id);
        $lim = 1;
        if ($this->user->gender == 1) {
            $lim = $activity->male_rest;
        } else {
            $lim = $activity->female_rest;
        }
        //状态：0#未登录 1#我要报名(男) 2#我要报名(女) 3报名结束(男女) 4#您已报名,审核中(女) 5#您已报名,审核不通过(女) 6#报名成功(女)
        $actstatus = $this->getActStatus($activity);
        $this->set([
            'user' => $this->user,
            'activity' => $activity,
            'lim' => $lim,
            'actstatus' => $actstatus,
            'pageTitle' => '美约-活动支付'
        ]);
    }


    /**
     * 获取派对状态（与数据库的状态不同）
     * @param Activity $activity
     * @return int
     */
    private function getActStatus(Activity $activity)
    {
        $actTime = new Time($activity->start_time);
        $curTime = new Time();
        //状态：0#未登录 1#我要报名(男) 2#我要报名(女) 3报名结束(男女) 4#您已报名,审核中(女) 5#您已报名,审核不通过(女) 6#报名成功(女)
        $actstatus = 1;
        if (($actTime < $curTime)) {
            $actstatus = 3;
        } else if ($this->user) {
            if (($this->user->gender == 1)) {
                if ($activity->male_rest == 0) {
                    $actstatus = 3;
                }
            } else if ($this->user->gender == 2) {
                if ($activity->female_rest == 0) {
                    $actstatus = 3;
                } else {
                    $myActTb = TableRegistry::get('Actregistration');
                    $myAct = $myActTb->find()->where(['user_id' => $this->user->id, 'activity_id' => $activity->id])->orderDesc('id')->first();
                    if ($myAct) {
                        switch ($myAct->status) {
                            case 1:  //正常（审核通过）
                                $actstatus = 6;
                                break;
                            case 2:  //取消
                                $actstatus = 2;
                                break;
                            case 3:  //审核中
                                $actstatus = 4;
                                break;
                            case 4:  //审核不通过
                                $actstatus = 5;
                                break;
                        }
                    } else {
                        $actstatus = 2;
                    }
                }
            }
        } else {
            $actstatus = 0;
        }
        return $actstatus;
    }


    /**
     * 美女报名派对
     * 限每人一名额
     */
    public function join($actid)
    {
        if ($this->request->is("POST")) {
            $this->handCheckLogin();
            if($this->user->gender != 2) {
                return $this->Util->ajaxReturn(false, '报名失败');
            }
            //检查是否参与过
            $actregistrationTable = TableRegistry::get('Actregistration');
            $actregistration = $actregistrationTable
                ->find()
                ->where([
                    'user_id' => $this->user->id,
                    'activity_id' => $actid,
                ])
                ->orderDesc('id')
                ->first();
            if ($actregistration) {
                if (!($actregistration->status == 2)) {
                    return $this->Util->ajaxReturn(false, '您已报名');
                }
            }

            //生成报名表
            $activity = null;
            try {
                $activity = $this->Activity->get($actid);
                $activity->female_rest --;
            } catch (Exception $e) {
                return $this->Util->ajaxReturn(false, '报名失败');
            }
            $actregistration = $actregistrationTable->newEntity([
                'user_id' => $this->user->id,
                'activity_id' => $actid,
                'status' => 3,
                'cost' => 0,
                'punish' => 0,
                'punish_percent' => $activity['punish_percent'],
                'num' => 1
            ]);
            $activityTable = $this->Activity;
            $transRes = $actregistrationTable
                ->connection()
                ->transactional(
                    function () use (
                        &$actregistration,
                        $actregistrationTable,
                        &$activity,
                        $activityTable
                    ) {
                        $saveActr = $actregistrationTable->save($actregistration);
                        $saveAct = $activityTable->save($activity);
                        return $saveActr
                        && $saveAct;
                    });
            if ($transRes) {
                return $this->Util->ajaxReturn(true, '报名成功');
            } else {
                return $this->Util->ajaxReturn(false, '报名失败');
            }
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
    public function mpay($id, $num = 1)
    {
        //参加活动
        if ($this->request->is("POST")) {
            $this->handCheckLogin();
            $activity = $this->Activity->get($id, ['contain' => ['Actregistrations' => function ($q) {
                return $q->contain(['User' => function ($q) {
                    return $q->select(['User.id', 'User.gender']);
                }])
                    ->where(['Actregistrations.status' => 1]);
            }]]);
            $actregistrationTable = TableRegistry::get('Actregistration');
            //获取需要费用
            //检查报名人数是否已满
            $price = 0;
            if ($this->user->gender == 1) {
                $price = $activity['male_price'];
                if ($activity->male_rest == 0) {
                    return $this->Util->ajaxReturn(false, '报名人数已满！');
                }
            } else {
                $price = $activity['female_price'];
                if ($activity->female_rest == 0) {
                    return $this->Util->ajaxReturn(false, '报名人数已满！');
                }
            }
            //判断余额是否充足
            if ($this->user->money < $price * $num && $price) {
                return $this->Util->ajaxReturn(false, '美币余额不足！');
            }

            //修改活动表项
            if ($this->user->gender == 1) {
                if ($activity->male_rest < $num) {
                    return $this->Util->ajaxReturn(false, '报名名额不足！');
                }
                $activity->male_rest -= $num;
            } else {
                if ($activity->female_rest < $num) {
                    return $this->Util->ajaxReturn(false, '报名名额不足！');
                }
                $activity->female_rest -= $num;
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
                'user_id' => 0,
                'buyer_id' => $this->user->id,
                'type' => 13,
                'type_msg' => '报名派对支出',
                'income' => 2,
                'amount' => $price * $num,
                'price' => $price * $num,
                'pre_amount' => $pre_amount,
                'after_amount' => $after_amount,
                'paytype' => 1,   //余额支付
                'remark' => '数量*' . $num
            ]);

            $activityTable = $this->Activity;
            $transRes = $actregistrationTable
                ->connection()
                ->transactional(
                    function () use (
                        &$flow,
                        $FlowTable,
                        &$actregistration,
                        $actregistrationTable,
                        &$activity,
                        $activityTable,
                        &$user
                    ) {
                        $UserTable = TableRegistry::get('User');
                        $saveActr = $actregistrationTable->save($actregistration);
                        $flow->relate_id = $actregistration['id'];
                        $saveAct = $activityTable->save($activity);
                        return $FlowTable->save($flow)
                        && $saveActr
                        && $saveAct
                        && $UserTable->save($user);
                    });

            if ($transRes) {
                return $this->Util->ajaxReturn(true, '参加成功');
            } else {
                return $this->Util->ajaxReturn(false, '参加失败');
            }
        }
    }


    /**
     * 活动-派对-已报名
     * @param $activity_id
     */
    public function memIndex($activity_id)
    {
        if ($activity_id) {
            $actreTable = TableRegistry::get('Actregistration');
            $actres = $actreTable->find('all',
                [
                    'contain' => ['User' => function ($q) {
                        return $q->select(['id', 'nick', 'birthday', 'gender', 'avatar', 'recharge']);
                    }
                    ]
                ])
                ->where(['activity_id' => $activity_id, 'Actregistration.status' => 1]);

        }
        $this->set(['pageTitle' => '美约-派对已报名', 'actres' => $actres, 'user' => $this->user]);
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
            if ($this->user) {
                $user = $this->user;
            }
            $limit = 99;
            $where = Array();

            if ('week' == $type) {
                $where['Flow.create_time >='] = new Time('last sunday');
            } else if ('month' == $type) {
                $da = new Time();
                $where['Flow.create_time >='] =
                    new Time(
                        new Time($da->year . '-' . $da->month . '-' . '01 00:00:00')
                    );
            }

            $i = 1;
            $query = $FlowTable->find()
                ->contain([
                    'User' => function ($q) {
                        return $q
                            ->select(['id', 'avatar', 'nick', 'phone', 'gender', 'birthday'])
                            ->where(['gender' => 2]);
                    },
                ])
                ->select(['user_id', 'total' => 'sum(amount)'])
                ->where($where)
                ->group('user_id')
                ->orderDesc('total')
                ->limit($limit)
                ->map(function ($row) use (&$i, $user) {
                    $row['user']['age'] = getAge($row['user']['birthday']);
                    $row['index'] = $i;
                    $row['ishead'] = false;
                    if ($user) {
                        $row['ismale'] = ($user->gender == 1) ? true : false;
                    }
                    $i++;
                    return $row;
                });
            $tops = $query->toArray();
            $mytop = Array();

            if ($user) {
                if ($user->gender == 2) {
                    $mytop = $this->Business->getMyTop($type, $this->user->id);
                }
            }
            return $this->Util->ajaxReturn(['datas' => $tops, 'mydata' => $mytop, 'status' => true]);
        } catch (Exception $e) {
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
            if ($this->user) {
                //获取我的排名
                //该算法需要优化
                if ($this->user->recharge > 0 && $this->user->gender == 1) {
                    $mypaiming = $userTb->find()->select(['recharge'])->where(['recharge >' => $this->user->recharge, 'gender' => 1])->count() + 1;
                    $this->user->paiming = $mypaiming;
                }
                $user = $this->user;
                $followTb = TableRegistry::get('UserFans');
                if ($user) {
                    $followlist = $followTb->find('all')->where(['user_id' => $this->user->id])->toArray();
                }
            }
            $i = 1;
            $richs = $userTb->find()
                ->select(['recharge', 'consumed', 'nick', 'id', 'avatar'])
                ->where(['recharge >' => 0, 'gender' => 1])
                ->orderDesc('recharge')
                ->limit(99)
                ->map(function ($row) use (&$i, $followlist, $user) {
                    //检查是否关注
                    $row['followed'] = false;
                    if ($user) {
                        foreach ($followlist as $item) {
                            if ($item->following_id == $row->id) {
                                $row['followed'] = true;
                            }
                        }
                    }

                    //判断我的性别
                    $row['ismale'] = true;
                    if (!$user || $user->gender == 2) {
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
            return $this->Util->ajaxReturn(['datas' => $richs, 'mydata' => $this->user, 'status' => true]);
        } catch (Exception $e) {
            return $this->Util->ajaxReturn(false, '服务器大姨妈啦~~');
        }
    }
}
