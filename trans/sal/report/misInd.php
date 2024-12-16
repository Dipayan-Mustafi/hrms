<?

require ("../../../config/setup.inc");

$title="MIS REPORTS";

require($rpath."pageDesign.tmp.php");
require ($root."lib/datetime/datetimepicker_css_js.php");
$cdt=date('Y-m-d');
$mntArray=array( "", "January", "February", "March", "April", "May", "Jun", "July", "August", "September", "October", "November", "December");
$lmt=15;


$eman=new empManagement();

$ecode=$_REQUEST['ecode'];
$fdt=$_REQUEST['fdt'];
$tdt=$_REQUEST['tdt'];


$expFdt=explode("-",$fdt);
$syr=$expFdt[0];

$expTdt=explode("-",$tdt);
$eyr=$expTdt[0];

$smnth=date("m", strtotime($fdt));
$emnth=date("m", strtotime($tdt));


//$d=cal_days_in_month(CAL_GREGORIAN,"$m","$yr");
$page=0;

$prvMnth=($m=="01") ? "12" : sprintf("%02d", ($m-1));
$prvYear=($m=="01") ? ($yr-1) : $yr;

$chkRes=$obj->select("empsaldet", "empCode='$ecode' and createDate>='$fdt' and createDate<='$tdt' and payHead='Basic'");
?>

