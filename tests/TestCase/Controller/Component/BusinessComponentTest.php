<?php
namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\BusinessComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\BusinessComponent Test Case
 */
class BusinessComponentTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Controller\Component\BusinessComponent
     */
    public $Business;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->Business = new BusinessComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Business);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
