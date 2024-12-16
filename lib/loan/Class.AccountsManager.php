<?

class AccountsManager{

	
	var $obj;
	var $misc;
	
	public function __construct(){
		
		$this->obj=new dbsql();
		
		$this->obj->Connect(HOST, USER, PWD, DATABASE);
		$this->misc=new misc();	
	
	}
	
	public function FindCompID($comp, $fyr){
		
		$res=$this->obj->Select("compsetup", "compName='$comp' and finYear='$fyr'");
		$fres=$this->obj->FetchRow($res);
		
		return $fres[0];
		
	}
	public function LedgerCheckinng($cid, $led, $ally="",$hd=0,$atyp, $ttyp, $fyr){
	
		$res=$this->obj->Select("ledgerlist","ledName='$led'");
		$rows=$this->obj->Rows($res);
		
		if ($rows==0){
			$this->CreateLedger($cid, $led, $ally,$hd,$atyp, $ttyp, $fyr);
		}
	}
	
	public function CreateLedger($cid, $led, $ally,$hd=0,$atyp, $ttyp, $fyr){
	
		$fld="ledName, ledAlly, ledHead, acntTyp, transTyp, editLock";
		$val="'$led', '$ally', $hd, $atyp,$ttyp, 2";
		
		$chkstr="ledName='$led' and ledHead=$hd and acntTyp=$atyp";

		$insRes=$this->obj->ChkInsert("ledgerlist", $chkstr, $fld, $val);
		
		if ($insRes){
			$getLastId= $this->obj->LastID("ledgerlist","ledID","ledName='$led' and ledHead='$hd' and acntTyp=$atyp");
			$this->CreateLedgerMaster($led,$ally,$hd,$atyp,$fyr,$cid,$ttyp, $getLastId);
			$cprint="created";
		}else{
			$getRes=$this->obj->select("ledgerlist", "ledName='$led' and ledHead='$hd' and acntTyp=$atyp");
			$getFres=$this->obj->fetchrow($getRes);
			$this->CreateLedgerMaster($led,$ally,$hd,$atyp,$fyr,$cid,$ttyp, $getFres[0]);
			$cprint="updated";
		}
		
		return $cprint;
	
	}
	private function CreateLedgerMaster($lname,$alias, $ltyp,$atyp=0,$fyr, $cid,$ttyp, $listid){
	
		
		$opDt=$this->misc->OpeningDate($fyr);
		$opBal=0;
		$fld="LedName, LedAlly, LedTyp, AcntTyp, OpDate, OpBal, finYear, compID, TransTyp, ledListID";
		$val="'$lname', '$alias', $ltyp, $atyp, '$opDt', $opBal, '$fyr', $cid, $ttyp, $listid";
		
		$ver="LedName='$lname' and AcntTyp=$atyp and compID=$cid and LedAlly='$alias'";
		$res=$this->obj->chkinsert("ledgermaster", $ver, $fld, $val);
		
	
	}
	
	public function getVchNo($cid, $vtyp, $dt){
	
		$lastNo=$this->obj->lastid("ledgertrans", "VchIndex", "compID=$cid and VchTyp=$vtyp and TransDt <= '$dt'");
		
		$lastNo++;
		
		$dLastNo=$this->getVchNoYr($cid, $vtyp, $dt);
		
		
		
		if ($lastNo==$dLastNo){
			
			$vcno=sprintf("%05d",$lastNo);
			
		}else{
			$vcno=$this->GenNewVchNo($cid, $vtyp, $dt, $lastNo);
			
		}
		
		return $vcno;
		
	
	
	}
	private function getVchNoYr($cid, $vtyp, $dt){
		
		$lastNo=$this->obj->Select("ledgertrans","VchIndex", "compID=$cid and VchTyp=$vtyp ");
		$lastNo++;
		
		return $lastNo;
	
	
	}
	
	private function GenNewVchNo($cid, $vtyp, $dt, $lno){
		
		$DvcArray=array("", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T");
		$lno=($lno>1) ? $lno-- : $lno;
		$res=$this->obj->distinct("ledgertrans","VchNo","compID=$cid and VchTyp=$vtyp and VchIndex=$lno ");
		$rows=$this->obj->rows($res);
		
		
		
		$vcno=sprintf("%05s",$lno.$DvcArray[$rows]);
		
		return $vcno;
	
	
	}
	
	public function AccountEntry($dt,$vchno, $lastInd, $vTyp, $ttyp, $acntName,$acntTyp,$acID ,$amount, $remarks="", $fyr, $mno="NULL" ,$bank="NULL", $chq="NULL",  $subhd="NULL" ){
		/*if ($acID){
			$ant=$acID;
		}else{
			$ant=$this->getAccountID($cID,$acntName, $fyr);	
		}*/
		
		$ant=$acID;
		
		$fld="TransDt, VchNo, VchIndex, VchTyp, TransTyp, LedID, AcntTyp, Amount, remarks, finYear, memNo, subhead, bank, chequeNo";
		$val="'$dt', '$vchno', $lastInd, $vTyp, $ttyp, $ant, $acntTyp, $amount, '$remarks', '$fyr', '$mno', '$subhd', '$bank', '$chq'";
		
		$chk="VchNo='$vchno' and VchTyp=$vTyp and TransTyp=$ttyp and LedID=$ant and Amount=$amount";
			
		$res=$this->obj->ChkInsert("ledgertrans", $chk, $fld, $val);
		
	
		return $res;
	}
	
	public function getAccountID($cid, $acntName, $fyr){
	
		$res=$this->obj->select("ledgerlist", "ledName='$acntName'");
		$fres=$this->obj->fetchrow($res);
		
		$mstRes=$this->obj->Select("ledgermaster","LedName='$acntName' and compID=$cid and finYear='$fyr'");
		$mstFres=$this->obj->FetchRow($mstRes);
		
		return $mstFres[0];
		
		
	
	
	}
	public function getInt($lid){
	
		$res=$this->obj->select("loanmaster", "LoanID=$lid");
		$fres=$this->obj->fetchrow($res);
		
		return $fres[3];
	
	
	}
	
	public function findLoanCode($lid){
	
		$res=$this->obj->select("loanmaster", "LoanID=$lid");
		$fres=$this->obj->fetchrow($res);
		
		return $fres[5];
	
	
	}
	
	public function FindLoanShare($amt, $mc){
	
		$sumShare=$this->obj->sumfield("memshare","shareNo", "memID=$mc");
		
		$cnfRes=$this->obj->select("configuration", "Active=1");
		$cnfFres=$this->obj->fetchrow($cnfRes);
		
		$shareValue=$sumShare * $cnfFres[2];
		
		$loanShareValue=($amt * $cnfFres[6])/100;
		
		$shareAddValue=($loanShareValue > $shareValue) ? ($loanShareValue - $shareValue) : 0;
		
		return $shareAddValue;
	
	
	
	}
	
	
	
	
	
}



?>