<?

class PageDesign{

	
	var $obj;
	
	public function __construct(){
		
		$this->obj=new dbsql();
		
		$this->obj->Connect(HOST, USER, PWD, DATABASE);
			
	
	}
	
	
	public function UserName($u){
	
		
		//$res=$this->obj->select("user_account", "")
	
	}


}


?>