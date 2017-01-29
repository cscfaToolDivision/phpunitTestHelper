# phpunitTestHelper

## The ObjectTestCase

The ObjectTestCase is a child of the phpunit TestCase that provide method to create

 * ObjectCall instance (**newObjectCall()** method),
 * SetterCall instance (**newSetterCall()** method),
 * GetterCall instance (**newGetterCall()** method)


## The ObjectTestTrait

This trait is used to provider helper methods to test an object instance.

#### Get an instance property value :

To get an instance property value, the trait provide a **getPropertyValue(instance, property)** method. The instance is given as first parameter and the property name as second one.

This method will create a reflection, set the property accessible and return it's value. An exception will be throwed if the first parameter is not an object or if the second one is not an object property.

```php
$instance = new MyInstance();
$instance->setName('instance_name');

$value = $ObjectTest->getPropertyValue($instance, 'name');

echo $value; // return 'instance_name'
```

#### Set an instance property value :

To set an instance property value, the trait provide a **setPropertyValue(instance, property, value)** method. The instance is given as first paramete, the property name as second one and the value as third one.

This method will create a reflection, set the property accessible and hydrate it's value. An exception will be throwed if the first parameter is not an object or if the second one is not an object property.

```php
$instance = new MyInstance();
$instance->setName('instance_name');

$value = $ObjectTest->getPropertyValue($instance, 'name');

echo $value; // return 'instance_name'
```

## The ObjectCall

The **ObjectCall** allow to test a method call with argument and return value. It allow to define the method name to call and the instance. This class need a ***\PHPUnit_Framework_Assert*** instance to execute the tests.

```php
$instance = new MyInstance();
$caller = new ObjectCall($currentTestCase);

$call->call('setName')
            ->on($instance)
            ->with(array('instance_name'))
            ->mustReturn($instance, true)
            ->resolve('Return value mismatch');
```

#### The resolve method

This method will call the method and validate the result. It will throw a ***\RuntimeException*** if the method call fail, a ***MethodNotFoundException*** if the method does not exist or a ***RequiredArgumentException*** if the method name to call or the instance are null.

It accept the assertion failure message as optional argument.

#### The mustReturn method

This method define the expected method return value. The second argument define if the expected and returned must be equals or same. To define the values as same, give true as second argument, or false for equal. Note the second argument is optional and is false by default.

#### The with method

This method define the arguments passed to the method at call time. It must be an array. To give none arguments to the method, simply don't call the ***with*** method. 

#### The on method

This method define the instance on which the method must be called.

#### The call method

This method define the method name to call.

#### The mustThrow method

This method define that the called method must throw an exception.

```php
$instance = new MyInstance();
$caller = new ObjectCall($currentTestCase);

$call->call('throw')
            ->on($instance)
            ->with(array('instance_name'))
            ->mustThrow(\Exception::class, 500, 'Th throw method was called')
            ->resolve();
```

## The SetterCall

The **SetterCall** is an extension of the ObjectCall that allow to test the property injection.

```php
$instance = new MyInstance();
$call->call('setName')
    ->on($instance)
    ->with(array('instance_name'))
    ->mustReturn($instance)
    ->inject('instance_name', false, function($value){return $value;})
    ->injectIn('name')
    ->resolve();
```

#### The inject method

This method allow to provide a value that is expected to be injected into a property of the instance. The given boolean, as second argument tell that the equality must be tested by same (as true) or equal (as false). Finally, a **Callable** can be given as third argument to pre-process the value before equality validation.

It return a InjectExpression instance.

#### The injectIn method

This method define the property where the value is stored. It is a method of InjectExpression instance and return the parent SetterCall instance.

For multiple instance setting, it s possible to give another instance as second argument to the injectIn method to specify another instance where the value must be injected.

```php
$instance = new MyInstance();
$facade = new MyFacade($instance);
$call->call('setName')
    ->on($facade)
    ->with(array('instance_name'))
    ->mustReturn($facade)
    ->inject('instance_name', false, function($value){return $value;})
    ->injectIn('name', $instance)
    ->resolve();
```

## The GetterCall

The **GetterCall** is an extension of the ObjectCall that allow to test the property getter.

```php
$instance = new MyInstance();
$name = 'instance_name';

$call->call('getName')
    ->on($instance)
    ->mustReturn($name)
    ->from('instanceName')
    ->thatContain($name)
    ->resolve();
```

#### The from method

This method define the property whence the getter is expected to return a value. It only accept a string value and will throw a TypeException if a non string value is provided.

#### The thatContain method

This method define the value contained into the given property.