<?php
/**
 * This file is part of the Hephaistos project management API.
 *
 * As each files provides by the CSCFA, this file is licensed
 * under the MIT license.
 *
 * PHP version 5.6
 *
 * @category Exceptions
 * @package  PHPUnitTestHelper
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace CSDT\PhpunitTestHelper\Exceptions;

/**
 * Type exception
 *
 * This exception is used in case of an unexpected type is given.
 *
 * @category Exceptions
 * @package  PHPUnitTestHelper
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class TypeException extends \Exception
{
    /**
     * Constructor
     *
     * The default TypeException constructor
     *
     * @param string     $expectedType The expected type
     * @param mixed      $instance     The given object
     * @param integer    $code         The exception code
     * @param \Exception $previous     The previous exception
     *
     * @return void
     */
    public function __construct($expectedType, $instance, $code = null, $previous = null)
    {
        $givenType = gettype($instance) == 'object' ? get_class($instance) : gettype($instance);

        $message = sprintf(
            'Type \'%s\' expected. \'%s\' given.',
            (string) $expectedType,
            $givenType
        );

        parent::__construct($message, $code, $previous);
    }
}
