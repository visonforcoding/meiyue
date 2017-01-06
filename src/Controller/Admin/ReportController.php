<?php

namespace App\Controller\Admin;

use Wpadmin\Controller\AppController;

/**
 * Report Controller
 *
 * @property \App\Model\Table\ReportTable $Report
 */
class ReportController extends AppController {

    /**
     * Index method
     *
     * @return void
     */
    public function index() {
        $this->set('report', $this->Report);
        $this->set([
            'pageTitle' => 'report管理',
            'bread' => [
                'first' => ['name' => 'xxx'],
                'second' => ['name' => 'report管理'],
            ],
        ]);
    }

    /**
     * View method
     *
     * @param string|null $id Report id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null) {
        $this->viewBuilder()->autoLayout(false);
        $report = $this->Report->get($id, [
            'contain' => ['User']
        ]);
        $this->set('report', $report);
        $this->set('_serialize', ['report']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $report = $this->Report->newEntity();
        if ($this->request->is('post')) {
            $report = $this->Report->patchEntity($report, $this->request->data);
            if ($this->Report->save($report)) {
                $this->Util->ajaxReturn(true, '添加成功');
            } else {
                $errors = $report->errors();
                $this->Util->ajaxReturn(['status' => false, 'msg' => getMessage($errors), 'errors' => $errors]);
            }
        }
        $user = $this->Report->User->find('list', ['limit' => 200]);
        $this->set(compact('report', 'user'));
        $this->set([
            'pageTitle' => 'report添加',
            'bread' => [
                'first' => ['name' => 'xxx'],
                'second' => ['name' => 'report添加'],
            ],
        ]);
    }

    /**
     * Edit method
     *
     * @param string|null $id Report id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $report = $this->Report->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['post', 'put'])) {
            $report = $this->Report->patchEntity($report, $this->request->data);
            if ($this->Report->save($report)) {
                $this->Util->ajaxReturn(true, '修改成功');
            } else {
                $errors = $report->errors();
                $this->Util->ajaxReturn(false, getMessage($errors));
            }
        }
        $user = $this->Report->User->find('list', ['limit' => 200]);
        $this->set(compact('report', 'user'));
        $this->set([
            'pageTitle' => 'report修改',
            'bread' => [
                'first' => ['name' => 'xxx'],
                'second' => ['name' => 'report修改'],
            ],
        ]);
    }

    /**
     * Delete method
     *
     * @param string|null $id Report id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod('post');
        $id = $this->request->data('id');
        if ($this->request->is('post')) {
            $report = $this->Report->get($id);
            if ($this->Report->delete($report)) {
                $this->Util->ajaxReturn(true, '删除成功');
            } else {
                $errors = $report->errors();
                $this->Util->ajaxReturn(true, getMessage($errors));
            }
        }
    }

    /**
     * get jqgrid data 
     *
     * @return json
     */
    public function getDataList() {
        $this->request->allowMethod('ajax');
        $page = $this->request->data('page');
        $rows = $this->request->data('rows');
        $sort = 'Report.' . $this->request->data('sidx');
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
        $query = $this->Report->find();
        $query->hydrate(false);
        if (!empty($where)) {
            $query->where($where);
        }
        $query->contain(['User']);
        $nums = $query->count();
        if (!empty($sort) && !empty($order)) {
            $query->order([$sort => $order]);
        }

        $query->limit(intval($rows))
                ->page(intval($page));
        $res = $query->toArray();
        if (empty($res)) {
            $res = array();
        }
        if ($nums > 0) {
            $total_pages = ceil($nums / $rows);
        } else {
            $total_pages = 0;
        }
        $data = array('page' => $page, 'total' => $total_pages, 'records' => $nums, 'rows' => $res);
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
    public function exportExcel() {
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
        $Table = $this->Report;
        $column = ['举报类型', '用户id', 'create_time', 'update_time'];
        $query = $Table->find();
        $query->hydrate(false);
        $query->select(['type', 'user_id', 'create_time', 'update_time']);
        if (!empty($where)) {
            $query->where($where);
        }
        if (!empty($sort) && !empty($order)) {
            $query->order([$sort => $order]);
        }
        $res = $query->toArray();
        $this->autoRender = false;
        $filename = 'Report_' . date('Y-m-d') . '.csv';
        \Wpadmin\Utils\Export::exportCsv($column, $res, $filename);
    }

    /**
     * rowEdit method
     *
     * @param string|null $id Report id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function rowEdit() {

        $id = $this->request->data('id');
        $oper = $this->request->data('oper');
        $data = $this->request->data();
        if ($id && $oper == 'edit') {
            $report = $this->Report->get($id, [
                'contain' => []
            ]);
            $report = $this->Report->patchEntity($report, $data);
            if ($this->Report->save($report)) {
                $this->Util->ajaxReturn(true, '保存成功');
            } else {
                $this->Util->ajaxReturn(true, '保存失败');
            }
        }
    }

}
