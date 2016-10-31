<?php
namespace App\Test\TestCase\View\Helper;

use App\View\Helper\LmHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * App\View\Helper\LmHelper Test Case
 */
class LmHelperTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\View\Helper\LmHelper
     */
    public $Lm;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $view = new View();
        $this->Lm = new LmHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Lm);

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
