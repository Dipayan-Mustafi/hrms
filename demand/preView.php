<?php
require ("../config/setup.inc");


$mnthArray=array("", "Jan", "Feb","Mar","Apr","May","Jun", "Jul","Aug","Sep","Oct","Nov","Dec");


$mnth=($_REQUEST['mnth']) ? $_REQUEST['mnth'] : date('m');
$yr=($_REQUEST['yr']) ? $_REQUEST['yr'] : date('Y');

$title="Demand Preview";

require($rpath."pageDesign.tmp.php");

?>
<style type="text/css">
	
	.demandHBox{
		width: 90%;
		display: table;
		font-weight: bold;
		padding: 0.5%;
		border: dotted 1px #666666;
		border-radius: 5px;
		margin-bottom: 4px;
	}
	.demandTBox{
		width: 99%;
		display: table;
		
		padding: 0.5%;
		border: dotted 1px #666666;
		border-radius: 5px;
		margin-bottom: 4px;
	}
	.dCell{
		float: left;
		text-align: center;
		padding: 3px;
		
	}
</style>

<div class="contDiv">


	<div class="demandHBox">
		
		<form name="form1" method="POST" action="viewDemand" >
			<table width="100%" border="0" cellpadding="3" cellspacing="0">
			<tr>
				<td valign="top" align="left">Select Month</td>
				<td valign="top" align="left">
					<select name="mnth" >
						<?
						for ($i=1;$i<=12; $i++){
							$j=sprintf("%02d",$i);
							
							if ($mnth==$j){
								print "<option value='$j' selected>".$mnthArray[$i]."</option>";
							}else{
								print "<option value='$j'>".$mnthArray[$i]."</option>";
							}
						}
						?>
						
					</select>
					
					
				</td>
				<td valign="top" align="left">Year</td>
				<td valign="top" align="left">
					<select name="yr">
						<?
						for ($i=(date('Y')-2);$i<=date('Y'); $i++){
							
							
							if ($yr==$i){
								print "<option value='$i' selected>$i</option>";
							}else{
								print "<option value='$i'>$i</option>";
							}
						}
						?>
						
					</select>
					
					
				</td>
				<td valign="top" align="left"></td>
			</tr>
			<tr>
				<td valign="top" align="left">Area</td>
				<td valign="top" align="left" colspan="2"><select name="area[]" multiple="multiple" size="10" style="width:70mm;">
				<?php 
				
				$offRes=$obj->select("officemaster");
				while ($offFres=$obj->fetchrow($offRes)){
					
					print "<option value='$offFres[0]'>$offFres[1]</option>";


				}
				
				?>
				
				
				
				</select></td>
				
				<td valign="top" align="left"><input type="submit" name="bGen" value="View" /></td>
			</tr>	
		</table>
			
		</form>
		
	</div>

</div>