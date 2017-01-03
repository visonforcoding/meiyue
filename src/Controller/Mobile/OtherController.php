<?php

namespace App\Controller\Mobile;

use App\Controller\Mobile\AppController;

/**
 * Index Controller
 *
 * @property \App\Model\Table\IndexTable $Index
 * @property \App\Controller\Component\SmsComponent $Sms
 * @property \App\Controller\Component\WxComponent $Wx
 * @property \App\Controller\Component\EncryptComponent $Encrypt
 * @property \App\Controller\Component\PushComponent $Push
 * @property \App\Controller\Component\BdmapComponent $Bdmap
 * @property \App\Controller\Component\BusinessComponent $Business
 */
class OtherController extends AppController {
    
    public function downApp(){
        $this->set([
            'pageTitle'=>'下载app'
        ]);
    }
}
