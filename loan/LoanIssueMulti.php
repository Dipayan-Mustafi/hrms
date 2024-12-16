<?
//error_reporting (E_ALL);
require ("../config/setup.inc");


$title="Multiple Loan Disbursement"; 

require($rpath."pageDesign.tmp.php");



$mem=($_REQUEST['mem']) ? $_REQUEST['mem'] : 0;




?>
<style type="text/css">
.DivLine {  text-align:left; border-bottom:dashed 1px #333333; margin-bottom:5px;}
.DivCell { float:left; padding:8px;}
.DivCell input[type=text],select { border:solid 1px #999999; border-radius:5px; font-family:verdana; font-size:10px; height:22px;}
#memList { display:none; width:300px; position:absolute; margin-top:25px; margin-left:15px; background-color:#FFFFFF; border:solid 1px #AEAEAE; border-radius:6px; height:150px; overflow:auto; }
.mSm{display:table; padding:3px; cursor:pointer; border-bottom:solid 1px #c1c1c1; width:99%;}
.mSm: hover{background-color:#B9B9B9;}
.mS1{display:table; float:left; text-align:left; width:49%; padding:0.5%;}
#detTbl { border:dashed 1px #333333; border-radius:6px;}
#detTbl th { background-color:#86869B; border-bottom:solid 1px #666666; color:#FFFFFF }
#detTbl td { border-bottom:dashed 1px #333333}

</style>

<script type="text/javascript">
	
	
function chckAccounts(){

	if (document.getElementById('ledNo').value==0){
	
		alert ("Please select account head !");
		return false;
	}else{
		return true;
	}


}	
	
	
</script>
<link rel="stylesheet" type="text/css" href="<?= $url?>lib/epoch_styles.css" />
<script type="text/javascript" src="<?= $url?>lib/epoch_classes.js"></script>
<script type="text/javascript">

	var pop_cal;
	window.onload=function(){
		
	
		pop_cal1= new Epoch('epoch_popup','popup',document.getElementById('chqdt'));
		
		
	};
</script>

<div class="contDiv">
	<div class="DivLine">
		<div class="DivLine" style="text-align:right"><input type="button" value="Back" onclick="navigate('undisbursed');" /></div>
		<h3>Loan Disbursement of Unpaid Loan</h3>
		<form name="form1" action="multiBack.php" method="post" onsubmit="return chckAccounts();">
			<table border="0" width="100%" cellpadding="5" cellspacing="0" id="detTbl">
			<tr>
				<th align="center" valign="top">Loan Type
				<input name="mno" type="hidden" id="mno" value="<?= $mem?>" /></th>
				
				<th align="center" valign="top">Authorised Amount</th>
				<th align="center" valign="top">Gurantee Fund</th>
				<th align="center" valign="top">Share Purchase Amount</th>
				<th align="center" valign="top">Previous Loan Amount</th>
				<th align="center" valign="top">Disbursement Amount</th>
			</tr>
			<?
			$lmRes=$obj->select("loanmem", "memNo='$mem' and endFlg=0");
			while ($lmFres=$obj->Fetchrow($lmRes)){
				
			
				$mstRes=$obj->select("loanmaster","loanID=$lmFres[4]");
				$mstFres=$obj->fetchrow($mstRes);
				
				$totAmount=$totAmount+$lmFres[9];
			
			?>
			<tr>
				<td align="left" valign="top"><?= $mstFres[1]?>
				<input name="lmID[]" type="hidden" id="lmID[]" value="<?= $lmFres[0]?>" /></td>
				
				<td align="center" valign="top"><?= $lmFres[8]?></td>
				<td align="center" valign="top"><?= $lmFres[10]?></td>
				<td align="center" valign="top"><?= $lmFres[11]?></td>
				<td align="center" valign="top"><?= $lmFres[12]?></td>
				<td align="center" valign="top"><?= $lmFres[9]?></td>
			</tr>
			
			<?
			}
			?>
			<tr>
			  <td align="left" valign="top">Pay Mode </td>
			  <td align="center" valign="top"><?
				$countPMode=count($payMode);
				$pm=($_REQUEST['pm']) ? $_REQUEST['pm'] : 1;
				for ($i=1; $i < $countPMode; $i++){
				
					if ($i==$pm){
						print "<input type='radio' name='pm' value='$i' checked='checked'>$payMode[$i]&nbsp; ";
					}else{
						print "<input type='radio' name='pm' value='$i'>$payMode[$i]&nbsp; ";
					}
				
				
				}
				
				
				
				
				?></td>
			  <td align="center" valign="top">Bank Name </td>
			  <td align="center" valign="top"><select name="bank" id="bank">
		<option>--</option>
		<?
		$bnkRes=$obj->select("bankmast order by bankName");
		while ($bnkFres=$obj->fetchrow($bnkRes)){
			print "<option>$bnkFres[1]</option>";
		}
		?>
		
		
		
	</select></td>
			  <td align="center" valign="top">Cheque No. </td>
			  <td align="center" valign="top"><input name="chqno" id="chqno" type="text" value="" size="17"  /></td>
			  </tr>
			<tr>
			  <td align="left" valign="top">Select Account Head </td>
			  <td align="center" valign="top"><select name="ledNo" id="ledNo">
				<option value="0">--</option>
				<?
				$ledRes=$obj->select("ledgermaster", "AcntTyp='3031' or AcntTyp='3032'");
				while ($ledFres=$obj->fetchrow($ledRes)){
					print "<option value='$ledFres[0]'>$ledFres[1]</option>";
				
				}
				
				?>
				</select></td>
			  <td align="center" valign="top">&nbsp;</td>
			  <td align="center" valign="top">&nbsp;</td>
			  <td align="center" valign="top">Cheque Date </td>
			  <td align="center" valign="top"><input name="chqdt" id="chqdt" type="date" value="" size="15"  /></td>
			  </tr>
			<tr>
			  <td align="left" valign="top">&nbsp;</td>
			  <td align="center" valign="top">&nbsp;</td>
			  <td align="center" valign="top"><input type="submit" name="Submit" value="Submit" /></td>
			  <td align="center" valign="top">&nbsp;</td>
			  <td align="center" valign="top">&nbsp;</td>
			  <td align="center" valign="top">&nbsp;</td>
			  </tr>
		</table>
		
		</form>
	
	</div>


</div>

<?
require($rpath."footer.tmp.php");
?>