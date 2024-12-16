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
		<?
					print "<h2 style='font-family:arial; font-size:12pt;'>".$app['info']['name']."</h2>";
		
		?>
	</div>
	<div id="hdRghtDiv">
	
		Current Financial Year : 
		<select name="fyr" id="fyr" onchange="changeFY(this.value, '<?= $url?>');">
		
			<option value="0">--</option>
			
			<?php 
			$disRes=$obj->distinct("empsaldet  order by finYear desc", "finYear");
			while ($disFres=$obj->fetchrow($disRes)){
				
				if ($fyr == $disFres[0]){
					
					print "<option value='$disFres[0]' selected>$disFres[0]</option>";
				}else{
					print "<option value='$disFres[0]' selected>$fyr</option>";
					
				}
			}
			
			?>
		
		
		</select>
		
		
		</div>
		<?
		require ($root."resource/menubar.php");
		?>
</div>


<div id="mainDiv">
