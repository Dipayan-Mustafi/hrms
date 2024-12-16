<?
error_reporting (E_ALL);
require ("../../../config/setup.inc");

$title="MIS REPORTS";

require($rpath."pageDesign.tmp.php");
require ($root."lib/datetime/datetimepicker_css_js.php");
$cdt=date('Y-m-d');

$lmt=15;


$eman=new empManagement();

$dept=$_REQUEST['dept'];
$m=$_REQUEST['mnth'];
$yr=$_REQUEST['year'];
$fdt=$_REQUEST['fdt'];
$tdt=$_REQUEST['tdt'];
$flg=$_REQUEST['flg'];

$d=cal_days_in_month(CAL_GREGORIAN,"$m","$yr");
$page=0;

$expFdt=explode("-",$fdt);
$syr=$expFdt[0];

$expTdt=explode("-",$tdt);
$eyr=$expTdt[0];

$smnth=date("m", strtotime($fdt));
$emnth=date("m", strtotime($tdt));

$prvMnth=($smnth=="01") ? "12" : sprintf("%02d", ($smnth-1));
$prvYear=($smnth=="01") ? ($syr-1) : $syr;
$slctArray=array("--", "ALL", "Individual", "Departmentwise");
$sdt=$prvYear."-".$prvMnth."-".$expFdt[2];

$slc=($_GET['slc']) ? $_GET['slc'] : 0;

 if ($dept){
 		$mRes=$obj->distinct("empmaster", "empCode", "empDept='$dept' and empCode>0 order by empName");
	}else{
		$mRes=$obj->distinct("empmaster", "empCode", "empCode>0 order by empName");
	}
	
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
function goNext(){
		
	if (document.getElementById('frm').value==0){
		alert ("Please select Staring Date");
	}else if (document.getElementById('to').value==0){
		alert ("Please select Ending Date");
	}else{
			document.form1.submit();
	}
	
	
}
function getSlc(s){
	window.location="?slc="+s;
}

function findEmp(e){
    
    var ajaxRequest;
    if (window.XMLHttpRequest){
    // code for IE7+, Firefox, Chrome, Opera, Safari
            ajaxRequest=new XMLHttpRequest();
    }else{
            // code for IE6, IE5
            ajaxRequest=new ActiveXObject("Microsoft.XMLHTTP");
    }

    //Function which is receiving data sent from server
    ajaxRequest.onreadystatechange=function(){
            if (ajaxRequest.readyState==4 && ajaxRequest.status==200){
					
					document.getElementById('nSrch').style.display="table";
                    document.getElementById('nSrch').innerHTML=ajaxRequest.responseText;
                    //document.getElementById('listShow').style.display="block";


            }else{
                    //alert (ajaxRequest.status);
                    document.getElementById('nSrch').innerHTML="Loading........................";
            }

    }


            var qstring="?emp="+e;

            ajaxRequest.open("GET","include/nSrch.php" + qstring, true);
            ajaxRequest.send(null);
    
}
function fillEmpCode(mn){
	
	document.getElementById('eq').value=mn;
	

	HideList('nSrch');
}
function goNext(){
		
	if (document.getElementById('frm').value==0){
		alert ("Please select Staring Date");
	}else if (document.getElementById('to').value==0){
		alert ("Please select Ending Date");
	}else{
			document.form1.submit();
	}
	
	
}
function getSlc(s){
	window.location="?slc="+s;
}

function findEmp(e){
    
    var ajaxRequest;
    if (window.XMLHttpRequest){
    // code for IE7+, Firefox, Chrome, Opera, Safari
            ajaxRequest=new XMLHttpRequest();
    }else{
            // code for IE6, IE5
            ajaxRequest=new ActiveXObject("Microsoft.XMLHTTP");
    }

    //Function which is receiving data sent from server
    ajaxRequest.onreadystatechange=function(){
            if (ajaxRequest.readyState==4 && ajaxRequest.status==200){
					
					document.getElementById('nSrch').style.display="table";
                    document.getElementById('nSrch').innerHTML=ajaxRequest.responseText;
                    //document.getElementById('listShow').style.display="block";


            }else{
                    //alert (ajaxRequest.status);
                    document.getElementById('nSrch').innerHTML="Loading........................";
            }

    }


            var qstring="?emp="+e;

            ajaxRequest.open("GET","include/nSrch.php" + qstring, true);
            ajaxRequest.send(null);
    
}
function fillEmpCode(mn){
	
	document.getElementById('eq').value=mn;
	

	HideList('nSrch');
}
</script>

