<?php 
require ("common.php");

$mID=$_REQUEST['mid'];
$acc=$_REQUEST['acc'];

$c=count($mID);
for($i=0; $i<$c; $i++){
	
	$upDate=$obj->update("menumanager", "menuUact=$acc[$i]", "menuID=$mID[$i]");
	
}
print $set->JScriptAlert("Menu Permissions Updated");
$set->redirect("up_perm");
?>