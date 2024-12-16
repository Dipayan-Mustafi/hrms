<?php
error_reporting(E_ERROR);
set_time_limit(3600);

require ("../config/setup.inc");

$title="Demand recieve";

require($rpath."pageDesign.tmp.php");


require($root."lib/loan/Class.DemandManager.php");

$dman=new DemandMan();

$mnth=$_REQUEST['mnth'];
$yr=$_REQUEST['yr'];
$area=$_REQUEST['area'];

$n=intval($mnth);


$mnArray=array("", "January","February","March","April","May","June","July","August","September", "October", "November", "December");
$count=count($area);
for ($i=0; $i < $count; $i++){
	
	if ($i==0){
		$qry.="area[]=$area[$i]";
	}else{
		$qry.="&area[]=$area[$i]";
	}

}

?>

<script type="text/javascript">
function goBack(){
  window.location="preRcv";
}


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

<div class="contDiv">
<div id="detButton">
  <input type="button" value="Back" onclick="goBack();" accesskey="B"></div>

<?
$count=count($area);



for ($i=0; $i < $count; $i++){
	
	$ofRes=$obj->select("officemaster", "officeID=$area[$i]");
	$ofFres=$obj->fetchrow($ofRes);
	
	
	
	
	$disRes=$obj->distinct("demandmast", "ddoCode", "officeID=$area[$i] and demandMonth='$mnth' and demandYear='$yr'");
	
	while ($disFres=$obj->FetchRow($disRes)){

		$secRes=$obj->select("secmaster", "secID=$disFres[0]");
		$secFres=$obj->fetchrow($secRes);
		
		$ddetRes=$obj->select("demandmast", "demandMonth='$mnth' and demandYear='$yr'");
		$ddetFres=$obj->fetchrow($ddetRes);
		
		
		
	
?>
<form name="form1" method="post" action="rcvBack">
		<table border="1" style="width:295mm; page-break-after:always; font-family:times; font-size:9pt;" cellpadding="3" cellspacing="0" >
			<tr>
				<th colspan="21" valign="top" align="left">	<?= $company['info']['name'];?><br>
				(Registered Under The Bengal Co-operative Societies Act, 1940)<br />
				<?= $company['info']['address'];?>, <?= $company['info']['city'];?> - <?= $company['info']['zip'];?><br />
				Recovery Sheet for <?= $mnArray[$n]?>, <?= $yr?>, Period <?= $misc->dateformat($ddetFres[31]);?> TO <?= $misc->dateformat($ddetFres[32]);?>			</th>	
			</tr>

			<tr>
			  <th valign="top" align="center" colspan="21">
				<div class="divCell" style="width:30mm;">Business Area </div><div class="divCell" style="width:60mm;"><?= $ofFres[1]?></div>
				<div class="divCell" style="width:25mm;">Unit</div><div class="divCell" style="width:50mm;"><?= $secFres[1]?></div>
				Bank Name<select name="bank" id="bank">
				<option>--</option>
				<?
				$bnkRes=$obj->select("bankmast order by bankName");
				while ($bnkFres=$obj->fetchrow($bnkRes)){
					print "<option>$bnkFres[1]</option>";
				}
				?>
				</select>				
				Cheque Number: <input name="chq" type="text" id="chq" size="10">			  </th>
			</tr>		
		<tr>
			<th valign="top" align="center">Sl NO.</th>
			<th valign="top" align="center">Memb. No.</th>
			<th valign="top" align="center">Name</th>
			<th valign="top" align="center">HR No.</th>
			<th valign="top" align="center">P.D.G.F.</th>
			<th valign="top" align="center">D.B.F</th>
			
			
			<?
			$lcatRes=$obj->select("loanmaster order by loanID");
			while ($lcatFres=$obj->FetchRow($lcatRes)){
			?> 
			<th valign="top" align="center"><?= $lcatFres[1]?></th>
			<?
			}
			?>
			
			<th valign="top" align="center">R.D.</th>
			<th valign="top" align="center">Arear Interest</th>
			<th valign="top" align="center">Total</th>
		    <th valign="top" align="center">Action</th>
		</tr>
		<?php
		$mdRes=$obj->distinct("demandmast", "memNo", "ddoCode=$disFres[0] and endFlg=0");
		$mdRows=$obj->rows($mdRes);
		
		
		while($mdFres=$obj->fetchrow($mdRes)){
			$s++;
			
			
			
			$memRes=$obj->select("membermast", "memNo='$mdFres[1]'");
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
			
			$memTot=$dmdFres[5]+$dmdFres[7]+$dmdFres[9]+$dbf;
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
			<td valign="top" align="center"><?= sprintf("%0.2f", $sumPrin);?><br><?= sprintf("%0.2f", $sumInt);?></td>
			<?
			}
			?>
			
			
			<td valign="top" align="center"><?= $dmdFres[9]?></td>
			<td valign="top" align="center"><?= $dmdFres[9]?></td>
			<td valign="top" align="center"><?= sprintf("%0.2f", $memTot)?></td>
		    <td valign="top" align="left" width="2"><input type="button" name="rcvOne" value="recive" onclick="navigate('rcvOne?mnth=<?= $dmdFres[17]?>&amp;yr=<?= $dmdFres[18]?>&amp;memno=<?= $dmdFres[1]?>');" /></td>
		</tr>

		<?php 
			$secTot=$secTot+$memTot;
			$memTot=0;
			
			unset ($attr);
		
		}
		
		
		?>
		</table>		
		
</form>


<?php 
		$s=0;
		unset($totBalance);
		unset($secDBF);
		unset ($totloan);
		unset ($totInt);
		unset ($secPGDF);
		unset ($secRD);
		unset ($secTot);
	}
}

?>



</div>


