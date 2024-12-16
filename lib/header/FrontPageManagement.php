<?
$pageID=($_REQUEST['pageID']) ? $_REQUEST['pageID'] : 1;

if ($pageID==1){
	
	require (TEMP_PATH."frontpage/");


}else {
	require (TEMP_PATH."innerpage/");

}




?>