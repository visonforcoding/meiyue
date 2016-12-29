<?php
namespace App\Controller\Admin;

use Wpadmin\Controller\AppController;

/**
 * Package Controller
 *
 * @property \App\Model\Table\PackageTable $Package
 */
class PackageController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set([
            'package' => $this->Package,
            'pageTitle' => '套餐购买管理 ',
            'bread' => [
                'first' => ['name' => '套餐管理'],
                'second' => ['name' => '套餐购买管理'],
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
        $this->set([
            'pageTitle' => '套餐管理 ',
            'bread' => [
                'first' => ['name' => '套餐管理'],
                'second' => ['name' => '套餐详情'],
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
        $package = $this->Package->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->data;
            if ($data['chat_endless']) {
                $data['chat_num'] = getDefultEndless();
            }
            if ($data['browse_endless']) {
                $data['browse_num'] = getDefultEndless();
            }

            $package = $this->Package->patchEntity($package, $data);

            if ($this->Package->save($package)) {
                $this->Util->ajaxReturn(true, '添加成功');
            } else {
                $errors = $package->errors();
                $this->Util->ajaxReturn([
                    'status' => false,
                    'msg' => getMessage($errors),
                    'errors' => $errors]);
            }
        }
        $this->set(compact('package'));
        $this->set([
            'pageTitle' => '添加套餐 ',
            'bread' => [
                'first' => ['name' => '套餐管理'],
                'second' => ['name' => '添加套餐'],
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
        $package = $this->Package->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->data;
            if (isset($data['chat_endless'])) {
                $data['chat_num'] = getDefultEndless();
            }
            if (isset($data['browse_endless'])) {
                $data['browse_num'] = getDefultEndless();
            }
            $package = $this->Package->patchEntity($package, $data);
            if ($this->Package->save($package)) {
                $this->Util->ajaxReturn(true, '修改成功');
            } else {
                $errors = $package->errors();
                $this->Util->ajaxReturn(false, getMessage($errors));
            }
        }
        $this->set(compact('package'));
        $this->set([
            'pageTitle' => '编辑套餐 ',
            'bread' => [
                'first' => ['name' => '套餐管理'],
                'second' => ['name' => '编辑套餐'],
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
            $package = $this->Package->get($id);
            if ($this->Package->delete($package)) {
                $this->Util->ajaxReturn(true, '删除成功');
            } else {
                $errors = $package->errors();
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
        $sort = 'Package.' . $this->request->data('sidx');
        $order = $this->request->data('sord');
        $keywords = $this->request->data('keywords');
        $where = [];
        if (!empty($keywords)) {
            $where[' title like'] = "%$keywords%";
        }
        $data = $this->getJsonForJqrid($page, $rows, '', $sort, $order, $where);
        $this->autoRender = false;
        $this->response->type('json');
        $this->response->body(json_encode($data));
        $this->response->send();
        $this->response->stop();
    }

}
