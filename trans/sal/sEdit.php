<?
error_reporting(E_ALL);
require ("../../config/setup.inc");

$title="Salary Modification";

require($rpath."pageDesign.tmp.php");
require ($root."lib/datetime/datetimepicker_css_js.php");


$cdt=date('Y-m-d');

$lmt=15;

$eman=new empManagement();


$mntArray=array( "", "January", "February", "March", "April", "May", "Jun", "July", "August", "September", "October", "November", "December");
$mnthDayArrray=array( "", "31", "28", "31", "30", "31", "30", "31", "31", "30", "31", "30", "31");

$dept=$_REQUEST['dept'];
$m=$_REQUEST['mnth'];
$yr=$_REQUEST['yr'];

$prvMnth=($m=="01") ? "12" : sprintf("%02d", ($m-1));
$prvYear=($m=="01") ? ($yr-1) : $yr;

$d=cal_days_in_month(CAL_GREGORIAN,"$m","$yr");

$page=0;


?>

<style type='text/css'>
 .ddhead { width:375mm; padding:5px; display:table; font-weight:bold; font-family:arial; font-size:13px;}
 .rowHead {width:375mm; display:table; font-family:arial; font-size:13px; border:solid 1px #666666; border-left:none; border-right:none;}
 .rowFoot {width:375mm; display:table; font-family:arial; font-size:13px; border:solid 1px #666666; border-left:none; border-right:none;page-break-after:always}
 .divCell {float:left}
 .divLine {width:100%;display:table; height:3%}

</style>
<script type="text/javascript">
function calculate(i, pfe, esie, esicc, esiSt, pt, pfa){

	var basec="basic"+i;
	var hrac="hra"+i;
	var wac="wa"+i;
	var grossc="gross"+i;
	var pfecc="pfec"+i;
	var esiecc="esiec"+i;
	var esiccc="esicc"+i;
	
	var base=document.getElementById(basec).value;
	var hra=document.getElementById(hrac).value;
	var wa=document.getElementById(wac).value;
	
	
	
	
	var tot=eval(base)+eval(hra)+eval(wa);
	
	if(eval(pfa)<2){
		var pfCal=(eval(tot)*eval(pfe))/100;
		var pf=Math.round(pfCal, 2);
	}else{
		var pf=0;
	}
	if(eval(esiSt)==1){
	var esiecCal=(eval(tot)*eval(esie))/100;
	var esiec=Math.round(esiecCal, 2);
	
	var esiccCal=(eval(base)*eval(esicc))/100;
	var esicc=Math.round(esiccCal, 2);
	}else{
		var esiec=0;
		var esicc=0;
	}
	document.getElementById(grossc).innerHTML=eval(tot);
	document.getElementById(pfecc).innerHTML=eval(pf);
	document.getElementById(esiecc).innerHTML=eval(esiec);
	document.getElementById(esiccc).innerHTML=eval(esicc);

	ptax(i, pt);
	pfcc(i, pfa);
	tdsCal(i);

}
function calculateded(i){

	
	var pfecc="pfec"+i;
	var ptaxc="ptax"+i;
	var tdsc="tds"+i;
	var advc="adv"+i;
	var esiecc="esiec"+i;
	var totdc="totd"+i;
	
	
	var pfec=document.getElementById(pfecc).innerHTML;
	var ptax=document.getElementById(ptaxc).innerHTML;
	var tds=document.getElementById(tdsc).value;
	var adv=document.getElementById(advc).value;
	var esiec=document.getElementById(esiecc).innerHTML;
	
	
	
	var totded=eval(pfec)+eval(ptax)+eval(esiec)+eval(tds)+eval(adv);
	
		document.getElementById(totdc).innerHTML=eval(totded);
		
}
function ptax(i, pt) {
   
   var basec="basic"+i;
	var hrac="hra"+i;
	var wac="wa"+i;
	var ptax="ptax"+i;
	
	var s=eval(document);
	//alert(s);
	
	var base=document.getElementById(basec).value;
	var hra=document.getElementById(hrac).value;
	var wa=document.getElementById(wac).value;
	
	
	var tot=eval(base)+eval(hra)+eval(wa);
	
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById(ptax).innerHTML = xmlhttp.responseText;
				
            }
        };
        xmlhttp.open("GET", "ptaxCal.php?q="+tot+"&pt="+pt, true);
        xmlhttp.send();
}

function pfcc(i, pfa) {
   
	var basec="basic"+i;
	var pfcc="pfcc"+i;
	
	var base=document.getElementById(basec).value;
	
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById(pfcc).innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET", "pfcc.php?q="+base+"&pf="+pfa, true);
        xmlhttp.send();
}
function tdsCal(i) {
   
	var basec="gross"+i;
	var pfcc="tds"+i;
	
	var base=document.getElementById(basec).innerHTML;
	
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById(pfcc).value = xmlhttp.responseText;
				calculateded(i);
            }
        };
        xmlhttp.open("GET", "tdsCal.php?q="+base, true);
        xmlhttp.send();
}

