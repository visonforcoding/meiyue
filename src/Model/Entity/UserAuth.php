<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * UserAuth Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $front
 * @property string $back
 * @property string $person
 * @property \Cake\I18n\Time $create_time
 *
 * @property \App\Model\Entity\User $user
 */
class UserAuth extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
