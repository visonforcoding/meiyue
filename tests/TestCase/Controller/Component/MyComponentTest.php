<?php
namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\MyComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\MyComponent Test Case
 */
class MyComponentTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Controller\Component\MyComponent
     */
    public $My;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->My = new MyComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->My);

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
