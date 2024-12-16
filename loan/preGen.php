<?
require ("../config/setup.inc");


$lid=$_REQUEST['lid'];
$mno=$_REQUEST['mno'];

$title="Loan Application Form";


require($rpath."pageDesign.tmp.php");


$res=$obj->select("membermast", "memNo = '$mno' order by memNo");
$fres=$obj->fetchrow($res);

?>
<script type="text/javascript">
	function goNext(){
		
		var ans=confirm('Are you sure to proceed?');
		if (ans==true){
			document.form1.submit();
		
		}
	
	}
	
	function fillAmount(a){
	
		document.getElementById('aamnt').value=a;
		document.getElementById('lamnt').value=a;
	}
	
	function chkAmnt(){
		
		var a=document.getElementById('aamnt').value;
		var la=document.getElementById('lamnt').value;
		
		if (a > la){
			alert("Sorry! you have entered more than limit");
			document.getElementById('aamnt').value=document.getElementById('lamnt').value;
		}else{
			alert (a);
		}
	
	
	}
	function getPage(s,m){
	
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
			if(ajaxRequest.readyState == 4){
				
				
				document.getElementById('loadChkDet').innerHTML = ajaxRequest.responseText;
				
			}else{
				document.getElementById('loadChkDet').innerHTML = "Loading...";
			}
		}
	
		ajaxRequest.open("GET", "getCheckList?s="+s+"&m="+m, true);
		
		ajaxRequest.send(null); 
	
	
	
	}
</script>
<div class="contDiv">
	<div class="divLine" style="text-align:right"><input type="button" value="<< Back" onclick="navigate('index');" /></div>
	<form name="form1" method="post" action="gen">
		<div class="divLine" style="margin-bottom:1%;font-weight:bold">Loan Application of Member : <?= $fres[2]?> [<?= $fres[1]?>]</div>
		<div class="divLine">
			<div class="divCell" style="width:15%; font-weight:bold;">Select Loan Category : <input type="hidden" name="lid" value="<?= $lid?>"><input type="hidden" name="mno" value="<?= $mno?>"> </div>
			<div class="divCell" style="width:35%;">
			<?
			$subRes=$obj->select("loansubmaster", "loanID=$lid");
			while ($subFres=$obj->Fetchrow($subRes)){
			?>
				<div class="divLine"><div class="divCell" style="width:50%"><input type="radio" name="sub" id="sub" value="<?= $subFres[0]?>" onClick="fillAmount('<?= $subFres[4]?>'); getPage('<?= $subFres[0]?>', '<?= $mno?>');"> <?= $subFres[1]?></div><div class="divCell" style="width:40%; text-align:right">- Rs. <?= $subFres[4]?></div> </div>
			<?
			}
			?>
			
			</div>
			<div class="divCell" style="width:15%; font-weight:bold">Enter Apply amount : </div>
			<div class="divCell" style="width:25%;"><input type="text" size="25" name="aamnt" id="aamnt" value="0" onchange="chkAmnt();"><input type="hidden" size="25" name="lamnt" id="lamnt" value="0"> </div>
		</div>
		<div id="loadChkDet" class="divLine">
			
		</div>
		<div class="divLine">
			<input type="button" value="Select" onClick="goNext();" accesskey="S">
		</div>
	
	</form>
</div>