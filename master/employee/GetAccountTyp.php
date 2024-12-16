<?
require ("../../config/setup.inc");

$typ=$_REQUEST['typ'];
?>
<select name="pt" id="pt">
<?

if ($typ==1){
	$pt=1;
?>

<?

	$countPT=count($payTyp);
	for ($i=1; $i < $countPT; $i++){
	
		if ($pt==$i){
			print "<option value='$i' selected='selected'> $payTyp[$i]</option> ";
		}else{
			print "<option value='$i'> $payTyp[$i]</option>";
		}
	}
	
?>	



<? 
}else{

				print "<option value='0'> --</option>";

}?>
</select>	