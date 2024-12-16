<?php
require ("../../config/setup.inc");

$lid=$_REQUEST['id'];
$dt=$_REQUEST['dt'];

$getRes=$obj->select("loanmem", "LmID=$lid[0]");
$getFres=$obj->fetchrow($getRes);

$memRes=$obj->select("membermaster", "memNo='$getFres[3]'");
$memFres=$obj->fetchrow($memRes);

$chqName=($memFres[27]) ? $memFres[27] : $memFres[2];


$count=count($id);

for ($i=0; $i < $count; $i++){
	
	$lmRes=$obj->select("loanmem", "LmID=$lid[$i]");
	$lmFres=$obj->FetchRow($lmRes);
	
	$totAmount=$totAmount+$lmFres[9];
	
}


?>
<style type="text/css">

#chqDiv{
	
}


	
</style>
<script type="text/javascript">

function PrintDiv(d, t) {    
    var divToPrint = document.getElementById(d);
    var popupWin = window.open('', '_blank', 'width=300,height=300');
    popupWin.document.open();
    popupWin.document.write('<html><title>'+t+'</title><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
    popupWin.document.close();
}

</script>
<div style="text-align:right"><input name="bprnt" type="button" value="Print&gt;&gt;" onclick="PrintDiv('chqDiv', 'Cheque Print');" /></div>
<div id="chqDiv" style="widht:203mm; height:99mm; margin-top:5pt;">
<style type="text/css">
#chqDt{
	margin-left:152mm;
	width:39mm;
	display:block;
	letter-spacing: 1mm;
	font-size:10pt;
	font-family:arial;
	margin-top:1mm;
	font-weight:bold;
}
#chqName{
	margin-left:20mm;
	margin-top:5mm;
	font-family: arial;
	font-size:10pt;
	width: 142mm;
	display:block;
	
}
#chqWords{
	width: 167mm;
	margin-left:30mm;
	margin-top:2mm;
	font-family: arial;
	font-size:10pt;
	display:block;
	
}
#chqAmount{
	margin-left: 155mm;
	width:40mm;
	font-family:arial;
	font-size:10pt;
	text-align: left;
	display:block;
	
}

</style>
	<div id="chqDt"><?= $dt?></div>
	<div id="chqName"><?= $chqName?></div>
	<div id="chqWords"><?= convert_number($totAmount)?> only</div>
	<div id="chqAmount"><?= number_format($totAmount,2);?> </div>
</div>
