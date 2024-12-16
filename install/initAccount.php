<?php
//error_reporting(E_ALL);

require ("../config/setup.inc");

$fyr=$_REQUEST['fyr'];

$title=$app['info']['name']." - Accounting Initiation";

require ($root."resource/pageDesign.tmp.php");
require ($root."lib/model/class.fyManager.php");

$fym=new fyManagement();

?>
<center>
	<?php 
		print $fym->chkMasterAccounts($actType, $actCode, $tranTyp,$url, $fyr);
	
	?>
</center>