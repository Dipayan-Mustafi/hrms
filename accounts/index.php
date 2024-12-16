<?php
//error_reporting(E_ALL);

require ("../config/setup.inc");

$fyr=$_REQUEST['fyr'];

$title=$app['info']['name']." - Ledger List";

require ($root."resource/pageDesign.tmp.php");
require ($root."lib/model/class.fyManager.php");

$fym=new fyManagement();

?>
<div class="contDiv">
	<?php 
		print $fym->chkMasterAccounts($actType, $actCode, $tranTyp,$url, $fyr);
	
	?>
</div>
<? require ($root."resource/footer.tmp.php"); ?>