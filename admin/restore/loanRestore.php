<?
error_reporting(E_ALL);
set_time_limit(3600);
require ("../../config/setup.inc");

$fyr=$misc->currentfinyear(date('y'), date('m'));



$res=$obj->select("`table 27`");
while ($fres=$obj->fetchrow($res)){

	$balance= $fres[3]-$fres[4];
	$loanTen= @intval($balance/$fres[5]);	
	if ($balance%$fres[5] > 0){
		$loanTen++;
	}
	
	$lastVchID=$obj->lastID("loanmem", "VchInd", "loanID=$fres[2]");
	$lastVchID++;
	
	$vchNo=sprintf("%02d", $fres[2])."/".sprintf("%04d", $lastVchID)."/$fyr";
	

	$fld="VchNo, VchInd, memNo, loanID,  appDt, applyAmount, IssueAmount, takenAmount,  RoI, LoanTen, installment, refundAmount, endFlg ";
	
	$val="'$vchNo', $lastVchID, '$fres[1]', '$fres[2]', '".date('Y-m-d'). "', '$fres[3]', '$fres[3]', '$fres[3]', 9, '$loanTen', '$fres[5]', '$fres[4]',1";
	
	
	$insRes=$obj->chkinsert("loanmem", "memNo='$fres[1]' and loanID='$fres[2]'", $fld, $val);
	
	
	
	print "<div>";
	print_r($insRes);
	print "</div>";
}





?>