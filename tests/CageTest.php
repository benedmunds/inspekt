<?php

use Inspekt\Inspekt;
use Inspekt\Cage;

/**
 * Test class for Cage.
 */
class CageTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var    Cage
     */
    protected $cage;

    /**
     * @var  string
     */
    protected $assetPath;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @access protected
     */
    protected function setUp()
    {
        $inputarray['html'] = '<IMG """><SCRIPT>alert("XSS")</SCRIPT>">';
        $inputarray['int'] = 7;
        $inputarray['char'] = 'f';
        $inputarray['input'] = '<img id="475">yes</img>';
        $inputarray['to_int'] = '109845 09471fjorowijf blab$';
        $inputarray['lowascii'] = '    ';
        // access this with index 0
        $inputarray[] = array('foo', 'bar<br />', 'yes<P>', 1776);
        $inputarray['x']['woot'] = array(
            'booyah' => 'meet at the bar at 7:30 pm',
            'ultimate' => '<strong>hi there!</strong>',
        );
        $inputarray['lemon'][][][][][][][][][][][][][][] = 'far';
        $inputarray['zero'] = '0';
        $inputarray['zeroint'] = 0;
        $this->cage = Cage::Factory($inputarray);
        $this->assetPath = dirname(__FILE__) . '/assets';
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     *
     * @access protected
     */
    protected function tearDown()
    {
        $_GET = array();
        $_POST = array();
    }

    /**
     */
    public function testFactory()
    {
        $foo = array('blazm'=>'bar', 'blau'=>'baz');
        $cage = Cage::factory($foo);
        $this->assertSame('Inspekt\Cage', get_class($cage));
    }

    /**
     */
    public function testGetIterator()
    {
        $foo = array('blazm'=>'bar', 'blau'=>'baz');
        $cage = Cage::factory($foo);
        $iter = $cage->getIterator();
        $this->assertSame('ArrayIterator', get_class($iter));
    }

    /**
     */
    public function testOffsetSet()
    {
        $foo = array('blazm'=>'bar', 'blau'=>'baz');
        $cage = Cage::factory($foo);
        $cage->offsetSet('foo', 'bar');
        $expected = $cage->getRaw('foo');

        $this->assertSame('bar', $expected);
    }

    /**
     */
    public function testOffsetExists()
    {
        $foo = array('blazm'=>'bar', 'blau'=>'baz');
        $cage = Cage::factory($foo);
        $cage->offsetSet('foo', 'bar');
        $this->assertTrue($cage->offsetExists('blazm'));
        $this->assertTrue($cage->offsetExists('blau'));
        $this->assertTrue($cage->offsetExists('foo'));
        $this->assertFalse($cage->offsetExists('nope'));
    }

    /**
     */
    public function testOffsetUnset()
    {
        $foo = array('blazm'=>'bar', 'blau'=>'baz');
        $cage = Cage::factory($foo);
        $cage->offsetSet('foo', 'bar');
        $expected = $cage->getRaw('foo');

        $this->assertSame('bar', $expected);

        $cage->offsetUnset('foo');
        $this->assertFalse($cage->offsetExists('for'));
    }

    /**
     */
    public function testOffsetGet()
    {
        $foo = array('foo'=>'bar');
        $cage = Cage::factory($foo);
        $this->assertSame('bar', $cage->offsetGet('foo'));
    }

    /**
     */
    public function testCount()
    {
        $foo = array('foo'=>'bar', 'bar'=>'baz');
        $cage = Cage::factory($foo);
        $this->assertSame(2, $cage->count());
    }

    /**
     */
    public function testGetSetHTMLPurifier()
    {
        $hp = new \HTMLPurifier();
        $foo = array('foo'=>'bar', 'bar'=>'baz');
        $cage = Cage::factory($foo);
        $cage->setHTMLPurifier($hp);
        $this->assertTrue($cage->getHTMLPurifier() instanceof \HTMLPurifier);
    }


    /**
     */
    public function testParseAndApplyAutoFilters()
    {
        $foo = array(
            'userid'=>'--12<strong>34</strong>',
            'username'=>'se777v77enty_<em>fiv</em>e!',
        );
        $config_file = $this->assetPath . '/config_cage.ini';
        $cage = Cage::factory($foo, $config_file);

        $this->assertTrue(1234 === ($cage->getRaw('userid')));
        $this->assertTrue('seventyfive' === ($cage->getRaw('username')));
    }


    /**
     *
     */
    public function testAddAccessor()
    {
        //pre-condition, clean start
        $this->assertSame($this->cage->user_accessors, array());
        $this->cage->addAccessor('method_name');
        $this->assertSame($this->cage->user_accessors, array('method_name'));
    }

    /**
     */
    public function testGetAlpha()
    {
        /**
         * $inputarray['x']['woot'] = array(
         *     'booyah' => 'meet at the bar at 7:30 pm',
         */
        $this->assertSame('meetatthebaratpm', $this->cage->getAlpha('x/woot/booyah'));
    }

    /**
     */
    public function testGetAlnum()
    {
        /**
         * $inputarray['x']['woot'] = array(
         *     'booyah' => 'meet at the bar at 7:30 pm',
         */
        $this->assertSame('meetatthebarat730pm', $this->cage->getAlnum('x/woot/booyah'));
    }

    /**
     */
    public function testGetDigits()
    {
        /**
         * $inputarray['x']['woot'] = array(
         *     'booyah' => 'meet at the bar at 7:30 pm',
         */
        $this->assertSame('730', $this->cage->getDigits('x/woot/booyah'));
    }

    /**
     */
    public function testGetDir()
    {
        $input = array('fullpath' => '/usr/lib/php/Pear.php');
        $cage = Cage::factory($input);
        $this->assertSame(
            '/usr/lib/php',
            $cage->getDir('fullpath')
        );
    }

    /**
     *
     */
    public function testGetInt()
    {
        /**
         * 109845 09471fjorowijf blab$
         */
        $this->assertSame(109845, $this->cage->getInt('to_int'));
        $this->assertSame(0, $this->cage->getInt('zero'));
        $this->assertSame(0, $this->cage->getInt('zeroint'));
    }

    /**
     *
     */
    public function testGetInt2()
    {
        $this->assertSame($this->cage->getInt('int'), 7);
    }

    /**
     */
    public function testGetPath()
    {
        $old_cwd = getcwd();

        $path_array = array(
            'one' => './',
            'two' => './../../',
        );

        $cage = Cage::factory($path_array);

        chdir(dirname(__FILE__));

        $expected = dirname(__FILE__);
        $this->assertSame($cage->getPath('one'), $expected);

        $expected = dirname(dirname(dirname(__FILE__)));
        $this->assertSame($cage->getPath('two'), $expected);

        chdir($old_cwd);
    }

    /**
     */
    public function testGetROT13()
    {
        $this->assertSame('<vzt vq="475">lrf</vzt>', $this->cage->getROT13('input'));
    }

    /**
     */
    public function testGetPurifiedHTML()
    {
        $inputarray['html'] = array(
            'xss' => '<IMG """><SCRIPT>alert("XSS")</SCRIPT>">',
            'bad_nesting' => '<p>This is a malformed fragment of <em>HTML</p></em>',
        );

        $cage = Cage::Factory($inputarray);
        $cage->loadHTMLPurifier();

        $this->assertSame("\"&gt;", $cage->getPurifiedHTML('html/xss'));
        $this->assertSame(
            "<p>This is a malformed fragment of <em>HTML</em></p>",
            $cage->getPurifiedHTML('html/bad_nesting')
        );
    }

    /**
     * @expectedException \Inspekt\KeyDoesNotExistException
     */
    public function testGetRaw()
    {
        $this->cage->getRaw('non-existant');
        $this->assertSame('0', $this->cage->getRaw('zero'));
        $this->assertSame(0, $this->cage->getRaw('zeroint'));
    }

    /**
     *
     */
    public function testGetRaw2()
    {
        //test that found key returns matching value
        $this->assertEquals(
            $this->cage->getRaw('html'),
            '<IMG """><SCRIPT>alert("XSS")</SCRIPT>">'
        );
    }

    /**
     *
     */
    public function testTestAlnum()
    {
        $_POST = array();
        $_POST['b'] = '0';
        $cage_POST = Inspekt::makePostCage();
        $result = $cage_POST->testAlnum('b');
        $this->assertSame('0', $result);
    }

    /**
     *
     */
    public function testTestAlnum2()
    {
        $_POST = array();
        $_POST['b'] = '2009-12-25';
        $cage_POST = Inspekt::makePostCage();
        $result = $cage_POST->testGreaterThan('b', 25);
        $this->assertSame(false, $result);
    }

    /**
     *
     */
    public function testTestAlnum3()
    {
        $_POST = array();
        $_POST['b'] = '0';
        $cage_POST = Inspekt::makePostCage();
        $result = $cage_POST->testLessThan('b', 25);
        $this->assertSame('0', $result);
    }

    /**
     */
    public function testTestAlpha()
    {
        $input = array(
            'values' => array(
                'input' => '0qhf01 *#R& !)*h09hqwe0fH! )efh0hf',
                'one' => '1241DOSLDH',
                'two' => 'efoihr123-',
                'three' => 'eoeijfol',
            ),
            'allgood' => array(
                'input' => 'asldifjlaskjg',
                'one' => 'wptopriowtg',
                'two' => 'WROIFWLVN',
                'three' => 'eoeijfol',
            )
        );
        $cage = Cage::factory($input);

        $this->assertFalse($cage->testAlpha('values/input'));
        $this->assertFalse($cage->testAlpha('values/one'));
        $this->assertFalse($cage->testAlpha('values/two'));
        $this->assertSame('eoeijfol', $cage->testAlpha('values/three'));

        $this->assertFalse($cage->testAlpha('allgood'));
    }

    /**
     */
    public function testTestBetween()
    {
        $this->assertSame(7, $this->cage->testBetween('int', 0, 7, true));
        $this->assertFalse($this->cage->testBetween('int', 0, 7, false));
        $this->assertSame(7, $this->cage->testBetween('int', '0', '7', true));
        $this->assertFalse($this->cage->testBetween('int', '0', '7', false));
        $this->assertSame('f', $this->cage->testBetween('char', 'a', 'm', false));
        $this->assertFalse($this->cage->testBetween('char', 'a', 'f', false));
        $this->assertSame('f', $this->cage->testBetween('char', 'a', 'f', true));
        $this->assertSame('f', $this->cage->testBetween('char', 'f', 'f', true));
        $this->assertFalse($this->cage->testBetween('char', 'f', 'f', false));
    }

    /**
     */
    public function testTestCcnum()
    {
        $ccnums = array(
            '378282246310005',  // American Express
            '371449635398431',  // American Express
            '378734493671000',  // American Express Corporate
            '5610591081018250',  // Australian BankCard
            '30569309025904',  // Diners Club
            '38520000023237',  // Diners Club
            '3530111333300000',  // JCB
            '5105105105105100',  // MasterCard
            '4222222222222',  // Visa
        );

        $bad_ccnums = array(
            '078282246310005',
            '071449635398431',
            '078734493671000',
            '0610591081018250',
            '00569309025904',
            '08520000023237',
            '0011111111111120',
            '0011000990139420',
            '0530111333300000',
            '0566002020360500',
            '0555555555554440',
            '0105105105105100',
            '0111111111111110',
            '0012888888881880',
            '0222222222222',
            '06009244561',
            '0019717010103740',
            '0331101999990020',
        );

        $cc_count = count($ccnums);
        $cage = Cage::factory($ccnums, null, null, false);
        for ($x = 0; $x < $cc_count; $x++) {
            $this->assertSame($ccnums[$x], $cage->testCcnum($x));
        }

        $cc_count = count($bad_ccnums);
        $cage = Cage::factory($bad_ccnums, null, null, false);
        for ($x = 0; $x < $cc_count; $x++) {
            $this->assertFalse($cage->testCcnum($x));
        }
    }

    /**
     */
    public function testTestDate()
    {
        $dates = array(
            'valid1' => '2009-06-30',
            'valid2' => '2009-6-30',
            'valid3' => '2-6-30',
            'invalid1' => '2009-06-31',
        );
        $cage = Cage::factory($dates);
        $this->assertSame('2009-06-30', $cage->testDate('valid1'));
        $this->assertSame('2009-6-30', $cage->testDate('valid2'));
        $this->assertSame('2-6-30', $cage->testDate('valid3'));
        $this->assertFalse($cage->testDate('invalid1'));
    }

    /**
     */
    public function testTestDigits()
    {
        $digits = array(
            'invalid1' => '1029438750192730t91740987023948',
            'valid1' => '102943875019273091740987023948',
            'integer' => 102943875019273091740987023948,
        );
        $cage = Cage::factory($digits);

        $this->assertFalse($cage->testDigits('invalid1'));
        $this->assertSame('102943875019273091740987023948', $cage->testDigits('valid1'));
        $this->assertFalse($cage->testDigits('integer'));
    }

    /**
     */
    public function testTestEmail()
    {
        $input = array(
            'foo1' => 'coj@poop.com',
            'foo2' => 'coj+booboo@poop.com',
            'foo3' => 'coj!booboo@poop.com',
            'foo4' => '@poop.com',
            'foo5' => 'a@b',
            'foo6' => 'webmaster',
        );
        $cage = Cage::factory($input);
        $expect = 'coj@poop.com';
        $this->assertSame($expect, $cage->testEmail('foo1'));
        $expect = 'coj+booboo@poop.com';
        $this->assertSame($expect, $cage->testEmail('foo2'));
        $this->assertFalse($cage->testEmail('foo3'));
        $this->assertFalse($cage->testEmail('foo4'));
        $this->assertFalse($cage->testEmail('foo5'));
        $this->assertFalse($cage->testEmail('foo6'));
    }

    /**
     */
    public function testTestFloat()
    {
        $locale = localeconv();
        $thousands_sep = $locale['thousands_sep'];

        $input = array(
            'foo1' => 1.1,
            'foo2' => -4095823.11,
            'foo3' => '1.1',
            'foo4' => '-4095823.11',
            'foo5' => '-4095823',
            'foo6' => '5', // ints are valid as floats
            'foo7' => "92{$thousands_sep}096{$thousands_sep}821.120494",
        );
        $cage = Cage::factory($input);
        $this->assertSame(1.1, $cage->testFloat('foo1'));
        $this->assertSame(-4095823.11, $cage->testFloat('foo2'));
        $this->assertSame('1.1', $cage->testFloat('foo3'));
        $this->assertSame('-4095823.11', $cage->testFloat('foo4'));
        $this->assertSame('-4095823', $cage->testFloat('foo5'));
        $this->assertSame('5', $cage->testFloat('foo6'));
        $this->assertSame(
            "92{$thousands_sep}096{$thousands_sep}821.120494",
            $cage->testFloat('foo7')
        );
    }

    /**
     */
    public function testTestGreaterThan()
    {
        $input = array(
            'foo' => 'c'
        );
        $cage = Cage::factory($input);
        $expect = 'c';
        $this->assertSame($expect, $cage->testGreaterThan('foo', 'a'));
        $this->assertFalse($cage->testGreaterThan('foo', 'c'));
    }

    /**
     */
    public function testTestHex()
    {
        $input = array(
            'foo1' => 'a0',
            'foo2' => 'FF',
            'foo3' => 'F',
            'foo4' => 'S',
        );
        $cage = Cage::factory($input);
        $this->assertSame('a0', $cage->testHex('foo1'));
        $this->assertSame('FF', $cage->testHex('foo2'));
        $this->assertSame('F', $cage->testHex('foo3'));
        $this->assertFalse($cage->testHex('foo4'));
    }

    /**
     */
    public function testTestHostname()
    {
        $input = array(
            'foo1' => '192.168.1.1',
            'foo2' => 'en.wikipedia.org',
            'foo3' => 'en.wiki_pedia.org',
            'foo4' => 'ουτοπία.δπθ.gr',
        );
        $cage = Cage::factory($input);
        $this->assertSame('192.168.1.1', $cage->testHostname('foo1'));
        $this->assertSame('en.wikipedia.org', $cage->testHostname('foo2'));
        $this->assertFalse($cage->testHostname('foo3'));
        // intl domains not supported
        $this->assertFalse($cage->testHostname('foo4'));
    }

    /**
     */
    public function testTestInt()
    {
        $locale = localeconv();
        $thousands_sep = $locale['thousands_sep'];

        $input = array(
            'foo1' => '7',
            'foo2' => 7,
            'foo3' => -7,
            'foo4' => 0,
            'foo5' => false,
            'foo6' => true,
            'foo7' => 'a0',
            'foo8' => 135902096821.0, // this is an integer!
            'foo9' => 135902096821.1,
            'foo10' => "135{$thousands_sep}902{$thousands_sep}096{$thousands_sep}821",
        );
        $cage = Cage::factory($input);

        $this->assertSame('7', $cage->testInt('foo1'));
        $this->assertSame(7, $cage->testInt('foo2'));
        $this->assertSame(-7, $cage->testInt('foo3'));
        $this->assertSame(0, $cage->testInt('foo4'));
        $this->assertSame(false, $cage->testInt('foo5'));
        $this->assertSame(false, $cage->testInt('foo6'));
        $this->assertSame(false, $cage->testInt('foo7'));
        $this->assertSame(135902096821.0, $cage->testInt('foo8'));
        $this->assertSame(false, $cage->testInt('foo9'));
        $this->assertSame("135{$thousands_sep}902{$thousands_sep}096{$thousands_sep}821", $cage->testInt('foo10'));
    }

    /**
     */
    public function testTestIp()
    {
        $input = array(
            'foo' => '192.168.1.1',
            'foo2' => '256.168.1.1',
        );
        $cage = Cage::factory($input);
        $expect = '192.168.1.1';
        $this->assertSame($expect, $cage->testIp('foo'));
        $this->assertFalse($cage->testIp('foo2'));
    }

    /**
     */
    public function testTestLessThan()
    {
        $input = array(
            'foo' => 'c'
        );
        $cage = Cage::factory($input);
        $expect = 'c';
        $this->assertSame($expect, $cage->testLessThan('foo', 'd'));
        $this->assertFalse($cage->testLessThan('foo', 'a'));
    }

    /**
     */
    public function testTestOneOf()
    {
        $input = array(
            'foo' => '&'
        );
        $cage = Cage::factory($input);
        $expect = '&';
        $this->assertSame($expect, $cage->testOneOf('foo', '<>\'"&'));
        $this->assertFalse($cage->testOneOf('foo', '<>\'"'));
    }

    /**
     */
    public function testTestPhone()
    {
        $input = array(
            'foo' => '7655559090',
            'bar' => '12345'
        );
        $cage = Cage::factory($input);
        $expect = '7655559090';
        $this->assertSame($expect, $cage->testPhone('foo'));
        $expect = false;
        $this->assertFalse($cage->testPhone('bar'));
    }

    /**
     */
    public function testTestRegex()
    {
        $input = array(
            'foo' => 'username_786'
        );
        $cage = Cage::factory($input);
        $expect = 'username_786';
        $regex = '/^[a-zA-Z0-9_]+$/';
        $this->assertSame($expect, $cage->testRegex('foo', $regex));
        $regex = '/^[a-zA-Z0-9]+$/';
        $this->assertFalse($cage->testRegex('foo', $regex));
    }

    /**
     */
    public function testTestUri()
    {
        $input = array(
            'foo1' => '//lessthan',
            'foo2' => 'ftp://funky7:boooboo@123.444.999.12/',
            // false because '%' indicates the beginning of an encoded char
            'foo3' => 'http://spinaltap.micro.umn.edu/00/Weather/California/Los%lngeles',
            'foo4' => 'http://funkatron.com/////////12341241',
            'foo5' => 'http://funkatron.com:12',
            'foo6' => 'http://funkatron.com:8000/#foo',
            'foo7' => 'https://funkatron.com',
            'foo8' => 'https://funkatron.com:42/funky.php?foo[]=bar',
            'foo9' => 'http://www.w3.org/2001/XMLSchema',
            'foo10' => 'http://www.w3.org/2001/XMLSchema',
        );
        $cage = Cage::factory($input, null, null, false);
        $this->assertSame(false, $cage->testUri('foo1'));
        $this->assertSame($input['foo2'], $cage->testUri('foo2'));
        $this->assertFalse($cage->testUri('foo3'));
        $this->assertSame($input['foo4'], $cage->testUri('foo4'));
        $this->assertSame($input['foo5'], $cage->testUri('foo5'));
        $this->assertSame($input['foo6'], $cage->testUri('foo6'));
        $this->assertSame($input['foo7'], $cage->testUri('foo7'));
        $this->assertSame($input['foo8'], $cage->testUri('foo8'));
        $this->assertSame($input['foo9'], $cage->testUri('foo9'));
        $this->assertSame($input['foo10'], $cage->testUri('foo10'));
    }

    /**
     */
    public function testTestZip()
    {
        $input = array(
            'foo' => '00202',
            'bar' => 'C6D-5F5',
            'baz' => '46544-4142',
        );
        $cage = Cage::factory($input);
        $this->assertSame('00202', $cage->testZip('foo'));
        $this->assertSame(false, $cage->testZip('bar'));
        $this->assertSame('46544-4142', $cage->testZip('baz'));
    }

    /**
     */
    public function testNoTags()
    {
        $input = array(
            'foo' => '<SCRIPT<strong>>alert(\'foobar\');<</strong>/SCRIPT>'
        );
        $cage = Cage::factory($input);
        $expect = 'alert(\'foobar\');';
        $this->assertSame($expect, $cage->noTags('foo'));

    }

    /**
     */
    public function testNoPath()
    {
        $input = array(
            'foo' => './../../../../../../../../../etc/passwd'
        );
        $cage = Cage::factory($input);
        $expect = 'passwd';
        $this->assertSame($expect, $cage->noPath('foo'));
    }

    /**
     */
    public function testNoTagsOrSpecial()
    {
        $input = array(
            'foo' => '    <SCRIPT<strong>>alert(\'foobar\');<</strong>/SCRIPT>'
        );
        $cage = Cage::factory($input);
        $expect = '&#21;&#21;&#21;&#21;&#21;&#21;&#22; &#22; &#22; &#22; alert(&#38;#39;foobar&#38;#39;);';
        $this->assertSame($expect, $cage->noTagsOrSpecial('foo'));
    }

    /**
     * @todo Implement testEscMySQL().
     */
    public function testEscMySQL()
    {
        if (!extension_loaded('mysqli')) {
            $this->markTestSkipped(
                'The MySQLi extension is not available.'
            );
        }
    }

    /**
     * @todo Implement testEscPgSQL().
     */
    public function testEscPgSQL()
    {
        if (!extension_loaded('pgsql')) {
            $this->markTestSkipped(
                'The PGSQL extension is not available.'
            );
        }
    }

    /**
     * @todo Implement testEscPgSQLBytea().
     */
    public function testEscPgSQLBytea()
    {
        if (!extension_loaded('pgsql')) {
            $this->markTestSkipped(
                'The PGSQL extension is not available.'
            );
        }
    }

    /**
     */
    public function testKeyExistsAndRecursive()
    {
        $this->assertTrue($this->cage->keyExists('html'));
        $this->assertTrue($this->cage->keyExists('x/woot'));
        $this->assertTrue($this->cage->keyExists('/x/woot'));
        $this->assertTrue($this->cage->keyExists('/x/woot/ultimate'));
        $this->assertFalse($this->cage->keyExists('/x/woot/0/'));
        $this->assertTrue($this->cage->keyExists(0));
        $this->assertTrue($this->cage->keyExists('lemon/0/0/0/0/0/0/0/0/0/0/0/0/0'));
        $this->assertTrue($this->cage->keyExists('/x/woot/ultimate'));
        $this->assertTrue($this->cage->keyExists('zero'));
        $this->assertTrue($this->cage->keyExists('zeroint'));
    }

    /**
     */
    public function testTestMethodsReturnFalseIfKeyDoesNotExist()
    {
        $this->assertFalse($this->cage->keyExists('/x/woot/0'));
        $this->assertFalse($this->cage->testAlpha('/x/woot/0'));
        $this->assertFalse($this->cage->testAlnum('/x/woot/0'));
        $this->assertFalse($this->cage->testBetween('/x/woot/0', 0, 5));
        $this->assertFalse($this->cage->testCcnum('/x/woot/0'));
        $this->assertFalse($this->cage->testDate('/x/woot/0'));
        $this->assertFalse($this->cage->testDigits('/x/woot/0'));
        $this->assertFalse($this->cage->testEmail('/x/woot/0'));
        $this->assertFalse($this->cage->testFloat('/x/woot/0'));
        $this->assertFalse($this->cage->testGreaterThan('/x/woot/0', 0));
        $this->assertFalse($this->cage->testHex('/x/woot/0'));
        $this->assertFalse($this->cage->testHostname('/x/woot/0'));
        $this->assertFalse($this->cage->testInt('/x/woot/0'));
        $this->assertFalse($this->cage->testIp('/x/woot/0'));
        $this->assertFalse($this->cage->testLessThan('/x/woot/0', 1));
        $this->assertFalse($this->cage->testOneOf('/x/woot/0', array(null, 0, 1, 2)));
        $this->assertFalse($this->cage->testPhone('/x/woot/0'));
        $this->assertFalse($this->cage->testRegex('/x/woot/0', "/null/"));
        $this->assertFalse($this->cage->testUri('/x/woot/0'));
        $this->assertFalse($this->cage->testZip('/x/woot/0'));
    }


}
