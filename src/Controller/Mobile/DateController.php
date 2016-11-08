<?php
namespace App\Controller\Mobile;

/**
 * Date Controller
 *
 * @property \App\Model\Table\DateTable $Date
 *
 */
class DateController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index($user_id = null)
    {

        if($this->request->is("post")) {

            $datas = $this->Date->find("all", ['contain' => ['Skill']]);
            if($user_id) {

                $datas = $datas->where(['user_id' => $user_id]);
                if(isset($this->request->data['status'])) {

                    $datas->where(["status" => $this->request->data['status']]);

                }

            } else{

                $datas = $datas->contain(['User' => function ($q) {
                    return $q->select(['nick', 'birthday']);}]);
                $userCoord_lng = $this->user->login_coord_lng;
                $userCoord_lat = $this->user->login_coord_lat;
                $datas->order(["getDistance($userCoord_lng, $userCoord_lat, user.login_coord_lng, user.login_coord_lat)"=>'asc',
                    'created_time' => 'desc']);

            }
            return $this->Util->ajaxReturn(['datas' => $datas->toArray(), 'status' => true]);

        }
        $this->set("user", $this->user);

    }

    /**
     * View method
     *
     * @param string|null $id Date id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $date = $this->Date->get($id, [
            'contain' => ['Skill', 'User', 'Tag']
        ]);
        $this->set('date', $date);

    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $date = $this->Date->newEntity();
        if ($this->request->is('post')) {
            $date = $this->Date->patchEntity($date, $this->request->data);
            if ($this->Date->save($date)) {
                return $this->Util->ajaxReturn(true, "发布成功");
            } else {
                return $this->Util->ajaxReturn(false, "发布失败");
            }
        }
        $this->set(['user'=>$this->user]);
    }

    /**
     * Edit method
     *
     * @param string|null $id Date id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null, $status = null)
    {

        $date = $this->Date->get($id, [
            'contain' => ['Skill', 'User', 'Tag']
        ]);
        //修改信息
        if($this->request->is("POST")) {

            $date = $this->Date->patchEntity($date, $this->request->data);
            if ($this->Date->save($date)) {
                return $this->Util->ajaxReturn(true, "发布成功");
            } else {
                return $this->Util->ajaxReturn(false, "发布失败");
            }

        }
        //修改状态
        if($this->request->is("PUT")) {

            $date = $this->Date->get($id);
            $date->set("status", $status);
            if ($this->Date->save($date)) {
                return $this->Util->ajaxReturn(true, "成功下架");
            } else {
                return $this->Util->ajaxReturn(false, "下架失败");
            }

        }
        $this->set(['date' => $date, 'user'=>$this->user]);
    }

    /**
     * Delete method
     *
     * @param string|null $id Date id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $date = $this->Date->get($id);
        if ($this->Date->delete($date)) {
            return $this->Util->ajaxReturn(true, "删除成功");
        } else {
            return $this->Util->ajaxReturn(false, "删除失败");
        }
    }

}
