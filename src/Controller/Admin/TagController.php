<?php
namespace App\Controller\Admin;

use Wpadmin\Controller\AppController;

/**
 * Tag Controller
 *
 * @property \App\Model\Table\TagTable $Tag
 */
class TagController extends AppController
{

/**
* Index method
*
* @return void
*/
public function index()
{
    $this->set([
        'tags' => $this->Tag->find('threaded')->toArray(),
        'pageTitle' => '标签管理 ',
        'bread' => [
            'first' => ['name' => '基础管理'],
            'second' => ['name' => '标签管理'],
        ],
    ]);
}

    /**
     * View method
     *
     * @param string|null $id Tag id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->viewBuilder()->autoLayout(false);
        $tag = $this->Tag->get($id, [
            'contain' => ['ParentTag', 'ChildTag']
        ]);
        $this->set('tag', $tag);
        $this->set('_serialize', ['tag']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->viewBuilder()->autoLayout(false);
        $tag = $this->Tag->newEntity();
        if ($this->request->is('post')) {
            $tag = $this->Tag->patchEntity($tag, $this->request->data);

            if ($this->Tag->save($tag)) {
                $this->Util->ajaxReturn(true, '添加成功');
            } else {
                $errors = $tag->errors();
                $this->Util->ajaxReturn(['status' => false, 'msg' => getMessage($errors), 'errors' => $errors]);
            }
        }
        $this->set(compact('tag'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Tag id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->viewBuilder()->autoLayout(false);
        $tag = $this->Tag->get($id,[
            'contain' => []
        ]);
        if ($this->request->is(['post','put'])) {
            $tag = $this->Tag->patchEntity($tag, $this->request->data);
            if ($this->Tag->save($tag)) {
                  $this->Util->ajaxReturn(true,'修改成功');
            } else {
                 $errors = $tag->errors();
               $this->Util->ajaxReturn(false,getMessage($errors));
            }
        }
        $parentTag = $this->Tag->ParentTag->find('list', ['limit' => 200])->toArray();
        $this->set(compact('tag', 'parentTag'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Tag id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod('post');
         $id = $this->request->data('id');
                if ($this->request->is('post')) {
                $tag = $this->Tag->get($id);
                 if ($this->Tag->delete($tag)) {
                     $this->Util->ajaxReturn(true,'删除成功');
                } else {
                    $errors = $tag->errors();
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
        $sort = 'Tag.'.$this->request->data('sidx');
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
                $query =  $this->Tag->find();
        $query->hydrate(false);
        if (!empty($where)) {
            $query->where($where);
        }
        $query->contain(['ParentTag', 'ChildTag']);
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
        $Table =  $this->Tag;
        $column = ['标签名','parent_id'];
        $query = $Table->find();
        $query->hydrate(false);
        $query->select(['name','parent_id']);
         if (!empty($where)) {
            $query->where($where);
        }
        if (!empty($sort) && !empty($order)) {
            $query->order([$sort => $order]);
        }
        $res = $query->toArray();
        $this->autoRender = false;
        $filename = 'Tag_'.date('Y-m-d').'.csv';
        \Wpadmin\Utils\Export::exportCsv($column,$res,$filename);

}
}
