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
use CSDT\PhpunitTestHelper\Expressions\InjectExpression;

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
     * Injections
     *
     * This property store the expected
     * injections.
     *
     * @var array
     */
    private $injections;

    /**
     * {@inheritDoc}
     *
     * @see \CSDT\PhpunitTestHelper\Objects\ObjectCall::__construct()
     */
    public function __construct($assert)
    {
        parent::__construct($assert);

        $this->injections = array();
    }

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
     * @return                                      $this
     */
    public function inject($value, $same = false, callable $process = null)
    {
        $injection = new InjectExpression($value, $this, $this->assert, $same, $process);

        array_push($this->injections, $injection);

        return $injection;
    }

    /**
     * {@inheritDoc}
     *
     * @see \CSDT\PhpunitTestHelper\Objects\ObjectCall::resolve()
     */
    public function resolve($message = '', $injectionMessage = '')
    {
        parent::resolve($message);

        foreach ($this->injections as $injection) {
            if ($injection instanceof InjectExpression) {
                $injection->resolve($this->instance, $injectionMessage);
            }
        }
    }
}
