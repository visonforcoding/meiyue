<?php

namespace App\Controller\Admin;

use Wpadmin\Controller\AppController;

/**
 * Dateorder Controller
 *
 * @property \App\Model\Table\DateorderTable $Dateorder
 */
class DateorderController extends AppController {

    /**
     * Index method
     *
     * @return void
     */
    public function index() {
        $this->set('dateorder', $this->Dateorder);
        $this->set([
            'pageTitle' => 'dateorder管理',
            'bread' => [
                'first' => ['name' => 'xxx'],
                'second' => ['name' => 'dateorder管理'],
            ],
        ]);
    }

    /**
     * View method
     *
     * @param string|null $id Dateorder id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null) {
        $this->viewBuilder()->autoLayout(false);
        $dateorder = $this->Dateorder->get($id, [
            'contain' => ['Buyer', 'Date', 'Dater', 'UserSkill']
        ]);
        $this->set('dateorder', $dateorder);
        $this->set('_serialize', ['dateorder']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $dateorder = $this->Dateorder->newEntity();
        if ($this->request->is('post')) {
            $dateorder = $this->Dateorder->patchEntity($dateorder, $this->request->data);
            if ($this->Dateorder->save($dateorder)) {
                $this->Util->ajaxReturn(true, '添加成功');
            } else {
                $errors = $dateorder->errors();
                $this->Util->ajaxReturn(['status' => false, 'msg' => getMessage($errors), 'errors' => $errors]);
            }
        }
        $buyer = $this->Dateorder->Buyer->find('list', ['limit' => 200]);
        $date = $this->Dateorder->Date->find('list', ['limit' => 200]);
        $dater = $this->Dateorder->Dater->find('list', ['limit' => 200]);
        $userSkill = $this->Dateorder->UserSkill->find('list', ['limit' => 200]);
        $this->set(compact('dateorder', 'buyer', 'date', 'dater', 'userSkill'));
        $this->set([
            'pageTitle' => 'dateorder添加',
            'bread' => [
                'first' => ['name' => 'xxx'],
                'second' => ['name' => 'dateorder添加'],
            ],
        ]);
    }

    /**
     * Edit method
     *
     * @param string|null $id Dateorder id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $dateorder = $this->Dateorder->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['post', 'put'])) {
            $dateorder = $this->Dateorder->patchEntity($dateorder, $this->request->data);
            if ($this->Dateorder->save($dateorder)) {
                $this->Util->ajaxReturn(true, '修改成功');
            } else {
                $errors = $dateorder->errors();
                $this->Util->ajaxReturn(false, getMessage($errors));
            }
        }
        $buyer = $this->Dateorder->Buyer->find('list', ['limit' => 200]);
        $date = $this->Dateorder->Date->find('list', ['limit' => 200]);
        $dater = $this->Dateorder->Dater->find('list', ['limit' => 200]);
        $userSkill = $this->Dateorder->UserSkill->find('list', ['limit' => 200]);
        $this->set(compact('dateorder', 'buyer', 'date', 'dater', 'userSkill'));
        $this->set([
            'pageTitle' => 'dateorder修改',
            'bread' => [
                'first' => ['name' => 'xxx'],
                'second' => ['name' => 'dateorder修改'],
            ],
        ]);
    }

    /**
     * Delete method
     *
     * @param string|null $id Dateorder id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod('post');
        $id = $this->request->data('id');
        if ($this->request->is('post')) {
            $dateorder = $this->Dateorder->get($id);
            if ($this->Dateorder->delete($dateorder)) {
                $this->Util->ajaxReturn(true, '删除成功');
            } else {
                $errors = $dateorder->errors();
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
        $sort = 'Dateorder.' . $this->request->data('sidx');
        $order = $this->request->data('sord');
        $keywords = $this->request->data('keywords');
        $begin_time = $this->request->data('begin_time');
        $end_time = $this->request->data('end_time');
        $where = [];
        if (!empty($keywords)) {
            $where['Buyer.nick like'] = "%$keywords%";
        }
        if (!empty($begin_time) && !empty($end_time)) {
            $begin_time = date('Y-m-d', strtotime($begin_time));
            $end_time = date('Y-m-d', strtotime($end_time));
            $where['and'] = [['date(`create_time`) >' => $begin_time], ['date(`create_time`) <' => $end_time]];
        }
        $query = $this->Dateorder->find();
        $query->hydrate(false);
        if (!empty($where)) {
            $query->where($where);
        }
        $query->contain([
            'Buyer' => function($q) {
                return $q->select(['id', 'nick', 'phone']);
            },
            'Date',
            'Dater' => function($q) {
                return $q->select(['id', 'nick', 'phone']);
            }, 'UserSkill.Skill']);
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
        $Table = $this->Dateorder;
        $column = ['男方', '消费者姓名', '女方', '服务提供者姓名', '对应约会', '用户技能id', '订单状态码： 1#消费者未支付预约金 2#消费者超时未支付预约金，订单取消 3#消费者已支付预约金 4#消费者取消订单 5#受邀者拒绝约单 6#受邀者超时未响应，自动退单 7#受邀者确认约单 8#受邀者取消订单 9#消费者超时未付尾款 10#消费者已支付尾款 11#消费者退单 12#受邀者退单 13#受邀者确认到达 14#订单完成 15#已评价 16#订单失败', '用户操作状态码：0#无操作 1#消费者删除订单 2#被约者删除订单 3#双方删除订单', '约会地点', '约会地点纬度', '约会地点经度', '价格', '总金额', '是否被投诉', '预约金', '预约金占比', '开始时间', '结束时间', '约会总时间', '支付预约金时间点', '是否已被阅读', '0未删除1男性2女性删除3双方删除', '评价准时得分', '评价匹配程度', '评价服务得分', '评价内容', '美女接单时间点', '生成时间', '订单更新时间'];
        $query = $Table->find();
        $query->hydrate(false);
        $query->select(['consumer_id', 'consumer', 'dater_id', 'dater_name', 'date_id', 'user_skill_id', 'status', 'operate_status', 'site', 'site_lat', 'site_lng', 'price', 'amount', 'is_complain', 'pre_pay', 'pre_precent', 'start_time', 'end_time', 'date_time', 'prepay_time', 'is_read', 'is_del', 'appraise_time', 'appraise_match', 'appraise_service', 'appraise_body', 'receive_time', 'create_time', 'update_time']);
        if (!empty($where)) {
            $query->where($where);
        }
        if (!empty($sort) && !empty($order)) {
            $query->order([$sort => $order]);
        }
        $res = $query->toArray();
        $this->autoRender = false;
        $filename = 'Dateorder_' . date('Y-m-d') . '.csv';
        \Wpadmin\Utils\Export::exportCsv($column, $res, $filename);
    }

    /**
     * rowEdit method
     *
     * @param string|null $id Dateorder id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function rowEdit() {

        $id = $this->request->data('id');
        $oper = $this->request->data('oper');
        $data = $this->request->data();
        if ($id && $oper == 'edit') {
            $dateorder = $this->Dateorder->get($id, [
                'contain' => []
            ]);
            $dateorder = $this->Dateorder->patchEntity($dateorder, $data);
            if ($this->Dateorder->save($dateorder)) {
                $this->Util->ajaxReturn(true, '保存成功');
            } else {
                $this->Util->ajaxReturn(true, '保存失败');
            }
        }
    }

    /**
     * 处理投诉
     */
    public function handComplain($order_id) {
        $DateorderTable = \Cake\ORM\TableRegistry::get('Dateorder');
        $dateorder = $DateorderTable->get($order_id, [
            'contain' => [
                'Buyer' => function($q) {
                    return $q->select(['phone', 'id', 'money']);
                }
                , 'Dater' => function($q) {
                    return $q->select(['id', 'nick', 'money']);
                }
                , 'UserSkill.Skill'
            ]
        ]);
        //订单状态更改
        if ($dateorder->status < 10) {
            return $this->Util->ajaxReturn(false, '暂时不能进行此操作');
        }
        $result = $this->request->data('result');
        if($result==3){
            $dateorder->is_complain = 3;
            if($DateorderTable->save($dateorder)){
                return $this->Util->ajaxReturn(true,'操作成功');
            } else {
                return $this->Util->ajaxReturn(false,'服务器错误');
            }
        }
        $dateorder->close_time = date('Y-m-d H:i:s');
        if($result==1){
             //订单状态更改
            $dateorder->is_complain = 1;
            $dateorder->status = 18;
        }elseif($result==2){
            $dateorder->is_complain = 2;
            $dateorder->status = 19;
        }
        $m_p = $this->request->data('m_p');
        $w_p = $this->request->data('w_p');
        //返还m_p 给男性
        $amount = $dateorder->amount;
        $m_amount = $amount*$m_p/100;
        $m_pre_money = $dateorder->buyer->money;
        $dateorder->buyer->money = $dateorder->buyer->money+$dateorder->$m_amount;
        $m_after_amount = $dateorder->buyer->money;
        
        $dateorder->dirty('buyer',true);
         //生成流水
        $FlowTable = \Cake\ORM\TableRegistry::get('Flow');
        $m_flow = $FlowTable->newEntity([
           'user_id'=> $dateorder->buyer->id,
           'buyer_id'=>  0,
           'relate_id'=>$dateorder->id,
           'type'=>22,
           'type_msg'=>'订单投诉退回',
           'income'=>1,
           'amount'=>$m_amount,
           'price'=>$m_amount,
           'pre_amount'=>$m_pre_money,
           'after_amount'=>$m_after_amount,
           'paytype'=>2, 
           'remark'=> '订单投诉的处理'
        ]);
        //扣除违约金   10%
        $breach_amount = $w_p*$dateorder->amount/100;
        $w_pre_amount = $dateorder->dater->money;
        $dateorder->dater->money = $dateorder->dater->money+$breach_amount;
        $w_after_amount = $dateorder->dater->money;
        $dateorder->dirty('dater',true);
        //女方的资金流水
        $w_flow = $FlowTable->newEntity([
           'user_id'=> $dateorder->dater->id,
           'buyer_id'=> 0,
           'relate_id'=>$dateorder->id,
           'type'=>22,
           'type_msg'=>'订单投诉退回',
           'income'=>1,
           'amount'=>$breach_amount,
           'price'=>$breach_amount,
           'pre_amount'=>$w_pre_amount,
           'after_amount'=>$w_after_amount,
           'paytype'=>1, 
           'remark'=> '订单投诉的处理'
        ]);
        $transRes = $DateorderTable->connection()
                 ->transactional(function()use(&$w_flow,$FlowTable,&$m_flow,&$dateorder,$DateorderTable){
               return $FlowTable->save($m_flow)&&$DateorderTable->save($dateorder)&&$FlowTable->save($w_flow);      
        });
       if($transRes){
            return $this->Util->ajaxReturn(true,'处理成功');
           }else{
            return $this->Util->ajaxReturn(false,'处理失败');
        }
    }

}
