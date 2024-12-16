<?

class  empManagement{
	
	var $obj;


	public function __construct(){
	
				
			$this->obj=new dbsql();
		
		$this->obj->Connect(HOST, USER, PWD, DATABASE);
	
	}
	
	
	public function findEmployee($t){
	
	
		$res=$this->obj->select("empmaster","empJobTyp=$t");
		$rows=$this->obj->rows($res);
		return $rows;
	}
	
	public function getEmpDet($ecode){
	
		$res=$this->obj->select("empmaster", "empCode='$ecode'");
		$fres=$this->obj->fetchrow($res);
		
		return $fres;
	}
	
	public function getEmpBasicDet($ecode, $sm, $sy){
	
		if($sm<10){
			$m="0".(int)$sm;
		}else{
			$m=$sm;
		}
		
		$res=$this->obj->select("empsaldet", "empCode='$ecode' and  salMonth='$m' and salYear='$sy' and payHead='Basic'");
		$fres=$this->obj->fetchrow($res);
		
		
		
		return $fres[9];
	
	}
	
	public function getPFEmpShare($ecode, $sm, $sy){
		
		if($sm<10){
			$m="0".(int)$sm;
		}else{
			$m=$sm;
		}
		
		$res=$this->obj->select("empsaldet", "empCode='$ecode' and  salMonth='$m' and salYear='$sy' and payHead='EPF Deduction'");
		$fres=$this->obj->fetchrow($res);
		
		return $fres[9];
	
	}
	
	public function getESIEmpShare($ecode, $sm, $sy){
		
		if($sm<10){
			$m="0".(int)$sm;
		}else{
			$m=$sm;
		}
		
		$res=$this->obj->select("empsaldet", "empCode='$ecode' and  salMonth='$m' and salYear='$sy' and payHead='ESI Deduction'");
		$fres=$this->obj->fetchrow($res);
		
		return $fres[9];
	
	}
	public function getWA($ecode, $sm, $sy){
	
		$m=sprintf("%02d", $sm);
		
		$res=$this->obj->select("empsaldet", "empCode='$ecode' and  salMonth='$m' and salYear='$sy' and payHead='Washinig Allowance'");
		$fres=$this->obj->fetchrow($res);
		
		return $fres[9];
	
	}
	
	public function getHRA($ecode, $sm, $sy){
	
		$m=sprintf("%02d", $sm);
		
		$res=$this->obj->select("empsaldet", "empCode='$ecode' and  salMonth='$m' and salYear='$sy' and payHead='House Rent Allowance'");
		$fres=$this->obj->fetchrow($res);
		
		return $fres[9];
	
	}
	
	public function getPtax($ecode, $sm, $sy){
	
		$m=sprintf("%02d", $sm);
		
		$res=$this->obj->select("empsaldet", "empCode='$ecode' and  salMonth='$m' and salYear='$sy' and payHead='Professional Tax'");
		$fres=$this->obj->fetchrow($res);
		
		return $fres[9];
	
	}
	
	public function getTDS($ecode, $sm, $sy){
		
		$sm=sprintf("%02d", $sm);
		$res=$this->obj->select("empsaldet", "empCode='$ecode' and  salMonth='$sm' and salYear='$sy' and payHead='TDS Deduction'");
		$fres=$this->obj->fetchrow($res);
		
		return $fres[9];
	
	}
	
	public function getMnthCont($ecode, $sm, $sy){
		
		if($sm<10){
			$m="0".(int)$sm;
		}else{
			$m=$sm;
		}
		$res=$this->obj->select("mnthcompcont", "empCode='$ecode' and  salMonth='$m' and salYear='$sy'");
		$fres=$this->obj->fetchrow($res);
		
		return $fres;
	
	}
	
	public function empAttendance($ecode, $sm, $sy){
	
		$m=sprintf("%02d",$sm);
		
		
		$res=$this->obj->select("attendancedet","empCode='$ecode' and attnMonth='$m' and attnYear='$sy'");
		$fres=$this->obj->fetchrow($res);
		$d=cal_days_in_month(CAL_GREGORIAN, "$sm", "$sy");
		
		$attnd=$d-$fres[6];
		
		
		return $attnd;
	}
	
