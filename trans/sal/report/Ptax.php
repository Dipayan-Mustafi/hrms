<?php
error_reporting (E_ALL);
require ("../../../config/setup.inc");

$title="Professional Tax Report";

require($rpath."pageDesign.tmp.php");
require ($root."lib/datetime/datetimepicker_css_js.php");
$cdt=date('Y-m-d');

$lmt=15;


$eman=new empManagement();

$fyr=$_REQUEST['fy'];



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

	document.form1.submit();
}
</script>

<center>
<div class="contDiv">
<input type="image" align="right" border="1" src="<?= $rurl?>images/close.png" width="24" height="24" alt="Close" title="Close" style="cursor:pointer; margin:2; padding:9; border:#666666; border-style:dashed" onclick="navigate('../../../index.php');" />
    <div id="heading" align="left">
	  <h2>Professional Tax Report</h2>
    </div>
	<form name="form1" action="" method="post">
	 <table width="100%" border="0" cellpadding="1" cellspacing="0" bordercolor="#999999">
            <tr>
                   <td width="43%" align="center" ><strong>Select Financial year for the Report</strong></td>
                   <td width="28%">
                        <select id="fy" name="fy">
                            <option value="0" selected="selected">--</option>
                            <?php
                            if($fyr){
                            ?>
                                <option value="0" selected="selected"><?=$fyr?></option>
                            <?php
                            }else{
                            
                                $disRes=$obj->distinct("empsaldet", "finYear", "empCode>0");
                                $disRow=$obj->rows($disRes);

                                while($disFres=$obj->fetchrow($disRes)){
                                    print "<option value='$disFres[0]'>$disFres[0]</option>";
                                }
                            }
                            ?>
                        </select>                   </td>
                   <td width="29%"><input type="button" id="show" name="show" Value="show" onclick="bsub();"></td>
            </tr>
	 </table>
