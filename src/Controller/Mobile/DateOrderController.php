<?php
namespace App\Controller\Mobile;

use Cake\ORM\TableRegistry;


/**
 * DateOrder Controller
 *
 * @property \App\Model\Table\DateOrderTable $DateOrder
 * @property \App\Controller\Component\BdmapComponent $Bdmap
 */
class DateOrderController extends AppController
{

    /**
     * 约会支付详情页--赴约流程
     * @param int $id
     */
    public function join($id = null)
    {

        $dateTable = TableRegistry::get("Date");
        $date = $dateTable->get($id, ['contain' => ['UserSkill' =>function($q){
            return $q->contain(['Skill', 'Cost']);}, 'Tags', 'User' => function ($q) {
            return $q->select(['nick', 'birthday', 'gender', 'money']);
        }]]);
        $this->set(['date' => $date, 'user' => $this->user]);


    }


    /**
     * 约会支付接口--赴约流程
     *
     */
    public function joinPay()
    {

    }
    
    /**
     * 约技能
     * @param type $skill_id
     */
    public function orderSkill($skill_id){
       $UserSkillTable = TableRegistry::get('UserSkill');
       $data = $UserSkillTable->get($skill_id,[
           'contain'=>[
               'User'=>function($q){
                    return $q->select(['id','avatar','birthday','nick']);
               },
               'Skill'=>function($q){
                    return $q->select(['skill_id'=>'Skill.id','name']);
               },        
               'Tags','Cost'      
           ]    
       ]);
       $this->set([
           'pageTitle'=> '约他',
           'data'=>$data,
           'user'=>  $this->user
       ]);    
    }
    
    /**
     * 选择地点
     */
    public function findPlace($page){
        $this->loadComponent('Bdmap');
        $places = $this->Bdmap->placeSearchNearBy('咖啡', $this->coord,$page);
        return $this->Util->ajaxReturn(['places'=>$places]);
    }
}
