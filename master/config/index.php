<?
require ("../../config/setup.inc");



$title="Allowance and Deduction Section";

require($rpath."pageDesign.tmp.php");

$emp=new empManagement();

$et=($_REQUEST['et']) ? $_REQUEST['et'] : 1;
$pt=($_REQUEST['pt']) ? $_REQUEST['pt'] : 1;
$sxt=($_REQUEST['sxt']) ? $_REQUEST['sxt'] : 1;
$id=($_REQUEST['id']) ? $_REQUEST['id'] : 1;

require ($root."lib/datetime/datetimepicker_css_js.php");





	$res=$obj->select("salconfig");
	$fres=$obj->fetchrow($res);
	$basic=$fres[1];
	$esi=$fres[2];
	$cesi=$fres[3];
	$pf=$fres[4];
	$cpf=$fres[5];
	$pfa=$fres[6];
	$eps=$fres[7];
	$eplmt=$fres[8];
	$edls=$fres[9];
	$edlsa=$fres[10];




?>
<script type="text/javascript">

function getRef(i){
	
	window.location="index?id="+i;
}
function update(){

	document.form2.submit();

}
function tdsBack(s){

	var fromc="tform"+s;
	var toc="tto"+s;
	var ptc="tds"+s;
	var tIDc="tID"+s;
	
	
	
	var f=document.getElementById(fromc).value;
	var to=document.getElementById(toc).value;
	var pt=document.getElementById(ptc).value;
	var tID=document.getElementById(tIDc).value;
	
	window.location="tdsBack?from="+f+"&to="+to+"&pt="+pt+"&ptid="+tID;
	
}
function ptBack(s){

	var fromc="pform"+s;
	var toc="pto"+s;
	var ptc="pt"+s;
	var tIDc="ptID"+s;
	
	
	
	var f=document.getElementById(fromc).value;
	var to=document.getElementById(toc).value;
	var pt=document.getElementById(ptc).value;
	var tID=document.getElementById(tIDc).value;
	
	window.location="ptaxBack?from="+f+"&to="+to+"&pt="+pt+"&ptid="+tID;
	
}
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

	<div class="displayBox" style="width:68%;">
    	<h2>Configuration</h2>
      <div class="listDiv">
        	
			
			  <table width="100%" border="0" cellspacing="0" cellpadding="3">
			  <form name="form1" method="post" action="addBack">
                 <?
				 if($id==1){
				 ?> 
					  <tr>
						<td colspan="4">ESI Limit </td>
						<td colspan="3">Rs. 
						  <input name="basic" type="text" id="basic" size="10" value="<?= $basic?>" /></td>
					  </tr>
					  <tr>
						<td colspan="4">ESI for Employee </td>
						<td colspan="3"><input name="esi" type="text" id="esi" size="10" value="<?= $esi?>" /> 
						% </td>
					  </tr>
					  <tr>
						<td colspan="4">ESI Emp. Contribution </td>
						<td colspan="3"><input name="cesi" type="text" id="cesi" size="10" value="<?= $cesi?>" /> 
						  % </td>
					  </tr>
				  <?
				  }else if($id==2){
				  ?>
					  <tr>
						<td colspan="4">PF Deduction </td>
						<td colspan="3"><input name="pf" type="text" id="pf" size="10" value="<?= $pf?>" />
	% </td>
					  </tr>
					  <tr>
						<td colspan="4">PF Emp. Contribution </td>
						<td colspan="3"><input name="cpf" type="text" id="cpf" size="10" value="<?= $cpf?>" />
						  % </td>
					  </tr>
					  <tr>
						<td colspan="4">PF Admin </td>
						<td colspan="3"><input name="pfa" type="text" id="pfa" size="10" value="<?= $pfa?>" />
						  % </td>
					  </tr>
				  <?
				  }else if($id==3){
				  ?>
					  <tr>
						<td colspan="4">EPS</td>
						<td colspan="3"><input name="eps" type="text" id="eps" size="10" value="<?= $eps?>" />
						  % </td>
					  </tr>
					  <tr>
						<td colspan="4">EPS Limit</td>
						<td colspan="3">Rs. 
						  <input name="eplmt" type="text" id="eplmt" size="10" value="<?= $eplmt?>" /></td>
					  </tr>
				  <?
				  }else if($id==4){
				  ?>
					  <tr>
						<td colspan="4">EDLS</td>
						<td colspan="3"><input name="edls" type="text" id="edls" size="10" value="<?= $edls?>" />
						  % </td>
					  </tr>
					  <tr>
						<td colspan="4">EDLS Admin </td>
						<td colspan="3"><input name="edlsa" type="text" id="edlsa" size="10" value="<?= $edlsa?>" />
						  % </td>
					  </tr>
				  <?
				  }else if($id==5){
				  
				  	$ptRes=$obj->select("ptmaster order by slabLow");
					while($ptFres=$obj->fetchrow($ptRes)){
				  		$s++;
				  ?>
				  		<tr>
							<td>From</td>
							<td><input type="text" name="pfrom[]" id="pform<?=$s?>" value="<?=$ptFres[1]?>" /></td>
							<td>Up to</td>
							<td><input type="text" name="pto[]" id="pto<?=$s?>" value="<?=$ptFres[2]?>" /></td>
							<td>Tax Amount</td>
							<td><input type="text" name="pt[]" id="pt<?=$s?>" value="<?=$ptFres[3]?>" /></td>
							<td><input type="hidden" name="ptID[]" id="ptID<?=$s?>" value="<?=$ptFres[0]?>" /><input type="button" name="ptChange[]" id="ptChange<?=$s?>" value="Change" onclick="ptBack(<?=$s?>);" /></td>
						</tr>
				<?
					}
				?>
						<tr>
							<td>From</td>
							<td><input type="text" name="spt" id="spt" value="" /></td>
							<td>Up to</td>
							<td><input type="text" name="tpt" id="tpt" value="" /></td>
							<td>Tax Amount</td>
							<td><input type="text" name="ptamnt" id="ptamnt" value="" /></td>
							<td>&nbsp;</td>
						</tr>
				  <?
				  }else if($id==6){
				  
				  	$tdsRes=$obj->select("tdsmaster order by slabLow");
					while($tdsFres=$obj->fetchrow($tdsRes)){
					
						$d++;
				  ?>
				  		<tr>
							<td>From</td>
							<td><input type="text" name="tfrom[]" id="tform<?= $d?>" value="<?=$tdsFres[1]?>" /></td>
							<td>Up to</td>
							<td><input type="text" name="tto[]" id="tto<?= $d?>" value="<?=$tdsFres[2]?>" /></td>
							<td>Parcentage</td>
							<td><input type="text" name="tds[]" id="tds<?= $d?>" value="<?=$tdsFres[3]?>" /></td>
							<td><input type="hidden" name="tID[]" id="tID<?= $d?>" value="<?=$tdsFres[0]?>" /><input type="button" name="tdChange[]" id="tdChange<?=$d?>" value="Change" onclick="tdsBack(<?= $d ?>);" /></td>
						</tr>
					
				<?
					}
				?>
						<tr>
							<td>From</td>
							<td><input type="text" name="spt" id="spt" value="" /></td>
							<td>Up to</td>
							<td><input type="text" name="tpt" id="tpt" value="" /></td>
							<td>Percentage</td>
							<td><input type="text" name="ptamnt" id="ptamnt" value="" /></td>
							<td>&nbsp;</td>
						</tr>
				  <?
				  }else if($id==7){
				  ?>
					<tr>
						<td colspan="1" style="border-top:1px solid; border-bottom:1px solid; border-left:1px solid">Sub group ID</td>
						<td colspan="6" style="border-top:1px solid; border-bottom:1px solid; border-right:1px solid">Group Name</td>
					</tr>
					<?
						$sgRes=$obj->Select("subgrpmast");
						while($sgFres=$obj->fetchrow($sgRes)){
					?>
				  	<tr>
						<td colspan="1" style="border-left:1px solid; border-right:1px solid; border-bottom:1px solid"><?=$sgFres[0]?></td>
						<td colspan="6" style=" border-right:1px solid; border-bottom:1px solid"><?=$sgFres[1]?></td>
					</tr>
				  <?
				  	}
				?>
					<tr>
						<td colspan="4">Enter New Sub Group</td>
						<td colspan="3"><input type="text" name="sgrp" id="sgrp" value="" /></td>
					</tr>
				<?
				  }
				  ?>
				  <tr>
                    <td colspan="4">&nbsp;</td>
                    <td colspan="3"><input type="hidden" name="id" value="<?= $id?>" id="id" />
                      <input name="bSav" align="middle" type="submit"  id="bSav" value="Submit" /></td>
				  </tr>
            </form>
	    </table>
			
        </div>
    </div>
	 <div class="displayBox" style="width:25%; height:400px; overflow:auto;">
    	<h2>Salary Configurations </h2>
        <div class="listDiv">
			<table border="0" cellpadding="3" width="100%">
			
			<?
			$c=count($configType);
			for($i=1; $i<$c; $i++){
					//$attr=($fres[5]==1) ? "Allowance" : "Deductions";
				?>
				<tr>
				
					<td class="listTD" style="cursor:pointer; border-bottom:solid 1px #333333;" onclick="getRef(<?= $i?>)"><?= $configType[$i]?></td>
				</tr>
				<?
			}
			?>
			</table>	
        </div>
</div>
