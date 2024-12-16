<?
//error_reporting(E_ALL);
require ("../../config/setup.inc");



$title="TDS Master";

require($rpath."pageDesign.tmp.php");

$emp=new empManagement();


require ($root."lib/datetime/datetimepicker_css_js.php");

$ec=$_REQUEST['ec'];

$fyrChk=$obj->lastID("empsaldet", "finYear", "esID>0");

$fyr=($_REQUEST['fy']) ? $_REQUEST['fy'] : $fyrChk;


?>
<script type="text/javascript">
function getEmp(s){
	window.location="index.php?ec="+s;
}
function getInd(){
	window.location="index.php";
}
function getYr(i){
	
	
	var ec=document.getElementById('empNo').value;
	
	
	window.location="index.php?ec="+ec+"&fy="+i;
}
function subf(){
	document.form1.submit();
}
</script>
<div class="contDiv">

	<div id="heading" align="left"><h3><strong>TDS Master</strong><input type="image" align="right" border="1" src="<?= $rurl?>images/close.png" width="24" height="24" alt="Close" title="Close" style="cursor:pointer; margin:2; padding:9; border:#666666; border-style:dashed" onclick="navigate('../../index.php');" /></h3></div>
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
	
		$salRes=$obj->distinct("empsaldet", "salMonth", "empCode='$ec' and payHead='Basic' and finYear='$fyr'");
		$salRows=$obj->rows($salRes);
		
		if($salRows<12){
			$remaining=12-$salRows;
		}else{
			$remaining=0;
		}
		
		$basicRes=$obj->sumfield("empsaldet", "payAmount", "empCode='$ec' and payHead='Basic' and finYear='$fyr'");
		$hraRes=$obj->sumfield("empsaldet", "payAmount", "empCode='$ec' and payHead='House Rent Allowance' and finYear='$fyr'");
		$waRes=$obj->sumfield("empsaldet", "payAmount", "empCode='$ec' and payHead='Washinig Allowance' and finYear='$fyr'");
		
		$pfRes=$obj->sumfield("empsaldet", "payAmount", "empCode='$ec' and payHead='EPF Deduction' and finYear='$fyr'");
		$pTaxRes=$obj->sumfield("empsaldet", "payAmount", "empCode='$ec' and payHead='Professional Tax' and finYear='$fyr'");
		
		$gross=$basicRes+$hraRes+$waRes;
		
		$basicLast=$obj->lastID("empsaldet", "payAmount", "empCode='$ec' and payHead='Basic' and finYear='$fyr'");
		$hraLast=$obj->lastID("empsaldet", "payAmount", "empCode='$ec' and payHead='House Rent Allowance' and finYear='$fyr'");
		$waLast=$obj->lastID("empsaldet", "payAmount", "empCode='$ec' and payHead='Washinig Allowance' and finYear='$fyr'");
		$pfLast=$obj->lastID("empsaldet", "payAmount", "empCode='$ec' and payHead='EPF Deduction' and finYear='$fyr'");
		$pTaxLast=$obj->lastID("empsaldet", "payAmount", "empCode='$ec' and payHead='Professional Tax' and finYear='$fyr'");
		
		
		$basicRemaining=$basicLast*$remaining;
		$hraRemaining=$hraLast*$remaining;
		$waRemaining=$waLast*$remaining;
		
		$pfRemaining=$pfLast*$remaining;
		$pTaxRemaining=$pTaxLast*$remaining;
		
		$grossR=$basicRemaining+$hraRemaining+$waRemaining;
		
		$totGross=$gross+$grossR;
		
		$totPF=$pfRemaining+$pfRes;
		$totPtax=$pTaxRes+$pTaxRemaining;
		
		 $deptRes=$obj->select("deptmanager", "deptID=$fres[12]");
	  	 $deptFres=$obj->fetchrow($deptRes);
		 
		 $desigRes=$obj->select("desigmast", "dsgID=$fres[11]");
		 $desigFres=$obj->fetchrow($desigRes);
		 
		 $tdsMstRes=$obj->select("tdsmaster", "slabHigh >='$totGross' and slabLow <='$totGross'");
		 $tdsMstFres=$obj->fetchrow($tdsMstRes);
