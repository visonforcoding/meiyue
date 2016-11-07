<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * UserSkills Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Skills
 * @property \Cake\ORM\Association\BelongsTo $Costs
 *
 * @method \App\Model\Entity\UserSkill get($primaryKey, $options = [])
 * @method \App\Model\Entity\UserSkill newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\UserSkill[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\UserSkill|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UserSkill patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\UserSkill[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\UserSkill findOrCreate($search, callable $callback = null)
 */
class UserSkillTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('lm_user_skill');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Skills', [
            'foreignKey' => 'skill_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Costs', [
            'foreignKey' => 'cost_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsToMany('Tags', [
            'joinTable' => 'lm_user_skill_tag',
            'dependent' => false,
            'foreignKey' => 'tag_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('desc', 'create')
            ->notEmpty('desc');

        $validator
            ->integer('is_used')
            ->requirePresence('is_used', 'create')
            ->notEmpty('is_used');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['skill_id'], 'Skills'));
        $rules->add($rules->existsIn(['cost_id'], 'Costs'));

        return $rules;
    }

    /**
     * 获取审核状态
     * @param int $status_code
     * @return array|mixed|string
     */
    public static function getCheckStatus($status_code = -1) {

        $status = Array(

            2 => "未审核",
            1 => "通过",
            0 => "不通过",

        );

        if($status_code != -1) {

            return isset($status[$status_code])?$status[$status_code]:"未知状态";

        } else {

            return $status;

        }

    }


    /**
     * 获取启用状态
     * @param int $status_code
     * @return array|mixed|string
     */
    public static function getUsedStatus($status_code = -1) {

        $status = Array(

            0 => "禁用",
            1 => "启用",

        );

        if($status_code != -1) {

            return isset($status[$status_code])?$status[$status_code]:"未知状态";

        } else {

            return $status;

        }

    }

}
