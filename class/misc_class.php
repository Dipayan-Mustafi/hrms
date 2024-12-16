<?php
class misc {
	
	public function DateFormat($dt){
		$dt_splt=explode("-",$dt);
		$dt_form=$dt_splt[2]."-".$dt_splt[1]."-".$dt_splt[0];
		
		return $dt_form;
	}
	public function CurrencyFormat($cur){
		$cur_form=sprintf("%01.2f", $cur);
		
		return $cur_form;
	}
	
	public function CurrentFinYear($year, $month){
		
		if  ($month<4){
			
			$cur_year=$year-1;
			$next_year=$year;
		}else{
			$cur_year=$year;
			$next_year=$year+1;
		}
		
		$fin_year=$cur_year."-".$next_year;
		
		
		return $fin_year;
		
		
	
	}
	
	public function OpeningDate($fyr){
	
		$exp=explode("-", $fyr);
		
		if (strlen($exp[0])==2){
		
			$opDt="20$exp[0]-04-01";
		}else{
			$opDt="$exp[0]-04-01";
		}
		
		return $opDt;
	
	}
	
	
}
?>