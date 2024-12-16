<?
//error_reporting(E_ALL);
require ("../../config/setup.inc");



$title="Leave Register Report";

require($rpath."pageDesign.tmp.php");

$emp=new empManagement();

$fdt=$_REQUEST['fdt'];
$tdt=$_REQUEST['tdt'];


require ($root."lib/datetime/datetimepicker_css_js.php");

$ec=$_REQUEST['emp'];

$dpt=$_REQUEST['dpt'];

$sc=$_REQUEST['sc'];

$endyr=date('Y');

$slctArray=array("--","ALL", "Individual", "Departmentwise");

$styr=$endyr -3;

$expSt=explode("-", $fdt);

$strmnth=sprintf("%02d", $expSt[1]);
$stryr=$expSt[0];
$strDay=$expSt[2];

$expEn=explode("-", $tdt);

$endmnth=sprintf("%02d", $expEn[1]);
$endyr=$expSt[0];

$prvMnth=($strmnth=="01") ? "12" : sprintf("%02d", ($strmnth-1));
$prvYear=($stryr=="01") ? ($stryr-1) : $stryr;
$d=cal_days_in_month(CAL_GREGORIAN,"$prvMnth","$prvYear");
$prvDt=($strDay=="01") ? ($d) : sprintf("%02d", ($strDay-1));
//$d=cal_days_in_month(CAL_GREGORIAN,"$prvMnth","$prvYear");
if($strDay=="01"){
	$prvDate="$prvYear-$prvMnth-$prvDt";
}else{
	$prvDate="$stryr-$strmnth-$prvDt";
}
//print $set->jscriptalert($prvDate);

$slc=($_GET['slc']) ? $_GET['slc'] : 0;
?>
<style type="text/css">
.displayBox{
	
	border:solid 1px #333333;
	padding:0.5%;
 	width:60%;
	display:inline;
	float:left;
	margin:1%;
	box-shadow:0.5em 0.5em 0.5em #CCCCCC;
}
.displayBox h2{
	color:#00032D;
	font-family:arial;
	font-size:12pt;
	font-weight:bold;
	vertical-align:middle;
	display:block;
	border-bottom:dotted 1px #00054A;
}
.displayBox .listDiv {
	display:table;
	width:100%;
	
}
.displayBox .listDiv .imgDiv{
	float:left;
	height:250px;
	border-right:solid 1px #000000;
	width:40%;
}
.displayBox .listDiv .gistDiv{
	float:left;
	height:250px;

	width:55%;

}

.displayBox .moreDiv{
	border-top:solid 1px #660000;
	text-align:right;
	font-family:Century Gothic;
	font-size:10pt;
	display:block;
}
.displayBox .moreDiv .btn{
	display:table;
	text-align:right;
	background-color:#99CCCC;
	color:#000000;
	font-weight:bold;
	cursor:pointer;
	float:right;
	padding:0.5%;
}
</style>
<script type="text/javascript">
function getEmp(s){
	window.location="reportIndex.php?ec="+s;
}

