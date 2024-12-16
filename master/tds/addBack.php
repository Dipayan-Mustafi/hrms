<?php
//error_reporting(E_ALL);
require ("../../config/setup.inc");

$emp=new empManagement();


require ($root."lib/datetime/datetimepicker_css_js.php");

$ecode=$_REQUEST['empNo'];
$mAmnt=$_REQUEST['mAmnt'];
$ot=$_REQUEST['misc'];
$inst=$_REQUEST['mTds'];
$invest=$_REQUEST['invst'];
$insure=$_REQUEST['insure'];
$tGross=$_REQUEST['totGrs'];
$fyr=$_REQUEST['fy'];
$misc=$_REQUEST['misc'];

$cdt=date('Y-m-d');


$fld="`EmpCode`, `totalGross`, `medical`, `lic`, `investment`, `other`, `finYear`, `createDate`";
$val="'$ecode', '$tGross', '$mAmnt', '$insure', '$invest', '$misc', '$fyr','$cdt'";

//print $fld."<br/>".$val."<br/>";
$insRes=$obj->chkinsert("tdsrecords", "empNo='$ecode', createDate='$cdt'", $fld, $val);

$empRes=$emp->getEmpDet($ecode);

print $set->jscriptalert ("TDS Record Inserted For $empRes[3] for Financial Year $fyr on".$misc->dateformat($dt));
$set->redirect("index.php?ec='$ecode'");
?>