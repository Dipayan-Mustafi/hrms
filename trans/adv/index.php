<?
//error_reporting(E_ALL);
require ("../../config/setup.inc");



$title="Advance Register";

require($rpath."pageDesign.tmp.php");

$emp=new empManagement();


require ($root."lib/datetime/datetimepicker_css_js.php");

$ec=$_REQUEST['ec'];

?>
<script type="text/javascript">
function getEmp(s){
	window.location="index.php?ec="+s;
}
</script>
<div class="contDiv">

	<div id="heading" align="left"><h3>Advance Register<input type="image" align="right" border="1" src="<?= $rurl?>images/close.png" width="24" height="24" alt="Close" title="Close" style="cursor:pointer; margin:2; padding:9; border:#666666; border-style:dashed" onclick="navigate('../../index.php');" /></h3></div>
<div class="displayBox" style="width:35%; height:400px; overflow:auto;">
  <table width="100%" border="0">
    <tr style="border-bottom:thick">
      <td width="115" style="border-bottom:solid 1px #333333;"><strong>Employee Number </strong></td>
      <td width="314" style="border-bottom:solid 1px #333333;"><strong>Eployee Name</strong> </td>
    </tr>
	<? if($ec){
			$empRes=$obj->select("empmaster","empCode='$ec'");
		}else{
			$empRes=$obj->select("empmaster order by empName");
		}
		while($empFres=$obj->fetchrow($empRes)){
	?>
    <tr onclick="getEmp(<?=$empFres[2]?>);" style="cursor:pointer">
      <td style="border-bottom:solid 1px #333333;"><?=$empFres[2]?></td>
      <td style="border-bottom:solid 1px #333333;"><?=$empFres[3]?></td>
    </tr>
	<?
	}?>
  </table>
</div>
<? if($ec){
	$res=$obj->select("empmaster", "empCode='$ec'");
	$fres=$obj->fetchrow($res);
?>
<div class="displayBox" style="width:58%; overflow:auto;">
<div class="divLine"><strong>ADVANCE TRANSACTION</strong><input type="image" align="right" border="1" src="<?= $rurl?>images/close.png" width="16" height="16" alt="Close" title="Close" style="cursor:pointer; margin:2; padding:9; border:#666666; border-style:dashed" onclick="navigate('index.php');" /></div>
	<table width="100%" border="0" align="center" style=" background-color:#BEBEBE">
	<form name="form1" method="post" action="addBack.php" >
	  <tr>
		<td width="178" height="39" align="right" style="border-bottom:1px dotted"><strong>Employee Name :</strong> </td>
		<td width="188" align="center" style="border-right:1px solid; border-bottom:1px dotted"><?=$fres[3]?></td>
		<td width="116" align="right" style="border-bottom:1px dotted"><strong>Basic Rate :</strong> </td>
		<td width="150" align="center" style="border-bottom:1px dotted"><?=$fres[35]?></td>
	  </tr>
	  <? $deptRes=$obj->select("deptmanager", "deptID=$fres[12]");
	  	 $deptFres=$obj->fetchrow($deptRes);
		 
		 $desigRes=$obj->select("desigmast", "dsgID=$fres[11]");
		 $desigFres=$obj->fetchrow($desigRes);
	  ?>
	  <tr>
		<td height="33" align="right" style="border-bottom:1px dotted"><strong>Department :</strong></td>
		<td align="center" style="border-right:1px solid; border-bottom:1px dotted"><?=$deptFres[1]?></td>
		<td align="right" style="border-bottom:1px dotted"><strong>Designation :</strong></td>
		<td align="center" style="border-bottom:1px dotted"><?=$desigFres[1]?></td>
	  </tr>
	  <tr>
		<td align="right" style="border-bottom:1px dotted"><strong>Amount of Advance :</strong></td>
		<td style="border-right:1px solid; border-bottom:1px dotted"><input type="text" id="amnt" name="amnt" /></td>
		<td align="right" style="border-bottom:1px dotted"><strong>Date :</strong></td>
		<td style="border-bottom:1px dotted"><input type="date" id="dt" name="dt" /></td>
	  </tr>
	  <tr>
		<td align="right" style="border-bottom:1px dotted"><strong>Installment Amount :</strong></td>
		<td style="border-right:1px solid; border-bottom:1px dotted"><input type="text" id="inst" name="inst" /></td>
		<td style="border-bottom:1px dotted">&nbsp;</td>
		<td style="border-bottom:1px dotted">&nbsp;</td>
	  </tr>
	  <tr>
	  	<td colspan="4" align="center"><input type="hidden" name="empNo" id="empNo" value="<?=$fres[2]?>" /><input type="submit" id="sub" value="Save" /></td>
	  </tr>
	</form>
	</table>
<?
$shRes=$obj->select("advancetrans", "empNo='$ec' order by transDate");
$shRows=$obj->rows($shRes);
if($shRows>0){
?>
<div id="gap" align="center" style=" background:#FFFFFF; display:block"><h4>Previous Advance Details</h4></div>
<table width="100%" border="1" align="center" cellpadding="3" cellspacing="0" bordercolor="#000000">
  <tr>
    <td><strong>Name</strong></td>
    <td><strong>Date</strong></td>
    <td><strong>Amount Given</strong></td>
    <td><strong>Amount Repaid</strong></td>
  </tr>
<? 
while($shFres=$obj->fetchrow($shRes)){
	
		$mem=$emp->getEmpDet($ec);
		if($shFres[2]==1){
			$paid=0;
			$recived=$shFres[4];
		}else{
			$paid=$shFres[4];
			$recived=0;
		}
?>
  <tr>
    <td><?=$mem[3]?></td>
    <td><?=$misc->dateformat($shFres[3]);?></td>
    <td><?=$paid?></td>
    <td><?=$recived?></td>
  </tr>
<?
 }
?>
</table>
</div>
<? 
	}	
} ?>
</div>