<?php
namespace App\Controller\Admin;

use CheckStatus;
use Wpadmin\Controller\AppController;

/**
 * YuepaiUser Controller
 *
 * @property \App\Model\Table\CostTable $Cost
 */
class YuepaiUserController extends AppController
{

    /**
    * Index method
    *
    * @return void
    */
    public function index()
    {
        $this->set('yuepaiUser', $this->YuepaiUser);
    }


    public function check($id, $status) {
        if($this->request->is('POST')) {
            $yuepaiu = $this->YuepaiUser->get($id);
            if(!CheckStatus::getStatus($status)) {
                $this->Util->ajaxReturn([
                    'status'=>false,
                    'msg'=>'参数异常',
                ]);
            } else {
                $yuepaiu->checked = $status;
            }

            if($this->YuepaiUser->save($yuepaiu)) {
                $this->Util->ajaxReturn([
                    'status'=>true,
                    'msg'=>'操作成功',
                ]);
            } else {
                $this->Util->ajaxReturn([
                    'status'=>false,
                    'msg'=>'操作失败',
                    'error' => $yuepaiu->errors()
                ]);
            }
        }
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
                $yuepaiuser = $this->YuepaiUser->get($id);
                 if ($this->YuepaiUser->delete($yuepaiuser)) {
                     $this->Util->ajaxReturn(true,'删除成功');
                } else {
                    $errors = $yuepaiuser->errors();
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
            $sort = 'YuepaiUser.'.$this->request->data('sidx');
            $order = $this->request->data('sord');
            $name = $this->request->data('name');
            $area = $this->request->data('area');
            $begin_time = $this->request->data('begin_time');
            $end_time = $this->request->data('end_time');
            $contain = [];
            $where = [];
            if (!empty($name)) {
                $where[' name like'] = "%$name%";
            }
            if (!empty($area)) {
                $where[' area like'] = "%$area%";
            }
            if (!empty($begin_time) && !empty($end_time)) {
                $begin_time = date('Y-m-d', strtotime($begin_time));
                $end_time = date('Y-m-d', strtotime($end_time));
                $contain[] = [
                    'Yuepai' => function($q) use($begin_time, $end_time) {
                        return $q->where([
                            'date(`Yuepai.act_time`) >' => $begin_time,
                            'date(`Yuepai.act_time`) <' => $end_time
                        ]);
                    }
                ];
            } else {
                $contain[] = 'Yuepai';
            }
            $data = $this->getJsonForJqrid($page, $rows, '', $sort, $order,$where,$contain);
            $this->autoRender = false;
            $this->response->type('json');
            $this->response->body(json_encode($data));
            $this->response->send();
            $this->response->stop();
    }

}
