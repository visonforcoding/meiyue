<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UserAuthTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UserAuthTable Test Case
 */
class UserAuthTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\UserAuthTable
     */
    public $UserAuth;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.user_auth',
        'app.users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('UserAuth') ? [] : ['className' => 'App\Model\Table\UserAuthTable'];
        $this->UserAuth = TableRegistry::get('UserAuth', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UserAuth);

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
