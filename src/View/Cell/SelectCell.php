<?php

namespace App\View\Cell;

use Cake\View\Cell;

/**
 * Select cell
 */
class SelectCell extends Cell {

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
    public function display() {
        
    }

    public function place() {
        $AreaTable = \Cake\ORM\TableRegistry::get('Area');
        $proviceAreas = $AreaTable->find()->where(['status' => 1, '`type`' => 2])->toArray();
        $this->set([
            'proviceAreas' => $proviceAreas
        ]);
    }

}
