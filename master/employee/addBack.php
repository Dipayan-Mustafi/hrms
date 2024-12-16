<?
//error_reporting (E_ALL);
require ("../../config/setup.inc");

$rid=$_REQUEST['rid'];
$empTyp=$_REQUEST['et'];
$payTyp=$_REQUEST['pt'];
$name=$_REQUEST['ename'];
$sxt=$_REQUEST['sxt'];
$dob=$_REQUEST['dob'];
$gender=$_REQUEST['sxt'];
$mail=$_REQUEST['email'];
$phNo=$_REQUEST['phno'];
$mobile=$_REQUEST['mobile'];
$pan=$_REQUEST['pan'];
$adhar=$_REQUEST['uid'];
$address=$_REQUEST['addr'];
$city=$_REQUEST['city'];
$pin=$_REQUEST['pin'];
$state=$_REQUEST['estat'];
$country=$_REQUEST['cntry'];
$religion=$_REQUEST['rlg'];
$subGrp=$_REQUEST['subGrp'];

$paddress=$_REQUEST['paddr'];
$pcity=$_REQUEST['pcity'];
$ppin=$_REQUEST['ppin'];
$pstate=$_REQUEST['pestat'];
$pcountry=$_REQUEST['pcntry'];

$gurName=$_REQUEST['gname'];
$gurRel=$_REQUEST['grel'];
$mTyp=$_REQUEST['mtyp'];
$spuse=$_REQUEST['sname'];
$spRel=$_REQUEST['srel'];
$desig=$_REQUEST['desig'];
$doj=$_REQUEST['doj'];
$dept=$_REQUEST['dept'];

$bank=$_REQUEST['bAccnt'];
$ifsc=$_REQUEST['ifsc'];
$esi=$_REQUEST['esa'];
$epf=$_REQUEST['epa'];
$epfNo=$_REQUEST['epno'];
$contEpf=$_REQUEST['cesa'];
$epbf=$_REQUEST['epbf'];
$prevComp=$_REQUEST['bcomp'];
$bpay=$_REQUEST['bpay'];
$uan=$_REQUEST['uan'];
$esno=$_REQUEST['esno'];
$ptx=$_REQUEST['ptx'];

$cdt=date('Y-m-d');
$cby=$_SESSION['usr']['id'];

if ($rid <1){
	
	$etypAbbr=array("", "P", "C");
	
	
	if($prevComp){
		$compName=$prevComp;
	}else{
		$compName='N/A';
	}
	
	if ($epfNo){
		$empCode=$epfNo;
		$lastInd=0;
	}else{
		$et=$empTyp;
		$lastInd=$obj->lastid("empmaster", "empIndex", "empTyp='$empTyp'");
		$lastInd++;
		$empCode=$etypAbbr[$et].sprintf("%04d",$lastInd);
	}
	
	
	
	$fld="empTyp, empCode, empName, empDob, 
			empPhn, empMob, empPan, empUID,
			empMail, empDoj, empDesig, empDept,
			empJobTyp, empRd, empCity, empZip,
			empStat, empCntry, empPRd, empPCity,
			empPZip, empPStat, empPCntry, empGName,
			empGRel, empMStat, empSName, empSRel,
			empESI, empEPF, empEPFNo, empUAN,
			empEPFBf, empPComp,empSex,empESINo, oprID,createDate, empIndex,basicPay,empReligion,empSubGrp, empBankAccount, empIfsc, empPtax";
	
	$val="'$empTyp', '$empCode', '$name', '$dob',
			'$phNo', '$mobile', '$pan', '$adhar',
			'$mail', '$doj', '$desig', '$dept',
			'$payTyp', '$address', '$city', '$pin',
			'$state', '$country', '$paddress', '$pcity',
			'$ppin', '$pstate', '$pcountry', '$gurName',
			'$gurRel', '$mTyp', '$spuse', '$spRel',
			'$esi', '$epf', '$epfNo', '$uan',
			'$epbf', '$compName', $sxt ,'$esno','$cby', '$cdt', $lastInd,'$bpay','$religion','$subGrp', '$bank', '$ifsc', $ptx";

	$res=$obj->chkinsert("empmaster" , "empTyp='$empTyp' and empName='$name' and empDob='$dob' and empEPFNo='$epf'" ,$fld, $val);

	$lastID=$obj->lastID("empmaster" , "empID" ,"empTyp='$empTyp' and empName='$name' and empDob='$dob'");
	if ($lastID){
		
		print $set->jscriptalert("Employee record is saved, Employee Code: '$empCode'");
		$set->redirect("salConfig?id=$lastID");
	}else{
			print_r ($res);
	}
}else{
	if($prevComp){
		$compName=$prevComp;
	}else{
		$compName='N/A';
	}

	$fld="
	empTyp='$empTyp',  empName='$name', empDob='$dob', 
			empPhn='$phNo', empMob='$mobile', empPan='$pan', empUID='$adhar',
			empMail='$mail', empDoj= '$doj', empDesig='$desig', empDept='$dept',
			empJobTyp='$payTyp', empRd= '$address', empCity='$city', empZip= '$pin',
			empStat='$state', empCntry='$country', empPRd='$paddress', empPCity='$pcity',
			empPZip='$ppin', empPStat='$pstate', empPCntry='$pcountry', empGName='$gurName',
			empGRel='$gurRel', empMStat='$mTyp', empSName='$spuse', empSRel='$spRel',
			empESI='$esi', empEPF='$epf', empEPFNo='$epfNo', empUAN='$uan',
			empEPFBf='$epbf', empPComp='$compName',empSex=$sxt, basicPay='$bpay', empESINo='$esno', 
			empReligion='$religion', empSubGrp='$subGrp',empBankAccount='$bank', empIfsc='$ifsc', empPtax=$ptx
			
	
		
	";
	print $compName;
	if ($epfNo){
		$fld.=",empCode='$epfNo'";
	}
	$upRes=$obj->update("empmaster", $fld, "empID=$rid");
	//print_r($upRes);
	
	print $set->jscriptalert("Employee record is modified, Employee Code: $empCode");
	$set->redirect("index?id=$rid");
}

?>