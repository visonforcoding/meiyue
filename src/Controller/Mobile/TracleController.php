<?php

namespace App\Controller\Mobile;

use App\Controller\Mobile\AppController;
use App\Model\Entity\User;
use Cake\Database\Expression\QueryExpression;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use SerRight;
use ServiceType;

/**
 * Userc Controller 动态
 *
 * @property \App\Model\Table\UserTable $User
 * @property \App\Controller\Component\SmsComponent $Sms
 */
class TracleController extends AppController {

    public function initialize() {
        parent::initialize();
    }

    /**
     * 获取动态列表
     * @param type $page
     * @return type
     */
    public function getTracleList($page){
        $user_id = $this->user->id;
        $MovementTable = TableRegistry::get('Movement');
        $movements = $MovementTable->find()
                   ->contain([
                       'User'=>function($q){
                            return $q->select(['id','avatar','nick']);
                       }
                   ]) 
                   ->where(['user_id'=>$user_id,'Movement.status'=>2])
                   ->orderDesc('Movement.create_time')
                   ->limit(10)
                   ->page($page)
                   ->formatResults(function($items) {
                        return $items->map(function($item) {
                            $item['images'] = unserialize($item['images']);
                             //时间语义化转换
                            $item['create_time'] = (new Time($item['create_time']))->timeAgoInWords(
                                    [ 'accuracy' => [
                                            'year' => 'year',
                                            'month' => 'month',
                                            'week' => 'week',
                                            'day' => 'day',
                                            'hour' => 'hour'
                                        ], 'end' => '+10 year']
                            );
                            return $item;
                        });
                    })
                   ->toArray();
        return $this->Util->ajaxReturn(['movements'=>$movements]);
    }


    /**
     * 查看美女动态
     */
    public function browse($uid) {
        $this->handCheckLogin();
        if($this->request->is('POST')) {
            $this->loadComponent('Business');
            //检查权限和名额剩余
            $res = $this->Business->checkRight($this->user->id, $uid, ServiceType::BROWSE);
            return $this->Util->ajaxReturn(['right' => $res]);
        }
    }


    /**
     * 她的动态
     */
    public function taTracle($uid) {
        $this->handCheckLogin();
        $this->autoRender = false;
        $this->loadComponent('Business');
        //检查权限和名额剩余
        $res = $this->Business->consumeRight($this->user->id, $uid, ServiceType::BROWSE);
        if($res) {
            $uTb = TableRegistry::get('User');
            $user = $uTb->get($uid);
            $this->set([
                "user" => $user,
                'pageTitle' => $user->nick.'的动态'
            ]);
            $this->render();
        }
    }


    /**
     * 查看基本视频
     */
    public function seeBvideo($uid)
    {
        $this->handCheckLogin();
        $this->autoRender = false;
        $this->loadComponent('Business');
        //检查权限和名额剩余
        $res = $this->Business->consumeRight($this->user->id, $uid, ServiceType::BROWSE);
        if($res) {
            $uTb = TableRegistry::get('User');
            $user = $uTb->get($uid);
            return $this->Util->ajaxReturn(['status' => true, 'video'=>$user->video, 'video_cover' => $user->video_cover]);
        }
        return $this->Util->ajaxReturn(['status' => false, 'msg' => '无法查看']);
    }


    /**
     * 获取她的动态
     */
    public function getTaTracles($page, $uid) {
        $this->handCheckLogin();
        $this->loadComponent('Business');
        //检查权限和名额剩余
        $res = $this->Business->checkRight($this->user->id, $uid, ServiceType::BROWSE);
        if($res == SerRight::OK_CONSUMED) {
            //检查是否关注过
            $uFanTb = TableRegistry::get('UserFans');
            $ufan = $uFanTb->find()->where(['user_id' => $this->user->id, 'following_id' => $uid])->count();
            $followed = false;
            if($ufan) {
                $followed = true;
            }

            $MovementTable = TableRegistry::get('Movement');
            $movements = $MovementTable->find()
                ->contain([
                    'User'=>function($q){
                        return $q->select(['id','avatar','nick']);
                    },
                    'Mvpraises' => function($q) {
                        return $q->where(['user_id' => $this->user->id]);
                    }
                ])
                ->where(['user_id'=>$uid,'Movement.status'=>2])
                ->orderDesc('Movement.create_time')
                ->limit(10)
                ->page($page)
                ->formatResults(function($items) use($followed){
                    return $items->map(function($item) use($followed){
                        $item['user']['avatar'] = generateImgUrl($item['user']['avatar']);
                        $item['images'] = unserialize($item['images']);
                        /*foreach ($item['images'] as &$img) {
                            $img = generateImgUrl($img);
                        }*/
                        //时间语义化转换
                        $item['create_time'] = (new Time($item['create_time']))->timeAgoInWords(
                            [ 'accuracy' => [
                                'year' => 'year',
                                'month' => 'month',
                                'week' => 'week',
                                'day' => 'day',
                                'hour' => 'hour'
                            ], 'end' => '+10 year']
                        );
                        $item['followed'] = $followed;
                        $item['view_nums'] ++;
                        if(count($item['mvpraises']) > 0) {
                            $item['praised'] = true;
                        } else {
                            $item['praised'] = false;
                        }
                        $item['ispraised'] = count($item['mvpraises']) > 0;
                        return $item;
                    });
                })
                ->toArray();

            //修改动态阅读次数
            $mvids = [];
            foreach($movements as $movement) {
                $mvids[] = $movement->id;
            }
            if($mvids) {
                $expression = new QueryExpression('view_nums = view_nums + 1');
                $MovementTable->updateAll([$expression], ['id IN' => $mvids]);
            }
            return $this->Util->ajaxReturn(['movements'=>$movements]);
        }
        return $this->Util->ajaxReturn(['movements'=>[]]);
    }


