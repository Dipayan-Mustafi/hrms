<?
//error_reporting(E_ALL);
require ("../../config/setup.inc");







$emp=new empManagement();


require ($root."lib/datetime/datetimepicker_css_js.php");

$mnth=$_REQUEST['mnth'];
$yr=$_REQUEST['yr'];
$dept=$_REQUEST['dept'];




?>
<title>Registering Attendance</title>