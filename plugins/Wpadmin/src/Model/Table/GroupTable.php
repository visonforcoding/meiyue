<?php

namespace Wpadmin\Model\Table;

use Admin\Model\Entity\Group;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CwpGroup Model
 *
 */
class GroupTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('lm_group');
        $this->alias('g');
        $this->displayField('name');
        $this->hasMany('Admin', [
            'className' => 'Admin.Admin',
            'joinTable' => 'cwp_admin_group',
            'foreignKey' => 'group_id',
            'dependent' => true
        ]);
        $this->belongsToMany('menu', [
            'className' => 'Wpadmin.Menu',
            'joinTable' => 'lm_group_menu',
            'foreignKey' => 'group_id',
            'targetForeignKey' => 'menu_id'
        ]);
        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'ctime' => 'new',
                    'utime' => 'always'
                ]
            ]
        ]);
        $this->primaryKey('id');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator) {
        $validator
                ->add('Id', 'valid', ['rule' => 'numeric'])
                ->allowEmpty('Id', 'create');

        $validator
                ->requirePresence('name', 'create')
                ->notEmpty('name')
                ->add('name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
                ->requirePresence('remark', 'create')
                ->notEmpty('remark');


        return $validator;
    }

}
