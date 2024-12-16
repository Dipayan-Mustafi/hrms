<?php

session_start();

$rf="hr";


$app['info']['name']="GRIP-HRMS";

$app['info']['path']=$_SERVER['DOCUMENT_ROOT']."/$rf/";

$app['info']['url']="http://".$_SERVER['HTTP_HOST']."/$rf/";

$app['info']['develop']="APJ SYSTEMS";


$company['info']['name']="KANCHAN VANIJYA PVT LTD";

$company['info']['address']="13/3, MAHENDRA ROY LANE";

$company['info']['city']="KOLKATA";

$company['info']['country']="INDIA";

$company['info']['state']="West Bengal";

$company['info']['zip']="700046";

$company['info']['abbr']="KV";

$company['info']['regno']="";




require ($app['info']['path']."config/db.inc");

require ($app['info']['path']."config/setup.php");


?>