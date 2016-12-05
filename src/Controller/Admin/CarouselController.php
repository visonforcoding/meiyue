<?php
namespace App\Controller\Admin;

use Wpadmin\Controller\AppController;

/**
 * Carousel Controller
 *
 * @property \App\Model\Table\CostTable $Cost
 */
class CarouselController extends AppController
{

    /**
    * Index method
    *
    * @return void
    */
    public function index()
    {
        $this->set([
            'carousels' => $this->Carousel,
            'pageTitle' => '轮播管理 ',
            'bread' => [
                'first' => ['name' => '基础管理'],
                'second' => ['name' => '轮播管理'],
            ],
        ]);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $carousel = $this->Carousel->newEntity();
        if ($this->request->is('post')) {
            $carousel = $this->Carousel->patchEntity($carousel, $this->request->data);
            if ($this->Carousel->save($carousel)) {
                 $this->Util->ajaxReturn(true,'添加成功');
            } else {
                 $errors = $carousel->errors();
                 $this->Util->ajaxReturn([
                     'status'=>false,
                     'msg'=>getMessage($errors),
                     'errors'=>$errors
                 ]);
            }
        }
        $this->set(compact('carousel'));
        $this->set([
            'pageTitle' => '添加轮播',
            'bread' => [
                'first' => ['name' => '轮播管理'],
                'second' => ['name' => '添加轮播'],
            ],
        ]);
    }

    /**
     * Edit method
     *
     * @param string|null $id Cost id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $carousel = $this->Carousel->get($id,[
        ]);
        if ($this->request->is(['post','put'])) {
            $carousel = $this->Carousel->patchEntity($carousel, $this->request->data);
            if ($this->Carousel->save($carousel)) {
                  $this->Util->ajaxReturn(true,'修改成功');
            } else {
                 $errors = $carousel->errors();
               $this->Util->ajaxReturn(false,getMessage($errors));
            }
        }
        $this->set(compact('carousel'));
        $this->set([
            'pageTitle' => '添加轮播',
            'bread' => [
                'first' => ['name' => '轮播管理'],
                'second' => ['name' => '编辑轮播'],
            ],
        ]);
    }

    /**
     * Delete method
     *
     * @param string|null $id Cost id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod('post');
         $id = $this->request->data('id');
                if ($this->request->is('post')) {
                $carousel = $this->Carousel->get($id);
                 if ($this->Carousel->delete($carousel)) {
                     $this->Util->ajaxReturn(true,'删除成功');
                } else {
                    $errors = $carousel->errors();
                    $this->Util->ajaxReturn(true,getMessage($errors));
                }
          }
    }


    /**
    * get jqgrid data
    *
    * @return json
    */
    public function getDataList()
    {
            $this->request->allowMethod('ajax');
            $page = $this->request->data('page');
            $rows = $this->request->data('rows');
            $sort = 'Carousel.'.$this->request->data('sidx');
            $order = $this->request->data('sord');
            $keywords = $this->request->data('keywords');
            $begin_time = $this->request->data('begin_time');
            $end_time = $this->request->data('end_time');
            $where = [];
            if (!empty($keywords)) {
                $where[' position like'] = "%$keywords%";
            }
            if (!empty($begin_time) && !empty($end_time)) {
                $begin_time = date('Y-m-d', strtotime($begin_time));
                $end_time = date('Y-m-d', strtotime($end_time));
                $where['and'] = [
                    ['date(`act_time`) >' => $begin_time],
                    ['date(`act_time`) <' => $end_time]
                ];
            }
            $data = $this->getJsonForJqrid($page, $rows, '', $sort, $order,$where);
            $this->autoRender = false;
            $this->response->type('json');
            $this->response->body(json_encode($data));
            $this->response->send();
            $this->response->stop();
    }

}
