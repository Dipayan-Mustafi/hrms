<?php
require ("../../../../config/setup.inc");

?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
<style type="text/css">
#vendList { position:absolute; width:20%; box-shadow:0.3em 0.3em 0.5em #CCCCCC; margin-top:0px; margin-left:55px; padding:4px; z-index:0; display:none; background-color:#FFFFFF; }
#nSrch { position:absolute; width:20%; box-shadow:0.3em 0.3em 0.5em #CCCCCC; margin-top:0px; margin-left:55px; padding:4px; z-index:0; display:none; background-color:#FFFFFF; }
.divSel {cursor:pointer; border-bottom:dotted 1px #333333;}
.divSel:hover { background-color:#D1D1D1; display:block;}
</style>

<script type="text/javascript">
function fillEmpCode(mn){
	
	document.getElementById('eq').value=mn;
	

	HideList('nSrch');
}
function HideList(d){
	document.getElementById(d).style.display="none";
}
</script>	
        Quick Search
		
        <input name="eq" type="text" id="eq" size="20" onKeyUp="findEmp(this.value);"  style="width:150px; border:solid 1px #999999; font-size:10px; padding:4px;" autocomplete="off" />
        <div id="nSrch"></div>
            <div>List of Employee</div>
            <select name="ename" id="ename" onChange='fillEmpCode(this.value);'>
                <option value="0">--</option>
        <?php
        	$res=$obj->select("empmaster", "empCode > 0 order by empCode");
			while($fres=$obj->fetchrow($res)){
			
				print "<option value='$fres[2]'>$fres[2]--$fres[3]</option> ";
			
			}
        ?>
            </select>
        </div>
    </body>
</html>
