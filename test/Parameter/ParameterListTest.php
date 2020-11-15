<?php

declare(strict_types=1);

/**
 * @see       https://github.com/niceshops/nice-beans for the canonical source repository
 * @license   https://github.com/niceshops/nice-beans/blob/master/LICENSE BSD 3-Clause License
 */

namespace ParsTest\Helper\Parameter;

use Pars\Helper\Parameter\AbstractParameter;
use Pars\Helper\Parameter\ParameterList;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * Class DefaultTestCaseTest
 * @package Niceshops\Bean
 */
class ParameterListTest extends \Niceshops\Core\PHPUnit\DefaultTestCase
{


    /**
     * @var ParameterList|MockObject
     */
    protected $object;


    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     */
    protected function setUp(): void
    {
        $this->object = new ParameterList();
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
        $this->assertTrue(class_exists(ParameterList::class), "Class Exists");
        $this->assertTrue(is_a($this->object, ParameterList::class), "Mock Object is set");
    }

    /**
     * @group integration
     * @small
     * @covers \Pars\Helper\Parameter\ParameterList
     */
    public function testList()
    {

        /**
         * @var $paremter AbstractParameter
         */
        $paremter = new class () extends AbstractParameter {
            public static function getParameterKey(): string
            {
                return 'test';
            }
        };
        $this->object->set($paremter);
        $paremter = clone $paremter;
        $paremter->fromData('foo=bar;bla=blub');
        $this->object->set($paremter);
        /**
         * @var $paremter AbstractParameter
         */
        $paremter = new class () extends AbstractParameter {
            public static function getParameterKey(): string
            {
                return 'test2';
            }
        };
        $paremter->fromData('bar=baz');
        $this->object->set($paremter);
        $this->assertEquals(['test' => 'foo=bar;bla=blub', 'test2' => 'bar=baz'], $this->object->toArray());
        $this->assertEquals('foo=bar;bla=blub', $this->object->get('test')->toString());
        $this->assertEquals('bar=baz', $this->object->get('test2')->toString());
        $this->object->unset('test2');
        $this->assertEquals(['test' => 'foo=bar;bla=blub'], $this->object->toArray());
    }
}
