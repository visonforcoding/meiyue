<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * UsedPackage Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $used_id
 * @property int $package_id
 * @property int $type
 * @property \Cake\I18n\Time $create_time
 * @property \Cake\I18n\Time $deadline
 */
class UsedPackage extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
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
