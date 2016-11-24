<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\I18n\Time;

/**
 * Util component
 */
class UtilComponent extends Component {

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    protected $_flagConfig = [];

    /**
     * ajax 返回json object response object
     * @param array/bool $status 可为数组也可以为bool
     * @param \Cake\Network\Response $response
     */
    public function ajaxReturn($status, $msg = '', $statusCode = 200) {
        $this->autoRender = false;
        $this->response->type('json');
        if (is_array($status) && !empty($status)) {
            if (!array_key_exists('code', $status)) {
                $status['code'] = 200;
            }
            $json = json_encode($status, JSON_UNESCAPED_UNICODE);
        } else {
            $json = json_encode(array('status' => $status, 'msg' => $msg, 'code' => $statusCode), JSON_UNESCAPED_UNICODE);
        }
        $this->response->body($json);
        return $this->response;
    }

    /**
     * 对重要信息的数据库日志记录，例如订单漏单
     * @param type $flag self:const
     * @param type $msg
     * @param type $data
     */
    public function dblog($flag, $msg, $data = null) {
        $LogTable = \Cake\ORM\TableRegistry::get('Log');

        $log = $LogTable->newEntity();
        if ($data) {
            $log->data = var_export($data, true);
        }
        $log = $LogTable->patchEntity($log, [
            'flag' => $flag,
            'msg' => $msg
        ]);
        $LogTable->save($log);
    }

    /**
     * 存储网络图片
     * @param type $url
     * @param type $dir
     */
    public function saveUrlImage($url, $dir = null) {
        $today = date('Y-m-d');
        $urlpath = '/upload/tmp/' . $today . '/';
        if (!empty($dir)) {
            $urlpath = '/upload/' . $dir . '/' . $today . '/';
        }
        $savePath = ROOT . '/webroot' . $urlpath;
        if (!is_dir($savePath)) {
            mkdir($savePath, 0777, true);
        }
        $uniqid = uniqid();
        $filename = $uniqid . '.jpg';
        $image = \Intervention\Image\ImageManagerStatic::make($url);
        $image->save($savePath . $filename);
        return $urlpath . $filename;
    }

    
    /**
     * 多文件上传 
     * @param string $dir  存储路径
     * @return array
     */
    public function uploadFiles($dir=null) {
        set_time_limit(0);
        $today = date('Y-m-d');
        $urlpath = '/upload/tmp/' . $today . '/';
        if (!empty($dir)) {
            $urlpath = '/upload/' . $dir . '/' . $today . '/';
        }
        $savePath = ROOT . '/webroot' . $urlpath;
        $upload = new \Wpadmin\Utils\UploadFile(); // 实例化上传类
//        $upload->maxSize = 31457280; // 设置附件上传大小
        $upload->allowExts = array('jpg', 'gif', 'png', 'jpeg', 'zip', 'ppt',
            'pptx', 'doc', 'docx', 'xls', 'xlsx', 'webp', 'rar', 'mp3', 'mp4', 'm4v', 'pdf'); // 设置附件上传类型
        $upload->savePath = $savePath; // 设置附件上传目录
        if (!$upload->upload()) {// 上传错误提示错误信息
            $response['status'] = false;
            $response['msg'] = $upload->getErrorMsg();
        } else {// 上传成功 获取上传文件信息
            $infos = $upload->getUploadFileInfo();
            $response['status'] = true;
            foreach($infos as $key=>$info){
                $infos[$key]['path'] = $urlpath.$info['savename'];
            }
            $response['info'] = $infos;
            $response['msg'] = '上传成功!';
        }
        return $response;
    }

    /**
     * 获取匹配模型
     * @return string
     */
    public function loadWordPatt() {
        $pattern = \Cake\Cache\Cache::read('wordpatt', 'redis');
        if (!$pattern) {
            $WordTable = \Cake\ORM\TableRegistry::get('Word');
            $words = $WordTable->find('list', [
                        'keyField' => 'id',
                        'valueField' => 'body'
                    ])->hydrate(false)->toList();
            $pattern = '';
            $patt = implode('|', array_values($words));
            $pattern = '/' . $patt . '/';
            \Cake\Cache\Cache::write('wordpatt', $pattern, 'redis');
        }
        return $pattern;
    }
    
    public function getServerDomain(){
        return $this->request->scheme().'://'.$this->request->env('SERVER_NAME'); 
    }


    /**
     * 获取我的排名对象
     * @param string $type
     * @return mixed|null
     */
    public function getMyTop($type = 'week', $userid) {

        $mytop = null;
        //获取我的排名
        $FlowTable = \Cake\ORM\TableRegistry::get('Flow');
        $query = $FlowTable->find();
        $query->contain(['User' => function($q) use($userid) {
            return $q->select(['id','avatar','nick','phone','gender','birthday'])
                     ->where(['User.id' => $userid]);
        }])
            ->select(['total' => 'sum(amount)'])
            ->where(['income' => 1])
            ->map(function($row) {
                $row['user']['age'] = getAge($row['user']['birthday']);
                $row['ishead'] = false;
                return $row;
            });
        $mytop = $query->first();
        $mytop->user->age = getAge($mytop->user->birthday);
        $mytop->ishead = true;

        //获取我的排名对象
        $where = Array(
            'income' => 1
        );
        if('week' == $type) {
            $where['Flow.create_time >='] = new Time('last sunday');
        } else if('month' == $type) {
            $da = new Time();
            $where['Flow.create_time >='] = new Time(new Time($da->year . '-' . $da->month . '-' . '01 00:00:00'));
        }
        $iquery = $FlowTable->find('list')
            ->contain([
                'User'=>function($q) use($mytop) {
                    return $q->where(['gender'=>2, 'User.id !=' => $mytop->user->id]);
                },
            ])
            ->select(['total' => 'sum(amount)'])
            ->where($where)
            ->group('Flow.user_id')
            ->having(['total >= ' => $mytop->total]);

        //计算排名
        $mytop->index = $iquery->count() + 1;
        return $mytop;

    }
}
