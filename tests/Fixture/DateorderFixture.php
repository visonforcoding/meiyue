<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DateorderFixture
 *
 */
class DateorderFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'lm_dateorder';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 255, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'consumer_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '消费者', 'precision' => null, 'autoIncrement' => null],
        'dater_name' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => '0', 'collate' => 'utf8_general_ci', 'comment' => '服务提供者姓名', 'precision' => null, 'fixed' => null],
        'consumer' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => '0', 'collate' => 'utf8_general_ci', 'comment' => '消费者姓名', 'precision' => null, 'fixed' => null],
        'date_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '对应约会', 'precision' => null, 'autoIncrement' => null],
        'dater_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '服务提供者', 'precision' => null, 'autoIncrement' => null],
        'user_skill_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '标签列表', 'precision' => null, 'autoIncrement' => null],
        'status' => ['type' => 'integer', 'length' => 4, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '订单状态码： 1#消费者未支付预约金 2#消费者超时未支付预约金，订单取消 3#消费者已支付预约金 4#消费者取消订单 5#受邀者拒绝约单 6#受邀者超时未响应，自动退单 7#受邀者确认约单 8#受邀者取消订单 9#消费者超时未付尾款 10#消费者已支付尾款 11#消费者退单 12#受邀者退单 13#受邀者确认到达 14#订单完成 15#已评价 16#订单失败', 'precision' => null, 'autoIncrement' => null],
        'update_time' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '订单更新时间', 'precision' => null],
        'operate_status' => ['type' => 'integer', 'length' => 4, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '用户操作状态码：0#无操作 1#消费者删除订单 2#被约者删除订单 3#双方删除订单', 'precision' => null, 'autoIncrement' => null],
        'site' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '约会地点', 'precision' => null, 'fixed' => null],
        'site_lat' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '约会地点纬度'],
        'site_lng' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '约会地点经度'],
        'price' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '价格'],
        'count' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '总金额'],
        'is_complain' => ['type' => 'integer', 'length' => 4, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '是否被投诉', 'precision' => null, 'autoIncrement' => null],
        'pre_pay' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '预约金'],
        'pre_precent' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '预约金占比'],
        'start_time' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '开始时间', 'precision' => null],
        'end_time' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '结束时间', 'precision' => null],
        'date_time' => ['type' => 'integer', 'length' => 4, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '约会总时间', 'precision' => null, 'autoIncrement' => null],
        'create_time' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '生成时间', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 1,
            'consumer_id' => 1,
            'dater_name' => 'Lorem ipsum dolor sit amet',
            'consumer' => 'Lorem ipsum dolor sit amet',
            'date_id' => 1,
            'dater_id' => 1,
            'user_skill_id' => 1,
            'status' => 1,
            'update_time' => '2016-11-11 14:29:16',
            'operate_status' => 1,
            'site' => 'Lorem ipsum dolor sit amet',
            'site_lat' => 1,
            'site_lng' => 1,
            'price' => 1,
            'count' => 1,
            'is_complain' => 1,
            'pre_pay' => 1,
            'pre_precent' => 1,
            'start_time' => '2016-11-11 14:29:16',
            'end_time' => '2016-11-11 14:29:16',
            'date_time' => 1,
            'create_time' => '2016-11-11 14:29:16'
        ],
    ];
}
