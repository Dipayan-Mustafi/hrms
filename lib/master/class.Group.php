<?

class GroupManager{

	
	var $obj;
	
	public function __construct(){
	
		$this->obj=new dbsql();
	
		$this->obj->Connect(HOST, USER, PWD, DATABASE);
			
	
	}
	
	
	
	public function GenGroupList($f, $g=0){
		
		$res=$this->obj->Select("ddomaster", "officeID=$f order by ddoName");
		while ($fres=$this->obj->FetchRow($res)){
			if ($g==$fres[0]){
				$cprint.="<option value='$fres[0]' selected>$fres[1]</option>";
			}else{
				$cprint.="<option value='$fres[0]'>$fres[1]</option>";
			}
			
		}
		
		return $cprint;
	}
	public function GenSecList($f, $g=0){
		
		$res=$this->obj->Select("secmaster", "officeID=$f order by secName");
		while ($fres=$this->obj->FetchRow($res)){
			if ($g==$fres[0]){
				$cprint.="<option value='$fres[0]' selected>$fres[1]</option>";
			}else{
				$cprint.="<option value='$fres[0]'>$fres[1]</option>";
			}
			
		}
		
		return $cprint;
	}
	

}




?>