function calCtc(i){
	
		var esiccc="esicc"+i;
		var pfccc="pfcc"+i;
		var grossc="gross"+i;
		var ctcc="ctc"+i;
		var pfecc="pfec"+i;
		var esiecc="esiec"+i;
		var ptaxc="ptax"+i;
		var tdsc="tds"+i;
		var inhandc="inhand"+i;
		
		var esicc=document.getElementById(esiccc).innerHTML;
		var pfcc=document.getElementById(pfccc).innerHTML;
		var esiec=document.getElementById(esiecc).innerHTML;
		var pfec=document.getElementById(pfecc).innerHTML;
		var gross=document.getElementById(grossc).innerHTML;
		var ptax=document.getElementById(ptaxc).innerHTML;
		var tds=document.getElementById(tdsc).value;
		

		var ctc=eval(gross)+eval(pfcc)+eval(esicc);
		var inhand=eval(gross)-eval(pfec)-eval(esiec)-eval(ptax)-eval(tds);
		
		document.getElementById(ctcc).innerHTML=eval(ctc);
		document.getElementById(inhandc).innerHTML=eval(inhand);
}
function goNext(){
		
	
	if (document.getElementById('slDt').value==0){
		alert ("Please select Sallary Date");
	}else{
			document.form1.submit();
	}
	
	
}
</script>

