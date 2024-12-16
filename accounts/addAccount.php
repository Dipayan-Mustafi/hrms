<?php
error_reporting(E_ALL);
require ("../config/setup.inc");


$lid=($_REQUEST['lid']) ? $_REQUEST['lid'] : 0; 
$aname=addcslashes((strtoupper($_REQUEST['aname'])), "'");
$acTyp=$_REQUEST['acTyp'];
$mled=$_REQUEST['mled'];
$fyr=$_REQUEST['fyr'];
$opbal=$_REQUEST['opbal'];
$opdt=$_REQUEST['opdt'];
$btyp=$_REQUEST['btyp'];


$ledAlly=strtolower($aname);

$lally=str_replace(" ", "-", $ledAlly);

if ($lid<1){

	$fld="LedName,LedAlly, LedHead, AcntTyp,transTyp ";
	$val="'$aname','$lally', $mled, $acTyp,$btyp";
	
	$insRes=$obj->chkInsert("ledgermaster", "LedName='$aname'", $fld, $val);
		
	$lastId=$obj->lastID("ledgermaster", "LedID", "LedName='$aname'");
	
	$bfld="LedID, finYear, opDate, opBalance, transTyp";
	$bval="$lastId, '$fyr', '$opdt', $opbal, $btyp";
	
	$tIns=$obj->ChkInsert("ledbaldet","LedID=$lastId and finYear='$fyr'", $bfld, $bval);
	
	
	print $set->jscriptalert("$aname is registered for the $fyr with opening balance $opbal");
	$set->redirect("index");
}else{
	
	$fld="LedName='$aname', LedAlly='$lally', LedHead=$mled, AcntTyp=$acTyp, transTyp=$btyp";
	$upRes=$obj->update("ledgermaster", $fld,"LedID=$lid");
	
	$bfld="opBalance='$opbal'";
	$upDRes=$obj->update("ledbaldet", $bfld, "LedID=$lid and finYear='$fyr'");
	
	print $set->jscriptalert("$aname is modified for the $fyr with opening balance $opbal");
	$set->redirect("index");
}