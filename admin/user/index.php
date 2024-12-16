<?php

error_reporting(E_ERROR);
require ("../../config/setup.inc");

$title=$app['info']['name'];

$stman=new SetupManagement();

if (!$_SESSION['usr']['id']){

	$stman->checkSetup();
}else{
	$stman->chkLiveLogin();
	
	$fyr=$misc->CurrentFinYear(date('y'), date('m'));
	
	
	
	

}

require ($root."resource/pageDesign.tmp.php");

?>
<div class="contDiv">

	<div style="width:198mm; text-align:left; background-color:#FFF; color:#000; padding:1mm;">
		
		<table width="90%" border="0" cellspacing="0" cellpadding="3" align="center" id="usrTbl">
		    <tr>
		      <td colspan="6" align="left" valign="top" style="border-bottom:solid 1px #B6BFBF; padding:3pt; font-family:arial; font-size:10pt;"><strong>User Management</strong> <div style="float: right; width:100px;"><input type="button" name="badd" value="Add New" onclick="navigate('add');" style="padding: 15px; background-color:#98ba5f; font-weight:bold; font-size:15px; font-family:arial; border:solid 1px #98ba00; " accesskey="I" /></div></td>
		    </tr>
		    <tr>
		      <th width="23%" align="center" valign="middle" ><strong>User id </strong></th>
		      <th width="25%" align="center" valign="middle"><strong>Password</strong></th>
		      <th width="26%" align="center" valign="middle"><strong>User Name</strong> </th>
		    
		      <th width="26%" align="center" valign="middle"> <strong>Access Level</strong></th>
		    </tr>
			<?
			$res=$obj->Select("userdetail");
			$rows=$obj->rows($res);
			if ($rows > 0){
				
				while ($fres=$obj->FetchRow($res)){
					
					
					
					$typ=$fres[4];
					
			?>
		    <tr>
		      <td align="center" valign="middle"><a href="update.php?id=<?= $fres[0]?>"><?= $fres[1]?></a></td>
		      <td align="center" valign="middle"><?= base64_decode(base64_decode(base64_decode($fres[2])))?></td>
		      <td align="center" valign="middle"><?= $fres[3]?></td>
		      <td align="center" valign="middle"><?= $acsTyp[$typ];?>		        <a href="up_perm.php?id=<?= $fres[0]?>&amp;acc=<?= $fres[9]?>"></a></td>
		    </tr>
			<?
				}
			}
			?>
		  </table>
	
	
	</div>
	</div>
