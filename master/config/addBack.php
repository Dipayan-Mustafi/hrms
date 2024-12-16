<?
require ("../../config/setup.inc");

$id=$_REQUEST['id'];
$cdt=date('Y-m-d');
$opr=$_SESSION['usr']['id'];
if($id>0){

	if($id==1){
		$basic=($_REQUEST['basic'])? $_REQUEST['basic'] :0;
		$esi=($_REQUEST['esi']) ? $_REQUEST['esi']:0;
		$cesi=($_REQUEST['cesi']) ? $_REQUEST['cesi'] :0;
		
		$fld="basic=$basic,esiCont=$esi, esiCC=$cesi, modDate='$cdt', oprID=$opr";
		$res=$obj->update("salconfig", $fld, "esID=1");
	
	}else if($id==2){
		$pf=($_REQUEST['pf']) ? $_REQUEST['pf'] :0;
		$cpf=($_REQUEST['cpf']) ? $_REQUEST['cpf'] :0;
		$pfa=($_REQUEST['pfa']) ? $_REQUEST['pfa'] :0;
		
		
		$fld="epfCont=$pf, epfCC=$cpf, pfAdmin=$pfa, modDate='$cdt', oprID=$opr";
		$res=$obj->update("salconfig", $fld, "esID=1");
	
	}else if($id==3){
		$eps=($_REQUEST['eps']) ? $_REQUEST['eps'] : 0;
		$eplmt=($_REQUEST['eplmt']) ? $_REQUEST['eplmt'] :0;
		
		$fld="epsCont=$eps, epsLimit=$eplmt, modDate='$cdt', oprID=$opr";
		$res=$obj->update("salconfig", $fld, "esID=1");	
	}else if($id==4){
		$edls=($_REQUEST['edls']) ? $_REQUEST['edls'] : 0;
		$edlsa=($_REQUEST['edlsa']) ? $_REQUEST['edlsa'] : 0;
	
		$fld="edlsCont=$edls, edlsAdmin=$edlsa, modDate='$cdt', oprID=$opr";
		$res=$obj->update("salconfig", $fld, "esID=1");
	
	}else if($id==5){
		
		$spt=($_REQUEST['spt']) ? $_REQUEST['spt'] : 0;
		$tpt=($_REQUEST['tpt']) ? $_REQUEST['tpt'] : 0;
		$pt=($_REQUEST['ptamnt']) ? $_REQUEST['ptamnt'] : 0;
		
		
		$fld="`slabLow`, `slabHigh`, `rate`";
		$val="'$spt', '$tpt', '$pt'";
		
		$insRes=$obj->chkinsert("ptmaster", "slabLow='$stp' and slabHigh='$tpt' and rate='$pt'", $fld, $val);
	}else if($id==6){
		$spt=($_REQUEST['spt']) ? $_REQUEST['spt'] : 0;
		$tpt=($_REQUEST['tpt']) ? $_REQUEST['tpt'] : 0;
		$pt=($_REQUEST['ptamnt']) ? $_REQUEST['ptamnt'] : 0;
		
		
		$fld="`slabLow`, `slabHigh`, `rate`";
		$val="'$spt', '$tpt', '$pt'";
		
		$insRes=$obj->chkinsert("tdsmaster", "slabLow='$stp' and slabHigh='$tpt' and rate='$pt'", $fld, $val);
	}else if($id==7){
		$sgrp=$_REQUEST['sgrp'];
		
		$fld="groupName, createDate";
		$val="'$sgrp', '$cdt'";
		
		$ins=$obj->chkinsert("subgrpmast", "groupName='$sgrp' and createDate='$cdt'", $fld, $val);
	}
	$set->redirect("index?id=".$id);
}else{

	print $set->jscriptalert ("Something Went Wrong. Please Try Again");
	$set->redirect("index");

}

?>