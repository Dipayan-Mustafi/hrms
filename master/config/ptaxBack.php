<?php
require ("../../config/setup.inc");

$low=$_REQUEST['from'];
$high=$_REQUEST['to'];
$pt=$_REQUEST['pt'];
$ptID=$_REQUEST['ptid'];

$fld="slabLow='$low',slabHigh='$high', rate='$pt'";
//print $fld;
$upRes=$obj->update("ptmaster", $fld, "ptmID=$ptID");

//print_r($upRes);

if($upRes){
	print $set->jscriptalert ("Professional Tax Slab Updated $high");
	$set->redirect("index?id=5");
}else{
	print $set->jscriptalert ("Something Went Wrong. Please Try Again");
	$set->redirect("index?id=5");
}
?>