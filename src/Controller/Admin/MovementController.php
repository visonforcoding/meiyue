<?php

namespace App\Controller\Admin;

use Wpadmin\Controller\AppController;

/**
 * Movement Controller
 *
 * @property \App\Model\Table\MovementTable $Movement
 */
class MovementController extends AppController {

    /**
     * Index method
     *
     * @return void
     */
    public function index() {
        $this->set('movement', $this->Movement);
        $this->set([
            'pageTitle' => '动态管理',
            'bread' => [
                'first' => ['name' => '用户管理'],
                'second' => ['name' => '动态管理'],
            ],
        ]);
    }

    /**
     * View method
     *
     * @param string|null $id Movement id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null) {
        $this->viewBuilder()->autoLayout(false);
        $movement = $this->Movement->get($id, [
            'contain' => ['User', 'Mvpraise']
        ]);
        $this->set('movement', $movement);
        $this->set('_serialize', ['movement']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $movement = $this->Movement->newEntity();
        if ($this->request->is('post')) {
            $movement = $this->Movement->patchEntity($movement, $this->request->data);
            if ($this->Movement->save($movement)) {
                $this->Util->ajaxReturn(true, '添加成功');
            } else {
                $errors = $movement->errors();
                $this->Util->ajaxReturn(['status' => false, 'msg' => getMessage($errors), 'errors' => $errors]);
            }
        }
        $user = $this->Movement->User->find('list', ['limit' => 200]);
        $this->set(compact('movement', 'user'));
        $this->set([
            'pageTitle' => 'movement添加',
            'bread' => [
                'first' => ['name' => 'xxx'],
                'second' => ['name' => 'movement添加'],
            ],
        ]);
    }

    /**
     * Edit method
     *
     * @param string|null $id Movement id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $movement = $this->Movement->get($id, [
            'contain' => ['User']
        ]);
        $oldCheck = $movement->status;
        if ($this->request->is(['post', 'put'])) {
            $movement = $this->Movement->patchEntity($movement, $this->request->data);
            if ($this->Movement->save($movement)) {
                if($oldCheck != $movement->status) {
                    switch($movement->status) {
                        case 1:   //待审核
                            break;
                        case 2:   //审核通过
                            $this->Business->sendSMsg($movement->user->id, [
                                'towho' => \MsgpushType::TO_MOVEMENT_CHECK,
                                'title' => '动态审核通过',
                                'body' => '恭喜您，动态审核通过，关注度已大大提升！',
                            ], true);
                            break;
                        case 3:   //审核不通过
                            $this->Business->sendSMsg($movement->user->id, [
                                'towho' => \MsgpushType::TO_MOVEMENT_CHECK,
                                'title' => '动态审核未通过',
                                'body' => '抱歉，您的动态未审核通过，主要原因是：您的动态涉嫌模糊、遮挡等看不清本人；'.
                                    '或裸露身体；或使用他人照片。请重新上传清晰的本人照片或视频。',
                            ], true);
                            break;
                    }
                }
                $this->Util->ajaxReturn(true, '修改成功');
            } else {
                $errors = $movement->errors();
                $this->Util->ajaxReturn(false, getMessage($errors));
            }
        }
        $user = $this->Movement->User->find('list', ['limit' => 200]);
        $this->set(compact('movement', 'user'));
        $this->set([
            'pageTitle' => 'movement修改',
            'bread' => [
                'first' => ['name' => 'xxx'],
                'second' => ['name' => 'movement修改'],
            ],
        ]);
    }

    /**
     * Delete method
     *
     * @param string|null $id Movement id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod('post');
        $id = $this->request->data('id');
        if ($this->request->is('post')) {
            $movement = $this->Movement->get($id);
            if ($this->Movement->delete($movement)) {
                $this->Util->ajaxReturn(true, '删除成功');
            } else {
                $errors = $movement->errors();
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
        $sort = 'Movement.' . $this->request->data('sidx');
        $order = $this->request->data('sord');
        $keywords = $this->request->data('keywords');
        $statuskw = $this->request->data('statuskw');
        $begin_time = $this->request->data('begin_time');
        $end_time = $this->request->data('end_time');
        $where = [];
        if(($statuskw !== null) && ($statuskw != 100)) {
            $where['Movement.status'] = $statuskw;
        }
        if (!empty($keywords)) {
            $where['username like'] = "%$keywords%";
        }
        if (!empty($begin_time) && !empty($end_time)) {
            $begin_time = date('Y-m-d', strtotime($begin_time));
            $end_time = date('Y-m-d', strtotime($end_time));
            $where['and'] = [['date(`create_time`) >' => $begin_time], ['date(`create_time`) <' => $end_time]];
        }
        $query = $this->Movement->find();
        $query->hydrate(false);
        if (!empty($where)) {
            $query->where($where);
        }
        $query->contain([
            'User'=>function($q){
                return $q->select(['id','nick','phone']);
            }, 
            'Mvpraises']);
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
        $Table = $this->Movement;
        $column = ['用户id', '1:图片动态2.视频动态', '动态内容', 'images', 'video', 'video_cover', '查看数', '点赞数', '1待审核2审核通过3审核不通过', 'create_time', 'update_time'];
        $query = $Table->find();
        $query->hydrate(false);
        $query->select(['user_id', 'type', 'body', 'images', 'video', 'video_cover', 'view_nums', 'praise_nums', 'status', 'create_time', 'update_time']);
        if (!empty($where)) {
            $query->where($where);
        }
        if (!empty($sort) && !empty($order)) {
            $query->order([$sort => $order]);
        }
        $res = $query->toArray();
        $this->autoRender = false;
        $filename = 'Movement_' . date('Y-m-d') . '.csv';
        \Wpadmin\Utils\Export::exportCsv($column, $res, $filename);
    }
    
    /**
     * 获得动态图片列表数据
     * @param type $id
     */
    public function getImgs($id){
         $Table = $this->Movement;
         $movment = $Table->find()->contain([
                    'User'=>function($q){
                        return $q->select(['nick']);
                    }
             ])->select(['images','body','id'])->where(['Movement.id'=>$id])->first();
         $images = $movment->images;
         $data = [];
         $imgs = unserialize($images);
         foreach ($imgs as $key=>$img){
             $data[] = [
               'alt'=>$key,
               'pid'=>$key,
               'src'=>$img  
             ];
         }
         $res = [
             'title'=>$movment->user->nick.'的动态',
             'id'=>$movment->id,
             'start'=>0,
             'data'=>$data
         ];
         $this->Util->ajaxReturn(['imgs'=>$res]);
    }
    
    public function rowEdit(){
        $id = $this->request->data('id');
        $oper = $this->request->data('oper');
        $data = $this->request->data();
        if($id&&$oper=='edit'){
            $movement = $this->Movement->get($id);
            $movement = $this->Movement->patchEntity($movement, $data);
            if($this->Movement->save($movement)){
                  $this->Util->ajaxReturn(true, '保存成功');
            }else{
                  $this->Util->ajaxReturn(true, '保存失败');
            }
        }
    }
}
