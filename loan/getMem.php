<?php
error_reporting(E_ALL);
require ("../config/setup.inc");
$q=$_REQUEST['q'];
$t=$_REQUEST['t'];
?>
<style type="text/css">
	body,td,div{
		font-family:verdana;
		font-size:9pt;
	}
	.divLine{
		display: table;
		padding:3px;
		border-bottom: dotted 1px #666666;
	}
	.divLine ul li{
		list-style: none;
		
	}
	.divLine ul li:focus{
		background-color:#999999;
		color:#FFFFFF;
	}
	.divLine ul li:hover{
		background-color:#999999;
		color:#FFFFFF;
		cursor:pointer;
	}
	.divLine ul li #list1{
		background-color:#999999;
		color:#FFFFFF;
		cursor:pointer;
		
	}
	
	.divCell{
		float:left;
		padding:2px;
	}	
</style>
<script type="text/javascript">
	
	
</script>
<!-- <div class="divLine" style="text-align: right"><input type="button" name="bcls" value="Confirm" onclick="closeList();"></div>-->
<?
if ($t==1){
	$res=$obj->select("membermast", "memNo = '$q' order by memNo");
}elseif ($t==2){
	$res=$obj->select("membermast", "Name like '$q%' order by memNo");
}elseif ($t==3){
	$res=$obj->select("membermast", "EmpID like '$q%' order by EmpID");
}elseif ($t==4){

	$res=$obj->select("membermast", "Mobile like '$q%' order by Mobile");
}else {
	$res=$obj->select("membermast", "chainNo like '$q%' order by memNo");
}

$rows=$obj->rows($res);


