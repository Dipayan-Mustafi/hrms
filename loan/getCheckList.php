<?
require ("../config/setup.inc");

$s=$_REQUEST['s'];
$mno=$_REQUEST['m'];

$getDetRes=$obj->select("loansubmaster", "subID=$s");
$getDetFres=$obj->fetchrow($getDetRes);


if ($getDetFres[11] > 0){
	print "<div class='divCell' style='width:40%;'>";

	$memDetRes=$obj->select("membermast", "memNo='$mno' ");
	$memDetFres=$obj->fetchrow($memDetRes);
	print "<h5>Chain List</h5>";
	
	$chainRes=$obj->select("membermast", "chainNo='$memDetFres[17]' and memNo not like '$mno'");
	while ($chainFres=$obj->fetchrow($chainRes)){
	
	
?>	

		<div><input type="checkbox" name="gur[]" value="<?= $chainFres[1]?>"> <?= $chainFres[2]?></div>

<?
	
	}
	print "</div>";
}

if ($getDetFres[10]> 0){
	
	print "<div class='divCell' style='width:40%'>";
	print "<h5>List of LIC Documents</h5>";
	
	$licRes=$obj->select("licmaster", "memNo='$mno' and assigNo > 0  order by assigNo ");
	while ($licFres=$obj->Fetchrow($licRes)){
	
		print "<div><input type='checkbox' name='lic[]' value='$licFres[1]'> $licFres[1]  :: $licFres[10] :: $licFres[3] </div>";
	}

	print "</div>";
}
?>