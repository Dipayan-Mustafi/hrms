<?
require ("../../../config/setup.inc");

$title="Company contribution report";

require($rpath."pageDesign.tmp.php");

$mnthArray=array( "", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");

$endyr=date('Y');
$styr=$endyr -3;


?>
<style type="text/css">
	#fldSet{
		border:solid 1px #666666;
		border-radius:5px;
		padding: 5px;
		
		background-color:#CCCCCC;
		display:inline-table;
		overflow:auto;
	}
	#lgnd {
		font-weight:bold; 
		font-family:arial;
		font-size:15px;
	}
	
	.detLine{
		border-bottom:solid 1px #000000;
		padding: 5px 10px 5px 10px;
		display:inline-table;
		width:99%;
		cursor:pointer;
	}
	.detLine:hover {
		
		background-color:#727272;
		display:inline-block;
		color:#FFFFFF;
	
	}
	
</style>
<script type="text/javascript">
function goNext(){
		
	if (document.getElementById('mth').value==0){
		alert ("Please select Month");
	}else if (document.getElementById('yr').value==0){
		alert ("Please select Year");
	}else if (document.getElementById('typ').value==0){
		alert ("Please select Catagory of the Report");
	}else{
			document.form1.submit();
	}
	
	
}		
</script>
<div class="contDiv">
<input type="image" align="right" border="1" src="<?= $rurl?>images/close.png" width="24" height="24" alt="Close" title="Close" style="cursor:pointer; margin:2; padding:9; border:#666666; border-style:dashed" onclick="navigate('../../../index.php');" />
	<div id="heading">
	  <h3>PF REPORTS </h3>
	</div>
	<form name="form1" action="direction.php" method="post">
		<input type="hidden" name="flg" id="flg" value="2" />
	 <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#999999">
			<tr>
			<th width="18%" align="center"> Select Report Type </th>
			<th width="82" align="left" valign="top"> <select id="typ" name="typ">
				<option value="0" selected="selected">--</option>
				<option value="1" >Monthly contribution Report</option>
				<option value="2" >Wages Report</option>
				</select>
			</th>
			<th width="321" align="center" valign="top"><strong>Select Department </strong></th>
			<th width="328" align="left" valign="top"><select id="dept" name="dept">
									<option value="0" selected="selected">--</option>
				<?
					 $res=$obj->select("deptmanager", "deptID > 1 order by deptID");
					 while($fres=$obj->fetchrow($res)){
						
							print "<option value='$fres[0]'>$fres[1]</option>";
						
					  }
				?>
				</select></th>
			</tr>
			</table>
			<table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC">
			<tr>
			<th width="18%" align="center">Select Month</th>
            <th width="32%" align="left" valign="top">
				<select id="mth" name="mth">
									<option value="0" selected="selected">--</option>
				<?
					$cMnth=count($mnthArray);
					for ($i=1;$i<$cMnth; $i++){
							
								print "<option value='$i'>$mnthArray[$i]</option>";
						}
				?>
				</select>
				<input type="hidden" name="mnth" id="mnth"/>
			</th>
			
			<th width="18%" align="center">Select Year</th>
			<th width="32%" align="left" valign="top"><select id="yr" name="yr" onChange="fillyr(this.value);">
								<option value="0" selected="selected">--</option>
				<?
					 for ($i=$styr; $i<=date('Y'); $i++){
						
							print "<option value='$i'>$i</option>";
						
					  }
				?>
				</select>
			</th>
			</tr>
			
		  </table>
		  <table width="100%" border="0" cellpadding="3" cellspacing="0">
		  <tr>
		  <th align="center"><input type="button" name="btnAll" id="btnAll" value="Preview" onclick="goNext();">
		  </th>
		  </tr>
		  </table>
</form>
</div>