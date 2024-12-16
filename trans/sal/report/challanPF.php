<?

require ("../../../config/setup.inc");

$title="Monthy PF Report";

require($rpath."pageDesign.tmp.php");

$dept=$_REQUEST['dept'];
$m=$_REQUEST['mnth'];
$yr=$_REQUEST['year'];

$d=cal_days_in_month(CAL_GREGORIAN,"$m","$yr");

$sm=sprintf("%02d",$m);

$page=0;

$strDt="$yr-$sm-01";
print $m;
?>
<script type="text/javascript">
function fillMnth(a){
		
		document.getElementById('mnth').value=a;
	}	
function fillyr(b){
		
		document.getElementById('year').value=b;
	}
function fillDept(c){
		
		document.getElementById('dept').value=c;
	}
function goNext(){
		
	if (document.getElementById('mth').value==0){
		alert ("Please select Proper Month");
	}else if (document.getElementById('yr').value==0){
		alert ("Please select Proper year");
	}else{
			document.form1.submit();
	}
	
	
}		
</script>



<center>
<div class="contDiv">
	<div style="text-align:right"><img src="<?= $rurl?>images/print_icon.gif" width="32" alt="Print Sheet" title="Print Report" height="32" style="cursor:pointer;" onclick="PrintDiv('printArea', 'EPForg Challan');" /></div>
	<form name="form1" action="" method="post">
	 <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#999999">
			<tr>
			<th width="18%" align="center">Select Month</th>
            <th width="32%" align="left" valign="top"> <select id="mth" name="mth" onChange="fillMnth(this.value);">
									<option value="0" selected="selected">--</option>
				<?
					$cMnth=count($mnthArray);
					for ($i=1;$i<$cMnth; $i++){
							
								print "<option value='$i'>$mnthArray[$i]</option>";
						}
				?>
				</select>
				<input type="hidden" name="mnth" id="mnth"/>
			</th>
			
			<th width="18%" align="center"> Select Year</th>
			<th width="32%" align="left" valign="top"> <select id="yr" name="yr" onChange="fillyr(this.value);">
								<option value="0" selected="selected">--</option>
				<?
					 for ($i=$styr; $i<=date('Y'); $i++){
						
							print "<option value='$i'>$i</option>";
						
					  }
				?>
				</select>
				<input type="hidden" name="year" id="year"/>
			</th>
			</tr>
	  </table>
			<table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC">
			<tr>
			<th width="18%" align="center"> Select Department</th>
			<th width="82" align="left" valign="top"> <select id="dpt" name="dpt"  onChange="fillDept(this.value);">
									<option value="0" selected="selected">ALL</option>
				<?
					 $res=$obj->select("deptmanager");
					 while($fres=$obj->fetchrow($res)){
						
							print "<option value='$fres[0]'>$fres[1]</option>";
						
					  }
				?>
				</select>
				<input type="hidden" name="dept" id="dept"/>
			</th>
			</tr>
		  </table>
		  <table width="100%" border="0" cellpadding="3" cellspacing="0">
		  <tr>
		  <th><input type="button" name="btnAll" id="btnAll" value="Preview" onclick="goNext();">
		  </th>
		  </tr>
		  </table>
