<?php
namespace App\View\Cell;

use Cake\View\Cell;

/**
 * Dates cell
 */
class DatesCell extends Cell
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
     * 显示技能表选择框
     */
    public function skillsView($container_id = '')
    {
        $this->loadModel("Skills");
        $list = $this->Skills->find("threaded")->toArray();
        $this->set(["list" => $list, "container_id" => $container_id]);
    }


    /**
     * 显示价格表选择框
     */
    public function costsView($container_id = '')
    {
        $this->loadModel("Costs");
        $list = $this->Costs->find("threaded")->toArray();
        $this->set(["list" => $list, "container_id" => $container_id]);
    }



    /**
     * 显示标签列表选择框
     *
     */
    public function tagsView($container_id = '')
    {
        $this->loadModel("Tag");
        $list = $this->Tags->find("threaded")->toArray();
        $this->set(["list" => $list, "container_id" => $container_id]);
    }
}
