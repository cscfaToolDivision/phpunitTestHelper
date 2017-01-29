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

use CSDT\PhpunitTestHelper\Expressions\ThrowExpression;

/**
 * ThrowExpression test
 *
 * This class is used to test the ThrowExpression
 *
 * @category Test
 * @package  PHPUnitTestHelper
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ThrowExpressionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test simple
     *
     * Validate the main feature of ThrowExpression
     *
     * @return void
     */
    public function testSimple()
    {
        $expression = new ThrowExpression($this);

        $exception = new \Exception();

        $this->assertNull($expression->resolve($exception));
    }

    /**
     * Test class
     *
     * Validate the class feature of ThrowExpression
     *
     * @return void
     */
    public function testClass()
    {
        $expression = new ThrowExpression($this, \Exception::class);

        $exception = new \Exception();

        $this->assertNull($expression->resolve($exception));
    }

    /**
     * Test code
     *
     * Validate the code feature of ThrowExpression
     *
     * @return void
     */
    public function testCode()
    {
        $expression = new ThrowExpression($this, \Exception::class, 500);

        $exception = new \Exception('', 500);

        $this->assertNull($expression->resolve($exception));
    }

    /**
     * Test message
     *
     * Validate the message feature of ThrowExpression
     *
     * @return void
     */
    public function testMessage()
    {
        $expression = new ThrowExpression($this, \Exception::class, 500, 'test');

        $exception = new \Exception('test', 500);

        $this->assertNull($expression->resolve($exception));
    }
}
