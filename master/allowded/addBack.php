<?
require ("../../config/setup.inc");


$id=$_REQUEST['rid'];
$dname=$_REQUEST['dname'];
$ptyp=$_REQUEST['runit'];
$rate=$_REQUEST['rate'];
$rtyp=$_REQUEST['rtyp'];
$effTyp=$_REQUEST['adtyp'];
$esf=$_REQUEST['esf'];
$pfe=$_REQUEST['pfe'];


	
	
$cdt=date('Y-m-d');
$opr=$_SESSION['usr']['id'];

	
	
if ($id <1){
	
	
	
	
	$fld="name, amount, atyp, paTyp,effTyp,esf,pfe, createDate, oprID, active";
	
	$val="'$dname',$rate ,$rtyp , $ptyp,'$effTyp',$esf, $pfe '$cdt', $opr,1";
	$qry="`name`='$dname'";

	$res=$obj->ChkInsert("allowancemaster", $qry, $fld, $val);
	
		
}else{

		$fld="name='$dname', amount=$rate, atyp='$rtyp', paTyp='$ptyp',effTyp=$effTyp, modDate='$cdt', oprID=$opr, esf='$esf', pfe='$pfe'";
		$upRes=$obj->update("allowancemaster", $fld, "alwID=$id");
	
}
	$set->redirect("index");
?>