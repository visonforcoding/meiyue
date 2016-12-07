<?php

namespace App\Shell;

use Cake\Console\Shell;
use App\Pack\Netim;

/**
 * Netim shell command. 云信
 */
class NetimShell extends Shell {
    
    const REDIS_HASH_KEY = 'meiyue_im_pool_hash';
    const REDIS_SET_KEY = 'meiyue_im_pool';


    protected $pool_nums = 50;

    /**
     * Manage the available sub-commands along with their arguments and help
     *
     * @see http://book.cakephp.org/3.0/en/console-and-shells.html#configuring-options-and-generating-help
     *
     * @return \Cake\Console\ConsoleOptionParser
     */
    public function getOptionParser() {
        $parser = parent::getOptionParser();

        return $parser;
    }
    
    public function __construct(\Cake\Console\ConsoleIo $io = null) {
        parent::__construct($io);
    }

    /**
     * main() method.
     *
     * @return bool|int Success or error code.
     */
    public function main() {
        $this->out($this->OptionParser->help());
    }

    public function check() {
        set_time_limit(0);
        $RedisConf = \Cake\Core\Configure::read('Redis.default');
        $redis = new \Redis();
        $redis->connect($RedisConf['host'], $RedisConf['port']);
        $im_counts = $redis->sSize(self::REDIS_SET_KEY);
        if($im_counts<$this->pool_nums){
            $num = $this->pool_nums-$im_counts;
            \Cake\Log\Log::info('填充im池'.$num.'条','cron');
            $this->addIm($num);
        }
    }

    protected function addIm($nums = 10) {
        $RedisConf = \Cake\Core\Configure::read('Redis.default');
        $redis = new \Redis();
        $redis->connect($RedisConf['host'], $RedisConf['port']);
        $Netim = new Netim();
        while ($nums > 0) {
            $nums--;
            $ImpoolTable = \Cake\ORM\TableRegistry::get('Impool');
            $counts = $ImpoolTable->find()->count();
            $no = $counts + 1;
            $accid = 'meiyue_' . $no;
            $token = $Netim->registerIm($accid);
            debug($accid);
            debug($token);
            $data = [];
            if ($token) {
                $data['accid'] = $accid;
                $data['token'] = $token;
                try {
                    $im = $ImpoolTable->newEntity($data);
                    $ImpoolTable->save($im);
                } catch (\Exception $exc) {
                    //
                    \Cake\Log\Log::error('Netim cron 进数据库失败,[accid:]' . $accid . '[token:]' . $token, 'cron');
                }
                $redisRs = $redis->hSet(self::REDIS_HASH_KEY, $accid, $token)&&$redis->sAdd(self::REDIS_SET_KEY,$accid);
                \Cake\Log\Log::info('Netim cron 进redis池结果为:' . $redisRs . ',[accid:]' . $accid . '[token:]' . $token, 'cron');
                if ($redisRs === false) {
                    dblog('netim', '存储redis失败' . ',[accid:]' . $accid . '[token:]' . $token);
                }
            } else {
                dblog('netim', '注册accid失败');
            }
        }
    }

    
    /**
     * 初始化填充池
     */
    public function initPool() {
        set_time_limit(0);
        $this->addIm($this->pool_nums);
    }
    
    public function getIm(){
        $RedisConf = \Cake\Core\Configure::read('Redis.default');
        $redis = new \Redis();
        $redis->connect($RedisConf['host'], $RedisConf['port']);
        $accid = $redis->sPop(self::REDIS_SET_KEY);
        $token = $redis->hGet(self::REDIS_HASH_KEY,$accid);
        debug($accid);
        debug($token);
    }
    
    public function test(){
        $this->addIm(1);
    }

}
