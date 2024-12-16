<?
error_reporting(E_ALL);
set_time_limit(7200);
require ("../../config/setup.inc");
require ($root."lib/datetime/datetimepicker_css_js.php");

//$s=$_REQUEST['s'];

$eman=new empManagement();

$empNo=$_REQUEST['empNo'];
$rm=$_REQUEST['mnth'];
$yr=$_REQUEST['yr'];
$dept=$_REQUEST['dept'];
$m=sprintf("%02d", $rm);

$d=cal_days_in_month(CAL_GREGORIAN,"$m","$yr");

$shtYr=substr($yr,2,2);

$fyr=$misc->currentFinYear($shtYr,$m);

$cdt=$yr."-".$m."-".$d;
$cby=$_SESSION['usr']['id'];

$basic=$_REQUEST['basic'];
$hra=$_REQUEST['hra'];
$wa=$_REQUEST['wa'];

$configRes=$obj->select("salconfig");
$configFres=$obj->fetchrow($configRes);

$tds=$_REQUEST['tds'];
$adv=$_REQUEST['adv'];


$salDate=$_REQUEST['slDt'];

$basicStrng="Basic";
$hraStrng="House Rent Allowance";
$waStrng="Washinig Allowance";
$ptaxStrng="Professional Tax";
$esiStrng="ESI Deduction";
$pfStrng="EPF Deduction";
$tdsStrg="TDS Deduction";
$advStrng="Advance Deduction";



$count=count($empNo);
//print $set->jscriptalert($count);
for($i=0; $i< $count; $i++){
//print "me<br/>";

	$mnthpf=($basic[$i]*$configFres[5])/100;
	$eps=($basic[$i]*$configFres[7])/100;
	$pfAdmn=($basic[$i]*$configFres[6])/100;
	$edli=($basic[$i]*$configFres[9])/100;
	$edliAdmn=($basic[$i]*$configFres[10])/100;
	
	$totAmnt=$basic[$i]+$hra[$i]+$wa[$i];
	
	$memRes=$obj->select("empmaster", "empCode='$empNo[$i]'");
	//print_r($memRes);
	$memFres=$obj->fetchrow($memRes);
	if($memFres[29]==1 && $totAmnt<15000){
		$esiccCal=($totAmnt*$configFres[3])/100;
		$exp=explode(".", $esiccCal);
		if($exp[1]>0){
			$esicc=(int)$exp[0]+1;
		}else{
			$esicc=(int)$exp[0];
		}
		
		$esical=(($totAmnt*$configFres[2])/100);
					
					
		$excEc=explode(".", $esical);
		
		if($excEc[1]>0){
			$esiec=$excEc[0]+1;
		}else{
			$esiec=$excEc[0];
		}
	}else{
		$esicc=0;
		$esiec=0;
	}
	if($totAmnt>8500){
		$ptax=$obj->sumfield("ptmaster", "rate","slabHigh >='$totAmnt' and slabLow <='$totAmnt'");
	}else{
		$ptax=0;
	}
	$pfCal=($configFres[4]/100);
	$pfec=round($basic[$i]*$pfCal);
	print "$empNo[$i]<br/>";
	
	
	$basicIns=$eman->insSalDet($empNo[$i], $dept, $m, $yr, $fyr, 1, $basic[$i], $cdt, $cby, $basicStrng, $salDate);
	
	if($hra[$i]>0){
		$hraIns=$eman->insSalDet($empNo[$i], $dept, $m, $yr, $fyr, 1, $hra[$i], $cdt, $cby, $hraStrng, $salDate);
	}
	
	if($wa[$i]>0){
		$waIns=$eman->insSalDet($empNo[$i], $dept, $m, $yr, $fyr, 1, $wa[$i], $cdt, $cby, $waStrng, $salDate);
	}
	
	if($ptax>0){
		$ptaxIns=$eman->insSalDet($empNo[$i], $dept, $m, $yr, $fyr, 2, $ptax, $cdt, $cby, $ptaxStrng, $salDate);
	}
	
	if($pfec>0){
		$pfecIns=$eman->insSalDet($empNo[$i], $dept, $m, $yr, $fyr, 2, $pfec, $cdt, $cby, $pfStrng, $salDate);
	}
	
	if($tds[$i]>0){
		$tdsIns=$eman->insSalDet($empNo[$i], $dept, $m, $yr, $fyr, 2, $tds[$i], $cdt, $cby, $tdsStrg, $salDate);
	}
	
	if($adv[$i]>0){
		$advIns=$eman->insSalDet($empNo[$i], $dept, $m, $yr, $fyr, 2, $adv[$i], $cdt, $cby, $advStrng, $salDate);
		$fld="`empNo`, `transTyp`, `transDate`, `amount`, `creatDate`, `endFlg`";
		$val="'$empNo[$i]', 1, $cdt, '$adv[$i]', $cdt, 1";
		
		$insRes=$obj->chkinsert("advancetrans", "empNo='$empNo[$i]' and transDate='$cdt' and amount='$adv[$i]'", $fld, $val);
		
	}
	
	//if($esiec[$i]>0){
		$esiIns=$eman->insSalDet($empNo[$i], $dept, $m, $yr, $fyr, 2, $esiec, $cdt, $cby, $esiStrng, $salDate);
	//}
	
	$mnthCompCont=$eman->insMnthCont($empNo[$i], $totAmnt, $m, $yr, $fyr, $esicc, $mnthpf, $eps, $pfAdmn, $edli, $edliAdmn, $cdt, $cby);
	//print "$empNo[$i]------$adv[i]<br/>";
	
}
//print "dept=$dept<br/> mnth=$rm <br/> year=$yr";
$set->redirect("report\sheet.php?dept=$dept&amp;mnth=$m&amp;year=$yr");
?>