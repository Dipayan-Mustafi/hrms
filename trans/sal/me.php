<?
error_reporting(E_ALL);
set_time_limit(7200);
require ("../../config/setup.inc");







$emp=new empManagement();


require ($root."lib/datetime/datetimepicker_css_js.php");

$mnth=$_REQUEST['mnth'];
$yr=$_REQUEST['yr'];
$dept=$_REQUEST['dept'];
$r=$_REQUEST['ecode'];
$cm=$_REQUEST['r'];

$totd=$_REQUEST['totd'];
$sday=$_REQUEST['sday'];
$hday=$_REQUEST['hday'];
$salDays=$_REQUEST['sdays'];

$tw=$_REQUEST['tw'];
$psnt=$_REQUEST['prsnt'];
$late=$_REQUEST['lat'];
$leave=$_REQUEST['leave'];


$c=count($r);
print_r($r);

$cdt=date('Y-m-d');
/*
for($i=0; $i<$c; $i++){
	
	$ec=$r[$i];
	
	$totDays=$totd[$i]-$sday[$i]-$hday[$i];
	$lt=$late[$i];
	$sal=$salDays[$i];
	
	$lt=($lt) ? $lt : 0;
	
	$prsnt=$psnt[$i];
	
	$intime=$prsnt-$lt;
	
	$lwp=($totd[$i]-$sal);
	
	$fld="empCode, attnMonth, attnYear,twDays, prsnt, inTime, lwp, inLate, attnDate";
	
	$val="'$ec', '$mnth', '$yr', '$totDays', $prsnt, $intime, '$lwp', $lt, '$cdt'";
	
	/*print $fld;
	print "<br/>";
	print $val;
	print "<br/>";
	print "<br/>";*/
	
	/*$lastID=$obj->lastID("attendancedet", "attID", "attnMonth='$mnth' and attnYear='$yr' and empCode='$ec'");
	if ($lastID <1){
	
		$insRes=$obj->chkInsert("attendancedet", "attnMonth='$mnth' and attnYear='$yr' and empCode='$ec'", $fld, $val);
		
	}else{
	
		$fld="prsnt='$prsnt', inTime='$intime', lwp='$lwp', inLate='$lt'";
		$upRes=$obj->update("attendancedet", $fld, "attnMonth='$mnth' and attnYear='$yr' and empCode='$ec'");
		
	}
	
	print_r($insRes);
	print "<br/>";
	print_r($upRes);
	print "<br/>";
}*/
//$set->redirect("sEdit?dept=$dept&mnth=$mnth&yr=$yr");


?>
<title>Registering Attendance</title>