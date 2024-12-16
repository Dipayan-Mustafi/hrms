<?
require ("../../config/setup.inc");



$title="Department Section";

require($rpath."pageDesign.tmp.php");

$emp=new empManagement();

$et=($_REQUEST['et']) ? $_REQUEST['et'] : 1;
$pt=($_REQUEST['pt']) ? $_REQUEST['pt'] : 1;
$sxt=($_REQUEST['sxt']) ? $_REQUEST['sxt'] : 1;

require ($root."lib/datetime/datetimepicker_css_js.php");

$id=($_REQUEST['id']) ? $_REQUEST['id'] : 0;

if ($id){

	$res=$obj->select("deptmanager", "deptID=$id");
	$fres=$obj->fetchrow($res);
	
	$dname=$fres[1];

}


?>
<script type="text/javascript">

function getRef(i){
	
	window.location="index?id="+i;
}


</script>
<style type="text/css">
.listTD{

	background-color:#FFFFFF;
	

}
.listTD:hover{
	background-color:#666666;
	color:#FFFFFF;
	display:block;
}
.divLine {
	width:100%;display:table; height:3%
}
</style>

<div class="contDiv">
<div class="divLine" align="right"><input type="image" align="right" border="1" src="<?= $rurl?>images/close.png" width="24" height="24" alt="Close" title="Close" style="cursor:pointer; margin:2; padding:9; border:#666666; border-style:dashed" onclick="navigate('../../index.php');" /></div>
	<div class="displayBox" style="width:68%;">
    	<h2>New Department </h2>
        <div class="listDiv">
        	<form name="form1" method="post" action="addBack">
			
			  <table width="100%" border="0" cellspacing="0" cellpadding="3">
                  <tr>
                    <td>Department Name 
                    <input name="rid" type="hidden" id="rid" value="<?= $id?>" /></td>
                    <td><input name="dname" type="text" id="dname" size="25" value="<?= $dname?>" /></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td><input name="bSav" type="submit" id="bSav" value="Submit" /></td>
                  </tr>
                </table>
			
			</form>
        </div>
       
    	
    </div>
	<div class="displayBox" style="width:25%; height:400px; overflow:auto;">
    	<h2>List of Department </h2>
        <div class="listDiv">
			<table border="0" cellpadding="3" width="100%">
			
			<?
			$res=$obj->select("deptmanager order by deptName" );
			while ($fres=$obj->fetchrow($res)){
				?>
				<tr>
				
					<td class="listTD" style="cursor:pointer; border-bottom:solid 1px #333333;" onclick="getRef(<?= $fres[0]?>)"><?= $fres[1]?></td>
				</tr>
				<?
			}
			?>
			</table>	
        </div>
        
    	
    </div>


</div>