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
namespace CSDT\PhpunitTestHelper\TestCases;

use CSDT\PhpunitTestHelper\Objects\SetterCall;
use CSDT\PhpunitTestHelper\Objects\ObjectCall;
use CSDT\PhpunitTestHelper\Objects\GetterCall;

/**
 * ObjectTestCase
 *
 * The ObjectTestCase allow to test an object with method call,
 * setter call and getter call.
 *
 * @category ObjectTestCase
 * @package  PHPUnitTestHelper
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ObjectTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * New ObjectCall
     *
     * This method return a new ObjectCall.
     *
     * @return ObjectCall
     */
    protected function newObjectCall()
    {
        return new ObjectCall($this);
    }

    /**
     * New SetterCall
     *
     * This method return a new SetterCall.
     *
     * @return SetterCall
     */
    protected function newSetterCall()
    {
        return new SetterCall($this);
    }

    /**
     * New GetterCall
     *
     * This method return a new GetterCall.
     *
     * @return GetterCall
     */
    protected function newGetterCall()
    {
        return new GetterCall($this);
    }
}
