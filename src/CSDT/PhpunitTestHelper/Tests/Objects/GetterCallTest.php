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

use CSDT\PhpunitTestHelper\Objects\GetterCall;
use CSDT\PhpunitTestHelper\Traits\ObjectTestTrait;
use CSDT\PhpunitTestHelper\Tests\Traits\Misc\TestObject;
use CSDT\PhpunitTestHelper\Exceptions\RequiredArgumentException;

/**
 * GetterCall test
 *
 * This class is used to test the GetterCall
 *
 * @category Test
 * @package  PHPUnitTestHelper
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class GetterCallTest extends \PHPUnit_Framework_TestCase
{
    use ObjectTestTrait;

    /**
     * Instance
     *
     * This property store the tested instance.
     *
     * @var GetterCall
     */
    private $instance;

    /**
     * {@inheritDoc}
     *
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    protected function setUp()
    {
        $this->instance = new GetterCall($this);
    }

    /**
     * Test from
     *
     * This method test the from method logic.
     *
     * @expectedException CSDT\PhpunitTestHelper\Exceptions\TypeException
     * @return            void
     */
    public function testFrom()
    {
        $property = 'property';
        $return = $this->instance->from($property);

        $this->assertEquals(
            $property,
            $this->getPropertyValue($this->instance, 'fromProperty'),
            'The GetterCall::from method is expected to set the given value into fromProperty property'
        );

        $this->assertSame(
            $this->instance,
            $return,
            'The GetterCall::from method is expected to return \$this'
        );

        $this->instance->from(new \stdClass());
    }

    /**
     * Test thatContain
     *
     * This method test the thatContain method logic.
     *
     * @return void
     */
    public function testThatContain()
    {
        $contain = 'value';
        $return = $this->instance->thatContain($contain);

        $this->assertEquals(
            $contain,
            $this->getPropertyValue($this->instance, 'thatContain'),
            'The GetterCall::thatContain method is expected to set the given value into thatContain property'
        );

        $this->assertSame(
            $this->instance,
            $return,
            'The GetterCall::thatContain method is expected to return \$this'
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
        $contain = 'value';
        $containSame = new \stdClass();
        $property = 'property';
        $instance = new TestObject();

        $this->instance->call('getProperty')
            ->onInstance($instance)
            ->mustReturn($contain)
            ->from($property)
            ->thatContain($contain)
            ->resolve();

        $this->instance->call('getProperty')
            ->onInstance($instance)
            ->mustReturn($containSame, true)
            ->from($property)
            ->thatContain($containSame)
            ->resolve();

        try {
            $this->instance = new GetterCall($this);

            $this->instance->call('getProperty')
                ->onInstance($instance)
                ->mustReturn($contain, true)
                ->from($property)
                ->resolve();

            $this->fail('Call resolve without thatContain must fail');
        } catch (RequiredArgumentException $e) {
            // success
        }

        try {
            $this->instance = new GetterCall($this);

            $this->instance->call('getProperty')
                ->onInstance($instance)
                ->mustReturn($contain, true)
                ->thatContain($contain)
                ->resolve();

            $this->fail('Call resolve without from must fail');
        } catch (RequiredArgumentException $e) {
            // success
        }
    }
}
