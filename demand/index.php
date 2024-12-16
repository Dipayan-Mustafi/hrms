<?php
//error_reporting(E_ALL);
require ("../config/setup.inc");

$title="Demand Generation";

require($rpath."pageDesign.tmp.php");
require ($root."lib/loan/Class.AccountsManager.php");

require($root."lib/loan/Class.DemandManager.php");

$dman=new DemandMan();
$aman=new AccountsManager();





$mnthArray=array("", "Jan", "Feb","Mar","Apr","May","Jun", "Jul","Aug","Sep","Oct","Nov","Dec");


$curYear=date('Y');
$curMonth=date('m');
$nxtMonth=$curMonth +1;
if ($mxtMonth > 12){
   $curYear=$curYear+1;
   $nxtMonth="01";
}else{
  $nxtYear=$curYear;
  $nxtMonth=sprintf("%02d", $nxtMonth);
}

$mnth=($_REQUEST['mnth']) ? $_REQUEST['mnth'] : date('m');
$yr=($_REQUEST['yr']) ? $_REQUEST['yr'] : date('Y');



$curMonth=sprintf("%02d", $curMonth);



$fyr=$misc->currentfinyear($curYear, $curMonth);

?>
<style type="text/css">
	
	.demandHBox{
		width: 100%;
		display: table;
		font-weight: bold;
		padding: 0.5%;
		border: dotted 1px #666666;
		border-radius: 5px;
		margin-bottom: 4px;
	}
	.demandTBox{
		width: 99%;
		display: table;
		
		padding: 0.5%;
		border: dotted 1px #666666;
		border-radius: 5px;
		margin-bottom: 4px;
	}
	.dCell{
		float: left;
		text-align: center;
		padding: 3px;
		
	}
</style>
<script type="text/javascript" src="<?= $rurl?>datetime/datetimepicker_css.js"></script>
<script type="text/javascript">
function genDemand(){

	window.open("genBack", "popup", "height=500, width=600, top=50, left=100, resize=Yes, scrollbars=Yes, toolbars=No");

	
}
</script>
<div class="contDiv">
	
		<h2>Demand Generation</h2>
		<form name="form1" method="POST" action="genBack" target="popup">
			<table width="100%" border="0" cellpadding="3" cellspacing="0">
			<tr>
			  <td valign="top" align="left">From</td>
			  <td valign="top" align="left"><input type="date" name="dt[]" size="12" id="dt1" onClick="javascript:NewCssCal('dt1','yyyyMMdd','','','','','past');"  /></td>
			  <td valign="top" align="left">To</td>
			  <td valign="top" align="left"><input type="date" name="dt[]" size="12" id="dt2" onClick="javascript:NewCssCal('dt2','yyyyMMdd','','','','','past');"  /></td>
			  <td valign="top" align="left"></td>
			  </tr>
			<tr>
				<td valign="top" align="left">Select Month</td>
				<td valign="top" align="left">
					<select name="mnth" >
						<?
						for ($i=1;$i<=12; $i++){
							$j=sprintf("%02d",$i);
							
							if ($mnth==$j){
								print "<option value='$j' selected>".$mnthArray[$i]."</option>";
							}else{
								print "<option value='$j'>".$mnthArray[$i]."</option>";
							}
						}
						?>
					</select>				</td>
				<td valign="top" align="left">Year</td>
				<td valign="top" align="left">
					<select name="yr">
						<?
						for ($i=(date('Y')-2);$i<=date('Y'); $i++){
							
							
							if ($yr==$i){
								print "<option value='$i' selected>$i</option>";
							}else{
								print "<option value='$i'>$i</option>";
							}
						}
						?>
					</select>				</td>
				<td valign="top" align="left"></td>
			</tr>
			<tr>
				<td valign="top" align="left">Area</td>
				<td valign="top" align="left" colspan="2"><select name="area[]" multiple="multiple" size="10" style="width:70mm;">
				<?php 
				
				$offRes=$obj->select("officemaster");
				while ($offFres=$obj->fetchrow($offRes)){
					
					print "<option value='$offFres[0]'>$offFres[1]</option>";


				}
				
				?>
				
				
				
				</select></td>
				
				<td valign="top" align="left"><input type="submit" name="bGen" value="Generate" onclick="genDemand();" /></td>
				</tr>
		</table>
			
		</form>
		
	
