<?php
namespace App\View\Cell;

use Cake\View\Cell;

/**
 * Dates cell
 */
class DateCell extends Cell
{

    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    /**
     * Default display method.
     *
     * @return void
     */
    public function display()
    {
    }


    /**
     * 显示后台技能表选择框
     */
    public function adminSkillsView()
    {
        $SkillTable = \Cake\ORM\TableRegistry::get('Skill');
        $skills = $SkillTable->find('threaded')->toArray();
        $this->set([
            'skills'=>$skills
        ]);
    }


    /**
     * 显示用户技能表选择框
     */
    public function skillsView($user_id)
    {
        $UserSkillTable = \Cake\ORM\TableRegistry::get('UserSkill');
        $topSkills = $this->getTopSkill();
        $userSkills = $UserSkillTable->find()->contain(['Skill', 'Cost'])->where(['UserSkill.user_id'=>$user_id, 'UserSkill.is_used' => 1, 'UserSkill.is_checked' => 1])->toArray();
        $this->set([
            'topSkills'=>$topSkills,
            'userSkills'=>$userSkills
        ]);
    }


    /**
     * 显示价格表选择框
     */
    public function costsView()
    {
        $this->loadModel("Cost");
        $list = $this->Cost->find("threaded")->toArray();
        $this->set(["list" => $list]);
    }



    /**
     * 显示标签列表选择框
     *
     */
    public function tagsView()
    {
        $this->loadModel("Tag");
        $list = $this->Tag->find("threaded")->toArray();
        $this->set(["list" => $list]);
    }


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
}
