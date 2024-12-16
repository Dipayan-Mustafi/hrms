<?php


class WorkOrderManager{

	
	var $obj;
	var $misc;
	
	public function __construct(){
		
		$this->obj=new dbsql();
		
		$this->obj->Connect(HOST, USER, PWD, DATABASE);
		$this->misc=new misc();	
	
	}

	public function FindCostsheet($b=""){
		
		$cs=array();
	
		if ($b){
			$res=$this->obj->Select("costsheet","BuyerCode=$b or BuyerCode=0  order by csNo");	
		}else{
			$res=$this->obj->Select("costsheet order by csNo");	
		}
		
		
		while ($fres=$this->obj->FetchRow($res)){
			if(!in_array($fres[1], $cs)){
				$cs[]=$fres[1];
			}
		}
		
		
		return $cs;
	}	
	
}

?>