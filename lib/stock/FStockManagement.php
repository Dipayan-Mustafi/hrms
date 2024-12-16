<?

class FStockManagement{

	
	var $obj;
	
	public function __construct(){
		
		$this->obj=new dbsql();
		
		$this->obj->Connect(HOST, USER, PWD, DATABASE);
			
	
	}
	
	
	public function getClosingStock($pc, $fyr, $opDt="", $clDt=""){
	
		
		
		
		$balStk=$this->CalCStock($pc, $opDt, $clDt);
		
		$Qty=$balStk;
		
		return $Qty;
		
	
	}
	
	private function CalCStock($pc, $opDt="", $clDt=""){
		
		$sumRcv=$this->obj->sumfield("finalprodstocktrans", "qty", "csNo='$pc' and transDate>='$opDt' and transDate<='$clDt' and (transTyp=0 or transTyp=1 or transTyp=3 or transTyp=5)");
		$sumIsu=$this->obj->sumfield("finalprodstocktrans", "qty", "csNo='$pc' and transDate>='$opDt' and transDate<='$clDt' and (transTyp=2 or transTyp=4 or transTyp=6)");	
		$balStk=$sumRcv- $sumIsu;
		
		return $balStk;
	
	}
	
	
	public function getClosingValue($pc, $fyr, $opDt="", $clDt=""){
	
		
		
		
		$balVal=$this->CalCVal($pc, $opDt, $clDt);
		
		$Val=$balVal;
		
		return $Val;
		
	
	}
	
	private function CalCVal($pc, $opDt="", $clDt=""){
		
		$sumRcv=$this->obj->sumfield("finalprodstocktrans", "price", "csNo='$pc' and transDate>='$opDt' and transDate<='$clDt' and (transTyp=0 or transTyp=1 or transTyp=3 or transTyp=5)");
		$sumIsu=$this->obj->sumfield("finalprodstocktrans", "price", "csNo='$pc' and transDate>='$opDt' and transDate<='$clDt' and (transTyp=2 or transTyp=4 or transTyp=6)");	
		$balVal=$sumRcv- $sumIsu;
		
		return $balVal;
	
	}
	
	
	
	public function GetIssueRate($qty, $pcode, $opDate, $clDate){
	
		$turn=0;
		$iQty=$qty;
		$disRes=$this->obj->distinct("prodstocktrans", "rate", "(transTyp=0 or transTyp=1 or transTyp=3 or transTyp=5) and prodCode='$pcode' and transDate >='$opDate' and transDate <= '$clDate' and endFlg=0 order by transTyp" );
		while ($disFres=$this->obj->fetchrow($disRes)){
			
			$sumQty=$this->GetRateQty($disFres[0],$pcode, $opDate, $clDate);
			if ($iQty>=$sumQty){
				$balQty=$iQty-$sumQty;
				$rateArray[]="$disFres[0]|$sumQty";
				$this->CloseProdRate($disFres[0], $pcode);
			}elseif($iQty < $sumQty){
				$balQty=$iQty;
				$rateArray[]="$disFres[0]|$iQty";
				
			}
			$iQty=$iQty-$balQty;
		
		}
	
		return $rateArray;
	
	}
	
	private function GetRateQty($rate, $pcode, $opDate, $clDate){
	
		$sumRcvQty=$this->obj->sumfield("prodstocktrans", "qty", "rate='$rate' and (transTyp=0 or transTyp=1 or transTyp=3 or transTyp=5) and prodCode='$pcode' and transDate >='$opDate' and transDate <= '$clDate' and endFlg=0 ");
		
		$sumIsuQty=$this->obj->sumfield("prodstocktrans", "qty", "rate='$rate' and ( transTyp=2 or transTyp=4 or transTyp=6) and prodCode='$pcode' and transDate >='$opDate' and transDate <= '$clDate'");
		
		$sumQty=$sumRcvQty-$sumIsuQty;
		
		$sumQty=($sumQty>0) ? $sumQty : 0;
		
		return $sumQty;
		
	}
	
	public function CloseProdRate($rate, $pcode){
		
		$upRes=$this->obj->update("prodstocktrans", "endFlg=1", "prodCode='$pcode' and `rate`='$rate'");
	
	}
	
	
	
	public function Stock_Opening_Update($fyr, $pcode){
		
		$opRes=$this->obj->select("prodopstock", "finYear='$fyr' and prodCode='$pcode'");
		$opFres=$this->obj->fetchrow($opRes);
		
		$rate=@($opFres[4]/$opFres[3]);
		
		$rate=($rate) ? $rate : 0;
		
		
		$fld="transTyp, refNo, transDate, prodCode, qty, `rate`, `price`, finYear";
		$val="0, 'Opening Stock', '$opFres[6]', '$pcode', '$opFres[3]', $rate, '$opFres[4]', '$fyr'";
		
		$insRes=$this->obj->chkinsert("prodstocktrans", "prodCode='$pcode' and transTyp=0 and finYear='$fyr'", $fld, $val);
	
	
	}


}


?>