<?
require ("../../config/setup.inc");

$title="Salary Deduction Area";

require($rpath."pageDesign.tmp.php");


$ec=$_REQUEST['ec'];
$mnth=$_REQUEST['mnth'];

$yr=$_REQUEST['yr'];

$empRes=$obj->select("empmaster", "empCode='$ec'");
$empFres=$obj->fetchrow($empRes);

$sumRcv=$obj->sumfield("empsaldet", "payAmount", "empCode='$ec' and salMonth='$mnth' and salYear='$yr'  and headTyp=1");

$salRes=$obj->select("empsaldet", "empCode='$ec' and salMonth='$mnth' and salYear='$yr' and headTyp=1 order by alwID");
while ($salFres=$obj->fetchrow($salRes)){
	
	if ($salFres[11]<1){
		$ecalAmnt=$salFres[9];
		$pcalAmnt=$salFres[9];
	}else{
		$chkRes=$obj->select("allowancemaster", "alwID=$salFres[11]");
		$chkFres=$obj->fetchrow($chkRes);
		
		if ($chkFres[6]==1){
			$ecalAmnt=$ecalAmnt+$salFres[9];
			
		}
		
		if ($chkFres[7]==1){
			$pcalAmnt=$pcalAmnt+$salFres[9];
		}
	
	
	}
	
	


}

$scRes=$obj->select("salconfig");
$scFres=$obj->Fetchrow($scRes);


$ptRes=$obj->select("ptaxmast", "stAmnt <='$sumRcv' and endAmnt>='$sumRcv'");

$ptRows=$obj->rows($ptRes);

$ptFres=$obj->fetchrow($ptRes);

$esiSlab=($sumRcv>=$scFres[1]) ? 0 : $sumRcv;


$oesi=($empFres[29]==1) ? (($esiSlab * $scFres[2])/100) : 0; 
$expOesi=explode(".", $oesi);
if (intval($expOesi[1]) > 0){
	$oesi=$expOesi[0]+1;
}


$cesi=($empFres[29]==1) ? (($esiSlab * $scFres[3])/100) : 0; 

$expCesi=explode(".", $cesi);
if (intval($expCesi[1]) > 0){
	$cesi=$expCesi[0]+1;
}



if ($empFres[30]==1){
	$psSlab=($pcalAmnt >$scFres[8]) ? $scFes[8] : $pcalAmnt;
	
	$epf=$pcalAmnt * $scFres[4] /100;
	
	
	$cps=$psSlab * $scFres[7] /100;
	$cpf=($pcalAmnt * $scFres[4] / 100) - $cps;
	$cedl=$pcalAmnt * $scFres[9] / 100;
	$cpfAdm=$pcalAmnt * $scFres[6] /100;
	$cedlAdm=$pcalAmnt * $scFres[10] /100;

}else{
	$epf=0;
	$cps=0;
	$cpf=0;
	$cedl=0;
	$cpfAdm=0;
	$cedlAdm=0;
}

$totDed=$ptFres[3]+ round($oesi)+ round($epf);
$totEC=round($cesi)+round($cpf)+round($cps)+round($cedl)+round($cpfAdm)+round($cedlAdm);
?>

<div class="contDiv">
  <form name="form1" method="post" action="dedBack">
    <table width="100%" border="0" cellspacing="0" cellpadding="3">
      <tr>
        <th align="left" valign="top" scope="col">Deduction Procedure <input name="ec" type="hidden" value="<?= $ec?>" /><input name="mnth" type="hidden" value="<?= $mnth?>" /><input name="yr" type="hidden" value="<?= $yr?>" /></th>
        <th align="left" valign="top" scope="col">&nbsp;</th>
        <th align="left" valign="top" scope="col">Amount</th>
      </tr>
      <tr>
        <td align="left" valign="top">Total Receive </td>
        <td align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top"><input type="text" name="totRcv" size="10" value="<?= sprintf("%0.2f", round($sumRcv))?>"></td>
      </tr>
      <tr>
        <td align="left" valign="top"><strong>Professional Tax </strong></td>
        <td align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top"><input type="text" name="pt" size="8" value="<?= $ptFres[3]?>" readonly="true" /></td>
      </tr>
      <tr>
        <td align="left" valign="top"><strong>ESI Deduction </strong></td>
        <td align="left" valign="top"><?= $scFres[2]?> %</td>
        <td align="left" valign="top"><input name="esi" type="text" value="<?= sprintf("%0.2f", round($oesi));?>" size="8" readonly="true" /></td>
      </tr>
      <tr>
        <td align="left" valign="top">ESI Contribution</td>
        <td align="left" valign="top"><?= $scFres[3]?> %</td>
        <td align="left" valign="top"><input name="esic" type="text" value="<?= sprintf("%0.2f", round($cesi))?>" size="8" readonly="true" /></td>
      </tr>
      <tr>
        <td align="left" valign="top"><strong>EPF Deduction</strong></td>
        <td align="left" valign="top"><?= $scFres[4]?> %</td>
        <td align="left" valign="top"><input name="epf" type="text" value="<?= sprintf("%0.2f", round($epf))?>" size="8" readonly="true" /></td>
      </tr>
	   <tr>
        <td align="left" valign="top">EPF Contribution</td>
        <td align="left" valign="top"><?= $cpf/$pcalAmnt *100?> %</td>
        <td align="left" valign="top"><input name="cpf" type="text" value="<?= sprintf("%0.2f", round($cpf))?>" size="8" readonly="true" /></td>
      </tr>
	  <tr>
        <td align="left" valign="top">EPS Contribution</td>
        <td align="left" valign="top"><?= $cps/$pcalAmnt *100?> %</td>
        <td align="left" valign="top"><input name="cps" type="text" value="<?= sprintf("%0.2f", round($cps))?>" size="8" readonly="true" /></td>
      </tr>
	  <tr>
        <td align="left" valign="top">EPF Admin</td>
        <td align="left" valign="top"><?= $cpfAdm/$pcalAmnt *100?> %</td>
        <td align="left" valign="top"><input name="cpfad" type="text" value="<?= sprintf("%0.2f",round($cpfAdm))?>" size="8" readonly="true" /></td>
      </tr>
	   <tr>
        <td align="left" valign="top">EDLI Charges</td>
        <td align="left" valign="top"><?= $cedl/$pcalAmnt *100?> %</td>
        <td align="left" valign="top"><input name="edl" type="text" value="<?= sprintf("%0.2f", round($cedl))?>" size="8" readonly="true" /></td>
      </tr>
	   <tr>
        <td align="left" valign="top">EDLI Admin Charges</td>
        <td align="left" valign="top"><?= $cedlAdm/$pcalAmnt *100?> %</td>
        <td align="left" valign="top"><input name="edlad" type="text" value="<?= sprintf("%0.2f",round($cedlAdm))?>" size="8" readonly="true" /></td>
      </tr>
      <tr>
        <td align="left" valign="top"><strong>Total Deduction </strong></td>
        <td align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top"><input name="totDed" type="text" id="totDed" size="10" value="<?= sprintf("%0.2f", $totDed)?>" readonly="true" /></td>
      </tr>
      <tr>
        <td align="left" valign="top"><strong><em>Total Employer's Contribution </em></strong></td>
        <td align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top"><input name="totEC" type="text" id="totEC" size="10" value="<?= sprintf("%0.2f", $totEC)?>"  /></td>
      </tr>
      <tr>
        <td align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top"><input name="bSav" type="submit" id="bSav" value="Save" /></td>
      </tr>
    </table>
  </form>
</div>