	public function deptDet($id){
		$res=$this->obj->select("deptmanager","deptID=$id");
		$fres=$this->obj->fetchrow($res);
		
		
		return $fres[1];
	}
	
	public function empAttndCal($ecode, $sm, $sy){
	
		if($sm<10){
			$m="0".(int)$sm;
		}else{
			$m=$sm;
		}
		
		$res=$this->obj->select("attendancedet","empCode='$ecode' and attnMonth='$m' and attnYear='$sy'");
		$fres=$this->obj->fetchrow($res);
		
		
		return $fres;
	}
	
	#.........................................................................................................................................................
		public function getEmpBasicTot($ecode, $fdt, $tdt){
		
		$res=$this->obj->sumfield("empsaldet", "payAmount", "empCode='$ecode' and createDate>='$fdt' and createDate<='$tdt' and payHead='Basic'");
		
		return $res;
	
	}
	
	public function getPFEmpShareTot($ecode, $fdt, $tdt){
		
		$res=$this->obj->sumfield("empsaldet", "payAmount", "empCode='$ecode' and createDate>='$fdt' and createDate<='$tdt' and payHead='EPF Deduction'");
		
		return $res;
	
	}
	
	public function getESIEmpShareTot($ecode, $fdt, $tdt){
		
		$res=$this->obj->sumfield("empsaldet", "payAmount", "empCode='$ecode' and createDate>='$fdt' and createDate<='$tdt' and  payHead='ESI Deduction'");
		
		
		return $res;
	
	}
	public function getWATot($ecode, $fdt, $tdt){
		
		$res=$this->obj->sumfield("empsaldet", "payAmount", "empCode='$ecode' and createDate>='$fdt' and createDate<='$tdt' and  payHead='Washinig Allowance'");
		
		
		return $res;
	
	}
	
	public function getHRATot($ecode, $fdt, $tdt){
		
		$res=$this->obj->sumfield("empsaldet", "payAmount", "empCode='$ecode' and createDate>='$fdt' and createDate<='$tdt' and  payHead='House Rent Allowance'");
		
		
		return $res;
	
	}
	
	public function getPtaxTot($ecode, $fdt, $tdt){
		
		$res=$this->obj->sumfield("empsaldet", "payAmount", "empCode='$ecode' and createDate>='$fdt' and createDate<='$tdt' and  payHead='Professional Tax'");
		
		
		return $res;
	
	}
	
	public function getTdsTot($ecode, $fdt, $tdt){
		
		$res=$this->obj->sumfield("empsaldet", "payAmount", "empCode='$ecode' and createDate>='$fdt' and createDate<='$tdt' and  payHead='TDS Deduction'");
		
		
		return $res;
	
	}
	
	public function getAdvTot($ecode, $fdt, $tdt){
		
		$res=$this->obj->sumfield("empsaldet", "payAmount", "empCode='$ecode' and createDate>='$fdt' and createDate<='$tdt' and  payHead='Advance Deduction'");
		
		
		return $res;
	
	}
		
	public function getEpfContTot($ecode, $fdt, $tdt){
		
		$res=$this->obj->sumfield("mnthcompcont","epfCC", "empCode='$ecode' and createDate>='$fdt' and createDate<='$tdt'");
		
		return $res;
	
	}
	
	public function getEsiContTot($ecode, $fdt, $tdt){
		
		$res=$this->obj->sumfield("mnthcompcont","esiCC", "empCode='$ecode' and createDate>='$fdt' and createDate<='$tdt'");
		
		return $res;
	
	}
	
	public function empAttendanceTot($ecode, $fdt, $tdt){
		$res=$this->obj->select("attendancedet", "empCode='$ecode' and attnDate>='$fdt' and attnDate<='$tdt' order by attnMonth");
		$attnd=0;
		$tday=0;
		$tWorkDay=0;
		while($fres=$this->obj->fetchrow($res)){
			
			//$attnd=$attnd+$fres[4];
			
			$d=cal_days_in_month(CAL_GREGORIAN, "$fres[8]", "$fres[9]");
			$tDay= $tDay + $d;
			$tWorkDay=$tWorkDay+$fres[3];
			
			$totattnd=$totattnd+$fres[4];
			
			//unset($d);
		}
		
		$Toff= $tDay - $tWorkDay;
		$attnd=$totattnd+$Toff;
		
		
		return $attnd;
	}
	
