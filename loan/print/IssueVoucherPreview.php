<?
require ("../../config/setup.inc");

$v=$_REQUEST['v'];

$title="Bond Issue - Accouts Voucher Preview";

require (TEMP_PATH."viewTemp.php");





$tranTyp=array("", "By","To");

?>
<script type="text/javascript">
	function chkPrint(d,t){
		 var divToPrint = document.getElementById(d);
		var popupWin = window.open('', '_blank', 'width=300,height=300');
		popupWin.document.open();
		popupWin.document.write('<html><title>'+t+'</title><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
		popupWin.document.close();
	}
	
</script>
<center>
	<div style="margin-top:0.5%; text-align:left;  padding:1%;  width:70%; text-align: right; ">
	<input type="button" name="chkPrnt" value="Print" onclick="chkPrint('PrintBlock', 'Voucher Printing');">
	</div>
	<div style="margin-top:0.5%; text-align:left; border-radius:6px; padding:1%; background-color:#A8A8A8; width:70%; box-shadow:0.5em 0.5em 0.5em #CCCCCC;">
		<div style="float:left; display:block; width:40%; ">


        </div>
	  <div id="PrintBlock" style="border-radius:6px; border:solid 1px #a1a1a1; background-color:#E2E2E2; padding:8px; ">
	  	<div style="border:dashed 1px #000; border-radius:6px;">
		<div style="display:table; width:99%; padding:2px;  text-align:center; margin-bottom:3%;">
			<div style="font-family:arial; font-weight:bold; font-size:20px;"><?= $company['info']['name']?></div>
			<div style="font-family:arial; font-weight:bold; font-size:15px;"><?= $company['info']['address']?>, <?= $company['info']['city']?>-<?= $company['info']['zip']?></div>
			<div style="font-family:arial; font-weight:bold; font-size:12px;">Reg. No. <?= $company['info']['regno']?></div>
			<div style="font-family:arial; font-weight:bold; font-size:12px;">Payment Voucher</div>
		</div>
		<?
		$DisRes=$obj->select("ledgertrans", "VchNo='$v'");
		$DisFres=$obj->fetchrow($DisRes);
		
		$usrRes=$obj->select("user_account", "acnt_id=$DisFres[21]");
		$usrFres=$obj->fetchrow($usrRes);


		
		?>
		<div style="display:table; width:99%; padding:2px; border-bottom:dotted 1px #000;font-family:arial; font-size:12px; ">
			<div style="float:left; display:block; width:20%; ">Voucher No</div><div style="float:left; display:block; width:25%;"><?= $v?></div><div style="float:left; display:block; width:20%; ">Voucher Date</div><div style="float:left; display:block; width:25%;"><?= $misc->dateformat($DisFres[1])?></div>
	    </div>
		<table width="99%" border="0" cellspacing="0" cellpadding="3" id="AcTbl" style="font-family:arial; font-size:12px;">
		  <tr>
			<th width="6%" align="center" valign="top" style="border-bottom:solid 2px #000;">#</th>
			<th width="40%" align="left" valign="top" style="border-bottom:solid 2px #000;">Account Name </th>
			<th width="21%" align="right" valign="top" style="border-bottom:solid 2px #000;">Debit</th>
			<th width="18%" align="right" valign="top" style="border-bottom:solid 2px #000;">Credit</th>
		  </tr>
		  <tbody>
		  <?
		  $res=$obj->select("ledgertrans", "VchNo='$v' order by TransTyp");
		  while ($fres=$obj->fetchrow($res)){
		  ?>
		  <tr >
            <td align="center" valign="top" style="border-bottom:dotted 1px #000;">
                <?
				$tt=$fres[5];
				print $tranTyp[$tt];
			
			?>
            </td>
		    <td align="left" valign="top" style="border-bottom:dotted 1px #000;">
                <?
			$LedRes=$obj->select("ledgermaster", "LedID=$fres[7]");
			$LedFres=$obj->fetchrow($LedRes);
			
			print $LedFres[1];
			if ($LedFres[2]){
				print " [$LedFres[2]]";
			}
			
			?>
            A/C</td>
			<?
			if ($fres[5]==1){
				$damnt=$fres[10];
			}else{
				$camnt=$fres[10];
			}
			
			?>
		    <td align="right" valign="top" style="border-bottom:dotted 1px #000;"><?= $damnt;?>&nbsp;</td>
		    <td align="right" valign="top" style="border-bottom:dotted 1px #000;"><?= $camnt;?>&nbsp;</td>
		    </tr>
		  
			<? 
				unset($damnt);
				unset($camnt);
			
			}?>
		  </tbody>
		  <?
		  $sumDr=$obj->sumfield("ledgertrans", "Amount", "TransTyp=1 and VchNo='$v'");
		  $sumCr=$obj->sumfield("ledgertrans", "Amount", "TransTyp=2 and VchNo='$v'");
		  ?>
		  <tr>
		    <th style="border:solid 2px #000;border-left:none; border-right:none;">&nbsp;</th>
		    <th style="border:solid 2px #000;border-left:none; border-right:none;">Total</th>
		    <th style="border:solid 2px #000;border-left:none; border-right:none;"><div id="TotDmt" align="right"><?= $sumDr?></div></th>
		    <th style="border:solid 2px #000;border-left:none; border-right:none;"><div id="TotCmt" align="right"><?= $sumCr?></div></th>
	      </tr>
		</table>

		<div style="display:table; width:99%; padding:2px; border-bottom:dotted 1px #000; height:50px; font-family:arial; font-size:12px;">
          <div style="float:left; display:block; width:10%; ">Narration</div>
		  <div style="float:left; display:block; width:30%; text-align: left;">
		    <?= nl2br($DisFres[11])?>
	      </div>
		  <div style="text-align:right; display:table; width:100%; padding-top: 2%;">
		  	<div style="float:right; border-top:dotted 1px #000; width:25%; padding-top: 4px; text-align:center;">Authorised Signature</div>
			<div style="float:right; border-top:dotted 1px #000; width:25%; padding-top: 4px; text-align:center; margin-right:1%;">Payee Signature [<?= $usrFres[4]?>] </div>
			<div style="float:right; border-top:dotted 1px #000; width:25%; padding-top: 4px; text-align:center; margin-right:1%;">Received By</div>
		  </div>
		 </div>
	    </div>
	  </div>
		
	</div>
</center>
