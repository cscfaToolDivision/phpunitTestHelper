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

use CSDT\PhpunitTestHelper\Objects\SetterCall;
use CSDT\PhpunitTestHelper\Exceptions\TypeException;
use CSDT\PhpunitTestHelper\Exceptions\RequiredArgumentException;
use CSDT\PhpunitTestHelper\Traits\ObjectTestTrait;

/**
 * Inject expression.
 *
 * The InjectExpression allow to test the injection of an argument,
 *
 * @category Expression
 * @package  PHPUnitTestHelper
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class InjectExpression
{
    use ObjectTestTrait;

    /**
     * Assert
     *
     * The assert instance to execute the tests.
     *
     * @var \PHPUnit_Framework_Assert
     */
    private $assert;

    /**
     * Parent call
     *
     * Store the parent call.
     *
     * @var SetterCall
     */
    private $parentCall;

    /**
     * Inject value
     *
     * The value expected to be injected
     * into the property.
     *
     * @var mixed
     */
    private $injectValue;

    /**
     * Inject process
     *
     * The injection process applicable to the value.
     *
     * @var Callable
     */
    private $injectProcess;

    /**
     * Inject target
     *
     * The property name where the injection
     * must be done.
     *
     * @var string
     */
    private $injectTarget;

    /**
     * Inject instance
     *
     * The instance where the injection
     * must be done.
     *
     * @var mixed
     */
    private $injectInstance;

    /**
     * Inject same
     *
     * Indicate that the injection result and the
     * given value must be equals or same.
     *
     * @var boolean
     */
    private $injectSame = false;

    /**
     * Constructor
     *
     * The default InjectExpression constructor.
     *
     * @param mixed                     $value   The expected injected value
     * @param SetterCall                $parent  The parent instance that execute the tests
     * @param \PHPUnit_Framework_Assert $assert  The assert instance to execute the tests
     * @param boolean                   $same    [optional] The equality testing method (same as true / equal by default as false)
     * @param callable                  $process [optional] A pre-process function for the given value
     *
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     * @return                                      $this
     */
    public function __construct($value, SetterCall $parent, \PHPUnit_Framework_Assert $assert, $same = false, callable $process = null)
    {
        $this->injectValue = $value;
        $this->parentCall = $parent;
        $this->assert = $assert;
        $this->injectProcess = $process;
        $this->injectSame = $same;

        return $this;
    }

    /**
     * Inject in
     *
     * This method define the property where the value is stored.
     *
     * @param string $property The property name
     * @param mixed  $instance The instance where the injection is done
     *
     * @throws TypeException If the given property is not a string
     *
     * @return SetterCall
     */
    public function injectIn($property, $instance = null)
    {
        if (!is_string($property)) {
            throw new TypeException('string', $property);
        }

        if (!is_null($instance) && !is_object($instance)) {
            throw new TypeException('object', $instance);
        }

        $this->injectTarget = $property;
        $this->injectInstance = $instance;

        return $this->parentCall;
    }

    /**
     * Resolve
     *
     * This method resolve and execute the injection.
     *
     * @param mixed  $instance         The instance to be tested
     * @param string $injectionMessage The failure message
     *
     * @throws RequiredArgumentException If the callMethod or instance are null
     *
     * @return void
     */
    public function resolve($instance, $injectionMessage = '')
    {
        $this->validatePreRequise();

        $expectedValue = $this->injectValue;
        if (!is_null($this->injectProcess)) {
            $function = $this->injectProcess;
            $expectedValue = $function($this->injectValue);
        }

        if (!is_null($this->injectInstance)) {
            $instance = $this->injectInstance;
        }

        $actualValue = $this->getPropertyValue($instance, $this->injectTarget);

        $method = 'assertEquals';
        if ($this->injectSame) {
            $method = 'assertSame';
        }
        $this->assert->$method($expectedValue, $actualValue, $injectionMessage);
    }

    /**
     * Validate pre-requise
     *
     * This method validate the method call pre-requise.
     *
     * @throws RequiredArgumentException If the callMethod or instance are null
     *
     * @return void
     */
    private function validatePreRequise()
    {
        if (is_null($this->injectTarget)) {
            throw new RequiredArgumentException(
                'The injectTarget is mandatory',
                500
            );
        }
    }
}
