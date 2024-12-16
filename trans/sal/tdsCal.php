<?

require ("../../config/setup.inc");

$q=$_REQUEST['q'];

$totQ=round($q*12);

$tdsMstRes=$obj->select("tdsmaster", "slabHigh >='$totQ' and slabLow <='$totQ'");
$tdsMstFres=$obj->fetchrow($tdsMstRes);

$remain=round($totQ-$tdsMstFres[1]);

$s=round((($remain*$tdsMstFres[3])/100)/12);


echo $s;
?>