<?
require ("../config/setup.inc");

require ($root."lib/loan/Class.LoanCalculator.php");

$lcal=new LoanCalculator();


require ($root."accounts/lib/class.CompMan.php");
$cman=new CompMan();

require ($root."accounts/lib/class.LedgMan.php");
$lman=new LedgMan();



$lnID=$_REQUEST['lmID'];
$mCode=$_REQUEST['mno'];
$bankname=$_REQUEST['bank'];
$chqno=$_REQUEST['chqno'];
$chqdt=($_REQUEST['chqdt']) ? $misc->dateformat($_REQUEST['chqdt']) : date('Y-m-d');
$expDt=explode("-",$chqdt);
$dtCount=count($expDt);
$ledNo=$_REQUEST['ledNo'];

$paymode=$_REQUEST['pm'];


$brn=$_SESSION['usr']['branch'];

$dt=$chqdt;
$expDt=explode("-", $dt);
$shtYr=substr($expDt[0], 2,2);
$fyr=$misc->CurrentFinYear($shtYr,$expDt[1]);







	

	$count=count($lnID);
	
	
	
	for ($i=0; $i < $count; $i++){
		if (!$chqno){
			$chkRes=$obj->select("loanmem","LmID=$lnID[$i]");
			$chkFres=$obj->fetchrow($chkRes);
			$fld="cashAmount=$chkFres[9], paymode=$paymode, endFlg=1, brnCode='$brn'";
		}else{
			$fld="Bank='$bankname', ChqNo='$chqno', ChqDt='$chqdt',brnCode='$brn', endFlg=1, paymode=$paymode";
	
		}

		
		$upRes=$obj->update("loanmem",$fld, "LmID=$lnID[$i]");
		
	
		
		if ($i < ($count-1)){
			$qry.="id[]=$lnID[$i]&";
		}else{
			$qry.="id[]=$lnID[$i]";
		}
	
	
	}
	
	
	
	
	
	
	$set->redirect("MultiAccounts?$qry&dt=$dt&ledID=$ledNo");
	
	//if ($paymode>1){
	
	//$set->redirect("MultiAccounts?$qry&dt=$chqdt");
	//$set->redirect("print/chqPrintPre?$qry&dt=$chqdt");
	//print $set->jsclose();
	//}else{
		
		//$set->redirect("multiAccounts?");
	//}
	

?>