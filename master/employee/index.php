<?
//error_reporting(E_ALL);
require ("../../config/setup.inc");



$title="Employee Section";

require($rpath."pageDesign.tmp.php");

$emp=new empManagement();

$et=($_REQUEST['et']) ? $_REQUEST['et'] : 1;
$pt=($_REQUEST['pt']) ? $_REQUEST['pt'] : 1;
$sxt=($_REQUEST['sxt']) ? $_REQUEST['sxt'] : 1;
$mtyp=($_REQUEST['mtyp']) ? $_REQUEST['mtyp'] :1;
$esa=($_REQUEST['esa']) ? $_REQUEST['esa'] : 1;
$epa=($_REQUEST['epa']) ? $_REQUEST['epa'] : 1;
$rlg=($_REQUEST['rlg']) ? $_REQUEST['rlg'] : 0;

$ec=($_REQUEST['ec']) ? $_REQUEST['ec'] : 0;
$id=($_REQUEST['id']) ? $_REQUEST['id'] : 0;
$deptS=($_REQUEST['sdept']) ? $_REQUEST['sdept'] : 0;

require ($root."lib/datetime/datetimepicker_css_js.php");

if ($id >0 || $ec){

	if($id>0){
		$eres=$obj->select("empmaster", "empID=$id");
	}elseif ($ec){
		$eres=$obj->select("empmaster", "empCode='$ec'");
	}
	$efres=$obj->fetchrow($eres);
	
	$et=$efres[1];
	$pt=$efres[13];
	$ename=$efres[3];
	$sxt=$efres[37];
	$dob=$efres[4];
	$email=$efres[9];
	$ph=$efres[5];
	$mob=$efres[6];
	$pan=$efres[7];
	$uid=$efres[8];
	$doj=$efres[10];
	$dsg=$efres[11];
	$dpt=$efres[12];
	$addr=$efres[14];
	$city=$efres[15];
	$zip=$efres[16];
	$stat=$efres[17];
	$cntry=$efres[18];
	$paddr=$efres[19];
	$pcity=$efres[20];
	$pzip=$efres[21];
	$pstat=$efres[22];
	$pcntry=$efres[23];
	$gname=$efres[24];
	$grel=$efres[25];
	$mtyp=$efres[26];
	$sname=$efres[27];
	$srel=$efres[28];
	$esa=$efres[29];
	$epa=$efres[30];
	$epno=$efres[31];
	$uan=$efres[32];
	$epbf=$efres[33];
	$pcomp=$efres[34];
	$basic=$efres[35];
	$esno=$efres[38];
	$rlg=$efres[44];
	$subGrp=$efres[45];
	$bAccnt=$efres[46];
	$ifsc=$efres[47];
	$pTxApp=$efres[48];
	

	



}


?>
<script type="text/javascript">

function fillText(){
	
	var saa=document.getElementById('saa');
	var addr=document.getElementById('addr').value;
	var city=document.getElementById('city').value;
	var est=document.getElementById('estat').value;
	var pin=document.getElementById('pin').value;
	var cnt=document.getElementById('cntry').value;
	
	var paddr=document.getElementById('paddr');
	var pcity=document.getElementById('pcity');
	var pest=document.getElementById('pestat');
	var ppin=document.getElementById('ppin');
	var pcnt=document.getElementById('pcntry');
	
	
	if (saa.checked==true){
		
		paddr.value=addr;
		pcity.value=city;
		pest.value=est;
		ppin.value=pin;
		pcnt.value=cnt;
	
	}else{
		paddr.value="";
		pcity.value="";
		pest.value="";
		ppin.value="";
		pcnt.value="";
	
	}

}
function getRef(i){
	
	window.location="?id="+i;
}
function getSet(i){
	window.location="salConfig?id="+i;
}

function getSetLev(i){
	window.location="levConfig?id="+i;
}
function getEc(){
	
	var ec=document.getElementById('spf').value;
		window.location="?ec="+ec;
}

function getDept(){
	var dept=document.getElementById('sdept').value;
	
	window.location="?sdept="+dept;
}

