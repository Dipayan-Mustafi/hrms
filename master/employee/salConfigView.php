<?

require ("../../config/setup.inc");



$title="View Configuration";

require($rpath."pageDesign.tmp.php");

$emp=new empManagement();


$ec=$_REQUEST['ec'];

$mstRes=$obj->select("empmaster", "empCode='$ec'");
	
$mstFres=$obj->fetchrow($mstRes);
	

?>
<script type="text/javascript">
function getRef(i){
	
	window.location="index";
}
</script>
<div class="contDiv">

	<div style="float:right; width:25%;"><input type="button" value="Back" onclick="getRef(0);" /></div>
	
			<h2 style="font-family:arial; font-size:13pt; background-color:#AEAEAE; padding:1%;">Salary settings of <?= $mstFres[3]?></h2>
			<table width="70%" border="0" cellspacing="0" cellpadding="3">
			  <tr>
				<th width="7%" align="center" valign="top">Sl No. <input name="rid" type="hidden" value="<?= $id?>"></th>
				<th width="38%" align="center" valign="top">Allowance / Deductions</th>
				<th width="18%" align="center" valign="top">Category</th>
				<th width="19%" align="center" valign="top">Type</th>
				<th width="18%" align="center" valign="top">Amount</th>
			  </tr>
			  <?
			
			  	$r++;
				$eaRes=$obj->select("empallowance", "empCode='$ec'");
				
				while ($eaFres=$obj->fetchrow($eaRes)) {
					$adRes=$obj->select("allowancemaster", "alwID=$eaFres[2]");
					$adFres=$obj->fetchrow($adRes);
				
					$eaid=($eaFres[2]) ? $eaFres[2] : 0;
					
						$amnt=(floatval($eaFres[3])>0) ? $eaFres[3] : 0;
					
					
					$t=($eaFres[4]) ? $eaFres[4] : 0;
					$u=($eaFres[5]==2) ? "Daily" : "Monthly";
					$e=($eaFres[6]==1) ? "Allowances" : "Deductions";
				
			  ?>
			  <tr>
				<td align="center" valign="top"><?= $r;?></td>
				<td align="left" valign="top"><?= $adFres[1]?> [<?= $u?>]</td>
				<td align="center" valign="top"><?= $e?></td>
				<td align="center" valign="top">
				<?= $salRTyp[$t] ?>
							
				</td>
				<td align="center" valign="top"><?= sprintf("%0.2f", $amnt);?></td>
			  </tr>
			
			  <?
			  }
			  
			  ?>
			    <tr>
			    <td align="center" valign="top">&nbsp;</td>
			    <td align="left" valign="top">&nbsp;</td>
			    <td align="center" valign="top">&nbsp;</td>
			    <td align="center" valign="top">&nbsp;</td>
			    <td align="center" valign="top">&nbsp;</td>
			    </tr>
		  </table>
	

</div>