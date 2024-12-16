<?

class StockManagement{

	
	var $obj;
	var $misc;
	
	public function __construct(){
		
		$this->obj=new dbsql();
		
		$this->obj->Connect(HOST, USER, PWD, DATABASE);

		$this->misc=new misc();
	
	}
	
	
	public function getClosingStock($pc, $fyr, $opDt="", $clDt="", $ch=""){
	
		$chkRes=$this->obj->select("prodstocktrans", "prodCode='$pc' and finYear='$fyr' and transTyp=0");
		$chkRows=$this->obj->rows($chkRes);
		if ($chkRows <1){
			
			$this->gen_Opening_Stock($fyr,$pc);
		}
		
		
		
		
		$sumRcv=$this->obj->sumfield("prodstocktrans", "qty", "prodCode='$pc' and transDate>='$opDt' and transDate<='$clDt' and (transTyp=1 or transTyp=3 or transTyp=5 or transTyp=0)");
		if ($ch){
			$sumIsu=$this->obj->sumfield("prodstocktrans", "qty", "prodCode='$pc' and transDate>='$opDt' and transDate<='$clDt' and (transTyp=2 or transTyp=4 or transTyp=6 or transTyp=8) and refNo !='$ch'");
		}else{
			$sumIsu=$this->obj->sumfield("prodstocktrans", "qty", "prodCode='$pc' and transDate>='$opDt' and transDate<='$clDt' and (transTyp=2 or transTyp=4 or transTyp=6 or transTyp=8)");
		}	
		$balStk=$sumRcv- $sumIsu;
		
		
		
		
		
		
		
		
		return $balStk;
		
	
	}
	
	private function CalCStock($pc, $opDt="", $clDt="", $ch=""){
		
		$sumRcv=$this->obj->sumfield("prodstocktrans", "qty", "prodCode='$pc' and transDate>='$opDt' and transDate<='$clDt' and ( transTyp=0 or transTyp=1 or transTyp=3 or transTyp=5)");
		if ($ch){
			$sumIsu=$this->obj->sumfield("prodstocktrans", "qty", "prodCode='$pc' and transDate>='$opDt' and transDate<='$clDt' and (transTyp=2 or transTyp=4 or transTyp=6 or transTyp=8) and refNo !='$ch'");
		}else{
			$sumIsu=$this->obj->sumfield("prodstocktrans", "qty", "prodCode='$pc' and transDate>='$opDt' and transDate<='$clDt' and (transTyp=2 or transTyp=4 or transTyp=6 or transTyp=8)");
		}	
		$balStk=$sumRcv- $sumIsu;
		
		return $clDt;
	
	}
	public function getClosingValue($pc, $fyr, $opDt="", $clDt="", $ch=""){
	
		$sumRcv=$this->obj->sumfield("prodstocktrans", "price", "prodCode='$pc' and transDate>='$opDt' and transDate<='$clDt' and (transTyp=1 or transTyp=3 or transTyp=5 or transTyp=0)");
		if ($ch){
			$sumIsu=$this->obj->sumfield("prodstocktrans", "price", "prodCode='$pc' and transDate>='$opDt' and transDate<='$clDt' and (transTyp=2 or transTyp=4 or transTyp=6 or transTyp=8) and refNo !='$ch'");
		}else{
			$sumIsu=$this->obj->sumfield("prodstocktrans", "price", "prodCode='$pc' and transDate>='$opDt' and transDate<='$clDt' and (transTyp=2 or transTyp=4 or transTyp=6 or transTyp=8)");
		}	
		$balVal=$sumRcv- $sumIsu;
		return $balVal;
		
		
	
	}
	
	private function CalCVal($pc, $opDt="", $clDt="", $ch=""){
		
		$sumRcv=$this->obj->sumfield("prodstocktrans", "price", "prodCode='$pc' and transDate>='$opDt' and transDate<='$clDt' and (transTyp=0 or transTyp=1 or transTyp=3 or transTyp=5)");
		if ($ch){
			$sumIsu=$this->obj->sumfield("prodstocktrans", "price", "prodCode='$pc' and transDate>='$opDt' and transDate<='$clDt' and (transTyp=2 or transTyp=4 or transTyp=6 or transTyp=8) and refNo !='$ch'");
		}else{
			$sumIsu=$this->obj->sumfield("prodstocktrans", "price", "prodCode='$pc' and transDate>='$opDt' and transDate<='$clDt' and (transTyp=2 or transTyp=4 or transTyp=6 or transTyp=8)");	
		$balVal=$sumRcv- $sumIsu;
		}
		return $balVal;
	
	}
	
	
	
	public function GetIssueRate($qty, $pcode, $opDate, $clDate){
	
		$turn=0;
		$iQty=$qty;
		
		$disRes=$this->obj->distinct("prodstocktrans", "`rate`", "(transTyp=0 or transTyp=1 or transTyp=3 or transTyp=5) and prodCode='$pcode' and transDate >='$opDate' and transDate <= '$clDate' and endFlg=0  and rate > 0 order by transTyp" );
		
		$disRows=$this->obj->rows($disRes);
		
		
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
	
		
		$sumRcvQty=$this->obj->sumfield("prodstocktrans", "qty", "rate='$rate' and (transTyp=0 or transTyp=1 or transTyp=3 or transTyp=5) and prodCode='$pcode' and transDate >='$opDate' and transDate <= '$clDate'");
			
			
		$sumIsuQty=$this->obj->sumfield("prodstocktrans", "qty", "rate='$rate' and ( transTyp=2 or transTyp=4 or transTyp=6 or transTyp=8) and prodCode='$pcode' and transDate >='$opDate' and transDate <= '$clDate' ");
			

		
		
		
		$sumQty=$sumRcvQty-$sumIsuQty;
		
		$sumQty=($sumQty>0) ? $sumQty : 0;
		
		return $sumQty;
		
	}
	
