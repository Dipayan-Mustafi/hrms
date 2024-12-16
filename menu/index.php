<?php

require ("../config/setup.inc");

$title="Menu Manager";


require ($root."resource/pageDesign.tmp.php");


?>
<style type="text/css">
	
	.divLine{
		display: inline-block;
		border-bottom: dotted 1px #AEAEAE;
		padding-bottom: 4px;
		font-size: 9pt;
		text-align: left;
		width: 99%;
	}
	#memTbl td { border-bottom:dashed 1px #666666}
</style>
<script type="text/javascript">
	function showMenu(){
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
				
				document.getElementById('detDiv').innerHTML=ajaxRequest.responseText;
				//document.getElementById('memList').style.display="table";
				
				
			}else{
				//alert (ajaxRequest.status);
			
			}
			
		}
			
		

			
			ajaxRequest.open("GET","ajax/GetMenu" , true);
			ajaxRequest.send(null);
	}
	function gotoadd(){
		window.location="createMenu";
	}
	
	function goUpdate(i){
		window.location="upMenu?id="+i;
	}
	function goDelete(i){
		var ans=confirm("Are you sure to remove the menu item ?");
		
		if (ans==true){
			window.location="delMenu?id="+i;
		}
	}
	function changePos(i,p,np,h){
		
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
				
				document.getElementById('detDiv').innerHTML=ajaxRequest.responseText;
				//document.getElementById('memList').style.display="table";
				
				
			}else{
				//alert (ajaxRequest.status);
			
			}
			
		}
			
		
			var qstring="?i="+i+"&p="+p+"&np="+np+"&h="+h;
			
			ajaxRequest.open("GET","ajax/GetMenu" + qstring, true);
			ajaxRequest.send(null);
	}
	function changePage(){
		var pg=document.getElementById('pg').value;
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
				
				document.getElementById('detDiv').innerHTML=ajaxRequest.responseText;
				//document.getElementById('memList').style.display="table";
				
				
			}else{
				//alert (ajaxRequest.status);
			
			}
			
		}
			
		
			var qstring="?pg="+pg;
			
			ajaxRequest.open("GET","ajax/GetMenu" + qstring, true);
			ajaxRequest.send(null);
		
	}
