<?php
//error_reporting(E_ALL);

require ("../config/setup.inc");

$fyr=$_REQUEST['fyr'];
$lid=$_REQUEST['lid'];

$title=$app['info']['name']." - Accounting Initiation";

require ($root."resource/pageDesign.tmp.php");
require ($root."lib/model/class.fyManager.php");

$fym=new fyManagement();

?>
<center>
	<div style="text-align: right; width:59%; background-color:#3C3D6C; padding:0.5%;"><input type="button" value="<< Back" name="bBack" onclick="navigate('initAccount');"></div>
	<?php 
		print $fym->modLedDet($lid, $fyr,$actType, $actCode, $tranTyp);
	
	?>
</center>