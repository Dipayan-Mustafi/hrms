<? 
require ("../../../config/setup.inc");
$title="Form 5";

require($rpath."pageDesign.tmp.php");

$cdt=date('Y-m-d');

$lmt=15;



$type=$_REQUEST['typ'];
$fdt=$_REQUEST['fdt'];
$tdt=$_REQUEST['tdt'];
$lastday = date('t',strtotime($fdt));
$month=date("m", strtotime($fdt));
?>
<style type='text/css'>
 .ddhead { width:375mm; padding:5px; display:table; font-weight:bold; font-family:arial; font-size:12px;}
 .rowHead {width:375mm; display:table; font-family:arial; font-size:12px; border:solid 1px #666666; border-left:none; border-right:none;}
 .rowFoot {width:375mm; display:table; font-family:arial; font-size:12px; border:solid 1px #666666; border-left:none; border-right:none;page-break-after:always}
 .divCell {float:left}
 .divLine {width:100%;display:table; height:3%}

</style>
<div class="contDiv">
	<div style="text-align:right"><img src="<?= $rurl?>images/print_icon.gif" width="16" alt="Print Sheet" title="Print Salary Sheet" height="16" style="cursor:pointer;" onclick="PrintDiv('printArea', 'Form 5');" /></div>
	<div id="printArea" align="center">
		<table width="100%" border="0" style="font-size:12px">
				  <tr>
					<td align="center" colspan="5"><strong>FORM 5</strong><div> RETURN OF CONTRIBUTIONS</div><div>EMPLOYEES STATE INCURENCE CORPORATION</div><div style="font-size:12px">(Regulation 26)</td>
				  </tr>
				  <tr>
				  <tr>
					<td colspan="3" align="left">Name of Branch Office:</td>
					<td align="left" width="19%">&nbsp;</td>
					<td align="left" width="45%">Employer's Code No.:</td>
				  </tr>
					<tr>
					<td colspan="5">Name and Address of the Factory or Establishment : <strong>KANCHAN VANIJYA (P)LTD.- 13/3 Mahendra Roy Lane, emloyer address2</td>
					</tr>
				  <tr><td colspan="3"></tr>
				  <tr>
				  <tr>
					<td colspan="5">Particulars of the Principal employer(s)</td>
				  </tr>
				  <tr><td colspan="3"></tr>
				  <tr>
					<td width="4%">&nbsp;</td>
					<td width="12%">(a) Name:</td>
					<td width="20%">&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				  </tr>
				  <tr>
					<td>&nbsp;</td>
					<td>(b) Designation </td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				  </tr>
				  <tr>
					<td>&nbsp;</td>
					<td>(c) Residential Address:</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				  </tr>
	  </table>
	  <table width="100%" border="0" style="font-size:12px">
				  <tr>
					<td width="14%">Contribution Period from: </td>
					<td width="8%"><strong><?=$misc->dateformat($fdt)?></strong></td>
					<td width="2%">to</td>
					<td width="9%"><strong><?=$misc->dateformat($tdt)?></strong></td>
					<td width="67%">&nbsp;</td>
				  </tr>
	   </table>
		  <table width="100%" border="0" style="font-size:12px">
				  <tr>
					<td width="7%" align="center">&nbsp;</td>
					<td align="left">I furnish below the details of the Employer's and Employee's Share of contribution in respect of the under mentioned insured persons. I here by declare that the return </td>
					</tr>
				  <tr>
					<td width="7%" align="center">&nbsp;</td>
					<td align="left">includes each and every employee, employed directly or through an immediate employer or in connecttion with the work of the factory/establisment or any </td>
					</tr>
				<tr>
					<td width="7%" align="center">&nbsp;</td>
					<td align="left">work ________________ connected with the administration of the factory/establishment or purchase of raw materials, sale or distribution of finished products etc. to </td>
					</tr>
				<tr>
					<td width="7%" align="center">&nbsp;</td>
					<td align="left">whom the <strong>ESI act, 1948</strong> applies, in the contribution period to which this return relates and that the contributions in respect of employer's and employee's</td>
					</tr>
				<tr>
					<td width="7%" align="center">&nbsp;</td>
					<td align="left">share have been correctly paid in accordance with the provisions of the Act and Regulations.</td>
					</tr>
		</table>
		<table width="37%" border="1" bordercolor="#000000" cellpadding="1" align="left" style="font-size:12px">
				  <tr>
					<td width="35%">Employees's Share </td>
					<td width="65%"><strong>&nbsp;</strong></td>
				  </tr>
				  <tr>
					<td>Employer's Share </td>
					<td><strong>&nbsp;</strong></td>
				  </tr>
				  <tr>
					<td>Total Contribution </td>
					<td><strong>&nbsp;</strong></td>
				  </tr>
		  </table>
		  <table width="100%" border="1" cellpadding="1" cellspacing="1" style="font-size:12px">
				  <tr>
					<td width="8%"><strong>S. No </strong></td>
					<td width="14%" align="center"><strong>Month</strong></td>
					<td width="15%" align="center"><strong>Challan Number </strong></td>
					<td width="21%" align="center"><strong>Date of Challan </strong></td>
					<td width="15%" align="center"><strong>Amount</strong></td>
					<td width="27%" align="center"><strong>Name of the Bank and Branch </strong></td>
				  </tr>
				  <?
				  
				  
				  
				  
				  
				  ?>
				  <tr>
						<td style="border:thin; border-bottom:hidden; border-left:hidden; border-right:thin">&nbsp;</td>
						<td style="border:thin; border-bottom:hidden; border-left:hidden; border-right:thin">&nbsp;</td>
						<td style="border:thin; border-bottom:hidden; border-left:hidden; border-right:thin">&nbsp;</td>
						<td style="border:thin; border-bottom:hidden; border-left:hidden; border-right:thin">&nbsp;</td>
						<td style="border:thin; border-bottom:hidden; border-left:hidden; border-right:thin">&nbsp;</td>
						<td style="border:thin; border-bottom:hidden; border-left:hidden; border-right:thin">&nbsp;</td>
				  </tr>
	  </table>
</div>
</div>