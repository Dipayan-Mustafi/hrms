<?php
require ("../../../../config/setup.inc");

$emp=($_GET['emp']) ? $_GET['emp'] : 0;

        // put your code here
        $res=$obj->select("empmaster", "(empCode like '$emp%' or empName like '$emp%' or empPhn like '$emp%' or empEPFNo like '$emp%') and empCode > 0 order by empCode");
        while ($fres=$obj->fetchrow($res)){
           
				print "<div style='padding:3px;' onclick='fillEmpCode(\"$fres[2]\");' class='divSel'>$fres[2]--$fres[3]</div>";
            
        }
        ?>