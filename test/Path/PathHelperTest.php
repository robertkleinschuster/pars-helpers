<?php

declare(strict_types=1);

/**
 * @see       https://github.com/niceshops/nice-beans for the canonical source repository
 * @license   https://github.com/niceshops/nice-beans/blob/master/LICENSE BSD 3-Clause License
 */

namespace ParsTest\Helper\Path;

use Pars\Helper\Path\PathHelper;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * Class DefaultTestCaseTest
 * @package Pars\Bean
 */
class PathHelperTest extends \Pars\Pattern\PHPUnit\DefaultTestCase
{


    /**
     * @var PathHelper|MockObject
     */
    protected $object;


    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     */
    protected function setUp(): void
    {
        $this->object = $this->getMockBuilder(PathHelper::class)->disableOriginalConstructor()->getMockForAbstractClass();
    }


    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown(): void
    {
    }


    /**
     * @group integration
     * @small
     */
    public function testTestClassExists()
    {
        $this->assertTrue(class_exists(PathHelper::class), "Class Exists");
        $this->assertTrue(is_a($this->object, PathHelper::class), "Mock Object is set");
    }
}
