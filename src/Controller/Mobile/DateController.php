<?php
namespace App\Controller\Mobile;
use Cake\Datasource\ResultSetInterface;

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

            $datas = $this->Date->find("all", ['contain' => ['UserSkill' => function($q){
                return $q->contain(['Skill', 'Cost']);
            }]]);
            if($user_id) {

                $datas = $datas->where(['Date.user_id' => $user_id]);
                if(isset($this->request->data['status'])) {

                    $datas->where(["Date.status" => $this->request->data['status']]);

                }

            } else{

                $datas = $datas->contain(['User' => function ($q) {
                    return $q->select(['nick', 'birthday']);}])
                    ->where(['Date.status' => 2]);
                $userCoord_lng = $this->user->login_coord_lng;
                $userCoord_lat = $this->user->login_coord_lat;
                $datas->order(["getDistance($userCoord_lng, $userCoord_lat, login_coord_lng, login_coord_lat)"=>'asc',
                    'created_time' => 'desc']);

            }
            $datas->formatResults(function(ResultSetInterface $results) {

                return $results->map(function($row) {
                    $row->time = getFormateDT($row->start_time, $row->end_time);
                    return $row;
                });

            });
            return $this->Util->ajaxReturn(['datas' => $datas->toArray(), 'status' => true]);

        }
        $this->set(["user" => $this->user, 'pageTitle' => '美约-约会管理']);

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
            'contain' => ['UserSkill' => function($q){
                return $q->contain(['Skill', 'Cost']);
            }, 'User', 'Tags']
        ]);
        $this->set(['date' => $date, 'pageTitle' => '美约-约会详情']);

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
        $this->set(['user'=>$this->user, 'pageTitle' => '美约-添加约会']);
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
            'contain' => ['UserSkill' => function($q){
                return $q->contain(['Skill', 'Cost']);
            }, 'User', 'Tags']
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
        $this->set(['date' => $date, 'user'=>$this->user, 'pageTitle' => '美约-约会编辑']);
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
