<?php

class DemandMan{

	
	var $obj;
	var $misc;
	
	public function __construct(){
		
		$this->obj=new dbsql();
		
		$this->obj->Connect(HOST, USER, PWD, DATABASE);
		
		$this->misc=new misc();
	
	}
	
	
	public function genDemand($mid,$dno,$dm,$dy, $fdt, $tdt){
		
		try{
			$chkRes=$this->chkDemand($mid, $dmn, $dy);
			
			$expDno=explode("/", $dno);
			$dind=intval($expDno[2]);
				
			$pgdf=$this->getPgdf($mid, $dm, $dy);
			$rd=$this->getRD($mid, $dmn, $dy);
			$rd=($rd) ? $rd : 0;
			$pamnt=$this->arearInt($mid, $dm, $dy);
			$pamnt=($pamnt) ? $pamnt : 0;
			
			if ($chkRes < 1){
			#-------------------Insert Subscription----------------------------------------------------------------------------------------			
				$mstRes=$this->obj->select("membermast", "memNo='$mid'");
				$mstFres=$this->obj->fetchrow($mstRes);
				$ddCode=($mstFres[15]) ? $mstFres[15] : 0;
				
				
				$fld="memNo, demandNo, demandIndex, finYear, thriftFund, rdFund,wfund, demandMonth,demandYear, officeID, ddoCode, billCode, fdt, tdt";
				$val="'$mid','$dno',$dind,'$expDno[3]',$pgdf, $rd,$pamnt ,'$dm', $dy, $mstFres[14], '$ddCode', '$mstFres[16]', '$fdt', '$tdt' ";
				
				$insRes=$this->obj->chkinsert("demandmast", "memNo='$mid' and demandMonth='$dm' and demandYear=$dy and LmID=0", $fld, $val);
				if(!$insRes){
				
					$fld="thriftFund=$pgdf, rdFund=$rd,wfund=$pamnt, officeID=$mstFres[14], ddoCode='$ddCode', billCode=$mstFres[16], fdt='$fdt', tdt='$tdt'";
					$upRes=$this->obj->update("demandmast", $fld, "memNo='$mid' and demandMonth='$dm' and demandYear=$dy and LmID=0");
				
				}
			
				
				
				
				$msg=($insRes) ? "Demand Generated for subscription part of $mid with PGDF - $pgdf, RD - $rd" : "Demand modified subscription part of $mid with PGDF - $pgdf, RD - $rd";
			}
			
		}catch (ErrorException $e){
			$msg="ERROR : ". $e->getMessage();
		}
		
		return $msg;
	}
	
	private function chkDemand($mid, $dmn, $dy){
		
		$res=$this->obj->select("demandmast", "memNo='$mid' and demandMonth='$dm' and demandYear=$dy");
		$rows=$this->obj->rows($res);
		
		return $rows;
		
	}
	
	
	
	private function getPgdf($mid, $dm, $dy){
		
		$res=$this->obj->select("membermast", "memNo='$mid'");
		$fres=$this->obj->fetchrow($res);
		
		$pgdf=$fres[21];
		
		
		
		
		
		$stDt="$dy-$dm-01";
		
		$licRes=$this->obj->select("licmaster", "memNo=$mid and lastPremDate>'$stDt' and endFlg=0");
		while ($licFres=$this->obj->fetchrow($licRes)){
			
			$prmAmount=$licFres[4]/12;
			$pgdf=$pgdf+$prmAmount;
			
			
		}
		
		$result=$this->pgdfDefault($mid);
		if ($result[0] > 0) {
			
			$pgdf=$pgdf+$result[1];
			
		}
		
		return $pgdf;
		
	}
	
	private function pgdfDefault($mID){
	
		$res=$this->obj->select("pgdfdefault", "memNo='$mID' and endFlg=0");
		$rows=$this->obj->rows($res);
	
		$fres=$this->obj->fetchrow($res);
	
		$result[]=$rows;
		$result[]=$fres[2];
	
		return $result;
	
	}
	
	private function getRD($mid, $dmn, $dy) {
	
		$stDt="$dy-$dm-01";
		
		$actRes=$this->obj->select("acntmaster", "matDate > '$stDt' and DepTyp=1 and memNo='$mid'");
		while ($actFres=$this->obj->FetchRow($actRes)){
			
			$depAmount=$depAmount+$actFres[8];
			
			
		}
		
		return $depAmount;
		
	
	}
	
