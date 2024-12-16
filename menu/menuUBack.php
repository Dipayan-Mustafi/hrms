<?php
require ("../config/setup.inc");

$ref=$_SERVER['HTTP_REFERER'];

$txt=$_REQUEST['txt'];
$id=$_REQUEST['id'];
$ql=$_REQUEST['ql'];
$phd=$_REQUEST['phd'];



$lastPos=$obj->lastID("menumanager", "menuPos", "menuHead=$txt[2]");
$lastPos++;

$fld="menuName='$txt[0]', menuHead=$txt[2], menuLink='$txt[1]'";
if ($phd<>$txt[2]){
	$fld.=", menuPos=$lastPos";	
}

$val=",,, ";

$res=$obj->update("menumanager",$fld, "menuID=$id");

print_r($res);
$set->redirect("index");
?>