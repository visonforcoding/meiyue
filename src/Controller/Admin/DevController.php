<?php

namespace App\Controller\Admin;

use Wpadmin\Controller\AppController;

/**
 * Dev Controller
 * 开发者页 一些开发者需要的信息
 * @property \App\Model\Table\LogTable $Log
 */
class DevController extends AppController {

    /**
     * Index method
     *
     * @return void
     */
    public function index() {
        $this->set('dev', $this->Log);
        $this->set([
            'pageTitle' => '系统面板',
            'bread' => [
                'first' => ['name' => '开发者'],
                'second' => ['name' => '系统面板'],
            ],
        ]);
    }
    
    /**
     * 检测netim 名片
     */
    public function checkNetIm(){
        $accid = $this->request->data('accid');
        $Netim = new \App\Pack\Netim();
        $res = $Netim->getUinfos([$accid]);
        if($res){
            echo json_encode($res);
            exit();
        }else{
            echo json_encode($res);
            exit();
        }
    }

}
