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


    /**
     * 获取我的排名对象
     * @param string $type
     * @return mixed|null
     */
    public function getMyTop($type = 'week', $userid) {

        $mytop = null;
        //获取我的排名
        $FlowTable = \Cake\ORM\TableRegistry::get('Flow');
        $query = $FlowTable->find();
        $query->contain(['User' => function($q) use($userid) {
            return $q->select(['id','avatar','nick','phone','gender','birthday'])
                ->where(['User.id' => $userid]);
        }])
            ->select(['total' => 'sum(amount)'])
            ->where(['income' => 1])
            ->map(function($row) {
                $row['user']['age'] = getAge($row['user']['birthday']);
                $row['ishead'] = false;
                return $row;
            });
        $mytop = $query->first();
        $mytop->user->age = getAge($mytop->user->birthday);
        $mytop->ishead = true;

        //获取我的排名对象
        $where = Array(
            'income' => 1
        );
        if('week' == $type) {
            $where['Flow.create_time >='] = new Time('last sunday');
        } else if('month' == $type) {
            $da = new Time();
            $where['Flow.create_time >='] = new Time(new Time($da->year . '-' . $da->month . '-' . '01 00:00:00'));
        }
        $iquery = $FlowTable->find('list')
            ->contain([
                'User'=>function($q) use($mytop) {
                    return $q->where(['gender'=>2, 'User.id !=' => $mytop->user->id]);
                },
            ])
            ->select(['total' => 'sum(amount)'])
            ->where($where)
            ->group('Flow.user_id')
            ->having(['total >= ' => $mytop->total]);

        //计算排名
        $mytop->index = $iquery->count() + 1;
        return $mytop;
    }


}
