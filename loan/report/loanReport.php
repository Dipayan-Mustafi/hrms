<?php
require ("../../config/setup.inc");

$title="Uptodate Loan Report";
require($rpath."pageDesign.tmp.php");

?>
<style type="text/css">
	
	#fldSet{
		border:solid 1px #666666;
		border-radius:5px;
		padding: 5px;
		
		
		display:inline-table;
		width:100%;
		overflow:auto;
	}
	#lgnd {
		font-weight:bold; 
		font-family:arial;
		font-size:15px;
	}
		
	#memDet{
		position: absolute;
		margin-top: 10mm;
		width:200mm;
		display:none;
		background-color:#cccccc;
	}
	
</style>
<script type="text/javascript">
function FindDet(m){
	var ajaxRequest;
	if (window.XMLHttpRequest){
	// code for IE7+, Firefox, Chrome, Opera, Safari
		ajaxRequest=new XMLHttpRequest();
	}else{
		// code for IE6, IE5
		ajaxRequest=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	//Function which is receiving data sent from server
	ajaxRequest.onreadystatechange=function(){
		if (ajaxRequest.readyState==4 && ajaxRequest.status==200){
			
			document.getElementById('loanDet').innerHTML=ajaxRequest.responseText;
			//document.getElementById('memList').style.display="table";
			
			
		}else{
			//alert (ajaxRequest.status);
			document.getElementById('loanDet').innerHTML="Loading.....";
		
		}
		
	}
		
	
		var qstring="?mn="+m;
		
		ajaxRequest.open("GET","ajax/GetPend" + qstring, true);
		ajaxRequest.send(null);
	
}
function goto(){
	var m= document.getElementById("mem").value;
	window.location="LoanIssueMulti?mem="+m;
}
</script>

	<div class="contDiv">
		<div class="divLine" style="text-align: right"><img src="<?= $rurl ?>images/print_icon.gif" width="16" height="16" style="cursor:pointer;" onclick="PrintDiv('printArea','Loan Report');"></div>
		<div id="printArea">
			<h2>Consolidated loan Report as on <?= date('d-m-Y')?></h2>
			<table width="100%" border="0" cellspacing="0" cellpadding="3" style="padding:1%; border:solid 1px #333333;">
			  <tr style="background-color: #DFFCF9; padding:3pt;">
			    <th align="center" valign="top">Sl. No. </th>
				<th align="center" valign="top">Loan Name </th>
				<th align="center" valign="top">Issued Amount </th>
				<th align="center" valign="top">Refunded Amount</th>
				<th align="center" valign="top">Balance Amount </th>
				<th align="center" valign="top">Refund Percentage </th>
			  </tr>
			  <?
			  $lnRes=$obj->select("loanmaster order by loanID");
			  while ($lnFres=$obj->fetchrow($lnRes)){
			  
			  		$s++;
			  
			  		$mlRes=$obj->select("loanmem", "loanID=$lnFres[0] and endFlg=1");
					while ($mlFres=$obj->fetchrow($mlRes)){
					
						$grsIssue=$grsIssue+$mlFres[8];
						$sumRefund=$obj->sumfield("loanrepaylist", "amount", "LmID=$mlFres[0]");
						$sumRefund=($sumRefund) ? $sumRefund : 0;
						
					
						$netRefund=$mlFres[19]+$sumRefund;
						$grsRefund=$grsRefund+$netRefund;
					
						$blnAmount=$mlFres[8] - $netRefund;
					
					
					
					}
					
					
					$blnAmount=$grsIssue - $grsRefund;
					
					$prcnt=($grsRefund/ $grsIssue) * 100;
					
			  
			  ?>
			  
			  
			  <tr onclick="navigate('lonDet?lnID=<?= $lnFres[0]?>');" style="cursor:pointer;">
			    <td align="center" valign="top" style="border-bottom:dashed 1px #000000; "><?= $s?></td>
				<td align="left" valign="top" style="border-bottom:dashed 1px #000000; "><?= $lnFres[1]?></td>
				<td align="center" valign="top" style="border-bottom:dashed 1px #000000; "><? printf("%0.2f", $grsIssue)?></td>
				<td align="center" valign="top" style="border-bottom:dashed 1px #000000; "><? printf ("%0.2f", $grsRefund)?></td>
				<td align="center" valign="top" style="border-bottom:dashed 1px #000000; "><? printf ("%0.2f", $blnAmount);?></td>
				<td align="center" valign="top" style="border-bottom:dashed 1px #000000; "><? printf ("%0.2f", $prcnt);?></td>
			  </tr>
			  <?
			  		
			  		$totIssue=$totIssue+$grsIssue;
					$totRefund=$totRefund+$grsRefund;
					$totBal=$totBal+$blnAmount;
					
					$grsIssue=0;
					$grsRefund=0;
					$blnAmount=0;
			  }
			  ?>
			  <tr>
			    <th>&nbsp;</th>
				<th>&nbsp;</th>
				<th align="center" valign="top"><? printf("%0.2f", $totIssue)?></th>
				<th align="center" valign="top"><? printf ("%0.2f", $totRefund)?></th>
				<th align="center" valign="top"><? printf ("%0.2f", $totBal);?></th>
				<th align="center" valign="top">&nbsp;</th>
			  </tr>
			</table>
		</div>
		
	
	</div>	

<?
require($rpath."footer.tmp.php");
?>