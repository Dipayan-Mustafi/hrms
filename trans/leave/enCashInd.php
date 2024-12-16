<?php
require ("../../config/setup.inc");

$title="Leave Encashment";

require($rpath."pageDesign.tmp.php");

$dt=$_REQUEST['dt'];

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
function getEmp(){
	var dt=document.getElementById('dt').value;
	window.location="?dt="+dt;
}


</script>
<div class="contDiv" >
	<div id="heading" align="left">Leave Encashment<input type="image" align="right" border="1" src="<?= $rurl?>images/close.png" width="16" height="16" alt="Close" title="Close" style="cursor:pointer; margin:2; padding:9; border:#666666; border-style:dashed" onclick="navigate('../../index.php');" /></h3></div>
	<div class="displayBox" style="width:30%; height:400px; overflow:auto;">
		<div class="divLine" >
			<div class="divCell" style="border:hidden; width:40%; text-align:center;border-bottom:1px solid"><strong>Employee Number </strong></div>
			<div class="divCell" style="width:57%; margin-left:1%; text-align:left;border-bottom:1px solid"><strong>Employee Name </strong></div>
		</div>
<?
	if($ec){
		$empRes=$obj->select("empmaster","empCode='$ec'");
	}else{
		$empRes=$obj->select("empmaster order by empName");
	}
	while($empFres=$obj->fetchrow($empRes)){
					
?>
		<div class="divLine" style="margin-top:3px; margin-bottom:2px;" >
			<div class="divCell" style="border:hidden; width:40%; text-align:left;border-bottom:1px solid"><?=$empFres[2]?></div>
			<div class="divCell" style="width:57%; margin-left:1%; text-align:left;border-bottom:1px solid"><?=$empFres[3]?></div>
		</div>
<?
	}
?>
	</div>
</div>