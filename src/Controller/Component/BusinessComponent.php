<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;

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
}