<center>
<div class="contDiv">
<input type="image" align="right" border="1" src="<?= $rurl?>images/close.png" width="24" height="24" alt="Close" title="Close" style="cursor:pointer; margin:2; padding:9; border:#666666; border-style:dashed" onclick="navigate('../../../index.php');" />
	  <div id="heading" align="left">
	  <h2>MIS Report</h2>
	  </div>
	  <div class="divLine">
		<div class="divCell" style="width:46%;">
			<h3>Selection Criteria</h3>
			<?php
			$countSLC=count($slctArray);
			for ($i=1; $i < $countSLC ; $i++){
			
				if ($slc==$i){
					echo "<p><input type='radio' name='rad' id='rad' value='$i' checked='checked'> $slctArray[$i] </p>";
				}else{
					echo "<p><input type='radio' name='rad' id='rad' value='$i' onclick='getSlc(this.value);'> $slctArray[$i] </p>";
				}
			
			}
			
			?>
		</div>
		<div class="divCell" width="48%">
			<?php
			if ($slc){
			?>
			<form name="form1" action="direction.php" method="post">
			<input type="hidden" name="stp" value="<?= $slc?>" />
			<p>From</p>
			<p><input name="frm" type="text" id="frm" size="15" value="<?php echo $fdt?>" onClick="javascript:NewCssCal('frm','yyyyMMdd','','','','','past');" onFocus="javascript:NewCssCal('frm','yyyyMMdd','','','','','past');" readonly="true"/></p>
			<p>To</p>
			<p><input name="to" type="text" id="to" value="<?php echo date('Y-m-d')?>" size="15" onClick="javascript:NewCssCal('to','yyyyMMdd','','','','','past');" onFocus="javascript:NewCssCal('frm','yyyyMMdd','','','','','past');" readonly="true"/></p>
			
			<?php
                            switch ($slc){
                                case 2:
                                    $cont=  file_get_contents($url."trans/sal/report/include/empSearch");
                                    echo $cont;
                                    
                                    break;
								case 3:
                                	$cont=  file_get_contents($url."trans/sal/report/include/deptSearch");
                                    echo $cont;
                                    
                                    break;
									
                                default:
                                    
                                    break;
                            }
                        
			}
			?>
						<input type="hidden" name="flg" id="flg" value="3" />
	
                        <input type='button' value='Show' onclick='goNext()'>
			
		</div>
	
	</form>