function chkForm(){

	var frm=document.form1
	if (frm.ename.value==""){
		alert ('Please enter employee name');
		frm.ename.focus();
		return false
	}else if(frm.doj.value==""){
		alert ('Please enter date of joining');
		frm.doj.focus();
		return false
	}else if(frm.dept.value=="0"){
		alert ('Please enter department');
		frm.dept.focus();
		return false
	}else{
		return true;
	}


}
function chkSalTyp(i){
	
	var ajaxRequest;
	if (window.XMLHttpRequest){
	// code for IE7+, Firefox, Chrome, Opera, Safari
	  	ajaxRequest=new XMLHttpRequest();
	}else{
		// code for IE6, IE5
		ajaxRequest=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	//Function which is receiving data sent from server
	ajaxRequest.onreadystatechange=function(){
		if (ajaxRequest.readyState==4 && ajaxRequest.status==200){
			
			document.getElementById('ptDiv').innerHTML=ajaxRequest.responseText;
			//document.getElementById('listShow').style.display="block";
			
			
		}else{
			//alert (ajaxRequest.status);
			document.getElementById('ptDiv').innerHTML="Loading.....";
		
		}
		
	}
		
	
		var qstring="?typ="+i;
		
		ajaxRequest.open("GET","GetAccountTyp.php" + qstring, true);
		ajaxRequest.send(null);
	



}
function endEmp(i){
	document.getElementById('endEmp').style.display="table";
	document.getElementById('mNo').value=i;
	
}
function clsPD(){

	document.getElementById('mNo').value=0;
	document.getElementById('dt').value=0;
	document.getElementById('endEmp').style.display="none";

	
}
function modPVal(){
	
	
	var i=document.getElementById('mNo').value;
	var v=document.getElementById('dt').value;
	clsPD();
	
	var ajaxRequest;
	if (window.XMLHttpRequest){
	// code for IE7+, Firefox, Chrome, Opera, Safari
	  	ajaxRequest=new XMLHttpRequest();
	}else{
		// code for IE6, IE5
		ajaxRequest=new ActiveXObject("Microsoft.XMLHTTP");
	}

	//Function which is receiving data sent from server
	ajaxRequest.onreadystatechange=function(){
		if (ajaxRequest.readyState==4 && ajaxRequest.status==200){

			
			
			
		}else{
			
			

		}

	}


		var qstring="?d="+v+"&i="+i;
		//alert(qstring);
		ajaxRequest.open("GET","endEmp.php" + qstring, true);
		ajaxRequest.send(null);
	

}
</script>

<style type="text/css">
#endEmp{display:none; width:150mm; height:20mm; padding:1pt; position:fixed; top:100mm; left:50mm; background-color:#FFFFFF; border:solid 1px #999999;}
.listTD{

	background-color:#FFFFFF;
	

}
.listTD:hover{
	background-color:#666666;
	color:#FFFFFF;
	display:block;
}
.divLine {
	width:100%;display:table; height:3%
}
</style>

<div class="contDiv">
<div class="divLine" align="right"><input type="image" align="right" border="1" src="<?= $rurl?>images/close.png" width="24" height="24" alt="Close" title="Close" style="cursor:pointer; margin:2; padding:9; border:#666666; border-style:dashed" onclick="navigate('../../index.php');" /></div>
	<div class="displayBox" style="width:68%;">
		<? 
		if($id>0){
		?>
		<div class="divLine" style="width:100%"> 
			<div style="float:right; width:10%;"><input type="button" value="Close" onclick="getRef(0);" /></div>
			<div style="float:right; width:10%;"><input type="button" value="Form 2" onclick="navigate('../../trans/sal/report/form2?ec=<?=$efres[2]?>')" /></div>
			<div style="float:right; width:10%;"><input type="button" value="View" onclick="navigate('../report/empDetails?ec=<?=$efres[2]?>')" /></div>
			<? if($efres[1]<3){?>
			<div style="float:right; width:10%;"><input type="button" value="Inactivate" onclick="endEmp(<?=$efres[0]?>);" /></div>
			<?
			}else{
			?>
			<div style="float:right; width:10%;"><input type="button" value="Inactivate" disabled="disabled" onclick="endEmp(<?=$efres[0]?>);" /></div>
			<?
			}
			?>
			<div id="endEmp" style="text-align:left; vertical-align:top">
				<div class="divLine" style="text-align:right"><input type="button" name="btn" onclick="clsPD();" value="Close" /></div>
				<div class="divLine">
					<div class="divCell" style="width:30mm;">Inactivation Date<input type="hidden" id="mNo" name="mNo" value="0" /></div>
					<div class="divCell" style="width:50mm;"><input type="date" id="dt" name="dt" value="0" size="20" /></div>
					<div class="divCell" style="width:20mm;"><input type="button"  name="btn" value="Modify" onclick="modPVal();"  /></div>
				</div>
			</div>
		</div>
		<h2>Modify Employee</h2>
		
		<? }elseif($ec){
		?>
		<div class="divLine" style="width:100%"> 
			<div style="float:right; width:10%;"><input type="button" value="Close" onclick="getRef(0);" /></div>
			<div style="float:right; width:10%;"><input type="button" value="Form 2" onclick="navigate('../../trans/sal/report/form2?ec=<?=$efres[2]?>')" /></div>
			<div style="float:right; width:10%;"><input type="button" value="View" onclick="navigate('../report/empDetails?ec=<?=$efres[2]?>')" /></div>
			<? if($efres[1]<3){?>
			<div style="float:right; width:10%;"><input type="button" value="Inactivate" onclick="endEmp(<?= $efres[0]?>);" /></div>
			<?
			}else{
			?>
			<div style="float:right; width:10%;"><input type="button" value="Inactivate" disabled="disabled" onclick="endEmp(<?=$efres[0]?>);" /></div>
			<?
			}
			?>
			<div id="endEmp" style="text-align:left; vertical-align:top">
				<div class="divLine" style="text-align:right"><input type="button" name="btn" onclick="clsPD();" value="Close" /></div>
				<div class="divLine">
					<div class="divCell" style="width:30mm;">Inactivation Date<input type="hidden" id="mNo" name="mNo" value="0" /></div>
					<div class="divCell" style="width:50mm;"><input type="date" id="dt" name="dt" value="0" size="20" /></div>
					<div class="divCell" style="width:20mm;"><input type="button"  name="btn" value="Modify" onclick="modPVal();"  /></div>
				</div>
			</div>
		</div>
		<h2>Modify Employee</h2>
				<?
			}else{
		?>
		
    	<h2>New Employee</h2>
		<? }?>
        <div class="listDiv">
        	<form name="form1" method="post" action="addBack" onsubmit="return chkForm();">
			
			  <table width="100%" border="0" cellspacing="0" cellpadding="3">
                  <tr>
                    <td>Employee Type </td>
                    <td><?
					$countET=count($empTyp);
					for ($i=1; $i < $countET; $i++){
						if ($et==$i){
							print "<input type='radio' value='$i' name='et' checked='checked' onchange='chkSalTyp($i);'> $empTyp[$i]&nbsp";
						}else{
							print "<input type='radio' value='$i' name='et' onchange='chkSalTyp($i);'> $empTyp[$i]&nbsp";
						}
					}
					
					?><input name="rid" type="hidden" value="<?= $efres[0]?>" /></td>
                    <td>Salary Type </td>
                    <td id="ptDiv">
					
					<select name="pt" id="pt">
					<?
					if ( $et==1){
						$countPT=count($payTyp);
						for ($i=1; $i < $countPT; $i++){
	
							if ($pt==$i){
								print "<option value='$i' selected='selected'> $payTyp[$i]</option> ";
							}else{
								print "<option value='$i'> $payTyp[$i]</option>";
							}
						}
					}else{
						print "<option value='0'> $payTyp[0]</option>";
					}
					?>	</select>				</td>
                  </tr>
                  <tr>
                    <td>Employee Name * </td>
                    <td><input name="ename" type="text" id="ename" size="25" value="<?= $ename?>" /></td>
                    <td>Gender</td>
                    <td><?
					$countSXT=count($sxTyp);
					for ($i=1; $i < $countSXT; $i++){
						if ($sxt==$i){
							print "<input type='radio' value='$i' name='sxt' checked='checked'> $sxTyp[$i]&nbsp";
						}else{
							print "<input type='radio' value='$i' name='sxt'> $sxTyp[$i]&nbsp";
						}
					}
					
					?></td>
                  </tr>
                  <tr>
                    <td>Date of Birth </td>
                    <td><input name="dob" type="text" id="dob" size="15" onClick="javascript:NewCssCal('dob','yyyyMMdd','','','','','past');" onFocus="javascript:NewCssCal('jdt','yyyyMMdd','','','','','past');" readonly="true" value="<?= $dob?>" /></td>
                    <td>Email </td>
                    <td><input name="email" type="text" id="email" value="<?= $email?>" /></td>
                  </tr>
                  <tr>
                    <td>Phone No. </td>
                    <td><input name="phno" type="text" id="phno" value="<?= $ph?>" /></td>
                    <td>Mobile No. </td>
                    <td><input name="mobile" type="text" id="mobile" value="<?= $mob?>" /></td>
                  </tr>
                  <tr>
                    <td>PAN No. </td>
                    <td><input name="pan" type="text" id="pan" size="23" value="<?= $pan?>" /></td>
                    <td>Adhaar No. </td>
                    <td><input name="uid" type="text" id="uid" value="<?= $uid?>" /></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr bgcolor="#ADD6D6">
                    <td><strong>Present Address</strong> </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>Address</td>
                    <td><textarea name="addr" id="addr" rows="3" /><?= $addr?></textarea></td>
                    <td>City/District</td>
                    <td><input name="city" type="text" id="city" value="<?= $city?>" /></td>
                  </tr>
                  <tr>
                    <td>Pin Code </td>
                    <td><input name="pin" type="text" id="pin" value="<?= $zip?>" /></td>
                    <td>State</td>
                    <td><input name="estat" type="text" id="estat" value="<?= $stat?>" /></td>
                  </tr>
                  <tr>
                    <td>Country</td>
                    <td><input name="cntry" type="text" id="cntry" value="<?= $cntry?>" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr bgcolor="#ADD6D6">
                    <td><strong>Permanent Address </strong></td>
                    <td><input name="saa" type="checkbox" id="saa" value="1" onclick="fillText();" />
                    Same as above </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>Address</td>
                    <td><textarea name="paddr" id="paddr" rows="3" /><?= $paddr?></textarea></td>
                    <td>City/District</td>
                    <td><input name="pcity" type="text" id="pcity" value="<?= $pcity?>" /></td>
                  </tr>
                  <tr>
                    <td>Pin Code </td>
                    <td><input name="ppin" type="text" id="ppin" value="<?= $pzip?>" /></td>
                    <td>State</td>
                    <td><input name="pestat" type="text" id="pestat" value="<?= $pstat?>" /></td>
                  </tr>
                  <tr>
                    <td>Country</td>
                    <td><input name="pcntry" type="text" id="pcntry" value="<?= $pcntry?>" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>Father's/ Husband's Name </td>
                    <td><input name="gname" type="text" id="gname" value="<?= $gname?>" /></td>
                    <td>Relation                    </td>
                    <td><input name="grel" type="text" id="grel" value="<?= $grel?>" /></td>
                  </tr>
                  <tr>
                    <td>Maritial Status </td>
                    <td><?
					
					$mcount=count($marTyp);
					for ($m=1; $m<$mcount;$m++){
						if ($mtyp==$m){
							print "<input type='radio' name='mtyp' value='$m' checked='checked'>$marTyp[$m]&nbsp;";
						}else{
							print "<input type='radio' name='mtyp' value='$m'>$marTyp[$m]&nbsp;";
						}
						
					}
					
					?></td>
                    <td>Religion</td>
                    <td><?
					$countRLG=count($relgnTypArray);
					for ($i=1; $i < $countRLG; $i++){
						if ($rlg==$i){
							print "<input type='radio' name='rlg' value='$i' checked='checked'>$relgnTypArray[$i]&nbsp;";
						}else{
							print "<input type='radio' name='rlg' value='$i'>$relgnTypArray[$i]&nbsp;";
						}
					}
					
					?></td>
                  </tr>
                  <tr>
                    <td>Spouse Name </td>
                    <td><input name="sname" type="text" id="sname" value="<?= $sname?>" /></td>
                    <td>Relation</td>
                    <td><input name="srel" type="text" id="srel" value="<?= $srel?>" /></td>
                  </tr>
                  <tr bgcolor="#ADD6D6">
                    <td><strong>Other</strong> </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>Designation</td>
                    <td><select name="desig" id="desig">
					<option value="0">--</option>
					<?
					$dsRes=$obj->Select("desigmast order by dsgName");
					while ($dsFres=$obj->fetchrow($dsRes)){
						if ($dsg==$dsFres[0]){
							print "<option value='$dsFres[0]' selected>$dsFres[1]</option>";
						}else{
							print "<option value='$dsFres[0]'>$dsFres[1]</option>";
						}
					
					}
					
					?>
					
					
                    </select>                    </td>
                    <td>Date of Joining*</td>
                    <td><input name="doj" type="text" id="doj" size="15" onclick="javascript:NewCssCal('doj','yyyyMMdd','','','','','past');" onfocus="javascript:NewCssCal('jdt','yyyyMMdd','','','','','past');" readonly="true" value="<?= $doj?>" /></td>
                  </tr>
                  <tr>
                    <td>Department*</td>
                    <td><select name="dept" id="dept">
					<option value="0">--</option>
					<?
					$dpRes=$obj->Select("deptmanager order by deptName");
					while ($dpFres=$obj->fetchrow($dpRes)){
						if ($dpt==$dpFres[0]){
							print "<option value='$dpFres[0]' selected>$dpFres[1]</option>";
						}else{
							print "<option value='$dpFres[0]'>$dpFres[1]</option>";
						}
					
					}
					
					?>
                    </select>                    </td>
                    <td>Sub-Group</td>
                    <td><select name="subGrp" id="subGrp">
					<option value="0">--</option>
					<?
						
					$sgRes=$obj->Select("subgrpmast");
					while($sgFres=$obj->fetchrow($sgRes)){
					if ($subGrp==$sgFres[0]){
							print "<option value='$sgFres[0]' selected>$sgFres[1]</option>";
						}else{
							print "<option value='$sgFres[0]'>$sgFres[1]</option>";
						}
					
					}
					
					?>
                    </select>  </td>
                  </tr>
                  
                  <tr>
                    <td>Bank Account No </td>
                    <td><input name="bAccnt" type="text" id="bAccnt" value="<?= $bAccnt?>" /></td>
                    <td>IFSC Code </td>
                    <td><input name="ifsc" type="text" id="ifsc" value="<?= $ifsc?>" /></td>
                  </tr>
                  <tr>
                    <td>Ptax Applicable</td>
                    <td><?
					$ccount=count($conTyp);
					
					for ($c=1; $c<$ccount; $c++){
						if ($pTxApp==$c){
							print "<input type='radio' name='ptx' value='$c' checked='checked'>$conTyp[$c]&nbsp;";
						}else{
							print "<input type='radio' name='ptx' value='$c'>$conTyp[$c]&nbsp;";
						}
						
					}
					
					?></td>
                    <td>&nbsp; </td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>ESI Applicable? </td>
                    <td><?
					$ccount=count($conTyp);
					
					for ($c=1; $c<$ccount;$c++){
						if ($esa==$c){
							print "<input type='radio' name='esa' value='$c' checked='checked'>$conTyp[$c]&nbsp;";
						}else{
							print "<input type='radio' name='esa' value='$c'>$conTyp[$c]&nbsp;";
						}
						
					}
					
					?></td>
                    <td>EPF Applicable? </td>
                    <td><?
					$ccount=count($conTyp);
					
					for ($c=1; $c<$ccount;$c++){
						if ($epa==$c){
							print "<input type='radio' name='epa' value='$c' checked='checked'>$conTyp[$c]&nbsp;";
						}else{
							print "<input type='radio' name='epa' value='$c'>$conTyp[$c]&nbsp;";
						}
						
					}
					
					?></td>
                  </tr>
                  <tr>
                    <td>ESI No. </td>
                    <td><input name="esno" type="text" id="esno" value="<?= $esno?>" /></td>
                    <td>EPF No. </td>
                    <td><input name="epno" type="text" id="epno" value="<?= $epno?>" /></td>
                  </tr>
                  <tr>
                    <td>UAN</td>
                    <td><input name="uan" type="text" id="uan" value="<?= $uan?>" /></td>
                    <td>EPF B/F Amount </td>
                    <td><input name="epbf" type="text" id="epbf" value="<?= $epbf?>" /></td>
                  </tr>
                  <tr>
                    <td>Previous Company Name </td>
                    <td><input name="bcomp" type="text" id="bcomp" value="<?= $pcomp?>" /></td>
                    <td>Basic Pay </td>
                    <td><input name="bpay" type="text" id="bpay" value="<?= $basic?>" /></td>
                  </tr>
                  <tr>
                    <td colspan="2">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  
                  <tr>
                    <td colspan="2">[*] are mandatory fields </td>
                    <td>&nbsp;</td>
                    <td><input name="bSav" type="submit" id="bSav" value="Submit" /></td>
                  </tr>
                </table>
			
			</form>
        </div>
       
    	
    </div>
	<div class="displayBox" style="width:25%; height:400px; overflow:auto;">
    	<h2>List of Employees</h2>
				<table border="0" cellpadding="3" width="100%">
					<tr>
						<td align="left" valign="top">PF. NUMBER</td><td width="31%"><input type="text" id="spf" name="spf" size="10" /></td>
					    <td width="31%"><input type="button" name="get" id="get" value="Search" onclick="getEc();" /></td>
					</tr>
					<tr>
					<td>Department</td>
                    <td colspan="2"><select name="sdept" id="sdept" style="display:inline" onchange="getDept();">
					<option value="0">--</option>
					<?
					$dpRes=$obj->Select("deptmanager order by deptName");
					while ($dpFres=$obj->fetchrow($dpRes)){
						if ($deptS==$dpFres[0]){
							print "<option value='$dpFres[0]' selected>$dpFres[1]</option>";
						}else{
							print "<option value='$dpFres[0]'>$dpFres[1]</option>";
						}
					
					}
					
					?>
                    </select></td>
					</tr>
				</table>
			</form>
        <div class="listDiv">
			<table border="0" cellpadding="3" width="100%">
				<tr>
				
					<th align="center" valign="top" class="listTD" style="cursor:pointer; border-bottom:solid 1px #333333;" >Name</th>
					<th align="center" valign="top" class="listTD" style="cursor:pointer; border-bottom:solid 1px #333333;" >Department</th>
				    <th align="center" valign="top" class="listTD" style="cursor:pointer; border-bottom:solid 1px #333333;" >&nbsp;</th>
				    <th align="center" valign="top" class="listTD" style="cursor:pointer; border-bottom:solid 1px #333333;" >&nbsp;</th>
				</tr>
			
			<?
			if($deptS>0){
				$res=$obj->select("empmaster", "empDept=$deptS order by empName");
			}else if($ec>0){
				$res=$obj->select("empmaster", "empCode=$ec order by empName");
			}else{
				$res=$obj->select("empmaster order by empName" );
			}
			while ($fres=$obj->fetchrow($res)){
				$dptRes=$obj->select("deptmanager", "deptID=$fres[12]");
				$dptFres=$obj->fetchrow($dptRes);
				
				?>
				<tr>
				
					<td class="listTD" style="cursor:pointer; border-bottom:solid 1px #333333;" onclick="getRef(<?= $fres[0]?>)"><?= $fres[3]?> </td>
					<td class="listTD" style="cursor:pointer; border-bottom:solid 1px #333333;" onclick="getRef(<?= $fres[0]?>)"><?= $dptFres[1]?> </td>
				
					<td class="listTD" style="cursor:pointer; border-bottom:solid 1px #333333;" onclick="getSetLev(<?= $fres[0]?>)"><img src="<?= $rurl?>images/leave.png" width="16" height="16" /></td>
					<td class="listTD" style="cursor:pointer; border-bottom:solid 1px #333333;" onclick="getSet(<?= $fres[0]?>)"><img src="<?= $rurl?>/images/settingsIcon.png" width="16" height="16" /> </td>
				</tr>
				<?
			}
			?>
			</table>	
        </div>
        
    	
    </div>


</div>