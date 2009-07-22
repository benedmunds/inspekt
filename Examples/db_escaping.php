<?php
require_once '../Inspekt.php';

$_POST['userid'] = "\'; DESC users; --";
$_POST['email'] = 'coj@funkatron.com';
$_POST['text'] = 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus nisl dolor, pulvinar id, pharetra a, egestas nec, ante. Duis scelerisque eleifend metus. Sed non odio id odio varius rutrum. Pellentesque congue commodo lacus. In semper pede lacinia felis. Morbi mollis molestie lorem. Morbi suscipit libero. Quisque ut erat sit amet elit aliquam nonummy. Donec tortor. Aliquam gravida ullamcorper pede. Praesent eros. Sed fringilla ligula sed odio pharetra imperdiet. Integer aliquet quam vitae nibh. Nam pretium, neque non congue vulputate, odio odio vehicula augue, sit amet gravida pede massa ac lectus. Curabitur a libero vitae dui sagittis aliquet. Ut suscipit. Curabitur accumsan sem a urna. Ut elit pede, vulputate sed, feugiat quis, congue sed, lacus.';


$mysql_conn = mysql_connect('localhost', 'inspekt_test', 'ewp-odd-ia');

$sc = Inspekt::makeSuperCage();

echo $sc->post->escMySQL('userid');

?>