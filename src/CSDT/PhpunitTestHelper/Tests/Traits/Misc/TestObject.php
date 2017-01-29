<?php
/**
 * This file is part of the Hephaistos project management API.
 *
 * As each files provides by the CSCFA, this file is licensed
 * under the MIT license.
 *
 * PHP version 5.6
 *
 * @category Test object
 * @package  PHPUnitTestHelper
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace CSDT\PhpunitTestHelper\Tests\Traits\Misc;

/**
 * TestObject
 *
 * This class is used to test the phpunit test helper
 *
 * @category Test object
 * @package  PHPUnitTestHelper
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class TestObject
{
    /**
     * Public
     *
     * The public property name
     *
     * @var string
     */
    const PROP_PUBLIC = 'property';

    /**
     * Protected
     *
     * The protected property name
     *
     * @var string
     */
    const PROP_PROTECTED = 'protected';

    /**
     * Private
     *
     * The private property name
     *
     * @var string
     */
    const PROP_PRIVATE = 'private';

    /**
     * Public static
     *
     * The public static property name
     *
     * @var string
     */
    const PROP_PUBLIC_STATIC = 'static';

    /**
     * Protected static
     *
     * The protected static property name
     *
     * @var string
     */
    const PROP_PROTECTED_STATIC = 'staticProtected';

    /**
     * Private static
     *
     * The private static property name
     *
     * @var string
     */
    const PROP_PRIVATE_STATIC = 'staticPrivate';

    /**
     * Property
     *
     * A public property
     *
     * @var mixed
     */
    public $property;

    /**
     * Protected
     *
     * A protected property
     *
     * @var mixed
     */
    protected $protected;

    /**
     * Private
     *
     * A private property
     *
     * @var mixed
     */
    private $private;

    /**
     * Static
     *
     * A static public property
     *
     * @var mixed
     */
    static public $static;

    /**
     * Static protected
     *
     * A static protected property.
     *
     * @var mixed
     */
    static protected $staticProtected;

    /**
     * Static private
     *
     * A static private property.
     *
     * @var mixed
     */
    static private $staticPrivate;

    /**
     * Get property
     *
     * Return the public property.
     *
     * @return mixed
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * Set property
     *
     * Set the public property
     *
     * @param mixed $property The public property value
     *
     * @return TestObject
     */
    public function setProperty($property)
    {
        $this->property = $property;

        return $this;
    }

    /**
     * Get protected
     *
     * Return the protected property.
     *
     * @return mixed
     */
    public function getProtected()
    {
        return $this->protected;
    }

    /**
     * Set protected
     *
     * Set the protected property
     *
     * @param mixed $protected The protected property value
     *
     * @return TestObject
     */
    public function setProtected($protected)
    {
        $this->protected = $protected;

        return $this;
    }

    /**
     * Get private
     *
     * Return the private property.
     *
     * @return mixed
     */
    public function getPrivate()
    {
        return $this->private;
    }

    /**
     * Set private
     *
     * Set the private property
     *
     * @param mixed $private The private property value
     *
     * @return TestObject
     */
    public function setPrivate($private)
    {
        $this->private = $private;

        return $this;
    }

    /**
     * Get static
     *
     * Return the static public property.
     *
     * @return mixed
     */
    public static function getStatic()
    {
        return self::$static;
    }

    /**
     * Set static
     *
     * Set the static property
     *
     * @param mixed $static The static property value
     *
     * @return TestObject
     */
    public static function setStatic($static)
    {
        self::$static = $static;
    }

    /**
     * Get static protected
     *
     * Return the static protected property.
     *
     * @return mixed
     */
    public static function getStaticProtected()
    {
        return self::$staticProtected;
    }

    /**
     * Set static protected
     *
     * Set the static protected property
     *
     * @param mixed $staticProtected The static protected property value
     *
     * @return TestObject
     */
    public static function setStaticProtected($staticProtected)
    {
        self::$staticProtected = $staticProtected;
    }

    /**
     * Get static private
     *
     * Return the static private property.
     *
     * @return mixed
     */
    public static function getStaticPrivate()
    {
        return self::$staticPrivate;
    }

    /**
     * Set static private
     *
     * Set the static private property
     *
     * @param mixed $staticPrivate The static private property value
     *
     * @return TestObject
     */
    public static function setStaticPrivate($staticPrivate)
    {
        self::$staticPrivate = $staticPrivate;
    }

    /**
     * Throw exception
     *
     * This method throw an exception.
     *
     * @param string $message The exception message
     * @param string $code    The exception code
     *
     * @throws \Exception
     */
    public function throwException($message, $code)
    {
        throw new \Exception($message, $code);
    }
}
