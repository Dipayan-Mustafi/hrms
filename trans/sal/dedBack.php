<?
require ("../../config/setup.inc");

$ec=$_REQUEST['ec'];
$mnth=$_REQUEST['mnth'];
$yr=$_REQUEST['yr'];

$pt=$_REQUEST['pt'];
$esi=$_REQUEST['esi'];
$esic=$_REQUEST['esic'];
$epf=$_REQUEST['epf'];
$cpf=$_REQUEST['cpf'];
$cpfad=$_REQUEST['cpfad'];
$cps=$_REQUEST['cps'];
$edl=$_REQUEST['edl'];
$edlad=$_REQUEST['edlad'];
$totPay=$_REQUEST['totRcv'];

$ptAttr="Professional Tax";
$esAttr="ESI Deduction";
$epAttr="EPF Deduction";


$salRes=$obj->select("empsaldet", "empCode='$ec' and salMonth='$mnth' and salYear='$yr'");
$salFres=$obj->fetchrow($salRes);

$cdt=$salFres[13];
$cby=$_SESSION['usr']['id'];


$sfld="empCode, deptID, salMonth, salYear, finYear, payHead, headTyp, headPrcnt, payAmount, salType,alwID,createDate, oprID";

if ($pt > 0){
	$pval="'$ec', $salFres[2], '$mnth', '$yr', '$salFres[5]', '$ptAttr', 2, 0, $pt,$salFres[10],0,'$cdt', '$cby'";
	$fndRes=$obj->select("empsaldet", "empCode='$ec' and salMonth='$mnth' and salYear='$yr' and payHead='$ptAttr'");
	$fndRows=$obj->rows($fndRes);

	if ($fndRows > 0){
		$upFld="payAmount='$pt'";
		$upRes=$obj->update("empsaldet",$upFld, "empCode='$ec' and salMonth='$mnth' and salYear='$yr' and payHead='$ptAttr'");
	}else{
		$insRes=$obj->insert("empsaldet", $sfld, $pval);
	}


}
if ($esi > 0){
	$sval="'$ec', $salFres[2], '$mnth', '$yr', '$salFres[5]', '$esAttr', 2, 0, $esi,$salFres[10],0,'$cdt', '$cby'";
	$fndRes=$obj->select("empsaldet", "empCode='$ec' and salMonth='$mnth' and salYear='$yr' and payHead='$esAttr'");
	$fndRows=$obj->rows($fndRes);

	if ($fndRows > 0){
		$upFld="payAmount='$esi'";
		$upRes=$obj->update("empsaldet",$upFld, "empCode='$ec' and salMonth='$mnth' and salYear='$yr' and payHead='$esAttr'");
	}else{
		$insRes=$obj->insert("empsaldet", $sfld, $sval);
	}


}
if ($epf > 0){
	$fval="'$ec', $salFres[2], '$mnth', '$yr', '$salFres[5]', '$epAttr', 2, 0, $epf,$salFres[10],0,'$cdt', '$cby'";
	$fndRes=$obj->select("empsaldet", "empCode='$ec' and salMonth='$mnth' and salYear='$yr' and payHead='$epAttr'");
	$fndRows=$obj->rows($fndRes);

	if ($fndRows > 0){
		$upFld="payAmount='$epf'";
		$upRes=$obj->update("empsaldet",$upFld, "empCode='$ec' and salMonth='$mnth' and salYear='$yr' and payHead='$epAttr'");
	}else{
		$insRes=$obj->insert("empsaldet", $sfld, $fval);
	}


}

$fld="empCode,totPay,finYear, salMonth, salYear, esiCC, epfCC, epsCont, epfAdm, edli,edliAdm,createDate,oprID  ";
$val="'$ec', '$totPay','$salFres[5]', '$mnth', '$yr', $esic, $cpf, $cps, $cpfad, $edl, $edlad, '$cdt', $cby";

$fndRes=$obj->select("mnthcompcont", "empCode='$ec' and salMonth='$mnth' and salYear='$yr' ");
	$fndRows=$obj->rows($fndRes);

	if ($fndRows > 0){
		$upFld="esiCC='$esic',epfCC=$cpf, epfAdm=$cpfad,edli=$edl,edliAdm=$edlad";
		$upRes=$obj->update("mnthcompcont",$upFld, "empCode='$ec' and salMonth='$mnth' and salYear='$yr'");
	}else{
		if ($esic > 0 || $cpf >0 || $cpfad>0 || $edl > 0 || $edlad > 0){
			$insRes=$obj->insert("mnthcompcont", $fld, $val);
		}
	}

$set->redirect("salView?ec=$ec&mnth=$mnth&yr=$yr");
?>