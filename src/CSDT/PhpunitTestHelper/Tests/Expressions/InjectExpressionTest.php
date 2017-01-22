<?php
/**
 * This file is part of the Hephaistos project management API.
 *
 * As each files provides by the CSCFA, this file is licensed
 * under the MIT license.
 *
 * PHP version 5.6
 *
 * @category Test
 * @package  PHPUnitTestHelper
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace CSDT\PhpunitTestHelper\Tests\Expressions;

use CSDT\PhpunitTestHelper\Expressions\InjectExpression;
use CSDT\PhpunitTestHelper\Traits\ObjectTestTrait;
use CSDT\PhpunitTestHelper\Objects\SetterCall;
use CSDT\PhpunitTestHelper\Tests\Traits\Misc\TestObject;
use CSDT\PhpunitTestHelper\Exceptions\TypeException;
use CSDT\PhpunitTestHelper\Tests\Traits\Misc\FacadeObject;

/**
 * InjectExpression test
 *
 * This class is used to test the InjectExpression
 *
 * @category Test
 * @package  PHPUnitTestHelper
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class InjectExpressionTest extends \PHPUnit_Framework_TestCase
{
    use ObjectTestTrait;

    /**
     * Test constructor
     *
     * This method validate the InjectExpression constructor logic.
     *
     * @return void
     */
    public function testConstructor()
    {
        $parent = new SetterCall($this);

        $value = 'value';
        $parentProperty = 'parentCall';
        $valueProperty = 'injectValue';
        $assertProperty = 'assert';
        $processProperty = 'injectProcess';
        $sameProperty = 'injectSame';

        $instance = new InjectExpression($value, $parent, $this);

        $this->assertEquals(
            $value,
            $this->getPropertyValue($instance, $valueProperty),
            'The InjectExpression constructor is expected to inject the value in \'injectValue\' property'
        );

        $this->assertSame(
            $parent,
            $this->getPropertyValue($instance, $parentProperty),
            'The InjectExpression constructor is expected to inject the parent in \'parentCall\' property'
        );

        $this->assertSame(
            $this,
            $this->getPropertyValue($instance, $assertProperty),
            'The InjectExpression constructor is expected to inject the assert in \'assert\' property'
        );

        $this->assertNull(
            $this->getPropertyValue($instance, $processProperty),
            'The InjectExpression constructor is expected to set the \'injectProcess\' property to null'
        );

        $this->assertFalse(
            $this->getPropertyValue($instance, $sameProperty),
            'The InjectExpression constructor is expected to set the \'injectSame\' property to false'
        );

        $process = function () {
        };
        $instance = new InjectExpression($value, $parent, $this, true, $process);

        $this->assertEquals(
            $value,
            $this->getPropertyValue($instance, $valueProperty),
            'The InjectExpression constructor is expected to inject the value in \'injectValue\' property'
        );

        $this->assertSame(
            $parent,
            $this->getPropertyValue($instance, $parentProperty),
            'The InjectExpression constructor is expected to inject the parent in \'parentCall\' property'
        );

        $this->assertSame(
            $this,
            $this->getPropertyValue($instance, $assertProperty),
            'The InjectExpression constructor is expected to inject the assert in \'assert\' property'
        );

        $this->assertSame(
            $process,
            $this->getPropertyValue($instance, $processProperty),
            'The InjectExpression constructor is expected to inject the process in \'injectProcess\' property'
        );

        $this->assertTrue(
            $this->getPropertyValue($instance, $sameProperty),
            'The InjectExpression constructor is expected to set the \'injectSame\' property to true'
        );
    }

    /**
     * Test injectIn
     *
     * This method test the in method logic.
     *
     * @expectedException CSDT\PhpunitTestHelper\Exceptions\TypeException
     * @return            void
     */
    public function testInjectIn()
    {
        $parent = new SetterCall($this);
        $instance = new InjectExpression('value', $parent, $this);

        $property = 'property';
        $return = $instance->injectIn($property);

        $this->assertEquals(
            $property,
            $this->getPropertyValue($instance, 'injectTarget'),
            'The InjectExpression::in method is expected to set the given value into injectTarget property'
        );

        $this->assertSame(
            $parent,
            $return,
            'The InjectExpression::in method is expected to return it\'s parent'
        );

        $return = $instance->injectIn($property, $instance);

        $this->assertSame(
            $instance,
            $this->getPropertyValue($instance, 'injectInstance'),
            'The InjectExpression::in method is expected to set the given instance into injectInstance property'
        );

        try {
            $instance->injectIn($property, 'noObject');
            $this->fail(
                'The InjectExpression::in method is expected to fail if the given instance is not object'
            );
        } catch (TypeException $exception) {
        }

        $instance->injectIn(new \stdClass());
    }

    /**
     * Test resolve
     *
     * This method test the resolve method logic.
     *
     * @expectedException CSDT\PhpunitTestHelper\Exceptions\RequiredArgumentException
     * @return            void
     */
    public function testResolve()
    {
        $instance = new TestObject();

        $value = 'property';
        $instance->setProperty($value);

        $property = 'property';

        $parent = new SetterCall($this);

        $expression = new InjectExpression($value, $parent, $this);
        $expression->injectIn($property);

        try {
            $expression->resolve($instance);
        } catch (\Exception $exception) {
            $this->fail('The InjectExpression::resolve is not expected to throw exception');
        }

        $expression = new InjectExpression(
            $value,
            $parent,
            $this,
            true,
            function ($value) {
                return $value;
            }
        );
        $expression->injectIn($property);

        try {
            $expression->resolve($instance);
        } catch (\Exception $exception) {
            $this->fail('The InjectExpression::resolve is not expected to throw exception');
        }

        $expression = new InjectExpression('test', $parent, $this);
        $expression->injectIn($property);

        try {
            $expression->resolve($instance);
            $this->fail('The InjectExpression::resolve is expected to throw exception');
        } catch (\Exception $exception) {
        }

        $parent = new SetterCall($this);
        $parent->call('setPrivate')
            ->with(array('test'))
            ->onInstance($instance)
            ->mustReturn($instance);

        $expression = new InjectExpression($value, $parent, $this);

        $this->setPropertyValue($parent, 'injections', array($expression));

        try {
            $expression->injectIn($property, $instance)
                ->resolve();
        } catch (\Exception $exception) {
            $this->fail('The InjectExpression::resolve is not expected to throw exception');
        }

        $expression = new InjectExpression($value, $parent, $this);
        $expression->resolve($instance);
    }
}
