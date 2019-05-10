# Inspekt user documentation 
[inspekt.org](http://inspekt.org)

## What is Inspekt 
Inspekt is an input filtering and validation library for PHP.

### Driving principles behind Inspekt 
1. Accessing user input via the PHP superglobals is inherently dangerous, because the "default" action is to retrieve raw, potentially dangerous data 
2. Piecemeal, "inline" filtering/validation done at various places in an application's source code is too error-prone to be effective 3.  The purpose of a library or framework is to make a programmer's job easier. Verbose and/or complex solutions should be avoided unless they are the *only* solution.

### Features of Inspekt
'Cage' objects that encapsulate input and require the coder to use the provided filtering and validation methods to access input data 
* Automatic application of filtering as defined in a configuration file 
* A library of static filtering and validation methods 
* A simple, clear API with No external dependencies 


## Basic Usage 
Here's a simple example of the most common way to use Inspekt. Here we: 
1. Require the library 
2. Create an [`Inspekt_Supercage`](#supercage) to wrap all input inside [`Inspekt_Cage`](#cage) objects 
3. Check to see if the 'userid' value from the POST input is an integer 
* If so, $userid is assigned the value and it's inserted into a database 
* If not, an error is triggered



### Example


```
// require the inspekt library
require "Inspekt.php";

// create a "SuperCage" to wrap all possible user input
// the SuperCage should be created before doing *anything* else
$input = Inspekt::makeSuperCage();

// we need to ensure that $_POST['userid'] is an integer
if ($userid = $input->post->testInt('userid')) {
    /* do stuff with $userid */
    $db->insert("id={$userid}");
} else {
    trigger_error('$userid input is invalid', E_USER_ERROR);
}

```

## Filtering and Validating Input with Input Cages 
`Inspekt_Cage`
objects take an array of data and encapsulate it, so the values in the array can only be accessed through the methods of the `Input_Cage` object. The original array is destroyed by default, so the data *must* be accessed via the cage object's methods. 


### Example

```
// Example: creating a cage for $_POST
require_once "Inspekt.php";

$cage_POST = Inspekt::makePostCage();
$userid = $cage_POST->getInt('userid');

if ( !isset($_POST['userid']) ) {
    echo 'Cannot access input via $_POST -- use the cage object';
}
```

### List of input cage creation methods 
Inspekt provides static methods for quickly creating cages for each of PHP's input superglobals.
These include: 
`Inspekt::makeGetCage()`
 Returns an Inspekt_Cage for the `$_GET` array
`Inspekt::makePostCage()`
 Returns an Inspekt_Cage for the `$_POST` array
`Inspekt::makeCookieCage()`
 Returns an Inspekt_Cage for the `$_COOKIE` array
`Inspekt::makeServerCage()`
 Returns an Inspekt_Cage for the `$_SERVER` array
`Inspekt::makeFilesCage()`
 Returns an Inspekt_Cage for the `$_FILES` array
`Inspekt::makeEnvCage()`
 Returns an Inspekt_Cage for the `$_ENV` array 

### List of test and filter methods 
Cage objects have several methods for examining and filtering values. These include:

 **Filters**
 Filter methods remove data from the value of the given key and return what remains. If the key does not exist, they return FALSE

`getAlnum` (mixed $key)

`getAlpha` (mixed $key)

`getDigits` (mixed $key)

`getDir` (mixed $key)

`getInt` (mixed $key)

`getPath` (mixed $key)

`getRaw` (string $key)

`noPath` (mixed $key)

`noTags` (mixed $key)


**Testers**
Tester methods return the value of the given key on pass, and FALSE on fail or if key fails 

`testAlnum` (mixed $key)

`testAlpha` (mixed $key)

`testBetween` (mixed $key, mixed $min, mixed $max, [boolean $inc = TRUE])

`testCcnum` (mixed $key, [mixed $type = NULL])

`testDate` (mixed $key)

`testDigits` (mixed $key)

`testEmail` (mixed $key)

`testFloat` (mixed $key)

`testGreaterThan` (mixed $key, [mixed $min = NULL])

`testHex` (mixed $key)

`testHostname` (mixed $key, [integer $allow = ISPK_HOST_ALLOW_ALL] 

`testInt` (mixed $key)

`testIp` (mixed $key)

`testLessThan` (mixed $key, [mixed $max = NULL])

`testOneOf` (mixed $key, [ $allowed = NULL])

`testPhone` (mixed $key, [ $country = 'US'])

`testRegex` (mixed $key, [mixed $pattern = NULL])

`testUri` (unknown_type $key)

`testZip` (mixed $key)

**Other**

`keyExists` (mixed $key) 


### Using the Supercage 
The `Inspekt_Supercage` is a single object that contains [`Inspekt_Cage`](#cage)s for each PHP input superglobal. Inspekt provides a static method to create a Supercage:
`Inspekt::makeSuperCage()`
Returns an `Inspekt_Supercage`

The `Inspekt_Supercage` object has 7 public properties: 

`get` an `Inspekt_Cage` wrapping the `$_GET` array 

`post` an `Inspekt_Cage` wrapping the `$_POST` array 

`cookie` an `Inspekt_Cage` wrapping the `$_COOKIE` array 

`server` an `Inspekt_Cage` wrapping the `$_SERVER` array 

`files` an `Inspekt_Cage` wrapping the `$_FILES` array 

`env` an `Inspekt_Cage` wrapping the `$_ENV` array 
 



### Example

```
// make a supercage and assign it to $input
$input = Inspekt::makeSuperCage();

// get email_addr from $_GET if it is a valid email, or trigger an error
if ($email_addr = $input->get->testEmail('email_addr')) {
    echo "valid email address";
} else {
    trigger_error('invalid email address', E_USER_ERROR);
}
```

### Predefined filtering with configuration files The
`Inspekt::makeSuperCage()` method optionally takes a path to a configuration file. The config file defines a set of filters to apply globally and/or to a specific input parameter. Filters defined in a configuration file are applied immediately, and are *destructive* – they will alter the value stored inside the Supercage.  


### Example

```
; FILENAME: config.ini

[_POST]
*=noTags,getAlnum       ; * means apply to all values in this input array
username=getAlpha       ; apply getAlpha automatically to username
userid=getInt           ; apply getInt automatically to userid
```

```
// for the sake of this example, plug-in some values
$_POST['userid'] = '--1234';
$_POST['username'] = 'se77777enty_five!';

// create a supercage and pass it a config file path
$sc = Inspekt::makeSuperCage('./config.ini');

// displays "1234" -- the value has been altered
echo $sc->post->getRaw('userid');   
```

### "Array Path" queries for multidimensional arrays 
Inspekt uses a special kind of formatting to make it easier to grab an arbitrary key from a deep multidimensional array. Let's take a form example like this:

### Example

```
    <form action="formtest.php" method="POST">
        <h3>Enter 5 email addresses</h3>
        <input type="text" name="email_addresses[group1][a]" value="foo1@bar.com" /><br />
        <input type="text" name="email_addresses[group1][b]" value="foo2@bar.com" /><br />
        <input type="text" name="email_addresses[group1][c]" value="foo3@bar.com" /><br />
        <input type="text" name="email_addresses[group2][a]" value="foo4@bar.com" /><br />
        <input type="text" name="email_addresses[group2][b]" value="foo5@bar.com" /><br />
        <input type="text" name="email_addresses[group3][a]" value="foo6@bar.com" /><br />
        <input type="text" name="email_addresses[group3][b]" value="foo7@bar.com" /><br />
        
        <input type="submit" name="submit" value="Go!" id="submit" />
    </form>
```

We could test a particular entry with the following code:

```
$input = Inspekt::makeSuperCage();

if ($email = $input->post->testEmail('/email_addresses/group3/a')) {
    echo $email;
} else {
    echo "invalid address";
}
```

Notes on array path querying: 
The forward slash "/" is the separator, so you can't access keys where you're using that character

Any numeric keys are converted to integers, so you can't access keys that are numeric strings

All queries must include the full path from the root of the array 

Leading and trailing slashes are ignored. These are all equivalent: 
 '/x/woot/booyah/'\
 '/x/woot/booyah'\
 'x/woot/booyah/'\
 'x/woot/booyah' 


### Dealing with different scopes 
PHP's superglobals are convenient in that they maintain a global scope without the need to declare then as globals in each function. PHP unfortunately does not allow user-defined superglobals, All of the `Inspekt::make*Cage()` methods utilize a singleton pattern. This means the developer does not have to pass the cage object to and from functions, or use the global keyword, to access it outside the global scope. Just use the make Cage() method to access the same object you created in a different scope. 


### Example

```
function foo() {
    $cage_foo = Inspekt::makeServerCage();
    return $cage_foo;
}

// All of these return the *same object*
$cage1 = Inspekt::makeServerCage();
$cage2 = foo();
$cage3 = Inspekt::makeServerCage();

// outputs bool(true)
var_dump($cage1 === $cage2 && $cage2 === $cage3);   
```

```
// make an inspekt post cage
$cage_POST = Inspekt::makePostCage();
echo "In MAIN: ";
echo var_dump($cage_POST->getInt('userid'));
echo "\n"; /** * first level of scoping */ function testScoping() {
testScoping2(); } /** * second level of scoping */ function
testScoping2() { // this returns the same object we created on line 2
$cage_POST = Inspekt::makePostCage(); echo "

    In " . __FUNCTION__."(): ";
        echo var_dump($cage_POST->getInt('userid'));
        echo "

\n"; } // test the singleton pattern testScoping();
```

## Filtering non-superglobal arrays 
You can wrap any array in an `Inspekt_Cage`, not just superglobals.  


### Example

```
// Example: wrap an arbitrary array in a cage
$d = array();
$d['input'] = '<img id="475">yes</img>';
$d[] = array('foo', 'bar<br />', 'yes<P>', 1776);
$d['x']['woot'] = array('booyah'=>'meet at the bar at 7:30 pm',
                        'ultimate'=>'<strong>hi there!</strong>',
                        );

// create our cage object
$d_cage = Inspekt_Cage::Factory($d);

// return the value of 'input', stripped of html tags
$input = $d_cage->noTags('input');

// get a portion of the array, with all non-alphanumeric chars stripped from values
$x = $d_cage->getAlnum('x');

/*
displays:
array (
  'woot' => 
  array (
    'booyah' => 'meetatthebaratpm',
    'ultimate' => 'stronghitherestrong',
  ),
)
*/
var_export($x); 
```

## Using static methods 
Inspekt also provides a library of filtering and validation methods that can be called statically. In cases where a simple one-off check makes more sense, you can use these instead of creating an `Inspekt_Cage` or `Inspekt_Supercage` object.



### Example

```
// static validation
if (Inspekt::isEmail($email))   {
    sendMail($email, 'Test Email', $msg);
} else {
    trigger_error('Email address not valid – could not send', E_USER_WARNING);
}

// static filtering
$phone_number = '(765) 555-1234';
$phone_number_digits = Inspekt::getDigits($phone_number);
echo $phone_number_digits; // outputs '7655551234';
```

### List of static filters and validators 
**Validators**
`Inspekt::isAlnum` (mixed $value)

`Inspekt::isAlpha` (mixed $value)

`Inspekt::isBetween` (mixed $value, mixed $min, mixed $max, [ $inc = TRUE])

`Inspekt::isCcnum` (mixed $value, [mixed $type = NULL])

`Inspekt::isDate` (mixed $value)

`Inspekt::isDigits` (mixed $value)

`Inspekt::isEmail` (string $value)

`Inspekt::isFloat` (string $value)

`Inspekt::isGreaterThan` (mixed $value, mixed $min)

`Inspekt::isHex` (mixed $value)

`Inspekt::isHostname` (mixed $value, [integer $allow = ISPK_HOST_ALLOW_ALL])

`Inspekt::isInt` (mixed $value)

`Inspekt::isIp` (mixed $value)

`Inspekt::isLessThan` (mixed $value, mixed $max)

`Inspekt::isOneOf` (mixed $value, [ $allowed = NULL])

`Inspekt::isPhone` (mixed $value, [ $country = 'US'])

`Inspekt::isRegex` (mixed $value, [mixed $pattern = NULL])

`Inspekt::isUri` (string $value, [integer $mode = ISPK_URI_ALLOW_COMMON])

`Inspekt::isZip` (mixed $value)


**Filters** 

`Inspekt::getAlnum` (mixed $value)

`Inspekt::getAlpha` (mixed $value)

`Inspekt::getDigits` (mixed $value)

`Inspekt::getDir` (mixed $value)

`Inspekt::getInt` (mixed $value)

`Inspekt::getPath` (mixed $value)

`Inspekt::noPath` (mixed $value)

`Inspekt::noTags` (mixed $value)
