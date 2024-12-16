<?
require ("../config/setup.inc");

require ($root."lib/loan/Class.AccountsManager.php");
require ($root."lib/loan/Class.LoanCalculator.php");



$aman=new AccountsManager();
$lcal=new LoanCalculator();



require ($root."accounts/lib/class.LedgMan.php");
$lman=new LedgMan();

$uri=$_SERVER['QUERY_STRING'];
$id=$_REQUEST['id'];
$actLedID=$_REQUEST['ledID'];



$dt=($_REQUEST['dt']) ? $_REQUEST['dt'] : date('Y-m-d');


$expDt=explode("-", $dt);

$shtYr=substr($expDt[0],2,2);


$fyr=$misc->CurrentFinYear($shtYr,$expDt[1]);

$opDt=$misc->openingdate($fyr);



$lnRes=$obj->select("loanmem", "LmID=$id[0]");
$lnFres=$obj->fetchrow($lnRes);




$memRes=$obj->select("membermast", "memNo='$lnFres[3]'");
$memFres=$obj->fetchrow($memRes);


if ($memFres[27]>0){
	$ledID=$memFres[27];
	
	
	$actTyp=$lman->findLAccountType($fyr,$ledID);

}else{
	$actTyp=503;
	
	$fld="LedName, LedAlly, LedTyp, AcntTyp, OpDate, OpBal, finYear, TransTyp";
	$val="'".strtoupper($memFres[1])."', '$memFres[1]', 0, $actTyp, '$opDt', 0, '$fyr',2 ";

	$insRes=$obj->chkInsert("ledgermaster", "LedName='".strtoupper($memFres[2])."' and LedAlly='$memFres[1]'", $fld, $val);

	$lastRec=$obj->lastID("ledgermaster", "LedID" , "LedName='".strtoupper($memFres[2])."' and LedAlly='$memFres[1]'" );
	
	$upRes=$obj->update("membermast", "ledID=$lastRec", "memNo='$memFres[1]'");
	
	$ledID=$lastRec;
}



$memName=strtoupper($memFres[2]);
$lastPayNo=$obj->lastID("ledgertrans", "VchIndex", "VchTyp=2 and finYear='$fyr'");

$lastPayNo++;

$payVch="P/".sprintf("%06d", $lastPayNo)."/$fyr";

$mid=$memFres[1];
$rmks="Loan Issued to $memName [$mid]";

$count=count($id);
for ($i=0; $i < $count; $i++){
	
	$lmRes=$obj->select("loanmem", "LmID=$id[$i]");
	$lmFres=$obj->fetchrow($lmRes);
	
	$takAmount=$takAmount+$lmFres[9];
	$isuAmount=$isuAmount+$lmFres[8];
	$shrAmount=$shrAmount+$lmFres[11];
	$pdAmount=$pdAmount+$lmFres[10];
	
	
	
	$mstRes=$obj->select("loanmaster", "loanID=$lmFres[4]");
	$mstFres=$obj->fetchrow($mstRes);
	
	$ldmRes=$obj->select("ledgermaster", "LedID=$mstFres[2]");
	$ldmFres=$obj->fetchrow($ldmRes);
	
	$mstAct=$aman->AccountEntry($dt,$payVch,$lastPayNo,2,1,$ldmFres[1],$ldmFres[4],$ldmFres[0],$isuAmount,$rmks, $fyr, $mid, $bank, $chqNo, $memFres[0]);
	
	if ($lmFres[12]){
		
		$rpRes=$obj->Select("loanrepaylist", "refID=$id[$i] and repayTyp=3");
		while ($rpFres=$obj->fetchrow($rpRes)){
		
			$lrpRes=$obj->select("loanmem", "LmID=$rpFres[1]");
			$lrpFres=$obj->fetchrow($lrpRes);
			
			$lrmRes=$obj->select("loanmastcat", "mstID=$lrpFres[4]");
			$lrmFres=$obj->fetchrow($lrmRes);
			
			$lrdmRes=$obj->select("ledgermaster", "LedID=$lrmFres[2]");
			$lrdmFres=$obj->fetchrow($lrdmRes);
			
			
			$rtnAct=$aman->AccountEntry($dt,$payVch,$lastPayNo,2,2,$lrdmFres[1],$lrdmFres[4],$lrdmFres[0],$rpFres[5],$rmks, $fyr,$mid, $bank, $chqNo, $memFres[0]);
		
		}
		
		
		
	}
	
	
	
	
	$bank=$lmFres[15];
	$chqNo=$lmFres[16];
	
	
	$payMode=$lmFres[20];
	
	$upRes=$obj->update("loanmem", "pvchNo='$payVch',endFlg=1, acntFlg=1" ,"LmID=$id[$i]");
	
	

}


if ($shrAmount){

	$ldmRes=$obj->select("ledgermaster", "AcntTyp='401'");
	$ldmFres=$obj->fetchrow($ldmRes);
	$mstAct=$aman->AccountEntry($dt,$payVch,$lastPayNo,2,2,$ldmFres[1],$ldmFres[4],$ldmFres[0],$shrAmount,$rmks, $fyr,$mid, $bank, $chqNo, $memFres[0]);
	
}
if ($pdAmount){

	$ldmRes=$obj->select("ledgermaster", "LedName='P.G.D.F'");
	$ldmFres=$obj->fetchrow($ldmRes);
	$mstAct=$aman->AccountEntry($dt,$payVch,$lastPayNo,2,2,$ldmFres[1],$ldmFres[4],$ldmFres[0],$pdAmount,$rmks, $fyr,$mid, $bank, $chqNo, $memFres[0]);
	
}


		/*$fld="TransDt, VchNo, VchIndex, VchTyp, TransTyp, LedID, AcntTyp, Amount, remarks, finYear,  bank, chequeNo";
		$val="'$dt', '$payVch', $lastPayNo, 2, 1, $ledID, $actTyp, $isuAmount, '$rmks', '$fyr',  '$bank', '$chqNo'";
		
		$chk="VchNo='$vchno' and VchTyp=$vTyp and TransTyp=$ttyp and LedID=$ant and Amount=$amount";
			
		$res=$obj->ChkInsert("ledgertrans", $chk, $fld, $val);*/
		



$ldRes=$obj->select("ledgermaster", "LedID=$actLedID");
$ldFres=$obj->fetchrow($ldRes);


$pAct=$aman->AccountEntry($dt,$payVch,$lastPayNo,2,2,$ldFres[1],$ldFres[4],$ldFres[0],$takAmount,$rmks, $fyr,$mid, $bank, $chqNo, $memFres[0]);

$cdt=date('Y-m-d');
$cby=$_SESSION['usr']['id'];

$upRes=$obj->update("ledgertrans", "CreateDate='$cdt', CreateBy=$cby" , "VchNo='$payVch'" );



if ($payMode > 1){
	$set->redirect("print/chqPrintPre?$uri");
}else{
	print $set->jscriptalert("Payment Voucher No : $payVch");
	$set->redirect("print/IssueVoucherPreview?v=$payVch");
}
?>