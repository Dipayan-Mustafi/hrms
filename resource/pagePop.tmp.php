<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?= $title?></title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<?
require ($root."resource/pageDesign.css.php");
require ($root."resource/menu.css.php");
require ($root."resource/baseJs.js.php");
$fyr=($_SESSION['fyr']) ? $_SESSION['fyr'] : $misc->CurrentFinYear(date('y'), date('m'));

?>
<center>
<div id="topHead">
	<div id="hdLftDiv">
	
		<img src="<?= $url ?>resource/images/logo.png"></img>
	</div>
	
		
</div>


<div id="mainDiv">
