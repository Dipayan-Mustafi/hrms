<?

class MemberMaster{

	
	var $obj;
	
	public function __construct(){
		
		$this->obj=new dbsql();
		
		$this->obj->Connect(HOST, USER, PWD, DATABASE);
			
	
	}
	
	
	public function GenAjaxList($mn, $t=0){
		
		
		
		$res=$this->obj->select("membermast", "`memNo` like '$mn%' and memTyp=1 order by `Name`");
		while ($fres=$this->obj->fetchrow($res)){
			if ($t<2){
				$cecho.="<div class='mSm' onclick='FillMem($fres[0], \"$fres[1]\");'><div class='mS1' style='width:50px;'>$fres[0]</div><div class='mS1'style='width:120px;'>$fres[1]</div><div class='mS1' style='width:80px;'>$fres[19]</div></div>";
			}else{
				$cecho.="<div class='mSm' onclick='FillMultiMem($fres[0], \"$fres[1]\");'><div class='mS1'>$fres[1]</div><div class='mS1'>$fres[19]</div></div>";	
			}
			
		
		}
	
		return $cecho;
	}
	
	private function ShortList(){
		
		$res=$this->obj->select("membermast", "memTyp=1 order by `Name`");
		while ($fres=$this->obj->fetchrow($res)){
			
			$cecho.="<div class='mSel'><div class='mS1'>$fres[1]</div><div class='mS2'>$fres[19]</div></div>";
		
		}
	
	}
	
	public function GetMemDet($mid){
		
		
		$detArray=array();
		
		$res=$this->obj->Select("membermast", "memNo='$mid'");
		$fres=$this->obj->FetchRow($res);
			
			$detArray[0]=$fres[1];// memID
			$detArray[1]=$fres[2];//name
			$detArray[2]=$fres[3];//EmpID
			$detArray[3]=$fres[4];//Design
			$detArray[4]=$fres[5];//gurd name
			$detArray[5]=$fres[6];//dob
			$detArray[6]=$fres[14];//office
			$detArray[7]=$fres[15];//section
			$detArray[8]=$fres[18];//memdate
			$detArray[9]=$fres[12];//Mobile
			$detArray[10]=$fres[7];//Nominee
			$detArray[11]=$fres[8];//Nom. rel
			$detArray[12]=$fres[9];//addr
			$detArray[13]=$fres[10];//pres city
			$detArray[14]=$fres[11];//zip
			$detArray[15]=$fres[13];//mail
			$detArray[16]=$fres[29];//memTyp
			$detArray[17]=$fres[20];//thrift fund
			$detArray[18]=$fres[22];//wel fund
			$detArray[19]= $fres[16];//surity
			$detArray[20]=$fres[32];//Date of Joining
			$detArray[21]=$fres[18];//Date of Retirement
			$detArray[22]=$fres[29];//Permnant Address
			$detArray[23]=$fres[30];//Office Phone No
			$detArray[24]=$fres[31];//Residence Phone No.
			$detArray[25]=$fres[15];//Bill
			$detArray[26]=$fres[34];//Bank name
			$detArray[27]=$fres[35];//IFS Code
			$detArray[28]=$fres[36];//PAN
			$detArray[29]=$fres[26];//Cheque Name
			
		
		return $detArray;
	}
	
	
	
}



?>