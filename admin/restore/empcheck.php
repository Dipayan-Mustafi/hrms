<?
error_reporting(E_ALL);

set_time_limit(3600);
require ("../../config/setup.inc");

/*$fyr=$misc->currentfinyear(date('y'), date('m'));

$cdt=date('Y-m-d');
*/


$res=$obj->select("`table 22`");
while($fres=$obj->fetchrow($res)){
	$empRes=$obj->select("empmaster", "empCode='$fres[0]'");
	$empFres=$obj->fetchrow($empRes);

	$chkres=$obj->select("empmaster", "empCode='$fres[0]' and empDept='$empFres[12]'");
	$chkrows=$obj->rows($chkres);
	$chkfres=$obj->fetchrow($chkres);
	
	if($chkrows > 0){
	 	$salDate=explode("-", $chkfres[10]);
	 	
		if($salDate[1] <= 11){
	 		$rmks= "ok";
	 	}else{
	 		$rmks= "date";
		}
	 }else{
	 	$rmks= "not found";
		}
	$mem=$fres[0];	
	print $mem;
	print "------";
	print $rmks;
	print "<br/>";
	
	/*$epfCal=$fres[3]*.12;
	$expd=explode(".", $epfCal);
	
	$epf=$expd[0];
	if($expd[1]>0){
		$epf++;
		}
		
	$epfRound=round($epfCal);
	
	$tot=$tot+$epf;
	$totRound=$totRound+$epfRound;
	print $tot;
	print "-------";
	print $totRound;
	print "<br/>";*/
	}
	
	
	
?>