	public function CloseProdRate($rate, $pcode, $wo=""){
		
		
		$upRes=$this->obj->update("prodstocktrans", "endFlg=1", "prodCode='$pcode' and `rate`='$rate'  and (transTyp=0 or transTyp=1 or transTyp=3 or transTyp=5)");
		
	}
	
	
	
	public function Stock_Opening_Update($fyr, $pcode){
		
		$opRes=$this->obj->select("prodopstock", "finYear='$fyr' and prodCode='$pcode'");
		$opFres=$this->obj->fetchrow($opRes);
		
		$rate=@($opFres[4]/$opFres[3]);
		
		$rate=($rate) ? $rate : 0;
		
		$mstRes=$this->obj->select("prodmaster", "prodCode='$pcode'");
		$mstFres=$this->obj->fetchrow($mstRes);
		
		
		$fld="transTyp, refNo, transDate, prodCode, qty, `rate`, `price`, finYear, prodHead";
		$val="0, 'Opening Stock', '$opFres[6]', '$pcode', '$opFres[3]', $rate, '$opFres[4]', '$fyr', $mstFres[2]";
		
		$insRes=$this->obj->chkinsert("prodstocktrans", "prodCode='$pcode' and transTyp=0 and finYear='$fyr'", $fld, $val);
		
		if (!$insRes){
			
			$ufld="qty='$opFres[3]', `rate`=$rate, `price`='$opFres[4]', finYear='$fyr', prodHead='$mstFres[2]'";
			$upRes=$this->obj->update("prodstocktrans",$ufld ,"prodCode='$pcode' and transTyp=0 and finYear='$fyr'");
			
		
		}
	
	
	}
	
	public function gen_Opening_Stock($fyr, $pcode){
		
		$exp=explode("-", $fyr);
		
		$prvFyr=($exp[0]-1)."-".$exp[0];
		$prvOpDt=($exp[0]-1)."-04-01";
		$prvClDt=$exp[0]."-03-31";
		
		$today=date('Y-m-d');
		
		$prvStkRcv=$this->obj->sumfield("prodstocktrans", "qty", "(transTyp=0 or transTyp=1 or transTyp=3 or transTyp=5) and prodCode='$pcode' and transDate >='$prvOpDt' and transDate <= '$prvClDt'");
		$prvRcvVal=$this->obj->sumfield("prodstocktrans", "price", "(transTyp=0 or transTyp=1 or transTyp=3 or transTyp=5) and prodCode='$pcode' and transDate >='$prvOpDt' and transDate <= '$prvClDt'");
		
		$prvStkIssu=$this->obj->sumfield("prodstocktrans", "qty", "(transTyp=2 or transTyp=4 or transTyp=6 or transTyp=8) and prodCode='$pcode' and transDate >='$prvOpDt' and transDate <= '$prvClDt'");
		
		$prvIssuVal=$this->obj->sumfield("prodstocktrans", "price", "(transTyp=2 or transTyp=4 or transTyp=6 or transTyp=8) and prodCode='$pcode' and transDate >='$prvOpDt' and transDate <= '$prvClDt'");
		
		$balStk=$prvStkRcv - $prvStkIssu;
		$balVal=$prvRcvVal-$prvIssuVal;
		
		$mstRes=$this->obj->Select("prodmaster","prodCode='$pcode'");
		$mstFres=$this->obj->FetchRow($mstRes);
		
		
		$opFld="prodCode,prodHead, opStock, opValue, finYear, CreateDate, CreateBy";
		$opVal="'$pcode', $mstFres[2],'$balStk', $balVal,'$fyr','$today',0";
		
		$opRes=$this->obj->chkinsert("prodopstock", "prodCode='$pcode' and finYear='$fyr'", $opFld, $opVal);
		
		$rate=@($balVal/$balStk);
		$rate=($rate) ? $rate :0;
		
		$trnFld="transTyp, refNo, transDate, prodCode, qty, `rate`, `price`, finYear, prodHead";
		$trnVal="0, 'Opening Stock', '$today', '$pcode', '$balStk', $rate, '$balVal', '$fyr', $mstFres[2]";
		
		$insRes=$this->obj->chkinsert("prodstocktrans", "prodCode='$pcode' and transTyp=0 and finYear='$fyr'", $trnFld, $trnVal);
	}
	
	public function OpeningStockDateManagement($fyr, $pcode){
		
		$opDt=$this->misc->OpeningDate($fyr);
		$upRes=$this->obj->Update("prodstocktrans", "transDate='$opDt'", "prodCode='$pcode' and finYear='$fyr' and transTyp=0");
		
		$this->openingStockValue($fyr, $pcode);
			
		
		
	}
	
	public function openingStockValue($fyr, $pcode){
		
		$chkRes=$this->obj->Select("prodstocktrans", "prodCode='$pcode' and finYear='$fyr' and transTyp=0");
		$chkFres=$this->obj->FetchRow($chkRes);
		
		if (($chkFres[7]==0 || $chkFres[7]=="0.00") && $chkFres[5] >0 ){
			
			$value=$chkFres[5] *0.01;
			
			$upRes=$this->obj->Update("prodstocktrans", "rate='0.01',price='$value'","prodCode='$pcode' and finYear='$fyr' and transTyp=0");
			
		}
	}
	


}


?>