</form>
	
	<div id="printArea" align="center" style="page-break-inside:auto">
	<div style="height:210mm; page-break-after:always">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family:arial; font-size:10px;" >
      <tr>
        <td width="11%" height="116" colspan="1" align="center"><img src="EPForg.jpg" width="83" height="67"/></td>
        <td colspan="8" align="center" style="font-size:12px"><h3>COMBINED CHALLAN OF A/C NO. 01, 02, 10, 21 &amp; 22 (With ECR)<br />
							(STATE BANK OF INDIA)<br />
              EMPLOYEES' PROVIDENT FUND ORGANISATION
                  <br />
        KOLKATA            </h3> </td>
      </tr>
      <tr>
        <td height="35">&nbsp;</td>
        <td colspan="7">&nbsp;</td>
        <td width="17%" height="35" valign="top" align="right"><strong>TRRN:4701512013819<br/>
		Employer E-Sewa</strong></td>
      </tr>
      <tr>
        <td height="21" colspan="9" valign="top">ESTABLISHMENT CODE & NAME : WBCAL0025282000 KANCHAN VANIJYA PVT. LTD.,</td>
      </tr>
      <tr>
        <td height="20" colspan="9" valign="top">ADDRESS : JHARGRAM, MEDINIPORE(E)</td>
      </tr>
      <tr>
        <td height="20" colspan="9" valign="top" align="right">Dues for the wage month of:</td>
      </tr>
      <tr>
        <td>TOTAL SUBSCRIBERS: </td>
        <td>&nbsp;</td>
        <td align="right">A/C.01</td>
        <td>&nbsp;</td>
        <td align="right">A/C.10</td>
        <td>&nbsp;</td>
        <td align="right">A/C.21</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>TOTAL WAGES: </td>
        <td width="20%">&nbsp;</td>
        <td width="5%" align="right">A/C.01</td>
        <td width="12%">&nbsp;</td>
        <td width="4%" align="right">A/C.10</td>
        <td width="10%">&nbsp;</td>
        <td width="5%" align="right">A/C.21</td>
        <td width="16%">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
	   <tr>
	  	<td height="20" colspan="9" valign="top" align="right" style="border-bottom:thick" bordercolor="#000000"></td>
	  </tr>
    </table>
	<table width="100%" border="0" cellspacing="0" cellpadding="3" style="font-family:arial; font-size:10px; font-weight:50">
  <tr>
    <td width="5%" height="34" align="center" valign="bottom" style="border-top:1px solid; border-bottom:1px solid"> SL.</td>
    <td width="31%" valign="bottom" align="left" style="border-top:1px solid; border-bottom:1px solid">PARTICULARS</td>
    <td width="12%" valign="bottom" colspan="2" align="center" style="border-top:1px solid; border-bottom:1px solid">A/C.01</td>
    <td width="12%" valign="bottom" style="border-top:1px solid; border-bottom:1px solid" align="center">A/C.02</td>
    <td width="11%" valign="bottom" style="border-top:1px solid; border-bottom:1px solid" align="center">A/C.10</td>
    <td width="10%" valign="bottom" style="border-top:1px solid; border-bottom:1px solid" align="center">A/C.21</td>
    <td width="12%" valign="bottom" style="border-top:1px solid; border-bottom:1px solid" align="center">A/C.22</td>
     <td width="7%" valign="bottom" style="border-top:1px solid; border-bottom:1px solid" align="center">Total</td>
  </tr>
  <tr>
    <td align="center">1.</td>
    <td>EMPLOYER'S SHARE OF CONT.</td>
    <td colspan="2" align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">2.</td>
    <td>EMPLOYEE'S SHARE OF CONT.</td>
    <td colspan="2" align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">3.</td>
    <td>ADMIN CHARGES</td>
    <td colspan="2" align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">4.</td>
    <td>INSPECTION CHARGES</td>
    <td colspan="2" align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">5.</td>
    <td>PENAL DAMAGES</td>
    <td colspan="2" align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">6.</td>
    <td>MISC. PAYMENT (INTEREST U/S 7Q)</td>
   <td colspan="2" align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td height="38" colspan="3" valign="top" style="border-top:1px solid; border-bottom:1px solid">GRAND TOTAL (IN WORDS) :</td>
    <td style="border-top:1px solid; border-bottom:1px solid">&nbsp;</td>
    <td style="border-top:1px solid; border-bottom:1px solid">&nbsp;</td>
    <td style="border-top:1px solid; border-bottom:1px solid">&nbsp;</td>
    <td style="border-top:1px solid; border-bottom:1px solid">&nbsp;</td>
    <td style="border-top:1px solid; border-bottom:1px solid">&nbsp;</td>
    <td style="border-top:1px solid; border-bottom:1px solid">&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="3" style="font:'Times New Roman', Times, serif; margin-top:1%; font-size:10px">
  <tr>
    <td width="51%"><strong>FOR BANK USE ONLY </strong></td>
    <td width="49%"><strong>FOR ESABLISMENT USE ONLY</strong> (To be manually filled by Employer)</td>
  </tr>
  <tr>
    <td>Amount Recived Rs. -------------------------------------------------------------------</td>
    <td>Cheque/DD No. --------------------------------- Date: -------------</td>
  </tr>
  <tr>
    <td>Date of presentation of Cheque/DD -----------------------------------------------------</td>
    <td>Cheque/DD drawn bank &amp; Branch-------------------------------------------------------</td>
  </tr>
  <tr>
    <td>Date of Realisation of Cheque/DD ------------------------------------------------------</td>
    <td>Name of the Depositer----------------------------------------------------</td>
  </tr>
  <tr>
    <td>SBI Branch Name-----------------------------------------------------------------------</td>
    <td>Date of Deposit----------------- Mobile No. -----------------</td>
  </tr>
  <tr>
    <td>SBI Branch Code-----------------------------------------------------------------------</td>
    <td>Signature of the Depositor-------------------------------------------------</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td style="border:1px solid; padding:2px" align="center"><strong>(KINDLY SUBMIT CHEQUE/DEMAND DRAFT & CHALLAN AT SBI COUNTER ONLY)</strong></td>
  </tr>
  <tr>
    <td colspan="2">   (This is a system generated challan generated on 29/12/2015 11:50, the particulars shown in this challan are populated from the Electronics Challan Return (ECR) uploaded by the establishment for the<br />
    specified month and year. Remittance can be made through a local Cheque/DD in any designated branch of SBI)<br/>
	<strong>This Challan is not the proof of payment of PF Dues. For confirming remittance status, please visit</strong> www.epfindia.gov.in >> <strong>TRRN Query</strong></td>
  </tr>
