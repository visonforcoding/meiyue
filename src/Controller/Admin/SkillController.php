<?php
namespace App\Controller\Admin;

use Wpadmin\Controller\AppController;

/**
 * Skill Controller
 *
 * @property \App\Model\Table\SkillTable $Skill
 */
class SkillController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('skills', $this->Skill->find('threaded')->toArray());
    }

    /**
     * View method
     *
     * @param string|null $id Skill id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->viewBuilder()->autoLayout(false);
        $skill = $this->Skill->get($id, [
            'contain' => []
        ]);
        $this->set('skill', $skill);
        $this->set('_serialize', ['skill']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($parent_id)
    {
        $skill = $this->Skill->newEntity();
        $skill->parent_id = $parent_id;
        if ($this->request->is('post')) {
            $skill = $this->Skill->patchEntity($skill, $this->request->data);
            if ($this->Skill->save($skill)) {
                $this->Util->ajaxReturn(true, '添加成功');
            } else {
                $errors = $skill->errors();
                $this->Util->ajaxReturn(['status' => false, 'msg' => getMessage($errors), 'errors' => $errors]);
            }
        }
        $this->set(compact('skill'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Skill id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $skill = $this->Skill->get($id);
        if ($this->request->is(['post', 'put'])) {
            $skill = $this->Skill->patchEntity($skill, $this->request->data);
            if ($this->Skill->save($skill)) {
                $this->Util->ajaxReturn(true, '修改成功');
            } else {
                $errors = $skill->errors();
                $this->Util->ajaxReturn(false, getMessage($errors));
            }
        }
        $this->set(compact('skill'));
    }


    /**
     * Delete method
     *
     * @param string|null $id Skill id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod('post');
        $id = $this->request->data('id');
        if ($this->request->is('post')) {
            $skill = $this->Skill->get($id);
            if ($this->Skill->delete($skill)) {
                $this->Util->ajaxReturn(true, '删除成功');
            } else {
                $errors = $skill->errors();
                $this->Util->ajaxReturn(true, getMessage($errors));
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
        $sort = 'Skill.' . $this->request->data('sidx');
        $order = $this->request->data('sord');
        $keywords = $this->request->data('keywords');
        $begin_time = $this->request->data('begin_time');
        $end_time = $this->request->data('end_time');
        $type = $this->request->data('type');
        $where = [];
        if (!empty($keywords)) {
            $where[' name like'] = "%$keywords%";
        }

        if('skill' == $type) {
            $where['and'] = "depth = 1";
        } elseif ('category' == $type) {
            $where['and'] = "depth = 0";
        }

        if (!empty($begin_time) && !empty($end_time)) {
            $begin_time = date('Y-m-d', strtotime($begin_time));
            $end_time = date('Y-m-d', strtotime($end_time));
            $where['and'] = [['date(`create_time`) >' => $begin_time], ['date(`create_time`) <' => $end_time]];
        }
        $data = $this->getJsonForJqrid($page, $rows, '', $sort, $order, $where);
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
        $Table = $this->Skill;
        $column = ['技能名称'];
        $query = $Table->find();
        $query->hydrate(false);
        $query->select(['name']);
        if (!empty($where)) {
            $query->where($where);
        }
        if (!empty($sort) && !empty($order)) {
            $query->order([$sort => $order]);
        }
        $res = $query->toArray();
        $this->autoRender = false;
        $filename = 'Skill_' . date('Y-m-d') . '.csv';
        \Wpadmin\Utils\Export::exportCsv($column, $res, $filename);

    }
}
