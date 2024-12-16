<?
//error_reporting(E_ALL);
require ("../config/setup.inc");

$lonID=$_REQUEST['lonID'];
$sub=$_REQUEST['sub'];
$mno=$_REQUEST['mno'];

$gur=$_REQUEST['gur'];
$lic=$_REQUEST['lic'];

$apno=$_REQUEST['apno'];
$apdt=$_REQUEST['apdt'];
$apamnt=$_REQUEST['apamnt'];

$shamnt=$_REQUEST['shamnt'];
$pgamnt=$_REQUEST['pgamnt'];
$arint=($_REQUEST['arint']) ? $_REQUEST['arint'] : 0;
$irat=$_REQUEST['irat'];
$emi=$_REQUEST['emi'];
$dur=$_REQUEST['dur'];

$istyp=$_REQUEST['istyp'];
$iscat=$_REQUEST['iscat'];
$refID=$_REQUEST['refID'];
$balRef=$_REQUEST['balRef'];
$purp=$_REQUEST['purp'];
$pfby=$_REQUEST['pfby'];
$pmod=$_REQUEST['pm'];

$dtexp=explode("-", $apdt);
$shrt=substr($dtexp[0],2);

$disAmount=$apamnt - $shamnt - $pgamnt - $balRef;
	
$fyr=$misc->currentfinyear($shrt, $dtexp[1]);



$lastVch=$obj->lastid("loanmem","VchInd","finYear='$fyr' and loanID=$lonID");


	
$lastVch++;



$subRes=$obj->select("loansubmaster", "subID=$sub");
$subFres=$obj->Fetchrow($subRes);

$lonCode=$subFres[5];
if ($istyp==1){
	$a="N";
}elseif($istyp==2){
	$a="PF";
}

$vchNo="$lonCode/$a/".date('m')."/$fyr/".sprintf("%04d",$lastVch);

if($arint>0){
		
	$cby=$_SESSION['usr']['id'];
	$tdt=date('Y')."-".date('m')."-11";
	if ($apdt < $tdt){
	
		$stDt=$tdt;
	}else{
		$tmstp=mktime(0,0,0,date('m')+1,"11",date('Y'));
		$stDt=date('Y-m-d', $tmstp);
	}
	
	$tmstp=mktime(0,0,0,date('m')+1,"11",date('Y'));
	$ndDt=date('Y-m-d', $tmstp);
	
	$nfld="memNo,payHead,amount,installment,lastAmount,stDate,endDate,createBy,createDate,cinstNo, totinstNo";
	$nval="'$mno','Arear Interest', $apamnt,$arint,$arint,'$stDt', '$ndDt', $cby,'$apdt', 0 ,1";
	
	$nInsRes=$obj->chkinsert("arearpaylist", "memNo='$mno' and installment=$arint and payHead='Arear Interest' and createDate='$apdt'", $nfld, $nval);
	
}

$countGur=count($gur);
				
for ($g=0; $g < $countGur; $g++) {
	
	if ($g < ($countGur -1)){
		$gmem.="$gur[$g]|";
	}else{
		$gmem.="$gur[$g]";
	}
	


}

$fld="VchNo, VchInd, memNo, LoanID, appNo, appDt, applyAmount, IssueAmount, takenAmount, shareAmount,gfAmount,LoanRepay, RoI, LoanTen, Bank, ChqNo, ChqDt, installment,paymode,cashAmount,intAmount, CreateDate, finYear, loanTyp,gurMem,subID, authTyp, isuCat, loanDet, pfby";
	
$val="'$vchNo', $lastVch, '$mno', $lonID, '$apno', '$apdt', $apamnt, $apamnt, $disAmount, $shamnt,$pgamnt,$balRef,$irat, $dur, '', '', '0000-00-00','$emi',$pmod, 0, $arint,'$apdt', '$fyr', $lonID, '$gmem', $sub, $istyp, $iscat, '$purp', '$pfby'  ";




$chkIns=$obj->chkinsert("loanmem", "VchNo='$vchNo' and memNo='$mno' and loanID=$lonID ", $fld, $val );



$lastRec=$obj->lastID("loanmem", "LmID", "VchNo='$vchNo' and memNo='$mno' and loanID=$lonID");


$countDoc=count($lic);
	
	for ($d=0; $d < $countDoc; $d++){
		$lfld="LmID, LoanID, docNo";
		
			$lval="$lastRec, $lonID, '$lic[$d]'";
			$dcIns=$obj->chkinsert("loandoclist", "LmID=$lastRec and docNo='$lic[$d]'", $lfld, $lval);
		
		
		
	}
	
	
	
	
	if ($shareValue > 0){
	
		$fndRes=$obj->select("configuration", "Active=1");
		$fndFres=$obj->fetchrow($fndRes);
		
		$noShare=intval($shamnt/ $fndFres[2]);
		
		$shrFld="memNo, shareNo, CreateDate, refID,loanID";
		$shrVal="'$mno', $noShare, '$apdt', $lastRec, $lonID";
		
		$shrRes=$obj->insert("memshare", $shrFld, $shrVal);
		
	}
	
	
	
	
	if ($chkIns){
		
		
	
		$gfFld="memNo, LmID, tfund,  LoanID,CreateDate";
		$gfVal="'$mno', $lastRec, $pgamnt,$lonID, '$apdt'";
		
		$gfIns=$obj->ChkInsert("memtfund", "memNo='$mno' and LmID=$lastRec", $gfFld, $gfVal);
		
		
		$toPay=$issAmount;
		$ref=0;
		$tot=0;
	}


if ($balRef){
	
	$rpFld="LmID,memNo,repayTyp, repayDate, amount, refID";
	$rpVal="$refID,'$mno',3,'$apdt', $balRef, $lastRec";
	$rpRes=$obj->chkinsert("loanrepaylist", "LmID=$refID and repayDate='$apdt' and refID=$lastRec", $rpFld, $rpVal);
	
	
	$clsRes=$obj->update("loanmem", "endFlg=2", "LmID=$refID");


}

print $set->jscriptalert ("Rs. $disAmount of Loan is issued to $mno on ".$misc->dateformat($apdt));
$set->redirect("index");

?>