</div>
<?
if ($_REQUEST['bGen']){
	$shtYr=substr($yr,2,2);
	$cfyr=$misc->currentfinyear($shtYr, $mnth);
	
	$chkRes=$obj->select("demandmast", "demandMonth='$mnth' and demandYear='$yr'");
	$chkRows=$obj->rows($chkRes);
	if ($chkRows <1){
		$lastCode=$obj->lastID("demandmast", "demandIndex", "finYear='$cfyr'");
		$lastCode++;
		$dNo="DMD/".sprintf("%04d", $lastCode)."/$cfyr";
		$dfyr=$cfyr;
	}else{
		$chkFres=$obj->fetchrow($chkRes);
		$lastCode=$chkFres[3];
		$dNo=$chkFres[2];
		$dfyr=$chkFres[4];
	}
	
	
	$memRes=$obj->select("membermast", "memTyp=1");
	while ($memFres=$obj->fetchrow($memRes)){
		$mcode=($fres[29]) ? $fres[29] : $fres[0];
		$sumInst=$obj->sumfield("acntmaster", "instAmount", "acntTyp=1 and acntStat=1 and custCode='$mcode'");
		
		
		
		$fld="memID, demandNo, demandIndex, finYear, thriftFund,wFund,rdFund, demandMonth, demandYear, ddoID";
		$val="$memFres[0],'$dNo', $lastCode, '$dfyr',$memFres[24],$memFres[26],$sumInst,'$mnth', '$yr', $memFres[14]";
		
		$insRes=$obj->ChkInsert("demandmast", "demandMonth='$mnth' and demandYear='$yr' and memID=$memFres[0]",$fld,$val);
		if (!$insRes){
			$upFld="thriftFund=$memFres[21],wFund=$memFres[23], rdFund=$memFres[22]";
			$upRes=$obj->update("demandmast",$upFld,"demandMonth='$mnth' and demandYear='$yr' and memID=$memFres[0] and LmID=0");
		}
	}
	
	$mlRes=$obj->select("loanmem", "endFlg=1");
	while ($mlFres=$obj->fetchrow($mlRes)){
		
		$totRepay=$obj->sumfield("loanrepaylist","amount" ,"LmID=$mlFres[0]");
		$totDem=$obj->sumfield("demandmast", "prinPay", "LmID=$mlFres[0] and prinRcv=0 and (demandMonth<>'$mnth' and demandYear<>'$yr') and endFlg=0");
		
		$lastPayDate=$obj->LastID("loanrepaylist", "repayDate", "LmID=$mlFres[0]");
		if ($lastPayDate){
			$expLPD=explode("-",$lastPayDate);
			$tmDiff=mktime(0,0,0,$mnth,date('Y'),$yr)-mktime(0,0,0,$expLPD[1],$expLPD[2],$expLPD[0]);
			$dayDiff=intval($tmDiff / (24*60*60));
			if ($dayDiff >30){
				$mnthDiff=intval($dayDiff / 30);
			}else{
				$mnthDiff=1;
			}
		}else{
			$mnthDiff=1;
		}
		
		
		
		
		$baltoRefund=$mlFres[8]-$totRepay;
		if ($mnthDiff==1){
			$interest=$baltoRefund * (($mlFres[13]*$mnthDiff)/(100*12));
		}elseif ($mnthDiff==2){
			$interest=$baltoRefund * (($mlFres[13]*$mnthDiff)/(100*12));
		}elseif ($mnthDiff==3){
			$double=$mnthDiff+1;
			$interest=$baltoRefund * (($mlFres[13]*$double)/(100*12));
		}elseif ($mnthDiff > 4)
		$expInt=explode(".",$interest);
		
		$intAmount=round($interest,0);
		
		$prin=($baltoRefund > $mlFres[18]) ? $mlFres[18] : $baltoRefund;
		$balAmount=$baltoRefund-$prin;
		$instNo=intval($balAmount/$mlFres[18]);
		$mstRes=$obj->select("membermast", "memID=$mlFres[3]");
		$mstFres=$obj->fetchrow($mstRes);
		$ddo=$mstFres[14];
		
		$fld="memID, demandNo, demandIndex, finYear,LoanID,LmID,prinPay,intPay, demandMonth, demandYear, ddoID, installmentno,balanceAmount,balanceInst";
    	$val="$mlFres[3],'$dNo', $lastCode, '$dfyr',$mlFres[4],$mlFres[0],$prin,$intAmount,'$mnth',$yr,$ddo, $instNo,$balAmount,$instNo ";
		
        //print "$val<br>";
    	$dmInsRes=$obj->ChkInsert("demandmast", "demandMonth='$mnth' and demandYear='$yr' and memID=$mlFres[3] and LmID=$mlFres[0]",$fld,$val);
		if (!$dmInsRes){
			$upRes=$obj->update("demandmast", "prinPay=$prin,intPay=$intAmount,balanceAmount=$balAmount,balanceInst=$instNo", "demandMonth='$mnth' and demandYear='$yr' and LmID=$mlFres[0]");
		}
		
		
		
	}
	
	
	
	
	

	$set->redirect("viewDemand?m=$mnth&y=$yr");
}
?>