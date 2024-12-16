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
<script type="text/javascript">
function fillEmpCode(mn){
	
	document.getElementById('eq').value=mn;
	

	HideList('nSrch');
}
function HideList(d){
	document.getElementById(d).style.display="none";
}
</script>	
            <div>List of Departments</div>
            <select name="dept" id="dept">
                <option value="0">--</option>
        <?php
        	$res=$obj->select("deptmanager order by deptID");
			while($fres=$obj->fetchrow($res)){
			
				print "<option value='$fres[0]'>$fres[1]</option> ";
			
			}
        ?>
            </select>
        </div>
    </body>
</html>
