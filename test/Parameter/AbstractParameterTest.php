<?php

declare(strict_types=1);

/**
 * @see       https://github.com/niceshops/nice-beans for the canonical source repository
 * @license   https://github.com/niceshops/nice-beans/blob/master/LICENSE BSD 3-Clause License
 */

namespace ParsTest\Helper\Parameter;

use Pars\Helper\Parameter\AbstractParameter;
use Pars\Helper\Parameter\InvalidParameterException;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * Class DefaultTestCaseTest
 * @package Pars\Bean
 */
class AbstractParameterTest extends \Pars\Pattern\PHPUnit\DefaultTestCase
{


    /**
     * @var AbstractParameter|MockObject
     */
    protected $object;


    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     */
    protected function setUp(): void
    {
        $this->object = $this->getMockBuilder(AbstractParameter::class)->disableOriginalConstructor()->getMockForAbstractClass();
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
        $this->assertTrue(class_exists(AbstractParameter::class), "Class Exists");
        $this->assertTrue(is_a($this->object, AbstractParameter::class), "Mock Object is set");
    }

    /**
     * @group unit
     * @small
     * @covers \Pars\Helper\Parameter\AbstractParameter::fromString
     * @throws \Pars\Pattern\Exception\AttributeExistsException
     * @throws \Pars\Pattern\Exception\AttributeLockException
     * @throws \Pars\Pattern\Exception\AttributeNotFoundException
     */
    public function testFromString()
    {
        $this->object->fromString("foo=bar;bar=baz");
        $this->assertEquals('bar', $this->object->getAttribute('foo'));
        $this->assertEquals('baz', $this->object->getAttribute('bar'));
    }

    public function dataProvider_invalidParameterString()
    {
        yield ['invalid'];
        yield [''];
        yield [' '];
        yield ['invalid='];
        yield ['invalid;'];
        yield ['=invalid'];
    }

    /**
     * @dataProvider dataProvider_invalidParameterString
     * @group unit
     * @small
     * @covers       \Pars\Helper\Parameter\AbstractParameter::fromString
     * @throws \Pars\Pattern\Exception\AttributeExistsException
     * @throws \Pars\Pattern\Exception\AttributeLockException
     */
    public function testFromString_InvalidString($parameter)
    {
        $this->expectException(InvalidParameterException::class);
        $this->object->fromString($parameter);
    }


    /**
     * @group unit
     * @small
     * @covers \Pars\Helper\Parameter\AbstractParameter::fromArray
     */
    public function testFromArray()
    {
        $this->object->fromArray([
            'key' => 'value',
            'key2' => 'value2'
        ]);
        $this->assertEquals('value', $this->object->getAttribute('key'));
        $this->assertEquals('value2', $this->object->getAttribute('key2'));
    }

    /**
     * @group unit
     * @small
     * @covers \Pars\Helper\Parameter\AbstractParameter::fromData
     */
    public function testFromData()
    {
        $this->object->fromData('bla=blub');
        $this->object->fromData(['a' => 'b']);
        $this->assertEquals('blub', $this->object->getAttribute('bla'));
        $this->assertEquals('b', $this->object->getAttribute('a'));
    }

    /**
     * @group unit
     * @small
     * @covers \Pars\Helper\Parameter\AbstractParameter::toString
     */
    public function testToString()
    {
        $this->object = $this->getMockBuilder(AbstractParameter::class)->disableOriginalConstructor()->getMockForAbstractClass();
        $this->object->fromData('bla=blub');
        $this->object->fromData(['a' => 'b']);
        $this->assertEquals('bla=blub;a=b', $this->object->toString());
    }


    /**
     * @group unit
     * @small
     * @covers \Pars\Helper\Parameter\AbstractParameter::hasData
     */
    public function testHasData()
    {
        $this->object = $this->getMockBuilder(AbstractParameter::class)->disableOriginalConstructor()->getMockForAbstractClass();
        $this->assertFalse($this->object->hasData());
        $this->object->fromData('bla=blub');
        $this->assertTrue($this->object->hasData());
    }
}
