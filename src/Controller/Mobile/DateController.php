<?php
namespace App\Controller\Mobile;
use Cake\Database\Schema\Table;
use Cake\Datasource\ResultSetInterface;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use DateState;

/**
 * Date Controller
 *
 * @property \App\Model\Table\DateTable $Date
 *
 */
class DateController extends AppController
{

    /**
     * 我的-我发起的约会
     * Index method
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->handCheckLogin();
        if($this->request->is("post")) {
            $datas = $this->Date
                ->find("all", [
                    'contain' => [
                        'UserSkill' => function($q){
                            return $q->contain(['Skill', 'Cost']);
                        }
                    ]
                ]);
            $datas = $datas
                ->where([
                    'Date.user_id' => $this->user->id
                ]);
            if(isset($this->request->data['status'])) {
                $datas->where([
                    "Date.status" => $this->request->data['status'],
                    "Date.start_time >" => new Time()
                ]);
            }
            $datas->formatResults(function(ResultSetInterface $results) {
                return $results->map(function($row) {
                    $row->time = getFormateDT($row->start_time, $row->end_time);
                    //到了约会开始时间还没有人赴约则显示已下线
                    if(($row->start_time <= new Time())
                        && $row->status == DateState::NOT_YET) {
                        $row->status = DateState::DOWN;
                    }
                    $row->status = DateState::getDateStatStr($row->status);
                    return $row;
                });
            });
            //已下线的置底
            $sortDowns = [];
            $sortNorms = [];
            foreach($datas as $data) {
                if($data->status == DateState::getDateStatStr(DateState::DOWN)
                    || $data->status == DateState::getDateStatStr(DateState::BE_DOWN)) {
                    $sortDowns[] = $data;
                }else {
                    $sortNorms[] = $data;
                }
            }
            $uSkillTb = TableRegistry::get('UserSkill');
            $sort = array_merge($sortNorms, $sortDowns);
            return $this->Util->ajaxReturn(['datas' => $sort, 'status' => true]);
        }
        $uSkillTb = TableRegistry::get('UserSkill');
        $uskillCount = $uSkillTb->find()->where(['user_id' => $this->user->id, 'is_used' => 1, 'is_checked' => 1])->count();
        $this->set(["user" => $this->user, 'skill' => $uskillCount, 'pageTitle' => '约会管理']);
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
            'contain' => [
                'UserSkill' => function($q){
                    return $q->contain(['Skill', 'Cost']);
                },
                'User',
                'Tags'
            ]
        ]);
        if($date) {
            if(($date->start_time <= new Time())
                && $date->status == DateState::NOT_YET) {
                $date->status = DateState::DOWN;
            }
        }
        $this->set(['date' => $date, 'pageTitle' => '约会详情']);

    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $date = $this->Date->newEntity();
        if($this->user->status != 3) {
            return $this->Util->ajaxReturn(false, "发布失败");
        }
        if ($this->request->is('post')) {
            $date = $this->Date->patchEntity($date, $this->request->data);
            if ($this->Date->save($date)) {
                return $this->Util->ajaxReturn(true, "发布成功");
            } else {
                return $this->Util->ajaxReturn(false, "发布失败");
            }
        }
        $this->set(['user'=>$this->user, 'pageTitle' => '添加约会']);
    }

    /**
     * Edit method
     * @param string|null $id Date id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null, $status = null)
    {
        $date = $this->Date->get($id, [
            'contain' => [
                'UserSkill' => function($q){
                    return $q->contain(['Skill', 'Cost']);
                },
                'User',
                'Tags'
            ]
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
        $this->set(['date' => $date, 'user'=>$this->user, 'pageTitle' => '约会编辑']);
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


    public function getAllDatesInPage($page)
    {
        $limit = 10;
        $datas = $this->Date->find("all", [
            'contain' => [
                'UserSkill.Skill',
                'UserSkill.Cost',
                'User' => function ($q) {
                    return $q->select(['nick', 'birthday', 'avatar']);}
                ]
            ])
            ->where([
                'Date.status' => 2,
                'Date.start_time >' => new Time()
            ]);
        $posititon = parent::getPosition();
        $userCoord_lng = $posititon[0];
        $userCoord_lat = $posititon[1];
        $datas->order([
            "getDistance($userCoord_lng, $userCoord_lat, login_coord_lng, login_coord_lat)"=>'asc',
            'created_time' => 'desc'
        ]);
        $datas->limit($limit);
        $datas->page($page);
        $datas->formatResults(function(ResultSetInterface $results) {
            return $results->map(function($row) {
                $row->time = getFormateDT($row->start_time, $row->end_time);
                $row->user->age = isset($row['user']['birthday'])?getAge($row['user']['birthday']):'xx';
                $row->total_price = ($row->end_time->hour - $row->start_time->hour) * $row->price;
                return $row;
            });
        });
        return $this->Util->ajaxReturn(['datas' => $datas->toArray(), 'status' => true]);
    }

}
