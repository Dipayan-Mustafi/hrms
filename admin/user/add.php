<?
require ("common.php");

$title.=" >> New User";

require ($root."resource/pageDesign.tmp.php");
?>
<link rel="stylesheet" href="<?= $CurDeptpath?>stylesheet/setup.css" />
<div class="contDiv">
<div style="background-color:#FFFFFF; width:60%; border:solid 1px #BABABA; text-align:left; padding:6pt;">
<form name="form1" method="post" action="addBack">
  <table width="90%" border="0" align="center" cellpadding="3" cellspacing="2" style="border:solid 1px #B6BFBF">
    <tr>
      <td colspan="2" align="left" valign="top" style="border-bottom:solid 1px #A3A3A3"><strong>New User Adding Section </strong> </td>
      </tr>
    <tr>
      <td width="49%" height="40" align="left" valign="middle">User Id </td>
      <td width="51%" align="left" valign="middle"><input name="uid" type="text" id="uid" size="20" maxlength="100"></td>
    </tr>
    <tr>
      <td align="left" valign="middle">Password</td>
      <td align="left" valign="middle"><input name="pswd" type="text" id="pswd" size="20" maxlength="100"></td>
    </tr>
    <tr>
      <td align="left" valign="middle">Name</td>
      <td align="left" valign="middle"><input name="Name" type="text" id="Name" size="20" /></td>
    </tr>
    <tr>
      <td align="left" valign="middle">User Group</td>
      <td align="left" valign="middle"><select name="usg">
      	<?
      	$countUSG=count($acsTyp);
      	for ($i=0; $i < $countUSG; $i++){
			print "<option value='$i'>$acsTyp[$i]</option>";
		}
      	
      	?>
      	
      	
      	
      </select></td>
    </tr>
    <tr>
      <td align="left" valign="middle">&nbsp;</td>
      <td align="left" valign="middle"><input name="submit" type="submit" id="badd" value="Insert"></td>
    </tr>
  </table>
</form>

</div>
</div>
<?


?>