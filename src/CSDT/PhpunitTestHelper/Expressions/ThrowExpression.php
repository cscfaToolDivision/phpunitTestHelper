<?php
/**
 * This file is part of the Hephaistos project management API.
 *
 * As each files provides by the CSCFA, this file is licensed
 * under the MIT license.
 *
 * PHP version 5.6
 *
 * @category Expression
 * @package  PHPUnitTestHelper
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace CSDT\PhpunitTestHelper\Expressions;

/**
 * Throw expression.
 *
 * The ThrowExpression allow to test the failure of a call,
 *
 * @category Expression
 * @package  PHPUnitTestHelper
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ThrowExpression
{

    /**
     * Assert
     *
     * The assert instance to execute the tests.
     *
     * @var \PHPUnit_Framework_Assert
     */
    private $assert;

    /**
     * Exception class
     *
     * The exception class name expected to be throwed.
     *
     * @var string
     */
    private $exceptionClass;

    /**
     * Code
     *
     * The exception code expected.
     *
     * @var integer
     */
    private $code;

    /**
     * Message
     *
     * The exception expected message.
     *
     * @var string
     */
    private $message;

    /**
     * Constructor
     *
     * The default ThrowException constructor
     *
     * @param \PHPUnit_Framework_Assert $assert         The assert instance to execute the tests
     * @param string                    $exceptionClass The expected exception class
     * @param string                    $code           The expected exception code
     * @param string                    $message        The expected exception message
     *
     * @return void
     */
    public function __construct(
        \PHPUnit_Framework_Assert $assert,
        $exceptionClass = null,
        $code = null,
        $message = null
    ) {
        $this->assert = $assert;
        $this->exceptionClass = $exceptionClass;
        $this->code = $code;
        $this->message = $message;
    }

    /**
     * Resolve
     *
     * This method resolve and execute the exception test.
     *
     * @param mixed $exception The exception to be tested
     *
     * @return void
     */
    public function resolve(\Exception $exception)
    {
        if ($this->exceptionClass !== null) {
            $this->assert->assertInstanceOf($this->exceptionClass, $exception);
        }

        if ($this->code !== null) {
            $this->assert->assertEquals($this->code, $exception->getCode());
        }

        if ($this->message !== null) {
            $this->assert->assertEquals($this->message, $exception->getMessage());
        }
    }
}
