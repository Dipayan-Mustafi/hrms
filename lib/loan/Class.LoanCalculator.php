<?

class LoanCalculator{

	
	var $obj;
	
	public function __construct(){
		
		$this->obj=new dbsql();
		
		$this->obj->Connect(HOST, USER, PWD, DATABASE);
			
	
	}
	
	
	public function LoanTaken($mc){
	
		$total=0;
		$res=$this->obj->select("loanmem", "memID=$mc and endFlg=1");
		while ($fres=$this->obj->fetchrow($res)){
			
			$rem=$fres[8]-$fres[17];
			$total=$total+$rem;
		
		}
	
		return $total;
	}
	
	public function LoanList($mst,$lid=0){
	
		$res=$this->obj->select("loanmaster", "mstID=$mst");
		while ($fres=$this->obj->fetchrow($res)){
		
			if ($lid==$fres[0]){
			
				$cprint.="<option value='$fres[0]' selected>$fres[1]</option>";
			}else{
				$cprint.="<option value='$fres[0]'>$fres[1]</option>";
			}
		
		}
		
		return $cprint;
	
	
	
	}
	public function CheckLoanAuth($lid, $lamnt){
	
		$res=$this->obj->select("loanmaster", "LoanID=$lid");
		$fres=$this->obj->fetchrow($res);
		
		$auth=($fres[4]>= $lamnt) ? $lamnt : $fres[4];
		
	
		return $auth;
	
	}
	
	public function getGFund($amnt, $eid){
	
		$res=$this->obj->select("configuration", "Active=1");
		$fres=$this->obj->fetchrow($res);
		
		$gf=sprintf("%0.2f",($amnt*$fres[4])/100);
		
		$sumAmount=$this->obj->sumfield("memgfund", "gfund", "memID=$eid");
		
		$ngf=($sumAmount < 1000) ? (1000-$sumAmount) : 0;
		
		if ($gf >$ngf){
			$sgf=$ngf;
		} else{
		
			$sgf=$gf;
		}
		
		return $sgf;
	
	
	}
	
	public function getTenure($lid){
	
		$res=$this->obj->select("loanmaster", "LoanID=$lid");
		$fres=$this->obj->fetchrow($res);
		
		return $fres[2];
	
	
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
	
	public function loanIssueCheck($lid,$mid, $gmc, $ldoc){
		
		
		$chkRes=$this->obj->select("loanmaster", "loanID=$lid");
		$chkFres=$this->obj->FetchRow($chkRes);
		
		$retn=0;
		
		if ($chkFres[14]==1){
			
			if ($gmc > 0 || $ldoc > 0){
				
				$retn=1;
			}else{
				$retn=0;
			}
			
			
		}else{
			
			if (($chkFres[11] > $gmc) && ($chkFres[11] > 0)){
				$retn=0;
			}else{
				$retn=1;
			}
		
		}
		
		
		return $retn;
	}
	
	
	public function LoanCancel($lid){
		
		$res=$this->obj->Select("loanmem", "LmID=$lid");
		$fres=$this->obj->FetchRow($res);
		
		$this->RepayCancel($lid);
		$this->ShareCancel($lid);
		$this->GFCancel($lid);
		
		$delRes=$this->obj->Delete("loanmem", "LmID=$lid");
		
		if ($delRes){
			
			$rtn=1;
			
		}else{
			$rtn=0;
		}
		
		return $rtn;
		
		
	}
	
	private function RepayCancel($lid){
		
		$rpRes=$this->obj->Select("loanrepaylist", "refID=$lid");
		$rpRows=$this->obj->Rows($rpRes);
		$rpFres=$this->obj->FetchRow($rpRes);
		
		
		if($rpRows > 0){
			$upRes=$this->obj->update("loanmem", "endFlg=1" ,"LmID=$rpFres[1] and endFlg=2");
		}
		$delRes=$this->obj->Delete("loanrepaylist", "refID=$lid");
	}
	
	private function ShareCancel($lid){
	
		
		$delRes=$this->obj->Delete("memshare", "refID=$lid");
	}
	private function GFCancel($lid){
	
	
		$delRes=$this->obj->Delete("memgfund", "LmID=$lid");
	}
	
	
	
}



?>