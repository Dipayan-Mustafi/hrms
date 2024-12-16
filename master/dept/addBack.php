<?
require ("../../config/setup.inc");


$dname=$_REQUEST['dname'];
$rid=$_REQUEST['rid'];



$cdt=date('Y-m-d');
$cby=$_SESSION['usr']['id'];

if ($rid <1){

	$fld="deptName,CreateBy, CreateDate";
	$val="'$dname', $cby, '$cdt'";

	$res=$obj->chkinsert("deptmanager" , "deptName='$dname'", $fld, $val);
	if ($res){
		print $set->jscriptalert("Department is saved");
	}else{
		print $set->jscriptalert("Department is already in record");
	}
}else{
	$fld="deptName='$dname',CreateBy=$cby, CreateDate='$cdt'";
	$upRes=$obj->update("deptmanager", $fld, "deptID=$rid");
	
		print $set->jscriptalert("Department is modified");
}

$set->redirect("index");

?>