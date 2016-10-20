<?php

namespace Wpadmin\Controller;

use Wpadmin\Controller\AppController;
/**
 * Index Controller
 *
 * @property \Admin\Model\Table\IndexTable $Index
 */
class IndexController extends AppController {

    /**
     * Index method
     *
     * @return void
     */
    public function index() {
        //date_default_timezone_set('PRC');
        //$AdminTable = \Cake\ORM\TableRegistry::get('Wpadmin.Admin');
        //$admin = $AdminTable->get(1);
        //debug($admin->ctime);
        //echo $admin->ctime;
        $this->set('test', '这是一个后台管理页');
    }

    public function test() {
        $this->set('test', 'hello,twig');
    }

}
