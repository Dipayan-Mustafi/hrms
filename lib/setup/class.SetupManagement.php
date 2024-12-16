<?php


class SetupManagement{
	
	public $obj;
	
	public $misc;
	
	public $set;
	
	
	public function __construct(){
		
		$this->obj= new dbsql();
		
		$this->obj->Connect(HOST, USER, PWD, DATABASE);
	
		
		$this->misc=new misc();
		
		$this->set=new Setting();	
		
		
	} 
	
	
	public function checkSetup(){
		
		$res=$this->obj->select("userdetail");
		$rows=$this->obj->rows($res);
		
		
		if ($rows <1){
			
			$this->set->redirect("install/");
		}else{
			
			$this->set->redirect("login");
		}		
		
		
	}
	
	public function chkLiveLogin(){
		
		
		if (!$_SESSION['usr']['id']){
			
			$this->set->Redirect("login");
			
		}
		
		
		
	}
	
	public function autoLogOut(){
		
		if ($_SESSION['usr']['id']){
			
			$this->set->redirect("logout");
		}
		
	}
	
	public function chkFinYear($fyr){
		
		$res=$this->obj->select("ledbaldet", "finYear='$fyr'");
		
		$rows=$this->obj->rows($res);
		
		return $rows;
	}
	
}
?>