<?php

require ("../config/setup.inc");

$id=$_REQUEST['id'];
$pamnt=$_REQUEST['pamnt'];
$pdt=$_REQUEST['pdt'];

$cdt=date('Y-m-d');

$expDt=explode("-", $pdt);
$shtYr=substr($expDt[0],2,2);
$fyr=$misc->currentfinyear($shtYr, $expDt[1]);


$getRes=$obj->select("loanmem", "LmID=$id");
$getFres=$obj->fetchrow($getRes);


$memRes=$obj->select("membermast", "memNo='$getFres[3]'");
$memFres=$obj->fetchrow($memRes);

$lonRes=$obj->select("loanmaster", "loanID=$getFres[4]");
$lonFres=$obj->fetchrow($lonRes);


$lastVchID=$obj->lastID("vouchertable", "vchInd", "finYear= '$fyr'");
	$lastVchID++;
	
	$vchNo="V/".sprintf("%06d", $lastVchID)."/$fyr";

$fld= "`vchNo`, `vchInd`, `vchDate`, `finYear`, `memNo`, `LmID`, `prinPay`,  `totAmount`, `CreateDate`";
$val= "'$vchNo', '$lastVchID', '$pdt', '$fyr', '$memFres[1]', '$lonFres[0]', '$getFres[8]', '$pamnt', '$cdt'";

$insRes=$obj->Insert("vouchertable", $fld, $val);

 if ($insRes){
	
	print $set->JScriptAlert(" elegibility amount is paid ");
	$set->redirect("payBalance?id=9");
	}

?>