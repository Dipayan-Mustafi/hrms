<?php
//error_reporting(E_ALL);
require ("../../config/setup.inc");

$id=$_REQUEST['id'];


$res=$obj->select("empnominee", "nmID='$id'");
$fres=$obj->fetchrow($res);

if($fres[7]==1){
	$endFlg=2;
}else if($fres[7]==2){
	$endFlg=1;
}	

$update=$obj->update("empnominee", "endFlg='$endFlg'", "nmID='$id'");

if($update){
	print $set->jsclose();
}
?>