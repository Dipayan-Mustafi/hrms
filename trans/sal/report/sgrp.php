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

$dept=$_REQUEST['dpt'];
$m=$_REQUEST['mnth'];
$yr=$_REQUEST['year'];

$d=cal_days_in_month(CAL_GREGORIAN,"$m","$yr");

$sm=sprintf("%02d",$m);

$page=0;


?>

<style type='text/css'>
 .ddhead { width:375mm; padding:5px; display:table; font-weight:bold; font-family:arial; font-size:13px;}
 .rowHead {width:375mm; display:table; font-family:arial; font-size:13px; border:solid 1px #666666; border-left:none; border-right:none;}
 .rowFoot {width:375mm; display:table; font-family:arial; font-size:13px; border:solid 1px #666666; border-left:none; border-right:none;page-break-after:always}
 .divCell {float:left}
 .divLine {width:100%;display:table; height:3%}

</style>
<script type="text/javascript">

function goNext(){
	if (document.getElementById('mth').value==0){
		alert ("Please select Proper Month");
	}else if (document.getElementById('yr').value==0){
		alert ("Please select Proper year");
	}else{
			document.form1.submit();
	}
	
	
}	
</script>
<center>
<div class="contDiv">
	<input type="image" align="right" border="1" src="<?= $rurl?>images/close.png" width="24" height="24" alt="Close" title="Close" style="cursor:pointer; margin:2; padding:9; border:#666666; border-style:dashed; " onclick="navigate('index.php');" /> <input type="image" align="right" hspace="10" src="<?= $rurl?>images/print_icon.gif" width="32" height="32" alt="Print Sheet" title="Print Salary Sheet" style="cursor:pointer;" onclick="PrintDiv('printArea', 'Salary Sheet');" />
	<input type="image" align="right" border="1" src="<?= $rurl?>images/close.png" width="24" height="24" alt="Close" title="Close" style="cursor:pointer; margin:2; padding:9; border:#666666; border-style:dashed" onclick="navigate('../../../index.php');" />
	<div id="heading"><h3>Sub Group Report</h3></div>
	<form name="form1" action="" method="post">
	 <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#999999">
			<tr>
			<th width="18%" align="center">Select Month</th>
            <th width="32%" align="left" valign="top"> <select id="mth" name="mth" onChange="fillMnth(this.value);">
									<option value="0" selected="selected">--</option>
				<?
					$cMnth=count($mnthArray);
					for ($i=1;$i<$cMnth; $i++){
							
								print "<option value='$i'>$mnthArray[$i]</option>";
						}
				?>
				</select>
				<input type="hidden" name="mnth" id="mnth"/>
			</th>
			
			<th width="18%" align="center"> Select Year</th>
			<th width="32%" align="left" valign="top"> <select id="yr" name="yr" onChange="fillyr(this.value);">
								<option value="0" selected="selected">--</option>
				<?
					 for ($i=$styr; $i<=date('Y'); $i++){
						
							print "<option value='$i'>$i</option>";
						
					  }
				?>
				</select>
				<input type="hidden" name="year" id="year"/>
			</th>
			</tr>
	  </table>
			<table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC">
			<tr>
			<th width="18%" align="center"> Select Sub Group</th>
			<th width="82" align="left" valign="top"> <select id="dpt" name="dpt"  onChange="fillDept(this.value);">
									<option value="0" selected="selected">ALL</option>
				<?
					$sgRes=$obj->Select("subgrpmast");
						while($sgFres=$obj->fetchrow($sgRes)){
						
							print "<option value='$sgFres[0]'>$sgFres[1]</option>";
						
					  }
				?>
				</select>
			</th>
			</tr>
		  </table>
		  <table width="100%" border="0" cellpadding="3" cellspacing="0">
		  <tr>
		  <th><input type="button" name="btnAll" id="btnAll" value="Preview" onclick="goNext();">
		  </th>
		  </tr>
		  </table>
</form>
<?
//if($m>0 && $yr>0){
?>
	 <table width="100%" border="1" bordercolorlight="#CCCCCC" cellspacing="0" cellpadding="0">
	<tr height="10" style="font-family:Verdana;">
	    <th width="30" rowspan="2" align="left"><p>SL. No.</p></th>
			<th width="195" rowspan="2" align="center">NAME</th>
			<th width="57" rowspan="2" align="center">BASIC</th>
			<th width="60" rowspan="2" align="center">H.R.A</th>
			<th width="82" rowspan="2" align="center">W.A.</th>
			<th width="59" rowspan="2" align="center">Gross</th>
			<th colspan="4" align="center">Employee Deductions</th>
			<th width="85" rowspan="2" align="center">TOTAL DED.</th>
			<th colspan="2" align="center">Employer's Contribution </th>
			<th width="95" rowspan="2" align="center">CTC</th>
		   <th width="95" rowspan="2" align="center">IN HAND</th>
	   </tr>
		<tr height="30" style="font-family:Verdana; font-size:9px;">
		  <th width="84" align="center">P.TAX</th>
		  <th width="77" align="center">@<?=$configFres[4]?>% P.F.</th>
		  <th width="88" align="center">TDS</th>
		  <th width="78" align="center">@<?=$configFres[2]?>% E.S.I.</th>
		  <th width="110" align="center">@13.36% P.F.</th>
		  <th width="90" align="center">@<?=$configFres[3]?>% ESI</th>
		</tr>
	
	<? if($dept==0){
			$sgrpRes=$obj->Select("subgrpmast");
		}else{
			$sgrpRes=$obj->Select("subgrpmast", "sgID=$dept");
		}
	while($sgrpFres=$obj->fetchrow($sgrpRes)){
	$s++;
	$m=sprintf("%02d", $m);
	$totBasic=0;
		$totHra=0;
		$totWa=0;
		$totProfTax=0;
		$totEsi=0;
		$totEpf=0;
		$totPfCont=0;
		$totEsiCont=0;
		$totTds=0;
	$disRes=$obj->distinct("empmaster", "empCode", "empSubGrp=$sgrpFres[0]");
	while($disFres=$obj->fetchrow($disRes)){
		$ecode=$disFres[0];
		$basic=$eman->getEmpBasicDet($ecode, $m, $yr);
						
		$hra=$eman->getHRA($ecode, $m, $yr);
		
		
		$wa=$eman->getWA($ecode, $m, $yr);
		
		
		
		$profTax=$eman->getPtax($ecode, $m, $yr);
		
		$profTax=($profTax) ? $profTax : 0;
		
		$epfP=$eman->getPFEmpShare($ecode, $m, $yr);

		$esiP=$eman->getESIEmpShare($ecode, $m, $yr);
		
		$tdsPre=$eman->getTDS($ecode, $m, $yr);
						
		$tds=($tdsPre) ? $tdsPre : 0;
		
			
		$mnthCC=$eman->getMnthCont($ecode, $m, $yr);
		
						
		$epfFst=$mnthCC[7]+$mnthCC[8]+$mnthCC[9]+$mnthCC[10]+$mnthCC[11];
		
		$expPF=explode(".", $epfFst);
		if($expPF[1]>0){
			$epfCC=round($epfFst);
		}else{
			$epfCC=$expPF[0];
		}
		
		
		$pfCont=($epfCC) ? $epfCC : 0;
		//if ($esiFres[9] > 0){						
		$esiCont=($mnthCC[6]) ? $mnthCC[6] : 0;
		//}
		
		$totBasic=$totBasic+$basic;
		$totHra=$totHra+$hra;
		$totWa=$totWa+$wa;
		$totProfTax=$totProfTax+$profTax;
		$totEsi=$totEsi+$esiP;
		$totEpf=$totEpf+$epfP;
		$totPfCont=$totPfCont+$pfCont;
		$totEsiCont=$totEsiCont+$esiCont;
		$totTds=$totTds+$tds;
	
	}
	$totGross=$totBasic+$totHra+$totWa;
	$totDed=$totProfTax+$totEpf+$totTds+$totEsi;
	
	$totCTC=$totGross+$totPfCont+$totEsiCont;
	$totIH=$totGross-$totDed;
	
	?>
		<tr height="10" style="font-family:Verdana">
		   <th width="30"  align="left"><?=$s?></th>
			<th width="195"  align="center"><?=$sgrpFres[1]?></th>
			<th width="57"  align="center"><?=$totBasic?></th>
			<th width="60"  align="center"><?=$totHra?></th>
			<th width="82"  align="center"><?=$totWa?></th>
			<th width="59"  align="center"><?=$totGross?></th>
			<th width="84"  align="center"><?=$totProfTax?></th>
			<th width="77"  align="center"><?=$totEpf?></th>
		   <th width="88"  align="center"><?=$totTds?></th>
		  <th width="78" align="center"><?=$totEsi?></th>
		  <th width="85" align="center"><?=$totDed?></th>
		  <th width="110" align="center"><?=$totPfCont?></th>
		  <th width="90" align="center"><?=$totEsiCont?></th>
		  <th width="95" align="center"><?=$totCTC?></th>
		  <th width="95" align="center"><?=$totIH?></th>
		</tr>
	<?
		unset($totGross);
		unset($totDed);
		
		unset($totCTC);
		unset($totIH);
		}
	?>
		</table>
<?
//}
?>
</div>
</center>