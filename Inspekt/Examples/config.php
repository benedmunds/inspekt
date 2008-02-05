<?php
set_include_path(get_include_path().PATH_SEPARATOR.dirname(dirname(__FILE__)));

require_once "Inspekt/Cage.php";

// for the sake of this example, plug-in some values
$_POST['userid'] = '--12<strong>34</strong>';
$_POST['username'] = 'se77777enty_<em>fiv</em>e!';

// create a supercage and pass it a config file path
$sc = Inspekt::makeSuperCage(TRUE, './config.ini');

// displays "1234"
echo $sc->post->getRaw('userid');
