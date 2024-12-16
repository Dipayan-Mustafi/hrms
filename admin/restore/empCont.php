<?
error_reporting(E_ALL);

set_time_limit(3600);
require ("../../config/setup.inc");

$disRes=$obj->distinct("`table 30`", "ofc", "sl>0");
//print_r($disRes);
while($disFres=$obj->fetchrow($disRes)){

print "<strong>$disFres[0]</strong><br/>";
	$res=$obj->select("`table 30`", "ofc=$disFres[0]");
	while($fres=$obj->fetchrow($res)){
		print $fres[1]."----";
			$memRes=$obj->select("empmaster", "empCode=$fres[1]");
			$memRows=$obj->rows($memRes);
			if($memRows>0){
			
				/*$dobExpld=explode(".", $fres[9]);
				$dob=$dobExpld[2]."-".$dobExpld[1]."-".$dobExpld[0];
				
				$dojExpld=explode(".", $fres[11]);
				$doj=$dojExpld[2]."-".$dojExpld[1]."-".$dojExpld[0];
				
				$upRes=$obj->update("empmaster", "empUID='$fres[2]'", "empCode=$fres[1]");*/
				
				/*
				$upRes=$obj->update("empmaster", "empUAN='$fres[2]', empName='$fres[7]', empDob='$dob', empDoj='$doj', empMob='$fres[13]', empSex=$fres[10], empESINo='$fres[3]', empGName='$fres[8]', empBankAccount='$fres[5]', empIfsc='$fres[6]'", "empCode=$fres[1]");*/
				
				print "<strong>OK</strong><br/>";
			}else{
			
				$dobExpld=explode(".", $fres[9]);
				$dob=$dobExpld[2]."-".$dobExpld[1]."-".$dobExpld[0];
				
				$dojExpld=explode(".", $fres[11]);
				$doj=$dojExpld[2]."-".$dojExpld[1]."-".$dojExpld[0];
				
				if($fres[3]>0){
					$esi=1;
				}else{
					$esi=2;
				}
				
				$fld="empTyp, empCode, empName, empDob, 
						empPhn, empMob,
						empDoj, empDept,
						empJobTyp,
						empESI, empEPF, empEPFNo, empUAN,
						empSex,empESINo, oprID,createDate, empBankAccount, empIfsc";
		
				$val="'1', '$fres[1]', '$fres[7]', '$dob',
						'$fres[13]', '$fres[13]',
						'$doj', '$fres[14]',
						'1',
						'$esi', '1', '$fres[1]', '$fres[2]',
						 $fres[10] ,'$fres[3]','1', '2016-06-18', '$fres[5]', '$fres[6]'";
						 
				$insRes=$obj->chkinsert("empmaster", "empCode=$fres[1]", $fld, $val);
				print_r($insRes);
				print "<br/>";
			}
	}
}
?>