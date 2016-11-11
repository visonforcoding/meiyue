<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DateorderTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DateorderTable Test Case
 */
class DateorderTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\DateorderTable
     */
    public $Dateorder;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.dateorder',
        'app.dates',
        'app.dater',
        'app.user_skills',
        'app.consumer'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Dateorder') ? [] : ['className' => 'App\Model\Table\DateorderTable'];
        $this->Dateorder = TableRegistry::get('Dateorder', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Dateorder);

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
