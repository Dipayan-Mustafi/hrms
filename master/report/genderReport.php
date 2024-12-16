<?
//error_reporting(E_ALL);
require ("../../config/setup.inc");

//require ($root."lib/hr/empManagement.php");
require ($root."lib/datetime/datetimepicker_css_js.php");

$title="Employee Report";

require($rpath."pageDesign.tmp.php");

$eman=new empManagement();


$endyr=date('Y');
$styr=$endyr -3;


$cdt=date('y-m-d');

$expdYr=explode("-",$cdt);

$yr=$yrd;
$prvYr=$yr-1;

$gen=$_REQUEST['gen'];
$fdt=$_REQUEST['fdt'];
$tdt=$_REQUEST['tdt'];




?>
<script type="text/javascript">

</script>
<style type="text/css">
.listTD{

	background-color:#FFFFFF;
	

}
.listTD:hover{
	background-color:#666666;
	color:#FFFFFF;
	display:block;
}

</style>

<div class="contDiv">
	<div id="heading" style="height:50px"><h4>Employee Report<input type="image" align="right" border="1" src="<?= $rurl?>images/close.png" width="24" height="24" alt="Close" title="Close" style="cursor:pointer; margin:2; padding:9; border:#666666; border-style:dashed" onclick="navigate('../../index.php');" /></h4></div>
	<div class="divLine">
	<form name="form1" action="genderReport.php" method="post">
	<div class="divCell" style="width:50%" align="right"><strong>Select Gender:</strong></div>
	<div class="divCell" style="width:50%" align="left"><select name="gen" id="gen"> 
		  <?
		  
		  $countSXT=count($sxTyp);
		  
		  
		  for ($i=1; $i < $countSXT; $i++){
		  	if ($i==$gen){
				print "<option value='$i' selected>$sxTyp[$i]</option>";
			}else{
				print "<option value='$i'>$sxTyp[$i]</option>";
			}
		  }
		  ?>
	  </select></div>
	</div>
	<div class="divLine">
		<div class="divCell" style="width:15%; vertical-align:middle" align="center"><strong>From:</strong></div>
		<div class="divCell" style="width:25%;"><input name="fdt" type="text" id="fdt" onFocus="javascript:NewCssCal('fdt','yyyyMMdd','','','','');" onClick="javascript:NewCssCal('fdt','yyyyMMdd','','','','');" value="<?php echo $fdt?>" size="15" readonly="true"/></div>
		<div class="divCell" style="width:15%; vertical-align:bottom" align="center"><strong>To:</strong></div>
		<div class="divCell" style="width:25%"><input name="tdt" type="text" id="tdt" onFocus="javascript:NewCssCal('tdt','yyyyMMdd','','','','');" onClick="javascript:NewCssCal('tdt','yyyyMMdd','','','','');" value="<?php echo $tdt?>" size="15" readonly="true"/></div>
	</div>
	<div class="divLine">
		<div class="divCell" style="width:100%" align="center"><input type="submit" name="bshow" value="Show" /></div>
	</div>
	</form>
	<div class="divLine" style="height:30px">&nbsp;</div>
<?
	if($gen){
?>
	<div class="divLine">
	  <table width="100%" border="1" cellpadding="2" cellspacing="0" style="font:Arial, Helvetica, sans-serif; font-size:12px">
	  <tr>
		<td width="7%" align="center"><strong>Sl No.</strong></td>
		<td width="17%" align="center"><strong>Employee Number</strong></td>
		<td width="22%" align="center"><strong>Employee Name</strong></td>
		<td width="21%" align="center"><strong>Department</strong></td>
		<td width="17%" align="center"><strong>In Hand</strong> </td>
		<td width="16%" align="center"><strong>CTC</strong></td>
	  </tr>
<?
	$empRes=$obj->select("empmaster", "empSex=$gen and (modDate>'$fdt' or modDate='0000-00-00') order by empDept");
	while($empFres=$obj->fetchrow($empRes)){
	
		if($empFres[40]<='$tdt' || $empFres[40]='0000-00-00')
		$s++;
		
		$deptRes=$obj->select("deptmanager", "deptID=$empFres[12]");
		$deptFres=$obj->fetchrow($deptRes);
		
		
		$basic=$eman->getEmpBasicTot($empFres[2], $fdt, $tdt);		
		$emppf=$eman->getPFEmpShareTot($empFres[2], $fdt, $tdt);
		$empesiRes=$eman->getESIEmpShareTot($empFres[2], $fdt, $tdt);
		$wa=$eman->getWATot($empFres[2], $fdt, $tdt);
		$hra=$eman->getHRATot($empFres[2], $fdt, $tdt);
		$pTaxRes=$eman->getPtaxTot($empFres[2], $fdt, $tdt);
		$tdsRes=$eman->getTdsTot($empFres[2], $fdt, $tdt);
		$advRes=$eman->getAdvTot($empFres[2], $fdt, $tdt);
		
		$gross=$basic+$wa+$hra;
		$inHand=$gross-$emppf-$empesiRes-$pTaxRes-$tdsRes-$advRes;
		
		$epfCCal=$eman->getEpfContTot($empFres[2], $fdt, $tdt);
		$epfCC=($epfCCal) ? $epfCCal:0;
		
		$esiCCal=$eman->getEsiContTot($empFres[2], $fdt, $tdt);
		$esiCC=($esiCCal) ? $esiCCal:0;
		
		$ctc=$gross+$epfCC+$esiCC;
?>
	  <tr>
		<td align="center"><?=$s?></td>
		<td align="center"><?=$empFres[2]?></td>
		<td><?=$empFres[3]?></td>
		<td align="center"><?=$deptFres[1]?></td>
		<td align="center"><?=round($inHand)?></td>
		<td align="center"><?=round($ctc)?></td>
	  </tr>
<?
	}
?>
	</table>
	</div>
<?
}
?>

</div>
    	