<?php


require ("../config/setup.inc");


$logID=$_REQUEST['logID'];
$pwd=$_REQUEST['pwd'];
$aname=$_REQUEST['aname'];


$ep=base64_encode(base64_encode(base64_encode($pwd)));
$cdt=date('Y-m-d');

$fld="logID, pswd, userName, userTyp, userDept, CreateBy, CreateDate, active";
$val="'$logID', '$ep', '$aname', 1, 1, 0, '$cdt', 1";

$insRes=$obj->ChkInsert("userdetail","logID='$logID'", $fld, $val );

$set->Redirect($url);

?>