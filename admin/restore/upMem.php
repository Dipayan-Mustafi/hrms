<?
error_reporting(E_ALL);
set_time_limit(3600);
require ("../../config/setup.inc");
require ($root."lib/datetime/datetimepicker_css_js.php");
$fyr=$misc->currentfinyear(date('y'), date('m'));



$res=$obj->select("attendancedet");
while ($fres=$obj->fetchrow($res)){
	$m=$fres[8];
	$yr=$fres[9];
	
	$d=cal_days_in_month(CAL_GREGORIAN,"$m","$yr");
	
	$dt=$yr."-".$m."-".$d;

	
	
	$insRes=$obj->update("attendancedet", "attnDate='$dt'", "attID=$fres[0]");
	
	
	
	print "<div>";
	print_r($insRes);
	print "</div>";

}




?>