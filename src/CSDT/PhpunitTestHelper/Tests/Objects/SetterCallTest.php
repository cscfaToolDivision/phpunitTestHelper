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
namespace CSDT\PhpunitTestHelper\Tests\Objects;

use CSDT\PhpunitTestHelper\Traits\ObjectTestTrait;
use CSDT\PhpunitTestHelper\Objects\SetterCall;
use CSDT\PhpunitTestHelper\Tests\Traits\Misc\TestObject;
use CSDT\PhpunitTestHelper\Expressions\InjectExpression;

/**
 * SetterCall test
 *
 * This class is used to test the SetterCall
 *
 * @category Test
 * @package  PHPUnitTestHelper
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class SetterCallTest extends \PHPUnit_Framework_TestCase
{
    use ObjectTestTrait;

    /**
     * Instance
     *
     * This property store the tested instance.
     *
     * @var SetterCall
     */
    private $instance;

    /**
     * {@inheritDoc}
     *
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    protected function setUp()
    {
        $this->instance = new SetterCall($this);
    }

    /**
     * InjectProvider
     *
     * This method is used to provide the test values
     * of the testInject method.
     *
     * @return array
     */
    public function injectProvider()
    {
        return array(
            array('value', false, null),
            array('value', true, null),
            array('value', true, array($this, 'injectProvider')),
        );
    }

    /**
     * Test inject
     *
     * This method test the inject method logic.
     *
     * @param mixed    $value   The injected value
     * @param boolean  $same    The equality validation
     * @param Callable $process The given value process
     *
     * @dataProvider injectProvider
     * @return       void
     */
    public function testInject($value, $same = null, $process = null)
    {
        $this->resolveInjectCall($value, $same, $process);

        $injections = $this->getPropertyValue($this->instance, 'injections');

        $this->assertCount(
            1,
            $injections,
            'The SetterCall::inject method is expected to store a InjectionExpression'
        );

        $injection = $injections[0];

        $this->assertInstanceOf(
            InjectExpression::class,
            $injection,
            'The SetterCall::inject method is expected to store a InjectionExpression instance'
        );

        $this->assertEquals(
            $value,
            $this->getPropertyValue($injection, 'injectValue'),
            'Inject method is expected to inject the given value in injectValue property'
        );

        $this->assertEquals(
            $process,
            $this->getPropertyValue($injection, 'injectProcess'),
            'Inject method is expected to inject the given process in injectProcess property'
        );

        $this->assertEquals(
            $same,
            $this->getPropertyValue($injection, 'injectSame'),
            'Inject method is expected to inject the given equality validation in injectSame property'
        );
    }

    /**
     * Test resolve
     *
     * This method test the resolve method logic.
     *
     * @return void
     */
    public function testResolve()
    {
        $instance = new TestObject();

        $this->instance->call('setProperty')
            ->onInstance($instance)
            ->with(array('test'))
            ->mustReturn($instance, true)
            ->inject('test')
            ->injectIn('property')
            ->resolve();

        $this->instance->call('setPrivate')
            ->onInstance($instance)
            ->with(array('test'))
            ->mustReturn($instance, true)
            ->inject(
                'test',
                true,
                function ($value) {
                    return $value;
                }
            )
            ->injectIn('private')
            ->resolve();


        $this->instance->call('setProtected')
            ->onInstance($instance)
            ->with(array('test'))
            ->mustReturn($instance, true)
            ->inject('test')
            ->injectIn('property')
            ->inject('test')
            ->injectIn('private')
            ->inject('test')
            ->injectIn('protected')
            ->resolve();
    }

    /**
     * Resolve injectCall
     *
     * This method resolve the inject call method
     * to use.
     *
     * @param mixed    $value   The injected value
     * @param boolean  $same    The equality validation
     * @param Callable $process The given value process
     *
     * @return void
     */
    private function resolveInjectCall($value, $same, $process)
    {
        if ($same === false && $process === null) {
            $this->instance->inject($value);

            return;
        }

        if ($process === null) {
            $this->instance->inject($value, $same);

            return;
        }

        $this->instance->inject($value, $same, $process);
    }
}
