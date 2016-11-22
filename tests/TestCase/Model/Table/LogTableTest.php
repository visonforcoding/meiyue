<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LogTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LogTable Test Case
 */
class LogTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\LogTable
     */
    public $Log;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.log'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Log') ? [] : ['className' => 'App\Model\Table\LogTable'];
        $this->Log = TableRegistry::get('Log', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Log);

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
}
