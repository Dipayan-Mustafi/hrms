<?php
class MembersManager{


	var $obj;
	var $misc;

	public function __construct(){

		$this->obj=new dbsql();

		$this->obj->Connect(HOST, USER, PWD, DATABASE);
		$this->misc=new misc();

	}
	
	public function getMemSelectList(){
		
		$res=$this->obj->select("membermaster", "")
		
	}	
}