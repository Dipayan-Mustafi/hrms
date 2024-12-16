<?
//error_reporting(E_ALL);
require ("../../config/setup.inc");



$title="Employee Nominee Details";

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

function chngTyp(r){
	window.open("upTyp?id="+r, "Update Type", "height=1, width=1, top=1, left=1");
}
function GoUp(r){
	window.open("up?id="+r, "Update Type", "height=800, width=1200, top=10, left=1");
}
function del(r){
	var ans=confirm("Do You Want To Delete this Family Member/ Nominee");
	if (ans==true){
		window.open("del?id="+r, "Update Type", "height=1, width=1, top=1, left=1");
	}
	
}
</script>
<div class="contDiv">

	<div id="heading" align="left">
	  <h3><strong>Employee Nominee Details </strong>
	    <input type="image" align="right" border="1" src="<?= $rurl?>images/close.png" width="24" height="24" alt="Close" title="Close" style="cursor:pointer; margin:2; padding:9; border:#666666; border-style:dashed" onclick="navigate('../../index.php');" /></h3></div>
<div class="displayBox" style="width:25%; height:400px; overflow:auto;">
  <table width="90%" align="center" border="0">
    <tr style="border-bottom:thick">
      <td width="96" style="border-bottom:solid 1px #333333;"><strong>Employee Number </strong></td>
      <td width="222" style="border-bottom:solid 1px #333333;"><strong>Eployee Name</strong> </td>
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
	
	$deptRes=$obj->select("deptmanager", "deptID='$fres[12]'");
	$deptFres=$obj->fetchrow($deptRes);
	
		
?>
	<input type="image" align="right" border="1" src="<?= $rurl?>images/close.png" width="24" height="24" alt="Close" title="Close" style="cursor:pointer; margin:2; padding:9; border:#666666; border-style:dashed" onclick="getInd();" />
		<form name="form1" method="post" action="addBack.php" >
	<table width="70%" border="1" bordercolor="#BFBFBF" cellpadding="3" cellspacing="0" align="center">
	  <tr style="border:hidden">
	    <td colspan="2" align="center" style="border:hidden"><strong>Employee Name:</strong></td>
	    <td width="23%" align="left" style="border:hidden"><?=$fres[3]?></td>
	    <td width="23%" align="center" style="border:hidden"><strong>Department:</strong></td>
	    <td width="30%" align="left" style="border:hidden"><?=$deptFres[1]?></td>
	  </tr>
		</table>
	<div id="divLine" style="height:15px;">&nbsp;</div>	
	  <table width="70%" border="1" bordercolor="#BFBFBF" cellpadding="3" cellspacing="0" align="center">
	  <tr style="border:hidden">
	    <td width="27%" align="center" colspan="2"><strong> Name</strong> </td>
	    <td width="13%" align="center"><strong>Date of Birth</strong> </td>
	    <td width="13%" align="center"><strong>Realation</strong></td>
	    <td width="30%" align="center"><strong>Address</strong></td>
	    <td width="13%" align="center"><strong>Percentage</strong></td>
		<td width="13%" align="center"><strong>Type</strong></td>
	  </tr>
	  <?
	  $nmRes=$obj->select("empnominee", "empCode='$fres[2]'");
	  $nmRows=$obj->rows($nmRes);
	  if($nmRows>0){
			while($nmFres=$obj->fetchrow($nmRes)){
	  ?>
			  <tr style="border:hidden">
			  	<td align="center" ><input type="image" src="<?= $rurl?>images/close.png" width="8" height="8" alt="delete" title="Delete" style="cursor:pointer;" onclick="del(<?=$nmFres[0]?>)" /></td>
				<td align="left" style="cursor:pointer;" onclick="GoUp(<?=$nmFres[0]?>);"><?= $nmFres[2]?></td>
				<td align="center" ><?= $misc->dateformat($nmFres[5]);?></td>
				<td align="center" ><?= $nmFres[3]?></td>
				<td align="left" ><?= $nmFres[6]?></td>
				<td align="center" ><?= $nmFres[4]?>%</td>
				<td align="center" >
					<select name="mtyp" onchange="chngTyp(<?=$nmFres[0]?>);">
						<?
						$c=count($nmTypArray);
						for($i=1; $i<$c; $i++){
							if($i==$nmFres[7]){
								print "<option value='$i' selected='selected'> $nmTypArray[$i]</option> ";
							}else{
								print "<option value='$i'> $nmTypArray[$i]</option>";
							}
						}
						?>
					</select>
				</td>
			  </tr>
	  <?
	  		}
	  }
	  ?>
	  <tr style="border:hidden">
	  	
	    <td colspan="7" align="center" valign="top" style="border:hidden">&nbsp;</td>
	    </tr>
	  <tr style="border:hidden">
	  	<td align="center" style="border:hidden" >&nbsp;</td>
	    <td align="center" style="border:hidden" valign="top"><input type="text" id="nmName" name="nmName" style="width:95%; size:20"/></td>
	    <td align="center" style="border:hidden" valign="top"><input name="dob" type="text" id="dob" size="15" value="<?php echo $prvDate?>" onClick="javascript:NewCssCal('dob','yyyyMMdd','','','','','past');" onFocus="javascript:NewCssCal('dob','yyyyMMdd','','','','','past');" readonly="true"/></td>
	    <td align="center" style="border:hidden" valign="top"><input type="text" id="nmRel" name="nmRel" /></td>
	    <td align="center" style="border:hidden" valign="top"><textarea rows="4" style="size:150; width:95%;"  id="adrs" name="adrs"> </textarea></td>
	    <td align="center" style="border:hidden" valign="top"><input type="text" id="prcnt" name="prcnt" style="width:95%;" maxlength="3" /></td>
	  	<td align="center" style="border:hidden" valign="top">
			<select name="nmtyp">
				<?
				$c=count($nmTypArray);
				for($i=1; $i<$c; $i++){
					
						print "<option value='$i'> $nmTypArray[$i]</option>";
				}
				?>
			</select>
		</td>
	  </tr>
	  <tr style="border:hidden">
	  	<td colspan="6" align="center" style="border:hidden"><input type="hidden" name="empNo" id="empNo" value="<?=$fres[2]?>" /><input type="button" onclick="subf();" id="sub" name="sub" value="Add" /></td>
	  </tr>
	  </table>
	  </form>
	

<? 

} ?>
</div>