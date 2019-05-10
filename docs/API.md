# Inspekt API Documentation 

[User Docs](https://github.com/benedmunds/inspekt/blob/master/docs/USER.md)

[API Docs](https://github.com/benedmunds/inspekt/blob/master/docs/API.md)


## Table of Contents

* [Cage](#cage)
    * [__construct](#__construct)
    * [factory](#factory)
    * [getIterator](#getiterator)
    * [offsetSet](#offsetset)
    * [offsetExists](#offsetexists)
    * [offsetUnset](#offsetunset)
    * [offsetGet](#offsetget)
    * [count](#count)
    * [loadHTMLPurifier](#loadhtmlpurifier)
    * [setHTMLPurifier](#sethtmlpurifier)
    * [getHTMLPurifier](#gethtmlpurifier)
    * [__call](#__call)
    * [addAccessor](#addaccessor)
    * [getAlpha](#getalpha)
    * [getAlnum](#getalnum)
    * [getDigits](#getdigits)
    * [getDir](#getdir)
    * [getInt](#getint)
    * [getPath](#getpath)
    * [getROT13](#getrot13)
    * [getPurifiedHTML](#getpurifiedhtml)
    * [getRaw](#getraw)
    * [testAlnum](#testalnum)
    * [testAlpha](#testalpha)
    * [testBetween](#testbetween)
    * [testCcnum](#testccnum)
    * [testDate](#testdate)
    * [testDigits](#testdigits)
    * [testEmail](#testemail)
    * [testFloat](#testfloat)
    * [testGreaterThan](#testgreaterthan)
    * [testHex](#testhex)
    * [testHostname](#testhostname)
    * [testInt](#testint)
    * [testIp](#testip)
    * [testLessThan](#testlessthan)
    * [testOneOf](#testoneof)
    * [testPhone](#testphone)
    * [testRegex](#testregex)
    * [testUri](#testuri)
    * [testZip](#testzip)
    * [noTags](#notags)
    * [noPath](#nopath)
    * [noTagsOrSpecial](#notagsorspecial)
    * [escMySQL](#escmysql)
    * [escPgSQL](#escpgsql)
    * [escPgSQLBytea](#escpgsqlbytea)
    * [keyExists](#keyexists)
    * [getValue](#getvalue)
* [Exception](#exception)
* [Inspekt](#inspekt)
    * [makeServerCage](#makeservercage)
    * [makeGetCage](#makegetcage)
    * [makePostCage](#makepostcage)
    * [makeCookieCage](#makecookiecage)
    * [makeEnvCage](#makeenvcage)
    * [makeFilesCage](#makefilescage)
    * [makeSuperCage](#makesupercage)
    * [useFilterExt](#usefilterext)
    * [isArrayObject](#isarrayobject)
    * [isArrayOrArrayObject](#isarrayorarrayobject)
    * [convertArrayToArrayObject](#convertarraytoarrayobject)
    * [getAlpha](#getalpha-1)
    * [getAlnum](#getalnum-1)
    * [getDigits](#getdigits-1)
    * [getDir](#getdir-1)
    * [getInt](#getint-1)
    * [getPath](#getpath-1)
    * [getROT13](#getrot13-1)
    * [isAlnum](#isalnum)
    * [isAlpha](#isalpha)
    * [isBetween](#isbetween)
    * [isCcnum](#isccnum)
    * [isDate](#isdate)
    * [isDigits](#isdigits)
    * [isEmail](#isemail)
    * [isFloat](#isfloat)
    * [isGreaterThan](#isgreaterthan)
    * [isHex](#ishex)
    * [isHostname](#ishostname)
    * [isInt](#isint)
    * [isIp](#isip)
    * [isLessThan](#islessthan)
    * [isOneOf](#isoneof)
    * [isPhone](#isphone)
    * [isRegex](#isregex)
    * [isUri](#isuri)
    * [isZip](#iszip)
    * [noTags](#notags-1)
    * [noTagsOrSpecial](#notagsorspecial-1)
    * [noPath](#nopath-1)
    * [escMySQL](#escmysql-1)
    * [escPgSQL](#escpgsql-1)
    * [escPgSQLBytea](#escpgsqlbytea-1)
* [KeyDoesNotExistException](#keydoesnotexistexception)
* [SuperglobalsCage](#superglobalscage)
    * [__construct](#__construct-1)
    * [factory](#factory-1)
    * [addAccessor](#addaccessor-1)

## Cage





* Full name: \Inspekt\Cage
* This class implements: \IteratorAggregate, \ArrayAccess, \Countable


### __construct



```php
Cage::__construct(  ): \Inspekt\Cage
```







---

### factory

Takes an array and wraps it inside an object.  If $strict is not set to
FALSE, the original array will be destroyed, and the data can only be
accessed via the object's accessor methods

```php
Cage::factory( array &$source, string $conf_file = null, string $conf_section = null, boolean $strict = true ): \Inspekt\Cage
```



* This method is **static**.
**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$source` | **array** |  |
| `$conf_file` | **string** |  |
| `$conf_section` | **string** |  |
| `$strict` | **boolean** |  |




---

### getIterator

Returns an iterator for looping through an ArrayObject.

```php
Cage::getIterator(  ): \ArrayIterator
```







---

### offsetSet

Sets the value at the specified $offset to value$
in $this->source.

```php
Cage::offsetSet( mixed $offset, mixed $value ): void
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$offset` | **mixed** |  |
| `$value` | **mixed** |  |




---

### offsetExists

Returns whether the $offset exists in $this->source.

```php
Cage::offsetExists( mixed $offset ): boolean
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$offset` | **mixed** |  |




---

### offsetUnset

Unsets the value in $this->source at $offset.

```php
Cage::offsetUnset( mixed $offset ): void
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$offset` | **mixed** |  |




---

### offsetGet

Returns the value at $offset from $this->source.

```php
Cage::offsetGet( mixed $offset ): mixed
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$offset` | **mixed** |  |




---

### count

Returns the number of elements in $this->source.

```php
Cage::count(  ): integer
```







---

### loadHTMLPurifier

Load the HTMLPurifier library and instantiate the object

```php
Cage::loadHTMLPurifier( mixed $opts = null )
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$opts` | **mixed** | options that are sent to HTMLPurifier. Optional |




---

### setHTMLPurifier



```php
Cage::setHTMLPurifier( \HTMLPurifier $pobj )
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$pobj` | **\HTMLPurifier** | an HTMLPurifer Object |




---

### getHTMLPurifier



```php
Cage::getHTMLPurifier(  ): \HTMLPurifier
```







---

### __call



```php
Cage::__call(  $name,  $args ): boolean|mixed
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$name` | **** |  |
| `$args` | **** |  |




---

### addAccessor

This method lets the developer add new accessor methods to a cage object
Note that calling these will be quite a bit slower, because we have to
use call_user_func()

```php
Cage::addAccessor( string $accessor_name ): void
```

The dev needs to define a procedural function like so:

<code>
function foo_bar($cage_object, $arg2, $arg3, $arg4, $arg5...) {
   ...
}
</code>


**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$accessor_name` | **string** |  |




---

### getAlpha

Returns only the alphabetic characters in value.

```php
Cage::getAlpha( mixed $key ): mixed
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$key` | **mixed** |  |




---

### getAlnum

Returns only the alphabetic characters and digits in value.

```php
Cage::getAlnum( mixed $key ): mixed
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$key` | **mixed** |  |




---

### getDigits

Returns only the digits in value. This differs from getInt().

```php
Cage::getDigits( mixed $key ): mixed
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$key` | **mixed** |  |




---

### getDir

Returns dirname(value).

```php
Cage::getDir( mixed $key ): mixed
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$key` | **mixed** |  |




---

### getInt

Returns (int) value.

```php
Cage::getInt( mixed $key ): integer
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$key` | **mixed** |  |




---

### getPath

Returns realpath(value).

```php
Cage::getPath( mixed $key ): mixed
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$key` | **mixed** |  |




---

### getROT13

Returns ROT13-encoded version

```php
Cage::getROT13( string $key ): mixed
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$key` | **string** |  |




---

### getPurifiedHTML

This returns the value of the given key passed through the HTMLPurifer
object, if it is instantiated with Cage::loadHTMLPurifer

```php
Cage::getPurifiedHTML( string $key ): mixed
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$key` | **string** |  |


**Return Value:**

purified HTML version of input



---

### getRaw

Returns value.

```php
Cage::getRaw( string $key ): mixed
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$key` | **string** |  |




---

### testAlnum

Returns value if every character is alphabetic or a digit,
FALSE otherwise.

```php
Cage::testAlnum( mixed $key ): mixed
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$key` | **mixed** |  |




---

### testAlpha

Returns value if every character is alphabetic, FALSE
otherwise.

```php
Cage::testAlpha( mixed $key ): mixed
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$key` | **mixed** |  |




---

### testBetween

Returns value if it is greater than or equal to $min and less
than or equal to $max, FALSE otherwise. If $inc is set to
FALSE, then the value must be strictly greater than $min and
strictly less than $max.

```php
Cage::testBetween( mixed $key, mixed $min, mixed $max, boolean $inc = true ): mixed
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$key` | **mixed** |  |
| `$min` | **mixed** |  |
| `$max` | **mixed** |  |
| `$inc` | **boolean** |  |




---

### testCcnum

Returns value if it is a valid credit card number format. The
optional second argument allows developers to indicate the
type.

```php
Cage::testCcnum( mixed $key, mixed $type = null ): mixed
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$key` | **mixed** |  |
| `$type` | **mixed** |  |




---

### testDate

Returns $value if it is a valid date, FALSE otherwise. The
date is required to be in ISO 8601 format.

```php
Cage::testDate( mixed $key ): mixed
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$key` | **mixed** |  |




---

### testDigits

Returns value if every character is a digit, FALSE otherwise.

```php
Cage::testDigits( mixed $key ): mixed
```

This is just like isInt(), except there is no upper limit.


**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$key` | **mixed** |  |




---

### testEmail

Returns value if it is a valid email format, FALSE otherwise.

```php
Cage::testEmail( mixed $key ): mixed
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$key` | **mixed** |  |




---

### testFloat

Returns value if it is a valid float value, FALSE otherwise.

```php
Cage::testFloat( mixed $key ): mixed
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$key` | **mixed** |  |




---

### testGreaterThan

Returns value if it is greater than $min, FALSE otherwise.

```php
Cage::testGreaterThan( mixed $key, mixed $min = null ): mixed
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$key` | **mixed** |  |
| `$min` | **mixed** |  |




---

### testHex

Returns value if it is a valid hexadecimal format, FALSE
otherwise.

```php
Cage::testHex( mixed $key ): mixed
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$key` | **mixed** |  |




---

### testHostname

Returns value if it is a valid hostname, FALSE otherwise.

```php
Cage::testHostname( mixed $key, integer $allow = \Inspekt\Inspekt::ISPK_HOST_ALLOW_ALL ): mixed
```

Depending upon the value of $allow, Internet domain names, IP
addresses, and/or local network names are considered valid.
The default is HOST_ALLOW_ALL, which considers all of the
above to be valid.


**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$key` | **mixed** |  |
| `$allow` | **integer** | bitfield for HOST_ALLOW_DNS, HOST_ALLOW_IP, HOST_ALLOW_LOCAL |




---

### testInt

Returns value if it is a valid integer value, FALSE otherwise.

```php
Cage::testInt( mixed $key ): mixed
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$key` | **mixed** |  |




---

### testIp

Returns value if it is a valid IP format, FALSE otherwise.

```php
Cage::testIp( mixed $key ): mixed
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$key` | **mixed** |  |




---

### testLessThan

Returns value if it is less than $max, FALSE otherwise.

```php
Cage::testLessThan( mixed $key, mixed $max = null ): mixed
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$key` | **mixed** |  |
| `$max` | **mixed** |  |




---

### testOneOf

Returns value if it is one of $allowed, FALSE otherwise.

```php
Cage::testOneOf( mixed $key, null $allowed = null ): mixed
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$key` | **mixed** |  |
| `$allowed` | **null** |  |




---

### testPhone

Returns value if it is a valid phone number format, FALSE
otherwise. The optional second argument indicates the country.

```php
Cage::testPhone( mixed $key, string $country = &#039;US&#039; ): mixed
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$key` | **mixed** |  |
| `$country` | **string** |  |




---

### testRegex

Returns value if it matches $pattern, FALSE otherwise. Uses
preg_match() for the matching.

```php
Cage::testRegex( mixed $key, mixed $pattern ): mixed
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$key` | **mixed** |  |
| `$pattern` | **mixed** |  |




---

### testUri

Enter description here.

```php
Cage::testUri( string $key ): boolean|string
```

..


**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$key` | **string** |  |




---

### testZip

Returns value if it is a valid US ZIP, FALSE otherwise.

```php
Cage::testZip( mixed $key ): mixed
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$key` | **mixed** |  |




---

### noTags

Returns value with all tags removed.

```php
Cage::noTags( mixed $key ): mixed
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$key` | **mixed** |  |




---

### noPath

Returns basename(value).

```php
Cage::noPath( mixed $key ): mixed
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$key` | **mixed** |  |




---

### noTagsOrSpecial



```php
Cage::noTagsOrSpecial(  $key ): array|boolean|mixed|string
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$key` | **** |  |




---

### escMySQL



```php
Cage::escMySQL( string $key, resource $conn ): boolean|mixed
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$key` | **string** |  |
| `$conn` | **resource** | a connection resource |




---

### escPgSQL



```php
Cage::escPgSQL(  $key, null $conn = null ): boolean|mixed
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$key` | **** |  |
| `$conn` | **null** |  |




---

### escPgSQLBytea



```php
Cage::escPgSQLBytea(  $key, null $conn = null ): boolean|mixed
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$key` | **** |  |
| `$conn` | **null** |  |




---

### keyExists

Checks if a key exists

```php
Cage::keyExists( mixed $key ): boolean
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$key` | **mixed** |  |




---

### getValue

Retrieves a value from the source array. This should NOT be called directly, but needs to be public
for use by AccessorAbstract. Maybe a different approach should be considered

```php
Cage::getValue( string $key ): mixed
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$key` | **string** |  |




---

## Exception

Class Exception



* Full name: \Inspekt\Exception
* Parent class: 


## Inspekt





* Full name: \Inspekt\Inspekt


### makeServerCage

Returns the $_SERVER data wrapped in an Cage object

```php
Inspekt::makeServerCage( string $config_file = null, boolean $strict = true ): \Inspekt\Cage
```

This utilizes a singleton pattern to get around scoping issues

* This method is **static**.
**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$config_file` | **string** |  |
| `$strict` | **boolean** | whether or not to nullify the superglobal array |




---

### makeGetCage

Returns the $_GET data wrapped in an Cage object

```php
Inspekt::makeGetCage( string $config_file = null, boolean $strict = true ): \Inspekt\Cage
```

This utilizes a singleton pattern to get around scoping issues

* This method is **static**.
**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$config_file` | **string** |  |
| `$strict` | **boolean** | whether or not to nullify the superglobal array |




---

### makePostCage

Returns the $_POST data wrapped in an Cage object

```php
Inspekt::makePostCage( string $config_file = null, boolean $strict = true ): \Inspekt\Cage
```

This utilizes a singleton pattern to get around scoping issues

* This method is **static**.
**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$config_file` | **string** |  |
| `$strict` | **boolean** | whether or not to nullify the superglobal array |




---

### makeCookieCage

Returns the $_COOKIE data wrapped in an Cage object

```php
Inspekt::makeCookieCage( string $config_file = null, boolean $strict = true ): \Inspekt\Cage
```

This utilizes a singleton pattern to get around scoping issues

* This method is **static**.
**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$config_file` | **string** |  |
| `$strict` | **boolean** | whether or not to nullify the superglobal array |




---

### makeEnvCage

Returns the $_ENV data wrapped in an Cage object

```php
Inspekt::makeEnvCage( string $config_file = null, boolean $strict = true ): \Inspekt\Cage
```

This utilizes a singleton pattern to get around scoping issues

* This method is **static**.
**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$config_file` | **string** |  |
| `$strict` | **boolean** | whether or not to nullify the superglobal array |




---

### makeFilesCage

Returns the $_FILES data wrapped in an Cage object

```php
Inspekt::makeFilesCage( string $config_file = null, boolean $strict = true ): \Inspekt\Cage
```

This utilizes a singleton pattern to get around scoping issues

* This method is **static**.
**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$config_file` | **string** |  |
| `$strict` | **boolean** | whether or not to nullify the superglobal array |




---

### makeSuperCage

Returns a SuperglobalsCage object, which wraps ALL input superglobals

```php
Inspekt::makeSuperCage( string $config_file = null, boolean $strict = true ): \Inspekt\SuperglobalsCage
```



* This method is **static**.
**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$config_file` | **string** |  |
| `$strict` | **boolean** | whether or not to nullify the superglobal |




---

### useFilterExt

Sets and/or retrieves whether we should use the PHP filter extensions where possible
If a param is passed, it will set the state in addition to returning it

```php
Inspekt::useFilterExt( boolean $state = null ): boolean
```

We use this method of storing in a static class property so that we can access the value outside of
class instances

* This method is **static**.
**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$state` | **boolean** | optional |




---

### isArrayObject

Checks to see if this is an ArrayObject

```php
Inspekt::isArrayObject(  $obj ): boolean
```



* This method is **static**.* **Warning:** this method is **deprecated**. This means that this method will likely be removed in a future version.

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$obj` | **** |  |



**See Also:**

* http://php.net/arrayobject 

---

### isArrayOrArrayObject

Checks to see if this is an array or an ArrayObject

```php
Inspekt::isArrayOrArrayObject(  $arr ): boolean
```



* This method is **static**.
**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$arr` | **** |  |



**See Also:**

* http://php.net/arrayobject * http://php.net/array 

---

### convertArrayToArrayObject

Converts an array into an ArrayObject. We use ArrayObjects when walking arrays in Inspekt

```php
Inspekt::convertArrayToArrayObject(  &$arr ): \ArrayObject
```



* This method is **static**.
**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$arr` | **** |  |




---

### getAlpha

Returns only the alphabetic characters in value.

```php
Inspekt::getAlpha( mixed $value ): mixed
```



* This method is **static**.
**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | **mixed** |  |




---

### getAlnum

Returns only the alphabetic characters and digits in value.

```php
Inspekt::getAlnum( mixed $value ): mixed
```



* This method is **static**.
**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | **mixed** |  |




---

### getDigits

Returns only the digits in value.

```php
Inspekt::getDigits( mixed $value ): mixed
```



* This method is **static**.
**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | **mixed** |  |




---

### getDir

Returns dirname(value).

```php
Inspekt::getDir( mixed $value ): mixed
```



* This method is **static**.
**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | **mixed** |  |




---

### getInt

Returns (int) value.

```php
Inspekt::getInt( mixed $value ): integer
```



* This method is **static**.
**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | **mixed** |  |




---

### getPath

Returns realpath(value).

```php
Inspekt::getPath( mixed $value ): mixed
```



* This method is **static**.
**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | **mixed** |  |




---

### getROT13

Returns the value encoded as ROT13 (or decoded, if already was ROT13)

```php
Inspekt::getROT13( mixed $value ): mixed
```



* This method is **static**.
**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | **mixed** |  |



**See Also:**

* http://php.net/manual/en/function.str-rot13.php 

---

### isAlnum

Returns true if every character is alphabetic or a digit,
false otherwise.

```php
Inspekt::isAlnum( mixed $value ): boolean
```



* This method is **static**.
**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | **mixed** |  |




---

### isAlpha

Returns true if every character is alphabetic, false
otherwise.

```php
Inspekt::isAlpha( mixed $value ): boolean
```



* This method is **static**.
**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | **mixed** |  |




---

### isBetween

Returns true if value is greater than or equal to $min and less
than or equal to $max, false otherwise. If $inc is set to
false, then the value must be strictly greater than $min and
strictly less than $max.

```php
Inspekt::isBetween( mixed $value, mixed $min, mixed $max, boolean $inc = true ): boolean
```



* This method is **static**.
**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | **mixed** |  |
| `$min` | **mixed** |  |
| `$max` | **mixed** |  |
| `$inc` | **boolean** |  |




---

### isCcnum

Returns true if it is a valid credit card number format. The
optional second argument allows developers to indicate the
type.

```php
Inspekt::isCcnum( mixed $value, mixed $type = null ): boolean
```



* This method is **static**.
**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | **mixed** |  |
| `$type` | **mixed** |  |




---

### isDate

Returns true if value is a valid date, false otherwise. The
date is required to be in ISO 8601 format.

```php
Inspekt::isDate( mixed $value ): boolean
```



* This method is **static**.
**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | **mixed** |  |




---

### isDigits

Returns true if every character is a digit, false otherwise.

```php
Inspekt::isDigits( mixed $value ): boolean
```

This is just like isInt(), except there is no upper limit.

* This method is **static**.
**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | **mixed** |  |




---

### isEmail

Returns true if value is a valid email format, false otherwise.

```php
Inspekt::isEmail( string $value ): boolean
```



* This method is **static**.
**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | **string** |  |



**See Also:**

* http://www.regular-expressions.info/email.html * \Inspekt\Inspekt::ISPK_EMAIL_VALID 

---

### isFloat

Returns true if value is a valid float value, false otherwise.

```php
Inspekt::isFloat( string $value ): boolean
```



* This method is **static**.
**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | **string** |  |




---

### isGreaterThan

Returns true if value is greater than $min, false otherwise.

```php
Inspekt::isGreaterThan( mixed $value, mixed $min ): boolean
```



* This method is **static**.
**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | **mixed** |  |
| `$min` | **mixed** |  |




---

### isHex

Returns true if value is a valid hexadecimal format, false
otherwise.

```php
Inspekt::isHex( mixed $value ): boolean
```



* This method is **static**.
**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | **mixed** |  |




---

### isHostname

Returns true if value is a valid hostname, false otherwise.

```php
Inspekt::isHostname( mixed $value, integer $allow = self::ISPK_HOST_ALLOW_ALL ): boolean
```

Depending upon the value of $allow, Internet domain names, IP
addresses, and/or local network names are considered valid.
The default is HOST_ALLOW_ALL, which considers all of the
above to be valid.

* This method is **static**.
**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | **mixed** |  |
| `$allow` | **integer** | bitfield for self::ISPK_HOST_ALLOW_DNS, self::ISPK_HOST_ALLOW_IP, self::ISPK_HOST_ALLOW_LOCAL |




---

### isInt

Returns true if value is a valid integer value, false otherwise.

```php
Inspekt::isInt( string|array $value ): boolean
```



* This method is **static**.
**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | **string&#124;array** |  |




---

### isIp

Returns true if value is a valid IPV4 format, false otherwise.

```php
Inspekt::isIp( mixed $value ): boolean
```



* This method is **static**.
**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | **mixed** |  |




---

### isLessThan

Returns true if value is less than $max, false otherwise.

```php
Inspekt::isLessThan( mixed $value, mixed $max ): boolean
```



* This method is **static**.
**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | **mixed** |  |
| `$max` | **mixed** |  |




---

### isOneOf

Returns true if value is one of $allowed, false otherwise.

```php
Inspekt::isOneOf( mixed $value, array|string $allowed ): boolean
```



* This method is **static**.
**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | **mixed** |  |
| `$allowed` | **array&#124;string** |  |




---

### isPhone

Returns true if value is a valid phone number format, false
otherwise. The optional second argument indicates the country.

```php
Inspekt::isPhone( mixed $value, string $country = &#039;US&#039; ): boolean
```

This method requires that the value consist of only digits.

* This method is **static**.
**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | **mixed** |  |
| `$country` | **string** |  |




---

### isRegex

Returns true if value matches $pattern, false otherwise. Uses
preg_match() for the matching.

```php
Inspekt::isRegex( mixed $value, mixed $pattern ): mixed
```



* This method is **static**.
**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | **mixed** |  |
| `$pattern` | **mixed** |  |




---

### isUri

Enter description here.

```php
Inspekt::isUri( string $value, integer $mode = self::ISPK_URI_ALLOW_COMMON ): boolean
```

..

* This method is **static**.
**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | **string** |  |
| `$mode` | **integer** |  |



**See Also:**

* http://www.ietf.org/rfc/rfc2396.txt 

---

### isZip

Returns true if value is a valid US ZIP, false otherwise.

```php
Inspekt::isZip( mixed $value ): boolean
```



* This method is **static**.
**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | **mixed** |  |




---

### noTags

Returns value with all tags removed.

```php
Inspekt::noTags( mixed $value ): mixed
```

This will utilize the PHP Filter extension if available

* This method is **static**.
**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | **mixed** |  |




---

### noTagsOrSpecial

returns value with tags stripped and the chars '"&<> and all ascii chars under 32 encoded as html entities

```php
Inspekt::noTagsOrSpecial( mixed $value ): array|mixed|string
```

This will utilize the PHP Filter extension if available

* This method is **static**.
**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | **mixed** |  |


**Return Value:**

@mixed



---

### noPath

Returns basename(value).

```php
Inspekt::noPath( mixed $value ): mixed
```



* This method is **static**.
**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | **mixed** |  |




---

### escMySQL

Escapes the value given with mysql_real_escape_string

```php
Inspekt::escMySQL( string $value, resource $conn ): mixed
```



* This method is **static**.
**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | **string** |  |
| `$conn` | **resource** | the mysql connection. If none is given, it will use the last link opened,
       per behavior of mysql_real_escape_string |



**See Also:**

* http://php.net/manual/en/function.mysql-real-escape-string.php 

---

### escPgSQL

Escapes the value given with pg_escape_string

```php
Inspekt::escPgSQL( mixed $value, resource $conn = null ): mixed
```

If the data is for a column of the type bytea, use Inspekt::escPgSQLBytea()

* This method is **static**.
**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | **mixed** |  |
| `$conn` | **resource** | the postgresql connection. If none is given, it will use the last link opened,
       per behavior of pg_escape_string |



**See Also:**

* http://php.net/manual/en/function.pg-escape-string.php 

---

### escPgSQLBytea

Escapes the value given with pg_escape_bytea

```php
Inspekt::escPgSQLBytea( mixed $value, resource $conn = null ): mixed
```



* This method is **static**.
**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | **mixed** |  |
| `$conn` | **resource** | the postgresql connection. If none is given, it will use the last link opened,
       per behavior of pg_escape_bytea |



**See Also:**

* http://php.net/manual/en/function.pg-escape-bytea.php 

---

## KeyDoesNotExistException

Class KeyDoesNotExistException



* Full name: \Inspekt\KeyDoesNotExistException
* Parent class: 


## SuperglobalsCage

The SuperglobalsCage object wraps ALL of the superglobals



* Full name: \Inspekt\SuperglobalsCage


### __construct

Enter description here.

```php
SuperglobalsCage::__construct(  ): \Inspekt\SuperglobalsCage
```

..





---

### factory

Enter description here.

```php
SuperglobalsCage::factory( string $config_file = null, boolean $strict = true ): \Inspekt\SuperglobalsCage
```

..

* This method is **static**.
**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$config_file` | **string** |  |
| `$strict` | **boolean** |  |




---

### addAccessor



```php
SuperglobalsCage::addAccessor(  $name )
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$name` | **** |  |




---



--------
> This document was automatically generated from source code comments on 2019-05-10 using [phpDocumentor](http://www.phpdoc.org/) and [cvuorinen/phpdoc-markdown-public](https://github.com/cvuorinen/phpdoc-markdown-public)
