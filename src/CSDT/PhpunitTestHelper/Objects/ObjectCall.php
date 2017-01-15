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

use Prophecy\Exception\Doubler\MethodNotFoundException;
use CSDT\PhpunitTestHelper\Exceptions\TypeException;
use CSDT\PhpunitTestHelper\Exceptions\RequiredArgumentException;

/**
 * ObjectCall
 *
 * The ObjectCall allow to test a method call with argument
 * and return value.
 *
 * @category ObjectTesting
 * @package  PHPUnitTestHelper
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ObjectCall
{
    /**
     * Assert
     *
     * The assert instance to execute the tests.
     *
     * @var \PHPUnit_Framework_Assert
     */
    protected $assert;

    /**
     * Instance
     *
     * The object instance to be tested.
     *
     * @var mixed
     */
    protected $instance;

    /**
     * Call method
     *
     * The method name to call
     *
     * @var string
     */
    private $callMethod;

    /**
     * Arguments
     *
     * The method call arguments
     *
     * @var array
     */
    private $arguments;

    /**
     * Result
     *
     * The expected method call result.
     *
     * @var mixed
     */
    private $result;

    /**
     * Same
     *
     * The return equality type.
     *
     * @var boolean
     */
    private $same = false;

    /**
     * Constructor
     *
     * The default ObjectCall constructor.
     *
     * @param \PHPUnit_Framework_Assert $assert The assert instance to execute the tests
     *
     * @return void
     */
    public function __construct(\PHPUnit_Framework_Assert $assert)
    {
        $this->assert = $assert;
        $this->arguments = array();
    }

    /**
     * Call
     *
     * This method define the method name to call.
     *
     * @param string $method The emthod name to call.
     *
     * @throws TypeException If the given method is not a string
     *
     * @return $this
     */
    public function call($method)
    {
        if (!is_string($method)) {
            throw new TypeException('string', $method);
        }

        $this->callMethod = $method;

        return $this;
    }

    /**
     * On instance
     *
     * This method define the instance on which the method must be called.
     *
     * @param mixed $instance The instance that is tested
     *
     * @throws TypeException If the given instance is not an object
     *
     * @return $this
     */
    public function onInstance($instance)
    {
        if (!is_object($instance)) {
            throw new TypeException('object', $instance);
        }

        $this->instance = $instance;

        return $this;
    }

    /**
     * With
     *
     * This method define the arguments passed to the method at call time.
     *
     * @param array $arguments The arguments to inject.
     *
     * @return $this
     */
    public function with(array $arguments = array())
    {
        $this->arguments = $arguments;

        return $this;
    }

    /**
     * Must return
     *
     * This method define the expected method return value.
     *
     * @param mixed  $result The expected result
     * @param string $same   [optional] The equality type (true for same, false for equal)
     *
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     * @return $this
     */
    public function mustReturn($result, $same = false)
    {
        $this->result = $result;
        $this->same = $same;

        return $this;
    }

    /**
     * Resolve
     *
     * This method resolve and execute the object call
     * definition.
     *
     * @param string $message The failure message
     *
     * @throws \RuntimeException         If the method call fail
     * @throws MethodNotFoundException   If the method does not exist
     * @throws RequiredArgumentException If the callMethod or instance are null
     *
     * @return void
     */
    public function resolve($message = '')
    {
        $this->validatePreRequise();

        $result = null;
        $failException = null;
        $failed = false;
        try {
            $result = $this->callMethod();
        } catch (\Exception $exception) {
            $failException = $exception;
            $failed = true;
        }

        if (!$failed) {
            $method = 'assertEquals';
            if ($this->same) {
                $method = 'assertSame';
            }

            $this->assert->$method($this->result, $result, $message);
        } else {
            throw new \RuntimeException('Method call failed', 500, $failException);
        }
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
    protected function validatePreRequise()
    {
        if (is_null($this->callMethod) || is_null($this->instance)) {
            throw new RequiredArgumentException(
                'The callMEthod and instance are mandatory',
                500
            );
        }
    }

    /**
     * Call method
     *
     * This method call the current tested instance
     * expected method with the registered arguments.
     *
     * @param \ReflectionClass $reflection The reflection whence resolve the method
     * @param string           $methodName The method name to resolve
     *
     * @throws MethodNotFoundException If the method does not exist
     *
     * @return mixed
     */
    private function callMethod()
    {
        $reflection = new \ReflectionClass($this->instance);
        $method = $this->getMethod($reflection, $this->callMethod);

        return $method->invokeArgs($this->instance, $this->arguments);
    }

    /**
     * Get method
     *
     * This method return a ReflectionMethod from a given
     * reflection class.
     *
     * @param \ReflectionClass $reflection The reflection whence resolve the method
     * @param string           $methodName The method name to resolve
     *
     * @throws MethodNotFoundException If the method does not exist
     *
     * @return \ReflectionMethod
     */
    private function getMethod(\ReflectionClass $reflection, $methodName)
    {
        if (!$reflection->hasMethod($methodName)) {
            throw new MethodNotFoundException(
                sprintf('Method \'%s\' cannot be resolved', $methodName),
                $reflection->getName(),
                $methodName
            );
        }

        return $reflection->getMethod($methodName);
    }
}
