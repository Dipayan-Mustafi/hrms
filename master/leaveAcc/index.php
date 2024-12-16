<?
require ("../../config/setup.inc");

//require ($root."lib/hr/empManagement.php");

$title="Holiday Section";

require($rpath."pageDesign.tmp.php");

$emp=new empManagement();

/*$et=($_REQUEST['et']) ? $_REQUEST['et'] : 1;
$pt=($_REQUEST['pt']) ? $_REQUEST['pt'] : 1;
$sxt=($_REQUEST['sxt']) ? $_REQUEST['sxt'] : 1;*/

//require ($root."lib/datetime/datetimepicker_css_js.php");

$id=($_REQUEST['id']) ? $_REQUEST['id'] : 0;

$cdt=date('y-m-d');

$expdYr=explode("-",$cdt);

$yr="20".$expdYr[0];
$prvYrCal=(int)$expdYr[0]-1;
$prvYr="20".$prvYrCal;
/*if ($id){

	$res=$obj->select("leaveconfig", "levID=$id");
	$fres=$obj->fetchrow($res);
	
	$lname=$fres[1];
	$qty=$fres[2];
	$mnth=$fres[3];
	$tqty=$fres[4];
	$mxBf=$fres[5];

}*/


?>
<script type="text/javascript">

function getRef(i){
	
	window.location="index?id="+i;
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
    	<h2>Holiday Configuration </h2>
        <div class="listDiv">
        	<form name="form1" method="post" action="addBack">
			 <table width="100%" border="0" cellspacing="0" cellpadding="3">
			 <tr>
			 <td width="34%"><strong>Holiday Name</strong></td>
             <td width="45%"><strong>Date</strong></td>
              </tr>
			<? 
				$holidayRes=$obj->distinct("holidaytable", "festival", "(hYear='$prvYr' or hYear='$yr')");
				//print_r($holidayRes);
				while($holidayFres=$obj->fetchrow($holidayRes)){
				
					$prvRes=$obj->select("holidaytable", "festival='$holidayFres[0]' and hYear='$prvYr'");
					$prvFres=$obj->fetchrow($prvRes);
					
					$hRes=$obj->select("holidaytable", "festival='$holidayFres[0]' and hYear=$yr");
					$hRow=$obj->rows($hRes);
					$hFres=$obj->fetchrow($hRes);
					
					
					$s++;
			?>
			 
                  <tr>
                    <td width="34%"><input type="hidden" name="id[]" id="id[]" value="<?=$s?>" /><input name="hname[]" type="text" id="hname[]" size="25" value="<?= $holidayFres[0]?>" /></td>
                    <td width="45%"><input name="dt[]" type="date" id="dt[]" size="25" value="<?= $hFres[1]?>"/></td>
                  </tr>
				   <?
				  }?>
                  <tr>
                    <td colspan="1">&nbsp;</td>
                    <td><input name="bSav" type="submit" id="bSav" value="Submit" /></td>
                  </tr>
				 
                </table>
			
			</form>
        </div>
</div>
        <div class="displayBox" style="width:25%; height:400px; overflow:auto;">
    	<h2>Holiday Section Oparations</h2>
        <div class="listDiv">
			<table border="0" cellpadding="3" width="100%">
				<tr>
				
					<td class="listTD" style="cursor:pointer; border-bottom:solid 1px #333333;" onclick="getRef(<?= $i?>)"><?= $configType[$i]?></td>
				</tr>
			</table>	
        </div>
</div>

    	