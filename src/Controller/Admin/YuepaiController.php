<?php
namespace App\Controller\Admin;

use Wpadmin\Controller\AppController;
use YuepaiStatus;

/**
 * Yuepai Controller
 *
 * @property \App\Model\Table\CostTable $Cost
 */
class YuepaiController extends AppController
{

    /**
    * Index method
    *
    * @return void
    */
    public function index()
    {
        $this->set('yuepai', $this->Yuepai);
    }

    /**
     * View method
     *
     * @param string|null $id Cost id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->viewBuilder()->autoLayout(false);
        $cost = $this->Cost->get($id, [
            'contain' => []
        ]);
        $this->set('cost', $cost);
        $this->set('_serialize', ['cost']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $yuepai = $this->Yuepai->newEntity();
        if ($this->request->is('post')) {
            $yuepai = $this->Yuepai->patchEntity($yuepai, $this->request->data);
            if ($this->Yuepai->save($yuepai)) {
                 $this->Util->ajaxReturn(true,'添加成功');
            } else {
                 $errors = $yuepai->errors();
                 $this->Util->ajaxReturn([
                     'status'=>false,
                     'msg'=>getMessage($errors),
                     'errors'=>$errors
                 ]);
            }
        }
        $this->set(compact('yuepai'));
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
        $yuepai = $this->Yuepai->get($id,[
            'contain' => []
        ]);
        if ($this->request->is(['post','put'])) {
            $yuepai = $this->Yuepai->patchEntity($yuepai, $this->request->data);
            if ($this->Yuepai->save($yuepai)) {
                  $this->Util->ajaxReturn(true,'修改成功');
            } else {
                 $errors = $yuepai->errors();
               $this->Util->ajaxReturn(false,getMessage($errors));
            }
        }
                  $this->set(compact('yuepai'));
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
                $yuepai = $this->Yuepai->get($id);
                 if ($this->Yuepai->delete($yuepai)) {
                     $this->Util->ajaxReturn(true,'删除成功');
                } else {
                    $errors = $yuepai->errors();
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
            $sort = 'Yuepai.'.$this->request->data('sidx');
            $order = $this->request->data('sord');
            $keywords = $this->request->data('keywords');
            $begin_time = $this->request->data('begin_time');
            $end_time = $this->request->data('end_time');
            $where = [];
            if (!empty($keywords)) {
                $where[' name like'] = "%$keywords%";
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
