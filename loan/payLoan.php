<?php
require ("../config/setup.inc");

$title="Cash Received";


require($rpath."pageDesign.tmp.php");
$id=$_REQUEST['id'];


$getRes=$obj->select("loanmem", "LmID=$id");
$getFres=$obj->fetchrow($getRes);


$memRes=$obj->select("membermast", "memNo='$getFres[3]'");
$memFres=$obj->fetchrow($memRes);

$lonRes=$obj->select("loanmaster", "loanID=$getFres[4]");
$lonFres=$obj->fetchrow($lonRes);



$paidAmnt=$obj->sumfield("loanrepaylist","amount", "LmID=$id");
$totRefund=$paidAmnt + $getFres[19];

$elgAmnt=$getFres[8] * 0.20;

$toPay=$getFres[8] - $totRefund;

?>
<style type="text/css">

.DivLine { display:table; width:890px; text-align:left; border-bottom:dashed 1px #333333; margin-bottom:5px;}
.DivCell { float:left; padding:8px;}
.DivCell input[type=text],select { border:solid 1px #999999; border-radius:5px; font-family:verdana; font-size:10px; height:22px;}
#memList { display:none; width:300px; position:absolute; margin-top:25px; margin-left:15px; background-color:#FFFFFF; border:solid 1px #AEAEAE; border-radius:6px; height:150px; overflow:auto; }
</style>
<link rel="stylesheet" type="text/css" href="<?= $url?>lib/epoch_styles.css" />
<script type="text/javascript" src="<?= $url?>lib/epoch_classes.js"></script>
<script type="text/javascript">

	
	function getCalender(d){
		var pop_cal;
		pop_cal= new Epoch('epoch_popup','popup',document.getElementById('d'));




	}
	
function findLoanMemDet(m){
	
	
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
			
			document.getElementById('memDet').innerHTML=ajaxRequest.responseText;
			//document.getElementById('memList').style.display="table";
			TotAmount();
			
		}else{
			//alert (ajaxRequest.status);
		
		}
		
	}
		
	
		var qstring="?mn="+m;
		
		ajaxRequest.open("GET","ajax/GetLoanMem" + qstring, true);
		ajaxRequest.send(null);
	
	
}
function TotAmount(){

	var adj=document.getElementsByName('adj[]');
	var int=document.getElementsByName('int[]');
	
	var tadj=0;
	var tint=0;
	
	for (var i=0; i < adj.length; i++){
		
		tadj=eval(tadj)+eval(adj[i].value);
	
	}
	
	for (var i=0; i < int.length; i++){
		
		tint=eval(tint)+eval(int[i].value);
	
	}
	
	var tf=document.getElementById('tfund').value;
	var wf=document.getElementById('wfund').value;
	var rf=document.getElementById('rdfund').value;
	
	var tf=tadj+eval(tf)+eval(wf)+eval(tint)+eval(rf);
	
	document.getElementById('Amount').value=tf.toFixed(2);


}
function checkDate(){

	if (document.getElementById('appdt').value==""){
		alert ("Please enter the date");
		document.getElementById('appdt').focus();
	}
}
function checkVch(v){

	var d=document.getElementById('appdt').value;
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
			
			var m=ajaxRequest.responseText;
			
			if (m==1){
				alert ('Voucher no is already in database');
				document.getElementById('vch').value="0";
			}else{
				//alert (m);
			}
			
		}else{
			//alert (ajaxRequest.status);
		
		}
		
	}
		
	
		var qstring="?v="+v+"&dt="+d;
		
		ajaxRequest.open("GET","ajax/checkVch" + qstring, true);
		ajaxRequest.send(null);

}
</script>


  <div class="contDiv">
  <h2>Payment of Due Loan amount</h2>
  <div class="divLine" style="text-align:right"><input type="button" value="<< Back" onclick="navigate('index');" /></div>
    <form name="form1" id="form1" method="post" action="rcvBack">
    	<div class="DivLine">
			<div class="DivCell" style="width:15%;">Membership No <input type="hidden" name="id" value="<?= $id?>" /></div>
			<div class="DivCell" style="width:15%;"><?= sprintf("%04s", $getFres[3])?></div>
			<div class="DivCell" style="width:20%;">Member's Name</div>
			<div class="DivCell" style="width:20%;"><?= $memFres[2]?></div>
		</div>
		<div class="DivLine">
			<div class="DivCell" style="width:15%;">Loan Type</div>
			<div class="DivCell" style="width:20%;"><?= $lonFres[1]?></div>
			<div class="DivCell" style="width:20%;">Issued Amount</div>
			<div class="DivCell" style="width:20%;">Rs. <?= $getFres[8]?></div>
		</div>
		<div class="DivLine">
			<div class="DivCell" style="width:15%;">Refunded </div>
			<div class="DivCell" style="width:20%;">Rs. <?= sprintf("%0.2f",$totRefund);?></div>
	  </div>
		<div class="DivLine">
			<div class="DivCell" style="width:15%;">Paying Amount </div>
			<div class="DivCell" style="width:20%;">Rs. <input type="text" size="15" name="pamnt" id="pamnt" value="<?= $toPay?>" /></div>
			<div class="DivCell" style="width:20%;">Date</div>
			<div class="DivCell" style="width:20%;"><input type="date" size="12" name="pdt" id="pdt" value="<?= date('Y-m-d')?>" /></div>
		</div>
		
		<div class="DivLine" style="text-align:center">
			<input type="submit" value="Generate" name="btnGen" />
		</div>
		
     </form>

  </div>

