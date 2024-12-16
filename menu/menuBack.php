<?php
require ("../config/setup.inc");

$ref=$_SERVER['HTTP_REFERER'];

$txt=$_REQUEST['txt'];


$suid=$_SESSION['usr']['id'];

$lastPos=$obj->lastID("menumanager", "menuPos", "menuHead=$txt[2]");
$lastPos++;

$fld="menuName, menuHead, menuLink, menuPos";
$val="'$txt[0]',$txt[2],'$txt[1]', $lastPos";

$res=$obj->chkinsert("menumanager","menuName='$txt[0]' and menuHead=$txt[2]",$fld, $val);
if ($res){
	$lastRec=$obj->LastID("menumanager", "menuID");
	
	$afld="menuID, userID";
	$aval="$lastRec, $suid";
	
	$ares=$obj->chkinsert("user_permission", "menuID=$lastRec and userID=$suid",$afld, $aval);
	
	$hval="$txt[2], $suid";
	
	$ares=$obj->chkinsert("user_permission", "menuID=$txt[2] and userID=$suid",$afld, $hval);
	
}
$set->redirect($ref);
?>