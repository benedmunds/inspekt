# Inspekt

*now on github!*

_see LICENSE for copyright and license info_

Ed Finkler    
<coj@funkatron.com>    
<http://inspekt.org>    
<http://github.com/funkatron/inspekt>    

**Version 0.4.1**
**2010-01-15**


### What Is Inspekt?

Inspekt is a comprehensive filtering and validation library for PHP.

Initial development of Inspekt was funded by OWASP's Spring of Code 2007.
<http://owasp.org>


### How Do I Use Inspekt?

Check the user docs at
http://funkatron.com/inspekt/user_docs or the API docs at
http://funkatron.com/inspekt/api_docs

### How Do I Run Tests

Install PHPUnit, cd to the root dir of Inspekt, and type

> phpunit InspektTest



### How Can I Contribute, Offer Feedback, Report Bugs, Complain, Etc.?

Visit the Github site for Inspekt at <http://github.com/funkatron/inspekt>


## Changelog ##


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
