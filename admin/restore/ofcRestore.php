<?
error_reporting(E_ALL);
set_time_limit(3600);
require ("../../config/setup.inc");

$fyr=$misc->currentfinyear(date('y'), date('m'));



$res=$obj->select("`table 35`");
while ($fres=$obj->fetchrow($res)){

	/*$balance= $fres[3]-$fres[4];
	$loanTen= @intval($balance/$fres[5]);	
	if ($balance%$fres[5] > 0){
		$loanTen++;
	}
	
	$lastVchID=$obj->lastID("loanmem", "VchInd", "loanID=$fres[2]");
	$lastVchID++;
	
	$vchNo=sprintf("%02d", $fres[2])."/".sprintf("%04d", $lastVchID)."/$fyr";*/
	

	$fld="`officeName`, `hodName`";
	
	$val="'$fres[1]', '-'";
	
	
	$insRes=$obj->insert("officemaster", $fld, $val);
	
	
	
	print "<div>";
	print_r($insRes);
	print "</div>";
}





?>