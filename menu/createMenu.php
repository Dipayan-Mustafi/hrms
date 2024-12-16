<?php
require ("../config/setup.inc");


if(!$_SESSION['usr']['id']){
	$set->redirect($url."login");
}

$title="Menu Creation";

require ($root."resource/pageDesign.tmp.php");


$qmArray=array("No", "Yes");
$qm=($_REQUEST['ql']) ? $_REQUEST['ql'] : 0;
?>
<style type="text/css">
	#divMain{
		margin-top: 5px;
		width: 58%;
		padding:1%;
		border:dotted 1px #333;
		border-radius: 6px;
		text-align: left;
	}
</style>
<center>
<div class="contDiv">
	<div class="mainDiv">
		<div style="text-align:right"><input type="button" name="bback" value="<< Manager" onclick="navigate('index');"></div>
		<h3>Create New Menu</h3>
		<form name="form1" method="POST" action="menuBack">
			
			<table border="0" width="100%" cellpadding="5" cellspacing="0">
				<tr>
					<td>Menu Name</td>
					<td><input type="text" name="txt[]" value="" size="20" autofocus="true"></td>
				</tr>
				<tr>
					<td>Menu Link</td>
					<td><input type="text" name="txt[]" value="" size="20"></td>
				</tr>
				<tr>
					<td>Menu Head</td>
					<td>
						<select name="txt[]" style="width:200px; padding:4px;">
							<option value="0">Main</option>
							<?
							$menuRes=$obj->select("menumanager order by menuHead");
							while ($menuFres=$obj->fetchrow($menuRes)){
								if ($menuFres[2]){
									$chkRes=$obj->select("menumanager", "menuID=$menuFres[0]");
									$chkFres=$obj->fetchrow($chkRes);
									$hdName=$chkFres[1];
								}else{
									$hdName="Main";
								}
								print "<option value='$menuFres[0]'>$menuFres[1] - $hdName</option>";
							}
							?>
						</select>					</td>
				</tr>
				
				<tr>
					<td colspan="2"><input  type="submit" value="Save" name="bsav"/></td>
				</tr>
			</table>
		</form>
		
	</div>
</div>
</center>