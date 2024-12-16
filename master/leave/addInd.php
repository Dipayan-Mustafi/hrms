<?
//error_reporting(E_ALL);
require ("../../config/setup.inc");



$title="Leave Accumulation";

require($rpath."pageDesign.tmp.php");

$emp=new empManagement();


require ($root."lib/datetime/datetimepicker_css_js.php");

$ec=$_REQUEST['ec'];
$cdt=date('y-m-d');


?>
<style type="text/css">
.displayBox{
	
	border:solid 1px #333333;
	padding:0.5%;
 	width:60%;
	display:inline;
	float:left;
	margin:1%;
	box-shadow:0.5em 0.5em 0.5em #CCCCCC;
}
.displayBox h2{
	color:#00032D;
	font-family:arial;
	font-size:12pt;
	font-weight:bold;
	vertical-align:middle;
	display:block;
	border-bottom:dotted 1px #00054A;
}
.displayBox .listDiv {
	display:table;
	width:100%;
	
}
.displayBox .listDiv .imgDiv{
	float:left;
	height:250px;
	border-right:solid 1px #000000;
	width:40%;
}
.displayBox .listDiv .gistDiv{
	float:left;
	height:250px;

	width:55%;

}

.displayBox .moreDiv{
	border-top:solid 1px #660000;
	text-align:right;
	font-family:Century Gothic;
	font-size:10pt;
	display:block;
}
.displayBox .moreDiv .btn{
	display:table;
	text-align:right;
	background-color:#99CCCC;
	color:#000000;
	font-weight:bold;
	cursor:pointer;
	float:right;
	padding:0.5%;
}
</style>
<script type="text/javascript">
function getEmp(s){
	window.location="?ec="+s;
}
function goto(){
		
	
	if (document.getElementById('dt').value==0){
		alert ("Please select Sallary Date");
	}else{
			document.form1.submit();
	}
	
	
}
</script>
<div class="contDiv">

	<div id="heading" align="left">
	  Leave Register
	    <input type="image" align="right" border="1" src="<?= $rurl?>images/close.png" width="16" height="16" alt="Close" title="Close" style="cursor:pointer; margin:2; padding:9; border:#666666; border-style:dashed" onclick="navigate('../../index.php');" /></div>
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
	<div class="displayBox" style="box-shadow:0.5em 0.5em 0.5em #CCCCCC; width:58%">
	<div class="divLine" style="width:99%; margin:1%" align="right">
		<input type="image" align="right" border="1" src="<?= $rurl?>images/close.png" width="16" height="16" alt="Close" title="Close" style="cursor:pointer; margin:2; padding:9; border:#666666; border-style:dashed" onclick="navigate('addInd.php');" />
	</div>
	<form name="form1" method="post" action="levBack">
	<div class="divLine" style="width:98%; margin:1%" align="center"><strong>Select Date:</strong><input type="date" id="dt" name="dt" /></div>
	<table width="100%" border="1" cellpadding="3" cellspacing="0" align="center" style="background-color:#BBD7D6; border:#0066FF 1px solid">
	 
		  <tr style="border:hidden">
		  <? $deptRes=$obj->select("deptmanager", "deptID=$fres[12]");
			 $deptFres=$obj->fetchrow($deptRes);
			 
			 $desigRes=$obj->select("desigmast", "dsgID=$fres[11]");
			 $desigFres=$obj->fetchrow($desigRes);
		  ?>
			<td style="border:hidden" width="151" height="39" align="right"><strong>Employee Name :</strong> </td>
			<td width="145" align="center" style="border:hidden"><?=$fres[3]?>
			<input type="hidden" name="ec" id="ec" value="<?=$ec?>" /></td>
			<td width="102" align="right" style="border:hidden"><strong>Department:</strong> </td>
			<td width="218" align="center" style="border:hidden"><?=$deptFres[1]?></td>
		  </tr>
		  
		  <tr style="border:hidden">
			<td height="33" align="right" style="border:hidden"><strong>Designation:</strong></td>
			<td align="center" style="border:hidden"><?=$desigFres[1]?></td>
			<td align="right" style="border:hidden">&nbsp;</td>
			<td align="center" style="border:hidden">&nbsp;</td>
		  </tr>
	 
	 </table>
	
	  <?php
	  $lvRes=$obj->select("leaveconfig order by prior");
	  while($lvFres=$obj->fetchrow($lvRes)){
	  
	  	if($lvFres[3]==1){
	  		$opRes=$obj->sumfield("emplevconfig", "qty", "empCode=$ec and levID=$lvFres[0]");
			$balance=$obj->sumfield("attnlevdet", "qty", "empCode=$ec and levID=$lvFres[0] and levDate<'$cdt'");
			
			$op=$opRes-$balance;
			
			$rmks="Opening";
		}else{
			$opRes=$obj->sumfield("emplevconfig", "qty", "empCode=$ec and levID=$lvFres[0]");
			$balance=$obj->sumfield("attnlevdet", "qty", "empCode=$ec and levID=$lvFres[0]");
			
			$op=$opRes-$balance;
			
			$rmks="Remaining";
		}
		
		
		$lvTakn=$obj->sumfield("attnlevdet", "empCode=$ec and levID=$lvFres[0]");
		
		$lvTakn=($lvTakn) ? $lvTakn : 0;
	  ?>
		   <table width="100%" border="0" align="center" style=" background-color:#BBD7D6; border:2px solid #0066FF;">
		   <tr>
		   	<td style="border:hidden">&nbsp;</td>
			<td colspan="4" align="center"  style="border-bottom:2px solid;"><h4><?=$lvFres[1]?></h4></td>
		   	<td style="border:hidden">&nbsp;</td>
		   </tr>
		   <div class="divLine" style="width:50%">&nbsp;</div>
		  <tr>
		  <? 
		  	if($lvFres[3]==1){
		  ?>
			<td width="26%" ><strong>Leaves <?=$rmks?> </strong></td>
			<td width="2%" ><strong>:</strong></td>
		  <?
		  	}else{
		  ?>
		  	<td width="26%" ><strong>Leaves Remaining</strong></td>
			<td width="2%" ><strong>:</strong></td>
		  <?
		  	}
		  ?>
			
			<td width="23%"><strong><?=$op?></strong></td>
			<td width="19%" align="center">&nbsp;</td>
			<td width="1%" align="center">&nbsp;</td>
			<td width="29%">&nbsp;</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
		  	<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			</tr>
		  <tr>
			<td><strong>New Leaves</strong> </td>
			<td><strong>:</strong></td>
			<td><input type="text" id="nLv<?=$lvFres[0]?>" name="nLv<?=$lvFres[0]?>" /></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
	  
	  <?
	  }
	  ?>
	  </table>
	  <div class="divLine" style="width:100%">&nbsp;</div>
	  <table width="100%" border="0" align="center" style="background-color:#BBD7D6; border:#0066FF 1px solid;">
	  <tr>
	  	<td colspan="4" align="center"><input type="hidden" name="empNo" id="empNo" value="<?=$fres[2]?>" /><input type="button" id="sub" value="Save" onclick="goto();" /></td>
	  </tr>
	  </table>
</form>
	
<?
}
?>
</div>