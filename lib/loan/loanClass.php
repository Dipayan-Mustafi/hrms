<?php
class LoanManager{
	
	
	var $obj;
	
	public function __construct(){
	
		$this->obj=new dbsql();
	
		$this->obj->Connect(HOST, USER, PWD, DATABASE);
			
	
	}
	
	
	
	
	public function loanDet($lid){
		
		$loanDet=array();
		
		$res=$this->obj->Select("loanmaster", "LoanID=$lid");
		$fres=$this->obj->FetchRow($res);
		
		$loanDet[0]=$fres[0];
		$loanDet[1]=$fres[1];
		$loanDet[2]=$fres[2];
		$loanDet[3]=$fres[3];
		$loanDet[4]=$fres[4];
		$loanDet[5]=$fres[9];
		$loanDet[6]=$fres[10];
		$loanDet[7]=$fres[11];
		$loanDet[8]=$fres[12];
		
		
		return $loanDet;
	}
	
	
}