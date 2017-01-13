<?php
namespace App\Controller\Admin;

use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Wpadmin\Controller\AppController;

/**
 * Withdraw Controller
 *
 * @property \App\Model\Table\WithdrawTable $Withdraw
 */
class WithdrawController extends AppController
{

    /**
    * Index method
    *
    * @return void
    */
    public function index()
    {
        $this->set([
            'pageTitle' => '美币兑换',
            'bread' => [
                'first' => ['name' => '客户服务'],
                'second' => ['name' => '美币兑换'],
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
                $withdraw = $this->Withdraw->get($id);
                 if ($this->Withdraw->delete($withdraw)) {
                     $this->Util->ajaxReturn(true,'删除成功');
                } else {
                    $errors = $withdraw->errors();
                    $this->Util->ajaxReturn(true,getMessage($errors));
                }
          }
    }


    /**
     * deal method
     *
     * @param string|null $id Cost id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function deal()
    {
        $this->request->allowMethod('post');
        $id = $this->request->data('id');
        if ($this->request->is('post')) {
            $withdraw = $this->Withdraw->find()->contain(['User'])->where(['Withdraw.id' => $id])->first();
            $before = $withdraw->user->money;
            $withdraw->user->money -= $withdraw->viramount;
            $withdraw->status = 2;
            $withdraw->deal_time = (new Time());
            $FlowTable = TableRegistry::get('Flow');
            $type = 21; //用户提现
            $flow = $FlowTable->newEntity([
                'user_id'=> 0,
                'buyer_id'=> $withdraw->user->id,
                'type'=> $type,
                'type_msg'=> getFlowType($type),
                'income'=> 1,
                'relate_id'=> $withdraw->id,
                'amount'=> $withdraw->viramount,
                'price'=> $withdraw->viramount,
                'pre_amount'=> $before,
                'after_amount'=> $withdraw->user->money,
                'paytype'=> 1,   //余额支付
                'remark'=> getFlowType($type).'[折算人民币=]'.$withdraw->amount
            ]);
            $withdrawTb = $this->Withdraw;
            $withdraw->dirty('user', true);
            $res = $FlowTable->connection()->transactional(function() use($withdrawTb, $withdraw, $FlowTable, $flow){
                $withres = $withdrawTb->save($withdraw);
                $flowres = $FlowTable->save($flow);
                return $withres&&$flowres;
            });
            if ($res) {
                $this->Util->ajaxReturn(true,'受理成功');
            } else {
                $errors = $withdraw->errors();
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
        $sort = 'Withdraw.'.$this->request->data('sidx');
        $order = $this->request->data('sord');
        $idKw = $this->request->data('id_kw');
        $nickKw = $this->request->data('nick_kw');
        $keywords = $this->request->data('id_kw');
        $begin_time = $this->request->data('begin_time');
        $end_time = $this->request->data('end_time');
        $where = [];
        $contain = ['User' => function($q) {
            return $q->select(['id', 'nick', 'phone']);
        }];
        if (!empty($idKw)) {
            $where[' User.id'] = $idKw;
        }
        if (!empty($nickKw)) {
            $where['User.nick like'] = "%$nickKw%";
        }
        if (!empty($begin_time) && !empty($end_time)) {
            $begin_time = date('Y-m-d', strtotime($begin_time));
            $end_time = date('Y-m-d', strtotime($end_time));
            $where['and'] = [['Withdraw.create_time >' => $begin_time], ['Withdraw.create_time <' => $end_time]];
        }
                $data = $this->getJsonForJqrid($page, $rows, '', $sort, $order,$where, $contain);
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
