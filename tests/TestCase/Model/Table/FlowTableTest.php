<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FlowTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FlowTable Test Case
 */
class FlowTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\FlowTable
     */
    public $Flow;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.flow',
        'app.users',
        'app.buyers',
        'app.relates'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Flow') ? [] : ['className' => 'App\Model\Table\FlowTable'];
        $this->Flow = TableRegistry::get('Flow', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Flow);

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