<? if($flg>0){?>
	  <input type="image" align="right" border="1" src="<?= $rurl?>images/close.png" width="24" height="24" alt="Close" title="Close" style="cursor:pointer; margin:2; padding:9; border:#666666; border-style:dashed" onclick="navigate('mis.php');" /><div style="text-align:right"><img src="<?= $rurl?>images/print_icon.gif" width="32" alt="Print MIS Report" title="Print MIS Report" height="32" style="cursor:pointer;" onclick="PrintDiv('printArea', 'MIS Report');" /> <img src="<?= $rurl?>images/csv.jpg" width="32" alt="CSV Download" title="CSV Download" height="32" style="cursor:pointer;" onclick="getCsv('<?= $m?>', '<?= $yr?>');" /></div>
	  
		<div id="printArea" align="center" style="page-break-inside:auto">
		  <table width="100%" border="1">
              <tr style="font-size:12px">
				<th height="98" colspan="6" rowspan="3" align="center"><img src="<?=$rurl?>images/kanchan.png" width="414" height="60" style="float:left;"/>
					<div style="float:left; width:45%; text-align:cetner; font-size:13pt;">
					  <p>MIS Report </p>
					  <p>from <?= $misc->dateformat($fdt);?>, to <?= $misc->dateformat($tdt);?></p>
				    </div></th>
					<?
					if($dept){
						$deptName=$eman->deptDet($dept);
					}else{
						$deptName="(ALL)";
					}
					?>
				<th width="29%" colspan="3"align="center" style="border-left:thin; border-bottom:hidden"><h4><p>FOR THE DEPARTMENT OF</p><p><?=$deptName?></p></h4></th>
		      </tr>
		  </table>
			
		  <table width="100%" border="1">
			  <tr>
                <td width="2%" rowspan="2" align="center"><strong>Sl. No.</strong> </td>
                <td width="21%" rowspan="2" align="center"><strong>Employee Name </strong></td>
                <td width="3%" rowspan="2" align="center"><strong>EPF No.</strong></td>
                <td width="3%" rowspan="2" align="center"><strong>ESI No.</strong> </td>
                <td width="6%" rowspan="2" align="center"><strong>Attendence</strong></td>
                <td width="3%" rowspan="2" align="center"><strong>Basic</strong></td>
                <td width="6%" rowspan="2" align="center"><strong>Washing Allowence</strong></td>
                <td width="8%" rowspan="2" align="center"><strong>House Rental Allowence</strong></td>
                <td width="4%" rowspan="2" align="center"><strong>Gross</strong></td>
                <td colspan="3" align="center"><strong>Employee Deduction </strong></td>
                <td colspan="2" align="center"><strong>Employeers contribution </strong></td>
                <td width="6%" rowspan="2" align="center"><strong>CTC</strong></td>
			    <td width="8%" rowspan="2" align="center"><strong>In Hand</strong> </td>
			  </tr>
              <tr>
                <td width="7%" align="center"><strong>Prof Tax</strong></td>
                <td width="5%" align="center"><strong>EPF (@12%)</strong> </td>
                <td width="6%" align="center"><strong>ESI (@1.75%)</strong> </td>
                <td width="6%" align="center"><strong>EPF (@13.36%)</strong> </td>
				<td width="6%" align="center"><strong>ESI (@4.75%) </strong></td>
			  </tr>
              <?
			while($mfres=$obj->fetchrow($mRes)){
				$disRes=$obj->select("empsaldet", "empCode='$mfres[0]' and salDate>='$sdt' and salDate<='$tdt' and payHead='Basic'");
				/*print_r($disRes);
				print "</br>";*/
				$disRows=$obj->rows($disRes);
				$disFres=$obj->fetchRow($disRes);
				
					$empDet=$eman->getEmpDet($disFres[1]);
					//print_r($disRes);
					//print "<br>";
					if($disFres[1]==$empDet[2]){
							$s++;
							
							$basic=$eman->getEmpBasicTot($disFres[1], $sdt, $tdt);		
							$emppf=$eman->getPFEmpShareTot($disFres[1], $sdt, $tdt);
							$empesiRes=$eman->getESIEmpShareTot($disFres[1], $sdt, $tdt);
							$WA=$eman->getWATot($disFres[1], $sdt, $tdt);
							$hra=$eman->getHRATot($disFres[1], $sdt, $tdt);
							$pTaxRes=$eman->getPtaxTot($disFres[1], $sdt, $tdt);
							$attnd=$eman->empAttendanceTot($disFres[1], $fdt, $tdt);					
							
							$pTax=($pTaxRes) ? $pTaxRes : 0;
							$waf=($WA) ? $WA : 0;
							$hraf=($hra) ? $hra : 0;
							$empesi=($empesiRes) ? $empesiRes : 0;
							
							$epfCCal=$eman->getEpfContTot($disFres[1], $sdt, $tdt);
							$epfCC=($epfCCal) ? $epfCCal:0;
							
							$esiCCal=$eman->getEsiContTot($disFres[1], $sdt, $tdt);
							$esiCC=($esiCCal) ? $esiCCal:0;
							
							$gross=$waf+$hraf+$basic;
							$ctc=$gross+$epfCC+$esiCC;
							$inhand=$gross-$emppf-$empesi;
							
							$epfNo=($empDet[31]) ?	$empDet[31] : "NONE";
							$esiNo=($empDet[38]) ? $empDet[38] : "NONE";		
							
							if($disRows){			
						?>
					
					  <tr>
						<td><?=$s?></td>
						<td align="left" style="font-size:11px; cursor:pointer;" onclick="navigate('direction.php?flg=3&frm=<?=$fdt?>&to=<?=$tdt?>&amp;eq=<?=$empDet[2]?>');"><?=$empDet[3]?></td>
						<td align="center"><?=$epfNo?></td>
						<td align="center"><?=$esiNo?></td>
						<td align="center"><?=$attnd?></td>
						<td align="center"><?=(int)$basic?></td>
						<td align="center"><?=(int)$waf?></td>
						<td align="center"><?=(int)$hraf?></td>
						<td align="center"><?=$gross?></td>
						<td align="center"><?=(int)$pTax?></td>
						<td align="center"><?=(int)$emppf?></td>
						<td align="center"><?=(int)$empesi?></td>
						<td align="center"><?=(int)$epfCC?></td>
						<td width="6%" align="center"><?=$esiCC?></td>
						<td width="6%" align="center"><?=$ctc?></td>
						<td width="8%" align="center"><?=$inhand?></td>
					  </tr>
					  
						<?
						$totBasic+=$basic;
						$totHra+=$hra;
						$totWa+=$WA;
						$totGross+=$gross;
						$totProfTax+=$pTaxRes;
						$totEpf+=$emppf;
						$totEsi+=$empesiRes;
						$totPfCont+=$epfCC;
						$totEsiCont+=$esiCC;
						$totCtc=$totCtc+$ctc;
						$totInhand+=$inhand;
						}
						}
			  
			  }
			  ?>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center"><strong>TOTAL:</strong></td>
                <td align="center"><?=$totBasic?></td>
                <td align="center"><?=$totWa?></td>
                <td align="center"><?=(int)$totHra?></td>
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
			/*}else{
			?>
		  <table width="100%" border="1">
			  <tr>
			  	<td width="100%" align="center"><h2>SALARY NOT YET GENERATED OF THIS TIME FRAME</h2></td>
			  </tr>
		  </table>
		  <?
		  }*/
		 } ?>
		</div>

</div>

</center>