<?php

require ("../../config/setup.inc");

$title="Leave Settlement";

require($rpath."pageDesign.tmp.php");

$ec=$_REQUEST['ec'];
$mnth=$_REQUEST['mnth'];
$yr=$_REQUEST['yr'];

$days=cal_days_in_month(CAL_GREGORIAN,$mnth, $yr);

$atnRes=$obj->select("attendancedet", "empCode='$ec' and attnMonth='$mnth' and attnYear='$yr'");
$atnFres=$obj->fetchrow($atnRes);

$twd=$atnFres[3];
$psnt=$atnFres[4];
$lat=($atnFres[7]) ? $atnFres[7] : ($atnFres[4] - $atnFres[5]);



$lev=$twd-$psnt;

$latLev=intval($lat/3);

$balAdjLev=$lev+$latLev;


$lvRes=$obj->select("leaveconfig");

while ($lvFres=$obj->fetchrow($lvRes)){
	$id=$lvFres[0];
	$pr=($lvFres[5]>0) ? 2 :1;
	$prArray[$id] = $pr;

}
		



?>
<div class="contDiv">
<form id="form1" name="form1" method="post" action="levAdjBack">
  <table width="50%" border="0" cellspacing="0" cellpadding="3">
    <tr>
      <th align="left" valign="top">Description<input name="ec" type="hidden" value="<?= $ec?>" /><input name="mnth" type="hidden" value="<?= $mnth?>" /><input name="yr" type="hidden" value="<?= $yr?>" /></th>
      <th align="left" valign="top">Value</th>
    </tr>
    <tr>
      <td align="left" valign="top">Total Working days </td>
      <td align="left" valign="top"><input name="twd" type="text" value="<?= $twd?>" size="8" readonly="true" /></td>
    </tr>
    <tr>
      <td align="left" valign="top">Total Present </td>
      <td align="left" valign="top"><input name="tpsnt" type="text" value="<?= $psnt?>" size="8" readonly="true" /></td>
    </tr>
    <tr>
      <td align="left" valign="top">Total Late </td>
      <td align="left" valign="top"><input name="tlat" type="text" value="<?= $lat?>" size="8" readonly="true" /></td>
    </tr>
	 <tr>
      <td align="left" valign="top">Leave to Adjusted </td>
      <td align="left" valign="top"><input name="tmlev" type="text" value="<?= $balAdjLev?>" size="8" readonly="true" /></td>
    </tr>
	<?
	$emlRes=$obj->select("emplevconfig", "empCode='$ec' and finYear='$yr' order by prior");
	while ($emlFres=$obj->fetchrow($emlRes)){
		$lvRes=$obj->select("leaveconfig", "levID=$emlFres[1]");
		$lvFres=$obj->fetchrow($lvRes);
		
		$lid=$lvFres[0];
		
		$prior=$prArray[$lid];
		
		if ($prior==1){
		
			$totGrntLev=$obj->sumfield("emplevconfig", "qty", "empCode='$ec' and finYear='$yr' and levID=$lid");
			$totTakLev=$obj->sumfield("attnlevdet", "qty", "empCode='$ec' and levYear='$yr' and levID=$lid and levMonth<'$mmth'");
			
			$balLev=$totGrntLev-$totTakLev;
			
			$adjLev= ($balLev > $balAdjLev) ? $balAdjLev : $balLev;
			
			$balAdjLev=$balAdjLev - $adjLev;
			
			
		
		}else{
			$totGrntLev=$obj->sumfield("emplevconfig", "qty", "empCode='$ec' and finYear='$yr' and levID=$lid");
			$totTakLev=$obj->sumfield("attnlevdet", "qty", "empCode='$ec' and finYear='$yr' and levID=$lid");
			
			$balLev=$totGrntLev-$totTakLev;
			
			$adjLev= ($balLev > $balAdjLev) ? $balAdjLev : $balLev;
			
			$balAdjLev=$balAdjLev - $adjLev;
		
		}
		
		$balAdjLev=($balAdjLev) ? $balAdjLev : 0;

	?>
    <tr>
      <td align="left" valign="top">Total <?= $lvFres[1]?><input name="levID[]" type="hidden" value="<?= $lid?>" /></td>
      <td align="left" valign="top"><input name="tlev[]" type="text" value="<?= $balLev?>" size="5" readonly="true" /></td>
    </tr>
	<tr>
      <td align="left" valign="top">Leave Adjusted from <?= $lvFres[1]?></td>
      <td align="left" valign="top"><input name="lev[]" type="text" value="<?= $adjLev?>" size="5" readonly="true" /></td>
    </tr>
	<? }?>
    <tr>
      <td align="left" valign="top">Leave Without Pay</td>
      <td align="left" valign="top"><input name="lwp" type="text" value="<?= $balAdjLev?>" size="5"  /></td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top"><input name="bSav" type="submit" id="bSav" value="Save &amp; Generate" /></td>
    </tr>
  </table>
</form>


	


</div>
