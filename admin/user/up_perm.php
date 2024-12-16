<?
require ("common.php");


$title .="Menu Accesibility maneger";



require ($root."resource/pageDesign.tmp.php");




?>
<div class="contDiv">
 <div id="heading">
  <h3>Menu Access  Maneger </h3>
 </div>
 <form name="form1" action="accUp" method="post">
  <table width="100%" border="1" cellspacing="0" cellpadding="3" style="border:solid 1px #B6BFBF">
	  <? $mRes=$obj->select("menumanager", "menuLink='#' order by menuPos");
		 while($mFres=$obj->fetchrow($mRes)){
	  		$s++
	  ?>
			  <tr bgcolor="#A3C7AD">
				<td width="4%" align="center" style="border-right:hidden">&nbsp;</td>
				<td colspan="3" align="center" style="border-left:hidden"><h3><?=$mFres[1]?></h3></td>
		  	  </tr>
			  <tr style="border:hidden">
				<td style="border:hidden">&nbsp;</td>
				<td width="31%" align="center" style="border:hidden"><h4>Menu Name</h4></td>
			  	<td width="60%" align="center" style="border:hidden"><h4>Heighest Access Level</h4></td>
			  	<td width="5%" rowspan="3" align="center" style="border:hidden"><h4>&nbsp;</h4></td>
			  </tr>
			  <?
			  $smRes=$obj->select("menumanager", "menuHead=$mFres[0] order by menuPos");
			  while($smFres=$obj->fetchrow($smRes)){
			  ?>
			  
			  <tr bgcolor="#98ACCD">
				<td height="60" style="border:hidden; background:#FFFFFF"><input type="hidden" name="mid[]" id="mid<?=$smFres[0]?>" value="<?=$smFres[0]?>" /></td>
				<td align="center" style="border-right:hidden"><strong><?=$smFres[1]?></strong></td>
			  	<td align="center" style="border-left:hidden"><select name="acc[]" id="acc<?=$smFres[0]?>">
				<? $countPT=count($acsTyp);
					for ($i=1; $i < $countPT; $i++){

						if ($smFres[5]==$i){
							print "<option value='$i' selected='selected'> $acsTyp[$i]</option> ";
						}else{
							print "<option value='$i'> $acsTyp[$i]</option>";
						}
					}
				?>
				</select>
				</td>
		  	  </tr>
	<?		}
	?>
			<tr style="border:hidden">
			    <td style="border:hidden">&nbsp;</td>
			    <td align="center" style="border:hidden">&nbsp;</td>
			    <td align="center" style="border:hidden">&nbsp;</td>
		     </tr>
	<?
		}
	?>
  </table>
  <div class="divLine">
  <div class="divCell" style="width:100%;" align="center"><input type="submit" value="Update" name="bSub" /></div>
  </div>
  </form>
</div>