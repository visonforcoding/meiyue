<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UserFixture
 *
 */
class UserFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'lm_user';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '用户表', 'autoIncrement' => true, 'precision' => null],
        'phone' => ['type' => 'string', 'length' => 20, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '手机号', 'precision' => null, 'fixed' => null],
        'pwd' => ['type' => 'string', 'length' => 120, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '密码', 'precision' => null, 'fixed' => null],
        'user_token' => ['type' => 'string', 'length' => 20, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '用户标志', 'precision' => null, 'fixed' => null],
        'union_id' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'wx_unionid', 'precision' => null, 'fixed' => null],
        'wx_openid' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => '', 'collate' => 'utf8_general_ci', 'comment' => '微信的openid', 'precision' => null, 'fixed' => null],
        'app_wx_openid' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => '', 'collate' => 'utf8_general_ci', 'comment' => 'app端的微信id', 'precision' => null, 'fixed' => null],
        'truename' => ['type' => 'string', 'length' => 20, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '姓名', 'precision' => null, 'fixed' => null],
        'level' => ['type' => 'string', 'length' => 20, 'null' => false, 'default' => '1', 'collate' => 'utf8_general_ci', 'comment' => '等级,1:普通2:专家', 'precision' => null, 'fixed' => null],
        'position' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => '', 'collate' => 'utf8_general_ci', 'comment' => '职位', 'precision' => null, 'fixed' => null],
        'email' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => '', 'collate' => 'utf8_general_ci', 'comment' => '邮箱', 'precision' => null, 'fixed' => null],
        'gender' => ['type' => 'integer', 'length' => 4, 'unsigned' => false, 'null' => false, 'default' => '1', 'comment' => '1,男，2女', 'precision' => null, 'autoIncrement' => null],
        'city' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => '', 'collate' => 'utf8_general_ci', 'comment' => '常驻城市', 'precision' => null, 'fixed' => null],
        'avatar' => ['type' => 'string', 'length' => 250, 'null' => true, 'default' => '', 'collate' => 'utf8_general_ci', 'comment' => '头像', 'precision' => null, 'fixed' => null],
        'money' => ['type' => 'decimal', 'length' => 10, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '0.00', 'comment' => '账户余额'],
        'status' => ['type' => 'integer', 'length' => 4, 'unsigned' => false, 'null' => false, 'default' => '1', 'comment' => '实名认证状态：1.实名待审核2审核通过0审核不通过', 'precision' => null, 'autoIncrement' => null],
        'enabled' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '1', 'comment' => '账号状态 ：1.可用0禁用(控制登录)', 'precision' => null],
        'is_del' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '0', 'comment' => '是否假删除：1,是0否', 'precision' => null],
        'device' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => 'app', 'collate' => 'utf8_general_ci', 'comment' => '注册设备', 'precision' => null, 'fixed' => null],
        'create_time' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '创建时间', 'precision' => null],
        'update_time' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '修改时间', 'precision' => null],
        'guid' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => '', 'collate' => 'utf8_general_ci', 'comment' => '唯一码（用于扫码登录）', 'precision' => null, 'fixed' => null],
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
            'phone' => 'Lorem ipsum dolor ',
            'pwd' => 'Lorem ipsum dolor sit amet',
            'user_token' => 'Lorem ipsum dolor ',
            'union_id' => 'Lorem ipsum dolor sit amet',
            'wx_openid' => 'Lorem ipsum dolor sit amet',
            'app_wx_openid' => 'Lorem ipsum dolor sit amet',
            'truename' => 'Lorem ipsum dolor ',
            'level' => 'Lorem ipsum dolor ',
            'position' => 'Lorem ipsum dolor sit amet',
            'email' => 'Lorem ipsum dolor sit amet',
            'gender' => 1,
            'city' => 'Lorem ipsum dolor sit amet',
            'avatar' => 'Lorem ipsum dolor sit amet',
            'money' => 1.5,
            'status' => 1,
            'enabled' => 1,
            'is_del' => 1,
            'device' => 'Lorem ipsum dolor sit amet',
            'create_time' => '2016-10-18 01:53:58',
            'update_time' => '2016-10-18 01:53:58',
            'guid' => 'Lorem ipsum dolor sit amet'
        ],
    ];
}