if ($rows>1){
	while($fres=$obj->fetchrow($res)){
?>	
	<div class="detLine" onclick="goDet('<?= $fres[1]?>', 1);">
		<div style="width:10%;" class="divCell"><?= $fres[1]?></div>
		<div style="width:20%;" class="divCell"><?= $fres[2]?></div>
		<div style="width:15%" class="divCell"><?= $fres[3]?></div>
		<div style="width:15%" class="divCell"><?= $fres[12]?></div>
	</div>	
	
<?	
	}
}elseif ($rows<1){

	echo "
	<div class=\"detLine\" style=\"color:#FF0000;\">
		<h2>Sorry no record is found </h2>
	
	
	</div>
	
	
	";

}else{

	
	$fres=$obj->fetchrow($res);	
	
	$getLERes=$obj->select("loanmem", "memNo='$fres[1]' and loanID=1");
	$getLERows=$obj->rows($getLERes);
	
	if ($getLERows > 0){
		$lnRes=$obj->select("loanmaster", "loanID <>2 order by loanID");
	}else{
	
		$lnRes=$obj->select("loanmaster order by loanID");
	}
	
	
	$totPgdf=$obj->sumfield("mempgdf", "tfund", "memNo='$fres[1]'");
	
	$confRes=$obj->select("configuration", "Active=1");
	$confFres=$obj->Fetchrow($confRes);
	
?>
<div class="divLine"><div class="divCell" style="width:35%;">Member's Name : <?= $fres[2]?> [<?= $fres[1] ?>]</div><div class="divCell" style="width:40%; font-weight:bold;">Current PGDF Value: Rs. <?= sprintf("%0.2f", $totPgdf);?></div></div>
<div class="detLine" style="text-align:center; font-size:13pt; font-weight:bold; background-color:#B0B0B0">
		<div class="divCell" style="width:20%;">Loan Name</div>
		<div class="divCell" style="width:15%;">Issued Amount</div>
		<div class="divCell" style="width:10%;">Balance Amount</div>
		<div class="divCell" style="width:10%;">20% Amount</div>
		<div class="divCell" style="width:10%;">To Pay</div>
		<div class="divCell" style="width:10%;">Shares</div>
		<div class="divCell" style="width:10%;">Status</div>
		
		
	</div>

<?

		while ($lnFres=$obj->fetchrow($lnRes)){
			
			$detRes=$obj->select("loanmem", "memNo='$fres[1]' and endFlg=1 and loanID=$lnFres[0]");
			$detRows=$obj->rows($detRes);
			
			/*while ($lnFres[0]=='1'){
				$splamt=detFres[9];
				}
			while ($lnFres[0]=='2'){
				$olamt=detFres[9];
				}
			while ($lnFres[0]=='3'){
				$uglamt=detFres[9];
				}
			while ($lnFres[0]=='4'){
				$tlamt=detFres[9];
				}
			while ($lnFres[0]=='5'){
				$emgamt=detFres[9];
				}*/
			$shrSum=$obj->sumfield("memshare", "shareNo", "memNo='$fres[1]' and loanID=$lnFres[0]");
			$shrValue=($shrSum * $confFres[2]);
			/*if( $splamt>$olamt : $uglamt : $tlamt : $emgamt){				
						$splshr=$splamt/10;
						$shrVal=$shrValue+$splshr;
					} else{
							$shrVal= $shrValue;
						}*/
			
			$detFres=$obj->fetchrow($detRes);
			
			$totIssue=0.00;
			$totBal=0.00;
			$totElg=0.00;
			$totPay=0.00;
			for($t=1;$t<6;$t++){
					$totRes=$obj->select("loanmem", "memNo='$fres[1]' and endFlg=1 and loanID='$t'");
					$totRows=$obj->rows($totRes);
					$totfres=$obj->fetchrow($totRes);
					$totIssue=$totIssue+$totfres[8];
					
					$bal= $totfres[8]-$totfres[19];
					$totBal=$totBal+$bal;
					
					$elg=$totfres[8] * 0.20;
					$totElg=$totElg+$elg;
					
					if ($totfres[19]>$elg){
							$tPay=0;
						}else{
							$tPay=$elg-$totfres[19];
							}
					$totPay=$totPay+$tPay;
			}
			
			
			$paidAmnt=$obj->sumfield("loanrepaylist","amount", "LmID=$detFres[0]");
			$totRefund=$paidAmnt + $detFres[19];
			
			$balAmount=$detFres[9] - $totRefund;
			
			$elgAmnt=$detFres[8] * 0.20;
			
			$toPay=($totRefund >= $elgAmnt) ? 0 : ($elgAmnt - $totRefund);
			
			
			$loanDfltChkRes=$obj->select("loandefault", "memNo='$fres[1]' and endFlg=0");
			$loanDfltChkRows=$obj->rows($loanDfltChkRes);
			
			$pgDfltChkRes=$obj->select("pgdfdefault", "memNo='$fres[1]' and endFlg=0");
			$pgDfltChkRows=$obj->rows($pgDfltChkRes);
			
			$attr= ($loanDfltChkRows > 0 || $pgDfltChkRows> 0) ? "Defaulter" : "Active";
			
			
			
			
?>
	<div class="detLine" style="text-align:center;">
		<div class="divCell" style="width:20%;"><?= $lnFres[1]?></div>
		<div class="divCell" style="width:15%;"><?= $detFres[8]?></div>
		<div class="divCell" style="width:10%;cursor:pointer;" onclick="navigate('payLoan?id=<?= $detFres[0]?>');"><?= sprintf("%0.2f",$balAmount)?></div>
		<div class="divCell" style="width:10%;"><?= sprintf("%0.2f",$elgAmnt)?></div>
		<?
		if ($toPay > 0){
		?>
		<div class="divCell" style="width:10%; cursor:pointer;" onclick="navigate('payBalance?id=<?= $detFres[0]?>');"><?= sprintf("%0.2f",$toPay)?></div>
		<?
		}else{
		?>
		<div class="divCell" style="width:10%; cursor:pointer;" ><?= sprintf("%0.2f",$toPay)?></div>
		<?
		}
		?>
		<div class="divCell" style="width:10%;"><?= sprintf("%0.2f", $shrValue)?></div>
		<div class="divCell" style="width:10%;"><?= $attr?></div>
		<? if ($attr=="Active" && $toPay < 1){ ?>
		<div class="divCell" style="width:10%;"><input type="button" class="btClass" value="Apply" onclick="navigate('preGen?lid=<?= $lnFres[0]?>&mno=<?= $fres[1]?>');" /></div>
		
		<? }else{?>
		<div class="divCell" style="width:10%;"><input type="button" class="btClass" value="Locked"  /></div>
		<? }?>
	</div>
	
<?		

			

	}
}
?>

<? if ($rows>0){ ?>
		<div class="detLine" style="text-align:center; font-size:13pt; font-weight:bold; background-color:#B0B0B0">
			<div class="divCell" style="width:20%;">Total</div>
			<div class="divCell" style="width:15%;"><?= sprintf("%0.2f",$totIssue)?></div>
			<div class="divCell" style="width:10%;"><?= sprintf("%0.2f",$totBal)?></div>
			<div class="divCell" style="width:10%;"><?= sprintf("%0.2f",$totElg)?></div>
			<div class="divCell" style="width:10%;"><?= sprintf("%0.2f",$totPay)?></div>
		<? }?>
							
	</div>
