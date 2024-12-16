<?

class LoanCalculator{

	
	var $obj;
	
	public function __construct(){
		
		$this->obj=new dbsql();
		
		$this->obj->Connect(HOST, USER, PWD, DATABASE);
			
	
	}
	
	
	public function LoanTaken($mc){
	
		$total=0;
		$res=$this->obj->select("loanmem", "memID=$mc");
		while ($fres=$this->obj->fetchrow($res)){
			
			$rem=$fres[8]-$fres[17];
			$total=$total+$rem;
		
		}
	
		return $total;
	}
	
	public function LoanList($lid=0){
	
		$res=$this->obj->select("loanmaster");
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
	
	public function getGFund($amnt){
	
		$res=$this->obj->select("configuration", "Active=1");
		$fres=$this->obj->fetchrow($res);
		
		$gf=sprintf("%0.2f",($amnt*$fres[4])/100);
		
		return $gf;
	
	
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
	
	
	
	
}



?>