<?php
require_once "../Inspekt.php";

// for the sake of this example, plug-in some values
$_POST['userid'] = '--12<strong>34</strong>';
$_POST['username'] = 'se77777enty_<em>fiv</em>e!';

// create a supercage and pass it a config file path
$sc = Inspekt::makeSuperCage('config.ini');

// displays "1234"
echo $sc->post->getRaw('userid');

// displays "seentyfive"
echo $sc->post->getRaw('username');

