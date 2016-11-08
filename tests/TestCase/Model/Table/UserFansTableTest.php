<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UserFansTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UserFansTable Test Case
 */
class UserFansTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\UserFansTable
     */
    public $UserFans;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.user_fans',
        'app.users',
        'app.followings'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('UserFans') ? [] : ['className' => 'App\Model\Table\UserFansTable'];
        $this->UserFans = TableRegistry::get('UserFans', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UserFans);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
