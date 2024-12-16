<?php

require ("../config/setup.inc");

$title="Loan Application";

require($rpath."pageDesign.tmp.php");



?>

<style type="text/css">
	#fldSet{
		border:solid 1px #666666;
		border-radius:5px;
		padding: 5px;
		
		background-color:#CCCCCC;
		display:inline-table;
		overflow:auto;
	}
	#lgnd {
		font-weight:bold; 
		font-family:arial;
		font-size:15px;
	}
	
	.detLine{
		border-bottom:solid 1px #000000;
		padding: 5px 10px 5px 10px;
		display:inline-table;
		width:99%;
		cursor:pointer;
	}
	.detLine:hover {
		
		background-color:#727272;
		display:inline-block;
		color:#FFFFFF;
	
	}
	
</style>
<script type="text/javascript">
function findMem(){
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}

	
	
		// Create a function that will receive data sent from the server
		ajaxRequest.onreadystatechange = function(){
			if(ajaxRequest.readyState ==4 ){
				
				
				document.getElementById('memDiv').innerHTML = ajaxRequest.responseText;
				
			}else{
				document.getElementById('memDiv').innerHTML = "Loading...";
			}
		}
		
		 var q=document.getElementById('sq').value;
		 var t=document.getElementById('styp').value;
		 
		 
		 
	
		ajaxRequest.open("GET", "getMem?q="+q+"&t="+t, true);
		
		ajaxRequest.send(null); 


}
function findLoan(){
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}


	
		// Create a function that will receive data sent from the server
		ajaxRequest.onreadystatechange = function(){
			if(ajaxRequest.readyState ==4 ){
				
				
				document.getElementById('loanDiv').innerHTML = ajaxRequest.responseText;
				
			}else{
				document.getElementById('loanDiv').innerHTML = "Loading...";
			}
		}
		
		var l=document.getElementById('loan').value;
		var m=document.getElementById('memDet').value;
	
		ajaxRequest.open("GET", "ajax/getMemLoan?m="+m+"&l="+l, true);
		
		ajaxRequest.send(null); 


}
function getCh(m,l,p){

	window.location="challanGen?m="+m+"&l="+l+"&a="+p;
}

function goDet(q,t){
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}

	
	
		// Create a function that will receive data sent from the server
		ajaxRequest.onreadystatechange = function(){
			if(ajaxRequest.readyState ==4 ){
				
				
				document.getElementById('memDiv').innerHTML = ajaxRequest.responseText;
				
			}else{
				document.getElementById('memDiv').innerHTML = "Loading...";
			}
		}
		
		
		 
		 
		 
	
		ajaxRequest.open("GET", "getMem?q="+q+"&t="+t, true);
		
		ajaxRequest.send(null); 



}


</script>
<div class="contDiv">
	<div id="heading">Member Loan Application</div>

	<div class="divLine" style="margin-top:2%;">
	
		<div class="divCell" style="width:15%;">Search Criteria </div>
		
		<div class="divCell" style="width:25%" >
		<select name="styp" id="styp">
			<option value="0">--</option>
			<option value="1" selected="selected">Memberhip No</option>
			<option value="2">Member's Name</option>
			<option value="3">HR No</option>
			<option value="4">Mobile No</option>
			<option value="5">Surity No.</option>
		</select>
		</div>
		<div class="divCell" style="width:15%;">Enter Details</div>
		<div class="divCell" style="width:20%;"><input type="text" name="sq" id="sq" value="" size="20%" /></div>
		<div class="divCell" style="width:15%;"><input type="button" value="Search" accesskey="S" onclick="findMem();" /></div>
	</div>
	<div class="divLine" style="margin-top:2%;" id="memDiv">
	
	
	</div>
	
</div>