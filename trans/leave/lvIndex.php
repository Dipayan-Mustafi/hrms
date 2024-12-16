<?
//error_reporting(E_ALL);
require ("../../config/setup.inc");



$title="Leave Register";

require($rpath."pageDesign.tmp.php");

$emp=new empManagement();

$mnth=($_REQUEST['mnth']) ? $_REQUEST['mnth'] : (date('n')-1);

$m=sprintf("%02d", $mnth);


require ($root."lib/datetime/datetimepicker_css_js.php");

if (date('n') < $mnth){
		  
	$endyr=date('Y')-1;
}else{
	$endyr=date('Y');
}

$styr=$endyr -3;

$yr=($_REQUEST['yr']) ? $_REQUEST['yr'] : $endyr;
$dept=($_REQUEST['dept']) ? $_REQUEST['dept'] : 0;
$d=cal_days_in_month(CAL_GREGORIAN,"$m","$yr");

$shtYr=substr($yr,2,2);

$fyr=$misc->CurrentFinYear($shtYr,$m);
?>
<script type="text/javascript">
function showList(i, ec, m, y){
	
	
	window.open("levAlct?lid="+i+"&ec="+ec+"&mnth="+m+"&yr="+y, "Alocate Leave", "height=580, width=870, top=100, left=150");


}
</script>
<div class="contDiv">
	<div id="heading" align="left"><h3>Leave Alocation<input type="image" align="right" border="1" src="<?= $rurl?>images/close.png" width="24" height="24" alt="Close" title="Close" style="cursor:pointer; margin:2; padding:9; border:#666666; border-style:dashed" onclick="navigate('index.php');" /></h3></div>
	<div style="margin-top:0.5%;width:100%;display:table; text-align:left">
	  <div style="background-color:#a8a8a8; color:#000; border-radius:6px 6px 0px 0; width:30%; padding:5pt; box-shadow:0.3em 0.1em 0.5em #CCC; font-size:110%; font-weight:bold;">Select Month &amp; Year </div>
	</div>
	<div style=" text-align:left; border-radius:6px 6px 0 0; padding:1%; background-color:#A8A8A8; width:98%; box-shadow:0.5em 0.5em 0.5em #CCCCCC; margin-bottom:1%;">
		<form method="get" name="form1" action=""  style="border-radius:6px ; border:solid 1px #a1a1a1; background-color:#E2E2E2; padding:8px; display:table; width:95%;">
		<div style="float:left; width:10%;">Month	</div>
		<div style="float:left; width:15%">
		<select name="mnth">
		  <?
		  for ($i=1; $i<=12; $i++){
		  	if ($i==$mnth){
				print "<option value='$i' selected>".date('M', mktime(0,0,0,$i+1,0,0))."</option>";
			}else{
				print "<option value='$i'>".date('M', mktime(0,0,0,$i+1,0,0))."</option>";
			}
		  }
		  ?>
	  </select>
		
		
		
		</div>
		<div style="float:left; width:10%;">Year</div>
		<div style="float:left; width:15%">
		
		<select name="yr">
		  <?
		  
		  
		  
		  
		  for ($i=$styr; $i<=date('Y'); $i++){
		  	if ($i==$yr){
				print "<option value='$i' selected>$i</option>";
			}else{
				print "<option value='$i'>$i</option>";
			}
		  }
		  ?>
	  </select>
		
		
		</div>
		<div style="float:left; width:10%;">Department</div>
		<div style="float:left; width:15%">
		  <select name="dept" id="dept">
            <option value="0">--</option>
            <?
					$dpRes=$obj->Select("deptmanager order by deptName");
					while ($dpFres=$obj->fetchrow($dpRes)){
						if ($dept==$dpFres[0]){
							print "<option value='$dpFres[0]' selected>$dpFres[1]</option>";
						}else{
							print "<option value='$dpFres[0]'>$dpFres[1]</option>";
						}
					
					}
					
					?>
          </select>
		</div>
		<div style="float:left; width:20%;"><input name="bshow" type="submit" value="Show" /></div>
		</form>
	</div>
	
	<?
	if ($_REQUEST['bshow']){
	
		$chkRes=$obj->Select("empsaldet", "salMonth='$m' and salYear='$yr' and deptID=$dept");
		$chkRows=$obj->rows($chkRes);
		
		
		
		$fdt="$yr-$mnth-01";
		$ldt=date('Y-m-t', strtotime($fdt));
		
		//if ($chkRows <1){
	?>
	
	<div style=" text-align:left; border-radius:6px; padding:1%; background-color:#A8A8A8; width:98%; box-shadow:0.5em 0.5em 0.5em #CCCCCC;">
		
		
			<table width="100%" border="0" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF" id="listTbl">
			  <tr>
			    <th width="2%" align="center" valign="top">&nbsp;</th>
				<th width="21%" align="center" valign="top">Employee</th>
				<th width="13%" align="center" valign="top">Total Days In the Month </th>
				<th width="5%" align="center" valign="top">Sundays</th>
				<th width="7%" align="center" valign="top">Holidays</th>
				<th width="7%" align="center" valign="top">Present </th>
				<th width="7%" align="center" valign="top">Late</th>
				<th width="16%" align="center" valign="top">Unallocated Leave</th>
				
				<?
					$lvRes=$obj->select("leaveconfig");
					
					while($lvFres=$obj->fetchrow($lvRes)){
				?>
				<th width="4%" align="center" valign="top"><?=$lvFres[1]?></th>
				<?
				}
				?>
				<th width="18%">&nbsp;</th>
		      </tr>
			  <?
			  	$mRes=$obj->select("empmaster", "empTyp=1 and empDept='$dept'");
				
				while($mFres=$obj->fetchrow($mRes)){
					
					$attndCal=$emp->empAttndCal($mFres[2], $m, $yr);
					$ltCal=(int)($attndCal[7]/3);
					$abs=$attndCal[3]-$attndCal[4]+$ltCal;
					$lvAbs=$abs-$attnd[6];
					
				
					
					$leave=($abs+$ltCal);
					$levRes=$obj->sumfield("emplevconfig", "qty", "empCode='$mFres[2]' and finYear='$fyr'");
					$takenRes=$obj->sumfield("attnlevdet", "qty", "empCode='$mFres[2]' and levYear='$yr'");
					
					$availLeave=$levRes-$takenRes;
					//print_r($levRes);
					//print "<br/>";
					
						$hday=0;
			  		$days=cal_days_in_month(CAL_GREGORIAN,$mnth, $yr);
					for ($i=1 ; $i<=$days; $i++){
						$mdt=sprintf("%02d",$i);
						$wkd=date('w', mktime(0,0,0,$mnth,$mdt,$yr));
						if ($wkd==0){
							$hday++;
						}
				
					}
										
 

                                    // $hdSum=$obj->sumfield("holidaytable", "hdno", "hsDt >='$fdt' and hsDmt<='$ldt'");
                     $hdSum=0;
					 $hdRes=$obj->select("holidaytable",  "hsDt >='$fdt' and hsDt<='$ldt'");
					 while ($hdFres=$obj->fetchrow($hdRes)){
							$expDt=explode("-", $hdFres[1]);
							
							$wkd=date('w', mktime(0,0,0,$mnth,$expDt[2],$expDt[0]));
							if ($wkd>0 ){
								 $hdSum++;
							}
							
					 }
					 
					 $mStrng=sprintf("%02d", $mnth);
					 
					 $mnthLvRes=$obj->sumfield("attnlevdet", "qty", "empCode='$mFres[2]' and levMonth='$mStrng' and levYear='$yr'");
					 $mnthLv=($mnthLvRes) ? $mnthLvRes : 0;
					 $unAlctd=$lvAbs-$mnthLvRes;
					 if($unAlctd>$availLeave){
					 	$unAlctd=$availLeave;
					 }
						//echo $mFres[2]."-".$availLeave."--". $unAlctd."</br>";
					 if($unAlctd >0 && $availLeave>= $unAlctd){
					 $s++;
					 
			  ?>
			  <form name="form1" method="post" action="levBack.php" />
			  <tr style="border-bottom:solid">
			    <th width="2%" align="center" valign="top"><?=$s?></th>
				<th width="21%" align="center" valign="top"><?=$mFres[3]?></th>
				<th width="13%" align="center" valign="top"><?=$days?> </th>
				<th width="5%" align="center" valign="top"><?=$hday?></th>
				<th width="7%" align="center" valign="top"><?=$hdSum?></th>
				<th width="7%" align="center" valign="top"><?= $attndCal[4]?></th>
				<th width="7%" align="center" valign="top"><?= $attndCal[7]?></th>
				<th width="16%" align="center" valign="top"><?=$unAlctd?></th>
				
				<?
					$lvRes=$obj->select("leaveconfig");
					while($lvFres=$obj->fetchrow($lvRes)){
					
						$mnLvRes=$obj->sumfield("attnlevdet", "qty", "empCode='$mFres[2]' and levID=$lvFres[0] and levMonth='$mnth' and levYear='$yr'");
						$mnLvRes=($mnLvRes) ? $mnLvRes : 0;
						
						$mnthlevRes=$obj->sumfield("emplevconfig", "qty", "empCode='$mFres[2]' and levID=$lvFres[0] and finYear='$fyr'");
						$mnthtakenRes=$obj->sumfield("attnlevdet", "qty", "empCode='$mFres[2]' and levID=$lvFres[0] and levYear='$yr'");
						$mnAlLvRes=$obj->sumfield("attnlevdet", "qty", "empCode='$mFres[2]' and levID=$lvFres[0] and levMonth='$mStrng' and levYear='$yr'");
					
						$avlLv=$mnthlevRes-$mnthtakenRes;
				?>
				<th width="4%" align="center" valign="top"><input name="lv[]" onclick="showList(<?=$lvFres[0]?>, <?=$mFres[2]?>, <?=$mnth?>, <?=$yr?>);" size="3" id="lv[]<?=$lvFres[0]?>" value="<?=$mnAlLvRes?>" type="text" /><div>(<?=$avlLv?>)</div></th>
				<?
				}
				?>
				<th width="18%">&nbsp;</th>
		      </tr>
			  
			  <?  }
			   }?>
			 </table>
			 </form>
		<?
		}
		?>