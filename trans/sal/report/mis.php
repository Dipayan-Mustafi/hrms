<?php

require ("../../../config/setup.inc");

$title="MIS REPORTS";

require($rpath."pageDesign.tmp.php");
require ($root."lib/datetime/datetimepicker_css_js.php");
$cdt=date('Y-m-d');

$lmt=15;


$eman=new empManagement();

$dept=$_REQUEST['dept'];
$m=($_REQUEST['mnth']) ? $_REQUEST['mnth'] : date('m');
$yr=($_REQUEST['year']) ? $_REQUEST['year'] : date('Y');
$d=cal_days_in_month(CAL_GREGORIAN,"$m","$yr");
$page=0;
$mkTime=  mktime(0, 0, 0, $m, date('d')-$d, $yr);
$prvDate= date('Y-m-d', $mkTime);
$prvMnth=($m=="01") ? "12" : sprintf("%02d", ($m-1));
$prvYear=($m=="01") ? ($yr-1) : $yr;

$slctArray=array("--","ALL", "Individual", "Departmentwise");

$slc=($_GET['slc']) ? $_GET['slc'] : 0;
?>

<style type='text/css'>
 .ddhead { width:375mm; padding:5px; display:table; font-weight:bold; font-family:arial; font-size:13px;}
 .rowHead {width:375mm; display:table; font-family:arial; font-size:13px; border:solid 1px #666666; border-left:none; border-right:none;}
 .rowFoot {width:375mm; display:table; font-family:arial; font-size:13px; border:solid 1px #666666; border-left:none; border-right:none;page-break-after:always}
 .divCell {float:left}
 .divLine {width:98%;display:table; padding:1%}
 .divSel {cursor:pointer; border-bottom:dotted 1px #333333;}
 
</style>
<script type="text/javascript">


function goNext(){
		
	if (document.getElementById('frm').value==0){
		alert ("Please select Staring Date");
	}else if (document.getElementById('to').value==0){
		alert ("Please select Ending Date");
	}else{
			document.form1.submit();
	}
	
	
}
function getSlc(s){
	window.location="?slc="+s;
}

function findEmp(e){
    
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
					
					document.getElementById('nSrch').style.display="table";
                    document.getElementById('nSrch').innerHTML=ajaxRequest.responseText;
                    //document.getElementById('listShow').style.display="block";


            }else{
                    //alert (ajaxRequest.status);
                    document.getElementById('nSrch').innerHTML="Loading........................";
            }

    }


            var qstring="?emp="+e;

            ajaxRequest.open("GET","include/nSrch.php" + qstring, true);
            ajaxRequest.send(null);
    
}
function fillEmpCode(mn){
	
	document.getElementById('eq').value=mn;
	

	HideList('nSrch');
}
</script>

<center>
<div class="contDiv">
	<input type="image" align="right" border="1" src="<?= $rurl?>images/close.png" width="24" height="24" alt="Close" title="Close" style="cursor:pointer; margin:2; padding:9; border:#666666; border-style:dashed" onclick="navigate('../../../index.php');" />
	<div id="heading" align="left">
	  <h2>MIS Report</h2>
	</div>
	
	<div class="divLine">
		<div class="divCell" style="width:46%;">
			<h3>Selection Criteria</h3>
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
		<div class="divCell" width="48%">
			<?php
			if ($slc){
			?>
			<form name="form1" action="direction.php" method="post">
			<input type="hidden" name="stp" value="<?= $slc?>" />
			<p>From</p>
			<p><input name="frm" type="text" id="frm" size="15" value="<?php echo $prvDate?>" onClick="javascript:NewCssCal('frm','yyyyMMdd','','','','','past');" onFocus="javascript:NewCssCal('frm','yyyyMMdd','','','','','past');" readonly="true"/></p>
			<p>To</p>
			<p><input name="to" type="text" id="to" value="<?php echo date('Y-m-d')?>" size="15" onClick="javascript:NewCssCal('to','yyyyMMdd','','','','','past');" onFocus="javascript:NewCssCal('frm','yyyyMMdd','','','','','past');" readonly="true"/></p>
			
			<?php
                            switch ($slc){
                                case 2:
                                    $cont=  file_get_contents($url."trans/sal/report/include/empSearch");
                                    echo $cont;
                                    
                                    break;
								case 3:
                                	$cont=  file_get_contents($url."trans/sal/report/include/deptSearch");
                                    echo $cont;
                                    
                                    break;
									
                                default:
                                    
                                    break;
                            }
                        
			}
			?>
						<input type="hidden" name="flg" id="flg" value="3" />
	
                        <input type='button' value='Show' onclick='goNext()'>
			
		</div>
	</div>
	
	</form>
		
</div>


</center>
