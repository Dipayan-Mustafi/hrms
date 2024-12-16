<?php
//error_reporting(E_ALL);
require ("config/setup.inc");

require ("lib/model/class.loginManagement.php");
$logman=new loginManagement();

$logID=$_REQUEST['usrid'];
$pwd=$_REQUEST['pwd'];

$row=$logman->chkLogin($logID, $pwd);

if ($row <1){
	
	print $set->JScriptAlert("Sorry wrong login credentials");
	$set->redirect("index");
}else{
	$sessDet=$logman->regSession($logID);
	
	$_SESSION['usr']['id']=$sessDet[1];
	$_SESSION['usr']['vpn']=$sessDet[0];
	$_SESSION['usr']['name']=$sessDet[2];
	$_SESSION['usr']['atyp']=$sessDet[3];
	$_SESSION['usr']['dept']=$sessDet[4];
	
	$logman->genLogBook($sessDet[0], $logID);
	
	
	print $set->JScriptAlert("Welcome $sessDet[2] to ".$app['info']['name']." with your secured channel no $sessDet[0] ");
	
	$set->redirect("index");
	
	
}
	