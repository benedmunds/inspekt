# Inspekt

### License
[LICENSE](https://github.com/benedmunds/inspekt/LICENSE)

### Maintained by
Ben Edmunds
[benedmunds.com](http://benedmunds.com)

### Created by
Ed Finkler    
<coj@funkatron.com>     

**Version 0.6.0**
**2015-09-23**


## What Is Inspekt?

Inspekt is a comprehensive filtering and validation library for PHP.

## Driving principles behind Inspekt

* Accessing user input via the PHP superglobals is inherently dangerous, because the "default" action is to retrieve raw, potentially dangerous data
* Piecemeal, "inline" filtering/validation done at various places in an application's source code is too error-prone to be effective
* The purpose of a library or framework is to make a programmer's job easier. Verbose and/or complex solutions should be avoided unless they are the only solution

## Features of Inspekt

* 'Cage' objects that encapsulate input and require the develop to use the provided filtering and validation methods to access input data
* Automatic application of filtering as defined in a configuration file
* A library of static filtering and validation methods
* A simple, clear API
* No external dependencies


## How Do I Use Inspekt?

The best idea at the moment is to look at the `Examples` directory.

### Quickly creating a cage for common input superglobals

```php
<?php
use Inspekt\Inspekt;

/*
 * creates a cage for $_GET, $_POST, $_COOKIE, $_ENV, $_FILES, $_SERVER
 */
$superCage = Inspekt::makeSuperCage();

echo 'Digits:' . $superCage->server->getDigits('SERVER_SOFTWARE') . '<p/>';
echo 'Alpha:' . $superCage->server->getAlpha('SERVER_SOFTWARE') . '<p/>';
echo 'Alnum:' . $superCage->server->getAlnum('SERVER_SOFTWARE') . '<p/>';
echo 'Raw:' . $superCage->server->getRaw('SERVER_SOFTWARE') . '<p/>';
```

### Creating a cage from an arbitrary array

```php
<?php
/**
 * Demonstration of:
 * - use of static filter methods on arrays
 * - creating a cage on an arbitrary array
 * - accessing a deep key in a multidim array with the "Array Query" approach
 */


require_once dirname(__FILE__) . "/../vendor/autoload.php";

use Inspekt\Cage;

$d = array();
$d['input'] = '<img id="475">yes</img>';
$d['lowascii'] = '    ';
$d[] = array('foo', 'bar<br />', 'yes<P>', 1776);
$d['x']['woot'] = array(
    'booyah' => 'meet at the bar at 7:30 pm',
    'ultimate' => '<strong>hi there!</strong>',
);
$d['lemon'][][][][][][][][][][][][][][] = 'far';


$d_cage = Cage::Factory($d);

var_dump($d_cage->getAlpha('/x/woot/ultimate'));

var_dump($d_cage->getAlpha('lemon/0/0/0/0/0/0/0/0/0/0/0/0/0'));

$x = $d_cage->getAlpha('x');
var_dump($x);

$x = $d_cage->getAlpha('input');
var_dump($x);
```

### Calling an individual validation method

```php
<?php
require_once dirname(__FILE__) . "/../vendor/autoload.php";

use Inspekt\Inspekt;

$rs = Inspekt::isUri('http://www.w3.org/2001/XMLSchema');
var_dump($rs);
```

## Documentation

[User Docs](https://github.com/benedmunds/inspekt/docs/USER.md)
[API Docs](https://github.com/benedmunds/inspekt/docs/API.md)



## How Do I Run Tests

Install PHPUnit, cd to the root dir of Inspekt, and type

> phpunit tests/



## Changelog ##

### Version 0.6.0 - 2014-11-08 ###

- Backwards-compatibility breaks! Be aware! Read examples!
- removed CodeIgniter helper
- removed all session cage code
- refactor for PSR2 compliance, **including namespaces** (BC BREAK)
- drop mysql for mysqli escaping calls

### 2014-04-14 ###

- Added composer.json file


### Version 0.4.1 - 2010-01-15 ###
- Inspekt_Cage::keyExists now returns boolean again, unless second param is TRUE (then it returns the value if key exists)
- fixed a bunch of missing public/protected definitions
- renamed Inspekt_CageTest.php to CageTest.php so phpunit would load it correctly
- wrote a couple unit tests for Inspekt_Cage::testAlnum



### Version 0.4.0 - 2009-11-15 ###

- added new way to add cage accessor methods by extending `AccessorAbstract` and registering with cage object
- added `Inspekt_Cage::addAccessor()` and `Inspekt_SuperCage::addAccessor()`
- modified `Examples/extending.php` to demonstrate adding new accessor methods
- added `HTMLPurifier` integration capability and new cage filter `getPurifiedHTML()`
- added a library for [CodeIgniter](http://codeigniter.com) to use `Inspekt` in the standard Input object
- make `Inspekt::isArrayObject()` and `Inspekt::isArrayOrArrayObject()` public
- added `__call()` to Inspekt_Cage so we can handle user-defined accessor methods
- added underscore to path portion of `isUri()` (Nick Ramsay)
- added a new folder for `Integration_helpers`
- commented out include for `Inspekt/Cage/Session` in `Cage.php` because it caused probs generating Cage test skeleton
- made PHPUnit `Inspekt_Cage` test skeleton
- added simple example for a wrapper that will pull from `GET` or `POST`



### Version 0.3.5 - 2009-07-18 ###


- refactored and reworked some examples; added db escaping examples
- did some work to get isInt to handle 64 bit integers better (more to do)
- fixed bug in `isOneOf` where a string pattern wasn't converted properly
- removed some incorrectly optional params for methods
- isRegex now correctly returns a boolean, not an Int
- added missing cage methods `getROT13`, `noTagsOrSpecial`, `escMySQL`, `escPgSQL`, `escPgSQLBytea`
- added many more unit tests


### Version 0.3.4 - 2009-07-18 ###

- Added `Inspekt::getROT13()`
- Added `Inspekt::escMySQL()`
- Added `Inspekt::escPgSQL()`
- Added `Inspekt::escPgSQLBytea()`
- Now arrays are only converted to `ArrayObjects` by cages; arrays passed into static filter calls are returned as arrays.
- More unit tests, and tests moved into `InspektTest.php` (removed Tests/ subdir)
- cleanup in `Inspekt_SuperCage` to fix `STRICT` notices

### Version 0.3.3 - 2009-07-18 ###

- Caged properties can now be iterated over b/c we're implementing `ArrayObject` (Matt McKeon)
- added a number of @assert tests for phpunit testing
- cleaned up function declarations so they would not raise STRICT notices
- leveraged Filter Extention in a couple filter methods; can be turned off with `Inspekt::useFilterExt()`
- added filter method Inspekt::noTagsOrSpecial() that strips tags, encodes 
`'"&<>`, and all low ascii chars (< 32)
- upped recursion limit to 15
- `Inspekt::_walkArray` will now convert a plain array into an ArrayObject (should it always? Not sure)
- filter methods will now use `Inspekt::isArrayOrArrayObject()` to determine if 
they need to walk the array
- fixed some require_once statements to use `dirname()` resolution so fewer path issues pop up (they showed up when using phpunit)

### Version 0.3.2 - 2009-06-22 ###

PHP5 now required, bug fixes for transposed params

### Version 0.3.1 - 2008-02-08 ###

Disables processing of `$_SESSION`

### Version 0.3.0 - 2008-01-16 ###

Final OWASP milestone release

### Version 0.1 - 2007-05-19 ###
Initial Release
