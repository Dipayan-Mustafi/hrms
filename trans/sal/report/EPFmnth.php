<?php

require ("../../../config/setup.inc");

$title="Monthy PF Report";

require($rpath."pageDesign.tmp.php");

$mnthArray=array( "", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");

$cdt=date('Y-m-d');

$lmt=15;

$endyr=date('Y');
$styr=$endyr -3;


$eman=new empManagement();

$dept=$_REQUEST['dept'];
$m=$_REQUEST['mnth'];
$yr=$_REQUEST['year'];
$typ=$_REQUEST['typ'];
$d=cal_days_in_month(CAL_GREGORIAN,"$m","$yr");
$page=0;

$prvMnth=($m=="01") ? "12" : sprintf("%02d", ($m-1));
$prvYear=($m=="01") ? ($yr-1) : $yr;

if($m<10){
	$sm="0".(int)$m;
}else{
	$sm=$m;
}

$monthName = date("F", strtotime($sm));
?>

<style type='text/css'>
 .ddhead { width:375mm; padding:5px; display:table; font-weight:bold; font-family:arial; font-size:13px;}
 .rowHead {width:375mm; display:table; font-family:arial; font-size:13px; border:solid 1px #666666; border-left:none; border-right:none;}
 .rowFoot {width:375mm; display:table; font-family:arial; font-size:13px; border:solid 1px #666666; border-left:none; border-right:none;page-break-after:always}
 .divCell {float:left}
 .divLine {width:100%;display:table; height:3%}

.style1 {font-size: 12px}
	#fldSet{
		border:solid 1px #666666;
		border-radius:5px;
		padding: 5px;
		
		background-color:#CCCCCC;
		display:inline-table;
		overflow:auto;
	}
	#lgnd {
		font-weight:bold; 
		font-family:arial;
		font-size:15px;
	}
	
	.detLine{
		border-bottom:solid 1px #000000;
		padding: 5px 10px 5px 10px;
		display:inline-table;
		width:99%;
		cursor:pointer;
	}
	.detLine:hover {
		
		background-color:#727272;
		display:inline-block;
		color:#FFFFFF;
	
	}

</style>
<script type="text/javascript">
function getCsv(m,y){

	
}
function goNext(){
		
	if (document.getElementById('mth').value==0){
		alert ("Please select Month");
	}else if (document.getElementById('yr').value==0){
		alert ("Please select Year");
	}else if (document.getElementById('typ').value==0){
		alert ("Please select Catagory of the Report");
	}else{
			document.form1.submit();
	}
	
	
}	
</script>

<center>
<div class="contDiv">
	<input type="image" align="right" border="1" src="<?= $rurl?>images/close.png" width="24" height="24" alt="Close" title="Close" style="cursor:pointer; margin:2; padding:9; border:#666666; border-style:dashed" onclick="navigate('../../../index.php');" />
	<div id="heading">
	  <h3>PF REPORTS </h3>
	</div>
	<form name="form1" action="direction.php" method="post">
		<input type="hidden" name="flg" id="flg" value="2" />
	 <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#999999">
			<tr>
			<th width="18%" align="center"> Select Report Type </th>
			<th width="82" align="left" valign="top"> <select id="typ" name="typ">
				<option value="0">--</option>
				<option value="1" >Monthly contribution Report</option>
				<option value="2" >Wages Report</option>
				</select>
			</th>
			<th width="321" align="center" valign="top"><strong>Select Department </strong></th>
			<th width="328" align="left" valign="top"><select id="dept" name="dept">
									<option value="0">--</option>
				<?
					 $res=$obj->select("deptmanager", "deptID > 1 order by deptID");
					 while($fres=$obj->fetchrow($res)){
						if($dept==$fres[0]){
							print "<option value='$fres[0]' selected='selected'>$fres[1]</option>";
						}else{
							print "<option value='$fres[0]'>$fres[1]</option>";
						}	
					  }
				?>
				</select></th>
			</tr>
			</table>
			<table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC">
			<tr>
			<th width="18%" align="center">Select Month</th>
            <th width="32%" align="left" valign="top">
				<select id="mth" name="mth">
									<option value="0">--</option>
				<?
					$cMnth=count($mnthArray);
					for ($i=1;$i<$cMnth; $i++){
							if($m==$i){
								print "<option value='$i' selected='selected'>$mnthArray[$i]</option>";
							}else{
								print "<option value='$i'>$mnthArray[$i]</option>";
							}
						}
				?>
				</select>
				<input type="hidden" name="mnth" id="mnth"/>
			</th>
			
			<th width="18%" align="center">Select Year</th>
			<th width="32%" align="left" valign="top"><select id="yr" name="yr" onChange="fillyr(this.value);">
								<option value="0">--</option>
				<?
					 for ($i=$styr; $i<=date('Y'); $i++){
							if($yr==$i){
								print "<option value='$i' selected='selected'>$i</option>";
							}else{
								print "<option value='$i'>$i</option>";
							}
					  }
				?>
				</select>
			</th>
			</tr>
			
		  </table>
		  <table width="100%" border="0" cellpadding="3" cellspacing="0">
		  <tr>
		  <th align="center"><input type="button" name="btnAll" id="btnAll" value="Preview" onclick="goNext();">
		  </th>
		  </tr>
		  </table>
</form>
	
	<input type="image" align="right" border="1" src="<?= $rurl?>images/close.png" width="24" height="24" alt="Close" title="Close" style="cursor:pointer; margin:2; padding:9; border:#666666; border-style:dashed" onclick="navigate('PFIndex.php');" /><img src="<?= $rurl?>images/print_icon.gif" align="right" hspace="5" width="32" alt="Print Sheet" title="Print Report" height="32" style="cursor:pointer;" onclick="PrintDiv('printArea', 'EPF Report');" /> <img src="<?= $rurl?>images/csv.jpg" align="right" hspace="10" width="32" alt="CSV Download" title="CSV Download" height="32" style="cursor:pointer;" onclick="getCsv('<?= $m?>', '<?= $yr?>');" />
	<div id="heading" align="center" style="font-family:'Times New Roman', Times, serif">
	  <h3>EPF MONTHLY REPORTS </h3>
	</div>
	<div id="printArea" align="center" style="page-break-inside:auto">
	
		<table width="100%" border="0" bordercolorlight="#CCCCCC" cellspacing="0" cellpadding="0" style="font-family:arial; font-size:10pt; ">
		  <tr>
            <th colspan="3" align="center"><h2 class="style1">EMPLOYEES' PROVIDENT FUND ORGANISATION, KOLKATA<br />
              ELECTRONIC CHALLAN CUM RETURN (ECR)
                  <br />
            FOR THE WAGE MONTH OF <h4><?= strtoupper ($mnthArray[$m])?></h4></h2></th>
          </tr>
		  <tr style="font-size:12px">
		    <th width="18%" align="left">ESTABLISHMENT ID </th>
	        <th width="79%" align="left">WBCAL0025282000</th>
	        <th width="3%" align="left">&nbsp;</th>
		  </tr>
		  <tr style="font-size:12px">
		    <th align="left">NAME OF ESTABLISHMENT </th>
		    <th align="left">KANCHAN VANIJYA PVT LTD </th>
		    <th align="left">&nbsp;</th>
	      </tr>
		  <tr style="font-size:12px">
		    <th align="left">TRRN</th>
		    <th align="left">&nbsp;</th>
		    <th align="left">&nbsp;</th>
	      </tr>
		  <tr >		  </tr>
	  </table>
		 <table width="100%" border="1" bordercolorlight="#CCCCCC" cellspacing="0" cellpadding="0" style="font-family:arial; font-size:9pt;">
		 <tr>
		   <th width="3%" align="left">SL. No.</th>
			<th >Member Id </th>
		   <th width="13%"><p>Member Name</p>	      </th>
			<th width="9%">EPF Wages </th>
			<th width="10%" align="center">EPS Wages </th>
			<th width="8%">EPF Contribution (EE Share) due </th>
			<th width="8%">EPF Contribution (EE Share) being remitted </th>
			<th width="7%">EPS Contribution due </th>
			<th width="7%">EPS Contribution being remitted </th>
			<th width="9%">Diff EPF and EPS Contribution(ER Share) due </th>
			<th width="9%">Diff EPF and EPS Contribution(ER Share) being remitted </th>
			<th width="5%">NCP Days </th>
		    <th width="5%">Refund of Advances </th>
		 </tr>
		
		 <?php		
		 	if ($dept){
				$deptRes=$obj->select("deptmanager", "deptID='$dept'");
				$deptFres=$obj->fetchrow($deptRes);	
		 		$disRes=$obj->distinct("empsaldet", "empCode", "salMonth='$sm' and salYear='$yr' and deptID='$deptFres[0]' and headTyp='1' and alwID='0' and payAmount >0 order by empCode");
			}else{
				$disRes=$obj->distinct("empsaldet", "empCode", "salMonth='$sm' and salYear='$yr' and headTyp='1' and alwID='0' and payAmount >0 order by empCode");
			}
			$rows=$obj->rows($disRes);
			if($rows<1){
		?>
			<tr>
			<td colspan="13" align="center" style="font-size:16px"><strong>SALARY NOT YET GENERATED</strong>			</tr>
		<?php 	
			}else{	
				while($disFres=$obj->fetchrow($disRes)){
					
					$empDet=$eman->getEmpDet($disFres[0]);
					$basic=$eman->getEmpBasicDet($disFres[0], $sm, $yr);
					
					$scRes=$obj->select("salconfig");
					$scFres=$obj->Fetchrow($scRes);
					
					$esiBasic=($basic > $scFres[8] ) ? $scFres[8] : $basic;
					
					$eePF=$eman->getPFEmpShare($disFres[0], $sm, $yr);
					
					$contDet=$eman->getMnthCont($disFres[0], $sm, $yr);
					
					$attnDet=$eman->empAttendance($disFres[0], $sm, $yr);
				
					if ($empDet[31]){
						$s++;
		?>	
		<tr>
			<td align="center"><?php echo $s?></td>
			<td width="7%"><?php printf("%07d", $disFres[0])?></td>
			<td width="13%" align="left"><?php echo $empDet[3]?></td>
			<td align="center"><?php printf("%0.2f", $basic)?></td>
			<td align="center"><?php printf("%0.2f", $esiBasic)?></td>
			<td align="center"><?php printf("%0.2f", $eePF);?></td>
			<td align="center"><?php printf("%0.2f", $eePF);?></td>
			<td  align="center"><?php printf("%0.2f", $contDet[8])?></td>
			<td  align="center"><?php printf("%0.2f", $contDet[8])?></td>
			<td  align="center"><?php printf("%0.2f", $contDet[7])?></td>
			<td  align="center"><?php printf("%0.2f", $contDet[7])?></td>
			<td  align="center"><?php echo $attnDet[6]?></td>
			<td  align="center"><?php printf("%0.2f", 0)?></td>
		</tr>
		
		<?php
					$totBasic=$totBasic+$basic;
					$totEBasic=$totEBasic+$esiBasic;
					$totEPF=$totEPF+$eePF;
					$totEPS=$totEPS+$contDet[8];
					$totDiff=$totDiff+$contDet[7];
					$totNCP=$totNCP+$attnDet[6];
				}
			}
		}
		?>
		<tr>
		  <th align="center">&nbsp;</th>
		  <th colspan="2" align="left">GRAND TOTAL </th>
		  <th align="center"><?php printf("%0.2f", $totBasic)?></th>
		  <th align="center"><?php printf("%0.2f", $totEBasic)?></th>
		  <th align="center"><?php printf("%0.2f", $totEPF)?></th>
		  <th align="center"><?php printf("%0.2f", $totEPF)?></th>
		  <th  align="center"><?php printf("%0.2f", $totEPS)?></th>
		  <th  align="center"><?php printf("%0.2f", $totEPS)?></th>
		  <th  align="center"><?php printf("%0.2f", $totDiff)?></th>
		  <th  align="center"><?php printf("%0.2f", $totDiff)?></th>
		  <th  align="center"><?php echo $totNCP?></th>
		  <th  align="center">&nbsp;</th>
		  </tr>
		</table>
		
		<?php
		
			unset($totGross);
			unset($totEmpEsi);
			unset($totCompEsi);
			unset($totded);
			
		?>
	</div>
</div>
</div>
</center>