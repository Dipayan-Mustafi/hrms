<?php
//error_reporting(E_ALL);
set_time_limit(3600);
require ("../config/setup.inc");

require ($root."lib/loan/Class.DemandManager.php");

$dmn=new DemandMan();

$mnth=$_REQUEST['mnth'];
$yr=$_REQUEST['yr'];

$area=$_REQUEST['area'];
$dt=$_REQUEST['dt'];
$shtYr=substr($yr, 2,2);

$fyr=$misc->CurrentFinYear($shtYr, $mnth);

$count=count($area);

global $qry;


print "<div class='contDiv' style='background-image:url(".$rurl."images/loadinfo.gif); background-attachment:fixed; background-repeat:no-repeat;'>";
$lastCode=$obj->lastID("demandmast", "demandIndex", "demandMonth='$mnth' and demandYear=$yr and finYear='$fyr'");
$lastCode++;
$dmnd="D/$mnth$yr/".sprintf("%04d", $lastCode)."/$fyr";


for ($i=0; $i < $count; $i++){

	$mstRes=$obj->Select("membermast", "officeID=$area[$i] and memTyp<3");
	$mstRows=$obj->rows($mstRes);

	while ($mstFres=$obj->FetchRow($mstRes)) {
	
		print "<div>$mstFres[1] - $mstFres[2] - $dmnd</div>";
	
		
	
	
		$dres=$dmn->genDemand($mstFres[1], $dmnd, $mnth, $yr, $dt[0], $dt[1]);
		$lres=$dmn->getLoan($mstFres[1], $dmnd, $mnth, $yr, $dt[0], $dt[1]);
	
		print "<div>$dres</div>";
		print "<div>$lres</div>";
		
	}
	if ($i==0){
		
		$qry.="area[]=$area[$i]";
	}else{
		$qry.="&area[]=$area[$i]";
	}
	
}

$qry.="&mnth=$mnth&yr=$yr";


print $set->JSORedirect("viewDemand?$qry");
print $set->JSClose();
print "</div>";
?>