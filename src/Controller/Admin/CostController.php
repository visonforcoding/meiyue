<?php
namespace App\Controller\Admin;

use Wpadmin\Controller\AppController;

/**
 * Cost Controller
 *
 * @property \App\Model\Table\CostTable $Cost
 */
class CostController extends AppController
{

    /**
    * Index method
    *
    * @return void
    */
    public function index()
    {
        $this->set([
            'costs' => $this->Cost,
            'pageTitle' => '价格管理 ',
            'bread' => [
                'first' => ['name' => '基础管理'],
                'second' => ['name' => '价格管理'],
            ],
        ]);
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
        $cost = $this->Cost->newEntity();
        if ($this->request->is('post')) {
            $cost = $this->Cost->patchEntity($cost, $this->request->data);
            if ($this->Cost->save($cost)) {
                 $this->Util->ajaxReturn(true,'添加成功');
            } else {
                 $errors = $cost->errors();
                 $this->Util->ajaxReturn(['status'=>false, 'msg'=>getMessage($errors),'errors'=>$errors]);
            }
        }
                $this->set(compact('cost'));
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
         $cost = $this->Cost->get($id,[
            'contain' => []
        ]);
        if ($this->request->is(['post','put'])) {
            $cost = $this->Cost->patchEntity($cost, $this->request->data);
            if ($this->Cost->save($cost)) {
                  $this->Util->ajaxReturn(true,'修改成功');
            } else {
                 $errors = $cost->errors();
               $this->Util->ajaxReturn(false,getMessage($errors));
            }
        }
                  $this->set(compact('cost'));
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
                $cost = $this->Cost->get($id);
                 if ($this->Cost->delete($cost)) {
                     $this->Util->ajaxReturn(true,'删除成功');
                } else {
                    $errors = $cost->errors();
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
        $sort = 'Cost.'.$this->request->data('sidx');
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
        $Table =  $this->Cost;
        $column = ['价格'];
        $query = $Table->find();
        $query->hydrate(false);
        $query->select(['money']);
         if (!empty($where)) {
            $query->where($where);
        }
        if (!empty($sort) && !empty($order)) {
            $query->order([$sort => $order]);
        }
        $res = $query->toArray();
        $this->autoRender = false;
        $filename = 'Cost_'.date('Y-m-d').'.csv';
        \Wpadmin\Utils\Export::exportCsv($column,$res,$filename);

}
}
