<?php
//error_reporting(E_ALL);
require ("../../config/setup.inc");

$emp=new empManagement();


require ($root."lib/datetime/datetimepicker_css_js.php");

$ecode=$_REQUEST['empNo'];
$name=$_REQUEST['nmName'];
$dob=$_REQUEST['dob'];
$rel=$_REQUEST['nmRel'];
$address=$_REQUEST['adrs'];
$prcnt=$_REQUEST['prcnt'];
$nmTyp=$_REQUEST['nmtyp'];

$cdt=date('Y-m-d');
$cby=$_SESSION['usr']['id'];

$fld="`EmpCode`, `nmName`, `nmRel`, `nmPercent`, `nmDob`, `nmAddress`, `endFlg`, `cdt`, `cby`";
$val="'$ecode', '$name', '$rel', '$prcnt', '$dob', '$address', '$nmTyp','$cdt', '$cby'";

//print $fld."<br/>".$val."<br/>";
$insRes=$obj->chkinsert("empnominee", "empCode='$ecode' and nmName='$name' and nmDob='$dob'", $fld, $val);
//print_r($insRes);
$empRes=$emp->getEmpDet($ecode);

print $set->jscriptalert ("Family details of $empRes[3] has been updated");
$set->redirect("index.php?ec=$ecode");
?>