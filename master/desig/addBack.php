<?
require ("../../config/setup.inc");


$dname=$_REQUEST['dname'];
$rid=$_REQUEST['rid'];



$cdt=date('Y-m-d');
$cby=$_SESSION['usr']['id'];

if ($rid <1){

	$fld="dsgName,CreateBy, CreateDate";
	$val="'$dname', $cby, '$cdt'";

	$res=$obj->chkinsert("desigmast" , "dsgName='$dname'", $fld, $val);
	if ($res){
		print $set->jscriptalert("Designation is saved");
	}else{
		print $set->jscriptalert("Designation is already in record");
	}
}else{
	$fld="dsgName='$dname',CreateBy=$cby, CreateDate='$cdt'";
	$upRes=$obj->update("desigmast", $fld, "dsgID=$rid");
	
		print $set->jscriptalert("Designation is modified");
}

$set->redirect("index");

?>