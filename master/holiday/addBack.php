<?
require ("../../config/setup.inc");


$hname=$_REQUEST['hname'];
$id=$_REQUEST['id'];
$dt=$_REQUEST['dt'];

$c=count($id);
for($i=0; $i<$c; $i++){

	$date=$dt[$i];
	
	$expdYr=explode("-",$date);
	$yr=$expdYr[0];
	
	$festival=$hname[$i];
	$fld="`hsDt`, `hdno`, `festival`, `hYear`";
	$val="'$date', 1, '$festival', '$yr'";
	
	
	if($date>0){
	
		$chkRes=$obj->select("holidaytable", "festival='$festival' and hYear=$yr");
		$chkRows=$obj->rows($chkRes);
		if($chkRows>0){
			$insRes=$obj->update("holidaytable", "hsDt='$date'", "festival='$festival' and hYear=$yr");
		}else{
			$insRes=$obj->chkinsert("holidaytable", "festival='$festival' and hYear=$yr", $fld, $val);
		}
		//print_r($insRes);
	}
	
}
print $set->jscriptalert("Holiday list is modified");
$set->redirect("index");
?>