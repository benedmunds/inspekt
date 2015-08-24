<?php
require_once dirname(__FILE__) . "/../vendor/autoload.php";

use Inspekt\Cage;
use Inspekt\Inspekt;
use Inspekt\AccessorAbstract;

/**
 * Class testUsername
 */
class testUsername extends AccessorAbstract
{
    /**
     * a function to test for a valid username
     *
     * @param $val
     * @return bool
     * @author Ed Finkler
     */
    protected function inspekt($val)
    {
        if (preg_match('/^[a-zA-Z0-9_]{1,64}$/', $val)) {
            return $val;
        } else {
            return false;
        }
    }
}


/**
 * Class noWhitespace
 */
class noWhitespace extends AccessorAbstract
{
    /**
     * a function to return values stripped of whitespace
     *
     * @param $val
     * @return string|array
     * @author Ed Finkler
     */
    protected function inspekt($val)
    {
        return preg_replace("/\s+/", '', $val);
    }

}

$superCage = Inspekt::makeSuperCage();

$superCage->addAccessor('testUsername');
$superCage->addAccessor('noWhitespace');


$rs = $superCage->server->testUsername('QUERY_STRING');
var_dump($superCage->server->getRaw('QUERY_STRING'));
var_dump($rs);

$rs = $superCage->server->noWhitespace('HTTP_USER_AGENT');
var_dump($superCage->server->getRaw('HTTP_USER_AGENT'));
var_dump($rs);


/**
 * Now let's take an arbitrary cage
 */
$d = array();
$d['input'] = '<img id="475">yes</img>';
$d['lowascii'] = '    ';
$d[] = array('foo', 'bar<br />', 'yes<P>', 1776);
$d['x']['woot'] = array(
    'booyah' => 'meet at the bar at 7:30 pm',
    'ultimate' => '<strong>hi there!</strong>',
);

$dc = Cage::Factory($d);

/**
 * Sad that we have to re-add, but it's done on a cage-by-cage basis
 */
$dc->addAccessor('testUsername');
$dc->addAccessor('noWhitespace');

var_dump($dc->getRaw('x'));
$rs = $dc->noWhitespace('x');
var_dump($rs);