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
namespace CSDT\PhpunitTestHelper\Tests\TestCase;

use CSDT\PhpunitTestHelper\TestCases\ObjectTestCase;
use CSDT\PhpunitTestHelper\Objects\ObjectCall;
use CSDT\PhpunitTestHelper\Objects\SetterCall;
use CSDT\PhpunitTestHelper\Objects\GetterCall;

/**
 * ObjectTestCase test
 *
 * This class is used to test the ObjectTestCase
 *
 * @category Test
 * @package  PHPUnitTestHelper
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ObjectTestCaseTest extends ObjectTestCase
{
    /**
     * Test newObjectCall
     *
     * This method validat the newObjectCall logic.
     *
     * @return void
     */
    public function testNewObjectCall()
    {
        $this->assertInstanceOf(
            ObjectCall::class,
            $this->newObjectCall(),
            'The newObjectCall is expected to return a new ObjectCall instance'
        );
    }

    /**
     * Test newSetterCall
     *
     * This method validat the newSetterCall logic.
     *
     * @return void
     */
    public function testNewSetteCall()
    {
        $this->assertInstanceOf(
            SetterCall::class,
            $this->newSetterCall(),
            'The newObjectCall is expected to return a new SetterCall instance'
        );
    }

    /**
     * Test newGetterCall
     *
     * This method validat the newGetterCall logic.
     *
     * @return void
     */
    public function testNewGetterCall()
    {
        $this->assertInstanceOf(
            GetterCall::class,
            $this->newGetterCall(),
            'The newObjectCall is expected to return a new GetterCall instance'
        );
    }
}
