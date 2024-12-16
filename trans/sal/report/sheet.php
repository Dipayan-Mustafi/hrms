<?
error_reporting(E_ALL);
set_time_limit(3600);
require ("../../../config/setup.inc");

$title="Salary Sheet";

require($rpath."pageDesign.tmp.php");
require ($root."lib/datetime/datetimepicker_css_js.php");


$cdt=date('Y-m-d');

$lmt=15;

$eman=new empManagement();


$mntArray=array( "", "January", "February", "March", "April", "May", "Jun", "July", "August", "September", "October", "November", "December");
$mnthDayArrray=array( "", "31", "28", "31", "30", "31", "30", "31", "31", "30", "31", "30", "31");

$dept=$_REQUEST['dept'];
$m=$_REQUEST['mnth'];
$yr=$_REQUEST['year'];

$d=cal_days_in_month(CAL_GREGORIAN,"$m","$yr");

$sm=sprintf("%02d",$m);

$page=0;

$strDt="$yr-$sm-01";

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
	<input type="image" align="right" border="1" src="<?= $rurl?>images/close.png" width="24" height="24" alt="Close" title="Close" style="cursor:pointer; margin:2; padding:9; border:#666666; border-style:dashed; " onclick="navigate('index.php');" /> <input type="image" align="right" hspace="10" src="<?= $rurl?>images/print_icon.gif" width="32" height="32" alt="Print Sheet" title="Print Salary Sheet" style="cursor:pointer;" onclick="PrintDiv('printArea', 'Salary Sheet');" />
	<div id="printArea" align="center">
	<?
				if($dept>0){
					$deptRes=$obj->select("deptmanager", "deptID='$dept'");
				}else{
					$deptRes=$obj->select("deptmanager", "deptID<>1");
				}
				while($deptFres=$obj->fetchrow($deptRes)){
				
				$configRes=$obj->select("salconfig");
				$configFres=$obj->fetchrow($configRes);
			$sgdisRes=$obj->distinct("empmaster", "empSubGrp","(empTyp=1 or empTyp=3) and empDept='$deptFres[0]' and (modDate>'$strDt' or modDate='0000-00-00')");
			while($sgdisFres=$obj->fetchrow($sgdisRes)){
			
				if($sgdisFres[0]==0){
					$sg="None";
				}else{
					$sgRes=$obj->Select("subgrpmast", "sgID=$sgdisFres[0]");
					$sgFres=$obj->fetchrow($sgRes);
					
					$sg="$sgFres[1]";
				}
	?>
		<table width="100%" border="1" style="" bordercolorlight="#CCCCCC" cellspacing="0" cellpadding="0">
		  <tr style="font-size:12px">
            <th colspan="19" rowspan="3" align="center"><img src="<?= $rurl?>images/kanchan.png" width="322" height="60" style="float:left;"/>
			<div style="float:left; width:30%; text-align:cetner; font-size:13pt;">Salary Sheet  for the month of <?= $mntArray[(int)$m]?>, <?= $yr?></div></th>
	        <th width="390" align="center" style="border-left:thin; border-bottom:hidden"><h2>For the Department of</h2></th>
		  </tr>
		  <tr style="font-size:12px">
		  
		    <th width="390" height="20" align="center" style="border-bottom:hidden; border-left:thin"><h3><?= $deptFres[1];?></h3></th>
	      </tr>
		   <tr>
		  
		    <th width="390" height="15" align="center" style="border-bottom:hidden; border-left:thin"><strong>SUB GROUP-</strong> <?=$sg?></th>
	      </tr>
	  </table>
		 <table width="100%" border="1" bordercolorlight="#CCCCCC" cellspacing="0" cellpadding="0">
		 <?
		 $salchkRes=$obj->select("empsaldet", "salYear=$yr and salMonth=$m");
			$salChkRows=$obj->rows($salchkRes);
			if($salChkRows>0){
		 ?>
		 <tr height="10" style="font-family:Verdana; font-size:9px">
		   <th width="18" rowspan="2" align="left"><p>SL. No.</p></th>
			<th width="118" rowspan="2" align="center">NAME</th>
			<th width="17" rowspan="2" align="center">PF No.</th>
			<th width="20" rowspan="2" align="center">ESI No.</th>
			<th width="34" rowspan="2" align="center"><p>ATTEN</p>
	      <p>DENCE</p></th>
			<th width="35" rowspan="2" align="center">BASIC RATE</th>
			<th width="34" rowspan="2" align="center">BASIC</th>
			<th width="36" rowspan="2" align="center">H.R.A</th>
			<th width="49" rowspan="2" align="center">W.A.</th>
			<th width="35" rowspan="2" align="center">Gross</th>
			<th colspan="5" align="center">Employee Deductions</th>
			<th width="51" rowspan="2" align="center">TOTAL DED.</th>
			<th colspan="2" align="center">Employer's Contribution </th>
			<th width="45" rowspan="2" align="center">CTC</th>
		   <th width="53" rowspan="2" align="center"><p>IN</p><p>HAND</p></th>
			<th width="79" rowspan="2" align="center">DATE</th>
			<th width="393" rowspan="2" align="center">SIGNATURE</th>
		</tr>
		<tr height="30" style="font-family:Verdana; font-size:9px;">
		  <th width="47" align="center">P.TAX</th>
		  <th width="46" align="center">@<?=$configFres[4]?>% P.F.</th>
		  <th width="46" align="center">TDS</th>
		  <th width="46" align="center">ADV. ADj</th>
		  <th width="46" align="center">@<?=$configFres[2]?>% E.S.I.</th>
		  <th width="57" align="center">@13.36% P.F.</th>
		  <th width="45" align="center">@<?=$configFres[3]?>% ESI</th>
		</tr>
		 <?	
		 	$r=0;
		 	$tempPrint=0;	
			
		 	$res=$obj->select("empmaster", "(empTyp=1 or empTyp=3) and empDept='$deptFres[0]' and (modDate>'$strDt' or modDate='0000-00-00') and empSubGrp=$sgdisFres[0] order by empName");
			//print_r($res);
			//print "</br>";
			$rows=$obj->rows($res);
			while($fres=$obj->fetchrow($res)){
			
				
				
				$ecode=$fres[2];
				
				$cRes=$obj->select("empsaldet", "empCode='$ecode' and salYear=$yr and salMonth='$sm'");
				$e++;
				
				$cRows=$obj->rows($cRes);
			//print_r($cRes);
					//print "$e<br />";
				$chkDate=$yr."-".$sm."-31";
				if ($cRows>0){
					$me++;
				$cFres=$obj->fetchrow($cRes);
					if($fres[10]<=$chkDate){
						//
						$s++;
						$temp=$s;
						
						$esiNo=($fres[38]) ? $fres[38] : "None";
						
						
						
						$attnd=$eman->empAttendance($ecode, $m, $yr);
						$attndCal=$eman->empAttndCal($ecode, $m, $yr);
						
						$basic=$eman->getEmpBasicDet($ecode, $m, $yr);
						
						$hra=$eman->getHRA($ecode, $m, $yr);
						
						
						$wa=$eman->getWA($ecode, $m, $yr);
						
						
						if($fres[48]<2){
							$profTax=$eman->getPtax($ecode, $m, $yr);
						
							$profTax=($profTax) ? $profTax : 0;
						}else{
						$profTax= 0;
						}
						if($fres[30]<2){
							$epfP=$eman->getPFEmpShare($ecode, $m, $yr);
						}else{
							$epfP=0;
						}
						$esiP=$eman->getESIEmpShare($ecode, $m, $yr);;
						$esi=$esiP;
						
						$advRes=$obj->select("empsaldet", "empCode='$fres[2]' and headTyp=2 and salYear=$yr and salMonth=$m and payHead='Advance Deduction'");
						$advFres=$obj->fetchrow($advRes);
						
						$adv=$advFres[9];
						
						$adv=($adv) ? $adv : 0;
						
						
						
						$gross=$basic+$hra+$wa;
						
						$tdsPre=$eman->getTDS($ecode, $m, $yr);
						
						$tds=($tdsPre) ? $tdsPre : 0;
						
						$empTotDed=$esi+$epfP+$profTax+$tds+$adv;
						if($fres[30]<2){
						$mnthCC=$eman->getMnthCont($ecode, $m, $yr);
						
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
						//if ($esiFres[9] > 0){						
						$esiCont=($mnthCC[6]) ? $mnthCC[6] : "-";
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
			<tr height="30" style="font-size:9px;">
				<th align="center"><?= $s?></th>
				<th width="118" align="left" style="font-size:11px; cursor:pointer;" onclick="navigate('../salView.php?ec=<?=$fres[2]?>&mnth=<?=$sm?>&yr=<?=$yr?>');"><?= $fres[3]?></th>
				<th align="center"><?= $fres[31]?></th>
				<th align="center"><?= $esiNo?></th>
				<th align="center"><?= $attnd?></th>
				<th style="min-width:inherit; max-width:inherit" align="center"><?= (int)$fres[35]?></th>
				<th style="min-width:inherit; max-width:inherit" align="center"><?= (int)$basic?></th>
				<th style="min-width:inherit; max-width:inherit" align="center"><?= (int)$hra?></th>
				<th style="min-width:inherit; max-width:inherit" align="center"><?= (int)$wa?></th>
				<th style="min-width:inherit; max-width:inherit" align="center"><strong><?= (int)$gross?></strong></th>
				<th style="min-width:inherit; max-width:inherit" align="center"><?= (int)$profTax?></th>
				<th style="min-width:inherit; max-width:inherit" align="center"><?= (int)$epfP?></th>
				<th style="min-width:inherit; max-width:inherit" align="center"><?= (int)$tds?></th>
				<th style="min-width:inherit; max-width:inherit" align="center"><?= $adv?></th>
				<th style="min-width:inherit; max-width:inherit" align="center"><?= (int)$esiP?></th>
				<th align="center"><strong><?= $empTotDed?></strong></th>
				<th style="min-width:inherit; max-width:inherit" align="center"><?= (int)$pfCont?></th>
				<th style="min-width:inherit; max-width:inherit" align="center"><?= (int)$esiCont?></th>
				<th align="center"><?= (int)$costCompany?></th>
				<th align="center"><?=(int)$inHand;?></th>
				<th valign="middle" style="min-width:inherit" align="center" rowspan="1"><?= $misc->dateformat($cFres[15]);?></th>
				<th width="393" align="center"></th>
			</tr>
			<?
					
					$PagetotBasic+=(int)$basic;
					$PagetotHra+=(int)$hra;
					$PagetotWa+=(int)$wa;
					$PagetotProfTax+=(int)$profTax;
					$PagetotGross+=(int)$gross;
					$PagetotEpf+=(int)$epfP;
					$PagetotEsi+=(int)$esi;
					$pagetotTds+=(int)$tds;
					$pagetotadv+=(int)$adv;
					$PagetotEmpDed+=(int)$empTotDed;
					$PagetotPfCont+=(int)$pfCont;
					$PagetotEsiCont+=(int)$esiCont;
					$PagetotCostCom+=(int)$costCompany;
					$PagetotInHand+=(int)$inHand;
					
					
					$totBasic+=(int)$basic;
					$totHra+=(int)$hra;
					$totWa+=(int)$wa;
					$totProfTax+=(int)$profTax;
					$totGross+=(int)$gross;
					$totEpf+=(int)$epfP;
					$totEsi+=(int)$esi;
					$totTds+=(int)$tds;
					$totadv+=(int)$adv;
					$totEmpDed+=(int)$empTotDed;
					$totPfCont+=(int)$pfCont;
					$totEsiCont+=(int)$esiCont;
					$totCostCom+=(int)$costCompany;
					$totInHand+=(int)$inHand;
					
					}
				}	
			$r++;
		
		$temp=$page+1;
		if($temp==1){
			if($s==19){
					
		?>
		<tr style="font-size:9px">
			<th align="center">--</th>
			<th width="118" align="center" style="font-size:11px">C/F</th>
			<th colspan="4" align="center">--------</th>
			<th align="center" style="font-size:11px"><?=$PagetotBasic?></th>
			<th align="center" style="font-size:11px"><?=$PagetotHra?></th>
			<th align="center" style="font-size:11px"><?=$PagetotWa?></th>
			<th align="center" style="font-size:11px"><?=$PagetotGross?></th>
			<th align="center" style="font-size:11px"><?=$PagetotProfTax?></th>
			<th align="center" style="font-size:11px"><?=$PagetotEpf?></th>
			<th align="center" style="font-size:11px"><?=$pagetotTds?></th>
			<th align="center" style="font-size:11px"><?=$pagetotadv?></th>
			<th align="center" style="font-size:11px"><?=$PagetotEsi?></th>
			<th align="center" style="font-size:11px"><?=$PagetotEmpDed?></th>
			<th align="center" style="font-size:11px"><?=$PagetotPfCont?></th>
			<th align="center" style="font-size:11px"><?=$PagetotEsiCont?></th>
			<th align="center" style="font-size:11px"><?=$PagetotCostCom?></th>
			<th align="center" style="font-size:11px"><?=$PagetotInHand?></th>
			<th width="79"align="center">--</th>
			<th width="393" align="center"></th>
		</tr>
		<tr style="page-break-after:always; border:none; border-bottom:none; border-left:none; border-right:none" height="5%">
		  <th height="10" colspan="62" align="center">&nbsp;</th>
		   </tr>
		<tr height="10" style="font-family:Verdana; font-size:9px">
		   <th width="18" rowspan="2" align="left"><p>SL. No.</p></th>
			<th width="118" rowspan="2" align="center">NAME</th>
			<th width="17" rowspan="2" align="center">PF No.</th>
			<th width="20" rowspan="2" align="center">ESI No.</th>
			<th width="34" rowspan="2" align="center"><p>ATTEN</p>
	      <p>DENCE</p></th>
			<th width="35" rowspan="2" align="center">BASIC RATE</th>
			<th width="34" rowspan="2" align="center">BASIC</th>
			<th width="36" rowspan="2" align="center">H.R.A</th>
			<th width="49" rowspan="2" align="center">W.A.</th>
			<th width="35" rowspan="2" align="center">Gross</th>
			<th colspan="5" align="center">Employee Deductions</th>
			<th width="51" rowspan="2" align="center">TOTAL DED.</th>
			<th colspan="2" align="center">Employee Contribution </th>
			<th width="45" rowspan="2" align="center">CTC</th>
	      <th width="53" rowspan="2" align="center"><p>IN</p><p>HAND</p></th>
			<th width="79" rowspan="2" align="center">DATE</th>
			<th width="393" rowspan="2" align="center">SIGNATURE</th>
		</tr>
		<tr height="30" style="font-family:Verdana; font-size:9px;">
		  <th width="47" align="center">P.TAX</th>
		  <th width="46" align="center">@12% P.F.</th>
		  <th width="46" align="center">TDS</th>
		  <th width="46" align="center">ADV. ADj</th>
		  <th width="46" align="center">@1.75% E.S.I.</th>
		  <th width="57" align="center">@13.36% P.F.</th>
		  <th width="45" align="center">@4.75% ESI</th>
		</tr>
		<tr style="font-size:9px">
			<th align="center">--</th>
			<th width="118" align="center" style="font-size:11px">B/F</th>
			<th colspan="4" align="center">--------</th>
			<th align="center" style="font-size:11px"><?=$PagetotBasic?></th>
			<th align="center" style="font-size:11px"><?=$PagetotHra?></th>
			<th align="center" style="font-size:11px"><?=$PagetotWa?></th>
			<th align="center" style="font-size:11px"><?=$PagetotGross?></th>
			<th align="center" style="font-size:11px"><?=$PagetotProfTax?></th>
			<th align="center" style="font-size:11px"><?=$PagetotEpf?></th>
			<th align="center" style="font-size:11px"><?=$pagetotTds?></th>
			<th align="center" style="font-size:11px"><?=$pagetotadv?></th>
			<th align="center" style="font-size:11px"><?=$PagetotEsi?></th>
			<th align="center" style="font-size:11px"><?=$PagetotEmpDed?></th>
			<th align="center" style="font-size:11px"><?=$PagetotPfCont?></th>
			<th align="center" style="font-size:11px"><?=$PagetotEsiCont?></th>
			<th align="center" style="font-size:11px"><?=$PagetotCostCom?></th>
			<th align="center" style="font-size:11px"><?=$PagetotInHand?></th>
			<th width="79"align="center">--</th>
			<th width="393" align="center"></th>
		</tr>
	
		<?
				$page++;	
			}
		}else if($temp==2){
			$chk=$temp*20;
			if($s==$chk){
		?>
		<tr style="font-size:9px">
			<th align="center">--</th>
			<th width="118" align="center" style="font-size:11px">C/F</th>
			<th colspan="4" align="center">--------</th>
			<th align="center" style="font-size:11px"><?=$PagetotBasic?></th>
			<th align="center" style="font-size:11px"><?=$PagetotHra?></th>
			<th align="center" style="font-size:11px"><?=$PagetotWa?></th>
			<th align="center" style="font-size:11px"><?=$PagetotGross?></th>
			<th align="center" style="font-size:11px"><?=$PagetotProfTax?></th>
			<th align="center" style="font-size:11px"><?=$PagetotEpf?></th>
			<th align="center" style="font-size:11px"><?=$pagetotTds?></th>
			<th align="center" style="font-size:11px"><?=$pagetotadv?></th>
			<th align="center" style="font-size:11px"><?=$PagetotEsi?></th>
			<th align="center" style="font-size:11px"><?=$PagetotEmpDed?></th>
			<th align="center" style="font-size:11px"><?=$PagetotPfCont?></th>
			<th align="center" style="font-size:11px"><?=$PagetotEsiCont?></th>
			<th align="center" style="font-size:11px"><?=$PagetotCostCom?></th>
			<th align="center" style="font-size:11px"><?=$PagetotInHand?></th>
			<th width="79"align="center">--</th>
			<th width="393" align="center"></th>
		</tr>
		<tr style="page-break-after:always; border:none; border-bottom:none; border-left:none; border-right:none" height="10%">
		  <th height="35" colspan="62" align="center">&nbsp;</th>
		   </tr>
		<tr height="10" style="font-family:Verdana; font-size:9px">
		   <th width="18" rowspan="2" align="left"><p>SL. No.</p></th>
			<th width="118" rowspan="2" align="center">NAME</th>
			<th width="17" rowspan="2" align="center">PF No.</th>
			<th width="20" rowspan="2" align="center">ESI No.</th>
			<th width="34" rowspan="2" align="center"><p>ATTEN</p>
	      <p>DENCE</p></th>
			<th width="35" rowspan="2" align="center">BASIC RATE</th>
			<th width="34" rowspan="2" align="center">BASIC</th>
			<th width="36" rowspan="2" align="center">H.R.A</th>
			<th width="49" rowspan="2" align="center">W.A.</th>
			<th width="35" rowspan="2" align="center">Gross</th>
			<th colspan="5" align="center">Employee Deductions</th>
			<th width="51" rowspan="2" align="center">TOTAL DED.</th>
			<th colspan="2" align="center">Employee Contribution </th>
			<th width="45" rowspan="2" align="center">CTC</th>
	      <th width="53" rowspan="2" align="center"><p>IN</p><p>HAND</p></th>
			<th width="79" rowspan="2" align="center">DATE</th>
			<th width="393" rowspan="2" align="center">SIGNATURE</th>
		</tr>
		<tr height="30" style="font-family:Verdana; font-size:9px;">
		  <th width="47" align="center">P.TAX</th>
		  <th width="46" align="center">@12% P.F.</th>
		  <th width="46" align="center">TDS</th>
		  <th width="46" align="center">ADV. ADj</th>
		  <th width="46" align="center">@1.75% E.S.I.</th>
		  <th width="57" align="center">@13.36% P.F.</th>
		  <th width="45" align="center">@4.75% ESI</th>
		</tr>
		<?
		$page++;	
			}
		}else{
			$chk=($page*20)+21;
			if($s==$chk){
		?>
		<tr style="font-size:9px">
			<th align="center">--</th>
			<th width="118" align="center" style="font-size:11px">C/F</th>
			<th colspan="4" align="center">--------</th>
			<th align="center" style="font-size:11px"><?=$PagetotBasic?></th>
			<th align="center" style="font-size:11px"><?=$PagetotHra?></th>
			<th align="center" style="font-size:11px"><?=$PagetotWa?></th>
			<th align="center" style="font-size:11px"><?=$PagetotGross?></th>
			<th align="center" style="font-size:11px"><?=$PagetotProfTax?></th>
			<th align="center" style="font-size:11px"><?=$PagetotEpf?></th>
			<th align="center" style="font-size:11px"><?=$pagetotTds?></th>
			<th align="center" style="font-size:11px"><?=$pagetotadv?></th>
			<th align="center" style="font-size:11px"><?=$PagetotEsi?></th>
			<th align="center" style="font-size:11px"><?=$PagetotEmpDed?></th>
			<th align="center" style="font-size:11px"><?=$PagetotPfCont?></th>
			<th align="center" style="font-size:11px"><?=$PagetotEsiCont?></th>
			<th align="center" style="font-size:11px"><?=$PagetotCostCom?></th>
			<th align="center" style="font-size:11px"><?=$PagetotInHand?></th>
			<th width="79"align="center">--</th>
			<th width="393" align="center"></th>
		</tr>
		<tr style="page-break-after:always; border:none; border-bottom:none; border-left:none; border-right:none" height="10%">
		  <th height="35" colspan="62" align="center">&nbsp;</th>
		   </tr>
		<tr height="10" style="font-family:Verdana; font-size:9px">
		   <th width="18" rowspan="2" align="left"><p>SL. No.</p></th>
			<th width="118" rowspan="2" align="center">NAME</th>
			<th width="17" rowspan="2" align="center">PF No.</th>
			<th width="20" rowspan="2" align="center">ESI No.</th>
			<th width="34" rowspan="2" align="center"><p>ATTEN</p>
	      <p>DENCE</p></th>
			<th width="35" rowspan="2" align="center">BASIC RATE</th>
			<th width="34" rowspan="2" align="center">BASIC</th>
			<th width="36" rowspan="2" align="center">H.R.A</th>
			<th width="49" rowspan="2" align="center">W.A.</th>
			<th width="35" rowspan="2" align="center">Gross</th>
			<th colspan="5" align="center">Employee Deductions</th>
			<th width="51" rowspan="2" align="center">TOTAL DED.</th>
			<th colspan="2" align="center">Employee Contribution </th>
			<th width="45" rowspan="2" align="center">CTC</th>
	      <th width="53" rowspan="2" align="center"><p>IN</p><p>HAND</p></th>
			<th width="79" rowspan="2" align="center">DATE</th>
			<th width="393" rowspan="2" align="center">SIGNATURE</th>
		</tr>
		<tr height="30" style="font-family:Verdana; font-size:9px;">
		  <th width="47" align="center">P.TAX</th>
		  <th width="46" align="center">@12% P.F.</th>
		  <th width="46" align="center">TDS</th>
		  <th width="46" align="center">ADV. ADj</th>
		  <th width="46" align="center">@1.75% E.S.I.</th>
		  <th width="57" align="center">@13.36% P.F.</th>
		  <th width="45" align="center">@4.75% ESI</th>
		</tr>
		<tr style="font-size:9px">
			<th align="center">--</th>
			<th width="118" align="center" style="font-size:11px">B/F</th>
			<th colspan="4" align="center">--------</th>
			<th align="center" style="font-size:11px"><?=$PagetotBasic?></th>
			<th align="center" style="font-size:11px"><?=$PagetotHra?></th>
			<th align="center" style="font-size:11px"><?=$PagetotWa?></th>
			<th align="center" style="font-size:11px"><?=$PagetotGross?></th>
			<th align="center" style="font-size:11px"><?=$PagetotProfTax?></th>
			<th align="center" style="font-size:11px"><?=$PagetotEpf?></th>
			<th align="center" style="font-size:11px"><?=$pagetotTds?></th>
			<th align="center" style="font-size:11px"><?=$pagetotadv?></th>
			<th align="center" style="font-size:11px"><?=$PagetotEsi?></th>
			<th align="center" style="font-size:11px"><?=$PagetotEmpDed?></th>
			<th align="center" style="font-size:11px"><?=$PagetotPfCont?></th>
			<th align="center" style="font-size:11px"><?=$PagetotEsiCont?></th>
			<th align="center" style="font-size:11px"><?=$PagetotCostCom?></th>
			<th align="center" style="font-size:11px"><?=$PagetotInHand?></th>
			<th width="79"align="center">--</th>
			<th width="393" align="center"></th>
		</tr>
		<?
		$page++;	
			}
		}
		}
		?>
		<tr style="font-size:9px;">
		  <th align="center">&nbsp;</th>
		  <th align="center" style="font-size:11px">&nbsp;</th>
		  <th align="center">&nbsp;</th>
		  <th align="center">&nbsp;</th>
		  <th align="center">&nbsp;</th>
		  <th align="center">&nbsp;</th>
		  <th align="center" style="font-size:11px">&nbsp;</th>
		  <th align="center" style="font-size:11px">&nbsp;</th>
		  <th align="center" style="font-size:11px">&nbsp;</th>
		  <th align="center" style="font-size:11px">&nbsp;</th>
		  <th align="center" style="font-size:11px">&nbsp;</th>
		  <th align="center" style="font-size:11px">&nbsp;</th>
		  <th align="center" style="font-size:11px">&nbsp;</th>
		  <th align="center" style="font-size:11px">&nbsp;</th>
		  <th align="center" style="font-size:11px">&nbsp;</th>
		  <th align="center" style="font-size:11px">&nbsp;</th>
		  <th align="center" style="font-size:11px">&nbsp;</th>
		  <th align="center" style="font-size:11px">&nbsp;</th>
		  <th align="center" style="font-size:11px">&nbsp;</th>
		  <th align="center" style="font-size:11px">&nbsp;</th>
		  <th align="center">&nbsp;</th>
		  <th width="393" align="center"></th>
		  </tr>
		
		<tr style="font-size:9px">
			<th align="center">--</th>
			<th width="118" align="center" style="font-size:11px">TOTAL</th>
			<th align="center">--</th>
			<th align="center">--</th>
			<th align="center">--</th>
			<th align="center">--</th>
			<th align="center" style="font-size:11px"><?=$totBasic?></th>
			<th align="center" style="font-size:11px"><?=$totHra?></th>
			<th align="center" style="font-size:11px"><?=$totWa?></th>
			<th align="center" style="font-size:11px"><?=$totGross?></th>
			<th align="center" style="font-size:11px"><?=$totProfTax?></th>
			<th align="center" style="font-size:11px"><?=$totEpf?></th>
			<th align="center" style="font-size:11px"><?=$totTds?></th>
			<th align="center" style="font-size:11px"><?=$totadv?></th>
			<th align="center" style="font-size:11px"><?=$totEsi?></th>
			<th align="center" style="font-size:11px"><?=$totEmpDed?></th>
			<th align="center" style="font-size:11px"><?=$totPfCont?></th>
			<th align="center" style="font-size:11px"><?=$totEsiCont?></th>
			<th align="center" style="font-size:11px"><?=$totCostCom?></th>
			<th align="center" style="font-size:11px"><?=$totInHand?></th>
			<th width="79"align="center">--</th>
			<th width="393" align="center"></th>
		</tr>
		
	<?
			unset($PagetotBasic);
			unset($PagetotProfTax);
			unset($PagetotHra);
			unset($PagetotWa);
			unset($PagetotGross);
			unset($PagetotEpf);
			unset($PagetotEsi);
			unset($PagetotEmpDed);
			unset($PagetotPfCont);
			unset($PagetotEsiCont);
			unset($PagetotCostCom);
			unset($PagetotInHand);
		
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
		}else{
		?>
		<tr style="font-size:20px">
		  <th align="center" colspan="22"><strong>SALARY NOT YET GENERATED</strong></th>
		  </tr>
	<?
	}
	
	?>
	</table>
	<div class="divCell" style="width:100%; height:4%; page-break-after:always; padding:3% empty-cells:show">&nbsp;</div>
<? 
	}
}?>
	</div>
</div>
</div>
</center>