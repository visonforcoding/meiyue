<?php
namespace App\Controller\Admin;

use Wpadmin\Controller\AppController;

/**
 * Activity Controller
 *
 * @property \App\Model\Table\ActivityTable $Activity
 */
class ActivityController extends AppController
{

/**
* Index method
*
* @return void
*/
public function index()
{
    $this->set([
        'activity' => $this->Activity,
        'pageTitle' => '派对管理',
        'bread' => [
            'first' => ['name' => 'xxx'],
            'second' => ['name' => '派对管理'],
        ],
    ]);
}

    /**
     * View method
     *
     * @param string|null $id Activity id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->viewBuilder()->autoLayout(false);
        $activity = $this->Activity->get($id, [
            'contain' => []
        ]);
        $this->set('activity', $activity);
        $this->set('_serialize', ['activity']);
        $this->set([
            'pageTitle' => '派对管理',
            'bread' => [
                'first' => ['name' => '活动管理'],
                'second' => ['name' => '派对管理'],
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
        $activity = $this->Activity->newEntity();
        if ($this->request->is('post')) {
            $activity = $this->Activity->patchEntity($activity, $this->request->data);
            $activity->male_rest = $activity->male_lim;
            $activity->female_rest = $activity->female_lim;
            if ($this->Activity->save($activity)) {
                 $this->Util->ajaxReturn(true,'添加成功');
            } else {
                 $errors = $activity->errors();
                 $this->Util->ajaxReturn(['status'=>false, 'msg'=>getMessage($errors),'errors'=>$errors]);
            }
        }
        $this->set(compact('activity'));
        $this->set([
            'pageTitle' => '添加派对',
            'bread' => [
                'first' => ['name' => '派对管理'],
                'second' => ['name' => '添加派对'],
            ],
        ]);
    }

    /**
     * Edit method
     *
     * @param string|null $id Activity id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
         $activity = $this->Activity->get($id,[
            'contain' => []
        ]);
        if ($this->request->is(['post','put'])) {
            $activity = $this->Activity->patchEntity($activity, $this->request->data);
            if ($this->Activity->save($activity)) {
                  $this->Util->ajaxReturn(true,'修改成功');
            } else {
                 $errors = $activity->errors();
               $this->Util->ajaxReturn(false,getMessage($errors));
            }
        }
        $this->set(compact('activity'));
        $this->set([
            'pageTitle' => '派对管理',
            'bread' => [
                'first' => ['name' => '派对管理'],
                'second' => ['name' => '编辑派对'],
            ],
        ]);
    }

    /**
     * Delete method
     *
     * @param string|null $id Activity id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod('post');
         $id = $this->request->data('id');
                if ($this->request->is('post')) {
                $activity = $this->Activity->get($id);
                 if ($this->Activity->delete($activity)) {
                     $this->Util->ajaxReturn(true,'删除成功');
                } else {
                    $errors = $activity->errors();
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
        $sort = 'Activity.'.$this->request->data('sidx');
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
        $Table =  $this->Activity;
        $column = ['大图url','标题','男性价格','女性价格','描述','开始时间','结束时间','活动地址','地址纬度','地址经度','活动男性名额','活动女性名额','男性剩余名额','女性剩余名额','图文详情','活动须知','活动状态：1#正常进行 2#下架处理','备注'];
        $query = $Table->find();
        $query->hydrate(false);
        $query->select(['big_img','title','male_price','female_price','description','start_time','end_time','site','site_lat','site_lng','male_lim','female_lim','male_rest','female_rest','detail','notice','status','remark']);
         if (!empty($where)) {
            $query->where($where);
        }
        if (!empty($sort) && !empty($order)) {
            $query->order([$sort => $order]);
        }
        $res = $query->toArray();
        $this->autoRender = false;
        $filename = 'Activity_'.date('Y-m-d').'.csv';
        \Wpadmin\Utils\Export::exportCsv($column,$res,$filename);

}
}
