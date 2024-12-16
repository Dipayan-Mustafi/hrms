<?
//error_reporting(E_ALL);
require ("../../config/setup.inc");



$title="Employee Leave Section";

require($rpath."pageDesign.tmp.php");

$emp=new empManagement();

$et=($_REQUEST['et']) ? $_REQUEST['et'] : 1;
$pt=($_REQUEST['pt']) ? $_REQUEST['pt'] : 1;
$sxt=($_REQUEST['sxt']) ? $_REQUEST['sxt'] : 1;

$id=($_REQUEST['id']) ? $_REQUEST['id'] : 0;

$yr=date('Y');


require ($root."lib/datetime/datetimepicker_css_js.php");



	$mstRes=$obj->select("empmaster", "empID=$id");
	
	$mstFres=$obj->fetchrow($mstRes);
	
	

	

$empCode=$mstFres[2];

$chkRes=$obj->select("emplevconfig", "empCode='$empCode'");
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
	<form name="form1" method="post" action="levBack">
			<h2 style="font-family:arial; font-size:13pt; background-color:#AEAEAE; padding:1%;">Leave settings of <?= $mstFres[3]?></h2>
			<table width="70%" border="0" cellspacing="0" cellpadding="3">
			  <tr>
				<th width="7%" align="center" valign="top">Sl No. <input name="rid" type="hidden" value="<?= $id?>"></th>
				<th width="38%" align="center" valign="top">Leave Name </th>
				<th width="18%" align="center" valign="top">Quntity</th>
			  </tr>
			  <?
			  $adRes=$obj->Select("leaveconfig order by prior");
			  
			  while ($adFres=$obj->fetchrow($adRes)){
			  	
				
				if ($chkRows > 0){
					
					$eaRes=$obj->select("emplevconfig", "empCode='$empCode' and levID=$adFres[0] and finYear='$yr'");
					
					while ($eaFres=$obj->fetchrow($eaRes)) {
					$r++;
					$eaid=($eaFres[0]) ? $eaFres[0] : 0;
					
					$qty=($eaFres[4]>0) ? $eaFres[4] : 0;
				
				
				
				
			  ?>
			  <tr>
				<td align="center" valign="top"><?= $r;?><input name="adID[]" type="hidden" value="<?= $adFres[0]?>"> <input type="hidden" name="eaID[]" value="<?= $eaid?>"  /></td>
				<td align="left" valign="top"><?= $adFres[1]?> </td>
				<td align="center" valign="top"><input name="qty[]" type="text" size="5" value="<?= sprintf("%s", $qty);?>"></td>
			  </tr>
			
			  <?
			  	}
			  }else{
			  	$r++;
			  		
			  ?>
			  <tr>
				<td align="center" valign="top"><?= $r;?><input name="adID[]" type="hidden" value="<?= $adFres[0]?>"></td>
				<td align="left" valign="top"><?= $adFres[1]?> </td>
				<td align="center" valign="top"><input name="qty[]" type="text" size="5" value="<?= sprintf("%s", $qty);?>"></td>
			  </tr>
			  <?
			 	 }
			  }
			  ?>
			    <tr>
			    <td align="center" valign="top">&nbsp;</td>
			    <td align="left" valign="top">&nbsp;</td>
			    <td align="center" valign="top">
				<? if($chkRows > 0) {?>
				
				<input name="bmod" type="submit" id="bmod" value="Modify" > 
				<? }?>
				<input name="bsav" type="submit" id="bsav" value="Save New"> 
				</td>
		      </tr>
		  </table>

  </form>


</div>