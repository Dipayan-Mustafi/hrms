<?
require ("../../config/setup.inc");

$title="Pay Slip Preview";

require($rpath."pageDesign.tmp.php");

$mnthArray=array( "", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");

$endyr=date('Y');
$styr=$endyr -3;
$slctArray=array("--","Individual", "Departmentwise");

$mnth=($_REQUEST['mnth']) ? ($_REQUEST['mnth']) : date('m');

$yr=($_REQUEST['yr']) ? $_REQUEST['yr'] : $endyr;

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
function getSlc(s){
	window.location="?slc="+s;
}	
</script>
<div class="contDiv">
	<div class="displayBox" style="width:96%">
	<form name="form1" action="salView" method="post">
		<div class="divLine" style="96%" align="center">
			<div class="divCell" style="width:48%">
			Payslips for the Month: 
				<select id="mnth" name="mnth">
										<option value="0" selected="selected">--</option>
					<?
						$cMnth=count($mnthArray);
						for ($i=1;$i<$cMnth; $i++){
								if($mnth==$i){
									print "<option value='$i' selected='selected'>$mnthArray[$i]</option>";
								}else{
									print "<option value='$i'>$mnthArray[$i]</option>";
								}
							}
					?>
				</select>
			</div>
			<div class="divCell" style="width:48%"> 
			 year: 
				<select name="yr" id="yr"> 
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
				<? if($slc==1){?>
				<div class="divCell" style="66%">
					<select id="ec" name="ec">
						<option value="0" selected="selected">---</option>
						<?
							$lvRes=$obj->distinct("emplevconfig", "empCode");
							while($lvFres=$obj->fetchrow($lvRes)){
							
								$memRes=$obj->select("empmaster", "empCode='$lvFres[0]'");
								$memFres=$obj->fetchrow($memRes);
								print "<option value='$lvFres[0]'>$lvFres[0]---$memFres[3]</option>";
						
							}
						?>
					</select>
				</div>
				<? 
				}elseif($slc==2){
				?>
				<div class="divCell" style="66%">
					<select id="dept" name="dept">
						<option value="0" selected="selected">---</option>
						<?
							$dptRes=$obj->select("deptmanager");
							while($dptFres=$obj->fetchrow($dptRes)){
							
								
								print "<option value='$dptFres[0]'>$dptFres[1]</option>";
						
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
</div>