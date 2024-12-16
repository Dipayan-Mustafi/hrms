<? 
require ("../../../config/setup.inc");
$title="Form 2";

require($rpath."pageDesign.tmp.php");

$cdt=date('Y-m-d');

$lmt=15;

$ec=$_REQUEST['ec'];

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
<div class="contDiv" style="font:'Times New Roman', Times, serif; font-weight:100">
	<div style="text-align:right"><img src="<?= $rurl?>images/print_icon.gif" width="16" alt="Print Sheet" title="Print Salary Sheet" height="16" style="cursor:pointer;" onclick="PrintDiv('printArea', 'Form 2');" /></div>
  <div id="printArea" align="center">
  	<div class="divLine" style="page-break-after:always;">
		<table width="95%" border="0" style="font-size:16px">
				  <tr>
				  	<td width="12%" height="124" colspan="1" align="right"><img src="<?= $rurl?>images/logo_pf.jpg" width="148" height="122" /></td>
					<td colspan="3" align="center"><h4>FORM - 2 (Revised)</h4>
				    <div><h3>NOMINATION AND DECLARATION FORM</h3>
			        <h4>FOR EXEMPTED / UNEXEMPTED ESTABLISHMENTS</h4></div></td>
					<td width="10%" colspan="1">&nbsp;</td>
				  </tr>
				  <tr>
				  	<td colspan="5" align="center" style="font-size:14px">Declaration and Nomination Form Under the Employee's Provident Funds & Employees' Pension Scheme</td>
			  	  </tr>
				  <tr>
				    <td colspan="5" align="center" style="font-size:12px">(Paragraph 33 &amp; 61 (1) of the Employees' Provident Fund Scheme, 1952 &amp; Paragraph 18 of the Employees's Pension Scheme, 1995)</td>
          </tr>
	  </table>
	  <?php
	  	$res=$obj->select("empmaster", "empCode=$ec");
		$fres=$obj->fetchrow($res);
		
		
	  ?>
  <table width="95%" align="center" border="1" style="font-size:14px" cellpadding="3" cellspacing="0">
			<tr style="border:hidden">
				<td width="4%" height="32" align="center" style="border:hidden">1</td>
				<td align="left" colspan="2" style="border:hidden">Name ( In Block Letters)</td>
				<td width="2%" style="border:hidden">:</td>
				<td colspan="5" style="border-right:hidden; border-top:hidden; border-left:hidden; border-bottom:1px solid"><?=strtoupper($fres[3])?></td>
			</tr>
			<tr style="border:hidden">
				<td width="4%" height="27" align="center" style="border:hidden">2</td>
				<td colspan="2" style="border:hidden">Father&rsquo;s / Husband&rsquo;s Name</td>
				<td width="2%" style="border:hidden"> :</td>
				<td colspan="5" style="border:hidden; border-bottom:1px solid"> <?=strtoupper($fres[24])?> </td>
			</tr>
			<tr style="border:hidden">
				<td width="4%" height="27" align="center" style="border:hidden"> 3 </td>
				<td colspan="2" style="border:hidden"> Date of Birth </td>
				<td width="2%" style="border:hidden"> : </td>
				<td colspan="5" style="border:hidden; border-bottom:1px solid"><?=$misc->dateformat($fres[4])?></td>
			</tr>
			<tr style="border:hidden">
				<td width="4%" height="27" align="center" style="border:hidden"> 4 </td>
				<td colspan="2" style="border:hidden"> Sex </td>
				<td width="2%" style="border:hidden"> : </td>
				<td colspan="5" style="border:hidden; border-bottom:1px solid"> <?=$genTyp[$fres[37]]?> </td>
			</tr>
			<tr>    <td width="4%" height="27" align="center" style="border:hidden"> 5 </td>
				<td colspan="2" style="border:hidden"> Marital Status </td>
				<td width="2%" style="border:hidden"> : </td>
				<td colspan="5" style="border:hidden; border-bottom:1px solid"> <?=$marTyp[$fres[26]]?> </td>
			</tr>
			<tr style="border:hidden">
				<td width="4%" height="30" align="center" style="border:hidden"> 6 </td>
				<td colspan="2" style="border:hidden"> Account Number </td>
				<td width="2%" style="border:hidden"> : </td>
				<td width="7%" align="center" style="border:solid">WB</td>
			    <td width="10%" align="center" style="border:solid">CAL</td>
			    <td width="23%" align="center" style="border:solid">000252800000</td>
			    <td width="10%" align="center" style="border:solid"><?=$fres[31]?></td>
			    <td width="12%" style="border:hidden">&nbsp;</td>
			</tr>
			<tr style="border:hidden">
				<td width="4%" rowspan="2" align="center" valign="top" style="border:hidden"> 7 </td>
				<td width="21%" rowspan="2" style="border:hidden" valign="top"> Address </td>
				<td width="11%" height="27" style="border:hidden">Permanent</td>
				<td width="2%" style="border:hidden"> : </td>
				<td colspan="5" style="border:hidden; border-bottom:1px solid"><?=$fres[19].",".$fres[20]."-".$fres[21].",".$fres[22].",".$fres[23]?></td>
			</tr>
			<tr style="border:hidden">
			  <td height="27" style="border:hidden">Temporary</td>
	          <td width="2%" style="border:hidden"> : </td>
	          <td colspan="5" style="border:hidden; border-bottom:1px solid"><?=$fres[14].",".$fres[15]."-".$fres[16].",".$fres[17].",".$fres[18]?></td>
		</tr>
			<tr style="border:hidden">
				<td width="4%" rowspan="4" align="center" valign="top" style="border:hidden"> 8 </td>
				<td rowspan="4" style="border:hidden" valign="top"> Date of Joining </td>
				<td height="27" style="border:hidden">&nbsp;</td>
				<td width="2%" style="border:hidden"> : </td>
				<td colspan="5" style="border:hidden; border-bottom:1px solid"><?=$misc->dateformat($fres[10])?></td>
			</tr>
			<tr style="border:hidden">
			  <td height="27" style="border:hidden">EPF</td>
	          <td width="2%" style="border:hidden"> : </td>
		      <td colspan="5" style="border:hidden; border-bottom:1px solid"><?=$misc->dateformat($fres[10])?></td>
    </tr>
			
			<tr style="border:hidden">
			  <td height="27" style="border:hidden">EPS</td>
	          <td width="2%" style="border:hidden"> : </td>
		      <td colspan="5" style="border:hidden; border-bottom:1px solid"><?=$misc->dateformat($fres[10])?></td>
	  </tr>
	  		<tr style="border:hidden">
			  <td height="27" style="border:hidden">&nbsp;</td>
			  <td style="border:hidden">&nbsp;</td>
			  <td colspan="5" style="border:hidden;">&nbsp;</td>
	    </tr>
      </table>
	  <div style="height:3px">&nbsp;</div>
	  <table width="95%" align="center" border="0" style="font-size:14px">
	  	<tr>
			<td colspan="2" align="center" style="border:hidden; font-size:14px"><strong>PART - A (EPF)</strong></td>
		</tr>
		<tr>
		  <td align="left" style="font-size:14px"> I here by nominate the person(s) / cancel the nomination made by me previously and person(s) mentioned below to</td>
		</tr>
		<tr>
		  <td align="left"  style="font-size:14px"> receive the amount standing to my credit in the Employees&rsquo; Provident Fund, in the event of my death. </td>
	    </tr>
	  </table>
	  <div style="height:3px">&nbsp;</div>
  	  <table width="95%" align="center" border="1" cellpadding="3" cellspacing="0" style="font-size:12px">
        <tr>
          <td width="21%" height="53" align="center">Name &amp; Address of the Nominee/ Nominees</td>
          <td width="20%" align="center">Nominee&rsquo;s relationship with the member</td>
          <td width="10%" align="center">Date of Birth</td>
          <td width="24%" align="center">Total amount of share of <br/>
            accumalation in provident<br/>
          fund to be paid to each nominee</td>
          <td width="25%" align="center">if the nominee is minor name &amp;<br/>
          address &amp; relationship of the<br/>guardian who may recive the amount</td>
        </tr>
        <tr>
          <td height="24" align="center">1</td>
          <td align="center">2</td>
          <td align="center">3</td>
          <td align="center">4</td>
          <td align="center">5</td>
        </tr>
		<div id="nm" style="height=86">
		<?
		$nmRes=$obj->select("empnominee", "EmpCode='$ec' and endFlg=1");
		$nmRows=$obj->rows($nmRes);
		while($nmFres=$obj->fetchrow($nmRes)){
		
		
		
		$nameAdd=strtoupper("<strong>$nmFres[2]</strong><p>$nmFres[6]</div></p>");
		if($nmRows>1){
		?>
        <tr style="border-bottom:0.5px solid; font-size:9px">
		  <td><?=$nameAdd?></td>
          <td align="center"><strong><?=strtoupper($nmFres[3])?></strong></td>
          <td align="center"><?=$misc->dateformat($nmFres[5])?></td>
          <td align="center"><?=$nmFres[4]?>%</td>
		  <td>&nbsp;</td>
        </tr>
		<?
		}else{
		?>
		<tr style="font-size:9px">
          <td><?=$nameAdd?></td>
          <td align="center"><?=strtoupper($nmFres[3])?></td>
          <td align="center"><?=$misc->dateformat($nmFres[5])?></td>
          <td align="center"><?=$nmFres[4]?>%</td>
          <td>&nbsp;</td>
        </tr>
		<?
		}
		}
		?>
		</div>
      </table>
	  <div style="height:3px">&nbsp;</div>
	  <table width="95%" align="center" border="0" style="font-size:12px">
	  	<tr>
			<td width="3%" height="30">1</td>
			<td width="97%">Certified that I have no family as defined in para 2 (g) of the Employee's Provident Fund Scheme 1952 and should I acquire a family hereafter the above nomination should be deemed as cancelled</td>
		</tr>
		<tr>
			<td width="3%" height="24">2</td>
			<td width="97%">Certified that my father / mother is / are depended upon me.</td>
		</tr>
		<tr>
			<td width="3%" height="31">3</td>
			<td width="97%">Unmarried members in the absence of dependent parents may nominate any other person to receive the shares</td>
		</tr>
	  </table>
	  <div style="height:3px">&nbsp;</div>
  	  <table width="85%" border="0" cellspacing="0" style="font-size:14px" align="center">
        <tr>
          <td width="45%" height="77" style="border:solid; font-size:14px" align="center"><strong>Note:</strong> A Fresh nomination shall be made by the member on his/her marriage and any nomination made before such marriage shall be deemed to be invalid</td>
          <td width="55%" align="center" valign="bottom">Signature or thumb impression of the Subscriber</td>
        </tr>
      </table>
  	</div>
	<div class="divCell" style="width:100%">&nbsp;</div>
	<div class="divLine">
	
		<table width="95%"  align="center" border="0" style="font-size:13px">
			  <tr>
				<td height="27" align="center" style="font-size:14px"><strong>PART - B (EPS)</strong></td>
			  </tr>
			  <tr>
				<td align="left">I hereby furnish below particulars of the members of my family who would be eligible to receive widow/children pension</td>
			  </tr>
			  <tr>
				<td align="left">in the event of my death</td>
			  </tr>
		</table>
		<div class="divCell" style="width:100%">&nbsp;</div>
		<table width="95%" align="center" border="1" cellspacing="0" cellpadding="3" style="font-size:14px">
		  <tr>
			<td width="6%" align="center"><strong>S.No</strong></td>
			<td width="32%" align="center"><strong>Name of the Family Members</strong></td>
			<td width="33%" align="center"><strong>Address</strong></td>
			<td width="14%" align="center"><strong>Date of Birth</strong></td>
			<td width="15%" align="center"><strong>Relationship</strong></td>
		  </tr>
		  <?
		  $s=0;
		$nmRes=$obj->distinct("empnominee", "nmId","EmpCode='$ec'");
		while($nmFres=$obj->fetchrow($nmRes)){
			
			$fmRes=$obj->select("empnominee", "nmId=$nmFres[0]");
			$fmFres=$obj->fetchrow($fmRes);
			
			$name[$s]=strtoupper($fmFres[2]);
			$add[$s]=strtoupper($fmFres[6]);
			$dob[$s]=$misc->dateformat($fmFres[5]);
			$nmRel[$s]=strtoupper($fmFres[3]);
			$s++;	
		}
		
		?>
		  <tr style="font-size:9px">
			<td align="center">1.</td>
			<td><?=$name[0]?></td>
			<td><?=$add[0]?></td>
			<td><?=$dob[0]?></td>
			<td><?=$nmRel[0]?></td>
		  </tr>
		  <tr style="font-size:9px">
			<td align="center">2.</td>
			<td><?=$name[1]?></td>
			<td><?=$add[1]?></td>
			<td><?=$dob[1]?></td>
			<td><?=$nmRel[1]?></td>
		  </tr>
		  <tr style="font-size:9px">
			<td align="center">3.</td>
			<td><?=$name[2]?></td>
			<td><?=$add[2]?></td>
			<td><?=$dob[2]?></td>
			<td><?=$nmRel[2]?></td>
		  </tr>
		  <tr style="font-size:9px">
			<td align="center">4.</td>
			<td><?=$name[3]?></td>
			<td><?=$add[3]?></td>
			<td><?=$dob[3]?></td>
			<td><?=$nmRel[3]?></td>
		  </tr>
		  <tr style="font-size:9px">
			<td align="center">5.</td>
			<td><?=$name[4]?></td>
			<td><?=$add[4]?></td>
			<td><?=$dob[4]?></td>
			<td><?=$nmRel[4]?></td>
		  </tr>
		</table>
		<div class="divCell" style="width:100%">&nbsp;</div>
		<table width="95%"  align="center" border="0" style="font-size:13px">
		  <tr>
			<td align="left">Certified that I have no family as defined in para 2 (vii) of the Employee's Pension Scheme 1995 and should I acquire a</td>
		  </tr>
		  <tr>
			<td align="left">family hereafter the above nomination should be deemed as cancelled</td>
		  </tr>
		</table>
		<div class="divCell" style="width:100%">&nbsp;</div>
		<table width="95%"  align="center" border="0" style="font-size:13px">
		  <tr>
			<td align="left">I hereby nominate the following person for receiving the monthly widow pension (admissible under para 16(2) (g) (I) &</td>
		  </tr>
		  <tr>
			<td align="left">(ii) in the event of my death with out leaving any eligible family member for receiving pension.</td>
		  </tr>
		</table>
		<div class="divCell" style="width:100%">&nbsp;</div>
		<table width="95%" align="center" border="1" cellspacing="0" cellpadding="3">
		  <tr>
			<td width="45%" align="center"><strong>Name &amp; Address of the Nominee</strong></td>
			<td width="16%" align="center"><strong>Date of Birth</strong></td>
			<td width="39%" align="center"><strong>Relationship with the member</strong></td>
		  </tr>
		  <div id="nm" style="height=86">
		<?
		$nmRes=$obj->select("empnominee", "EmpCode='$ec' and endFlg=1");
		$nmRows=$obj->rows($nmRes);
		while($nmFres=$obj->fetchrow($nmRes)){
		
		
		
		$nameAdd=strtoupper("<strong>$nmFres[2]</strong><p>$nmFres[6]</div></p>");
		if($nmRows>1){
		?>
		  <tr style="border-bottom:0.5px solid; font-size:9px">
			<td ><?=$nameAdd?></td>
			<td align="center"><?=$misc->dateformat($nmFres[5])?></td>
			<td align="center"><?=$nmFres[3]?></td>
		  </tr>
		<?
		}else{
		?>
		 <tr style="border-bottom:0.5px solid; font-size:9px">
			<td ><?=$nameAdd?></td>
			<td align="center"><?=$misc->dateformat($nmFres[5])?></td>
			<td align="center"><?=$nmFres[3]?></td>
		  </tr>
		<?
		}
		}
		?>
		</div>
		</table>
		<div class="divCell" style="width:100%; height:2%">&nbsp;</div>
		<table width="95%" align="center" border="0" cellspacing="0" cellpadding="3">
		  <tr>
			<td width="49%"><strong>Date :</strong></td>
			<td colspan="2">&nbsp;</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td width="4%">&nbsp;</td>
		    <td width="47%">x</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td colspan="2"><strong>Signature / Thumb impression of the subscriber</strong></td>
		  </tr>
		</table>
		<div class="divCell" style="width:100%; height:2%">&nbsp;</div>
		<table width="95%" align="center" border="1" cellspacing="0" cellpadding="3" style="font-size:12px">
		  <tr style="border:hidden">
			<td height="25" align="center" style="border:hidden; font-size:14px"><strong>CERTIFICATE BY EMPLOYER</strong></td>
		  </tr>
		  <tr style="border:hidden">
			<td style="border:hidden">Certified that the above declaration and nomination has been signed/thumb impressed before shri/Smt/Kum &#133;&#133;&#133;&#133;</td>
		  </tr>
		  <tr style="border:hidden">
			<td style="border:hidden">.........&#133;&#133;&#133;&#133;&#133;&#133;&#133;&#133;&#133; employed in my establishment after he/she has read the entry/entries have been read over to</td>
		  </tr>
		  <tr style="border:hidden">
			<td style="border:hidden">him/her by me and got confirmed by him/her.</td>
		  </tr>
		  <tr style="border:hidden">
			<td height="51" valign="bottom" style="border:hidden">Place:</td>
		  </tr>
		  <tr style="border:hidden">
			<td style="border:hidden">Date :</td>
		  </tr>
		  <tr style="border:hidden">
			<td align="right" style="border:hidden"><em>Signature of the employer</em></td>
		  </tr>
		  <tr style="border:hidden">
			<td height="111" align="right" valign="bottom" style="border:hidden"><em>Name &amp; Address of the Establishment</em></td>
		  </tr>
		</table>
	<div class="divCell" style="width:100%; height:2%">&nbsp;</div>
	</div>
  </div>
</div>