<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * User Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Unions
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null)
 */
class UserTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('lm_user');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->hasMany('UserSkills', [
            'className' => 'UserSkill',
            'foreignKey' => 'user_id'
        ]);
        $this->belongsToMany('Tags',[
            'className'=>'Tag',
            'joinTable'=>'lm_user_tag',
            'foreignKey'=>'user_id',
            'targetForeignKey'=>'tag_id'
        ]);
        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'create_time' => 'new',
                    'update_time' => 'always'
                ]
            ]
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator) {
        $validator
                ->integer('id')
                ->allowEmpty('id', 'create');

        $validator
                ->requirePresence('phone', 'create')
                ->notEmpty('phone');

        $validator
                ->requirePresence('pwd', 'create')
                ->notEmpty('pwd');

        $validator
                ->requirePresence('user_token', 'create')
                ->notEmpty('user_token');

        $validator
                ->allowEmpty('wx_openid');

        $validator
                ->allowEmpty('app_wx_openid');

        $validator
                ->allowEmpty('truename');


        $validator
                ->allowEmpty('position');

        $validator
                ->email('email')
                ->allowEmpty('email');


        $validator
                ->allowEmpty('city');

        $validator
                ->allowEmpty('avatar');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules) {
        $rules->add($rules->isUnique(['email']));

        return $rules;
    }

}
