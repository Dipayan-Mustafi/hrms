<?
error_reporting(E_ALL);
set_time_limit(3600);
require ("../../config/setup.inc");

$fyr=$misc->currentfinyear(date('y'), date('m'));



$res=$obj->select("`table 36`");
while ($fres=$obj->fetchrow($res)){


	/*$secRes=$obj->select("secmaster", "secName='$fres[2]'");
	$secFres=$obj->fetchrow($secRes);
	
	$secID=($secFres[0]) ? $secFres[0] : 0;*/	
	
	
	
	
	
	$insRes=$obj->update("membermast", "EmpID=$fres[1]", "memNo='$fres[0]'");
	
	
	
	print "<div>";
	print_r($insRes);
	print "</div>";
}





?>