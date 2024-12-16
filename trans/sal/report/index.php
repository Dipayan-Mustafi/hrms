<?
require ("../../../config/setup.inc");

$title="Salary Sheet Preview";

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
function fillMnth(a){
		
		document.getElementById('mnth').value=a;
	}	
function fillyr(b){
		
		document.getElementById('year').value=b;
	}
function fillDept(c){
		
		document.getElementById('dept').value=c;
	}
function goNext(){
		
	if (document.getElementById('mth').value==0){
		alert ("Please select Proper Month");
	}else if (document.getElementById('yr').value==0){
		alert ("Please select Proper year");
	}else{
			document.form1.submit();
	}
	
	
}		
</script>
<div class="contDiv">
	<input type="image" align="right" border="1" src="<?= $rurl?>images/close.png" width="24" height="24" alt="Close" title="Close" style="cursor:pointer; margin:2; padding:9; border:#666666; border-style:dashed" onclick="navigate('../../../index.php');" />
	<div id="heading"><h3>Salary Sheet Preview</h3></div>
	<form name="form1" action="sheet.php" method="post">
	 <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#999999">
			<tr>
			<th width="18%" align="center">Select Month</th>
            <th width="32%" align="left" valign="top"> <select id="mth" name="mth" onChange="fillMnth(this.value);">
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
			
			<th width="18%" align="center"> Select Year</th>
			<th width="32%" align="left" valign="top"> <select id="yr" name="yr" onChange="fillyr(this.value);">
								<option value="0" selected="selected">--</option>
				<?
					 for ($i=$styr; $i<=date('Y'); $i++){
						
							print "<option value='$i'>$i</option>";
						
					  }
				?>
				</select>
				<input type="hidden" name="year" id="year"/>
			</th>
			</tr>
	  </table>
			<table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC">
			<tr>
			<th width="18%" align="center"> Select Department</th>
			<th width="82" align="left" valign="top"> <select id="dpt" name="dpt"  onChange="fillDept(this.value);">
									<option value="0" selected="selected">ALL</option>
				<?
					 $res=$obj->select("deptmanager");
					 while($fres=$obj->fetchrow($res)){
						
							print "<option value='$fres[0]'>$fres[1]</option>";
						
					  }
				?>
				</select>
				<input type="hidden" name="dept" id="dept"/>
			</th>
			</tr>
		  </table>
		  <table width="100%" border="0" cellpadding="3" cellspacing="0">
		  <tr>
		  <th><input type="button" name="btnAll" id="btnAll" value="Preview" onclick="goNext();">
		  </th>
		  </tr>
		  </table>
</form>
</div>