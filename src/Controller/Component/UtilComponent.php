<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;

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

}
