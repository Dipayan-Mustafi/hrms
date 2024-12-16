<?php
require ("../config/setup.inc");

$title="Unpaid Loan List";
require($rpath."pageDesign.tmp.php");

?>
<style type="text/css">
	
	#fldSet{
		border:solid 1px #666666;
		border-radius:5px;
		padding: 5px;
		
		
		display:inline-table;
		width:100%;
		overflow:auto;
	}
	#lgnd {
		font-weight:bold; 
		font-family:arial;
		font-size:15px;
	}
		
	#memDet{
		position: absolute;
		margin-top: 10mm;
		width:200mm;
		display:none;
		background-color:#cccccc;
	}
	
</style>
<script type="text/javascript">
function FindDet(m){
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
			
			document.getElementById('loanDet').innerHTML=ajaxRequest.responseText;
			//document.getElementById('memList').style.display="table";
			
			
		}else{
			//alert (ajaxRequest.status);
			document.getElementById('loanDet').innerHTML="Loading.....";
		
		}
		
	}
		
	
		var qstring="?mn="+m;
		
		ajaxRequest.open("GET","ajax/GetPend" + qstring, true);
		ajaxRequest.send(null);
	
}
function goto(){
	var m= document.getElementById("mem").value;
	window.location="LoanIssueMulti?mem="+m;
}
</script>
<center>
	<div class="contDiv">
	<div class="mainDiv">
		<fieldset id="fldSet"><legend id="lgnd">Upaid Loan List</legend>
			<div class="divLine" style="margin-bottom:5%;">
				<div class="divCell" style="width: 170mm;">
					Selection of Member
					<select name="mem" id="mem" onchange="FindDet(this.value);" style="width:30%; padding:1%;">
						<option value="0">--</option>
						<?
						$unRes=$obj->distinct("loanmem","memNo","endFlg=0");
						while ($unFres=$obj->fetchrow($unRes)){
							$mbRes=$obj->select("membermast", "memNo='$unFres[0]'");
							$mbFres=$obj->fetchrow($mbRes);
							print "<option value='$unFres[0]'>$mbFres[0]</option>";
						}	
						?>
						
						
					</select>
					
					
				</div>
			</div>	
			<div class="divLine" style="margin-top: 5mm;" id="loanDet"></div>
			<div class="divLine" style="text-align: center"><input type="button" name="bGen" value="Finalize" onclick="goto();"> </div>
			
		</fieldset>
		
	</div>
	</div>	
</center>
