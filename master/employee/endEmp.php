<?
//error_reporting (E_ALL);
require ("../../config/setup.inc");

$emp=$_REQUEST['i'];
$dt=$_REQUEST['d'];

$update=$obj->update("empmaster", "empTyp=3, modDate='$dt'","empID='$emp'");
//print $set->jscriptalert("$emp--$dt me");
//$set->redirect("index?id=$rid");


?>