    /**
     * 删除动态
     */
    public function delete($mvid)
    {
        $this->handCheckLogin();
        if($this->request->is('POST')) {
            $mvTb = TableRegistry::get('Movement');
            $entity = $mvTb->get($mvid);
            if($mvTb->delete($entity)) {
                return $this->Util->ajaxReturn(true, '删除成功');
            };
            return $this->Util->ajaxReturn(false, '删除失败');
        }
    }


    /**
     * 点赞
     */
    public function praise($mvid) {
        $this->handCheckLogin();
        if($this->request->is('POST')) {
            //不是的话就不可以点赞
            if($this->user->gender != 1) {
                return $this->Util->ajaxReturn(false, '女性不可以给女性点赞哦');
            }
            //是否点赞过
            $praiseTb = TableRegistry::get('Mvpraise');
            $praise = $praiseTb
                ->find()
                ->where(['movement_id' => $mvid, 'user_id' => $this->user->id])
                ->first();
            if($praise) {
                //点赞过了则取消点赞
                $res = $praiseTb->connection()->transactional(function() use($praiseTb, $praise, $mvid){
                    $delres = $praiseTb->delete($praise);
                    $mvTb = TableRegistry::get('Movement');
                    $upres = $mvTb->connection()->execute('UPDATE lm_movement SET praise_nums = praise_nums - 1 WHERE id = ? and praise_nums > ?', [$mvid, 0]);
                    return $delres&&$upres;
                });
                if($res) {
                    return $this->Util->ajaxReturn([
                        'status'=> true,
                        'msg' => '取消点赞成功',
                        'act' => 2]);
                }else {
                    return $this->Util->ajaxReturn(false, '取消点赞失败');
                }
            } else {
                $praise = $praiseTb->newEntity([
                    'movement_id' => $mvid,
                    'user_id' => $this->user->id,
                ]);
                $res = $praiseTb->connection()->transactional(function() use($praiseTb, $praise, $mvid){
                    $addres = $praiseTb->save($praise);
                    $mvTb = TableRegistry::get('Movement');
                    $upres = $mvTb->connection()->execute('UPDATE lm_movement SET praise_nums = praise_nums + 1 WHERE id = ?', [$mvid]);
                    return $addres&&$upres;
                });
                if($res) {
                    return $this->Util->ajaxReturn([
                        'status'=> true,
                        'msg' => '点赞成功',
                        'act' => 1
                    ]);
                }
                return $this->Util->ajaxReturn(false, '点赞失败');
            }
        }
        return $this->Util->ajaxReturn(false, '非法请求');
    }


    /**
     * 约拍
     */
    public function tracleOrder(){
        $this->handCheckLogin();
        $yuepaiTb = TableRegistry::get('Yuepai');
        $yuepais = $yuepaiTb
            ->find()
            ->where(['act_time >' => new Time()])
            ->map(function($row) {
                $actTime = new Time($row->act_time);
                $row->act_date = $actTime->i18nFormat('MM月dd日');
                $row->act_week = getWeekStr($actTime->format('w') + 1);
                return $row;
            });
        $this->set(['datas' => $yuepais->toArray(), 'pageTitle' => '免费约拍报名']);
    }

    /**
     * 约拍申请
     * @param $userid
     * @param $yuepaid
     */
    public function yuepaiApply() {
        $this->handCheckLogin();
        if($this->request->is('POST')) {
            $yuepaiUserTb = TableRegistry::get('YuepaiUser');
            $yuepaiUser = $yuepaiUserTb->newEntity();
            $yuepaiUser = $yuepaiUserTb->patchEntity($yuepaiUser, $this->request->data);
            $yuepaiUser->checked = 2;
            $yuepaiUser->user_id = $this->user->id;
            //检查是否申请过
            $tmp = $yuepaiUserTb
                    ->find()
                    ->where([
                        'yuepai_id' => $yuepaiUser->yuepai_id,
                        'user_id' => $this->user->id
                    ])
                    ->first();
            if($tmp) {
                return $this->Util->ajaxReturn(false, '已经申请过了哦');
            }
            //同步约拍
            $yuepaiTb = TableRegistry::get('Yuepai');
            $yuepai = $yuepaiTb->get($yuepaiUser->yuepai_id);
            if($yuepai->rest_num < 1) {
                return $this->Util->ajaxReturn(false, '名额不足');
            } else {
                $yuepai->rest_num --;
            }

            $transRes = $yuepaiTb
                ->connection()
                ->transactional(function()use($yuepaiTb, $yuepai, $yuepaiUserTb, $yuepaiUser){
                    return $yuepaiTb->save($yuepai)&&$yuepaiUserTb->save($yuepaiUser);
                });
            if($transRes) {
                return $this->Util->ajaxReturn(true, '申请成功');
            }
            return $this->Util->ajaxReturn(false, '申请失败');
        }
        return $this->Util->ajaxReturn(false, '非法操作');
    }

}
