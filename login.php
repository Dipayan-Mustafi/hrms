<?php
require ("config/setup.inc");

require ("lib/model/class.loginManagement.php");

$title=$app['info']['name'].  "- Login to Account";

$logman=new loginManagement();


//print base64_decode(base64_decode(base64_decode("WWxkR2VtUkhWbms9")));

require ($rpath."pageDesign.tmp.php");
?>


<?php 
print $logman->LoginView($url);


require ($rpath."pageFooter.tmp.php");

?>

