<?
error_reporting(E_ALL);

set_time_limit(3600);
require ("../../config/setup.inc");
require ($root."lib/datetime/datetimepicker_css_js.php");

$eman=new empManagement();

$fyr="15-16";
$basicStrng="Basic";
$hraStrng="House Rent Allowance";
$waStrng="Washinig Allowance";
$ptaxStrng="Professional Tax";
$esiStrng="ESI Deduction";
$pfStrng="EPF Deduction";
$tdsStrg="TDS Deduction";
$advStrng="Advance Deduction";

$cby=1;

$configRes=$obj->select("salconfig");
$configFres=$obj->fetchrow($configRes);

$res=$obj->select("`table 32`");

while ($fres=$obj->fetchrow($res)){
	$empRes=$obj->select("empmaster", "empCode='$fres[1]'");
	$empFres=$obj->fetchrow($empRes);
	$empRows=$obj->rows($empRes);
	//print "me";

	if($empRows>0){
		//if($empFres[12]>2){
	
			$basic=$fres[4];
			
			$pfcc=($basic*$configFres[5])/100;
			$epsCC=($basic*$configFres[7])/100;
			$pfAdmin=($basic*$configFres[6])/100;
			$edlicc=($basic*$configFres[9])/100;
			$edliAdmin=($basic*$configFres[10])/100;
			
			$totAmnt=$basic+$fres[5]+$fres[6];
			
			$dept=$empFres[12];
			
			$yr=$fres[13];
		
			
			$insRes=$obj->update("empmaster", "basicPay='$fres[3]'", "empCode='$fres[1]'");
			
			
			
			$slmnth=sprintf("%02d", $fres[12]);
			
			
			
			
						
			$nmnth=($slmnth=="12") ? "01" : sprintf("%02d", ($slmnth+1));
			$nYear=($slmnth=="12") ? ($yr+1) : $yr;
			$d=cal_days_in_month(CAL_GREGORIAN,"$slmnth","$yr");
			
			$cdt=$yr."-".$slmnth."-".$d;
			$sdt=$nYear."-".$nmnth."-07";
			
			//print $cdt;
			
			
			//print $fres[1].",". $dept.",". $slmnth.", ".$yr.",". $fyr.",1,". $fres[4].",". $cdt.",". $cby.",".$basicStrng.",". $sdt;
			//actualpay
			$basicIns=$eman->insSalDet($fres[1], $dept, $slmnth, $yr, $fyr, 1, $fres[4], $cdt, $cby, $basicStrng, $sdt);
			
			//print_r($basicIns);
			
			//proffesional tax
			if($fres[7] > 0){
				
				$ptaxIns=$eman->insSalDet($fres[1], $dept, $slmnth, $yr, $fyr, 1, $fres[7], $cdt, $cby, $ptaxStrng, $sdt);
			}
			
			
			
			
			if($fres[8]>0){
				//epf
				$pfecIns=$eman->insSalDet($fres[1], $dept, $slmnth, $yr, $fyr, 1, $fres[8], $cdt, $cby, $pfStrng, $sdt);
				
			}
			
			
			
			//esi
			if($fres[9]>0){
				$esiIns=$eman->insSalDet($fres[1], $dept, $slmnth, $yr, $fyr, 1, $fres[9], $cdt, $cby, $esiStrng, $sdt);
			}
			
			
			
			
			
			//hra
			if($fres[5]>0){
			
				$hraIns=$eman->insSalDet($fres[1], $dept, $slmnth, $yr, $fyr, 1, $fres[5], $cdt, $cby, $hraStrng, $sdt);
				
			}
			
			
			
			
			//wa
			if($fres[6]>0){
			
				$waIns=$eman->insSalDet($fres[1], $dept, $slmnth, $yr, $fyr, 1, $fres[6], $cdt, $cby, $waStrng, $sdt);
				
			}
			
			$mnthCompCont=$eman->insMnthCont($fres[1], $totAmnt, $slmnth, $yr, $fyr, $fres[11], $pfcc, $epsCC, $pfAdmin, $edlicc, $edliAdmin, $cdt, $cby);
			
			
			
			$hday=0;
			for ($i=1 ; $i<=$d; $i++){
				$mdt=sprintf("%02d",$i);
				$wkd=date('w', mktime(0,0,0,$slmnth,$mdt,$yr));
				if ($wkd==0){
					$hday++;
				}
		
			}
			
			$totDays=$d-$hday;
			$lwp=$d-$fres[2];
			
			$prsnt=$totDays-$lwp;
			
			
			$attndt=$yr."-".$slmnth."-".$d;
			
			$attnfld="empCode, attnDate, twDays, prsnt, inTime, lwp, inLate, attnMonth, attnYear";
			$attnval="'$fres[1]', '$attndt', '$totDays', '$prsnt', '$prsnt', '$lwp', 0, '$slmnth', $yr";
			
			
				$leaveRes=$obj->chkinsert("attendancedet", "empCode='$fres[1]' and attnMonth='$slmnth'", $attnfld,$attnval);
			
			
			print "<div>".$fres[1]."</div>";
			print "<div>Insertion Done</div>";
		//}		
	}else{
			print "<div><strong>not found</strong></div>";
			print $fres[1];
			print "<br/>";
		}
}





?>