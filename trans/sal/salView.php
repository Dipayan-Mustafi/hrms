<?
require ("../../config/setup.inc");

$title="View of Pay Slip";

require($rpath."pageDesign.tmp.php");
$eman=new empManagement();
$dept=$_REQUEST['dept'];
$ecm=$_REQUEST['ec'];
$mnth=$_REQUEST['mnth'];
$yr=$_REQUEST['yr'];

$mntArray=array( "", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");

$n=intval($mnth);

$shrt=substr($yr,2);
	
$fyr=$misc->currentfinyear($shrt, $mnth);
?>
<script type="text/javascript">





</script>
<div class="contDiv">
		<div style="text-align:right"><img src="<?= $rurl?>images/print_icon.gif" width="24" alt="Print Slip" title="Print Salary Slip" height="24" style="cursor:pointer" onclick="PrintDiv('printArea', 'Salary Slip');" /></div>
		<div id="printArea" style="font-family:arial; font-size:9px; height:297mm">
<?
if($dept){
	$memRes=$obj->select("empmaster", "empDept='$dept' and empTyp=1");
}else if($ecm){
	$memRes=$obj->select("empmaster", "empCode='$ecm' and empTyp=1");
}
//print_r($memRes);
while($memFres=$obj->fetchrow($memRes)){
	$ec=$memFres[2];
		$mstRes=$obj->select("empmaster", "empCode='$ec'");
		$mstFres=$obj->fetchrow($mstRes);
	
	$mnth=sprintf("%02d", $mnth);
	$days=cal_days_in_month(CAL_GREGORIAN,$mnth, $yr);
	
	for ($i=1 ; $i<=$days; $i++){
		$mdt=sprintf("%02d",$i);
		$wkd=date('w', mktime(0,0,0,$mnth,$mdt,$yr));
		if ($wkd==0){
			$hday++;
		}
	
	}
					
	$fdt="$yr-$mnth-01";
	$ldt="$yr-$mnth-$days";
	
	// $hdSum=$obj->sumfield("holidaytable", "hdno", "hsDt >='$fdt' and hsDmt<='$ldt'");
	$hdSum=0;
	$hdRes=$obj->select("holidaytable",  "hsDt>='$fdt' and hsDt<='$ldt'");
	while ($hdFres=$obj->fetchrow($hdRes)){
		$expDt=explode("-", $hdFres[1]);
		
		$wkd=date('w', mktime(0,0,0,$mnth,$expDt[2],$expDt[0]));
		if ($wkd>0 ){
			 $hdSum++;
		}
		
	}
	
	
	$hday=$hday+$hdSum;//
	
	$working=$days-$hday;
	$dsgRes=$obj->select("desigmast", "dsgID=$mstFres[11]");
	$dsgFres=$obj->fetchrow($dsgRes);
	
	$dptRes=$obj->select("deptmanager", "deptID=$mstFres[12]");
	$dptFres=$obj->fetchrow($dptRes);
	
	
	$atRes=$obj->select("attendancedet", "empCode='$ec' and attnMonth='$mnth' and attnYear='$yr'");
	$atFres=$obj->fetchrow($atRes);
	
	
	$desig=($dsgFres[1]) ? $dsgFres[1]: "Not Specified";
	$esiNo=($mstFres[38]) ? $mstFres[38]: "NONE";
	
	if($mstFres[38]<2){
						$mnthCC=$eman->getMnthCont($ec, $mnth, $yr);
						
						$epfFst=$mnthCC[7]+$mnthCC[8]+$mnthCC[9]+$mnthCC[10]+$mnthCC[11];
						
						$expPF=explode(".", $epfFst);
						if($expPF[1]>0){
							$epfCC=round($epfFst);
						}else{
							$epfCC=$expPF[0];
						}
						}else{
							$epfCC=0;
						}
						
						$pfCont=($epfCC) ? $epfCC : 0;
						$esiCont=($mnthCC[6]) ? $mnthCC[6] : "-";
				
				$dtRes=$obj->select("empsaldet", "empCode='$ec' and salMonth='$mnth' and salYear='$yr'");
				
				$dtFres=$obj->fetchrow($dtRes);
?>	
	
	
	
	
			<div class="divLine" style="font-size:14px; border-bottom:1px solid; height:65; width:100%">
			<div class="divCell" style="border-right:1px solid; width:60%; float:left">
			 	<img src="<?= $rurl?>images/kanchan.png" width="100%" height="65" style="float:left;"/>
			</div>
			<div class="divCell" style="text-align:left; width:35%; float:left; margin-left:5px">
				 Pay Slip for the month of <?= $mntArray[$n]?>, <?= $yr?><p> Date of Payment: <?=$misc->dateformat($dtFres[15])?></p>
			</div>
			</div>
			<table width="100%" border="0" cellspacing="1" cellpadding="3" style="font-family:arial; font-size:9px">
			 
			  <tr>
				<td width="18%" align="left" valign="middle">Name</td>
				<td width="5%" align="left"><img border="0" src="<?= $rurl?>images/emp_name.png" height="20" alt="Name" title="Name" /></td>
				<td width="28%"><strong>: </strong><?= $mstFres[3]?></td>
				<td align="left">Total Working Days</td>
				<td width="4%" align="left"><img border="0" src="<?= $rurl?>images/total_working_days.png" height="16" alt="Total Working Days" title="Total Working Days" /></td>
				<td width="25%"><strong>: </strong><?= $working?></td>
			  </tr>
			  <tr>
				<td align="left" valign="middle">Designation</td>
				<td align="left"><img border="0" src="<?= $rurl?>images/desig.png" height="20" alt="Designation" title="Designation" /></td>
				<td><strong>: </strong><?= $desig?></td>
				<td align="left">Paid Holidays</td>
				<td align="left"><img border="0" src="<?= $rurl?>images/leave_of_absence.png" height="16"/></td>
				<td><strong>: </strong><?= $hday?></td>
			  </tr>
			  <tr>
				<td align="left" valign="middle">Department</td>
				<td align="left"><img border="0" src="<?= $rurl?>images/dept.png" height="20" alt="Department" title="Department" /></td>
				<td align="left" valign="middle"><strong>: </strong><?= $dptFres[1]?></td>
				<td align="left" >Present</td>
				<td align="left"><img border="0" src="<?= $rurl?>images/present.png" height="16" alt="Total Working Days" title="Total Working Days" /></td>
				<td><strong>: </strong><?= $atFres[4]?></td>
			  </tr>
			  <tr>
				<td align="left">Late</th>
				<td align="left"><img border="0" src="<?= $rurl?>images/late.png" height="16" alt="Late" title="Late" /></th>
				<td><strong>: </strong><?= $atFres[7]?></td>
				<td align="left">Leave Details
				<td align="left"><img border="0" src="<?= $rurl?>images/leave_details.png" height="16" /></th>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td align="left">Leave Without Pay </th>
				<td align="left"><img border="0" src="<?= $rurl?>images/leave_without_pay.png" height="18" alt="Leave_without_pay" title="Leave_WIthout_Pay" /></th>
				<td align="left" valign="top"><strong>: </strong><?= $atFres[6]?></td>
				<td colspan="3" rowspan="3" align="left" valign="top">
				<table width="100%" border="1" cellspacing="0" cellpadding="3" style="font-family:arial; font-size:9px">
				  <tr>
					<td width="17%">Name</th>
					<td width="19%">Total</th>
					<td width="18%">Previous</th>
					<td width="23%">Current</td>
					<td width="23%">Balance</td>
				  </tr>
				  <?
					$mnth=sprintf("%02d", $mnth);
					$grntLeave=0;
					$prvLeave=0;
					$current=0;
					$balLeave=0;
					$totLeav=0;
					$levRes=$obj->select("leaveconfig");
					$levRows=$obj->rows($levRes);
					while ($levFres=$obj->fetchrow($levRes)) {
						$lid=$levFres[0];
						
						
						if($levFres[3]==0){
							$lastDt=$obj->lastID("emplevconfig", "createDate", "levID=$levFres[0] and empCode='$ec' and finYear='$fyr'");
							$prvLeave=$obj->sumfield("attnlevdet", "qty", "levID=$levFres[0] and empCode='$ec' and levMonth<'$mnth' and levYear='$yr'");
													
							
							$grntLeave=$obj->sumfield("emplevconfig", "qty", "levID=$levFres[0] and empCode='$ec' and finYear='$fyr'");
						}else{
							$prvLeave=$obj->sumfield("attnlevdet", "qty", "levID=$levFres[0] and empCode='$ec' and levMonth<'$mnth' and levYear='$yr'");
							$grntLeave=$obj->sumfield("emplevconfig", "qty", "levID=$levFres[0] and empCode='$ec' and finYear='$fyr'");
						}
						
						$prvLeave=($prvLeave) ? $prvLeave : 0;
						
		
						$current=$obj->sumfield("attnlevdet", "qty", "levID=$levFres[0] and empCode='$ec' and levMonth='$mnth' and levYear='$yr'");
						$current=($current) ? $current : 0;
						$balLeave=$grntLeave - ($totLeav+$prvLeave)-$current;
				  ?>
				  <tr>
					<td align="center" valign="top"><?= $levFres[1]?></td>
					<td align="center" valign="top"><?= $grntLeave?></td>
					<td align="center" valign="top"><?= $prvLeave?></td>
					<td align="center" valign="top"><?= $current?></td>
					<td align="center" valign="top"><?= $balLeave?></td>
				  </tr>
				  <?
				  }
				  ?>
				</table></td>
			  </tr>
			  <tr>
				<td align="left">ESI No. </td>
				<td align="left"><img border="0" src="<?= $rurl?>images/esi_no.png" height="20" alt="E.S.I No." title="E.S.I No." /></td>
				<td align="left"><strong>: </strong><?= $esiNo?></td>
			  </tr>
			  <tr>
				<td align="left" valign="middle">EPF No. </td>
				<td align="left" valign="top"><img border="0" src="<?= $rurl?>images/pf_no.png" height="16" alt="E.P.F No." title="E.P.F No." /></td>
				<td align="left" valign="middle"><strong>: </strong><?= $mstFres[31]?></td>
			  </tr>
			  <tr>
				<td align="left">Allowance</td>
				<td align="left">&nbsp;</td>
				<td align="right" valign="bottom">Rs. <img border="0" src="<?= $rurl?>images/rs.png" height="16" alt="Amount" title="Amount" /></td>
				<td colspan="2" align="left" valign="top">Deductions</td>
				<td align="right" valign="top">Rs. <img border="0" src="<?= $rurl?>images/rs.png" height="16" alt="Amount" title="Amount" /></td>
			  </tr>
			 
			  <tr>
				<td colspan="3" align="left" valign="top" style="border-right:solid 1px #333333">
					<table width="100%" border="0" cellspacing="0" cellpadding="3" style="font-family:arial; font-size:9px">
					<?
					$mnth=sprintf("%02d", $mnth);
					$salRes=$obj->select("empsaldet", "empCode='$ec' and salMonth='$mnth' and salYear='$yr' and headTyp=1");
					//print_r($salRes);
					while ($salFres=$obj->fetchrow($salRes)) {
						
						$allwRes=$obj->select("allowancemaster", "name='$salFres[6]'");
						$allwRows=$obj->rows($allwRes);
						$allwFres=$obj->fetchrow($allwRes);
						
						$imgPath=$rurl."images/".$allwFres[12];
					?>
					  <tr>
					<? if($allwRows>0){?>
						<td align="left"><?= $salFres[6]?>  <img border="0" src="<?=$imgPath?>" height="16" alt="alw" title="alw" /></td>
					<? }else{
					?>	<td align="left"><?= $salFres[6]?></td>
					<?
					}
					?>
						<td align="right"><?= $salFres[9]?></td>
					  </tr>
					 <?
						$grossAll=$grossAll+$salFres[9];
					 }
					 ?>
					</table>				</td>
				<td colspan="3" align="left" valign="top">
				<table width="100%" border="0" cellspacing="0" cellpadding="3" style="font-family:arial; font-size:9px">
				  <?
				$salRes=$obj->select("empsaldet", "empCode='$ec' and salMonth='$mnth' and salYear='$yr' and headTyp=2");
				while ($salFres=$obj->fetchrow($salRes)) {
					
				
				?>
				  <tr>
					<td align="left"><?= $salFres[6]?></td>
					<td align="right" valign="top"><?= $salFres[9]?></td>
				  </tr>
				 <?
					$grossDed=$grossDed+$salFres[9];
				 }
				 ?>
				</table></td>
			  </tr>
			  <tr>
				<td align="left">Total</td>
				<td align="left"><img src="<?= $rurl?>images/total.png" alt="total" height="16" border="0" /></td>
				<td align="right" valign="top" style="border:solid 1px #333333; border-left:none;"><?= sprintf("%0.2f", $grossAll)?></td>
				<td align="left">Total</td>
				<td align="left"><img src="<?= $rurl?>images/total_deduction.png" alt="total" height="16" border="0" /></td>
				<td align="right" valign="top" style="border:solid 1px #333333; border-left:none; border-right:none;"><?= sprintf("%0.2f", $grossDed)?></td>
			  </tr>
			  <?
			  $netPay=$grossAll - $grossDed;
			  
			  ?>
			  <tr>
				<td align="left" valign="top" >Net Pay </td>
				<td align="left" valign="top" ><img src="<?= $rurl?>images/net_payable.png" alt="total" height="16" border="0" /></td>
				<td align="right" valign="top" ><?= sprintf("%0.2f", $netPay)?></td>
				<td colspan="2" align="left" valign="top">Gross Sallary:</td>
				<td align="right" valign="top"><?= sprintf("%0.2f", $netPay)?></td>
			  </tr>
			  <tr>
				<td height="24" colspan="3" align="left" valign="top" >In words: Rupees
                <?= convert_number($netPay, "Paise");?></td>
				<td colspan="2" align="left" valign="top">Employers Contribuion to PF:</td>
			    <td align="right" valign="top"><?=$pfCont?></td>
			  </tr>
			  <tr>
				<td height="34" colspan="2" rowspan="2" align="left" valign="top" >&nbsp;</td>
				<td rowspan="2" align="left" valign="top">&nbsp;</td>
				<td colspan="2" align="left" valign="top">Employers Contribution to E.S.I:</td>
				<td align="right" valign="top"><?=$esiCont?></td>
			  </tr>
			  <tr>
			    <td colspan="2" align="left" valign="top">Total Salary (CTC) per Month:</td>
		        <? 
				$ctc=$esiCont+$pfCont+$netPay;
				?>
		        <td align="right" valign="top" style="border-top:1px solid; border-bottom:1px solid"><?=$ctc?></td>
			  </tr>
			  <tr>
				<td colspan="2" align="left" valign="top" style="border-top:solid 1px #333333;">Receipient Signature </td>
				<td align="center" valign="top" style="border-top:solid 1px #333333;">Authorised Signatory</td>
				<td colspan="2" align="center" valign="top">&nbsp;</td>
				<td align="left" valign="top">&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan="2" align="left" valign="top" ><img src="<?= $rurl?>images/emp_sig.png" alt="signature" height="16" border="0" /></td>
				<td align="center" valign="top">&nbsp;</td>
				<td colspan="2" align="center" valign="top">&nbsp;</td>
				<td align="left" valign="top">&nbsp;</td>
			  </tr>
			</table>
		
		<div class="divLine" style="border-bottom:1px dotted; width:100%;">&nbsp;</div>
		<div class="divLine" style="font-size:14px; border-bottom:1px solid; height:65; margin-top:10px; width:100%">
			<div class="divCell" style="border-right:1px solid; width:60%; float:left">
			 	<img src="<?= $rurl?>images/kanchan.png" width="100%" height="65" style="float:left;"/>
			</div>
			<div class="divCell" style="text-align:left; width:35%; margin-left:5px; float:left">
			 Pay Slip for the month of 
			 <?= $mntArray[$n]?>
			 , 
			 <?= $yr?><p> Date of Payment: <?=$misc->dateformat($dtFres[15])?>
			</div>
		  </div>
			<table width="100%" border="0" cellspacing="1" cellpadding="3" style="font-family:arial; font-size:9px">
			  <tr>
				<td width="18%" align="left" valign="middle">Name</td>
				<td width="5%" align="left"><img border="0" src="<?= $rurl?>images/emp_name.png" height="20" alt="Name" title="Name" /></td>
				<td width="28%"><strong>: </strong><?= $mstFres[3]?></td>
				<td align="left">Total Working Days</td>
				<td width="4%" align="left"><img border="0" src="<?= $rurl?>images/total_working_days.png" height="16" alt="Total Working Days" title="Total Working Days" /></td>
				<td width="25%"><strong>: </strong><?= $working?></td>
			  </tr>
			  <tr>
				<td align="left" valign="middle">Designation</td>
				<td align="left"><img border="0" src="<?= $rurl?>images/desig.png" height="20" alt="Designation" title="Designation" /></td>
				<td><strong>: </strong><?= $desig?></td>
				<td align="left">Paid Holidays</td>
				<td align="left"><img border="0" src="<?= $rurl?>images/leave_of_absence.png" height="16"/></td>
				<td><strong>: </strong><?= $hday?></td>
			  </tr>
			  <tr>
				<td align="left" valign="middle">Department</td>
				<td align="left"><img border="0" src="<?= $rurl?>images/dept.png" height="20" alt="Department" title="Department" /></td>
				<td align="left" valign="middle"><strong>: </strong><?= $dptFres[1]?></td>
				<td align="left" >Present</td>
				<td align="left"><img border="0" src="<?= $rurl?>images/present.png" height="16" alt="Total Working Days" title="Total Working Days" /></td>
				<td><strong>: </strong><?= $atFres[4]?></td>
			  </tr>
			  <tr>
				<td align="left">Late</th>
				<td align="left"><img border="0" src="<?= $rurl?>images/late.png" height="16" alt="Late" title="Late" /></th>
				<td><strong>: </strong><?= $atFres[7]?></td>
				<td align="left">Leave Details
				<td align="left"><img border="0" src="<?= $rurl?>images/leave_details.png" height="16" /></th>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td align="left">Leave Without Pay </th>
				<td align="left"><img border="0" src="<?= $rurl?>images/leave_without_pay.png" height="18" alt="Leave_without_pay" title="Leave_WIthout_Pay" /></th>
				<td align="left" valign="top"><strong>: </strong><?= $atFres[6]?></td>
				<td colspan="3" rowspan="3" align="left" valign="top">
				<table width="100%" border="1" cellspacing="0" cellpadding="3" style="font-family:arial; font-size:9px">
				  <tr>
					<td width="17%">Name</th>
					<td width="19%">Total</th>
					<td width="18%">Previous</th>
					<td width="23%">Current</td>
					<td width="23%">Balance</td>
				  </tr>
				  <?
				  if($mstFres[38]<2){
						$mnthCC=$eman->getMnthCont($ec, $mnth, $yr);
						
						$epfFst=$mnthCC[7]+$mnthCC[8]+$mnthCC[9]+$mnthCC[10]+$mnthCC[11];
						
						$expPF=explode(".", $epfFst);
						if($expPF[1]>0){
							$epfCC=round($epfFst);
						}else{
							$epfCC=$expPF[0];
						}
						}else{
							$epfCC=0;
						}
						
						$pfCont=($epfCC) ? $epfCC : 0;
						$esiCont=($mnthCC[6]) ? $mnthCC[6] : "-";
				  	$mnth=sprintf("%02d", $mnth);
					$grntLeave=0;
					$prvLeave=0;
					$current=0;
					$balLeave=0;
					$totLeav=0;
					$levRes=$obj->select("leaveconfig");
					$levRows=$obj->rows($levRes);
					while ($levFres=$obj->fetchrow($levRes)) {
						$lid=$levFres[0];
						
						
						if($levFres[3]==0){
							$lastDt=$obj->lastID("emplevconfig", "createDate", "levID=$levFres[0] and empCode='$ec' and finYear='$fyr'");
							$prvLeave=$obj->sumfield("attnlevdet", "qty", "levID=$levFres[0] and empCode='$ec' and levMonth<'$mnth' and levYear='$yr'");
													
							
							$grntLeave=$obj->sumfield("emplevconfig", "qty", "levID=$levFres[0] and empCode='$ec' and finYear='$fyr'");
						}else{
							$prvLeave=$obj->sumfield("attnlevdet", "qty", "levID=$levFres[0] and empCode='$ec' and levMonth<'$mnth' and levYear='$yr'");
							$grntLeave=$obj->sumfield("emplevconfig", "qty", "levID=$levFres[0] and empCode='$ec' and finYear='$fyr'");
						}
						
						$prvLeave=($prvLeave) ? $prvLeave : 0;
						
		
						$current=$obj->sumfield("attnlevdet", "qty", "levID=$levFres[0] and empCode='$ec' and levMonth='$mnth' and levYear='$yr'");
						$current=($current) ? $current : 0;
						$balLeave=$grntLeave - ($totLeav+$prvLeave)-$current;
				  ?>
				  <tr>
					<td align="center" valign="top"><?= $levFres[1]?></td>
					<td align="center" valign="top"><?= $grntLeave?></td>
					<td align="center" valign="top"><?= $prvLeave?></td>
					<td align="center" valign="top"><?= $current?></td>
					<td align="center" valign="top"><?= $balLeave?></td>
				  </tr>
				  <?
				  }
				  ?>
				</table></td>
			  </tr>
			  <tr>
				<td align="left">ESI No. </td>
				<td align="left"><img border="0" src="<?= $rurl?>images/esi_no.png" height="20" alt="E.S.I No." title="E.S.I No." /></td>
				<td align="left"><strong>: </strong><?= $esiNo?></td>
			  </tr>
			  <tr>
				<td align="left" valign="middle">EPF No. </td>
				<td align="left" valign="top"><img border="0" src="<?= $rurl?>images/pf_no.png" height="20" alt="E.P.F No." title="E.P.F No." /></td>
				<td align="left" valign="middle"><strong>: </strong><?= $mstFres[31]?></td>
			  </tr>
			  <tr>
				<td align="left">Allowance</td>
				<td align="left">&nbsp;</td>
				<td align="right" valign="bottom">Rs. <img border="0" src="<?= $rurl?>images/rs.png" height="16" alt="Amount" title="Amount" /></td>
				<td colspan="2" align="left" valign="top">Deductions</td>
				<td align="right" valign="top">Rs. <img border="0" src="<?= $rurl?>images/rs.png" height="16" alt="Amount" title="Amount" /></td>
			  </tr>
			 
			  <tr>
				<td colspan="3" align="left" valign="top" style="border-right:solid 1px #333333">
					<table width="100%" border="0" cellspacing="0" cellpadding="3" style="font-family:arial; font-size:9px">
					<?
					$grossAll=0;
					$grossDed=0;
					$salRes=$obj->select("empsaldet", "empCode='$ec' and salMonth='$mnth' and salYear='$yr' and headTyp=1");
					while ($salFres=$obj->fetchrow($salRes)) {
						
						$allwRes=$obj->select("allowancemaster", "name='$salFres[6]'");
						$allwRows=$obj->rows($allwRes);
						$allwFres=$obj->fetchrow($allwRes);
						
						$imgPath=$rurl."images/".$allwFres[12];
					?>
					  <tr>
					<? if($allwRows>0){?>
						<td align="left"><?= $salFres[6]?>  <img border="0" src="<?=$imgPath?>" height="16" alt="alw" title="alw" /></td>
					<? }else{
					?>	<td align="left"><?= $salFres[6]?></td>
					<?
					}
					?>
						<td align="right"><?= $salFres[9]?></td>
					  </tr>
					 <?
						$grossAll=$grossAll+$salFres[9];
					 }
					 ?>
					</table>				</td>
				<td colspan="3" align="left" valign="top">
				<table width="100%" border="0" cellspacing="0" cellpadding="3" style="font-family:arial; font-size:9px">
				  <?
				$salRes=$obj->select("empsaldet", "empCode='$ec' and salMonth='$mnth' and salYear='$yr' and headTyp=2");
				while ($salFres=$obj->fetchrow($salRes)) {
					
				
				?>
				  <tr>
					<td align="left"><?= $salFres[6]?></td>
					<td align="right" valign="top"><?= $salFres[9]?></td>
				  </tr>
				 <?
					$grossDed=$grossDed+$salFres[9];
				 }
				 ?>
				</table></td>
			  </tr>
			  <tr>
				<td align="left">Total</td>
				<td align="left"><img src="<?= $rurl?>images/total.png" alt="total" height="16" border="0" /></td>
				<td align="right" valign="top" style="border:solid 1px #333333; border-left:none;"><?= sprintf("%0.2f", $grossAll)?></td>
				<td align="left">Total</td>
				<td align="left"><img src="<?= $rurl?>images/total_deduction.png" alt="total" height="16" border="0" /></td>
				<td align="right" valign="top" style="border:solid 1px #333333; border-left:none; border-right:none;"><?= sprintf("%0.2f", $grossDed)?></td>
			  </tr>
			  <?
			  $netPay=$grossAll - $grossDed;
			  
			  ?>
			  <tr>
				<td align="left" valign="top" >Net Pay </td>
				<td align="left" valign="top" ><img src="<?= $rurl?>images/net_payable.png" alt="total" height="16" border="0" /></td>
				<td align="right" valign="top" ><?= sprintf("%0.2f", $netPay)?></td>
				<td colspan="2" align="left" valign="top">Gross Sallary:</td>
				<td align="right" valign="top"><?= sprintf("%0.2f", $netPay)?></td>
			  </tr>
			  <tr>
				<td height="24" colspan="3" align="left" valign="top" >In words: Rupees
                <?= convert_number($netPay, "Paise");?></td>
				<td colspan="2" align="left" valign="top">Employers Contribuion to PF:</td>
			    <td align="right" valign="top"><?=$pfCont?></td>
			  </tr>
			  <tr>
				<td height="34" colspan="2" rowspan="2" align="left" valign="top" >&nbsp;</td>
				<td rowspan="2" align="left" valign="top">&nbsp;</td>
				<td colspan="2" align="left" valign="top">Employers Contribution to E.S.I: </td>
				<td align="right" valign="top"><?=$esiCont?></td>
			  </tr>
			  <tr>
			    <td colspan="2" align="left" valign="top">Total Salary (CTC) per Month:</td>
				<? 
				$ctc=$esiCont+$pfCont+$netPay;
				?>
		        <td align="right" valign="top" style="border-top:1px solid; border-bottom:1px solid"><?=$ctc?></td>
			  </tr>
			  <tr>
				<td colspan="2" align="left" valign="top" style="border-top:solid 1px #333333;">Receipient Signature </td>
				<td align="center" valign="top" style="border-top:solid 1px #333333;">Authorised Signatory </td>
				<td colspan="2" align="center" valign="top">&nbsp;</td>
				<td align="left" valign="top">&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan="2" align="left" valign="top" ><img src="<?= $rurl?>images/emp_sig.png" alt="signature" height="16" border="0" /></td>
				<td align="center" valign="top">&nbsp;</td>
				<td colspan="2" align="center" valign="top">&nbsp;</td>
				<td align="left" valign="top">&nbsp;</td>
			  </tr>
			</table>
	<div style="page-break-after:always">&nbsp;</div>
<? 
	unset($hday);
	unset($grossAll);
	unset($grossDed);
} ?>
</div>
</div>