<?
require ("../../config/setup.inc");


$id=$_REQUEST['count'];
$empCode=$_REQUEST['ecode'];
$levID=$_REQUEST['lvID'];
$mnth=$_REQUEST['mnth'];
$yr=$_REQUEST['yr'];

$mRes=$obj->select("empmaster", "empCode='$empCode'");
$mFres=$obj->fetchrow($mRes);
$c=count($id);
//print $c;
if($c>0){
	$fdt=$_REQUEST['fdt'];
	$tdt=$_REQUEST['tdt'];
	
	

	$dayCount=$_REQUEST['no'];
	
	//print $fdt[1];

	for($i=0; $i<$c; $i++){
		
		if($dayCount[$i]>1){
			$fdtExpld=explode("-", $fdt[$i]);
			$tdtExpld=explode("-", $tdt[$i]);
			for($j=$fdtExpld[2]; $j<=$tdtExpld[2]; $j++){
				$day=sprintf("%02d", $j);
				$dt=$tdtExpld[0]."-".$tdtExpld[1]."-".$day;
				
				$fld="`levID`, `empCode`, `qty`, `levDate`, `levMonth`, `levYear`";
				$val="$levID, '$empCode', '1', '$dt', '$fdtExpld[1]','$fdtExpld[0]'";
				
				$insRes=$obj->insert("attnlevdet", $fld, $val);
			}
			
		}else if($dayCount[$i]==1){
		
				$fdtExpld=explode("-", $fdt[$i]);
				$fld="`levID`, `empCode`, `qty`, `levDate`, `levMonth`, `levYear`";
				$val="$levID, '$empCode', '1', '$fdt[$i]', '$fdtExpld[1]','$fdtExpld[0]'";
				
				$insRes=$obj->insert("attnlevdet", $fld, $val);
		}
		
		
	}


}

print $set->JSORedirect("lvIndex?dept=$mFres[12]&mnth=$mnth&yr=$yr");
print $set->JSClose();