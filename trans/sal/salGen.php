<?
//error_reporting(E_ALL);
require ("../../config/setup.inc");




$title="Salary slip Generation";

require($rpath."pageDesign.tmp.php");


$mntArray=array( "", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");


$emp=new empManagement();


require ($root."lib/datetime/datetimepicker_css_js.php");

$ec=$_REQUEST['ec'];
$mnth=$_REQUEST['mnth'];
$yr=$_REQUEST['yr'];
$nnth=intval($mnth);


$days=cal_days_in_month(CAL_GREGORIAN,$mnth, $yr);

$days=($days < 30) ? 30 : $days;

$mstRes=$obj->select("empmaster", "empCode='$ec'");
$mstFres=$obj->fetchrow($mstRes);

$atnRes=$obj->Select("attendancedet", "empCode='$ec' and attnMonth='$mnth' and attnYear='$yr'");
$atnFres=$obj->fetchrow($atnRes);

$twd=$atnFres[4];
$atn=$atnFres[5];
$lwp=$atnFres[6];

$basic=$mstFres[35];

$pdBasic=$basic / $days;
$lwpAmnt=$pdBasic * $lwp;

$netBasic=$basic - $lwpAmnt;
$roundBasic=round($netBasic);
?>

<div class="contDiv">
	<h2 style="border-bottom:solid 1px #333333">Salary Slip Generation of <?= $mstFres[3]?> for the month of <?= $mntArray[$nnth]?>, <?= $yr?></h2>
  <form id="form1" name="form1" method="post" action="salGenBack">
  	<table width="100%" border="0" cellspacing="0" cellpadding="3">
      <tr>
        <td>Basic Salary <input name="ec" type="hidden" value="<?= $ec?>" /><input name="mnth" type="hidden" value="<?= $mnth?>" /><input name="yr" type="hidden" value="<?= $yr?>" /></td>
        <td><input name="basic" type="text" value="<?= sprintf("%0.2f", $roundBasic)?>" size="10" readonly="readonly" /></td>
      </tr>
	 <?
	  $esRes=$obj->select("empallowance", "empCode='$ec' and effTyp=1 and amount > 0");
	  while ($esFres=$obj->fetchrow($esRes)){
	  	$amRes=$obj->select("allowancemaster", "alwID=$esFres[2]");
		$amFres=$obj->fetchrow($amRes);
		
		if ($esFres[4]==1){
			if ($esFres[5]==2){
				$amnt=$esFres[3] * $atn;
				
			}elseif ($esFres[5]==1){
				if ($lwp<1){
					$amnt=$esFres[3];
				}else{
					$amnt=$esFres[3]*($days-$lwp)/ $days;
				}
			}
		}elseif($esFres[4]==2){
			if ($esFres[5]==1){
				
				$amnt=($netBasic*$esFres[3])/100;
				
				
			}elseif($esFres[5]==2){
				
				$amnt=($pdBasic * $esFres[3]/100) * $atn;
			
			}
		}
		
		$roundAmnt=round($amnt);
		
	  ?>
      <tr>
        <td><?= $amFres[1]?><input name="amid[]" type="hidden" value="<?= $amFres[0]?>" /><input type="hidden" name="phd[]" value="<?= $amFres[1]?>" /></td>
        <td><input type="text" name="amt[]" id="amt[]" value="<?= sprintf("%0.2f", $roundAmnt)?>" size="10"/></td>
      </tr>
     
	  <? }?>
	   <tr>
        <td>&nbsp;</td>
        <td><input name="bsav" type="submit" id="bsav" value="Generate" /></td>
      </tr>
    </table>
  
  </form>
</div>

