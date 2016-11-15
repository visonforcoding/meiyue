<?php
namespace App\Controller\Mobile;
use Cake\ORM\TableRegistry;

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
     * @return \Cake\Network\Response|null
     */
    public function index($user_id = null)
    {
        if($this->request->is("post")) {

            $datas = $this->Activity->find("all");
            if($user_id) {

                $datas = $datas->where(['Date.user_id' => $user_id]);
                if(isset($this->request->data['status'])) {

                    $datas->where(["Date.status" => $this->request->data['status']]);

                }

            }
            return $this->Util->ajaxReturn(['datas' => $datas->toArray(), 'status' => true]);

        }
        $this->set(["user" => $this->user, 'pageTitle' => '美约-活动']);
    }


    /**
     * 参加派对
     * 1.生成报名表
     * 2.扣除用户报名费用
     * 3.生成流水
     * @param string|null $id Activity id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->handCheckLogin();
        $activity = $this->Activity->get($id, ['contain' => ['Actregistrations'=> function($q){
            return $q->contain(['User' => function($q) { return $q->select(['User.id', 'User.gender']);}]);
        }]]);

        //参加活动
        if($this->request->is("POST")) {

            //检查是否参与过
            $actregistrationTable = TableRegistry::get('Actregistration');
            $count = $actregistrationTable->find()->where(['user_id' => $this->user->id, 'activity_id' => $id])->count();
            if($count > 0) {

                return $this->Util->ajaxReturn(false, '您已经参与过了！');

            }

            //获取需要费用
            //检查报名人数是否已满
            $price = 0;
            if($this->user->gender == 1) {

                $price = $activity['male_price'];
                if($activity->male_rest == 0) {

                    return $this->Util->ajaxReturn(false, '报名人数已满！');

                }

            } else {

                $price = $activity['female_price'];
                if($activity->female_rest == 0) {

                    return $this->Util->ajaxReturn(false, '报名人数已满！');

                }
            }
            //判断余额是否充足
            if($this->user->money < $price) {

                return $this->Util->ajaxReturn(false, '美币余额不足！');

            }

            //生成报名表
            $actregistration = $actregistrationTable->newEntity([
                'user_id' => $this->user->id,
                'activity_id' => $activity['id'],
                'status' => 1,
                'cost' => $price,
                'punish' => $price * $activity['punish_percent'] /100,
                'punish_percent' => $activity['punish_percent'],
            ]);
            //生成流水
            //扣除 报名费用
            $pre_amount = $this->user->money;
            $this->user->money = $this->user->money - $price;
            $user = $this->user;
            $after_amount = $this->user->money;
            //生成流水
            $FlowTable = TableRegistry::get('Flow');
            $flow = $FlowTable->newEntity([
                'user_id'=>0,
                'buyer_id'=>  $this->user->id,
                'type'=>$FlowTable::TYPE_ACTIVITY,
                'type_msg'=>'报名派对支出',
                'income'=>2,
                'amount'=>$price,
                'price'=>$price,
                'pre_amount'=>$pre_amount,
                'after_amount'=>$after_amount,
                'paytype'=>1,   //余额支付
                'remark'=> '报名派对支出'
            ]);

            $activityTable = $this->Activity;
            $transRes = $actregistrationTable->connection()->transactional(function()use($flow,$FlowTable,&$actregistration,$actregistrationTable,$activity,$activityTable,$user){
                $UserTable = TableRegistry::get('User');
                $saveActr = $actregistrationTable->save($actregistration);
                $flow->relate_id = $activity->id;
                if($user->gender == 1) {

                    $activity->male_rest -= 1;

                } else {

                    $activity->female_rest -= 1;

                }
                $saveAct = $activityTable->save($activity);
                return $FlowTable->save($flow)&&$saveActr&&$saveAct&&$UserTable->save($user);
            });

            if($transRes){
                return $this->Util->ajaxReturn(true,'参加成功');
            }else{
                errorMsg($flow, '失败');
                errorMsg($actregistration, '失败');
                return $this->Util->ajaxReturn(false,'参加失败');
            }
            return $this->Util->ajaxReturn(true, '参加成功');

        }

        //检查是否已经参与
        $has_in = false;
        $actregistrations = $activity['actregistrations'];
        foreach ($actregistrations as $actregistration) {
            if($this->user->id == $actregistration['user']['id']) {
                $has_in = true;
                break;
            }
        }

        //检查报名人数是否已满
        $lim_flag = false;
        if($this->user->gender == 1) {

            if($activity['male_rest'] == 0) {

                $lim_flag = true;

            }

        } else {

            if($activity['female_rest'] == 0) {

                $lim_flag = true;

            }
        }

        $this->set(['lim_flag' => $lim_flag, 'has_in' => $has_in, 'user' => $this->user, 'activity' => $activity, 'pageTitle' => '美约-活动详情']);
    }


    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $activity = $this->Activity->newEntity();
        if ($this->request->is('post')) {
            $activity = $this->Activity->patchEntity($activity, $this->request->data);
            if ($this->Activity->save($activity)) {
                $this->Flash->success(__('The activity has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The activity could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('activity'));
        $this->set('_serialize', ['activity']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Activity id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $activity = $this->Activity->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $activity = $this->Activity->patchEntity($activity, $this->request->data);
            if ($this->Activity->save($activity)) {
                $this->Flash->success(__('The activity has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The activity could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('activity'));
        $this->set('_serialize', ['activity']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Activity id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $activity = $this->Activity->get($id);
        if ($this->Activity->delete($activity)) {
            $this->Flash->success(__('The activity has been deleted.'));
        } else {
            $this->Flash->error(__('The activity could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
