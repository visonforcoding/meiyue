<?php

namespace App\Controller\Mobile;

use App\Controller\Mobile\AppController;
use App\Model\Entity\User;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;

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
     * 她的动态
     */
    public function taTracle() {
        $this->set([
            "user" => $this->user,
            'pageTitle' => $this->user->nick.'的动态'
        ]);
    }


    /**
     * 获取她的动态
     */
    public function getTaTracles($page, $uid) {
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
     * 获取TA动态列表
     * @param type $page
     * @return type
     */
    public function getHerTracleList($page){
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
                $row->act_week = getWeekStr($actTime->format('w'));
                return $row;
            });
        $this->set(['datas' => $yuepais, 'pageTitle' => '免费约拍报名']);
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
