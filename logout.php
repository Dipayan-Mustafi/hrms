<?php
require ("config/setup.inc");

$vpn=$_SESSION['usr']['vpn'];

$cdt=date('Y-m-d');
$ctm=date('H:i:s');

$upRes=$obj->update("logbook", "logoutDate='$cdt',logoutTime='$ctm', active=2", "chnNo='$vpn'");



session_destroy();
$set->redirect($url);

?>