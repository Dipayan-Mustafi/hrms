<?
require ("../../config/setup.inc");

$s=$_REQUEST['s'];
$e=$_REQUEST['e'];

if($e){
		
		$sExpld=explode("-", $s);
		$eExpld=explode("-", $e);
		
		$val=(int)$eExpld[2]-(int)$sExpld[2]+1;

}elseif($s){
	$val=1;
}else{
	$val=0;
}

echo $val;
