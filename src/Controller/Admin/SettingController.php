<?php
namespace App\Controller\Admin;

use Wpadmin\Controller\AppController;

/**
 * Setting Controller
 *
 * @property \App\Model\Table\SettingTable $Setting
 */
class SettingController extends AppController
{
    /**
     * View method
     *
     * @param string|null $id Setting id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $setting = $this->Setting->find()->where(['type' => \Sysetting::DATE_SHARE_DESC])->first();
        if ($this->request->is(['post', 'put'])) {
            if(!$setting) {
                $setting = $this->Setting->newEntity();
                $setting->name = '约会分享描述设置';
                $setting->content = '美约';
                $setting->type = \Sysetting::DATE_SHARE_DESC;
                $setting->admin_id = 0;
            }
            $setting = $this->Setting->patchEntity($setting, $this->request->data);
            if ($this->Setting->save($setting)) {
                \Cake\Cache\Cache::write('DATE_SHARE_DESC', $setting);
                $this->Util->ajaxReturn(true, '修改成功');
            } else {
                //$errors = $setting->errors();
                //$this->Util->ajaxReturn(['status' => false, 'msg' => getMessage($errors), 'errors' => $errors]);
                $this->Util->ajaxReturn(false, '修改失败');
            }
        }
        $this->set([
            'setting' => $setting,
            'pageTitle' => '约会分享描述管理 ',
            'bread' => [
                'first' => ['name' => '基础管理'],
                'second' => ['name' => '约会分享描述管理'],
            ],
        ]);
    }
}
