<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Utility\Security;

/**
 * 加解密
 * Encrypt component 
 */
class EncryptComponent extends Component {

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    /**
     *
     * @var type 
     */
    protected $key;

    /**
     *
     * @var type 
     */
    protected $salt;

    public function initialize(array $config) {
        parent::initialize($config);
        $conf = \Cake\Core\Configure::read('encrypt');
        $this->key = $conf['key'];
        $this->salt = $conf['salt'];
        if (empty($this->key) || empty($this->salt)) {
            throw new \Cake\Core\Exception\Exception('KEY或salt未配置');
        }
    }

    public function encrypt($plain) {
        return base64_encode(Security::encrypt($plain, $this->key, $this->salt));
    }

    public function decrypt($cipher) {
        return Security::decrypt(base64_decode($cipher), $this->key, $this->salt);
    }

}