<?php
    if($fyr){
?>
	<input type="image" align="right" border="1" src="<?= $rurl?>images/close.png" width="24" height="24" alt="Close Report" title="Close Report" style="cursor:pointer; margin:2; padding:9; border:#666666; border-style:dashed" onclick="navigate('PTax.php');" /><img src="<?= $rurl?>images/print_icon.gif" align="right" hspace="5" width="32" alt="Print MIS Report" title="Print MIS Report" height="32" style="cursor:pointer;" onclick="PrintDiv('printArea', 'MIS Report');" /> <img src="<?= $rurl?>images/csv.jpg" align="right" hspace="10" width="32" alt="CSV Download" title="CSV Download" height="32" style="cursor:pointer;" onclick="getCsv('<?= $m?>', '<?= $yr?>');" />
<div id="printArea" align="center" style="page-break-inside:auto">
		  
                    <table width="100%" border="1">
                        <tr style="font-size:12px">
                            <th height="98"rowspan="3" align="center"><img src="<?=$rurl?>images/kanchan.png" width="414" height="60" style="float:left;"/>
				<div style="float:left; width:45%; text-align:cetner; font-size:13pt;">
					  <p>Professional Tax Details </p>
					  <p>For the Financial Year <?=$fyr?></p>
				</div>
                            </th>
			</tr>
                    </table>
                    <table width="100%" border="1" style="border:#000000" cellpadding="3" cellspacing="0">
                        <tr>
                          <td width="14%"><strong>Professional Tax Slab</strong> </td>
                            <td colspan="12" align="center"><strong>No. of Employees</strong> </td>
                            <td width="6%" align="center"><strong>Rate</strong></td>
                            <td width="42%" colspan="12" align="center"><strong>Tax Amount</strong> </td>
                        </tr>
                        <tr style="font-weight:800">
                          <td>&nbsp;</td>
                          <td width="4%" align="center">Apr</td>
                          <td width="4%" align="center">May</td>
                          <td width="3%" align="center">Jun</td>
                          <td width="3%" align="center">July</td>
                          <td width="3%" align="center">Aug</td>
                          <td width="3%" align="center">Sept</td>
                          <td width="3%" align="center">Oct</td>
                          <td width="3%" align="center">Nov</td>
                          <td width="3%" align="center">Dec</td>
                          <td width="3%" align="center">Jan</td>
                          <td width="3%" align="center">Feb</td>
                          <td width="3%" align="center">Mar</td>
                          <td>&nbsp;</td>
                          <td align="center">Apr</td>
                          <td align="center">May</td>
                          <td align="center">Jun</td>
                          <td align="center">July</td>
                          <td align="center">Aug</td>
                          <td align="center">Sept</td>
                          <td align="center">Oct</td>
                          <td align="center">Nov</td>
                          <td align="center">Dec</td>
                          <td align="center">Jan</td>
                          <td align="center">Feb</td>
                          <td align="center">March</td>
                        </tr>
						<?
						$ptRes=$obj->select("ptmaster", "ptmID>1");
						while($ptFres=$obj->fetchRow($ptRes)){
							
							$rt=90;
						?>
						
						<tr>
                          <td style="font-weight:800"><?=$ptFres[1]."-".$ptFres[2]?></td>
                          <td width="4%" align="center">
						  <?
						  	$aprl=$eman->countPtax(04, $ptFres[3], $fyr);
						  ?><?=$aprl?></td>
                          <td width="4%" align="center"> <?
						  	$may=$eman->countPtax(05, $ptFres[3], $fyr);
						  ?><?=$may?></td>
                          <td width="3%" align="center"> <?
						  	$jun=$eman->countPtax(06, $ptFres[3], $fyr);
						  ?><?=$jun?></td>
                          <td width="3%" align="center"> <?
						  	$jul=$eman->countPtax(07, $ptFres[3], $fyr);
						  ?><?=$jul?></td>
                          <td width="3%" align="center"> <?
						  	$aug=$eman->countPtax('08', $ptFres[3], $fyr);
						  ?><?=$aug?></td>
                          <td width="3%" align="center"> <?
						  	$sept=$eman->countPtax('09', $ptFres[3], $fyr);
						  ?><?=$sept?></td>
                          <td width="3%" align="center"><?
						  	$oct=$eman->countPtax(10, $ptFres[3], $fyr);
						  ?><?=$oct?></td>
                          <td width="3%" align="center"><?
						  	$nov=$eman->countPtax(11, $ptFres[3], $fyr);
						  ?><?=$nov?></td>
                          <td width="3%" align="center"><?
						  	$dec=$eman->countPtax(12, $ptFres[3], $fyr);
						  ?><?=$dec?></td>
                          <td width="3%" align="center"><?
						  	$jan=$eman->countPtax(01, $ptFres[3], $fyr);
						  ?><?=$jan?></td>
                          <td width="3%" align="center"><?
						  	$feb=$eman->countPtax(02, $ptFres[3], $fyr);
						  ?><?=$feb?></td>
                          <td width="3%" align="center"><?
						  	$march=$eman->countPtax(03, $ptFres[3], $fyr);
						  ?><?=$march?></td>
                          <?
						  if($ptFres[0]>2){
						  ?>
						  
						  <td><?=sprintf("%.2f", $ptFres[3])?></td>
						  <?		
						  }else{ 
						  ?>
						   <td><?=sprintf("%.2f", $rt)?></td>
						<?	
								}
						  ?>
                          
						  
						  <td width="4%" align="center">
						  <?
						  	$aprlA=$eman->countPtaxAmount(04, $ptFres[3], $fyr);
						  ?><?=$aprlA?></td>
                          <td width="4%" align="center"> <?
						  	$mayA=$eman->countPtaxAmount(05, $ptFres[3], $fyr);
						  ?><?=$mayA?></td>
                          <td width="3%" align="center"> <?
						  	$junA=$eman->countPtaxAmount(06, $ptFres[3], $fyr);
						  ?><?=$junA?></td>
                          <td width="3%" align="center"> <?
						  	$julA=$eman->countPtaxAmount(07, $ptFres[3], $fyr);
						  ?><?=$julA?></td>
                          <td width="3%" align="center"> <?
						  	$augA=$eman->countPtaxAmount('08', $ptFres[3], $fyr);
						  ?><?=$augA?></td>
                          <td width="3%" align="center"> <?
						  	$septA=$eman->countPtaxAmount('09', $ptFres[3], $fyr);
						  ?><?=$septA?></td>
                          <td width="3%" align="center"><?
						  	$octA=$eman->countPtaxAmount(10, $ptFres[3], $fyr);
						  ?><?=$octA?></td>
                          <td width="3%" align="center"><?
						  	$novA=$eman->countPtaxAmount(11, $ptFres[3], $fyr);
						  ?><?=$novA?></td>
                          <td width="3%" align="center"><?
						  	$decA=$eman->countPtaxAmount(12, $ptFres[3], $fyr);
						  ?><?=$decA?></td>
                          <td width="3%" align="center"><?
						  	$janA=$eman->countPtaxAmount(01, $ptFres[3], $fyr);
						  ?><?=$janA?></td>
                          <td width="3%" align="center"><?
						  	$febA=$eman->countPtaxAmount(02, $ptFres[3], $fyr);
						  ?><?=$febA?></td>
                          <td width="3%" align="center"><?
						  	$marchA=$eman->countPtaxAmount(03, $ptFres[3], $fyr);
						  ?><?=$marchA?></td>
                        </tr>
						<?
						$aprilC=$aprilC+$aprl; $aprilTot=$aprilTot+$aprlA;
						$mayC=$mayC+$may; $mayTot=$mayTot+$mayA;
						$junC=$junC+$jun; $junTot=$junTot+$junA;
						$julC=$julC+$jul; $julTot=$julTot+$julA;
						$augC=$augC+$aug; $augTot=$augTot+$augA;
						$septC=$septC+$sept; $septTot=$septTot+$septA;
						$octC=$octC+$oct; $octTot=$octTot+$octA;
						$novC=$novC+$nov; $novTot=$novTot+$novA;
						$decC=$decC+$dec; $decTot=$decTot+$decA;
						$janC=$janC+$jan; $janTot=$janTot+$janA;
						$febC=$febC+$feb; $febTot=$febTot+$febA;
						$marchC=$marchC+$march; $marchTot=$marchTot+$marchA;
						}
						?>
						<tr style="font-weight:800">
						  <td align="right"><strong>Total</strong></td>
						  <td align="center"><?=$aprilC?></td>
						  <td align="center"><?=$mayC?></td>
						  <td align="center"><?=$junC?></td>
						  <td align="center"><?=$julC?></td>
						  <td align="center"><?=$augC?></td>
						  <td align="center"><?=$septC?></td>
						  <td align="center"><?=$octC?></td>
						  <td align="center"><?=$novC?></td>
						  <td align="center"><?=$decC?></td>
						  <td align="center"><?=$janC?></td>
						  <td align="center"><?=$febC?></td>
						  <td align="center"><?=$marchC?></td>
						  <td>&nbsp;</td>
						  <td align="center"><?=$aprilTot?></td>
						  <td align="center"><?=$mayTot?></td>
						  <td align="center"><?=$junTot?></td>
						  <td align="center"><?=$julTot?></td>
						  <td align="center"><?=$augTot?></td>
						  <td align="center"><?=$septTot?></td>
						  <td align="center"><?=$octTot?></td>
						  <td align="center"><?=$novTot?></td>
						  <td align="center"><?=$decTot?></td>
						  <td align="center"><?=$janTot?></td>
						  <td align="center"><?=$febTot?></td>
						  <td align="center"><?=$marchTot?></td>
					  </tr>
  </table>

                        
<?php
  unset($aprilC);  }
?>          
                        
</div>
</div>

</center>