</script>
<center>
<div class="contDiv">
	<div class="mainDiv">
		
			<table width="100%" id="memTbl" border="0" align="center" cellpadding="2" cellspacing="0" style="border:solid 1px #5C7083; margin-top:2%; border-radius:6px; height: 300px; overflow: auto;">
			  <tr>
			    <td height="30" colspan="6" align="right" valign="middle"><span style="font-size:8pt; font-family:verdana;">
			      <input type="button" name="badd" value="Add New" onclick="navigate('createMenu')" style="padding: 15px; background-color:#98ba5f; font-weight:bold; font-size:15px; font-family:arial; border:solid 1px #98ba00; " accesskey="I" />
			    </span></td>
			  </tr>
			  <tr>
			    <td height="30" colspan="6" align="center" valign="middle" bgcolor="#A3A6D1"><h3>
			      Menu Manager</h3>    </td>
			  </tr>
			  <tr>
			    <th width="8%" height="30" align="center" valign="middle" bgcolor="#CCD2DB"><strong>Menu Name </strong></th>
			    <th width="16%" height="30" align="center" valign="middle" bgcolor="#CCD2DB"><strong>Menu Head </strong></th>
			    
			    <th width="12%" align="center" valign="middle" bgcolor="#CCD2DB">Menu Position </th>
			    <th width="12%" height="30" align="center" valign="middle" bgcolor="#CCD2DB">&nbsp;        </th>
			  </tr>
			  <tbody>
			  <?   
		  	$disRes=$obj->distinct("menumanager", "menuID" ,"menuHead=0 order by menuName");
		  	$disRows=$obj->rows($disRes);
		  
				
			
			$bg="#CCC";
			
			if ($disRows > 0){
			
		  		for ($h=1; $h < $disRows; $h++){
					if ($bg=="#FFF"){
						$bg="#CCC";
					}else{
						$bg="#FFF";
					}
					
					while ($disFres=$obj->FetchRow($disRes)){	
						$hdRes=$obj->select("menumanager", "menuID=$disFres[0]");
						$hdFres=$obj->fetchrow($hdRes);
						
						
						
						
			?>
			  <tr style="background-color:<?= $bg?>; height:25px;">
			    <td align="center" valign="middle" ><strong>Main Menu</strong></td>
			    <td align="center" valign="middle" ><?= $hdFres[1];?></td>
				<td align="center" valign="middle">&nbsp;</td>
				<td align="center" valign="middle"><img src="<?= $url?>resource/images/edit_add.png" border="0" style="cursor:pointer" width="16" height="16" onclick="navigate('upMenu?id=<?= $hdFres[0]?>')" alt="Update" title="Update" />&nbsp;&nbsp;<img src="<?= $url?>resource/images/delete_icon.png" border="0" style="cursor:pointer" width="16" height="16" onclick="goDelete(<?= $smFres[0]?>)" alt="Remove" title="Remove" /></td>
				
			  </tr>
			  <?
			  			$smRes=$obj->Select("menumanager", "menuHead=$disFres[0] order by menuPos");
						$smRows=$obj->rows($smRes);
						while ($smFres=$obj->fetchrow($smRes)){
							
							
							$pos=$smFres[6];
							$prev=$pos-1;
							$nxt=$pos+1;
			?>
							<tr style="background-color:<?= $bg?>; height:25px;">
							<td align="center" valign="middle" ><em><?= $smFres[1];?></em></td>
							<td align="center" valign="middle" >"</td>
							<td align="center" valign="middle">
							<?
							if ($prev >0){
							?>
							<span style="padding:3px; cursor:pointer; font-size:9px;" onclick="changePos(<?= $smFres[0]?>,<?= $pos?>, <?= $prev?>, <?= $disFres[0]?>);">&Lambda;</span>
							<? }?>
							<span style="width:50px; padding:2px;"><?= $pos?></span>
							<?
							if ($nxt <= $smRows){
							?>
							
							<span style="padding:3px; cursor:pointer" onclick="changePos(<?= $smFres[0]?>,<?= $pos?>, <?= $nxt?>, <?= $disFres[0]?>);">&nu;</span>
							<?
							}
							?>
							</td>
							<td align="center" valign="middle"><img src="<?= $url?>resource/images/edit_add.png" border="0" style="cursor:pointer" width="16" height="16" onclick="navigate('upMenu?id=<?= $smFres[0]?>')" alt="Update" title="Update" />&nbsp;&nbsp;<img src="<?= $url?>resource/images/delete_icon.png" border="0" style="cursor:pointer" width="16" height="16" onclick="goDelete(<?= $smFres[0]?>)" alt="Remove" title="Remove" /></td>
						  </tr>
						<?
							
						}
					}
			  
			  	}
			  }
				
				?>
				
				<? 
				if ($disRows > 0){?>
				<tr>
				<th colspan="6" align="right" valign="top" style="font-size:8pt; font-family:verdana;" >
				<input type="button" name="badd" value="Add New" onclick="navigate('createMenu');" />
				
				
				
				Page No. 
				<select name="pg" id="pg" >
				<?
				
						$pageNum=@intval($disRows/ $lmt);
						
						if (($disRows > $lmt ) && (($disRows%$lmt)>0)){
							
							$pageNum++;
						
						}
						$pageNum=($pageNum) ? $pageNum : 1;
						for ($i=1; $i <= $pageNum; $i++){
							if ($pg==$i){
								print "<option value='$i' selected>$i</option>";
							}else{
								print "<option value='$i'>$i</option>";
							}
						}
					
				
				
				?>
				</select><input type="button" value="Go" onclick="changePage(<?= $pl?>);" >	</th>
			  </tr>
			<?
			  	}else{
			  ?>
			  <tr>
			    <td colspan="6" style="font-family:arial; font-size:12pt; font-weight:bold; color:#FF0000; line-height:25px; margin-left:20%; width:50%">Menu is not found 
			      </td>
			  </tr>
			  
			  <? }?>
			  
			    
			  </tbody>
			</table>
			
		
	</div>

</div>

</center>