	private function arearInt($mid, $dm, $dy){
		$dt="$dy-$dm-11";
		$res=$this->obj->select("arearpaylist", "memNo='$mid' and endFlg=0 and stDate>='$dt' and endDate<='$dt'");
		while ($fres=$this->obj->fetchrow($res)){
			$cinNo=$fres[8];
			$cinNo++;
			if ($fres[9]==$cinNo){
				$payAmnt=$fres[5];
				$upDate=$this->obj->update("arearpaylist", "cinstNo=$cinNo", "apID=$fres[0]");
			}else{
				$payAmnt=$fres[4];
			}
				
				
			
			
		}
		return $payAmnt;
	}
	
	
	public function getLoan($mid,$dno, $dm, $dy, $fdt, $tdt){
		
		$dt="$dy-$dm-11";
		$expDno=explode("/", $dno);
		$dind=intval($expDno[2]);
		
		$mstRes=$this->obj->select("membermast", "memNo='$mid'");
		$mstFres=$this->obj->fetchrow($mstRes);
		
		$msg="";
		#-------------------Insert Loan Details----------------------------------------------------------------------------------------
		
		
		$res=$this->obj->select("loanmem", "memNo='$mid' and endFlg=1");
		
		while ($fres=$this->obj->Fetchrow($res)){
			
			 try{	
				$result=$this->loanDefault($fres[0]);
				if ($result[0] > 0 && $result[0]<2){
					
					$roi=18;
					$rmk=$result[0];
					
				}elseif($result[0] >1 && $result[0] < 3){
					
					$roi=36;
					$rmk=$result[0];
					
				}elseif($result[0] > 2){
					
					$roi=12;
					$rmk=$result[0];
				}else{
					$roi=$fres[13];
					$rmk="-";
				}
				
				$rpay=$this->obj->sumfield("loanrepaylist", "amount", "LmID=$fres[0]");
				$rpay=($rpay) ? $rpay : 0;
				if ($rpay > 0) {
					$lrpRes=$this->obj->select("loanrepapylist", "LmID=$fres[0] order by repayDate desc limit 0,1");
					$lrpFres=$this->obj->fetchrow($lrpRes);
					
					$tmDiff= mktime(0,0,0,$dm,11,$dy) - mktime(0,0,0,$lrpFres[8],11,$lrpFres[9]);
					
					$diffMnth=intval($tmDiff / (30*24*60*60));
				}else{
					$diffMnth=1;
					
				}
				$toPay=$fres[8]-$rpay;
				
				$intAmount=($toPay*$roi*$diffMnth)/(100*12);
				
				
				$totInst=$fres[18]+$result[1];
				
				$instNo=intval($toPay/$fres[18]);
				
				$ddCode=($mstFres[15]) ? $mstFres[15] : 0;
				
				$fld="memNo, demandNo, demandIndex, finYear, LoanID, LmID,prinPay, intPay, demandMonth,demandYear, officeID, ddoCode, billCode,installmentno,balanceAmount, fdt, tdt, remarks";
				$val="'$mid','$dno',$dind,'$expDno[3]',$fres[4], $fres[0],$totInst,$intAmount ,'$dm', $dy, $mstFres[14], '$ddCode', '$mstFres[16]', $instNo,$toPay, '$fdt', '$tdt', '$rmk' ";
					
				$insRes=$this->obj->chkinsert("demandmast", "memNo='$mid' and demandMonth='$dm' and demandYear=$dy and LmID=$fres[0]", $fld, $val);
				if (!$insRes){
					$fld="prinPay=$totInst, intPay=$intAmount, officeID=$mstFres[14], ddoCode='$ddCode', billCode='$mstFres[16]',installmentno=$instNo,balanceAmount=$toPay, fdt='$fdt', tdt='$tdt'";
					$upRes=$this->obj->update("demandmast", $fld,"memNo='$mid' and demandMonth='$dm' and demandYear=$dy and LmID=$fres[0]");
				}
				
				
				$msg.= ($insRes) ? "<div>Demand Generated for Loan No : $fres[1]</div>" : "<div> Demand for Loan No $fres[1] is modified	</div>";
				//$msg .= ($insRe) ? "<div>".var_dump($insRes)."</div>" : "<div?".var_dump($upRes)."</div>";
			
				
				
				
				
				
			}catch (Exception $e){
				
				$msg.="Error occurred : ".$e->getMessage();
				
			} 
			
			
			
			
		}
		
		return $msg;
		
	}
	
	private function loanDefault($lmID){
		
		$res=$this->obj->select("loandefault", "LmID=$lmID and endFlg=0");
		$rows=$this->obj->rows($res);
		
		$fres=$this->obj->fetchrow($res);
		
		$result[]=$rows;
		$result[]=$fres[4];
		
		return $result;
		
	}
	
		
	
}
?>