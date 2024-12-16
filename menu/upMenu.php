<?php
require ("../config/setup.inc");



$harray=array("--", "Administrative", "Executive", "Members");

$title="Menu Modification";

require($root."resource/pageDesign.tmp.php");

$qmArray=array("No", "Yes");
$qm=($_REQUEST['ql']) ? $_REQUEST['ql'] : 0;

$id=$_REQUEST['id'];

$res=$obj->Select("menumanager", "menuID=$id");
$fres=$obj->fetchrow($res);

$txt[0]=$fres[1];
$txt[1]=$fres[2];
$txt[2]=$fres[3];



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

	<div class="contDiv">
		<div style="text-align:right"><input type="button" name="bback" value="<< Manager" onclick="javascript:window.location='index'"></div>
		<h3>Modify Menu</h3>
		<form name="form1" method="POST" action="menuUBack">
			
			<table border="0" width="100%" cellpadding="5" cellspacing="0">
				<tr>
					<td>Menu Name
				    <input name="id" type="hidden" id="id" value="<?= $id?>" /></td>
					<td><input type="text" name="txt[]"  size="20" value="<?= $txt[0]?>"></td>
				</tr>
				<tr>
					<td>Menu Link</td>
					<td><input type="text" name="txt[]"  size="20" value="<?= $txt[1]?>"></td>
				</tr>
				<tr>
					<td>Menu Head</td>
					<td>
						<select name="txt[]">
							<option value="0">Main</option>
							<?
							$menuRes=$obj->select("menumanager");
							while ($menuFres=$obj->fetchrow($menuRes)){
								if ($menuFres[2]){
									$chkRes=$obj->select("menumanager", "menuID=$menuFres[0]");
									$chkFres=$obj->fetchrow($chkRes);
									$hdName=$chkFres[1];
								}else{
									$hdName="Main";
								}
								
								if ($menuFres[0]==$txt[2]){
									print "<option value='$menuFres[0]' selected>$menuFres[1]</option>";
								}else{
									print "<option value='$menuFres[0]'>$menuFres[1]</option>";
								}
							}
							?>
						</select>	<input type="hidden" name="phd" value="<?= $txt[2]?>" /></td>
				</tr>
				
				<tr>
					<td colspan="2"><input  type="submit" value="Save" name="bsav"/></td>
				</tr>
			</table>
		</form>
		
	</div>

