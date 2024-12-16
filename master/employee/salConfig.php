<?
//error_reporting(E_ALL);
require ("../../config/setup.inc");



$title="Employee Section";

require($rpath."pageDesign.tmp.php");

$emp=new empManagement();

$et=($_REQUEST['et']) ? $_REQUEST['et'] : 1;
$pt=($_REQUEST['pt']) ? $_REQUEST['pt'] : 1;
$sxt=($_REQUEST['sxt']) ? $_REQUEST['sxt'] : 1;

$id=($_REQUEST['id']) ? $_REQUEST['id'] : 0;

require ($root."lib/datetime/datetimepicker_css_js.php");



	$mstRes=$obj->select("empmaster", "empID=$id");
	
	$mstFres=$obj->fetchrow($mstRes);
	
	

	

$empCode=$mstFres[2];

$chkRes=$obj->select("empallowance", "empCode='$empCode'");
$chkRows=$obj->rows($chkRes);


?>
<script type="text/javascript">

function fillText(){
	
	var saa=document.getElementById('saa');
	var addr=document.getElementById('addr').value;
	var city=document.getElementById('city').value;
	var est=document.getElementById('estat').value;
	var pin=document.getElementById('pin').value;
	var cnt=document.getElementById('cntry').value;
	
	var paddr=document.getElementById('paddr');
	var pcity=document.getElementById('pcity');
	var pest=document.getElementById('pestat');
	var ppin=document.getElementById('ppin');
	var pcnt=document.getElementById('pcntry');
	
	
	if (saa.checked==true){
		
		paddr.value=addr;
		pcity.value=city;
		pest.value=est;
		ppin.value=pin;
		pcnt.value=cnt;
	
	}else{
		paddr.value="";
		pcity.value="";
		pest.value="";
		ppin.value="";
		pcnt.value="";
	
	}

}
function getRef(i){
	
	window.location="index";
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
			<div style="float:right; width:25%;"><input type="button" value="Back" onclick="getRef(0);" /></div>
	<form name="form1" method="post" action="setBack">
			<h2 style="font-family:arial; font-size:13pt; background-color:#AEAEAE; padding:1%;">Salary settings of <?= $mstFres[3]?></h2>
			<table width="70%" border="0" cellspacing="0" cellpadding="3">
			  <tr>
				<th width="7%" align="center" valign="top">Sl No. <input name="rid" type="hidden" value="<?= $id?>"></th>
				<th width="38%" align="center" valign="top">Allowance / Deductions</th>
				<th width="18%" align="center" valign="top">Category</th>
				<th width="19%" align="center" valign="top">Type</th>
				<th width="18%" align="center" valign="top">Amount</th>
			  </tr>
			  <?
			  $adRes=$obj->Select("allowancemaster order by effTyp,aTyp,name");
			  while ($adFres=$obj->fetchrow($adRes)){
			  	$r++;
				$eaRes=$obj->select("empallowance", "empCode='$empCode' and alwID=$adFres[0]");
				
				$eaFres=$obj->fetchrow($eaRes);
				
				$eaid=($eaFres[2]) ? $eaFres[2] : 0;
				if ($chkRows > 0){
					$amnt=(floatval($eaFres[3])>0) ? $eaFres[3] : 0;
				}else{
					$amnt=$adFres[2];
				}
				
				$t=($eaFres[4]) ? $eaFres[4] : $adFres[3];
				$u=($adFres[4]==2) ? "Daily" : "Monthly";
			  	$e=($adFres[5]==1) ? "Allowances" : "Deductions";
				
			  ?>
			  <tr>
				<td align="center" valign="top"><?= $r;?><input name="adID[]" type="hidden" value="<?= $adFres[0]?>"><input name="eaid[]" type="hidden" value="<?= $eaid?>" /> </td>
				<td align="left" valign="top"><?= $adFres[1]?> [<?= $u?>]</td>
				<td align="center" valign="top"><?= $e?></td>
				<td align="center" valign="top">
				<select name="rtyp[]" id="rtyp">
						<?
					  $countSal=count($salRTyp);
					  for ($i=1; $i<$countSal; $i++){
					  
					  	if ($i==$t){
							print "<option value='$i' selected>$salRTyp[$i]</option>";
						}else{
							print "<option value='$i'>$salRTyp[$i]</option>";
						}
					  }
					  
					  ?>
							</select>
				</td>
				<td align="center" valign="top"><input name="amnt[]" type="text" size="5" value="<?= sprintf("%0.2f", $amnt);?>"></td>
			  </tr>
			
			  <?
			  }
			  
			  ?>
			    <tr>
			    <td align="center" valign="top">&nbsp;</td>
			    <td align="left" valign="top">&nbsp;</td>
			    <td align="center" valign="top">&nbsp;</td>
			    <td align="center" valign="top">&nbsp;</td>
			    <td align="center" valign="top"><input name="bsav" type="submit" id="bsav" value="Save"></td>
		      </tr>
		  </table>

  </form>


</div>