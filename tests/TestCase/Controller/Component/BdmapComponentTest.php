<?php
namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\BdmapComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\BdmapComponent Test Case
 */
class BdmapComponentTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Controller\Component\BdmapComponent
     */
    public $Bdmap;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->Bdmap = new BdmapComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Bdmap);

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