function getYr(s){
	
	var ec=document.getElementById('emp').value;
	window.location="reportIndex.php?ec="+ec+"&yr="+s;
}
function getSlc(s){
	window.location="?slc="+s;
}
</script>
<div class="contDiv">

	<div id="heading" align="left"><h3>Leave Register Report<input type="image" align="right" border="1" src="<?= $rurl?>images/close.png" width="24" height="24" alt="Close" title="Close" style="cursor:pointer; border:hidden" onclick="navigate('../../index.php');" /></h3></div>
	
	<div class="displayBox" style="width:96%">
		<form name="form1" action="" method="post">
		<div class="divLine" style="96%" align="center">
			<div class="divCell" style="width:48%">
			Leave Deatils From 
				<input type="date" id="fdt" name="fdt" value="<?=$fdt?>" />
			</div>
			<div class="divCell" style="width:48%"> 
			 To 
				<input type="date" id="tdt" name="tdt" value="<?=$tdt?>" />
		  </div>
	  </div>
		<div class="divLine" align="center"><h2>Select Criteria</h2></div>
			<div class="divLine">
				<div class="divCell" style="width:30%;">
					<?php
					$countSLC=count($slctArray);
					for ($i=1; $i < $countSLC ; $i++){
					
						if ($slc==$i){
							echo "<p><input type='radio' name='rad' id='rad' value='$i' checked='checked'> $slctArray[$i] </p>";
						}else{
							echo "<p><input type='radio' name='rad' id='rad' value='$i' onclick='getSlc(this.value);'> $slctArray[$i] </p>";
						}
					
					}
					
					?>
				</div>
				<? if($slc==2){?>
				<div class="divCell" style="66%">
					<select id="emp" name="emp">
						<option value="0" selected="selected">---</option>
						<?
							$lvRes=$obj->distinct("emplevconfig", "empCode");
							while($lvFres=$obj->fetchrow($lvRes)){
							
								$memRes=$obj->select("empmaster", "empCode='$lvFres[0]'");
								$memFres=$obj->fetchrow($memRes);
								if($ec==$lvFres[0]){
									print "<option value='$lvFres[0]' selected='selected'>$lvFres[0]---$memFres[3]</option>";
								}else{
									print "<option value='$lvFres[0]'>$lvFres[0]---$memFres[3]</option>";
								}
							}
						?>
					</select>
				</div>
				<? 
				}elseif($slc==3){
				?>
				<div class="divCell" style="66%">
					<select id="dpt" name="dpt">
						<option value="0" selected="selected">---</option>
						<?
							$dptRes=$obj->select("deptmanager");
							while($dptFres=$obj->fetchrow($dptRes)){
							
								if($dpt==$dptFres[0]){
									print "<option value='$dptFres[0]' selected='selected'>$dptFres[1]</option>";
								}else{
									print "<option value='$dptFres[0]'>$dptFres[1]</option>";
								}
							}
						?>
					</select>
				</div>
				<?
				}?>
			</div>
			<?
			if($slc){
			?>
			<div class="divLine" align="center" style="width:96%"><input type="hidden" name="sc" id="sc" value="<?=$slc?>" /><input type="submit" id="show" value="Show" /></div>
			<?
			}
			?>
		</form>
	</div>
