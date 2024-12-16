<?

require ("../../../config/setup.inc");

$title="Monthy ESI Report";

require($rpath."pageDesign.tmp.php");

$cdt=date('Y-m-d');

$lmt=15;



$dept=$_REQUEST['dept'];
$fdt=$_REQUEST['fdt'];
$tdt=$_REQUEST['tdt'];
$d=cal_days_in_month(CAL_GREGORIAN,"$m","$yr");
$page=0;
?>


<style type='text/css'>
 .ddhead { width:375mm; padding:5px; display:table; font-weight:bold; font-family:arial; font-size:13px;}
 .rowHead {width:375mm; display:table; font-family:arial; font-size:13px; border:solid 1px #666666; border-left:none; border-right:none;}
 .rowFoot {width:375mm; display:table; font-family:arial; font-size:13px; border:solid 1px #666666; border-left:none; border-right:none;page-break-after:always}
 .divCell {float:left}
 .divLine {width:100%;display:table; height:3%}

</style>
	
<div class="contDiv">
	<div style="text-align:right"><img src="<?= $rurl?>images/print_icon.gif" width="16" alt="Print Sheet" title="Print Report" height="16" style="cursor:pointer;" onclick="PrintDiv('printArea', 'Salary Sheet');" /></div>
	<div id="printArea" align="center" style="page-break-inside:auto">
	<?
				
				$deptRes=$obj->select("deptmanager", "deptID=$dept");
				$deptFres=$obj->fetchrow($deptRes);
				
				

			?>
		<table width="100%" border="1" style="" bordercolorlight="#CCCCCC" cellspacing="0" cellpadding="0">
		  <tr style="font-size:12px">
            <th colspan="19" rowspan="3" align="center"><img src="http://172.16.16.147:8080/crm/images/kanchan.png" width="414" height="60" style="float:left;"/>
			<div style="float:left; width:30%; text-align:cetner; font-size:14pt;">ESI Contribution  Details</div></th>
	        <th width="390" align="center" style="border-left:thin; border-bottom:hidden"><h2>Department</h2></th>
		  </tr>
		  <tr style="font-size:12px">
		  
		    <th width="390" height="20" align="center" style="border-bottom:hidden; border-left:thin"><h3><?= $deptFres[1];?></h3></th>
	      </tr>
	  </table>
		 <table width="100%" border="1" bordercolorlight="#CCCCCC" cellspacing="0" cellpadding="0">
		 <tr>
		   <th width="3%" align="left">SL. No.</th>
			<th width="19%">NAME</th>
			<th width="7%">ESI No.</th>
		    <th width="8%">Month</th>
	        <th width="8%">Year</th>
           <th width="9%"><p>ATTENDENCE</p>	      </th>
			<th width="6%">Gross</th>
			<th width="8%" align="center">Employee Contribution </th>
			<th width="10%"> Employer's Contribution </th>
			<th width="22%">TOTAL DED.</th>
		   </tr>
		
		 <?		
		 		$disRes=$obj->distinct("empsaldet", "empCode", "createDate>='$fdt' and createDate<='$tdt' and deptID='$deptFres[0]' and headTyp='1' and alwID='0'");
				$rows=$obj->rows($disRes);
				if($rows<1){
		?>
			<tr>
			<td colspan="10" align="center" style="font-size:16px"><strong>SALARY NOT YET GENERATED</strong>			</tr>
		<? 	
			}else{
				
					
				while($disFres=$obj->fetchrow($disRes)){
					$yrRes=$obj->distinct("empsaldet", "salYear", "'empCode=$disFres[0]' and createDate>='$fdt' and createDate<='$fdt' and deptID='$deptFres[0]' and headTyp='1' and alwID='0'");
					while($yrFres=$obj->fetchrow($yrRes)){
					
					$mnthRes=$obj->distinct("empsaldet", "'empCode=$disFres[0]' and salYear='$yrFres[0]' and createDate>='$fdt' and createDate<='$fdt' and deptID='$deptFres[0]' and headTyp='1' and alwID='0'");	
					while($mnthFres=$obj->fetchrow($mnthRes)){
					
					$m=sprintf("%04d", $mnthFres[0]);
					$yr=$yrFres[0];
				
					$res=$obj->select("empsaldet", "salMonth='$m' and salYear='$yr' and empCode='$disFres[0]' and payHead='ESI Deduction'");
					
					$fres=$obj->fetchRow($res);
					
					$s++;
					
					$empRes=$obj->select("empmaster", "empCode='$fres[1]'");
					$empFres=$obj->fetchrow($empRes);
				
		 			$esiNo=($empFres[38]) ? $empFres[38] : 0;
					
					$attndRes=$obj->select("attendancedet", "empCode=$fres[1] and attnMonth=$m and attnYear=$yr");
					$attndFres=$obj->fetchrow($attndRes);
					
					$attndRows=$obj->rows($attndRes);					
					if($attndRows>0){
						$off=$d-$attndFres[3];
						
						$attnd=$attndFres[4]+$off;
					}else{
						$attnd=0;
						}
					
					$basicRes=$obj->sumfield("empsaldet", "payAmount", "salMonth='$m' and salYear='$yr' and empCode=$fres[1] and payHead='Basic'");
					$waRes=$obj->sumfield("empsaldet", "payAmount", "salMonth='$m' and salYear='$yr' and empCode=$fres[1] and payHead='Washinig Allowance'");
					$hraRes=$obj->sumfield("empsaldet", "payAmount", "salMonth='$m' and salYear='$yr' and empCode=$fres[1] and payHead='House Rent Allowance'");
					$empEsi=$obj->sumfield("empsaldet", "payAmount", "salMonth='$m' and salYear='$yr' and empCode=$fres[1] and payHead='ESI Deduction'");
					$compEsi=$obj->sumfield("mnthcompcont", "esiCC", "salMonth='$m' and salYear='$yr' and empCode=$fres[1]");
					
					$gross=$basicRes+$waRes+$hraRes;
					
					$empTotDed=$compEsi+$empEsi;
				
		?>	
		<tr>
			<th align="left"><?= $s?>.</th>
			<th><?= $empFres[3]?></th>
			<th align="center"><?= $esiNo?></th>
			<th align="center"><?=$mnthFres[0]?></th>
			<th align="center"><?=$yrFres[0]?></th>
			<th align="center"><?= $attnd?></th>
			<th align="center"><strong><?= sprintf("%.2f", $gross)?></strong></th>
			<th align="center"><strong><?=$empEsi?></strong></th>
			<th align="center"><strong><?= $compEsi?></strong></th>
			<th align="center"><strong><?=sprintf("%.2f", $empTotDed)?></strong></th>
		</tr>
			<?
		$temp=$page+1;
		if($temp==1){
			if($s==25){
			?>
			<tr style="page-break-after:always; border:none; border-bottom:none; border-left:none; border-right:none" height="10%">
				<th colspan="9" height="35" align="center">&nbsp;</th> 
			</tr>
			
			<?
			$page++;	
			}
		}else{
			$chk=$temp*28;
			if($s==$chk){
			?>
			<tr style="page-break-after:always; border:none; border-bottom:none; border-left:none; border-right:none" height="10%">
				<th colspan="9" height="36" align="center">&nbsp;</th> 
			</tr>
			
			<?
			$page++;	
			}
		}
				$totGross=$totGross+$gross;
				$totEmpEsi=$totEmpEsi+$empEsi;
				$totCompEsi=$totCompEsi+$compEsi;
				$totded=$totded+$empTotDed;
				
			}
			}
			}
		}
					
			//$r++;
		?>
		<tr>
			<th align="center"></th>
			<th align="center">TOTAL:</th>
			<th align="center"></th>
			<th align="center"></th>
			<th align="center"></th>
			<th align="center"></th>
			<th align="center"><strong><?= sprintf("%.2f", $totGross)?></strong></th>
			<th align="center"><strong><?=sprintf("%.2f", $totEmpEsi)?></strong></th>
			<th align="center"><strong><?= sprintf("%.2f", $totCompEsi)?></strong></th>
			<th align="center"><strong><?=sprintf("%.2f", $totded)?></strong></th>
		</tr>
		</table>
  </div>
</div>
</div>

		<?
		
			unset($totBasic);
			unset($totProfTax);
			unset($totHra);
			unset($totWa);
			unset($totGross);
			unset($totEpf);
			unset($totEsi);
			unset($totEmpDed);
			unset($totPfCont);
			unset($totEsiCont);
			unset($totCostCom);
			unset($totInHand);
		?>
	