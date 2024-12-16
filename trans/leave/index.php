<?php
require ("../../config/setup.inc");

$title="Leave Register";

require($rpath."pageDesign.tmp.php");

?>
<div class="contDiv" >
	<div id="heading" align="left"><h3>Leave Register<input type="image" align="right" border="1" src="<?= $rurl?>images/close.png" width="24" height="24" alt="Close" title="Close" style="cursor:pointer; margin:2; padding:9; border:#666666; border-style:dashed" onclick="navigate('../../index.php');" /></h3></div>
		<table width="100%" border="0" cellpadding="3">
		  <tr>
			<td height="70" style="border:solid" colspan="2" align="center"><strong><h3>Select Action</h3></strong> </td>
		  </tr>
		  <tr>
			<td width="50%" align="center" valign="top" height="50" onclick="navigate('reportIndex.php');" style="border:solid; text-align:center; height:70%; background-color:#B0877B; cursor:pointer"><strong><h3>Report</h3></strong></td>
			<td width="50%" align="center" valign="top" height="50" onclick="navigate('lvIndex.php');" style="border:solid; text-align:center; height:70%; background:#B0877B; cursor:pointer"><strong><h3>Leave alocation</h3></strong></td>
		  </tr>
		</table>
</div>