<? if($sc){?>
	<div class="displayBox" style="width:96%" align="center">
		<div class="divLine" align="right">
			<input type="image" align="right" hspace="10" src="<?= $rurl?>images/print_icon.gif" width="32" height="32" alt="Print Sheet" title="Print Salary Sheet" style="cursor:pointer;" onclick="PrintDiv('printArea', 'Salary Sheet');" />
		</div>
		<div id="printArea">
			<table width="100%" border="1" cellspacing="0" cellpadding="3">
			  <tr>
				<td width="4%"><strong>Sl. No.</strong> </td>
				<td width="8%"><strong>Emp Code</strong> </td>
				<td width="13%"><strong>Employee Name</strong></td>
				<?
					$disRes=$obj->select("leaveconfig");
					while($disFres=$obj->fetchrow($disRes)){
				?>
				<td colspan="6" align="center" style="padding:3px"><?= $disFres[1]?></td>
				<?
				}
				?>
			  </tr>
			  
			  <tr>
				<td rowspan="2">&nbsp;</td>
				<td rowspan="2">&nbsp;</td>
				<td rowspan="2">&nbsp;</td>
				<?
					$disRes=$obj->select("leaveconfig");
					while($disFres=$obj->fetchrow($disRes)){
				?>
				<td width="6%" rowspan="2"><strong>Starting</strong></td>
				
			    <td colspan="2" align="center"><strong>Added</strong></td>
			    <td colspan="2" rowspan="2" align="center"><strong>Taken</strong></td>
			    <td rowspan="2" align="center"><strong>Balance</strong></td>
				<?
				}
				?>
			  </tr>
			  <tr>
			  <?
					$disRes=$obj->select("leaveconfig");
					while($disFres=$obj->fetchrow($disRes)){
				?>
			    <td align="center"><strong>Date</strong></td>
		        <td align="center"><strong>Qty</strong></td>
			<?
			}
			?>
			  </tr>
			  <?
			  if($ec){
			  	$memRes=$obj->select("empmaster", "empCode=$ec");
			  }elseif($dpt){
			  	$memRes=$obj->select("empmaster", "empDept=$dpt");
			  }else{
			  	$memRes=$obj->select("empmaster");
			  }
			  
			  while($memFres=$obj->fetchrow($memRes)){
			  	$s++;
			  ?>
			  <tr>
				<td rowspan="2"><?=$s?></td>
				<td rowspan="2" align="center"><?=$memFres[2]?></td>
				<td rowspan="2"><?=$memFres[3]?></td>
				<?
					$disRes=$obj->select("leaveconfig");
					while($disFres=$obj->fetchrow($disRes)){
					
						//$lastDay="$yr-"
						$beforeLv=$obj->sumfield("emplevconfig", "qty","empCode='$memFres[2]' and levID=$disFres[0] and createDate<='$prvDate'");
						$beforeTaken=$obj->sumfield("attnlevdet", "qty", "empCode='$memFres[2]' and levID=$disFres[0] and levDate<='$prvDate'");
						$start=$beforeLv-$beforeTaken;
						$start=($start) ? $start : 0;
						$tot=0;
				?>
				<td style="border-bottom:hidden"><?=$start?></td>
			    <td>
					<? 
					$adRes=$obj->distinct("emplevconfig", "createDate","empCode='$memFres[2]' and levID=$disFres[0] and createDate>='$fdt' and createDate<='$tdt'");
					//print_r($adRes);
					while($adFres=$obj->fetchrow($adRes)){
					
						print $misc->dateformat($adFres[0]);
						print "<br/>";
					}
					?>				</td>
			    <td><? $adRes=$obj->distinct("emplevconfig", "createDate", "empCode='$memFres[2]' and levID=$disFres[0] and createDate>='$fdt' and createDate<='$tdt' order by createDate");
					//print_r($adRes);
					
					while($adFres=$obj->fetchrow($adRes)){
					$qty=$obj->sumfield("emplevconfig", "qty", "empCode='$memFres[2]' and levID=$disFres[0] and createDate='$adFres[0]'");
						print $qty."<br/>";
						
						$tot=$tot+$qty;
						
						
					}?></td>
				<td colspan="2" align="center">
					<? 
					$taken=$obj->distinct("attnlevdet", "levDate", "empCode='$memFres[2]' and levID=$disFres[0] and levDate>='$fdt' and levDate<='$tdt' and levMonth>0");
					while($takenFres=$obj->fetchrow($taken)){
					
						print $misc->dateformat($takenFres[0]);
						print "<br/>";
						
						$s++;
					}
					?>				</td>
				<?
					
				?>
			    <td style="border-bottom:hidden">
				<?
					
					$take=$obj->sumfield("attnlevdet", "qty", "empCode='$memFres[2]' and levID=$disFres[0] and levDate>='$fdt' and levDate<='$tdt' and levMonth>0");
					$bal=$start+$tot-$take;;
					print $bal;
					unset($bal);
				?>	</td>
				<?
				
				}
				?>
			  </tr>
			  <tr>
			  <?
			  	$disRes=$obj->select("leaveconfig");
				while($disFres=$obj->fetchrow($disRes)){
			  ?>
			    <td style="border-top:hidden">&nbsp;</td>
			  <?
					
					$tot=($tot) ? $tot : 0;
					$take=$obj->sumfield("attnlevdet", "qty", "empCode='$memFres[2]' and levID=$disFres[0] and levDate>='$fdt' and levDate<='$tdt' and levMonth>0");
					$take=($take) ? $take : 0;
				?>
			    <td>Total Eligible:</td>
		      	<td><? $adRes=$obj->distinct("emplevconfig", "createDate","empCode='$memFres[2]' and levID=$disFres[0] and createDate>='$fdt' and createDate<='$tdt'");
					//print_r($adRes);
					
					while($adFres=$obj->fetchrow($adRes)){
					$qty=$obj->sumfield("emplevconfig", "qty", "empCode='$memFres[2]' and levID=$disFres[0] and createDate='$adFres[0]'");
					//$ins=$obj->distinct("emplevconfig", "qty", "empCode='$memFres[2]' and levID=$disFres[0] and createDate='$adFres[0]'");	
						
						$tot=$qty;
						
						
					}
					print $tot?></td>
		      	<td>Total:</td>
				<td><?=$take?></td>
				<td style="border-top:hidden">&nbsp;</td>
				<?
				
				 unset($tot);
				 unset($take);
				 unset($start);
				 unset($beforeLv);
				 unset($beforeTaken);
			}
			?>
			  </tr>
			  <?
			 
			  }
			  ?>
			</table>

		</div>
	</div>
<?
}
?>
</div>