<?

require ("../../config/setup.inc");

$basic=$_REQUEST['q'];
$pf=$_REQUEST['pf'];
if($pf<2){
	$configRes=$obj->select("salconfig");
	$configFres=$obj->fetchrow($configRes);
	
	$pfcc=($basic*$configFres[5])/100;
	$epsCC=($basic*$configFres[7])/100;
	$pfAdmin=($basic*$configFres[6])/100;
	$edlicc=($basic*$configFres[9])/100;
	$edliAdmin=($basic*$configFres[10])/100;
	
	$mnthPfCc=round($pfcc+$epsCC+$pfAdmin+$edlicc+$edliAdmin);
}else{
	$mnthPfCc=0;
}
echo $mnthPfCc;
?>