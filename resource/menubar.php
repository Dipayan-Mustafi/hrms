<?

/*$menuRes=$obj->select("menumanager","menuHead=0 order by menuPos");
$menuRows=$obj->rows($menuRes);
$menuRows > 0 &&*/


if ( $_SESSION['usr']['id']){

$ses=$_SESSION['usr']['id'];
$usrRes=$obj->select("userdetail", "userID=$ses");
$usrFres=$obj->fetchrow($usrRes);
?>
<div id="menuBar">

	<ul id="menu">
	<?
		$mRes=$obj->select("menumanager", "menuLink='#' order by menuPos");
		while($mFres=$obj->fetchrow($mRes)){
			$mName=strtoupper($mFres[1]);
	?>
			<li><a href="#"><?=$mName?></a>
				<ul class="sub-menu">
					<div class="divLine">&nbsp;</div>
				<?
					$smRes=$obj->select("menumanager", "menuHead=$mFres[0] and menuUact>=$usrFres[9] order by menuPos");
					$smRows=$obj->rows($smRes);
					if($smRows>0){
						while($smFres=$obj->fetchrow($smRes)){
						
						$smName=strtoupper($smFres[1]);
					?>
						<li><a href="#" onclick="navigate('<?= $url.$smFres[2]?>');"><?=$smName?></a></li>
					<?	
						 }
					}else{
				?>
						<li><a href="#">NO ACCESS</a></li>
				<?	}
				?>
				
				</ul> 
			</li>
		<?
		}
		?>
		<li><a href="#" onclick="navigate('<?=$url?>logout.php')"><?=LOGOUT?></a>
	</ul>


</div>
<?
}
?>
