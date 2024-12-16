<?php
require ("../../config/setup.inc");

$low=$_REQUEST['from'];
$high=$_REQUEST['to'];
$pt=$_REQUEST['pt'];
$ptID=$_REQUEST['ptid'];

$fld="slabLow='$low', slabHigh='$high', rate='$pt'";
$upRes=$obj->update("tdsmaster", $fld, "ptmID=$ptID");

if($upRes){
	print $set->jscriptalert ("TDS Slab Updated $high");
	$set->redirect("index?id=6");
}else{
	print $set->jscriptalert ("Something Went Wrong. Please Try Again");
	$set->redirect("index?id=6");
}
?>