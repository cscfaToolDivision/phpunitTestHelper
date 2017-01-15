<?php
/**
 * This file is part of the Hephaistos project management API.
 *
 * As each files provides by the CSCFA, this file is licensed
 * under the MIT license.
 *
 * PHP version 5.6
 *
 * @category ObjectTesting
 * @package  PHPUnitTestHelper
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace CSDT\PhpunitTestHelper\Objects;

use CSDT\PhpunitTestHelper\Objects\ObjectCall;
use CSDT\PhpunitTestHelper\Traits\ObjectTestTrait;
use CSDT\PhpunitTestHelper\Exceptions\RequiredArgumentException;
use CSDT\PhpunitTestHelper\Exceptions\TypeException;

/**
 * Setter call.
 *
 * The SetterCall allow to test a setter method call with argument,
 * return value and property setting.
 *
 * @category ObjectTesting
 * @package  PHPUnitTestHelper
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class SetterCall extends ObjectCall
{

    use ObjectTestTrait;

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
     * Inject same
     *
     * Indicate that the injection result and the
     * given value must be equals or same.
     *
     * @var boolean
     */
    private $injectSame = false;

    /**
     * Inject
     *
     * This method allow to provide a value that is expected to be injected into
     * a property of the instance. The given boolean, as second argument tell
     * that the equality must be tested by same (as true) or equal (as false).
     * Finally, a Callable can be given as third argument to pre-process the
     * value before equality validation.
     *
     * @param mixed    $value   The expected injected value
     * @param boolean  $same    [optional] The equality testing method (same as true / equal by default as false)
     * @param callable $process [optional] A pre-process function for the given value
     *
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     * @return $this
     */
    public function inject($value, $same = false, callable $process = null)
    {
        $this->injectValue = $value;
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
     *
     * @throws TypeException If the given property is not a string
     *
     * @return $this
     */
    public function injectIn($property)
    {
        if (!is_string($property)) {
            throw new TypeException('string', $property);
        }

        $this->injectTarget = $property;

        return $this;
    }

    /**
     * {@inheritDoc}
     *
     * @see \CSDT\PhpunitTestHelper\Objects\ObjectCall::resolve()
     */
    public function resolve($message = '', $injectionMessage = '')
    {
        parent::resolve($message);

        $expectedValue = $this->injectValue;
        if (!is_null($this->injectProcess)) {
            $function = $this->injectProcess;
            $expectedValue = $function($this->injectValue);
        }

        $actualValue = $this->getPropertyValue($this->instance, $this->injectTarget);

        $method = 'assertEquals';
        if ($this->injectSame) {
            $method = 'assertSame';
        }
        $this->assert->$method($expectedValue, $actualValue, $injectionMessage);
    }

    /**
     * {@inheritDoc}
     *
     * @see \CSDT\PhpunitTestHelper\Objects\ObjectCall::validatePreRequise()
     */
    protected function validatePreRequise()
    {
        if (is_null($this->injectTarget)) {
            throw new RequiredArgumentException(
                'The injectTarget is mandatory',
                500
            );
        }
    }
}
