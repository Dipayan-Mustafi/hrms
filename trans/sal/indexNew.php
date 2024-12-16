<?
//error_reporting(E_ALL);
require ("../../config/setup.inc");



$title="Employee Section";

require($rpath."pageDesign.tmp.php");

$emp=new empManagement();


require ($root."lib/datetime/datetimepicker_css_js.php");

$mnth=($_REQUEST['mnth']) ? $_REQUEST['mnth'] : (date('n')-1);

$m=sprintf("%02d", $mnth);

if (date('n') < $mnth){
		  
	$endyr=date('Y')-1;
}else{
	$endyr=date('Y');
}

$styr=$endyr -3;

$yr=($_REQUEST['yr']) ? $_REQUEST['yr'] : $endyr;
$dept=($_REQUEST['dept']) ? $_REQUEST['dept'] : 0;

$d=cal_days_in_month(CAL_GREGORIAN,"$m","$yr");


?>
<script type="text/javascript">
function PrintDiv(d, t) {    
     var divToPrint = document.getElementById(d);
     var popupWin = window.open('', '_blank', 'width=300,height=300');
     popupWin.document.open();
     popupWin.document.write('<html><title>'+t+'</title><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
     popupWin.document.close();
}

function movBack(m,y){

	window.location="index?mnth="+m+"&yr="+y;
}

function calLev(i){

	var wd="twd"+i;
	var tp="prsnt"+i;
	var lv="lev"+i;
	var atn="attn"+i;
	var tlv="talev"+i;
	var elv="elev"+i;
	var lop="lwp"+i;
	var bsv="bsav"+i
	
	var tpv=document.getElementById(tp).value;
	var twdv=document.getElementById(wd).value;
	//var elvv=document.getElementById(elv).value;
	var glv=eval(twdv) - eval(tpv);
	//var balv=eval(glv)- eval(elvv);
	//if (eval(glv) <= eval(elvv)){
		//document.getElementById(lv).value=glv;
		//document.getElementById(tlv).value=glv;
	//}else{
		//document.getElementById(lv).value=elvv;
		//document.getElementById(tlv).value=elvv;
		//document.getElementById(lop).value=balv;
	//}
	
	
	document.getElementById(atn).value=tpv;
	document.getElementById(bsv).disabled=false;
	
}
function calLate(i, avl){

	var totdays="totd";
	var tp="prsnt"+i;
	var lt="lat"+i;
	var sday="sday";
	var hday="hday";
	var absid="abs"+i;
	var sdays="sdays"+i;
	var leavedays="leave"+i;
	
	var tpv=document.getElementById(tp).value;
	var ltv=document.getElementById(lt).value;
	var sdayv=document.getElementById(sday).value;
	var hdayv=document.getElementById(hday).value;
	var absv=document.getElementById(absid).value;
	var totv=document.getElementById(totdays).value;
	
	var cal=eval(tpv)+eval(sdayv)+eval(hdayv);
	var ltCal=parseInt(eval(ltv)/3);
	
	var tot=eval(absv)+eval(ltCal);
	
	if(eval(avl)>eval(tot)){
		var cut=0;
		var leave=eval(tot);
	}else if(eval(avl)==eval(tot)){
		var cut=0;
		var leave=eval(tot);
	}else if(eval(avl)<eval(tot)){
		var cut=eval(tot)-eval(avl);
		var leave=eval(avl);
	}
	var saldays=eval(totv)-eval(cut);
	
	document.getElementById(sdays).value=eval(saldays);
	document.getElementById(leavedays).value=eval(leave);
	

}

function levLate(i){

	var lv="lev"+i;
	var atn="attn"+i;
	var lt="lat"+i;
	var tlv="talev"+i;
	var llv="llev"+i;
	var elv="elev"+i;
	var lop="lwp"+i;
	var bsv="bsav"+i;
	
	
	var elvv=document.getElementById(elv).value;
	var ltv=document.getElementById(lt).value;
	var altv=document.getElementById(tlv).value;
	var lopv=document.getElementById(lop).value;
	
	var allv=eval(ltv) /3;
	var tallv=parseInt(allv);
	var totallv=eval(tallv)+eval(altv);
	
	if (eval(totallv) > eval(elvv)){
		
		document.getElementById(lop).value=eval(lopv)+eval(tallv);
		document.getElementById(llv).value=0;
	
	}else{
		document.getElementById(llv).value=tallv;
	
		document.getElementById(tlv).value=totallv;
	}
	
	document.getElementById(bsv).disabled=false;
	
	

}
function absCal(i){

	
	var tot="totd";
	var sun="sday";
	var hday="hday";
	var absc="abs"+i;
	var tlv="talev"+i;
	var prsnt="prsnt"+i;
	var attn="attn"+i;
	var sday="sdays"+i;
	
	var totv=document.getElementById(tot).value;
	var sunv=document.getElementById(sun).value;
	var hdayv=document.getElementById(hday).value;
	var abscv=document.getElementById(absc).value;
	
	
	//var elvv=document.getElementById(elv).value;
	var rest=eval(totv) - eval(sunv)- eval(hdayv)- eval(abscv);
	var sal=eval(rest)+eval(sunv)+eval(hdayv);
	//var balv=eval(glv)- eval(elvv);
	//if (eval(glv) <= eval(elvv)){
		//document.getElementById(lv).value=glv;
		//document.getElementById(tlv).value=glv;
	//}else{
		//document.getElementById(lv).value=elvv;
		//document.getElementById(tlv).value=elvv;
		//document.getElementById(lop).value=balv;
	//}
	
	//document.getElementById(lt).value=eval(tpv) - eval(atnv);
	document.getElementById(prsnt).value=eval(rest);
	document.getElementById(sday).value=eval(sal);
	//document.getElementById(bsv).disabled=false;
	
}


function goSav(i){


	var ec="ecode"+i;
	var tw="twd"+i;
	var prsn="prsnt"+i;
	var attn="attn"+i;
	var lat="lat"+i;
	var lev="lev"+i;
	var llev="llev"+i;
	var lwp="lwp"+i;
	
	var ecv=document.getElementById(ec).value;
	var twv=document.getElementById(tw).value;
	var prv=document.getElementById(prsn).value;
	var atv=document.getElementById(attn).value;
	

	var mn=document.getElementById('mnth').value
	var yrv=document.getElementById('yr').value
	var dpv=document.getElementById('dept').value
	
	var qry="mnth="+mn+"&yr="+yrv+"&dept="+dpv+"&ec="+ecv+"&tw="+twv+"&psnt="+prv+"&attn="+atv;
	window.location="salSet?"+qry;


}




function SubmitForm(){

	var ans=confirm("Are your sure to save current month's attendance of current department");
	
	if (ans==true){
		document.form2.submit();
	}

}
function gen(){

	var ans=confirm("Are your sure to save current month's attendance of current department");
	
	if (ans==true){
		document.form2.submit();
	}

}
</script>

<style type="text/css">
.listTD{

	background-color:#FFFFFF;
	

}
.listTD:hover{
	background-color:#666666;
	color:#FFFFFF;
	display:block;
}

</style>

<div class="contDiv">
	<input type="image" align="right" border="1" src="<?= $rurl?>images/close.png" width="24" height="24" alt="Close" title="Close" style="cursor:pointer; margin:2; padding:9; border:#666666; border-style:dashed" onclick="navigate('../../index.php');" />
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
					$dpRes=$obj->Select("deptmanager");
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
		//if ($chkRows <1){
	?>
	
	<div style=" text-align:left; border-radius:6px; padding:1%; background-color:#A8A8A8; width:98%; box-shadow:0.5em 0.5em 0.5em #CCCCCC;">
		
		<input name="totd" type="hidden" id="totd" value="<?= $d?>" />
		<input name="sday" type="hidden" id="sday" value="<?= $hday?>" />
		<input name="hday" type="hidden" id="hday" value="<?= $hdSum?>" />
		<input name="mnth" type="hidden" id="mnth" value="<?= $m?>">
		<input name="yr" type="hidden" id="yr" value="<?= $yr?>">
		<input name="dept" type="hidden" value="<?= $dept?>" />
			<table width="100%" border="0" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF" id="listTbl">
			  <tr>
				<th width="20%" align="center" valign="top">Employee</th>
				<th width="12%" align="center" valign="top">Designation</th>
				<th width="14%" align="center" valign="top">Total Days In the Month </th>
				<th width="8%" align="center" valign="top">Sundays</th>
				<th width="9%" align="center" valign="top">Holidays</th>
				<th width="6%" align="center" valign="top">Absent </th>
				<th width="7%" align="center" valign="top">Present </th>
				<th width="8%" align="center" valign="top">Late</th>
				<th width="8%" align="center" valign="top">Leave</th>
				<th width="11%" align="center" valign="top">Salary days </th>
				<th width="5%" align="center" valign="top">&nbsp;</th>
		      </tr>
			  <?
			 
				
			  $res=$obj->select("empmaster", "active=1 and empDept=$dept and empDoj <'$ldt' order by empName");

			  $rows=$obj->rows($res);


			  while ($fres=$obj->fetchrow($res)){
			  		$r++;

			  		$dsgRes=$obj->Select("desigmast", "dsgID=$fres[11]");
					$dsgFres=$obj->fetchrow($dsgRes);
					
					$erRes=$obj->select("mnthcompcont", "salMonth='$m' and salYear='$yr' and empCode='$fres[2]'");
					$erRows=$obj->fetchrow($erRes);
					
					
					
			  		
					 

					//$hday=$hday+$hdSum;//
			  		
					
					$actDays=$days-$hday;
					
					$atnRes=$obj->select("attendancedet", "empCode='$fres[2]' and attnMonth='$m' and attnYear='$yr'");

					$atnRows=$obj->rows($atnRes);
					$atnFres=$obj->fetchrow($atnRes);
					$prsntDay=($atnRows > 0) ? $atnFres[4] : $actDays;
					$intmDay=($atnRows > 0) ? $atnFres[5] : $actDays;
					$attnLate=($atnRows > 0) ? $atnFres[7] : 0;
					$levTak=($atnRows > 0) ? $atnFres[8] : 0;
					$levAdj=($atnRows > 0) ? $atnFres[9] : 0;
					$lwp=($atnRows > 0) ? $atnFres[10] : 0;
					$totLevAdj=$levTak+$levAdj;
					$absCal=(int)($attnLate/3);
					
					
					$sumAllLev=$obj->sumfield("empleavdet","qty" ,"empCode='$fres[2]'");
					/*$sumTakLev=$obj->sumfield("attendancedet", "levTaken", "empCode='$fres[2]'");
					$sumAdjLev=$obj->sumfield("attendancedet", "adjLeave", "empCode='$fres[2]'");
					$balLev=$sumAllLev - $sumTakLev - $sumAdjLev;*/
					if($atnRows>0){
						$absent=$d-$hday-$hdSum-$prsntDay;
					}else{
						$absent=0;
					}
					$sDays=$emp->empAttendance($fres[2], $m, $yr);
					
					
					$lev=($lev) ? $lev : 0;
					$wdays=$days - $lev;
					
					$setRes=$obj->select("salconfig");
					$setFres=$obj->fetchrow($setRes);
					
					$pfCont=$fres[35] * $setFres[4] / 100;
					
					$sumContrPf=$setFres[5]+$setFres[6]+$setFres[7]+$setFres[8]+$setFres[9];
					$cpfCont=$fres[35] * $sumContrPf / 100;
					
					$esi=$fres[35] * $setFres[2]/100;
					$cesi=$fres[35] * $setFres[3] /100;
					
					if ($fres[29]>1){
						$esi=0;
						$cesi=0;
					}
					
					if ($fres[30] > 1){
						$cpfCont=0;
						$pfCont=0;
					}
					
					$levRes=$obj->sumfield("emplevconfig", "qty", "empCode='$fres[2]' and finYear='$yr'");
					$takenRes=$obj->sumfield("attnlevdet", "qty", "empCode='$fres[2]' and levYear='$yr'");
					
					$availLeave=$levRes-$takenRes;
					
			  ?>
			   <form name="form2" method="post" action="salSet.php"/>
			 
			  <tr>
				<td align="left" valign="top"><?= $fres[3]?><input name="ecode[]" type="hidden" id="ecode<?= $r?>" value="<?= $fres[2]?>"></td>
				<td align="center" valign="top"><?= $dsgFres[1]?></td>
				<td align="center" valign="top"><?= $d?></td>
				<td align="center" valign="top"><?=$hday?></td>
				<td align="center" valign="top"><?=$hdSum?></td>
				<td align="center" valign="top"><input type="text" style="text-align:center" name="abs[]" id="abs<?=$r?>" size="5" value="<?=$absent?>" onblur="absCal(<?= $r?>);"/>
			    <input name="twd" type="hidden" id="twd<?= $r?>" value="<?= $actDays?>" /></td>
				<td align="center" valign="top"><input name="prsnt[]" type="text" id="prsnt<?= $r?>" size="5" value="<?= $prsntDay?>" onblur="calLev(<?= $r?>);" /></td>
				<td align="center" valign="top"><input name="lat[]" type="text" id="lat<?= $r?>" size="5" onblur="calLate(<?=$r?>, <?=$availLeave?>)" value="<?= $attnLate?>" /></td>
				<td align="center" valign="top"><input name="leave[]" type="text" id="leave<?= $r?>" size="5" /></td>
				  <td align="center" valign="top"><input name="sdays[]" type="text" id="sdays<?= $r?>" value="<?=$sDays?>" size="10" /></td>
				  <td align="center" valign="middle">
				<?
				if ($chkRows > 0 && $erRows >0){
				
				?>
				<img src="<?= $rurl?>images/print_icon.gif" width="24" align="left" alt="Print Slip" title="Print Salary Slip" height="24" style="cursor:pointer; vertical-align:inherit" onclick="navigate('salView?ec=<?= $fres[2]?>&mnth=<?= sprintf("%02d",$mnth)?>&yr=<?= $yr?>');" />
				<? }else{?>
				
				&nbsp;
				
				<? }?>				</td>
			  </tr>
			 
			  <?
			  	$esi=0;
				$cesi=0;
			  }
			  ?>
			   <tr>
			    <td colspan="11" align="Center" valign="top"><input name="bsav" width="100%" type="button" id="bsav<?= $r?>" value="Proceed >>" onclick="gen(<?= $r?>);" /></td>
		       </tr>
		</table>
	
		</form>
	</div>
		
	<?
		//}
	}
	?>


</div>