</table>
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="3" style="font-size:9px">
  <tr>
    <td colspan="3" align="center"><h4>EMPLOYEES' PROVIDENT FUND ORGANISATION KOLKATA<br/>
					ELECTRONIC CHALLAN CUM RETURN (ECR)<br/>
						FOR THE WAGE MONTH OF () AND RETURN MONTH()</h4>      </td>
    </tr>
  <tr>
    <td width="10%">ESTABLISHMENT ID </td>
    <td width="53%">: WBCAL0025282000</td>
    <td width="37%" align="right">Employer E-Sewa </td>
  </tr>
  <tr>
    <td>NAME OF ESTABLISHMENT</td>
    <td>: KANCHAN VANIJYA PVT. LTD.</td>
    <td align="right" valign="top">ECR UPLOADED </td>
  </tr>
  <tr>
    <td>TRRN</td>
    <td>:4701512013819</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="30" colspan="3" align="left" valign="bottom"><strong>PART A-MEMBERS' WAGE DETAILS</strong></td>
    </tr>
</table>
<table width="100%" border="1" cellspacing="0" cellpadding="3" style="font-size:10px">
  <tr>
    <td width="3%">SL No</td>
    <td width="5%" align="center">Member Id </td>
    <td width="15%" align="center">Member Name </td>
    <td width="5%" align="center">EPF Wages </td>
    <td width="5%" align="center">EPS Wages </td>
    <td width="8%" align="center">EPF Contribution (EE Share) Due </td>
    <td width="8%" align="center">EPF Contribution (EE Share) being Remitted </td>
    <td width="7%" align="center">EPS Contribution Due </td>
    <td width="8%" align="center">EPS Contribution being remitted </td>
    <td width="8%" align="center">Diff EPF and EPS Contribution(ER Share) Due </td>
    <td width="12%" align="center">Diff EPF and EPS Contribution(ER Share) being remitted </td>
    <td width="6%" align="center">NCP DAYS </td>
    <td width="10%" align="center">Refund Of Advances </td>
  </tr>
  <?
  if($dept>0){
					$deptRes=$obj->select("deptmanager", "deptID='$dept'");
				}else{
					$deptRes=$obj->select("deptmanager", "deptID<>1");
				}
				while($deptFres=$obj->fetchrow($deptRes)){
				
				$res=$obj->select("empmaster", "(empTyp=1 or empTyp=3) and empDept='$deptFres[0]' and (modDate>'$strDt' or modDate='0000-00-00') and empSubGrp=$sgdisFres[0] order by empName");
				$rows=$obj->rows($res);
			while($fres=$obj->fetchrow($res)){
			
			$s++;
			
	?>
  <tr>
    <td><?=$s?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?
  }
  }
  ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>


</div>
