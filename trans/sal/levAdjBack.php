<?
require ("../../config/setup.inc");

$ec=$_REQUEST['ec'];
$mnth=$_REQUEST['mnth'];
$yr=$_REQUEST['yr'];
$lwp=$_REQUEST['lwp'];
$tmLev=$_REQUEST['tmlev'];

$tlev=$_REQUEST['tlev'];
$levID=$_REQUEST['levID'];
$lev=$_REQUEST['lev'];



$count=count($levID);

for ($i=0; $i < $count; $i++){
	
	$chkRes=$obj->select("attnlevdet", "empCode='$ec' and levMonth='$mnth' and levYear=$yr");
	$chkRows=$obj->fetchrow($chkRes);
	
	if ($chkRows < 1){
	
	
		$fld="levID, empCode, qty, levMonth, levYear";
		$val="$levID[$i], '$ec', $lev[$i], '$mnth', $yr";
		
		$res=$obj->insert("attnlevdet", $fld, $val);
	}else{
		$fld=" qty='$lev[$i]'";
		$upRes=$obj->update("attnlevdet", $fld, "empCode='$ec' and levMonth='$mnth' and levYear=$yr and levID=$levID[$i]");
	}
}
	$fld="lwp=$lwp";
	$upRes=$obj->update("attendancedet", $fld, "attnMonth='$mnth' and attnYear='$yr' and empCode='$ec'");
	
	
	$set->redirect("salGen?ec=$ec&mnth=$mnth&yr=$yr");

?>