<?php
//error_reporting(E_ALL);
require ("../../config/setup.inc");

$title="UPDATE DETAILS";

$id=$_REQUEST['id'];


$nm=$_REQUEST['name'];
$dt=$_REQUEST['dt'];
$rel=$_REQUEST['rel'];
$add=$_REQUEST['adrs'];
require($rpath."pagePop.tmp.php");
?>
<div class="contDiv">
	<div class="divLine" style="border:1px solid #000000; border-radius:2mm; padding:8px; width:98%">
		<div class="divCell" align="center" style="width:20%; border-right:1px solid #000000">Name</div>
		<div class="divCell" align="center" style="width:20%; border-right:1px solid #000000">Date of Birth</div>
		<div class="divCell" align="center" style="width:16%; border-right:1px solid #000000">Realation</div>
		<div class="divCell" align="center" style="width:30%">Address</div>
	</div>
<?
$res=$obj->select("empnominee", "nmID='$id'");
$fres=$obj->fetchrow($res);
?>
	<form name="form1" action="" method="post">
	<div class="divLine" style="padding:8px; width:98%" align="center">
		<div class="divCell" align="center" style="width:20%; border-right:1px solid #000000"><input type="text" id="name" name="name" value="<?=$fres[2]?>" /></div>
		<div class="divCell" align="center" style="width:20%; border-right:1px solid #000000"><input type="date" id="dt" name="dt" value="<?=$fres[5]?>" /></div>
		<div class="divCell" align="center" style="width:16%; border-right:1px solid #000000"><input type="text" id="rel" name="rel" value="<?=$fres[3]?>" /></div>
		<div class="divCell" align="center" style="width:30%"><textarea rows="4" style="size:150; width:95%;"  id="adrs" name="adrs"><?=$fres[6]?></textarea></div>
	</div>
	<div class="divLine" align="center">
		<div class="divCell" align="center" style="width:100%"><input type="submit" id="bsub" value="submit" style="width:40%; background-color:#999999"</div>
	</div>
	</form>
</div>	
<?
if($nm){
$fld="nmName='$nm', nmDob='$dt', nmRel='$rel', nmAddress='$add'";
print $fld;

$update=$obj->update("empnominee", $fld, "nmID='$id'");
}
?>