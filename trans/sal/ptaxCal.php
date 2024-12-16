<?

require ("../../config/setup.inc");

$pt=$_REQUEST['pt'];
if($pt<2){
	$q=$_REQUEST['q'];
	
	$ptMstRes=$obj->select("ptmaster", "slabHigh >=$q and slabLow <=$q");
	$ptMstFres=$obj->fetchrow($ptMstRes);
	
	
	$s=($ptMstFres[3]) ? $ptMstFres[3] : 0;
}else{
	$s=0;
}
echo $s;
?>