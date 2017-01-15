<?php
/**
 * This file is part of the Hephaistos project management API.
 *
 * As each files provides by the CSCFA, this file is licensed
 * under the MIT license.
 *
 * PHP version 5.6
 *
 * @category Trait
 * @package  PHPUnitTestHelper
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace CSDT\PhpunitTestHelper\Traits;

use CSDT\PhpunitTestHelper\Exceptions\TypeException;

/**
 * ObjectTestTrait
 *
 * This trait is used to test an object instance
 *
 * @category Trait
 * @package  PHPUnitTestHelper
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
trait ObjectTestTrait
{

    /**
     * Get property value
     *
     * This method return the value of a property
     * inside an object.
     *
     * @param mixed  $instance The object whence return the property
     * @param string $property The property name
     *
     * @throws TypeException        If the given instance is not an object
     * @throws \ReflectionException If the property does not exist
     *
     * @return mixed
     */
    public function getPropertyValue($instance, $property)
    {
        $property = $this->getProperty($instance, $property);
        $this->setPropertyAccessible($property);

        return $property->getValue($instance);
    }

    /**
     * Set property value
     *
     * This method hydrate the value of a property
     * inside an object.
     *
     * @param mixed  $instance The object where hydrate the property
     * @param string $property The property name
     * @param mixed  $value    The value to inject
     *
     * @throws TypeException        If the given instance is not an object
     * @throws \ReflectionException If the property does not exist
     *
     * @return void
     */
    public function setPropertyValue($instance, $property, $value)
    {
        $property = $this->getProperty($instance, $property);
        $this->setPropertyAccessible($property);
        $property->setValue($instance, $value);
    }

    /**
     * Set property accessible
     *
     * This method set the property to accessible if not public
     * or run-time.
     *
     * @param \ReflectionProperty $property The property to set accessible
     *
     * @return void
     */
    private function setPropertyAccessible(\ReflectionProperty $property)
    {
        if (!$property->isPublic()) {
            $property->setAccessible(true);
        }
    }

    /**
     * Get property
     *
     * This method return a Reflection property according with
     * the instance and property name given.
     *
     * @param mixed  $instance The object whence return the property
     * @param string $property The property name
     *
     * @throws TypeException        If the given instance is not an object
     * @throws \ReflectionException If the property does not exist
     *
     * @return \ReflectionProperty
     */
    private function getProperty($instance, $property)
    {
        if (!is_object($instance)) {
            throw new TypeException('object', $instance);
        }

        $reflection = new \ReflectionClass($instance);
        if (!$reflection->hasProperty($property)) {
            throw new \ReflectionException(
                sprintf(
                    'The property %s of class %s does not exist',
                    $property,
                    $reflection->getName()
                )
            );
        }

        return $reflection->getProperty($property);
    }
}