	public function countPtax($m, $amnt, $f){
			if($amnt==0){
				$amnt=90;
			}
			
			$res=$this->obj->distinct("empsaldet", "empCode", "finYear='$f' and salMonth=$m and payHead='Professional Tax' and payAmount='$amnt'");
			$row=$this->obj->rows($res);
			
			return $row;
	}
	public function countPtaxAmount($m, $amnt, $f){
		if($amnt==0){
				$amnt=90;
			}
		
		$res=$this->obj->sumfield("empsaldet", "payAmount", "finYear='$f' and salMonth=$m and payHead='Professional Tax' and payAmount='$amnt'");
		
		if($res){
			$r=$res;
		}else{
			$r=0.00;
		}
		
		return $r;
	
	}
	public function insSalDet($ecode, $dept, $m, $yr, $fyr, $hTyp, $amount, $cdt, $cby, $strng, $salDate){
		
		
		
		$alwRes=$this->obj->select("allowancemaster", "name='$strng'");
		$alwFres=$this->obj->fetchrow($alwRes);
		
		$alwnc=($alwFres[0]) ? $alwFres[0] : 0;
		
		
		
		$fld="`empCode`, `deptID`, `salMonth`, `salYear`, `finYear`, `payHead`, `headTyp`, `headPrcnt`, `payAmount`, `salType`, `alwID`, `levbal`, `createDate`, `oprID`, `salDate`";
	
		$val="'$ecode', '$dept', '$m', '$yr', '$fyr', '$strng', '$hTyp', '0.00', '$amount', '1', '$alwnc', '0', '$cdt', '$cby', '$salDate'";
		
		$chkRes=$this->obj->select("empsaldet", "empCode='$ecode' and salMonth='$m' and salYear='$yr' and payHead='$strng'");
		$rows=$this->obj->rows($chkRes);
		
		if($rows>0){
			$insRes=$this->obj->update("empsaldet", "payAmount='$amount', salDate='$salDate'", "empCode='$ecode' and salMonth='$m' and salYear='$yr' and payHead='$strng'");
		}else{
			$insRes=$this->obj->chkinsert("empsaldet", "empCode='$ecode' and salMonth='$m' and salYear='$yr' and payHead='$strng'", $fld, $val);
		}
		
		return $insRes;
	}

	public function insMnthCont($ecode, $gross, $m, $yr, $fyr, $esicc, $pfcc, $epscc, $pfAdmn, $edli, $edliAdmn, $cdt, $cby){
		
		$chkRes=$this->obj->select("mnthcompcont", "empCode='$ecode' and salMonth='$m' and salYear='$yr'");
		$rows=$this->obj->rows($chkRes);
	
		if($rows>0){
			
			$upfld="totpay='$gross', esiCC='$esicc', epfCC='$pfcc', epsCont='$epscc', epfAdm='$pfAdmn', edli='$edli', edliAdm='$edliAdmn', modDate='$cdt', oprID='$cby'";
			
			$insRes=$this->obj->update("mnthcompcont", $upfld, "empCode='$ecode' and salMonth='$m' and salYear='$yr'");
		}else{
		
			$fld="`empCode`, `totpay`, `salMonth`, `salYear`, `finYear`, `esiCC`, `epfCC`, `epsCont`, `epfAdm`, `edli`, `edliAdm`, `createDate`, `oprID`";
		
			$val="'$ecode', '$gross', '$m', '$yr', '$fyr', '$esicc', '$pfcc', '$epscc', '$pfAdmn', '$edli', '$edliAdmn', '$cdt', '$cby'";
	
			$insRes=$this->obj->chkinsert("mnthcompcont", "empCode='$ecode' and salMonth='$m' and salYear='$yr'", $fld, $val);
		}
		
		return $insRes;
	
	}

}



?>