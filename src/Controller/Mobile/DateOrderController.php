<?php
namespace App\Controller\Mobile;
use Cake\ORM\TableRegistry;


/**
 * DateOrder Controller
 *
 * @property \App\Model\Table\DateOrderTable $DateOrder
 */
class DateOrderController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->set('user', $this->user);
    }


    /**
     * 约会支付详情页--赴约流程
     * @param int $id
     */
    public function join($id = null)
    {

        $dateTable = TableRegistry::get("Date");
        $date = $dateTable->get($id, ['contain' => ['Skill', 'Tag', 'User' => function ($q) {
            return $q->select(['nick', 'birthday', 'gender']);}]]);
        $this->set(['date' => $date, 'user' => $this->user]);


    }


    /**
     * View method
     *
     * @param string|null $id Date Order id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->set('user', $this->user);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $dateOrder = $this->DateOrder->newEntity();
        if ($this->request->is('post')) {
            $dateOrder = $this->DateOrder->patchEntity($dateOrder, $this->request->data);
            if ($this->DateOrder->save($dateOrder)) {
                $this->Flash->success(__('The date order has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The date order could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('dateOrder'));
        $this->set('_serialize', ['dateOrder']);
    }


    /**
     * Edit method
     *
     * @param string|null $id Date Order id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $dateOrder = $this->DateOrder->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $dateOrder = $this->DateOrder->patchEntity($dateOrder, $this->request->data);
            if ($this->DateOrder->save($dateOrder)) {
                $this->Flash->success(__('The date order has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The date order could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('dateOrder'));
        $this->set('_serialize', ['dateOrder']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Date Order id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $dateOrder = $this->DateOrder->get($id);
        if ($this->DateOrder->delete($dateOrder)) {
            $this->Flash->success(__('The date order has been deleted.'));
        } else {
            $this->Flash->error(__('The date order could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
