<?php
//error_reporting(E_ALL);
require ("../config/setup.inc");

$title=$app['info']['name']."- Setting up the application "; 
require ($root."resource/pageDesign.tmp.php");
?>
<center>

	<div id="logBox" style="width:40%;">
		<form name="form1" method="post" action="addAdmin">		
			<table border="0" width="100%" cellpadding="3" cellspacing="0" id="setTbl">
			
				<tr>
					<th colspan="2">Installation of Admin</th>
				</tr>
				<tr>
					<td align="left" valign="top">Login ID</td>
					<td align="left" valign="top"><input type="text" name="logID" id="logID" size="20"></td>
				</tr>
				<tr>
					<td align="left" valign="top">Password</td>
					<td align="left" valign="top"><input type="password" name="pwd" id="pwd" size="20"></td>
				</tr>
				<tr>
					<td align="left" valign="top">Administrator Name</td>
					<td align="left" valign="top"><input type="text" name="aname" id="aname" size="20"></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" name="bSav" value="Save" > </td>
				</tr>
			
			</table>
		</form>
	</div>
</center>