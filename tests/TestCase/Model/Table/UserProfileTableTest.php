<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UserProfileTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UserProfileTable Test Case
 */
class UserProfileTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\UserProfileTable
     */
    public $UserProfile;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.user_profile',
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
        $config = TableRegistry::exists('UserProfile') ? [] : ['className' => 'App\Model\Table\UserProfileTable'];
        $this->UserProfile = TableRegistry::get('UserProfile', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UserProfile);

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
