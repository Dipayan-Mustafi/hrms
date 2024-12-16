<?
//error_reporting(E_ALL);
require ("../config/setup.inc");


$lid=$_REQUEST['lid'];
$sub=$_REQUEST['sub'];
$mno=$_REQUEST['mno'];
$aamnt=$_REQUEST['aamnt'];

$gur=$_REQUEST['gur'];
$lic=$_REQUEST['lic'];

$title="Loan Application Form";


require($rpath."pageDesign.tmp.php");

$getLoanRes=$obj->select("loanmaster", "loanID=$lid");
$getLoanRows=$obj->rows($getLoanRes);
$getLoanFres=$obj->fetchrow($getLoanRes);


$getDetRes=$obj->select("loansubmaster", "subID=$sub");

$getDetFres=$obj->fetchrow($getDetRes);

$minMem=$getDetFres[12];
$gurMem=$getDetFres[11];
$pgdf=$getDetFres[13];
$docRec=$getDetFres[10];

$intRate=$getDetFres[3];
$lonID=$getDetFres[15];
$dur=$getDetFres[2];



$confRes=$obj->select("configuration", "Active=1");
$confFres=$obj->Fetchrow($confRes);



$cutDate=date('Y')."-".date('m')."-".$confFres[14];


$memDetRes=$obj->select("membermast", "memNo='$mno'");
$memDetFres=$obj->fetchrow($memDetRes);

if ($memDetFres[18]!="0000-00-00"){
	$expMDt=explode("-", $memDetFres[18]);
	$tmdiff=mktime(0,0,0,date('m'),date('d'),date('Y'))- mktime(0,0,0,$expMDt[1],$expMDt[2],$expMDt[0]);
	$memDur=intval($tmdiff/ (24*60*60*30));
	
	
}else{
	$memDur=0;
}


$totPgdf=$obj->sumfield("mempgdf", "tfund", "memNo='$mno'");



