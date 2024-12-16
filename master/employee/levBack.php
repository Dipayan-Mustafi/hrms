<?
require ("../../config/setup.inc");

$rid=$_REQUEST['rid'];
$adID=$_REQUEST['adID'];
$yr=date('Y');
$eaID=$_REQUEST['eaID'];

$qty=$_REQUEST['qty'];

$cdt=date('Y-m-d');
$cby=$_SESSION['usr']['id'];

$empRes=$obj->select("empmaster", "empID=$rid");
$empFres=$obj->Fetchrow($empRes);


$count=count($adID);

if ($_REQUEST['bsav']){

	for ($i=0; $i < $count; $i++){
		$lcRes=$obj->select("leaveconfig","levID=$adID[$i]");
		$lcFres=$obj->Fetchrow($lcRes);
		
		
			$fld="levID, empCode, finYear, qty, prior,createDate, oprID";
			$val="$adID[$i], '$empFres[2]', '$yr', $qty[$i], $lcFres[6], '$cdt', $cby";
			
			$insRes=$obj->chkinsert("emplevconfig", "empCode='$empFres[2]' and levID=$adID[$i] and finYear='$yr' and createDate='$cdt'", $fld, $val);
		
		
	}

}
if ($_REQUEST['bmod']){
	
	for ($i=0; $i < $count; $i++){
		$lcRes=$obj->select("leaveconfig","levID=$adID[$i]");
		$lcFres=$obj->Fetchrow($lcRes);
		//print $eaID[$i]."<Br>";
		if ( $eaID[$i]>0){
			$fld=" qty=$qty[$i]";
			
			
			$insRes=$obj->update("emplevconfig",  $fld, "elID=$eaID[$i]");
			//print_r($insRes);
		}
	}

}

print $set->jscriptalert("Leave is configured");
$set->redirect("index");
?>