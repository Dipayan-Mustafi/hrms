<?php
error_reporting(E_ERROR);
set_time_limit(3600);
require ("../config/setup.inc");

$title="Demand Preview";




require($root."lib/loan/Class.DemandManager.php");

$dman=new DemandMan();

$mnth=$_REQUEST['m'];
$yr=$_REQUEST['y'];
$area=$_REQUEST['area'];

$n=intval($mnth);


$mnArray=array("", "January","February","March","April","May","June","July","August","September", "October", "November", "December");

$count=count($area);

for ($a=0; $a < $count; $a++){
	
	$ara .= "$area[$a], ";
}


?>
<title>Demand for <?= $mnArray[$n]?>, <?= $yr?> for <?= $ara?></title>
<script type="text/javascript">
window.onload=function(){
	self.print();

};
</script>
 <style type="text/css" media="screen">
   #detButton {text-align:right;}
 </style>




<style type='text/css'>
 .ddhead { width:375mm; padding:5px; display:table; font-weight:bold; font-family:arial; font-size:13px;}
 .rowHead {width:375mm; display:table; font-family:arial; font-size:13px; border:solid 1px #666666; border-left:none; border-right:none;}
 .rowFoot {width:375mm; display:table; font-family:arial; font-size:13px; border:solid 1px #666666; border-left:none; border-right:none;page-break-after:always}
 .divCell { float:left}

</style>

<center>
  <?




for ($i=0; $i < $count; $i++){
	
	
	$ofRes=$obj->select("officemaster", "officeID=$area[$i]");
	$ofFres=$obj->fetchrow($ofRes);
	
	
	
	$disRes=$obj->distinct("demandmast", "ddoCode", "officeID=$area[$i]");
	
	while ($disFres=$obj->FetchRow($disRes)){
		
		$secRes=$obj->select("secmaster", "secID=$disFres[0]");
		$secFres=$obj->fetchrow($secRes);
		
		$ddetRes=$obj->select("demandmast", "demandMonth='$mnth' and demandYear='$yr'");
		$ddetFres=$obj->fetchrow($ddetRes);
	
?>
  <table border="1" style="width:295mm; page-break-after:always; font-family:times; font-size:9pt;" cellpadding="3" cellspacing="0" >
    <tr>
      <th colspan="22" valign="top" align="left"> <?= $company['info']['name'];?><br>
				(Registered Under The Bengal Co-operative Societies Act, 1940)<br />
				<?= $company['info']['address'];?>, <?= $company['info']['city'];?> - <?= $company['info']['zip'];?><br />
				Recovery Sheet for <?= $mnArray[$n]?>, <?= $yr?>, Period <?= $misc->dateformat($ddetFres[31]);?> TO <?= $misc->dateformat($ddetFres[32]);?>	</th>
    </tr>
    <tr>
      <th valign="top" align="center" colspan="22"> <div class="divCell" style="width:30mm;">Office </div>
          <div class="divCell" style="width:60mm;">
            <?= $ofFres[1]?>
          </div>
        <div class="divCell" style="width:30mm;">Unit</div>
        <div class="divCell" style="width:60mm;">
          <?= $secFres[1]?>
        </div></th>
    </tr>
    <tr>
      <th valign="top" align="center">Sl NO.</th>
      <th valign="top" align="center">Memb. No.</th>
      <th valign="top" align="center">Name</th>
      <th valign="top" align="center">HR No.</th>
      <th valign="top" align="center">P.D.G.F</th>
      <th valign="top" align="center">D.B.F</th>
      <?
			$lcatRes=$obj->select("loanmaster order by loanID");
			while ($lcatFres=$obj->FetchRow($lcatRes)){
			?>
      <th valign="top" align="center"><?= $lcatFres[1]?></th>
      <?
			}
			?>
      <?
			$lcatRes=$obj->select("loanmaster order by loanID");
			while ($lcatFres=$obj->FetchRow($lcatRes)){
			?>
      <th valign="top" align="center">Balance
        <?= $lcatFres[1]?></th>
      <? }?>
      <th valign="top" align="center">R.D.</th>
      <th valign="top" align="center">Arear Interest</th>
      <th valign="top" align="center">Total</th>
      <th valign="top" align="center">Remarks</th>
    </tr>
    <?php
		$mdRes=$obj->distinct("demandmast", "memNo", "ddoCode=$disFres[0]");
		$mdRows=$obj->rows($mdRes);
		
		
		while($mdFres=$obj->fetchrow($mdRes)){
			$s++;
			
			
			
			
			$memRes=$obj->select("membermast", "memNo='$mdFres[0]'");
			$memFres=$obj->fetchrow($memRes);
			
			$dsgID=($mdFres[4]) ? $mdFres[4] : 0;
			
			$dsgRes=$obj->select("desigmaster", "desigID=$dsgID");
			$dsgFres=$obj->fetchrow($dsgRes);
			
			$billCode=($memFres[16]) ? $memFres[16] : 0;
			
			$blRes=$obj->select("billmaster", "billID=$billCode");
			$blFres=$obj->Fetchrow($blRes);
			
			$blName=($blFres[1]) ? addslashes($blFres[1]) : "";
			
			
			$dmdRes=$obj->select("demandmast", "memNo='$mdFres[0]' and demandMonth='$mnth' and demandYear='$yr'");
			$dmdFres=$obj->fetchrow($dmdRes);
			
			$dbfRes=$obj->select("dbfmaster", "memNo='$mdFres[0]' and endFlg=0");
			$dbfFres=$obj->fetchrow($dbfRes);
			
			$dbf=($dbfFres[2]) ? $dbfFres[2]: 0;
			
		?>
    <tr>
      <td valign="top" align="center"><?= $s;?></td>
      <td valign="top" align="center"><?= $mdFres[0];?></td>
      <td valign="top" align="center"><?= $memFres[2]?></td>
      <td valign="top" align="center"><?= $memFres[3]?></td>
      <td valign="top" align="center"><?= $dmdFres[5]?></td>
      <td valign="top" align="center"><?= sprintf("%0.2f",$dbf)?></td>
      <?
			
			$memTot=$dmdFres[5]+$dmdFres[7]+$dmdFres[9];
			$secPDGF=$secPDGF+$dmdFres[5];
			$secDBF=$secDBF+$dmdFres[7];
			$secRD=$secRD+$dmdFres[9];
			$secDBF=$secDBF+$dbf;
			$lcatRes=$obj->select("loanmaster order by loanID");
			while ($lcatFres=$obj->FetchRow($lcatRes)){
				$t=$lcatFres[0];
				$sumPrin=$obj->sumfield("demandmast", "prinPay", "loanID=$lcatFres[0] and memNo='$mdFres[0]' and demandMonth='$mnth' and demandYear='$yr'");
				$sumInt=$obj->sumfield("demandmast", "intPay", "loanID=$lcatFres[0] and memNo='$mdFres[0]' and demandMonth='$mnth' and demandYear='$yr'");
				if ($sumPrin >0){
					
					$memTot=$memTot+$sumPrin;
					$totloan[$t]=$totloan[$t]+$sumPrin;
					
				}
				if ($sumInt > 0){
					
					$memTot=$memTot+$sumInt;
					$totInt[$t]=$totInt[$t]+$sumInt;
				}
				
			?>
      <td valign="top" align="center"><?= sprintf("%0.2f", $sumPrin);?>
          <br />
        <?= sprintf("%0.2f", $sumInt);?></td>
      <?
			}
			?>
      <?
			$lcatRes=$obj->select("loanmaster order by loanID");
			while ($lcatFres=$obj->FetchRow($lcatRes)){
				$t=$lcatFres[0];
				$sumBalance=$obj->sumfield("demandmast", "balanceAmount", "loanID=$lcatFres[0] and memNo='$mdFres[0]' and demandMonth='$mnth' and demandYear='$yr'");
				$sumInst=$obj->sumfield("demandmast", "installmentNo", "loanID=$lcatFres[0] and memNo='$mdFres[0]' and demandMonth='$mnth' and demandYear='$yr'") ;
				$totBal[$t]= $totBal[$t]+ $sumBalance;
				
			?>
      <td valign="top" align="center"><?= sprintf("%0.2f", $sumBalance)?>
          <br />
        <?= $sumInst?></td>
      <? }?>
      <?php 
			
			
			?>
      <td valign="top" align="center"><?= $dmdFres[7]?></td>
      <td valign="top" align="center"><?= $dmdFres[9]?></td>
      <td valign="top" align="center"><?= sprintf("%0.2f", $memTot)?></td>
      <td valign="top" align="center"><?
			$dfltRes=$obj->select("loandefault", "memNo='$mdFres[0]' and endFlg=0");
			$dfltRows=$obj->rows($dfltRes);
			
			$arRes=$obj->select("arearpaylist", "memNo='$mdFres[0]' and payHead='Arear Interest' and endFlg=0");
			$arRows=$obj->rows($arRes);
			
			$attr=($dfltRows > 0) ? $dfltRows : "-";
			if ($arRows > 0){
				if (strlen($attr) > 1){
					$attr.="<br>Arear Interest Realised";
				}else{
					$attr.="Arear Interest Realised";
				}
			}
			
			print $attr;
			
			?></td>
    </tr>
    <?php 
			$secTot=$secTot+$memTot;
			$memTot=0;
			
			
		
		}
		
		
		?>
    <tr>
      <th valign="top" align="center">&nbsp;</th>
      <th valign="top" align="center">&nbsp;</th>
      <th valign="top" align="center">Total</th>
      <th valign="top" align="center">&nbsp;</th>
      <th valign="top" align="center"><? printf("%0.2f", $secPDGF)?></th>
      <th valign="top" align="center"><? printf("%0.2f", $secDBF)?></th>
      <?
			$lcatRes=$obj->select("loanmaster order by loanID");
			while ($lcatFres=$obj->FetchRow($lcatRes)){
				$t= $lcatFres[0];
			?>
      <th valign="top" align="center"><?= sprintf("%0.2f",$totloan[$t])?>
          <br />
        <?= sprintf("%0.2f",$totInt[$t])?></th>
      <?
			}
			?>
      <?
			$lcatRes=$obj->select("loanmaster order by loanID");
			while ($lcatFres=$obj->FetchRow($lcatRes)){
				$t= $lcatFres[0];
			?>
      <th valign="top" align="center"><?= sprintf("%0.2f",$totBal[$t] )?></th>
      <? }?>
      <th valign="top" align="center"><?= sprintf("%0.2f", $secRD)?></th>
      <th valign="top" align="center"><?= sprintf("%0.2f", $secDBF)?></th>
      <th valign="top" align="center"><?= sprintf("%0.2f", $secTot)?></th>
      <th valign="top" align="center">&nbsp;</th>
    </tr>
  </table>
  <?php 
		$s=0;
		unset($totBal);
		unset($secDBF);
		unset ($secTot);
		unset($secRD);
		unset ($totloan);
		unset ($totInt);
		unset($secPDGF);
	}
}

?>



</center>


