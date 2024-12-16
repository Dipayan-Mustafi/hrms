<?php
/** 
*  Function:   convert_number 
*
*  Description: 
*  Converts a given integer (in range [0..1T-1], inclusive) into 
*  alphabetical format ("one", "two", etc.)
*
*  @int
*
*  @return string
*
*/ 

class Convert_Number{

	var $num=0;
	
	var $ones = array("", "One", "Two", "Three", "Four", "Five", "Six", 
        "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", 
        "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eighteen", 
        "Nineteen"); 
    var $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", 
        "Seventy", "Eigthy", "Ninety"); 
		
	var $Cr=0;
	var $Lc=0;
	var $Th=0;
	var $Hn=0;
	var $Dn=0;
	var $Ps=0;
	var $Rs=0;
	
	
	
	public function getNumber($amount){
		
		$this->num=$amount;
	
	}
	
	public function getRupees(){
		
		$int=explode(".",$this->num);
		$this->Rs=$int[0];
		$this->Ps=$int[1];
	}
	
	public function getPaisa(){
		
		if ($this->Ps>0){
			$Dn=floor($this->Ps / 10);
			$n=$this->Ps % 10;
			 if ($Dn < 2) { 
	            $res .= $this->ones[$Dn * 10 + $n]; 
    	    } else { 
            	$res .= $this->tens[$Dn]; 
            	if ($n) { 
                	$res .= "-" . $this->ones[$n]; 
            	} 
        	}
		}
		
		return $res;
	
	}
	
	public function getCr(){
	
		$cr_val=floor($this->Rs / 10000000);
		
		$this->Cr=$this->ones[$cr_val];
		
		if ($this->Cr){
			$words=$this->Cr. " Crore";
		}
		
		return $words;
	}
	
	public function getLac(){
	
		$cr_val=floor($this->Rs / 10000000);
		$Ln=$this->Rs - ($cr_val * 100000);
		$lac_val=floor($Ln / 100000);
		
		$this->Lc=$this->ones[$lac_val];
		
		if ($this->Lc){
			$words=$this->Lc. " Lac";
		}
		
		return $words;
	}
	
	public function getThousand(){
	
		//$cr_val=floor($this->Rs / 10000000);
		$Ln=$this->Rs / 100000;
		$Tn=$this>Rs -($Ln * 100000);
		
		
		$this->Th=floor($Tn / 1000);
		
		if ($this->Th){
			$Dn=floor($this->Th / 10);
			$n=$this->Th % 10;
			 if ($Dn < 2) { 
	            $words .= $this->ones[$Dn * 10 + $n]; 
    	    } else { 
            	$words .= $this->tens[$Dn]; 
            	if ($n) { 
                	$words .= "-" . $this->ones[$n]; 
            	} 
        	}
			$words.= " Thousands";
		}
		return $words;
	}
	
	
	public function getHundred(){
	
		$Tn=floor($this->Rs / 1000);
		$hd=$this->Rs - ($Tn * 1000);
		$hd_val=floor($hd / 100);
		
		$this->Hn=$this->ones[$hd_val];
		
		if ($this->Hn){
			$words=$this->Hn. " Hundred";
		}
		
		return $words;
	}
	
	public function getTens(){
	
		$Hd=floor($this->Rs / 100);
		$tn=$this->Rs - ($Hd * 100);
		$ten_val=floor($hd / 100);
		
		
		
		if ($ten_val){
			$Dn=floor($ten_val / 10);
			$n=$ten_val % 10;
			 if ($Dn < 2) { 
	            $words .= $this->ones[$Dn * 10 + $n]; 
    	    } else { 
            	$words .= $this->tens[$Dn]; 
            	if ($n) { 
                	$words .= "-" . $this->ones[$n]; 
            	} 
        	}
			
		}
		
		return $words;
	}


	public function setWords(){
	
		if ($this->getCr()){
			$word=$this->getCr();		
		}
		
		if ($this->getLac()){
			$word.= " ".$this->getLac();
		}
		
		if ($this->getThousand()){
			$word.= " ".$this->getThousand();
		}
		
		if ($this->getHundred()){
			$word.=" ".$this->getHundred();
		}
		
		if ($this->getPaisa()){
			$word.= ".".$this->getPaisa();
		}
		
		return $word;
		
	}


}





/*$cheque_amt = 8747484 ; 
try
    {
    echo convert_number($cheque_amt);
    }
catch(Exception $e)
    {
    echo $e->getMessage();
    }*/
?>
