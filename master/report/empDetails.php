<?
//error_reporting(E_ALL);
require ("../../config/setup.inc");



$title="Employee Details";

require($rpath."pageDesign.tmp.php");

$emp=new empManagement();

$ec=$_REQUEST['ec'];

$res=$obj->select("empmaster", "empCode='$ec'");
$fres=$obj->fetchrow($res);

?>

<style type="text/css">
.listTD{

	background-color:#FFFFFF;
	

}
.listTD:hover{
	background-color:#666666;
	color:#FFFFFF;
	display:block;
}
.divLine {
	width:100%;display:table; height:3%
}
</style>

<div class="contDiv">
<div class="divLine" align="right"><input type="image" align="right" border="1" src="<?= $rurl?>images/close.png" width="24" height="24" alt="Close" title="Close" style="cursor:pointer; margin:2; padding:9; border:#666666; border-style:dashed" onclick="navigate('../employee/index.php?ec=<?=$fres[2]?>');" /><input type="image" align="right" hspace="10" src="<?= $rurl?>images/print_icon.gif" width="32" height="32" alt="Print Employee Details" title="Print Employee Details" style="cursor:pointer;" onclick="PrintDiv('printArea', 'Employee Details');" /></div>
<div id="printArea" align="center">
	<div class="divLine" style="width:100%; border:3px #D3D3D3 solid" align="center">
		
		<div class="divCell" style="width:100%; border-bottom:2px #FF0000 solid"><h2>Employee Details</h2></div>
       
        	<form name="form1" method="post" action="addBack" onsubmit="return chkForm();">
			
			  <table width="98%" border="0" cellspacing="0" cellpadding="3">
                  <tr>
                    <td width="25%"><strong>Employee Type </strong></td>
                    <td width="1%"><strong>:</strong></td>
                    <td width="28%"><?=$empTyp[$fres[1]]?></td>
					<td width="15%"><strong>Salary Type </strong></td>
                    <td width="1%"><strong>:</strong></td>
                    <td width="30%"><?=$payTyp[$fres[13]]?></td>
                  </tr>
                  <tr>
                    <td><strong>Employee Name </strong></td>
                    <td width="1%"><strong>:</strong></td>
                    <td><?= $fres[3]?></td>
                    <td><strong>Gender</strong></td>
                    <td width="1%"><strong>:</strong></td>
                    <td><?=$sxTyp[$fres[37]]?></td>
                  </tr>
                  <tr>
                    <td><strong>Date of Birth</strong> </td>
                    <td width="1%"><strong>:</strong></td>
                    <td><?=$misc->dateformat($fres[4]);?></td>
                    <td><strong>Email</strong> </td>
                    <td width="1%"><strong>:</strong></td>
                    <td><?= $fres[9]?></td>
                  </tr>
                  <tr>
                    <td><strong>Phone No.</strong> </td>
                    <td width="1%"><strong>:</strong></td>
                    <td><?= $fres[5]?></td>
                    <td><strong>Mobile No.</strong> </td>
                    <td width="1%"><strong>:</strong></td>
                    <td><?= $fres[6]?></td>
                  </tr>
                  <tr>
                    <td><strong>PAN No. </strong></td>
                    <td width="1%"><strong>:</strong></td>
                    <td><?= $fres[7]?></td>
                    <td><strong>Adhaar No.</strong> </td>
                    <td width="1%"><strong>:</strong></td>
                    <td><?= $fres[8]?></td>
                  </tr>
                  <tr>
                    <td colspan="6">&nbsp;</td>
                  </tr>
                  <tr bgcolor="#ADD6D6">
                    <td colspan="6" align="center"><strong>Present Address</strong> </td>
                  </tr>
                  <tr>
                    <td colspan="6">&nbsp;</td>
                  </tr>
                  <tr>
                    <td><strong>Address</strong></td>
                    <td width="1%"><strong>:</strong></td>
                    <td><?= $fres[14]?></td>
                    <td><strong>City</strong></td>
                    <td width="1%"><strong>:</strong></td>
                    <td><?= $fres[15]?></td>
                  </tr>
                  <tr>
                    <td><strong>Pin Code </strong></td>
                    <td width="1%"><strong>:</strong></td>
                    <td><?= $fres[16]?></td>
                    <td><strong>State</strong></td>
                    <td width="1%"><strong>:</strong></td>
                    <td><?= $fres[17]?></td>
                  </tr>
                  <tr>
                    <td><strong>Country</strong></td>
                    <td width="1%"><strong>:</strong></td>
                    <td><?= $fres[18]?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="6" align="center">&nbsp;</td>
                  </tr>
                  <tr bgcolor="#ADD6D6">
                    <td colspan="6" align="center"><strong>Permanent Address</strong></td>
                  </tr>
                  <tr>
                    <td colspan="6">&nbsp;</td>
                  </tr>
                  <tr>
                    <td><strong>Address</strong></td>
                    <td width="1%"><strong>:</strong></td>
                    <td><?= $fres[19]?></td>
                    <td><strong>City</strong></td>
                    <td width="1%"><strong>:</strong></td>
                    <td><?= $fres[20]?></td>
                  </tr>
                  <tr>
                    <td><strong>Pin Code </strong></td>
                    <td width="1%"><strong>:</strong></td>
                    <td><?= $fres[21]?></td>
                    <td><strong>State</strong></td>
                    <td width="1%"><strong>:</strong></td>
                    <td><?= $fres[22]?></td>
                  </tr>
                  <tr>
                    <td><strong>Country</strong></td>
                    <td width="1%"><strong>:</strong></td>
                    <td><?= $fres[23]?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
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
                    <td><strong>Father's/ Husband's Name </strong></td>
                    <td width="1%"><strong>:</strong></td>
                    <td><?= $fres[24]?></td>
                    <td><strong>Relation</strong></td>
                    <td width="1%"><strong>:</strong></td>
                    <td><?= $fres[25]?></td>
                  </tr>
                  <tr>
                    <td><strong>Maritial Status </strong></td>
                    <td width="1%"><strong>:</strong></td>
                    <td><?=$marTyp[$fres[26]];?></td>
                    <td><strong>Religion</strong></td>
                    <td width="1%"><strong>:</strong></td>
                    <td><?=$relgnTypArray[$fres[44]]?></td>
                  </tr>
                  <tr>
                    <td><strong>Spouse Name</strong> </td>
                    <td width="1%"><strong>:</strong></td>
                    <td><?= $fres[27]?></td>
                    <td><strong>Relation</strong></td>
                    <td width="1%"><strong>:</strong></td>
                    <td><?= $fres[28]?></td>
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
                    <td><strong><strong>Designation</strong></strong></td>
                    <td width="1%"><strong>:</strong></td>
                    
					<?
					$dsRes=$obj->Select("desigmast", "dsgID=$fres[11]");
					$dsFres=$obj->fetchrow($dsRes);
					
					?>
					<td><?=$dsFres[1]?></td>
                    <td><strong>Date of Joining</strong></td>
                    <td width="1%"><strong>:</strong></td>
                    <td><?= $misc->dateformat($fres[10])?></td>
                  </tr>
                  <tr>
                    <td><strong>Department*</strong></td>
                    <td width="1%"><strong>:</strong></td>
					<?
					$dpRes=$obj->Select("deptmanager", "deptID='$fres[12]'");
					$dpFres=$obj->fetchrow($dpRes);
					?>
					<td><?=$dpFres[1]?></td>
                    <td><strong>Sub-Group</strong></td>
                    <td width="1%"><strong>:</strong></td>
                    <td><?=$contractorArray[$fres[45]]?></td>
                  </tr>
                  
                  <tr>
                    <td><strong>Bank Account No </strong></td>
                    <td width="1%"><strong>:</strong></td>
                    <td><?=$fres[46]?></td>
                    <td><strong>IFSC Code </strong></td>
                    <td width="1%"><strong>:</strong></td>
                    <td><?=$fres[47]?></td>
                  </tr>
                  
                  <tr>
                    <td><strong>ESI Applicable? </strong></td>
                    <td width="1%"><strong>:</strong></td>
                    <td><?=$conTyp[$fres[29]]?></td>
                    <td><strong>EPF Applicable? </strong></td>
                    <td width="1%"><strong>:</strong></td>
                    <td><?=$conTyp[$fres[30]]?></td>
                  </tr>
                  <tr>
                    <td><strong>ESI No. </strong></td>
                    <td width="1%"><strong>:</strong></td>
					<? if($fres[29]==2){
						$num="N/A";
					}else{
						$num=$fres[38];
					}?>
                    <td><?=$num?></td>
                    <td><strong>EPF No. </strong></td>
                    <td width="1%"><strong>:</strong></td>
					<? $epf=sprintf("%07d", $fres[31])?>
                    <td>WBCAL0025282000<?=$epf?></td>
                  </tr>
                  <tr>
                    <td><strong>UAN</strong></td>
                    <td width="1%"><strong>:</strong></td>
                    <td><?=$fres[32]?></td>
                    <td><strong>EPF B/F Amount</strong> </td>
                    <td width="1%"><strong>:</strong></td>
                    <td><?=$fres[33]?></td>
                  </tr>
                  <tr>
                    <td><strong>Previous Company Name </strong></td>
                    <td width="1%"><strong>:</strong></td>
                    <td><?=$fres[34]?></td>
                    <td><strong>Basic Pay </strong></td>
                    <td width="1%"><strong>:</strong></td>
                    <td><?=$fres[35]?></td>
                  </tr>
                </table>
			
			</form>       
    	
    </div>
	

</div>
</div>