<?
error_reporting(E_ALL);
require ("../../config/setup.inc");

$ec=$_REQUEST['ec'];
$cdt=$_REQUEST['dt'];

$dtexp=explode("-", $cdt);
$shtYr=substr($dtexp[0],2,2);

$fyr=(string)($misc->currentfinyear($shtYr, $dtexp[1]));

$ses=$_SESSION['usr']['id'];

$lvRes=$obj->select("leaveconfig order by prior");
//print_r($lvRes);
while($lvFres=$obj->fetchrow($lvRes)){
	//print $lvFres[3]."<br/>";

	$qry="nLv".$lvFres[0];
	
	$lv=$_REQUEST[$qry];
	
	
	
	$lv=($lv) ? $lv : 0 ;
	if($lvFres[3]==1){
	
		
		$fld="`levID`, `empCode`, `finYear`, `qty`, `prior`, `createDate`, `oprID`";
		$val="'$lvFres[0]', '$ec', '$fyr', '$lv', '$lvFres[6]', '$cdt' , '$ses'";
		
		
		
		$insRes=$obj->chkinsert("emplevconfig", "levID='$lvFres[0]' and empCode='$ec' and createDate='$cdt'", $fld, $val);
		
	}else{
		
		$total=$obj->sumfield("emplevconfig", "qty", "levID='$lvFres[0]' and empCode='$ec'");
		$taken=$obj->sumfield("attnlevdet", "qty", "levID='$lvFres[0]' and empCode='$ec'");
		
		$remain=$total-$taken;
		
		//print $lvFres[0]." ".$remain;
		if($lvFres[3]<1){
		if($remain >0){
			
			$atFld="`levID`, `empCode`, `qty`,  `levDate`, `levMonth`, `levYear`";
			$atVal="'$lvFres[0]', '$ec', '$remain', '$cdt','0', '0'";
			$ainsRes=$obj->chkinsert("attnlevdet", "levID='$lvFres[0]' and empCode=$ec and levDate='$cdt'", $atFld, $atVal);
			
			//print_r($ainsRes);
		}
		}
		$fld="`levID`, `empCode`, `finYear`, `qty`, `prior`, `createDate`, `oprID`";
		$val="'$lvFres[0]', '$ec', '$fyr', '$lv', '$lvFres[6]', '$cdt' , '$ses'";
		$insRes=$obj->chkinsert("emplevconfig", "levID='$lvFres[0]' and empCode='$ec' and createDate='$cdt'", $fld, $val);
		
		//print_r($insRes);
	}
		
	
	
}

print $set->jscriptalert("Leave is configured");
$set->redirect("addInd?ec=$ec");
?>