<?
require ("../../config/setup.inc");


$mn=$_REQUEST['mn'];



$res=$obj->Select("loanmem", "memNo='$mn' and endFlg=0");
while ($fres=$obj->fetchrow($res)){
	

?>
<div class="divLine" style="font-weight: bold; ">
	<div class="divCell" style="width:33%;  text-align: center;">Loan A/C No.</div>
	<div class="divCell" style="width:33%;  text-align: center;">Issue Amount</div>
	<div class="divCell" style="width:33%;  text-align: right;">Monthly Principal</div>
</div>
<div class="divLine">
	<div class="divCell" style="width:33%; text-align:center;"><?= $fres[1]?></div>
	<div class="divCell" style="width:33%; text-align:center;"><?= $fres[8] ?></div>
	<div class="divCell" style="width:33%; text-align: right;"><?= sprintf("%0.2f",$fres[18])?></div>
</div>
<?
}
?>