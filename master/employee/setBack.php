<?
//error_reporting(E_ALL);
require ("../../config/setup.inc");


$id=$_REQUEST['rid'];
$eaid=$_REQUEST['eaid'];
$adID=$_REQUEST['adID'];
$amnt=$_REQUEST['amnt'];
$rtyp=$_REQUEST['rtyp'];


$empRes=$obj->select("empmaster", "empID=$id");
$empFres=$obj->Fetchrow($empRes);	
	
$cdt=date('Y-m-d');
$opr=$_SESSION['usr']['id'];

	
$count=count($adID);	

for ($i=0; $i < $count; $i++){

	
	if (floatval($amnt[$i]) > 0){
	
		$adRes=$obj->select("allowancemaster", "alwID=$adID[$i]");
		$adFres=$obj->Fetchrow($adRes);
		
		
		
		if ($eaid[$i] < 1){
			$fld="empCode, alwID, amount, atyp, paTyp,effTyp, createDate, oprID";
			
			$val="'$empFres[2]', $adID[$i] , $amnt[$i] ,$rtyp[$i] , $adFres[4],'$adFres[5]', '$cdt', $opr";
			$qry="empCode='$empFres[2]' and alwID=$adID[$i]";
		
			$res=$obj->ChkInsert("empallowance", $qry, $fld, $val);
		}else{
		
			$fld="atyp=$rtyp[$i],  amount='$amnt[$i]',  modDate='$cdt', oprID=$opr";
				
			$res=$obj->update("empallowance", $fld,"empCode='$empFres[2]' and alwID=$adID[$i]");
			
		}
			
		
	}else{
		
		if ($eaid[$i] > 0){

			$delRes=$obj->delete("empallowance", "empCode='$empFres[2]' and alwID=$adID[$i]");
		}
	
	}
	
		
		
	

			
		
}
$set->redirect("salConfigView?ec=$empFres[2]");
?>