<?php
//error_reporting(E_ALL);
require ("../../config/setup.inc");

$id=$_REQUEST['id'];



$update=$obj->delete("empnominee", "nmID='$id'");

if($update){
	print_r($update);
	//print $set->jsclose();
}
?>