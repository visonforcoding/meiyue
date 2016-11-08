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
     * 显示技能表选择框
     */
    public function skillsView($container_id = '')
    {
        $this->loadModel("Skill");
        $list = $this->Skill->find("threaded")->toArray();
        $this->set(["list" => $list, "container_id" => $container_id]);
    }


    /**
     * 显示价格表选择框
     */
    public function costsView($container_id = '')
    {
        $this->loadModel("Cost");
        $list = $this->Cost->find("threaded")->toArray();
        $this->set(["list" => $list, "container_id" => $container_id]);
    }



    /**
     * 显示标签列表选择框
     *
     */
    public function tagsView($container_id = '')
    {
        $this->loadModel("Tag");
        $list = $this->Tag->find("threaded")->toArray();
        $this->set(["list" => $list, "container_id" => $container_id]);
    }
}
