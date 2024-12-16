<?
set_time_limit(3600);
require ("../../config/setup.inc");

$disRes=$obj->distinct("attendancedet", "empCode");
while($disFres=$obj->fetchrow($disRes)){
		
			$res=$obj->select("attendancedet", "empCode='$disFres[0]'");
			while($fres=$obj->fetchrow($res)){
			
						$lwp=$fres[3]-$fres[4];	
						$upRes=$obj->update("attendancedet", "lwp=$lwp", "attID='$fres[0]'");
						print_r($upRes);
						print "<div>";
					}
}
?>