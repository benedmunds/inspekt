<?php
require_once "../Inspekt.php";

// for the sake of this example, plug-in some values
$_POST['userid'] = '--12<strong>34</strong>';
$_POST['username'] = 'se777v77enty_<em>fiv</em>e!';
?>



<h2>contents of $_POST</h2>
<?php
echo "<pre>"; var_dump($_POST); echo "</pre>";

// create a supercage and pass it a config file path
$sc = Inspekt::makeSuperCage('config.ini');
?>


<h2>config file contents</h2>
<?php
echo "<pre>"; echo print_r(file_get_contents('config.ini'), true); echo "</pre>";
?>


<h2>echo $sc->post->getRaw('userid')</h2>
<?php
// displays "1234"
echo "<pre>"; var_dump($sc->post->getRaw('userid')); echo "</pre>";
?>


<h2>echo $sc->post->getRaw('username')</h2>
<?php
// displays "seentyfive"
echo "<pre>"; var_dump($sc->post->getRaw('username')); echo "</pre>";
?>