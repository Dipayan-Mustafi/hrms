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

$endyr=date('Y');
$styr=$endyr -3;

$yrd=($_GET['slc']) ? $_GET['slc'] : $endyr;
$cdt=date('y-m-d');

$expdYr=explode("-",$cdt);

$yr=$yrd;
$prvYr=$yr-1;
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
function getSlc(s){
	window.location="?slc="+s;
}
function newholi(){
	
	window.open('new.php','AddWindow','width=500,height=400,left=100,top=250,toolbar=No,location=No,scrollbars=yes,status=No,resizable=no,fullscreen=no');
	AddWindow.focus();

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
			 <td colspan="2">Select Year
			 <select name="yr" onchange="getSlc(this.value);">
		  <?
		  
		  
		  
		  
		  for ($i=$styr; $i<=date('Y'); $i++){
		  	if ($i==$yrd){
				print "<option value='$i' selected>$i</option>";
			}else{
				print "<option value='$i'>$i</option>";
			}
		  }
		  ?>
	  </select></td>
			 </tr>
			 <tr>
			 <td width="34%"><strong>Holiday Name</strong></td>
             <td width="45%"><strong>Date</strong></td>
              </tr>
			<? 
				$cRes=$obj->select("holidaytable", "hYear=$yr");
				$cRows=$obj->rows($cRes);
				if($cRows<20){
					$holidayRes=$obj->distinct("holidaytable", "festival", "(hYear='$yr' or hYear='$prvYr') order by hYear desc, hsDt");
				}else{
					$holidayRes=$obj->distinct("holidaytable", "festival", "hYear='$yr' order by hsDt");	
				}
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
    	