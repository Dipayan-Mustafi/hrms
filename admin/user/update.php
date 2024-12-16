<?
error_reporting(E_ERROR);
require ("common.php");



$title.=" Update User";

$id=$_REQUEST['id'];




if ($_REQUEST['badd']){

	$txt=$_REQUEST['txt'];
	$typ=$_REQUEST['typ'];
	$usg=$_REQUEST['usg'];
	$act=$_REQUEST['act'];
	
	$pwd=base64_encode(base64_encode(base64_encode($txt[1])));
	if ($txt[0]){
	
		$fld="logID='".trim($txt[0])."', pwd='$pwd', userName='$txt[2]', userTyp=$usg";
		
		
		
		$qry="userID=$id";
		
		$res=$obj->Update("userdetail", $fld,$qry );
		
		if ($res){
			print $set->JScriptAlert("User is Updated");
			print $set->jsoreload();
			print $set->JSClose();
		}else{
			print $set->JScriptAlert("Userid is already in Database");
		}
	
	}else{
		print $set->JScriptAlert("Sorry no blank field is allowed");
	}
}else{
	
	$res=$obj->Select("userdetail", "userID=$id");
	
	$fres=$obj->fetchrow($res);
	
	$txt[0]=$fres[1];
	
	$txt[1]=base64_decode(base64_decode(base64_decode($fres[2])));
	
	
	
	$txt[2]=$fres[3];
	$usg=$fres[4];

}




require ($root."resource/pageDesign.tmp.php");


?>

<link rel="stylesheet" href="<?= $CurDeptpath?>stylesheet/setup.css" />
<div class="contDiv">
<div style="background-color:#FFFFFF; width:70%; border:solid 1px #BABABA; text-align:left; padding:6pt;">
<form name="form1" method="post" action="">
  <table width="90%" border="0" cellspacing="2" cellpadding="3" style="border:solid 1px #B6BFBF">
    <tr>
      <td colspan="2" style="border-bottom:solid 1px #A3A3A3"><strong>User Update Section </strong> </td>
      </tr>
    <tr>
      <td width="49%" height="40" align="left" valign="bottom">User Id </td>
      <td width="51%" align="left" valign="bottom"><input name="txt[]" type="text" id="txt[]" size="20" maxlength="100" value="<?= $txt[0];?>"></td>
    </tr>
    <tr>
      <td align="left" valign="middle">Password</td>
      <td align="left" valign="middle"><input name="txt[]" type="text" id="txt[]" size="20" maxlength="100" value="<?= $txt[1]?>"></td>
    </tr>
    
    <tr>
      <td>User Name </td>
      <td><input name="txt[]" type="text" id="txt[]" value="<?= $txt[2]?>" size="20" /></td>
    </tr>
    <tr>
      <td align="left" valign="middle">User Group</td>
      <td align="left" valign="middle"><select name="usg">
      	<?
      	$countUSG=count($acsTyp);
      	for ($i=0; $i < $countUSG; $i++){
			if ($usg==$i){
				print "<option value='$i' selected>$acsTyp[$i]</option>";
			}else{
				print "<option value='$i'>$acsTyp[$i]</option>";
			}
			
		}
      	
      	?>
      	
      	
      	
      </select></td>
    </tr>
     
    <tr>
      <td>&nbsp;</td>
      <td><input name="badd" type="submit" id="badd" value="Modify"></td>
    </tr>
  </table>
</form>

</div>
</div>