?>
	<table width="61%" border="1" cellpadding="2" cellspacing="0" align="center">
	<input type="image" align="right" border="1" src="<?= $rurl?>images/close.png" width="24" height="24" alt="Close" title="Close" style="cursor:pointer; margin:2; padding:9; border:#666666; border-style:dashed" onclick="getInd();" />
		<form name="form1" method="post" action="addBack.php" >
		<tr style="border:hidden">
			<td colspan="2" style="border:hidden"><div class="divCell" style="width:50%"><strong>Select Financial year</strong></div><div class="divCell">
                        <select id="fy" name="fy" onchange="getYr(this.value);">
                           <?
                                $disRes=$obj->distinct("empsaldet", "finYear", "empCode>0");
                                $disRow=$obj->rows($disRes);

                                while($disFres=$obj->fetchrow($disRes)){
								
								if($disFres[0]==$fyr){
									print "<option value='$disFres[0]' selected>$disFres[0]</option>";
								}else{
                                    print "<option value='$disFres[0]'>$disFres[0]</option>";
								}
                                }
                            ?>
                        </select></div></td>
			<td colspan="2" style="border:hidden" align="right"></td>
		</tr>
	  <tr style="border:hidden">
		<td width="218" height="25" align="right"><strong>Employee Name :</strong> </td>
		<td width="167" align="center"><?=$fres[3]?></td>
		<td width="186" align="right"><strong>Department:</strong> </td>
		<td width="196" align="center"><?=$deptFres[1]?></td>
	  </tr>
	  <tr style="border:hidden">
		<td height="33" align="right"><strong>Total Gross Amount :</strong></td>
		<td align="center"><?=$totGross?><input type="hidden" name="totGrs" id="totGrs" value="<?=$totGross?>" /></td>
		<td align="right"><strong>TDS percentage:</strong></td>
		<td align="center"><?=$tdsMstFres[3]?>%<input type="hidden" name="prt" id="prt" value="<?=$tdsMstFres[3]?>" /></td>
	  </tr>
	  <tr style="border:hidden">
	    <td align="right"><strong>PF Deduction</strong>: </td>
	    <td><input name="pf" id="pf" align="middle" value="<?=$totPF?>" /></td>
	    <td align="right"><strong>Proffesional Tax</strong>: </td>
	    <td><input name="ptax" id="ptax" align="middle" value="<?=$totPtax?>" /></td>
	    </tr>
	  <tr style="border:hidden">
		<td align="right"><strong>Total Medical Expencess:</strong></td>
		<td><input type="text" id="mAmnt" name="mAmnt" /></td>
		<td align="right"><strong>Total Insurence Amount: </strong></td>
		<td><input type="text" id="insure" name="insure" /></td>
	  </tr>
	  <tr style="border:hidden">
		<td align="right"><strong>Total Investment Amount: </strong></td>
		<td><input type="text" id="invst" name="invst" /></td>
		<td align="right"><strong>Others:</strong></td>
		<td><input type="text" id="misc" name="misc" /></td>
	  </tr>
	  <tr style="border:hidden">
	    <td align="center"><strong>TDS Amount Yearly</strong> </td>
        <td align="left"><input type="text" name="ytds" id="ytds" /></td>
        <td align="center"><strong>TDS Ammount Monthly</strong> </td>
        <td align="left"><input type="text" name="mtds" id="mtds" /></td>
	  </tr>
	  <tr style="border:hidden">
	  	<td colspan="4" align="center"><input type="hidden" name="empNo" id="empNo" value="<?=$fres[2]?>" /><input type="button" onclick="subf();" id="sub" name="sub" value="Save" /></td>
	  </tr>
	  </form>
	</table>

<? 
	$shRes=$obj->select("advancetrans", "empNo='$ec' and transTyp=2 and endFlg=1");
	$shRows=$obj->rows($shRes);
	if($shRows>0){
	
		$shFres=$obj->fetchrow($shRes);
		$repaid=$obj->sumfield("advancetrans", "amount", "empNo='$ec' and transTyp=2 and advID>'$shFres[0]'");
		
		$repaid=($repaid) ? $repaid : 0;
		
		$balance=$shFres[4]-$repaid;
?>
<div id="gap" align="center" style=" background:#FFFFFF; display:block"><h4>Previous Advance Details</h4></div>
<table width="50%" border="1" align="center" cellpadding="3" cellspacing="0" bordercolor="#000000">
  <tr>
    <td><strong>Name</strong></td>
    <td><strong>Date</strong></td>
    <td><strong>Amount Given</strong></td>
    <td><strong>Amount Repaid</strong></td>
	<td><strong>Balance</strong></td>
  </tr>
  <tr>
    <td><?=$fres[3]?></td>
    <td><?=$shFres[3]?></td>
    <td><?=$shFres[4]?></td>
    <td><?=$repaid?></td>
	<td><?=$balance?></td>
  </tr>
</table>

<? 
	}
} ?>
</div>