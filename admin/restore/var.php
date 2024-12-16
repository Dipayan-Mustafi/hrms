<?
error_reporting(E_ALL);
set_time_limit(3600);
require ("../../config/setup.inc");

$fyr=$misc->currentfinyear(date('y'), date('m'));



$res=$obj->distinct("emplevconfig", "empCode");
while ($fres=$obj->fetchrow($res)){

	$chkRes=$obj->select("emplevconfig", "empCode='$fres[0]'");
	$chkRows=$obj->rows($chkRes);
	/*$balance= $fres[3]-$fres[4];
	$loanTen= @intval($balance/$fres[5]);	
	if ($balance%$fres[5] > 0){
		$loanTen++;
	}
	
	$lastVchID=$obj->lastID("loanmem", "VchInd", "loanID=$fres[2]");
	$lastVchID++;
	
	$vchNo=sprintf("%02d", $fres[2])."/".sprintf("%04d", $lastVchID)."/$fyr";*/
	


	
	if($chkRows>2){
		print $fres[0]."<br/>";
	}
}





?>