<?
require ("../../config/setup.inc");



$title="Allowance and Deduction Section";

require($rpath."pageDesign.tmp.php");

$emp=new empManagement();

$et=($_REQUEST['et']) ? $_REQUEST['et'] : 1;
$pt=($_REQUEST['pt']) ? $_REQUEST['pt'] : 1;
$sxt=($_REQUEST['sxt']) ? $_REQUEST['sxt'] : 1;
$pfe=($_REQUEST['pfe']) ? $_REQUEST['pfe'] : 1;
$esf=($_REQUEST['esf']) ? $_REQUEST['esf'] : 1;

require ($root."lib/datetime/datetimepicker_css_js.php");

$id=($_REQUEST['id']) ? $_REQUEST['id'] : 0;

if ($id){

	$res=$obj->select("allowancemaster", "alwID=$id");
	$fres=$obj->fetchrow($res);
	
	$dname=$fres[1];
	$rate=$fres[2];
	$adtyp=$fres[5];
	$rtyp=$fres[3];
	$runit=$fres[4];
	$esf=$fres[6];
	$pfe=$fres[7];
	

}


?>
<script type="text/javascript">

function getRef(i){
	
	window.location="index?id="+i;
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

	<div class="displayBox" style="width:68%;">
    	<h2>New Allowance or Deduction </h2>
        <div class="listDiv">
        	<form name="form1" method="post" action="addBack">
			
			  <table width="100%" border="0" cellspacing="0" cellpadding="3">
                  <tr>
                    <td>Allowance/Deductions  Name 
                      <input name="rid" type="hidden" id="rid" value="<?= $id?>" /></td>
                    <td><input name="dname" type="text" id="dname" size="25" value="<?= $dname?>" /></td>
                  </tr>
				   <tr>
					  <td>Effect Type</td>
					  <td>
					  <select name="adtyp">
					  <?
					  $countSal=count($salTyp);
					  for ($i=1; $i<$countSal; $i++){
					  	if ($adtyp==$i){
							print "<option value='$i' selected>$salTyp[$i]</option>";
						}else{
							print "<option value='$i'>$salTyp[$i]</option>";
						}
					  }
					  
					  ?>
					  </select>	  </td>
					</tr>
					<tr>
					  <td>Rate</td>
					  <td><input name="rate" type="text" id="rate" size="15" value="<?= $rate?>" /></td>
					</tr>
					<tr>
					  <td>Rate Type </td>
					  <td><select name="rtyp" id="rtyp">
						<?
					  $countSal=count($salRTyp);
					  for ($i=1; $i<$countSal; $i++){
					  
					  	if ($rtyp==$i){
							print "<option value='$i' selected>$salRTyp[$i]</option>";
						}else{
							print "<option value='$i'>$salRTyp[$i]</option>";
						}
					  }
					  
					  ?>
							</select></td>
					</tr>
					<tr>
					  <td>Payment Type </td>
					  <td><select name="runit" id="runit">
						<?
					  $countRU=count($uTyp);
					  for ($i=1; $i<$countRU; $i++){
						if ($runit==$i){
							print "<option value='$i' selected>$uTyp[$i]</option>";
						}else{
							print "<option value='$i'>$uTyp[$i]</option>";
						}
					  }
					  
					  ?>
					  </select></td>
					</tr>
                    <tr>
                      <td>ESI Effect </td>
                      <td><?
					$ccount=count($conTyp);
				
					for ($c=1; $c<$ccount;$c++){
						if ($esf==$c){
							print "<input type='radio' name='esf' value='$c' checked='checked'>$conTyp[$c]&nbsp;";
						}else{
							print "<input type='radio' name='esf' value='$c'>$conTyp[$c]&nbsp;";
						}
						
					}
					
					?></td>
                    </tr>
                    <tr>
                      <td>PF Effect </td>
                      <td><?
					$ccount=count($conTyp);
					
					for ($c=1; $c<$ccount;$c++){
						if ($pfe==$c){
							print "<input type='radio' name='pfe' value='$c' checked='checked'>$conTyp[$c]&nbsp;";
						}else{
							print "<input type='radio' name='pfe' value='$c'>$conTyp[$c]&nbsp;";
						}
						
					}
					
					?></td>
                    </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td><input name="bSav" type="submit" id="bSav" value="Submit" /></td>
                  </tr>
                </table>
			
			</form>
        </div>
       
    	
    </div>
	<div class="displayBox" style="width:25%; height:400px; overflow:auto;">
    	<h2>List of Allowance / Deductions </h2>
        <div class="listDiv">
			<table border="0" cellpadding="3" width="100%">
			
			<?
			$res=$obj->select("allowancemaster order by name" );
			while ($fres=$obj->fetchrow($res)){
					$attr=($fres[5]==1) ? "Allowance" : "Deductions";
				?>
				<tr>
				
					<td class="listTD" style="cursor:pointer; border-bottom:solid 1px #333333;" onclick="getRef(<?= $fres[0]?>)"><?= $fres[1]?></td>
					<td class="listTD" style="cursor:pointer; border-bottom:solid 1px #333333;" onclick="getRef(<?= $fres[0]?>)"><?= $attr?></td>
				</tr>
				<?
			}
			?>
			</table>	
        </div>
        
    	
    </div>


</div>