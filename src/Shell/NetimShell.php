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
    const REDIS_WAIT_UPINFO_KEY = 'meiyue_im_info_queue';  //名片更新待处理队列
    const REDIS_WAIT_UPINFO_FAIL_KEY = 'meiyue_im_info__fail_queue';  //名片更新待处理队列

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
        if ($im_counts < $this->pool_nums) {
            $num = $this->pool_nums - $im_counts;
            \Cake\Log\Log::info('填充im池' . $num . '条', 'cron');
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
                $redisRs = $redis->hSet(self::REDIS_HASH_KEY, $accid, $token) && $redis->sAdd(self::REDIS_SET_KEY, $accid);
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

    public function getIm() {
        $RedisConf = \Cake\Core\Configure::read('Redis.default');
        $redis = new \Redis();
        $redis->connect($RedisConf['host'], $RedisConf['port']);
        $accid = $redis->sPop(self::REDIS_SET_KEY);
        $token = $redis->hGet(self::REDIS_HASH_KEY, $accid);
        if ($accid === false) {
            return false;
        }
        debug($accid);
        debug($token);
        return [
            'accid' => $accid,
            'token' => $token
        ];
    }

    public function test() {
        $this->addIm(20);
    }

    /**
     * 更新用户的im 信息
     */
    public function updateUserIm() {
        $UserTable = \Cake\ORM\TableRegistry::get('User');
        $users = $UserTable->find()->select(['imaccid', 'imtoken', 'id'])->toArray();
        foreach ($users as $user) {
            $im = $this->getIm();
            if ($im) {
                $user->imaccid = $im['accid'];
                $user->imtoken = $im['token'];
            }
            if ($UserTable->save($user)) {
                \Cake\Log\Log::info('更新user im信息成功', 'cron');
            }
        }
    }

    /**
     * 补掉没有imaccid的用户
     */
    public function addUserIm() {
        $UserTable = \Cake\ORM\TableRegistry::get('User');
        $users = $UserTable->find()->select(['imaccid', 'imtoken', 'id'])
                ->where(['imaccid' => ''])
                ->orWhere(['imtoken' => ''])
                ->toArray();
        foreach ($users as $user) {
            $im = $this->getIm();
            if ($im) {
                $user->imaccid = $im['accid'];
                $user->imtoken = $im['token'];
            }
            if ($UserTable->save($user)) {
                \Cake\Log\Log::info('更新user im信息成功', 'cron');
            }
        }
    }

    public function updateAllInfo() {
        set_time_limit(0);
        $UserTable = \Cake\ORM\TableRegistry::get('User');
        $users = $UserTable->find()->select(['imaccid', 'imtoken', 'id', 'nick', 'avatar', 'gender'])
                ->where(['imaccid !=' => '', 'imtoken !=' => ''])
                ->toArray();
        foreach ($users as $user) {
            $Netim = new Netim();
            $ex = [
                'id' => $user->id
            ];
            $param = [
                'name' => $user->nick,
                'icon' => $user->avatar,
                'gender' => $user->gender,
                'ex' => json_encode($ex)
            ];
            $res = $Netim->updateInfo($user->imaccid, $param);
            if ($res) {
                \Cake\Log\Log::info('更新user 名片信息成功', 'cron');
            } else {
                \Cake\Log\Log::info('更新user 名片信息失败', 'cron');
                dblog('netim', '更新用户名片失败' . ',[accid:]' . $accid . '[id:]' . $user->id);
            }
        }
    }

    /**
     * 检查用户名片
     */
    public function checkUinfo() {
        set_time_limit(0);
        $redis = new \Redis();
        $redis_conf = \Cake\Core\Configure::read('Redis.default');
        $redis->connect($redis_conf['host'], $redis_conf['port']);
        $size = $redis->lSize(self::REDIS_WAIT_UPINFO_KEY);
        $records = $redis->lrange(self::REDIS_WAIT_UPINFO_KEY, 0, $size - 1);
        $UserTable = \Cake\ORM\TableRegistry::get('User');
        foreach ($records as $user_id) {
            $user = $UserTable->find()->select(['imaccid', 'imtoken', 'id', 'nick', 'avatar', 'gender'])
                    ->where(['id' => $user_id])
                    ->first();
            $Netim = new Netim();
            $ex = [
                'id' => $user->id
            ];
            $param = [
                'name' => $user->nick,
                'icon' => $user->avatar,
                'gender' => $user->gender,
                'ex' => json_encode($ex)
            ];
            try {
                $res = $Netim->updateInfo($user->imaccid, $param);
            } catch (\Exception $exc) {
                \Cake\Log\Log::error('更新user 名片信息成功', 'cron');
            }
            if ($res) {
                \Cake\Log\Log::info('更新user 名片信息成功', 'cron');
            } else {
                $redis->rPush(self::REDIS_WAIT_UPINFO_FAIL_KEY, $user_id); //缓冲进redis 队列
                \Cake\Log\Log::info('更新user 名片信息失败', 'cron');
                dblog('netim', '更新用户名片失败' . ',[accid:]' . $accid . '[id:]' . $user->id);
            }
        }
        $redis->ltrim(self::REDIS_WAIT_UPINFO_KEY, $size, -1);
    }

}
