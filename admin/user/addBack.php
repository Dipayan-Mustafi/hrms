<?
//error_reporting(E_ALL);
require ("../../config/setup.inc");



	$uid=$_REQUEST['uid'];
	$name=$_REQUEST['Name'];
	$pswd=$_REQUEST['pswd'];

	
	$usg=$_REQUEST['usg'];
	$act=$_REQUEST['act'];
	$cdt=date('y-m-d');
	
	
	
		$fld="logID, pswd, userName, userDept, userTyp, CreateDate, accLevel";
		
		$val="'".trim($uid)."', '".trim(base64_encode(base64_encode(base64_encode($pswd))))."', '$name', $usg, $usg, '$cdt', $usg ";
		
		
		
		
		
		$res=$obj->chkinsert("userdetail", "logID='$uid'" ,$fld , $val);
		
		if ($res){
			print $set->jscriptalert("User is added");
		}else{
			print $set->jscriptalert("Userid is already in Database");
		}
	
	$set->redirect("index");
?>