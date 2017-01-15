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
namespace CSDT\PhpunitTestHelper\Tests\Traits;

use CSDT\PhpunitTestHelper\Tests\Traits\Misc\TestObject;
use CSDT\PhpunitTestHelper\Exceptions\TypeException;

/**
 * ObjectTestTrait test
 *
 * This class is used to test the ObjectTestTrait
 *
 * @category Test
 * @package  PHPUnitTestHelper
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ObjectTestTraitTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test getPropertyValue
     *
     * This method test the ObjectTestTrait getPropertyValue
     * method logic.
     *
     * @return void
     */
    public function testGetPropertyValue()
    {
        $instance = $this->getMockForTrait('CSDT\\PhpunitTestHelper\\Traits\\ObjectTestTrait');
        $object = new TestObject();

        $equalityValue = "test_value";
        $sameValue = new \stdClass();

        $object->setProperty($equalityValue)
            ->setPrivate($equalityValue)
            ->setProtected($equalityValue);

        $object->setStatic($equalityValue);
        $object->setStaticPrivate($equalityValue);
        $object->setStaticProtected($equalityValue);

        $this->assertEquals(
            $equalityValue,
            $instance->getPropertyValue($object, TestObject::PROP_PUBLIC),
            'ObjectTestTrait is expected to be able to access to public properties'
        );
        $this->assertEquals(
            $equalityValue,
            $instance->getPropertyValue($object, TestObject::PROP_PROTECTED),
            'ObjectTestTrait is expected to be able to access to protected properties'
        );
        $this->assertEquals(
            $equalityValue,
            $instance->getPropertyValue($object, TestObject::PROP_PRIVATE),
            'ObjectTestTrait is expected to be able to access to private properties'
        );

        $this->assertEquals(
            $equalityValue,
            $instance->getPropertyValue($object, TestObject::PROP_PUBLIC_STATIC),
            'ObjectTestTrait is expected to be able to access to public static properties'
        );
        $this->assertEquals(
            $equalityValue,
            $instance->getPropertyValue($object, TestObject::PROP_PROTECTED_STATIC),
            'ObjectTestTrait is expected to be able to access to static protected properties'
        );
        $this->assertEquals(
            $equalityValue,
            $instance->getPropertyValue($object, TestObject::PROP_PRIVATE_STATIC),
            'ObjectTestTrait is expected to be able to access to static privet properties'
        );

        $object->setProperty($sameValue)
            ->setPrivate($sameValue)
            ->setProtected($sameValue);

        $object->setStatic($sameValue);
        $object->setStaticPrivate($sameValue);
        $object->setStaticProtected($sameValue);

        $this->assertSame(
            $sameValue,
            $instance->getPropertyValue($object, TestObject::PROP_PUBLIC),
            'ObjectTestTrait is expected to be able to access to public properties'
        );
        $this->assertSame(
            $sameValue,
            $instance->getPropertyValue($object, TestObject::PROP_PROTECTED),
            'ObjectTestTrait is expected to be able to access to protected properties'
        );
        $this->assertSame(
            $sameValue,
            $instance->getPropertyValue($object, TestObject::PROP_PRIVATE),
            'ObjectTestTrait is expected to be able to access to private properties'
        );

        $this->assertSame(
            $sameValue,
            $instance->getPropertyValue($object, TestObject::PROP_PUBLIC_STATIC),
            'ObjectTestTrait is expected to be able to access to public static properties'
        );
        $this->assertSame(
            $sameValue,
            $instance->getPropertyValue($object, TestObject::PROP_PROTECTED_STATIC),
            'ObjectTestTrait is expected to be able to access to static protected properties'
        );
        $this->assertSame(
            $sameValue,
            $instance->getPropertyValue($object, TestObject::PROP_PRIVATE_STATIC),
            'ObjectTestTrait is expected to be able to access to static privet properties'
        );
    }

    /**
     * Test setPropertyValue
     *
     * This method test the ObjectTestTrait setPropertyValue
     * method logic.
     *
     * @return void
     */
    public function testSetPropertyValue()
    {
        $instance = $this->getMockForTrait('CSDT\\PhpunitTestHelper\\Traits\\ObjectTestTrait');
        $object = new TestObject();

        $equalityValue = "test_value";
        $sameValue = new \stdClass();

        $instance->setPropertyValue($object, TestObject::PROP_PUBLIC, $equalityValue);
        $instance->setPropertyValue($object, TestObject::PROP_PROTECTED, $equalityValue);
        $instance->setPropertyValue($object, TestObject::PROP_PRIVATE, $equalityValue);

        $instance->setPropertyValue($object, TestObject::PROP_PUBLIC_STATIC, $equalityValue);
        $instance->setPropertyValue($object, TestObject::PROP_PROTECTED_STATIC, $equalityValue);
        $instance->setPropertyValue($object, TestObject::PROP_PRIVATE_STATIC, $equalityValue);

        $this->assertEquals(
            $equalityValue,
            $object->getProperty(),
            'ObjectTestTrait is expected to be able to set a public property'
        );
        $this->assertEquals(
            $equalityValue,
            $object->getProtected(),
            'ObjectTestTrait is expected to be able to set a protected property'
        );
        $this->assertEquals(
            $equalityValue,
            $object->getPrivate(),
            'ObjectTestTrait is expected to be able to set a private property'
        );

        $this->assertEquals(
            $equalityValue,
            $object->getStatic(),
            'ObjectTestTrait is expected to be able to set a static public property'
        );
        $this->assertEquals(
            $equalityValue,
            $object->getStaticProtected(),
            'ObjectTestTrait is expected to be able to set a static protected property'
        );
        $this->assertEquals(
            $equalityValue,
            $object->getStaticPrivate(),
            'ObjectTestTrait is expected to be able to set a static private property'
        );

        $instance->setPropertyValue($object, TestObject::PROP_PUBLIC, $sameValue);
        $instance->setPropertyValue($object, TestObject::PROP_PROTECTED, $sameValue);
        $instance->setPropertyValue($object, TestObject::PROP_PRIVATE, $sameValue);

        $instance->setPropertyValue($object, TestObject::PROP_PUBLIC_STATIC, $sameValue);
        $instance->setPropertyValue($object, TestObject::PROP_PROTECTED_STATIC, $sameValue);
        $instance->setPropertyValue($object, TestObject::PROP_PRIVATE_STATIC, $sameValue);

        $this->assertSame(
            $sameValue,
            $object->getProperty(),
            'ObjectTestTrait is expected to be able to set a public property'
        );
        $this->assertSame(
            $sameValue,
            $object->getProtected(),
            'ObjectTestTrait is expected to be able to set a protected property'
        );
        $this->assertSame(
            $sameValue,
            $object->getPrivate(),
            'ObjectTestTrait is expected to be able to set a private property'
        );

        $this->assertSame(
            $sameValue,
            $object->getStatic(),
            'ObjectTestTrait is expected to be able to set a static public property'
        );
        $this->assertSame(
            $sameValue,
            $object->getStaticProtected(),
            'ObjectTestTrait is expected to be able to set a static protected property'
        );
        $this->assertSame(
            $sameValue,
            $object->getStaticPrivate(),
            'ObjectTestTrait is expected to be able to set a static private property'
        );

    }

    /**
     * Test type exception
     *
     * This method test the ObjectTestTrait when a
     * TypeException must be throwed.
     *
     * @return void
     */
    public function testTypeException()
    {
        $instance = $this->getMockForTrait('CSDT\\PhpunitTestHelper\\Traits\\ObjectTestTrait');

        try {
            $instance->getPropertyValue('string', 'property');
            $this->fail('Get property of non object must fail');
        } catch (TypeException $exception) {
            // success
        }

        try {
            $instance->setPropertyValue('string', 'property', 'value');
            $this->fail('Set property of non object must fail');
        } catch (TypeException $exception) {
            // success
        }
    }

    /**
     * Test reflection exception
     *
     * This method test the ObjectTestTrait when a
     * ReflectionException must be throwed.
     *
     * @return void
     */
    public function testReflectionException()
    {
        $instance = $this->getMockForTrait('CSDT\\PhpunitTestHelper\\Traits\\ObjectTestTrait');

        try {
            $instance->getPropertyValue(new \stdClass(), 'property');
            $this->fail('Get unexisting property must fail');
        } catch (\ReflectionException $exception) {
            // success
        }

        try {
            $instance->setPropertyValue(new \stdClass(), 'property', 'value');
            $this->fail('Set unexisting property must fail');
        } catch (\ReflectionException $exception) {
            // success
        }
    }
}