if ($memDur < $minMem){
	print $set->jscriptalert("Your membership tennure is not matching with requirement, Please select other option");
	
	$set->redirect("preGen?lid=$lid&mno=$mno");
}else{

	if (floatval($pgdf) > 0){
		
		$elgAmnt=$totPgdf * ($pgdf/100);

	}	
	if ($gurMem > 0){
		
		$count=count ($gur);
		
		$gelgAmnt=$confFres[5] * $count;
	
	}
	
	if ($docRec > 0){
		$countLic=count($lic);
		for ($l=0; $l < $countLic ; $l++){
			$licRes=$obj->Select("licmaster", "licNo='$lic[$l]'");
			$licFres=$obj->fetchrow($licRes);
			$lelgAmnt=$lelgAmnt+$licFres[3];
		}
	
	}
	
	$totElgAmnt=$elgAmnt+$gelgAmnt+$lelgAmnt;
	
	if ($docRec > 0 || $gurMem > 0 || floatval($pgdf) >0){
	
		if ($totElgAmnt >= $aamnt ){
			$isuAmnt=$aamnt;
		}else{
			$isuAmnt=$totElgAmnt;
		}
		
		$msg= "Your application amount can not be more than Rs. $isuAmnt as per rule";
	}else{
		$isuAmnt=$aamnt;
	}
	
	$shrSum=$obj->sumfield("memshare", "shareNo", "memNo='$mno' and loanID=$lonID");
	$shrVal=$shrSum * $confFres[2];
	
	$rqShrVal=($isuAmnt * $confFres[6])/100;
	
	if ($rqShrVal > $shrVal){
	
		$shrAmnt=$rqShrVal-$shrVal;
	}else{
		$shrAmnt=0;
	}
	
	
	$gurFund=$isuAmnt * $confFres[4]/100;
	

	
	
	$cdt=date('Y-m-d');
	
	$mlRes=$obj->select("loanmem" ,"memNo='$mno' and loanID=$lonID and endFlg=1");
	$mlFres=$obj->Fetchrow($mlRes);
	$mRefSum=$obj->sumfield("loanrepaylist", "amount", "memNo='$mno' and LmID=$mlFres[0]");
	$refID=$mlFres[0];
		$balToRefund=$mlFres[8] - $mlFres[19] - $mRefSum;
	
	if ($cdt > $cutDate){
	
	
		
		
		$adjIsu=$isuAmnt - $balToRefund;
		
		$arearInt=$adjIsu * $intRate /(100*12);
	
	}else{
		$arearInt=0;
	}
	
	
	$emi=round($isuAmnt / $dur);
	



?>
<link rel="stylesheet" type="text/css" href="<?= $url?>lib/epoch_styles.css" />
<script type="text/javascript" src="<?= $url?>lib/epoch_classes.js"></script>
<script type="text/javascript">

	var pop_cal;
	window.onload=function(){
		
	
		pop_cal1= new Epoch('epoch_popup','popup',document.getElementById('apdt'));
		
		
	};
	
	function chkEmi(d){
	
		var p=document.getElementById('apamnt').value;
		var emi=eval(p) / eval(d);
		var remi=Math.round(emi,0);
		document.getElementById('emi').value=remi.toFixed(2);
		
	
	}
	function showDis(){
	
		var p=document.getElementById('apamnt').value;
		var s=document.getElementById('shamnt').value;
		var t=document.getElementById('pgamnt').value;
		var a=document.getElementById('balRef').value;
		
		var d=eval(p) - eval(s) - eval(t) - eval(a);
		
		alert ("Your disbursement amount - "+d.toFixed(2));
		 
	
	
	}
</script>

<div class="contDiv">
	<h2>Issue of <?= $getLoanFres[1]?> [ <?= $getDetFres[1]?> ]</h2>
	<form name="form1" method="post" action="genBack">
		
	  <div class="divLine">
			<table width="100%" border="0" cellspacing="0" cellpadding="3">
			  <tr>
				<td>Member Name </td>
				<td><?= $memDetFres[2]?></td>
				<td>Member Ship No </td>
				<td><?= sprintf("%04d",$mno)?></td>
			  </tr>
			  <tr>
				<td>Date of Membership </td>
				<td><?= $misc->dateformat($memDetFres[18]);?></td>
				<td>Total PGDF </td>
				<td><? printf("%0.2f", $totPgdf)?></td>
			  </tr>
			  <tr>
				<td>Chain No. </td>
				<td><?= $memDetFres[17]?></td>
				<td>Date of Retirement </td>
				<td><?= $misc->dateformat($memDetFres[19]);?></td>
			  </tr>
			</table>

		    <table width="100%" border="0" cellspacing="0" cellpadding="3" style="margin-top:2%;">
              <tr>
                <td width="14%" align="left" valign="top">Application No.</td>
                <td width="32%" align="left" valign="top"><input name="apno" type="text" size="10" required="required" title="Enter application form no." /><input name="mno" type="hidden" value="<?= $mno?>" /><input name="lonID" type="hidden" value="<?= $lonID?>" /><input name="sub" type="hidden" value="<?= $sub?>" /></td>
                <td width="16%" align="left" valign="top">Application Date </td>
                <td width="38%" align="left" valign="top"><input name="apdt" type="date" id="apdt" size="12" required="required" title="Enter application date"  /></td>
              </tr>
              <tr>
                <td align="left" valign="top">Application Amount </td>
                <td align="left" valign="top"><input name="apamnt" type="text" id="apamnt" value="<?= $isuAmnt?>" size="10" readonly="readonly" /><br /><?= $msg?></td>
                <td align="left" valign="top">Share Value </td>
                <td align="left" valign="top"><input name="shamnt" id="shamnt" type="text" value="<?= $shrAmnt?>" size="10" /></td>
              </tr>
              <tr>
                <td align="left" valign="top">PGDF</td>
                <td align="left" valign="top"><input name="pgamnt" id="pgamnt" type="text" value="<?= $gurFund?>" size="10" /></td>
                <td align="left" valign="top">Arear Interest</td>
                <td align="left" valign="top"><input name="arint" type="text" value="<?= $arearInt?>" size="10" /></td>
              </tr>
              <tr>
                <td align="left" valign="top">Loan Adjustment </td>
                <td align="left" valign="top"><input name="balRef" type="text" id="balRef" value="<?= $balToRefund?>" size="10" readonly="readonly" />
                <input name="refID" type="hidden" id="refID" value="<?= $refID?>" /></td>
                <td align="left" valign="top">Tennure</td>
                <td align="left" valign="top"><input name="dur" type="text" value="<?= $dur?>" size="10" onchange="chkEmi(this.value);" />
                &nbsp;</td>
              </tr>
              <tr>
                <td align="left" valign="top">Interest</td>
                <td align="left" valign="top"><input name="irat" type="text" id="irat" value="<?= $intRate?>" size="10" /></td>
                <td align="left" valign="top">Principal Pay </td>
                <td align="left" valign="top"><input name="emi" type="text" value="<?= $emi?>" id="emi" size="10" onblur="showDis();" />&nbsp;</td>
              </tr>
              <tr>
                <td align="left" valign="top">Issue Type </td>
                <td align="left" valign="top">
                  <?
				$countISM=count($isuMode);
				$ist=($_REQUEST['istyp']) ? $_REQUEST['istyp'] : 1;
				for ($i=1; $i < $countISM; $i++){
				
					if ($i==$ist){
						print "<input type='radio' name='istyp' value='$i' checked='checked'>$isuMode[$i]&nbsp; ";
					}else{
						print "<input type='radio' name='istyp' value='$i'>$isuMode[$i]&nbsp; ";
					}
				
				
				}
				
				
				
				
				?>                </td>
                <td align="left" valign="top">Issuing Category</td>
                <td align="left" valign="top">
                  <select name="iscat" id="iscat">
                    <?
				$countICT=count($lonIsuCat);
				$ict=($_REQUEST['iscat']) ? $_REQUEST['iscat'] : 1;
				for ($i=1; $i < $countICT; $i++){
				
					if ($i==$ict){
						print "<option value='$i' checked='checked'>$lonIsuCat[$i]</option> ";
					}else{
						print "<option value='$i'>$lonIsuCat[$i]</option> ";
					}
				
				
				}
				
				
				
				
				?>
                  </select>
                </td>
              </tr>
              <tr>
                <td align="left" valign="top">Loan Purpose </td>
                <td align="left" valign="top"><textarea name="purp" cols="25" rows="3" id="purp">&nbsp;</textarea></td>
                <td align="left" valign="top">Post Facto By</td>
                <td align="left" valign="top"><input name="pfby" type="text" id="pfby" size="25" /></td>
              </tr>
              <tr>
                <td align="left" valign="top">Guranteed by </td>
                <td align="left" valign="top">
				<?
				$countGur=count($gur);
				
				for ($g=0; $g < $countGur; $g++) {
					$gmDetRes=$obj->select("membermast", "memNo='$gur[$g]'");
					$gmDetFres=$obj->fetchrow($gmDetRes);
					print "<div><input type='checkbox' name='gur[]' value='$gur[$g]' checked='checked' readonly='readonly'> $gmDetFres[2]</div>";
				
				
				}
				
				?>
				
				</td>
                <td align="left" valign="top">LIC Policy No </td>
                <td align="left" valign="top">
				<?
				$countLic=count($lic);
				
				for ($l=0; $l < $countLic; $l++) {
					$licDetRes=$obj->select("licmaster", "licNo='$lic[$l]'");
					$licDetFres=$obj->fetchrow($licDetRes);
					print "<div><input type='checkbox' name='lic[]' value='$lic[$l]' checked='checked' readonly='readonly'> $licDetFres[1]</div>";
				
				
				}
				
				?>
				
				
				</td>
              </tr>
              <tr>
                <td>Payment Mode </td>
                <td><?
				$countPMode=count($payMode);
				$pm=($_REQUEST['pm']) ? $_REQUEST['pm'] : 1;
				for ($i=1; $i < $countPMode; $i++){
				
					if ($i==$ist){
						print "<input type='radio' name='pm' value='$i' checked='checked'>$payMode[$i]&nbsp; ";
					}else{
						print "<input type='radio' name='pm' value='$i'>$payMode[$i]&nbsp; ";
					}
				
				
				}
				
				
				
				
				?></td>
                <td><input type="submit" name="Submit" value="Save" />
                <input name="bCan" type="reset" id="bCan" value="Cancel" /></td>
                <td>&nbsp;</td>
              </tr>
            </table>
		</div>
	
	</form>
</div>
<?
}

require($rpath."pageFooter.tmp.php");

?>