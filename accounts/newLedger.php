<?php
//error_reporting(E_ALL);

require ("../config/setup.inc");

$fyr=$_REQUEST['fyr'];

$title=$app['info']['name']." - Accounting Initiation";

require ($root."resource/pageDesign.tmp.php");
require ($root."lib/model/class.fyManager.php");

$fym=new fyManagement();

?>

<div class="contDiv">
	<div style="text-align: right; background-color:#3C3D6C; padding:0.5%;"><input type="button" value="<< Back" name="bBack" onclick="navigate('index');"></div>
	<?php 
		print $fym->genMaster($actType, $actCode, $tranTyp);
	
	?>
</div>
<?
require ($root."resource/footer.tmp.php");
?>