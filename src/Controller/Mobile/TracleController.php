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
     * 约拍
     */
    public function tracleOrder(){
        $this->set(['pageTitle' => '免费约拍报名']);
    }
    
}
