<?php
namespace App\Controller\Admin;

use Cake\ORM\TableRegistry;
use MsgpushType;
use Wpadmin\Controller\AppController;

/**
 * Ptmsg Controller
 *
 * @property \App\Model\Table\CostTable $Cost
 */
class PtmsgController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set([
            'ptmsg' => $this->Ptmsg,
            'pageTitle' => '平台消息管理 ',
            'bread' => [
                'first' => ['name' => '客户服务'],
                'second' => ['name' => '平台消息管理'],
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
        $this->set([
            'cost' => $cost,
            'pageTitle' => '添加价格',
            'bread' => [
                'first' => ['name' => '价格管理'],
                'second' => ['name' => '添加价格'],
            ],
        ]);
        $this->set('_serialize', ['cost']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $ptmsg = $this->Ptmsg->newEntity();
        if ($this->request->is('post')) {
            $uids = $this->request->data('user_id');
            if(count($uids) <= 0) {
                $this->Util->ajaxReturn(false, '对象不能为空');
            }
            $ptmsg = $this->Ptmsg->patchEntity($ptmsg, $this->request->data);
            $ptmsg->msg_type = MsgpushType::COMMON;
            if ($this->Ptmsg->save($ptmsg)) {
                $this->Util->ajaxReturn(true, '添加成功');
            } else {
                $errors = $ptmsg->errors();
                $this->Util->ajaxReturn(['status' => false, 'msg' => getMessage($errors), 'errors' => $errors]);
            }
        }
        $this->set(compact('ptmsg'));
        $this->set([
            'pageTitle' => '发布新消息',
            'bread' => [
                'first' => ['name' => '平台消息管理'],
                'second' => ['name' => '发布新消息'],
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
        $cost = $this->Cost->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['post', 'put'])) {
            $cost = $this->Cost->patchEntity($cost, $this->request->data);
            if ($this->Cost->save($cost)) {
                $this->Util->ajaxReturn(true, '修改成功');
            } else {
                $errors = $cost->errors();
                $this->Util->ajaxReturn(false, getMessage($errors));
            }
        }
        $this->set(compact('cost'));
        $this->set([
            'pageTitle' => '编辑价格',
            'bread' => [
                'first' => ['name' => '价格管理'],
                'second' => ['name' => '编辑价格'],
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
            $ptmsg = $this->Ptmsg->get($id);
            if ($this->Ptmsg->delete($ptmsg)) {
                $this->Util->ajaxReturn(true, '删除成功');
            } else {
                $errors = $ptmsg->errors();
                $this->Util->ajaxReturn(true, getMessage($errors));
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
        $sort = 'Ptmsg.' . $this->request->data('sidx');
        $order = $this->request->data('sord');
        $begin_time = $this->request->data('begin_time');
        $end_time = $this->request->data('end_time');
        $where = [];
        if (!empty($begin_time) && !empty($end_time)) {
            $begin_time = date('Y-m-d', strtotime($begin_time));
            $end_time = date('Y-m-d', strtotime($end_time));
            $where['and'] = [['date(`create_time`) >' => $begin_time], ['date(`create_time`) <' => $end_time]];
        }
        $data = $this->getJsonForJqrid($page, $rows, '', $sort, $order, $where);
        $this->autoRender = false;
        $this->response->type('json');
        $this->response->body(json_encode($data));
        $this->response->send();
        $this->response->stop();
    }


    public function findUser()
    {
        $this->request->allowMethod('ajax');
        $key = $this->request->query('key');
        $utb = TableRegistry::get('User');
        $users = [];
        if($key) {
            $users = $utb->find()->select(['id', 'nick'])->where([' nick like' => "%$key%"])->toArray();
        }
        $this->Util->ajaxReturn(['datas' => $users]);
    }
}
