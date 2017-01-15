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
use CSDT\PhpunitTestHelper\Objects\ObjectCall;
use CSDT\PhpunitTestHelper\Exceptions\TypeException;
use CSDT\PhpunitTestHelper\Tests\Traits\Misc\TestObject;
use CSDT\PhpunitTestHelper\Exceptions\RequiredArgumentException;

/**
 * ObjectCall test
 *
 * This class is used to test the ObjectCall
 *
 * @category Test
 * @package  PHPUnitTestHelper
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ObjectCallTest extends \PHPUnit_Framework_TestCase
{
    use ObjectTestTrait;

    /**
     * Instance
     *
     * This property store the tested instance.
     *
     * @var ObjectCall
     */
    private $instance;

    /**
     * {@inheritDoc}
     *
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    protected function setUp()
    {
        $this->instance = new ObjectCall($this);
    }

    /**
     * Test call
     *
     * This method validate the call
     * method logic.
     *
     * @return void
     */
    public function testCall()
    {
        $method = 'method';
        $return = $this->instance->call($method);

        $this->assertEquals(
            $method,
            $this->getPropertyValue($this->instance, 'callMethod'),
            'The ObjectCall::call method is expected to set the given value into callMethod property'
        );

        $this->assertSame(
            $this->instance,
            $return,
            'The ObjectCall::call method is expected to return \$this'
        );

        try {
            $this->instance->call(new \stdClass());
            $this->fail(
                'The ObjectCall::call method must fail on non string argument'
            );
        } catch (TypeException $exception) {
            // success
        }
    }

    /**
     * Test on
     *
     * This method validate the on
     * method logic.
     *
     * @return void
     */
    public function testOnInstance()
    {
        $instance = new \stdClass();
        $return = $this->instance->onInstance($instance);

        $this->assertEquals(
            $instance,
            $this->getPropertyValue($this->instance, 'instance'),
            'The ObjectCall::on method is expected to set the given value into instance property'
        );

        $this->assertSame(
            $this->instance,
            $return,
            'The ObjectCall::on method is expected to return \$this'
        );

        try {
            $this->instance->onInstance('string');
            $this->fail(
                'The ObjectCall::on method must fail on non object argument'
            );
        } catch (TypeException $exception) {
            // success
        }
    }

    /**
     * Test with
     *
     * This method validate the with
     * method logic.
     *
     * @return void
     */
    public function testWith()
    {
        $arguments = array(1, 2, 3);
        $return = $this->instance->with($arguments);

        $this->assertEquals(
            $arguments,
            $this->getPropertyValue($this->instance, 'arguments'),
            'The ObjectCall::with method is expected to set the given value into arguments property'
        );

        $this->assertSame(
            $this->instance,
            $return,
            'The ObjectCall::with method is expected to return \$this'
        );
    }

    /**
     * Test mustReturn
     *
     * This method validate the mustReturn
     * method logic.
     *
     * @return void
     */
    public function testMustReturn()
    {
        $result = 'result';
        $return = $this->instance->mustReturn($result, true);

        $this->assertEquals(
            $result,
            $this->getPropertyValue($this->instance, 'result'),
            'The ObjectCall::mustReturn method is expected to set the first argument value into result property'
        );

        $this->assertEquals(
            true,
            $this->getPropertyValue($this->instance, 'same'),
            'The ObjectCall::mustReturn method is expected to set the second argument value into result property'
        );

        $return = $this->instance->mustReturn(null);

        $this->assertEquals(
            null,
            $this->getPropertyValue($this->instance, 'result'),
            'The ObjectCall::mustReturn method is expected to set the first argument value into result property'
        );

        $this->assertEquals(
            false,
            $this->getPropertyValue($this->instance, 'same'),
            'The ObjectCall::mustReturn method is expected to set the second argument value into result property'
        );

        $this->assertSame(
            $this->instance,
            $return,
            'The ObjectCall::with method is expected to return \$this'
        );
    }

    /**
     * Test resolve
     *
     * This method validate the resolve
     * method logic.
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
            ->resolve();

        $this->instance->call('getPrivate')
            ->onInstance($instance)
            ->mustReturn(null)
            ->resolve();
    }

    /**
     * Test call prerequise
     *
     * This method validate the prerequise failure
     * for call method.
     *
     * @return void
     */
    public function testCallPrerequise()
    {
        try {
            $this->instance->onInstance(new \stdClass())
                ->mustReturn(null)
                ->resolve();
            $this->fail('Call resolve without callMethod must fail');
        } catch (RequiredArgumentException $exception) {
            // success
        }
    }

    /**
     * Test on prerequise
     *
     * This method validate the prerequise failure
     * for on method.
     *
     * @return void
     */
    public function testOnPrerequise()
    {
        try {
            $this->instance->call('getProperty')
                ->mustReturn(null)
                ->resolve();
            $this->fail('Call resolve without instance must fail');
        } catch (RequiredArgumentException $exception) {
            // success
        }
    }

    /**
     * Test unexisting method
     *
     * This method validate the failure
     * of the resolving in case of unexisting
     * method call.
     *
     * @return void
     */
    public function testUnexistingMethod()
    {
        try {
            $this->instance->call('getUndefined')
                ->onInstance(new TestObject())
                ->mustReturn(null)
                ->resolve();
            $this->fail('Call resolve without instance must fail');
        } catch (\RuntimeException $exception) {
            // success
        }
    }
}
