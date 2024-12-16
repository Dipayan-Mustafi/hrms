<?

require ("../../../config/setup.inc");

$title="Contributions";

require($rpath."pageDesign.tmp.php");

$cdt=date('Y-m-d');

$lmt=15;

$mntArray=array( "", "January", "February", "March", "April", "May", "Jun", "July", "August", "September", "October", "November", "December");
$mnthDayArrray=array( "", "31", "28", "31", "30", "31", "30", "31", "31", "30", "31", "30", "31");

$type=$_REQUEST['type'];
$fdt=$_REQUEST['frm'];
$tdt=$_REQUEST['to']


?>

<style type='text/css'>
 .ddhead { width:375mm; padding:5px; display:table; font-weight:bold; font-family:arial; font-size:13px;}
 .rowHead {width:375mm; display:table; font-family:arial; font-size:13px; border:solid 1px #666666; border-left:none; border-right:none;}
 .rowFoot {width:375mm; display:table; font-family:arial; font-size:13px; border:solid 1px #666666; border-left:none; border-right:none;page-break-after:always}
 .divCell {float:left}
 .divLine {width:100%;display:table; height:3%}

</style>

<center>
<div class="contDiv">
	<div style="text-align:right"><img src="<?= $rurl?>images/print_icon.gif" width="16" alt="Print Sheet" title="Print Salary Sheet" height="16" style="cursor:pointer;" onclick="PrintDiv('printArea', 'Salary Sheet');" /></div>
	<div id="printArea" align="center">
		<table width="100%" border="1" style="" bordercolorlight="#CCCCCC" cellspacing="0" cellpadding="0">
		  <tr style="font-size:12px">
            <th colspan="19" rowspan="3" align="center"><img src="http://172.16.16.147:8080/crm/images/kanchan.png" width="414" height="60" style="float:left;"/>
			<div style="float:left; width:30%; text-align:cetner; font-size:13pt;">Contribution Report month of <?= $mntArray[$m]?>, <?= $yr?></div></th>
	        <th width="390" align="center" style="border-left:thin; border-bottom:hidden"><h2>For the Department of</h2></th>
		  </tr>
		  <tr style="font-size:12px">
		  	<?
				
				$deptRes=$obj->select("deptmanager", "deptID='$dept'");
				$deptFres=$obj->fetchrow($deptRes);
				
				

			?>
		    <th width="390" height="20" align="center" style="border-bottom:hidden; border-left:thin"><h3><?= $deptFres[1];?></h3></th>
	      </tr>
	  </table>
		 
		 <?		$r=0;
		 		$tempPrint=0;	
		 		$res=$obj->select("empmaster", "empTyp=1 and empDept=$dept order by empEPFNo asc");
			while($fres=$obj->fetchrow($res)){
			
				$salDate=explode("-", $fres[10]);
				if($salDate[0]<=$yr && $salDate[1]<=$m){
					$s++;
					$temp=$s;
					
					
					if($fres[38]){
						$esiNo=$fres[38];
					}else{
						$esiNo=0;
					}
					
					$attndRes=$obj->select("attendancedet", "empCode=$fres[2] and attnMonth=$m and attnYear=$yr");
					$attndFres=$obj->fetchrow($attndRes);
					$attndRows=$obj->rows($attndRes);					
					if($attndRows>0){
						$tot=$mnthDayArrray[$m];
						$off=$tot-$attndFres[3];
						
						$attnd=$attndFres[4]+$off;
					}else{
						$attnd=0;
						}
					$basicRes=$obj->select("empsaldet", "empCode=$fres[2] and headTyp=1 and salYear=$yr and salMonth=$m and alwID=0");
					$basicFres=$obj->fetchrow($basicRes);
					if($basicFres[9]>0){
						$basic=$basicFres[9];
					}else{
						$basic="-";
					}
					
					$hraRes=$obj->select("empsaldet", "empCode=$fres[2] and headTyp=1 and salYear=$yr and salMonth=$m and alwID=2");
					$hraFres=$obj->fetchrow($hraRes);
					
					if ($hraFres[9] > 0){
						$hra=$hraFres[9];
					}else{
						$hra="-";
					}
					
					$waRes=$obj->select("empsaldet", "empCode=$fres[2] and headTyp=1 and salYear=$yr and salMonth=$m and alwID=3");
					$waFres=$obj->fetchrow($waRes);
					
					if ($waFres[9] > 0){
						$wa=$waFres[9];
					}else{
						$wa="-";
					}
					
					$profTaxRes=$obj->select("empsaldet", "empCode=$fres[2] and headTyp=2 and salYear=$yr and salMonth=$m and payHead='Professional Tax'");
					$profTaxFres=$obj->fetchrow($profTaxRes);
					
					if ($profTaxFres[9] > 0){
						$profTax=$profTaxFres[9];
					}else{
						$profTax="0.00";
					}
					
					$epfRes=$obj->select("empsaldet", "empCode=$fres[2] and headTyp=2 and salYear=$yr and salMonth=$m and payHead='EPF Deduction'");
					$epfFres=$obj->fetchrow($epfRes);
					
					if ($epfFres[9] > 0){
						$epf=$epfFres[9];
						$epfP=$epf;
					}else{
						$epf=0;
						$epfP="--";
					}
					
					$esiRes=$obj->select("empsaldet", "empCode=$fres[2] and headTyp=2 and salYear=$yr and salMonth=$m and payHead='ESI Deduction'");
					$esiFres=$obj->fetchrow($esiRes);
					
					if ($esiFres[9] > 0){
						$esi=$esiFres[9];
						$esiP=$esi;
					}else{
						$esi=0;
						$esiP="--";
					}
					
					$empTotDed=$esi+$epf+$profTax;
					
					$gross=$basic+$hra+$wa;
					
					if($fres[31]>0){
						$pfContCal=$basic * .1336;
						$pfCont=round($pfContCal, 0);
					}else{
						$pfCont=0;
					}
					//if ($esiFres[9] > 0){						
					if($gross > 15000){
						$esiContCal= $gross * .0475;
						$esiCont="-";
					}else if($gross < 15000){
						$esiContCal= $gross * .0475;
						$expesi=explode(".", $esiContCal);
						$esiCont=$expesi[0];
						$esiRest=$expesi[1];
						if($esiRest>0){
							$esiCont++;
							}
					}
					//}
					$costCompany=$gross+$esiCont+$pfCont;
					$inHand=$gross-$empTotDed;
		 			/*if ($r%$lmt==0 || $r==0){
						if($r>1){
				?>
		<tr height="20">
		</tr>
				<?
				}
				?>
		
		<?
	
				}	*/
		?>		
		
		
				
		<?		$totBasic+=$basic;
				$totHra+=$hra;
				$totWa+=$wa;
				$totProfTax+=$profTax;
				$totGross+=$gross;
				$totEpf+=$epf;
				$totEsi+=$esi;
				$totEmpDed+=$empTotDed;
				$totPfCont+=$pfCont;
				$totEsiCont+=$esiCont;
				$totCostCom+=$costCompany;
				$totInHand+=$inHand;
				
				}	
			$r++;
		?>
		<? 
					$temp=$s-$tempPrint;
					if($temp==17){
					$tempPrint=$s+2;
					
		
				}
			}
		?>
		

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
	</div>
</div>
</div>
</center>