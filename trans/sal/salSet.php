<?
error_reporting(E_ALL);
require ("../../config/setup.inc");



//$emp=new empManagement();


require ($root."lib/datetime/datetimepicker_css_js.php");

$mnth=$_REQUEST['mnth'];
//print $mnth;
$yr=$_REQUEST['yr'];
$dept=$_REQUEST['dept'];
$r=$_REQUEST['ecode'];

$totd=$_REQUEST['totd'];
$sday=$_REQUEST['sday'];
$hday=$_REQUEST['hday'];
$salDays=$_REQUEST['sdays'];

//$tw=$_REQUEST['twd'];
$psnt=$_REQUEST['prsnt'];
$late=$_REQUEST['lat'];
$leave=$_REQUEST['leave'];



$c=count($r);
//print_r($r);

//echo $mnth;

$cdt=date('Y-m-d');

for($i=0; $i<$c; $i++){
	
	$ec=$r[$i];
	
	$totDays=$totd-$sday-$hday;
	$lt=$late[$i];
	$sal=$salDays[$i];
	
	$lt=($lt) ? $lt : 0;
	
	$prsnt=$psnt[$i];
	
	$intime=$prsnt-$lt;
	
	$lwp=($totd-$sal);
	
	$fld="empCode, attnMonth, attnYear,twDays, prsnt, inTime, lwp, inLate, attnDate";
	
	$val="'$ec', '$mnth', '$yr', '$totDays', '$prsnt', '$intime', '$lwp', '$lt', '$cdt'";
	
	/*print $fld;
	print "<br/>";
	print $val;
	print "<br/>";
	print "<br/>";
	*/
	$lastID=$obj->lastID("attendancedet", "attID", "attnMonth='$mnth' and attnYear='$yr' and empCode='$ec'");
	if ($lastID <1){
	
		$insRes=$obj->chkInsert("attendancedet", "attnMonth='$mnth' and attnYear='$yr' and empCode='$ec'", $fld, $val);
		
	}else{
	
		$fld="prsnt='$prsnt', inTime='$intime', lwp='$lwp', inLate='$lt'";
		$upRes=$obj->update("attendancedet", $fld, "attnMonth='$mnth' and attnYear='$yr' and empCode='$ec'");
		
	}
	
}
$set->redirect("sEdit?dept=$dept&mnth=$mnth&yr=$yr");


?>
<title>Registering Attendance</title>