<center>
<div class="contDiv">
	<?
				$deptRes=$obj->select("deptmanager", "deptID='$dept'");
				
				$deptFres=$obj->fetchrow($deptRes);
				
				$configRes=$obj->select("salconfig");
				$configFres=$obj->fetchrow($configRes);
				
				$pfcch=$configFres[5]+$configFres[6]+$configFres[7]+$configFres[9]+$configFres[10];

	?>
		<table width="100%" border="1" bordercolorlight="#CCCCCC" cellspacing="0" cellpadding="0">
		  <tr style="font-size:12px">
            <th height="20" align="center">
	        <h2>Department of <?= $deptFres[1]?><br/></h2>
	        <h3>
			Salary Modifications
          </h3>
		 </tr>
	  </table>
	  <form name="form1" action="salGenBack.php" method="post">
	  <div class="divLine" align="center" style="width:96%; border:1px solid #000000; border-radius:2mm; margin-left:2%">
	  	<div class="divCell" style="width:46%; vertical-align:middle;" align="right"><strong>Select Salary Date:</strong></div>
		<div class="divCell" style="width:46%" align="center"><input type="date" id="slDt" name="slDt" /><input type="hidden" name="mnth" id="mnth" value="<?=(string)$m?>" />
			 <input type="hidden" name="yr" id="yr" value="<?=(string)$yr?>" />
			 <input type="hidden" name="dept" id="dept" value="<?=(string)$dept?>" /></div>
	  </div>
		 <table width="100%" border="1" bordercolorlight="#CCCCCC" cellspacing="0" cellpadding="0">
		 <tr height="10" style="font-family:Verdana; font-size:9px">
		   <th width="37" rowspan="2" align="left"><p>SL. No.</p></th>
			<th width="165" rowspan="2" align="center">NAME</th>
			<th width="41" rowspan="2" align="center">PF No.</th>
			<th width="40" rowspan="2" align="center">ESI No.</th>
		   <th width="49" rowspan="2" align="center">ATTEN
	       <p>DENCE</p></th>
			<th width="43" rowspan="2" align="center">BASIC RATE</th>
			<th width="60" rowspan="2" align="center">BASIC</th>
			<th width="71" rowspan="2" align="center">H.R.A</th>
			<th width="64" rowspan="2" align="center">W.A.</th>
			<th width="51" rowspan="2" align="center">Gross</th>
			<th colspan="5" align="center">Employee Deductions</th>
			<th width="77" rowspan="2" align="center">TOTAL DED.</th>
			<th colspan="2" align="center">Employer's Contribution </th>
			<th width="64" rowspan="2" align="center">CTC</th>
		   <th width="104" rowspan="2" align="center">INHAND</th>
		</tr>
		<tr height="30" style="font-family:Verdana; font-size:9px;">
		  <th width="51" align="center">P.TAX</th>
		  <th width="64" align="center">@<?=$configFres[4]?>% P.F.</th>
		  <th width="51" align="center">TDS</th>
		  <th width="51" align="center">ADV. ADj</th>
		  <th width="77" align="center">@<?=$configFres[2]?>% E.S.I.</th>
		  <th width="64" align="center">@<?=$pfcch?>% P.F.</th>
		  <th width="51" align="center">@<?=$configFres[3]?>% ESI</th>
		</tr>
		 <?	
		 	$r=0;
		 	$tempPrint=0;	
			
		 	$res=$obj->select("empmaster", "empTyp=1 and empDept='$deptFres[0]' order by empName asc");
			while($fres=$obj->fetchrow($res)){
			
				
				$s++;
				
				$ecode=$fres[2];
				
				$esiNo=($fres[38]) ? $fres[38] : "None";
				
				$attnd=$eman->empAttendance($ecode, $m, $yr);
				$attndCal=$eman->empAttndCal($ecode, $m, $yr);
				$lwp=$attndCal[6];
				$pdBasic=$fres[35] / $d;
				$lwpAmnt=$pdBasic * $lwp;
					
				$basic=round($fres[35]-$lwpAmnt);
				
				$hraRes=$obj->distinct("empallowance", "amount", "empCode='$ecode' and alwID='2'");
				$hraFres=$obj->fetchrow($hraRes);
				
				
				$lastAdv=$obj->lastID("advancetrans", "transDate", "empNo='$ecode' and transTyp=2");
				$totAdv=$obj->sumfield("advancetrans", "amount", "empNo='$ecode' and transTyp=2");
				$totRet=$obj->sumfield("advancetrans", "amount", "empNo='$ecode' and transTyp=1");
				if($totRet>=$totAdv){
					$adv=0;
				}else{
					$balAdv=$totAdv-$totRet;
					$lastInst=$obj->lastID("advancetrans", "instalment", "empNo='$ecode' and transTyp=2 and transDate='$lastAdv'");
					if($lastInst<=$balAdv){
						$adv=$lastInst;
					}else{
						$adv=$balAdv;
					}
				}
				
				$hraNot=$hraFres[0]/$d;
				$lwpHra=$hraNot*$lwp;
				$lwpHra=sprintf("%.02f",$lwpHra);
				$exLwp=explode(".",$lwpHra);
				if($exLwp[1]>50){
					$hraLw=$exLwp[0]+1;
				}else{
					$hraLw=$exLwp[0];
				}
				$hraCal=$hraFres[0]-$hraLw;
				$waCal=$obj->sumfield("empallowance", "amount", "empCode='$ecode' and alwID='3'");
					$h=1;
				$hra=($hraCal) ? $hraCal : 0;	
				
				$wa=($waCal) ? $waCal : 0;
				
				$gross=$basic+$hra+$wa;
				if($fres[48]<2){
					$ptMst=$obj->sumfield("ptmaster", "rate","slabHigh >='$gross' and slabLow <='$gross'");
				}else{
					$ptMst=0;
				}//$ptMstFres=$obj->fetchrow($ptMstRes);
				
				if($fres[30]<2){
					$pfCal=($configFres[4]/100);
					$pfec=round($basic*$pfCal);
				}else{
					$pfec=0;
				}
				if($fres[29]==1 && $gross<$configFres[1]){
					$esical=(($gross*$configFres[2])/100);
					
					
					$excEc=explode(".", $esical);
					
					if($excEc[1]>0){
						$esiec=$excEc[0]+1;
					}else{
						$esiec=$excEc[0];
					}
				}
				
				$esiec=($esiec) ? $esiec : 0;
				
				if($fres[29]==1 && $gross<$configFres[1]){
					$esiccCal=($gross*$configFres[3])/100;
						$exp=explode(".", $esiccCal);
						if($exp[1]>0){
							$esiCc=(int)$exp[0]+1;
						}else{
							$esiCc=(int)$exp[0];
						}
					
				}else{
					$esiCc=0;
					
				}
				
				$totDed=$esiec+$pfec+$ptMst+$tds+$adv;
				if($fres[30]<2){
					$pfcc=($basic*$configFres[5])/100;
					$epsCC=($basic*$configFres[7])/100;
					$pfAdmin=($basic*$configFres[6])/100;
					$edlicc=($basic*$configFres[9])/100;
					$edliAdmin=($basic*$configFres[10])/100;
					
					$mnthPfCcFst=($pfcc+$epsCC+$pfAdmin+$edlicc+$edliAdmin);
				}else{
					$pfcc=0;
					$epsCC=0;
					$pfAdmin=0;
					$edlicc=0;
					$edliAdmin=0;
					
					$mnthPfCcFst=($pfcc+$epsCC+$pfAdmin+$edlicc+$edliAdmin);
				}
				$expPF=explode(".", $mnthPfCcFst);
				if($expPF[1]>0){
					$mnthPfCc=round($mnthPfCcFst);
				}else{
					$mnthPfCc=$expPF[0];
				}
				$ptxc=($ptMst) ? ($ptMst) : 0;
					$ptx=(int)($ptxc);
				//print "$mnthPfCc<br/>";				
				
				
				$tds=($tds) ? $tds : 0;
				$adv=($adv) ? $adv : 0;
				
				$ctc=$gross+$mnthPfCc+$esiCc;
				
				
				
				$inhand=$gross-$pfec-$esiec-$ptMst-$tds-$adv;
				
				$shRes=$obj->select("advancetrans", "empNo='$ecode' and transTyp=2 and endFlg=1");
				$shFres=$obj->fetchrow($shRes);
					
					$repaid=$obj->sumfield("advancetrans", "amount", "empNo='$ecode' and transTyp=2 and advID>'$shFres[0]'");
					
					$repaid=($repaid) ? $repaid : 0;
					
					$balance=$shFres[4]-$repaid;
				
				
			?>	
			
			<tr height="30" style="font-size:9px;">
				<th align="center"><?= $s?></th>
				<th width="165" align="left" style="font-size:11px;"><?= $fres[3]?><input type="hidden" name="empNo[]" value="<?=$ecode?>" /></th>
				<th align="center"><?= $fres[31]?></th>
				<th align="center"><?= $esiNo?></th>
				<th align="center"><?= $attnd?></th>
				<th style="min-width:inherit; max-width:inherit" align="center"><?= (string)$fres[35]?></th>
				<th style="min-width:inherit; max-width:inherit" align="center"><input type="text" size="7" style="text-align:center" name="basic[]" id="basic<?=(string)$s?>" value="<?= (string)$basic?>" onchange="fillAmnt();"/></th>
				<th style="min-width:inherit; max-width:inherit" align="center"><input type="text" size="7" style="text-align:center" name="hra[]" id="hra<?=(string)$s?>" value="<?= (string)$hra?>"/></th>
				<th style="min-width:inherit; max-width:inherit" align="center"><input type="text" size="7" style="text-align:center" name="wa[]" id="wa<?=(string)$s?>" value="<?= (string)$wa?>" onblur="calculate(<?=$s?>, <?=$configFres[4]?>, <?=$configFres[2]?>, <?=$configFres[3]?>, <?=$fres[29]?>, <?=$fres[48]?>, <?=$fres[30]?>); calculateded(<?=$s?>);" /></th>
				<th style="min-width:inherit; max-width:inherit" align="center"><span size="3" style="text-align:center" id="gross<?=(string)$s?>" name="gross"/><?=(string)$gross?></span></th>
				<th style="min-width:inherit; max-width:inherit" align="center"><span id="ptax<?=(string)$s?>" name="ptax" size="3" style="text-align:center" /><?=$ptx?></span></th>
				<th style="min-width:inherit; max-width:inherit" align="center"><span size="3" style="text-align:center" id="pfec<?=(string)$s?>" name="pfec" /><?=(string)$pfec?></span></th>
				<th style="min-width:inherit; max-width:inherit" align="center"><input type="text" size="3" style="text-align:center" id="tds<?=(string)$s?>" name="tds[]" onkeyup="calculateded(<?=$s?>); calCtc(<?=$s?>);" value="<?=(string)$tds?>" /></th>
				<th style="min-width:inherit; max-width:inherit" align="center"><input type="text" size="3" alt="Balance=<?= $balance?>" title="Balance=<?=$balance?>" style="text-align:center" id="adv<?=(string)$s?>" name="adv[]" onkeyup="calculateded(<?=$s?>);" value="<?=(string)$adv?>" /></th>
				<th style="min-width:inherit; max-width:inherit" align="center"><span size="3" style="text-align:center" id="esiec<?=(string)$s?>" name="esiec" /><?=(string)$esiec?></span></th>
				<th align="center"><span size="3" style="text-align:center" id="totd<?=(string)$s?>" name="totd"/><?=(string)$totDed?></span></strong></th>
				<th style="min-width:inherit; max-width:inherit" align="center"><span size="3" style="text-align:center" id="pfcc<?=(string)$s?>" name="pfcc"><?= (string)$mnthPfCc?></span></th>
				<th style="min-width:inherit; max-width:inherit" align="center"><span size="3" style="text-align:center" id="esicc<?=(string)$s?>" name="esicc"><?= (string)$esiCc?></span></th>
				<th align="center"><span size="3" style="text-align:center" id="ctc<?=(string)$s?>" name="ctc"><?= (string)$ctc?></span></th>
				<th align="center"><span size="3" style="text-align:center" id="inhand<?=(string)$s?>" name="inhand"/><?= (string)$inhand?></span>
				
			  </th>
			</tr>
			
			<?		unset($esiec);
					}
					
			$r++;
		
	 ?>
		<tr height="30" style="font-size:9px;">
			  <th colspan="20" align="center">
		  <input type="button" style="min-width:100%; background-color:#8A8A8A; cursor:pointer; padding:9px;" name="bsab" value="Submit" onclick="goNext();" /></th>
		   </tr>
		</table>
		</form>

</div>

</center> 