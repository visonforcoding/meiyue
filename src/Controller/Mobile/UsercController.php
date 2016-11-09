<?php

namespace App\Controller\Mobile;

use App\Controller\Mobile\AppController;
use Cake\I18n\Time;

/**
 * Userc Controller 个人中心
 *
 * @property \App\Model\Table\UserTable $User
 */
class UsercController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadModel('User');
    }

    /**
     * 美女粉丝
     */
    public function fans($page=null) {
        $this->handCheckLogin();
        if($this->request->is('json')){
            $limit = 10;
            $UserFansTable = \Cake\ORM\TableRegistry::get('UserFans');
            $fans = $UserFansTable->find()->hydrate(false)->contain(['User'=>function($q){
                    return $q->select(['id','birthday','avatar','nick']);
            }])->where(['following_id' => $this->user->id])->limit(intval($limit))
                    ->page(intval($page))->formatResults(function($items) {
                return $items->map(function($item) {
                            $item['user']['avatar'] = createImg($item['user']['avatar']) . '?w=44&h=44&fit=stretch';
                            $item['user']['age'] = (Time::now()->year) - $item['user']['birthday']->year;
                            return $item;
                        });
            })->toArray();
            $this->set(['fans' => $fans]);
        }
        $this->set(['pageTitle'=>'我的粉丝']);
    }


    /**
     * 我的-我的技能-列表
     */
    public function userSkillsIndex()
    {

        $userSkillTable = \Cake\ORM\TableRegistry::get('UserSkill');
        $query = $userSkillTable->find()->contain(['Skill', 'Cost'])
            ->select(['id', 'is_used', 'Skill.name', 'Cost.money'])
            ->where(['user_id' => $this->user->id, 'is_checked' => 1]);
        $userskills = $query->toArray();
        $is_all_used = true;
        foreach ($userskills as $item) {

            if($item['is_used'] == 0) {

                $is_all_used = false;

            }

        }
        $this->set(['userskills' => $userskills, 'is_all_used' => $is_all_used, 'user' => $this->user, 'pageTitle' => '美约-我的技能']);

    }


    /**
     * 我的-我的技能-添加、编辑技能页面
     */
    public function userSkillsView($action, $userskill_id = null)
    {

        $page_titles = Array(

            'add' => '美约-添加技能',
            'edit' => '美约-编辑技能',

        );

        $userSkillTable = \Cake\ORM\TableRegistry::get('UserSkill');;
        $userskill = null;
        if('edit' == $action) {

            $userskill = $userSkillTable->get($userskill_id, ['contain' => ['Skill', 'Cost', 'Tags']]);

        }
        $this->set(['userskill' => $userskill, 'user' => $this->user, 'pageTitle' => $page_titles[$action]]);
        $this->render('user_skills_view');

    }


    /**
     * 我的-我的技能-添加技能接口
     */
    public function userSkillSave($user_skill_id = null)
    {

        $userSkillTable = \Cake\ORM\TableRegistry::get('UserSkill');

        if($this->request->is("POST")) {

            //约定有用户技能id参数的为修改
            $userSkill = $userSkillTable->newEntity();
            $userSkill = $userSkillTable->patchEntity($userSkill, $this->request->data);
            $userSkill->user_id = $this->user->id;
            $userSkill->is_checked = 2;
            if(isset($user_skill_id)) {

                $userSkill->id = $user_skill_id;

            }
            if ($userSkillTable->save($userSkill)) {
                return $this->Util->ajaxReturn(true, "发布成功");
            } else {
                return $this->Util->ajaxReturn(false, getMessage($userSkill->errors()));
            }

        }

    }


    /**
     * 我的-我的技能-批量修改使用技能上线状态
     */
    public function updateUsedStatus($is_used, $user_skill_id = null) {

        $userSkillTable = \Cake\ORM\TableRegistry::get('UserSkill');
        if(!$user_skill_id) {

            $res = $userSkillTable->updateAll(['is_used' => $is_used], ['user_id' => $this->user->id, 'is_checked' => 1]);

        } else {

            $res = $userSkillTable->updateAll(['is_used' => $is_used], ['user_id' => $this->user->id, 'is_checked' => 1, 'id' => $user_skill_id]);

        }

        if ($res) {
            return $this->Util->ajaxReturn(true);
        } else {
            return $this->Util->ajaxReturn(false, '操作失败');
        }

    }


}
