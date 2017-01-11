<?php
namespace App\Controller\Admin;

use Wpadmin\Controller\AppController;

/**
 * Suggest Controller
 *
 * @property \App\Model\Table\CostTable $Suggest
 */
class SuggestController extends AppController
{

    /**
     * Index method
     * @return void
     */
    public function index()
    {
        $this->set([
            'pageTitle' => '意见反馈管理',
            'bread' => [
                'first' => ['name' => '客户服务'],
                'second' => ['name' => '意见反馈管理'],
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
            $suggest = $this->Suggest->get($id);
            if ($this->Suggest->delete($suggest)) {
                $this->Util->ajaxReturn(true, '删除成功');
            } else {
                $errors = $suggest->errors();
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
        $sort = 'Suggest.' . $this->request->data('sidx');
        $order = $this->request->data('sord');
        $where = [];
        $contain = ['User' => function($q) {
            return $q->select(['nick']);
        }];
        $data = $this->getJsonForJqrid($page, $rows, '', $sort, $order, $where, $contain);
        $this->autoRender = false;
        $this->response->type('json');
        $this->response->body(json_encode($data));
        $this->response->send();
        $this->response->stop();
    }

}