<style type='text/css'>
 .ddhead { width:375mm; padding:5px; display:table; font-weight:bold; font-family:arial; font-size:13px;}
 .rowHead {width:375mm; display:table; font-family:arial; font-size:13px; border:solid 1px #666666; border-left:none; border-right:none;}
 .rowFoot {width:375mm; display:table; font-family:arial; font-size:13px; border:solid 1px #666666; border-left:none; border-right:none;page-break-after:always}
 .divCell {float:left}
 .divLine {width:100%;display:table; height:3%}
</style>
<script type="text/javascript">
function getCsv(m,y){

	
}
</script>

<center>
<div class="contDiv">
	<input type="image" align="right" border="1" src="<?= $rurl?>images/close.png" width="24" height="24" alt="Close" title="Close" style="cursor:pointer; margin:2; padding:9; border:#666666; border-style:dashed" onclick="navigate('mis.php');" /><img src="<?= $rurl?>images/print_icon.gif" align="right" hspace="5" width="32" alt="Print MIS Report" title="Print MIS Report" height="32" style="cursor:pointer;" onclick="PrintDiv('printArea', 'MIS Report');" /> <img src="<?= $rurl?>images/csv.jpg" align="right" hspace="10" width="32" alt="CSV Download" title="CSV Download" height="32" style="cursor:pointer;" onclick="getCsv('<?= $m?>', '<?= $yr?>');" />
		<div id="printArea" align="center" style="page-break-inside:auto">
		  <table width="100%" border="1">
              <tr>
				<th colspan="7" rowspan="5" align="center"><img src="<?=$rurl?>images/kanchan.png" width="414" height="70" style="float:left;"/><h2>
					  <p>MIS Report </p></h2>
					  <p>from <?= $misc->dateformat($fdt);?>, to <?= $misc->dateformat($tdt);?></p>
			    </th>
				<?
					$empDet=$eman->getEmpDet($ecode);
					$esiNo=($empDet[38]) ? $esiNo: "NONE";
					
					
				?>
				<th width="13%" align="center" style="border-left:thin; border-bottom:hidden"><h4>Name</h4></th>
			    <th width="18%" align="center" style="border-left:thin; border-bottom:hidden"><?= $empDet[3]?></th>
              </tr>
              <tr>
                <th align="center" style="border-left:thin; border-bottom:hidden"><h4>EPF No.</h4></th>
                <th align="center" style="border-left:thin; border-bottom:hidden"><?= $empDet[31]?></th>
              </tr>
              <tr>
                <th align="center" style="border-left:thin; border-bottom:hidden"><h4>ESI No</h4></th>
                <th align="center" style="border-left:thin; border-bottom:hidden"><?= $esiNo?></th>
              </tr>
		  </table>
			<?
		  	$rows=$obj->rows($chkRes);
			if($rows>0){
			?>
		  <table width="100%" border="1">
			  <tr>
                <td width="2%" rowspan="2" align="center"><strong>Sl. No.</strong> </td>
                <td width="9%" rowspan="2" align="center"><strong>SALARY MONTH</strong> </td>
                <td width="7%" rowspan="2" align="center"><strong>Attendence</strong></td>
                <td width="7%" rowspan="2" align="center"><strong>Basic</strong></td>
                <td width="7%" rowspan="2" align="center"><strong>Washing Allowence</strong></td>
                <td width="11%" rowspan="2" align="center"><strong>House Rental Allowence</strong></td>
                <td width="8%" rowspan="2" align="center"><strong>gross</strong></td>
                <td colspan="3" align="center"><strong>Employee Deduction</strong> </td>
                <td colspan="2" align="center"><strong>Employeers contribution</strong> </td>
                <td width="6%" rowspan="2" align="center"><strong>CTC</strong></td>
			    <td width="7%" rowspan="2" align="center"><strong>In Hand </strong></td>
			  </tr>
              <tr>
                <td width="8%" align="center"><strong>Prof Tax</strong></td>
                <td width="8%" align="center"><strong>EPF (@12%) </strong></td>
                <td width="6%" align="center"><strong>ESI (@1.75%)</strong> </td>
                <td width="6%" align="center"><strong>EPF (@13.36%)</strong> </td>
				<td width="8%" align="center"><strong>ESI (@4.75%) </strong></td>
			  </tr>
			  <?
    			
				while($chFres=$obj->fetchrow($chkRes)){
					$s++;
							$basic=$eman->getEmpBasicDet($chFres[1], $chFres[3], $chFres[4]);		
			 				$emppf=$eman->getPFEmpShare($chFres[1], $chFres[3], $chFres[4]);
							$empesiRes=$eman->getESIEmpShare($chFres[1], $chFres[3], $chFres[4]);
							$WA=$eman->getWA($chFres[1], $chFres[3], $chFres[4]);
			  				$hra=$eman->getHRA($chFres[1], $chFres[3], $chFres[4]);
			 				$pTaxRes=$eman->getPtax($chFres[1], $chFres[3], $chFres[4]);
							$attnd=$eman->empAttendance($chFres[1], $chFres[3], $chFres[4]);
							
							$pTax=($pTaxRes) ? $pTaxRes : 0;
							$waf=($WA) ? $WA : 0;
							$hraf=($hra) ? $hra : 0;
							$empesi=($empesiRes) ? $empesiRes : 0;
							
							$mnth=$eman->getMnthCont($chFres[1], $chFres[3], $chFres[4]);
			 				
							$gross=$basic+$WA+$hra;
							$ctc=$gross+$mnth[7]+$mnth[6];
							$inhand=$gross-$emppf-$empesi;
							
							$m=(int)$chFres[3];
							
			?>
			  
				  <tr>
					<td align="center"><?=$s?></td>
					<td align="center" style="font-size:11px; cursor:pointer;" onclick="navigate('sheet.php?dept=<?=$empDet[12]?>&mnth=<?=$chFres[3]?>&year=<?=$chFres[4]?>');"><?=$mntArray[$m]?></td>
					<td align="center"><?=$attnd?></td>
					<td align="center"><?=(int)(int)$basic?></td>
					<td align="center"><?=$waf?></td>
					<td align="center"><?=(int)$hraf?></td>
					<td align="center"><?=(int)$gross?></td>
					<td align="center"><?=(int)$pTax?></td>
					<td align="center"><?=(int)$emppf?></td>
					<td align="center"><?=(int)$empesi?></td>
					<td align="center"><?=$mnth[7]?></td>
					<td width="8%" align="center"><?=$mnth[6]?></td>
					<td width="6%" align="center"><?=$ctc?></td>
				    <td width="7%" align="center"><?=$inhand?></td>
				  </tr>
			  <?
				$totBasic+=$basic;
				$totHra+=$hra;
				$totWa+=$WA;
				$totGross+=$gross;
				$totProfTax+=$pTaxRes;
				$totEpf+=$emppf;
				$totEsi+=$empesiRes;
				$totPfCont+=$mnth[7];
				$totEsiCont+=$mnth[6];
				$totAttnd=$totAttnd+$attnd;
				$totCtc=$totCtc+$ctc;
				$totInhand+=$inhand;
	
			  	}
			  ?>
              <tr>
                <td></td>
                <td align="right"><strong>TOTAL</strong></td>
                <td align="center"><?=$totAttnd?></td>
                <td align="center"><?=$totBasic?></td>
                <td align="center"><?=$totWa?></td>
                <td align="center"><?=$totHra?></td>
                <td align="center"><?=$totGross?></td>
                <td align="center"><?=$totProfTax?></td>
                <td align="center"><?=$totEpf?></td>
                <td align="center"><?=$totEsi?></td>
                <td align="center"><?=$totPfCont?></td>
                <td align="center"><?=$totEsiCont?></td>
                <td align="center"><?=$totCtc?></td>
                <td align="center"><?=$totInhand?></td>
              </tr>
          </table>
			<?
			}else{
			?>
		  <table width="100%" border="1">
			  <tr>
			  	<td width="100%" align="center"><h2>SALARY NOT YET GENERATED OF THIS TIME FRAME</h2></td>
			  </tr>
		  </table>
		  <?
		  }
		  ?>
		</div>
</div>

</center>