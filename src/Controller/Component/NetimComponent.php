<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use App\Pack\Netim;

/**
 * Netim component
 */
class NetimComponent extends Component {
    
    
    /**
     * 
     *  
     */
    protected $Netim;

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    protected $appkey;
    protected $appSecret;

    public function initialize(array $config) {
        parent::initialize($config);
        $this->Netim = new Netim();
    }
    
    public function test(){
        
    }

}
