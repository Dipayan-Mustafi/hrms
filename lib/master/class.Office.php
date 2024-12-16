<?

class OfficeManager{

	
	var $obj;
	
	public function __construct(){
	
		$this->obj=new dbsql();
	
		$this->obj->Connect(HOST, USER, PWD, DATABASE);
			
	
	}
	
	
	
	public function GenOfficeList($f){
		
		$res=$this->obj->Select("officemaster order by officeName");
		while ($fres=$this->obj->FetchRow($res)){
			if ($f==$fres[0]){
				$cprint.="<option value='$fres[0]' selected>$fres[1]</option>";
			}else{
				$cprint.="<option value='$fres[0]'>$fres[1]</option>";
			}
		}
		
		return $cprint;
	}
	
	
	public function GenDesigList($d=0){
	
		$res=$this->obj->Select("desigmaster order by desigName");
		while ($fres=$this->obj->FetchRow($res)){
			
			if ($d==$fres[0]){
				$cprint.="<option value='$fres[0]' selected>$fres[1]</option>";
			}else{
				$cprint.="<option value='$fres[0]'>$fres[1]</option>";
			}
			
			
		}
	
		return $cprint;
	}
	

}




?>