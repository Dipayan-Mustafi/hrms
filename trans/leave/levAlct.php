<title>Leave Alocation</title>
<?
error_reporting(E_ALL);
require ("../../config/setup.inc");



$title="Leave Alocation";



//require($rpath."pageDesign.tmp.php");

$emp=new empManagement();

$lid=$_REQUEST['lid'];
$ec=$_REQUEST['ec'];
$m=$_REQUEST['mnth'];
$yr=$_REQUEST['yr'];
$m=sprintf("%02d",$m);
$shtYr=substr($yr,2,2);

$fyr=$misc->CurrentFinYear($shtYr,$m);

$mnth=sprintf("%02d", $m);

$mRes=$obj->select("empmaster", "empCode=$ec");
$mFres=$obj->fetchrow($mRes);

$lvRes=$obj->select("leaveconfig", "levID=$lid");
$lvFres=$obj->fetchrow($lvRes);

$mnthlevRes=$obj->sumfield("emplevconfig", "qty", "empCode='$mFres[2]' and levID='$lvFres[0]' and finYear='$fyr'");
//print_r($mnthlevRes);
$mnthtakenRes=$obj->sumfield("attnlevdet", "qty", "empCode='$mFres[2]' and levID='$lvFres[0]' and levYear='$yr'");

$avlLv=$mnthlevRes-$mnthtakenRes;
$attndCal=$emp->empAttndCal($mFres[2], $mnth, $yr);
$ltCal=(int)($attndCal[7]/3);
$abs=$attndCal[3]-$attndCal[4]+$ltCal;
$lvAbs=$abs-$attnd[6];


$mnthLvRes=$obj->sumfield("attnlevdet", "qty", "empCode='$mFres[2]' and levMonth='$mnth' and levYear='$yr'");
$unAlctd=$lvAbs-$mnthLvRes;

if($unAlctd>$avlLv){
	$unAlctd=$avlLv;
}	
?>
<style type="text/css">
tr:hover { background-color:#999999; cursor:pointer;}
</style>
<script type="text/javascript">
function dtcal(i) {
   
	var fdtc="fdt"+i;
	var tdtc="tdt"+i;
	var noc="no"+i;
	
	var fdt=document.getElementById(fdtc).value;
	var tdt=document.getElementById(tdtc).value;
     
	//alert(tdt);
		var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById(noc).value = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET", "chk.php?s="+fdt+"&e="+tdt, true);
        xmlhttp.send();
		
		
}
function calTot(i) {
  
	var noc="no"+i;
	
	var nocv=document.getElementById(noc).value;
	if(eval(nocv)>0){
	var tots=document.getElementById('tot').value;
	
	var ntot=eval(tots)+eval(nocv);
   // alert(tots+'+'+nocv+'='+ntot);
    document.getElementById('tot').value = eval(ntot);
	}
}
function bSub(){
	
	var tots=document.getElementById('tot').value;
	var unalv=document.getElementById('unal').value;
	
	//alert(unalv);
	
	if(eval(tots)>eval(unalv)){
		alert('Check Leave Alocation. Number of alocated leaves and leaves does not match');
	}else{
		document.form1.submit();
	}
}
</script>
 <form method="post" name="form1" action="alocate.php">
<table width="100%" border="0" bgcolor="#CCCCCC">
  <tr>
    <td width="29%" bgcolor="#CCCCCC"><strong>Employee Name:</strong> <?=$mFres[3]?><input type="hidden" id="ecode" name="ecode" value="<?=$ec?>" /></td>
    <td width="34%" bgcolor="#CCCCCC"><strong>Total Unalocated Leave:</strong> <?=$unAlctd?><input type="hidden" name="unal" id="unal" value="<?=$unAlctd?>" /></td>
    <td width="37%" bgcolor="#CCCCCC"><strong>Number of <?=$lvFres[1]?>(s) Left:</strong> <?=$avlLv?><input type="hidden" id="lvID" name="lvID" value="<?=$lid?>" /><input type="hidden" name="mnth" id="mnth" value="<?=$m?>" /><input type="hidden" name="yr" id="yr" value="<?=$yr?>" /></td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="0" bgcolor="#FFFFFF">  
  <tr>
    <td colspan="3" align="center" valign="middle"><h3>ALOCATE LEAVE</h3></td>
  </tr>
  <tr>
    <td width="48%" align="center"><strong>From</strong></td>
    <td width="18%"><strong>To</strong></td>
    <td width="34%" align="center"><strong>Number of Days</strong></td>
  </tr>
 
<?
  for($i=0; $i<$unAlctd; $i++){
  	$s++;
?>  
  <tr>
    <td align="center"><input type="date" name="fdt[]" id="fdt<?=$i?>" /><input type="hidden" name="count[]" id="count<?=$i?>" value="<?=$s?>" /><input type="hidden" id="ecode" name="ecode" value="<?=$ec?>" /></td>
    <td><input type="date" name="tdt[]" onblur="dtcal(<?=$i?>);" id="tdt<?=$i?>" /></td>
    <td align="center"><input type="text" size="3" onblur="calTot(<?=$i?>);" readonly="readonly" name="no[]" id="no<?=$i?>"/></div></td>
  </tr>
<? }?>
<tr>
    <td colspan="2" align="right"><strong>Total Number of Days</strong></td>
    <td align="center"><input type="text" size="3" value="0" readonly="readonly" id="tot"/></div></td>
  </tr>
  <tr>
    <td colspan="3" align="center"><input type="button" name="bSave" id="bSave" value="Alocate" onClick="bSub();" /></td>
  </tr>
 
</table>
</form>