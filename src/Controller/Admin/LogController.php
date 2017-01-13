<?php
namespace App\Controller\Admin;

use Wpadmin\Controller\AppController;

/**
 * Log Controller
 *
 * @property \App\Model\Table\LogTable $Log
 */
class LogController extends AppController
{

/**
* Index method
*
* @return void
*/
public function index()
{
$this->set('log', $this->Log);
$this->set([
      'pageTitle'=>'log管理',
      'bread'=>[
            'first'=>['name'=>'xxx'],
            'second'=>['name'=>'log管理'],
        ],
      ]);
}

    /**
     * View method
     *
     * @param string|null $id Log id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->viewBuilder()->autoLayout(false);
        $log = $this->Log->get($id, [
            'contain' => []
        ]);
        $this->set('log', $log);
        $this->set('_serialize', ['log']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $log = $this->Log->newEntity();
        if ($this->request->is('post')) {
            $log = $this->Log->patchEntity($log, $this->request->data);
            if ($this->Log->save($log)) {
                 $this->Util->ajaxReturn(true,'添加成功');
            } else {
                 $errors = $log->errors();
                 $this->Util->ajaxReturn(['status'=>false, 'msg'=>getMessage($errors),'errors'=>$errors]);
            }
        }
                $this->set(compact('log'));
        $this->set([
      'pageTitle'=>'log添加',
      'bread'=>[
            'first'=>['name'=>'xxx'],
            'second'=>['name'=>'log添加'],
        ],
      ]);
    }

    /**
     * Edit method
     *
     * @param string|null $id Log id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
         $log = $this->Log->get($id,[
            'contain' => []
        ]);
        if ($this->request->is(['post','put'])) {
            $log = $this->Log->patchEntity($log, $this->request->data);
            if ($this->Log->save($log)) {
                  $this->Util->ajaxReturn(true,'修改成功');
            } else {
                 $errors = $log->errors();
               $this->Util->ajaxReturn(false,getMessage($errors));
            }
        }
                  $this->set(compact('log'));
        $this->set([
      'pageTitle'=>'log修改',
      'bread'=>[
            'first'=>['name'=>'xxx'],
            'second'=>['name'=>'log修改'],
        ],
      ]);
    }

    /**
     * Delete method
     *
     * @param string|null $id Log id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod('post');
         $id = $this->request->data('id');
                if ($this->request->is('post')) {
                $log = $this->Log->get($id);
                 if ($this->Log->delete($log)) {
                     $this->Util->ajaxReturn(true,'删除成功');
                } else {
                    $errors = $log->errors();
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
        $sort = 'Log.'.$this->request->data('sidx');
        $order = $this->request->data('sord');
        $keywords = $this->request->data('keywords');
        $begin_time = $this->request->data('begin_time');
        $end_time = $this->request->data('end_time');
        $where = [];
        if (!empty($keywords)) {
            $where[' username like'] = "%$keywords%";
        }
        if (!empty($begin_time) && !empty($end_time)) {
            $begin_time = date('Y-m-d', strtotime($begin_time));
            $end_time = date('Y-m-d', strtotime($end_time));
            $where['and'] = [['date(`create_time`) >' => $begin_time], ['date(`create_time`) <' => $end_time]];
        }
                $data = $this->getJsonForJqrid($page, $rows, '', $sort, $order,$where);
                $this->autoRender = false;
        $this->response->type('json');
        $this->response->body(json_encode($data));
        $this->response->send();
        $this->response->stop();
}

/**
* export csv
*
* @return csv 
*/
public function exportExcel()
{
        $sort = $this->request->query('sidx');
        $order = $this->request->query('sort');
        $keywords = $this->request->query('keywords');
        $begin_time = $this->request->query('begin_time');
        $end_time = $this->request->query('end_time');
        $where = [];
        if (!empty($keywords)) {
            $where['username like'] = "%$keywords%";
        }
        if (!empty($begin_time) && !empty($end_time)) {
            $begin_time = date('Y-m-d', strtotime($begin_time));
            $end_time = date('Y-m-d', strtotime($end_time));
            $where['and'] = [['date(`create_time`) >' => $begin_time], ['date(`create_time`) <' => $end_time]];
        }
        $Table =  $this->Log;
        $column = ['flag','msg','data','create_time'];
        $query = $Table->find();
        $query->hydrate(false);
        $query->select(['flag','msg','data','create_time']);
         if (!empty($where)) {
            $query->where($where);
        }
        if (!empty($sort) && !empty($order)) {
            $query->order([$sort => $order]);
        }
        $res = $query->toArray();
        $this->autoRender = false;
        $filename = 'Log_'.date('Y-m-d').'.csv';
        \Wpadmin\Utils\Export::exportCsv($column,$res,$filename);

}

    /**
     * rowEdit method
     *
     * @param string|null $id Log id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function rowEdit()
    {
    
        $id = $this->request->data('id');
        $oper = $this->request->data('oper');
        $data = $this->request->data();
        if($id&&$oper=='edit'){
            $log = $this->Log->get($id,[
            'contain' => []
            ]);
            $log = $this->Log->patchEntity($log, $data);
            if($this->Log->save($log)){
                  $this->Util->ajaxReturn(true, '保存成功');
            }else{
                  $this->Util->ajaxReturn(true, '保存失败');
            }
        }
    }
}
