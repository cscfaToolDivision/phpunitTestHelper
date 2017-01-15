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
use CSDT\PhpunitTestHelper\Exceptions\TypeException;
use CSDT\PhpunitTestHelper\Traits\ObjectTestTrait;
use CSDT\PhpunitTestHelper\Exceptions\RequiredArgumentException;

/**
 * Getter call.
 *
 * The GetterCall allow to test a getter method call with argument,
 * return value and property setting.
 *
 * @category ObjectTesting
 * @package  PHPUnitTestHelper
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class GetterCall extends ObjectCall
{
    use ObjectTestTrait;

    /**
     * From property
     *
     * This property store the property that store
     * the value to return.
     *
     * @var string
     */
    private $fromProperty;

    /**
     * That contain
     *
     * This property store the value contained by the
     * fromProperty.
     *
     * @var mixed
     */
    private $thatContain;

    /**
     * From
     *
     * This method define the property whence the getter
     * is expected to return a value.
     *
     * @param string $property The property name
     *
     * @throws TypeException If the given property is not a string
     *
     * @return $this
     */
    public function from($property)
    {
        if (!is_string($property)) {
            throw new TypeException('string', $property);
        }

        $this->fromProperty = $property;

        return $this;
    }

    /**
     * That contain
     *
     * This method define the value contained into the given property.
     *
     * @param mixed $value The value contained by the property
     *
     * @return $this
     */
    public function thatContain($value)
    {
        $this->thatContain = $value;

        return $this;
    }

    /**
     * {@inheritDoc}
     *
     * @see \CSDT\PhpunitTestHelper\Objects\ObjectCall::resolve()
     */
    public function resolve($message = '', $injectionMessage = '')
    {
        $this->validatePreRequise();

        $this->setPropertyValue(
            $this->instance,
            $this->fromProperty,
            $this->thatContain
        );

        parent::resolve($message);
    }

    /**
     * {@inheritDoc}
     *
     * @see \CSDT\PhpunitTestHelper\Objects\ObjectCall::validatePreRequise()
     */
    protected function validatePreRequise()
    {
        if (is_null($this->fromProperty) || is_null($this->thatContain)) {
            throw new RequiredArgumentException(
                'The fromProperty and thatContain are mandatory',
                500
            );
        }
    }
}
