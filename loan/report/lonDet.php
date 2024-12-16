<?php
set_time_limit (3600);
require ("../../config/setup.inc");


$lnID=$_REQUEST['lnID'];
$title="Uptodate Loan Report";
require($rpath."pageDesign.tmp.php");

$lmt=40;

$lnRes=$obj->select("loanmaster","loanID=$lnID order by loanID");
$lnFres=$obj->Fetchrow($lnRes);

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
		<h2><?= $lnFres[1]?> Details</h2>
		<table width="100%" border="0" cellspacing="0" cellpadding="3">
		  
		  <?
		  		$r=0;
		  		$mlRes=$obj->select("loanmem", "loanID=$lnID and endFlg=1");
				while ($mlFres=$obj->fetchrow($mlRes)){
				
					$grsIssue=$grsIssue+$mlFres[8];
					$sumRefund=$obj->sumfield("loanrepaylist", "amount", "LmID=$mlFres[0]");
					$sumRefund=($sumRefund) ? $sumRefund : 0;
					$grsRefund=$grsRefund+$mlFres[19]+$sumRefund;
				
					$netRefund=$mlFres[19]+$sumRefund;
				
					$blnAmount=$mlFres[8] - $netRefund;
					
					$memRes=$obj->select("membermast", "memNo='$mlFres[3]'");
					$memFres=$obj->fetchrow($memRes);
					
					$s++;
				
					if ($r%$lmt==0 || $r==0){
						?>
						
					<tr>
						<th align="center" valign="top">Sl. No. </th>
						<th align="center" valign="top">Account No. </th>
						<th align="center" valign="top">Members Name </th>
						<th align="center" valign="top">Issued Amount </th>
						<th align="center" valign="top">Refunded Amount</th>
						<th align="center" valign="top">Balance Amount </th>
					  </tr>
						
						
						<?
					
					
					
					}
		  
		  ?>
		  
		  
		  <tr >
		    <td align="center" valign="top"><?= $s?></td>
			<td align="left" valign="top"><?= sprintf("%04s",$mlFres[3])?></td>
			<td align="left" valign="top"><?= $memFres[2]?></td>
			<td align="center" valign="top"><? printf("%0.2f", $mlFres[8])?></td>
			<td align="center" valign="top"><? printf ("%0.2f", $netRefund)?></td>
			<td align="center" valign="top"><? printf ("%0.2f", $blnAmount);?></td>
		  </tr>
		  <?
		  
		  			$totIssue=$totIssue+$mlFres[8];
					$totRefund=$totRefund+$netRefund;
					$totBal=$totBal+$blnAmount;
					
					$r++;
				
				}
		  
		  ?>
		  <tr>
		    <th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>Total</th>
			<th align="center" valign="top"><? printf("%0.2f", $totIssue)?></th>
			<th align="center" valign="top"><? printf ("%0.2f", $totRefund)?></th>
			<th align="center" valign="top"><? printf ("%0.2f", $totBal);?></th>
		  </tr>
		</table>

		
	
	</div>	

<?
require($rpath."footer.tmp.php");
?>