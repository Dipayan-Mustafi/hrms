<?php
error_reporting (E_ALL);
require ("../../../config/setup.inc");

$title="Bonus Report";

require($rpath."pageDesign.tmp.php");
require ($root."lib/datetime/datetimepicker_css_js.php");
$cdt=date('Y-m-d');

$lmt=15;


$eman=new empManagement();

$fdt=$_REQUEST['fdt'];
$tdt=$_REQUEST['tdt'];
$empType=$_REQUEST['eType'];
$times=$_REQUEST['times'];


?>
<style type='text/css'>
 .ddhead { width:375mm; padding:5px; display:table; font-weight:bold; font-family:arial; font-size:13px;}
 .rowHead {width:375mm; display:table; font-family:arial; font-size:13px; border:solid 1px #666666; border-left:none; border-right:none;}
 .rowFoot {width:375mm; display:table; font-family:arial; font-size:13px; border:solid 1px #666666; border-left:none; border-right:none;page-break-after:always}
 .divCell {float:left}
 .divLine {width:100%;display:table; height:3%}
</style>
<script type="text/javascript">
function bsub(){
	if (document.getElementById('fdt').value==0){
		alert ("Please select The Date of Bonus");
	}else if (document.getElementById('tdt').value==0){
		alert ("Please select Time Period of Bonus");
	}else if (document.getElementById('eType').value==0){
		alert ("Please select Employee Type");
	}else{
	document.form1.submit();
	}
}
function getSlc(){
	window.location="?times=2";
}
</script>

<div class="contDiv">
<input type="image" align="right" border="1" src="<?= $rurl?>images/close.png" width="24" height="24" alt="Close" title="Close" style="cursor:pointer; margin:2; padding:9; border:#666666; border-style:dashed" onClick="navigate('../../../index.php');" />
    <div id="heading" align="left">
	  <h2>Bonus Report</h2>
    </div>
	<form name="form1" action="" method="post">
	<div class="divLine">
	<div align="center" style="height:30px"><strong>Select Employee Type:</strong> </td>
                   <select id="eType" name="eType">
                            <option value="0" selected="selected">--</option>
                            <?php
                            
                            	$countRLG=count($relgnTypArray);
								for ($i=1; $i < $countRLG; $i++){
									if ($empType==$i){
										$r=substr($relgnTypArray[$i], 0,1);
										print "<option value='$i' selected>$r</option>";
									}else{
										$r=substr($relgnTypArray[$i], 0,1);
										print "<option value='$i'>$r</option>";
									}
								
								}
                            
                            ?>
                   </select>
		</div>
		</div>
	 <div class="divLine">
		<div class="divCell" style="width:15%; vertical-align:middle" align="left"><strong>Bonus Period:</strong></div>
       <div class="divCell" style="width:30%; vertical-align:middle"><strong>From:</strong> <input name="fdt" type="text" id="fdt" onFocus="javascript:NewCssCal('fdt','yyyyMMdd','','','','');" onClick="javascript:NewCssCal('fdt','yyyyMMdd','','','','');" value="<?php echo $fdt?>" size="15" readonly="true"/></div>
		<div class="divCell" style="width:15%; vertical-align:bottom" align="center"><strong><strong>To:</strong></strong></div>
		<div class="divCell" style="width:25%"><input name="tdt" type="text" id="tdt" onFocus="javascript:NewCssCal('tdt','yyyyMMdd','','','','');" onClick="javascript:NewCssCal('tdt','yyyyMMdd','','','','');" value="<?php echo $tdt?>" size="15" readonly="true"/></div>
	</div>
	<div class="divLine">
		<div class="divCell" style="width:100%" align="center"><input type="button" id="show" name="show" Value="show" onClick="bsub();"></div>
	</div>
<?php
if($times<2){
    if($fdt && $empType<4){
?>
	<input type="image" align="right" border="1" src="<?= $rurl?>images/close.png" width="24" height="24" alt="Close Report" title="Close Report" style="cursor:pointer; margin:2; padding:9; border:#666666; border-style:dashed" onClick="navigate('bonusReport.php?times=2');" /><img src="<?= $rurl?>images/print_icon.gif" align="right" hspace="5" width="32" alt="Print MIS Report" title="Print MIS Report" height="32" style="cursor:pointer;" onClick="PrintDiv('printArea', 'MIS Report');" /> <img src="<?= $rurl?>images/csv.jpg" align="right" hspace="10" width="32" alt="CSV Download" title="CSV Download" height="32" style="cursor:pointer;" onClick="getCsv('<?= $m?>', '<?= $yr?>');" />
	<div id="printArea" align="center" style="page-break-inside:auto">
		<div class="divLine" style="border:thick; background:#CCCCCC; text-decoration:underline">
		<h3>Bonus Report for the period of <?=$misc->dateformat($fdt)?> to <?=$misc->dateformat($tdt)?></h3>
		</div>  
	  <table width="100%" border="1" cellpadding="3" cellspacing="0">
       
		<?
		$disRes=$obj->select("deptmanager");
		while($disFres=$obj->fetchrow($disRes)){
		
			if($empType<3){
				$empRes=$obj->select("empmaster", "empDept=$disFres[0] and empDoj<'$tdt' and empReligion=$empType order by empName");
			}else if($empType==3){
				$empRes=$obj->select("empmaster", "empDept=$disFres[0] and empDoj<'$tdt' order by empName");
			}
			$empRows=$obj->rows($empRes);
			if($empRows>0){
		?>
			<tr style="border:hidden">
			  <td style="border:hidden"><strong><h4>Department:</h4></strong></td>
			  <td style="hborder:hidden; font-size:14px; font-weight:900;" align="center"><h4><?=$disFres[1]?></h4> </td>
			  <td style="border:hidden">&nbsp;</td>
			  <td style="border:hidden">&nbsp;</td>
			  <td style="border:hidden">&nbsp;</td>
			  <td style="border:hidden">&nbsp;</td>
			  <td style="border:hidden">&nbsp;</td>
			  <td style="border:hidden">&nbsp;</td>
			</tr>
		
			 <tr>
          <td width="7%"><strong>Sl No.</strong></td>
          <td width="34%" align="center"><strong>Employee Name</strong></td>
		  <td width="4%">&nbsp;</td>
          <td width="15%" align="center"><strong>Date Of Joining</strong></td>
          <td width="9%" align="center"><strong>CTC</strong></td>
          <td width="8%" align="center"><strong>In Hand</strong> </td>
          <td width="10%" align="center"><strong>Total Basic Sal </strong></td>
          <td width="13%" align="center"><strong>Bonus @8.33%</strong> </td>
        </tr>
			<?
			
			while($empFres=$obj->fetchrow($empRes)){
				$s++;
				
				$arpHRA=0;
				$arpWA=0;
				
				$expldDt=explode("-", $dt);
				
				$m=4;
				$yr=$expldDt[0];
				$mnth=sprintf("%02d", $m);
				
				$ecode=$empFres[2];
				$totBasic=$eman->getEmpBasicTot($ecode, $fdt, $tdt);
				$attnd=$eman->empAttendance($ecode, $mnth, $yr);
				
				$bCal=$eman->getEmpBasicDet($ecode, $mnth, $yr);
				$hraCal=$eman->getHRA($ecode, $mnth, $yr);
				$waCal=$eman->getWA($ecode, $mnth, $yr);
				
				if($bCal>0){
					$basic=$bCal;
					$aprBasic=round(($basic/$attnd)*30);
				}else{
					$basic=$empFres[35];
					$aprBasic=$basic;
				}
				
				$alwRes=$obj->select("empallowance", "empCode='$empFres[2]' order by alwID");
				//print_r($alwRes);
				$alwRows=$obj->rows($alwRes);
				if($alwRows>0){
					while($alwFres=$obj->fetchrow($alwRes)){
						if($alwFres[2]==2){
							if($hraCal>0){
								$hra=$hraCal;
								$aprHRA=round(($hra/$attnd)*30);
							}else{
								if($alwFres[3]>0){
									$hra=$alwFres[3];
									$aprHRA=$hra;
								}else{
									$hra=0;
									$aprHRA=$hra;
								}
							}
						}else if($alwFres[2]==3){
							if($waCal>0){
								$wa=$waCal;
								$aprWA=round(($wa/$attnd)*30);
							}else{
								$wa=$alwFres[3];
								$aprWA=$wa;
							}
						}
					}
				}
				
				$configRes=$obj->select("salconfig");
				$configFres=$obj->fetchrow($configRes);
				
				$cRes=$obj->select("empsaldet", "empCode='$ecode' and salYear='$yr' and salMonth='$mnth'");
				//print_r($cRes);
				$cRows=$obj->rows($cRes);
				if($cRows>0){
					$mnthCC=$eman->getMnthCont($ecode, $mnth, $yr);
						
					$epfCC=$mnthCC[7]+$mnthCC[8]+$mnthCC[9]+$mnthCC[10]+$mnthCC[11];
					
					if($empFres[29]==1){
						$esiCC=$mnthCC[6];
					}else{
						$esiCC=0;
					}
				}else{
				
					$epfCC=(round($aprBasic*$configFres[5])/100)+(round($aprBasic*$configFres[6])/100)+(round($aprBasic*$configFres[7])/100)+(round($aprBasic*$configFres[9])/100)+(round($aprBasic*$configFres[10])/100);
					if($empFres[29]==1){
						$esiCC=(round($aprBasic*$configFres[3])/100);
					}else{
						$esiCC=0;
					}
					
				}
				$aprGross=$aprBasic+$aprWA+$aprHRA;
				
				$aprEpf=round(($aprBasic*$configFres[4])/100);
				if($empFres[29]==1){
					$arpEsi=round(($aprGross*$configFres[2])/100);
				}else{
					$arpEsi=0;
				}
				
				
						
				//$totCtc=$aprHRA;
				$totCtc=$aprGross+$epfCC;
				
				//$totInhand=$arpEsi;
				$totInhand=$aprGross-$aprEpf-$arpEsi-$profTax;
				
				//$totCtc=$ctc*12;
				//$totInhand=$inHand*12;
				
				$bonus=round($totBasic*.0833);
				
				$r=substr($relgnTypArray[$empFres[44]], 0, 1);
			?>
			<tr>
			  <td><?=$s?>.</td>
			  <td><?=$empFres[3]?></td>
			  <td align="center"><?=$r?></td>
			  <td align="center"><?=$misc->dateformat($empFres[10])?></td>
			  <td align="center"><?=(int)$totCtc?></td>
			  <td align="center"><?=(int)$totInhand?></td>
			  <td align="center"><?=(int)$totBasic?></td>
			  <td align="center"><?=(int)$bonus?></td>
			</tr>
			
<?

		unset($aprHRA);
		unset($aprWA);
		unset($totCtc);
		unset($totInhand);
		unset($aprEpf);
		unset($aprEsi);
			}
		}
	}
?>
      </table>			
</div>
<?
}
}
unset ($dt);
unset ($empType);
?>