<?php

namespace App\Controller\Admin;

use Cake\ORM\TableRegistry;
use UserStatus;
use Wpadmin\Controller\AppController;

/**
 * User Controller
 *
 * @property \App\Model\Table\UserTable $User
 */
class UserController extends AppController {

    /**
     * Index method
     *
     * @return void
     */
    public function index() {
        $this->set('user', $this->User);
        $this->set([
            'pageTitle' => '用户列表',
            'bread' => [
                'first' => ['name' => 'xxx'],
                'second' => ['name' => 'user管理'],
            ],
        ]);
    }


    /**
     * 男性用户列表
     */
    public function maleIndex() {
        $this->set([
            'pageTitle' => '男性用户列表',
            'bread' => [
                'first' => ['name' => '用户管理'],
                'second' => ['name' => '男性用户列表'],
            ],
        ]);
    }
    
    
    /**
     * MView method
     * @param string|null $id User id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function mview($id = null) {
        $paihang = $this->User->find()->select()->where(['recharge >' => $this->recharge])->count();
        $user = $this->User->find()
                ->contain([
                    'Tags', 
                    'UserSkills.Skill',
                    'Fans', 
                    'Upacks' => function($q) {
                        return $q->orderDesc('create_time')->limit(1);
                    }
                ])
                ->where(['id' => $id])
                ->map(function($row) use($paihang){
                    $row->fanum = count($row->fans);
                    $row->paihang = $paihang;
                    $row->viptype = '无';
                    if(count($row->upacks)) {
                        $row->viptype = $row['upacks'][0]['title'];
                    }
                    return $row;
                })
                ->first();
        $this->set('user', $user);
        $this->set('_serialize', ['user']);
        $this->set([
            'pageTitle' => '用户审核',
            'bread' => [
                'first' => ['name' => '用户管理'],
                'second' => ['name' => '用户审核'],
            ],
        ]);
    }


    /**
     * 美女用户列表视图
     */
    public function femaleIndex() {
        $this->set([
            'pageTitle' => '美女用户列表',
            'bread' => [
                'first' => ['name' => '用户管理'],
                'second' => ['name' => '美女用户列表'],
            ],
        ]);
    }

    
    /**
     * FMView method
     * @param string|null $id User id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function fmview($id) {
        $user = $this->User->find()
                ->contain([
                    'Tags', 
                    'UserSkills.Skill',
                    'Fans', 
                    'Follows'
                ])
                ->where(['id' => $id])
                ->map(function($row) {
                    $row->fonum = count($row->follows);
                    $row->fanum = count($row->fans);
                    $row->follownum = count($row->follows);
                    return $row;
                })
                ->first();
        
        $this->set('user', $user);
        $this->set('_serialize', ['user']);
        $this->set([
            'pageTitle' => '用户审核',
            'bread' => [
                'first' => ['name' => '用户管理'],
                'second' => ['name' => '用户审核'],
            ],
        ]);
    }

    /**
     * 获取美女列表
     */
    public function getFemales() {
        $this->request->allowMethod('ajax');
        $page = $this->request->data('page');
        $rows = $this->request->data('rows');
        $sort = 'User.' . $this->request->data('sidx');
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
        $where['gender'] = 2;
        $query = $this->User->find();
        $query->hydrate(false);
        if (!empty($where)) {
            $query->where($where);
        }
        $query->contain([
            'Fans',
            'Follows',
            'Flows' => function($q) {
                return $q->select(['user_id', 'amounts' => 'sum(amount)']);
            }
        ]);
        $nums = $query->count();
        if (!empty($sort) && !empty($order)) {
            $query->order([$sort => $order]);
        }

        $query->limit(intval($rows))
            ->page(intval($page));
        $query->formatResults(function($items) {
            return $items->map(function($item) {
                $item['myno'] = 'my'.  str_pad($item['id'],8, 0,STR_PAD_LEFT);
                $item['age'] = (isset($item['birthday']))?getAge($item['birthday']):'无';
                $item['status'] = UserStatus::getStatus($item['status']);
                $item['fancount'] = count($item['fans']);
                $item['followcount'] = count($item['follows']);
                if(count($item['flows']) > 0) {
                    $item['meili'] = $item['flows'][0]['amounts'];
                } else {
                    $item['meili'] = 0;
                }
                //时间语义化转换
                return $item;
            });
        });
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

    
    public function check($uid) {
        if($this->request->is('POST')) {
            $user = $this->User->get($uid);
            $user = $this->User->patchEntity($user, $this->request->data);
            $mvTb = TableRegistry::get('Movement');
            $delres = $mvTb->query()->delete()->where([['user_id' => $uid, 'type IN' => [3, 4]]])->execute();
            if($delres) {
                $mv_vid = null;
                $mv_pic = null;
                if($user->video) {
                    $mv_vid = $mvTb->newEntity([
                        'user_id' => $uid,
                        'type' => 4,
                        'body' => '',
                        'video' => $user->video,
                        'video_cover' => $user->video_cover,
                        'view_nums' => 0,
                        'praise_nums' => 0,
                        'status' => 2,
                    ]);
                }
                if($user->images) {
                    $mv_pic = $mvTb->newEntity([
                        'user_id' => $uid,
                        'type' => 3,
                        'body' => '',
                        'images' => $user->images,
                        'view_nums' => 0,
                        'praise_nums' => 0,
                        'status' => 2,
                    ]);
                }

                switch($user->status) {
                    case UserStatus::CHECKING:
                        if($mv_pic) {
                            $mv_pic->status = 1;
                        }
                        if($mv_vid) {
                            $mv_vid->status = 1;
                        }
                        break;
                    case UserStatus::NOPASS:
                        if($mv_pic) {
                            $mv_pic->status = 3;
                        }
                        if($mv_vid) {
                            $mv_vid->status = 3;
                        }
                        break;
                    case UserStatus::PASS:
                        if($mv_pic) {
                            $mv_pic->status = 2;
                        }
                        if($mv_vid) {
                            $mv_vid->status = 2;
                        }
                        break;
                }
                $res = $this->User->connection()->transactional(function() use($user, $mvTb, $mv_pic, $mv_vid) {
                    $mvres1 = true;
                    $mvres2 = true;
                    if($mv_pic) {
                        $mvres1 = $mvTb->save($mv_pic);
                    }
                    if($mv_vid) {
                        $mvres2 = $mvTb->save($mv_vid);
                    }
                    $ures = $this->User->save($user);
                    return $mvres1&&$mvres2&&$ures;
                });
                if ($res) {
                    $this->Util->ajaxReturn(true, '修改成功');
                } else {
                    $this->Util->ajaxReturn(false, '修改失败');
                }
            } else {
                $this->Util->ajaxReturn(false, '修改失败');
            }
        }
        $this->Util->ajaxReturn(false, '修改失败');
    }

    /**
     * 获取男性用户列表
     */
    public function getMales() {
        $this->request->allowMethod('ajax');
        $page = $this->request->data('page');
        $rows = $this->request->data('rows');
        $sort = 'User.' . $this->request->data('sidx');
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
        $where['gender'] = 1;
        $query = $this->User->find();
        $query->hydrate(false);
        if (!empty($where)) {
            $query->where($where);
        }
        $query->contain([
            'Fans'
        ]);
        $nums = $query->count();
        if (!empty($sort) && !empty($order)) {
            $query->order([$sort => $order]);
        }

        $query->limit(intval($rows))
            ->page(intval($page));
        $query->formatResults(function($items) {
            return $items->map(function($item) {
                $item['myno'] = 'my'.  str_pad($item['id'],8, 0,STR_PAD_LEFT);
                $item['age'] = (isset($item['birthday']))?getAge($item['birthday']):'无';
                $item['status'] = UserStatus::getStatus($item['status']);
                $item['fancount'] = count($item['fans']);
                //时间语义化转换
                return $item;
            });
        });
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
     * View method
     * @param string|null $id User id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null) {
        $user = $this->User->get($id, [
            'contain' => ['Tags', 'UserSkills', 'Fans', 'Follows']
        ]);
        $this->set('user', $user);
        $this->set('_serialize', ['user']);
        $this->set([
            'pageTitle' => '用户审核',
            'bread' => [
                'first' => ['name' => '用户管理'],
                'second' => ['name' => '用户审核'],
            ],
        ]);
    }


    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $user = $this->User->newEntity();
        if ($this->request->is('post')) {
            $user = $this->User->patchEntity($user, $this->request->data);
            if ($this->User->save($user)) {
                $this->Util->ajaxReturn(true, '添加成功');
            } else {
                $errors = $user->errors();
                $this->Util->ajaxReturn(['status' => false, 'msg' => getMessage($errors), 'errors' => $errors]);
            }
        }
        $tags = $this->User->Tags->find('list', ['limit' => 200]);
        $this->set(compact('user', 'tags'));
        $this->set([
            'pageTitle' => 'user添加',
            'bread' => [
                'first' => ['name' => 'xxx'],
                'second' => ['name' => 'user添加'],
            ],
        ]);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $user = $this->User->get($id, [
            'contain' => ['Tags']
        ]);
        if ($this->request->is(['post', 'put'])) {
            $user = $this->User->patchEntity($user, $this->request->data);
            if ($this->User->save($user)) {
                $this->Util->ajaxReturn(true, '修改成功');
            } else {
                $errors = $user->errors();
                $this->Util->ajaxReturn(false, getMessage($errors));
            }
        }
        $tags = $this->User->Tags->find('list', ['limit' => 200]);
        $this->set(compact('user', 'tags'));
        $this->set([
            'pageTitle' => 'user修改',
            'bread' => [
                'first' => ['name' => 'xxx'],
                'second' => ['name' => 'user修改'],
            ],
        ]);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod('post');
        $id = $this->request->data('id');
        if ($this->request->is('post')) {
            $user = $this->User->get($id);
            if ($this->User->delete($user)) {
                $this->Util->ajaxReturn(true, '删除成功');
            } else {
                $errors = $user->errors();
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
        $sort = 'User.' . $this->request->data('sidx');
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
        $query = $this->User->find();
        $query->hydrate(false);
        if (!empty($where)) {
            $query->where($where);
        }
        $query->contain(['Tags', 'UserSkills', 'Fans', 'Follows']);
        $nums = $query->count();
        if (!empty($sort) && !empty($order)) {
            $query->order([$sort => $order]);
        }

        $query->limit(intval($rows))
                ->page(intval($page));
        $query->formatResults(function($items) {
            return $items->map(function($item) {
                        $item['myno'] = 'my'.  str_pad($item['id'],8, 0,STR_PAD_LEFT);
                        //时间语义化转换
                        return $item;
                    });
        });
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
        $Table = $this->User;
        $column = ['手机号', '密码', '用户标志', 'wx_unionid', '微信的openid', 'app端的微信id', '昵称', '真实姓名', '职业', '邮箱', '1,男，2女', '生日', '星座', '体重(KG)', '身高(cm)', '三围', '罩杯', '家乡', '常驻城市', '头像', '情感状态', '工作经历', '常出没地', '最喜欢美食', '音乐', '电影', '运动', '个性签名', '微信号', '账户余额(美币)', '审核状态1待审核2审核不通过3审核通过', '账号状态 ：1.可用0禁用(控制登录)', '身份证路径', '身份证正面照', '身份证背面照', '手持身份照', '基本照片', '基本视频', '基本视频封面', '充值总额', '是否假删除：1,是0否', '注册设备', '创建时间', '修改时间', '上次登陆时间', '上次登录坐标', '上次登录坐标', '唯一码（用于扫码登录）', '云信token'];
        $query = $Table->find();
        $query->hydrate(false);
        $query->select(['phone', 'pwd', 'user_token', 'union_id', 'wx_openid', 'app_wx_openid', 'nick', 'truename', 'profession', 'email', 'gender', 'birthday', 'zodiac', 'weight', 'height', 'bwh', 'cup', 'hometown', 'city', 'avatar', 'state', 'career', 'place', 'food', 'music', 'movie', 'sport', 'sign', 'wxid', 'money', 'status', 'enabled', 'idpath', 'idfront', 'idback', 'idperson', 'images', 'video', 'video_cover', 'recharge', 'is_del', 'device', 'create_time', 'update_time', 'login_time', 'login_coord_lng', 'login_coord_lat', 'guid', 'imtoken']);
        if (!empty($where)) {
            $query->where($where);
        }
        if (!empty($sort) && !empty($order)) {
            $query->order([$sort => $order]);
        }
        $res = $query->toArray();
        $this->autoRender = false;
        $filename = 'User_' . date('Y-m-d') . '.csv';
        \Wpadmin\Utils\Export::exportCsv($column, $res, $filename);
    }

}
