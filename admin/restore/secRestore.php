<?
error_reporting(E_ALL);
set_time_limit(3600);
require ("../../config/setup.inc");

$fyr=$misc->currentfinyear(date('y'), date('m'));



$res=$obj->select("`table 36`");
while ($fres=$obj->fetchrow($res)){

	

	$fld="`secID`, `secName`, `officeID`";
	
	$val=" '$fres[0]','$fres[1]','$fres[2]'";
	
	
	$insRes=$obj->insert("secmaster", $fld, $val);
	
	
	
	print "<div>";
	print_r($insRes);
	print "</div>";
}





?>