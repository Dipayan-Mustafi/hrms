<?php

error_reporting(E_ERROR);
require ("config/setup.inc");

$title=$app['info']['name'];



require ($root."resource/pageDesign.tmp.php");


if (!$_SESSION['usr']['id']){
	
	$set->redirect ("login");
	//print $set->jscriptalert("Please Login to Application");
	//$set->redirect("http://".$_SERVER['HTTP_HOST']."/crm/");
}else{
	
	
	$stman->chkLiveLogin();
	
	
	
	$frow=$stman->chkFinYear($fyr);
	
	if ($frow<1){
		
		$set->redirect("install/initAccount?fyr=$fyr");
		
	}else{
		$set->redirect($url."postLogin");
		
	}
	
	

}


?>