<?php
//error_reporting(E_ALL);
require ("../../config/setup.inc");

$emp=new empManagement();


require ($root."lib/datetime/datetimepicker_css_js.php");

$ecode=$_REQUEST['empNo'];
$amount=$_REQUEST['amnt'];
$dt=$_REQUEST['dt'];
$inst=$_REQUEST['inst'];

$cdt=date('Y-m-d');


$fld="`empNo`, `transTyp`, `transDate`, `amount`, `creatDate`, `endFlg`, instalment";
$val="'$ecode', '2', '$dt', '$amount', '$cdt', 1, $inst ";

//print $fld."<br/>".$val."<br/>";
$insRes=$obj->chkinsert("advancetrans", "empNo='$ecode' and transDate='$dt' and amount='$amount'", $fld, $val);

$empRes=$emp->getEmpDet($ecode);

print $set->jscriptalert ("Rs. $amount is paid to $empRes[2] as Advance on ".$misc->dateformat($dt));
$set->redirect("index.php?ec='$ecode'");
?>