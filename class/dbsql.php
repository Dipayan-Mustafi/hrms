<?php
class dbsql{
	
	var $lnk;
	
	public function Connect($host,$user,$pass,$db){
		
		$dsn="mysql:host=$host;dbname=$db;charset=utf8";
		
		$this->lnk=new PDO($dsn, $user, $pass);
		
		$this->lnk->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
	}
	
	public function Select($tbl, $param=""){
		
		$sql="select * from $tbl";
		if (!empty($param)){
			$sql.=" where $param";
		}
		try {
			$res=$this->lnk->query($sql);
		} catch (Exception $e) {
			$res= 'ERROR: ' . $e->getMessage();
		}		
		
		
		return $res;
	}
	
	public function AdvSelect( $tbl,$fld, $param=""){
		
		$sql="select $fld from $tbl";
		if (!empty($param)){
			$sql.=" where $param";
		}
				
	try {
			$res=$this->lnk->query($sql);
		} catch (Exception $e) {
			$res= 'ERROR: ' . $e->getMessage();
		}	
		
		return $res;
	}
	
	public function GroupBy( $tbl,$fld,$group, $param=""){
		
		$sql="select $fld from $tbl";
		if ($param){
			$sql.=" where $param";
		}
		
		$sql.=" group by $group";
		
				
	try {
			$res=$this->lnk->query($sql);
		} catch (Exception $e) {
			$res= 'ERROR: ' . $e->getMessage();
		}	
		
		return $res;
	}
	
	public function Insert($tbl, $fld, $val){
		$sql="insert into $tbl ($fld) value ($val)";
	try {
			$res=$this->lnk->query($sql);
		} catch (Exception $e) {
			$res= 'ERROR: ' . $e->getMessage();
		}

		
		return $res;
	}
	
	
	public function Update($tbl, $set, $param=""){
		$sql="update $tbl set $set";
		if (!empty($param)){
			$sql.= " where $param";
		}
		
	try {
			$res=$this->lnk->query($sql);
		} catch (Exception $e) {
			$res= 'ERROR: ' . $e->getMessage();
		}
		
		return $res;
	}
	
	public function Delete($tbl, $param=""){
		$sql="delete from $tbl";
		if (!empty($param)){
			$sql.= " where $param";
		}
	try {
			$res=$this->lnk->query($sql);
		} catch (Exception $e) {
			$res= 'ERROR: ' . $e->getMessage();
		}
	$opsql="optimize table $tbl";
	try {
			$res=$this->lnk->query($opsql);
		} catch (Exception $e) {
			$res= 'ERROR: ' . $e->getMessage();
		}
		
		return $res;
	}
	
	public function Rows($res){
		$rows=$res->rowCount();
		return $rows;
	}
	
	public function FetchArray($res){
		$fres=$res->fetch(PDO::FETCH_ASSOC);
		return $fres;
	}
	
	public function FetchAssoc($res){
		$fres=$res->fetch(PDO::FETCH_ASSOC);
		return $fres;
	}
	
	public function FetchRow($res){
		$fres=$res->fetch(PDO::FETCH_NUM);
		return $fres;
	}
	
	public function Distinct($tbl, $fld, $param=""){
		$sql="select distinct($fld) from $tbl";
		if (!empty($param)){
			$sql.=" where $param";
		}
		 
		try {
			$res=$this->lnk->query($sql);
		} catch (Exception $e) {
			$res= 'ERROR: ' . $e->getMessage();
		}
		return $res;
	}
	
	public function ChkInsert($tbl, $param="", $fld, $val){
		$sql="select * from $tbl";
		if (!empty($param)){
			$sql.=" where $param";
		}
				
		try {
			$res=$this->lnk->query($sql);
		} catch (Exception $e) {
			$res= 'ERROR: ' . $e->getMessage();
		}
		
		$rows = $res->rowCount();
		$rows=intval($rows);
		
		if ($rows<1){
			$inssql="insert into $tbl ($fld) value ($val)";
		try {
			$res=$this->lnk->query($inssql);
		} catch (Exception $e) {
			$res= 'ERROR: ' . $e->getMessage();
		}
			
			return $res;
		}
	}
	
	public function FullTextSearch($tbl, $fld, $val){
		
		$qry="select * from $tbl where ($fld) AGAINST ($val with query expansion )";
		
		try {
			$res=$this->lnk->query($sql);
		} catch (Exception $e) {
			$res= 'ERROR: ' . $e->getMessage();
		}
		
		return $res;
		
	}
	
	
	
	public function Truncate($tbl){
	
		$sql="truncate table $tbl";
		try {
			$res=$this->lnk->query($sql);
		} catch (Exception $e) {
			$res= 'ERROR: ' . $e->getMessage();
		}
		
		return $res;
	}
	
	public function LastID($tbl, $fld, $param=""){
	
		$sql="select max($fld) from $tbl";
		
		if ($param){
			$sql.=" where $param";
		}
		
		try {
			$res=$this->lnk->query($sql);
			$fres=$res->fetch(PDO::FETCH_NUM);
		} catch (Exception $e) {
			$res= 'ERROR: ' . $e->getMessage();
			$fres=$res;
		}
		
		
		
		
		return $fres[0];
	}

	public function SumField($tbl, $fld, $param=""){
	
		$sql="select sum($fld) as total from $tbl";
		
		if ($param){
			$sql.=" where $param";
		}
		
		try {
			$res=$this->lnk->query($sql);
			$rows=$res->rowCount();
			
			if ($rows > 0){
				$fres=$res->fetch(PDO::FETCH_ASSOC);
			
				return $fres['total'];
					
			}else{
				$total=0;
				return $total;
			}
		} catch (Exception $e) {
			$res= 'ERROR: ' . $e->getMessage();
			return $res;
		}
		
		
	}
	
	public function AvgField($tbl, $fld, $param=""){
	
		$sql="select avg($fld) as total from $tbl";
		
		if ($param){
			$sql.=" where $param";
		}
		
		try {
			$res=$this->lnk->query($sql);
			$rows=$res->rowCount();
			
			if ($rows > 0){
				$fres=$res->fetch(PDO::FETCH_ASSOC);
			
				return $fres['total'];
					
			}else{
				$total=0;
				return $total;
			}
		} catch (Exception $e) {
			$res= 'ERROR: ' . $e->getMessage();
			return $res;
		}

	}
	
	public function CopyTable($tbl1, $tbl2, $param="" ){
		
		$sql="insert into $tbl1 select * from $tbl2";
		
		if ($param){
			$sql .=" where $param";
		}
		
		try {
			$res=$this->lnk->query($sql);
			
		} catch (Exception $e) {
			$res= 'ERROR: ' . $e->getMessage();
		}
		
		return $res;
	}
	
	
	public function InsertSelect($tbl1, $fld1, $tbl2, $fld2, $param=""){
	
		$sql="insert into $tbl1 ($fld1) select from ($fld2) from $tbl2";
		
		if ($param){
		
			$sql.=" where $param";
		}
		try {
			$res=$this->lnk->query($sql);
			
		} catch (Exception $e) {
			$res= 'ERROR: ' . $e->getMessage();
		}
		
		return $res;
	
	}
	
	public function DuplicateDelete($tbl, $fld,  $typ=""){
		
		$sql="select $fld from $tbl group by $fld having (count($fld) > 1 )";
		try {
			$res=$this->lnk->query($sql);
			
		} catch (Exception $e) {
			$res= 'ERROR: ' . $e->getMessage();
		}
		$rows=$res->rowCount();

		$array_nxt=array("");
		
		if ($rows > 0){

			while ($fres=$res->fetch(PDO::FETCH_NUM)){
				$nsql="select * from $tbl ";
				if ($typ=0){
					$nsql.="where $fld=$fres[0]";
				}else{
					$nsql.="where $fld='$fres[0]'";
				}
				$nxt_res=$this->lnk->query($nsql);
				$nxt_rows=$nxt_res->rowCount();
				
				$last_val=$nxt_rows-1;
				
				while ($nxt_fres=$nxt_res->fetch(PDO::FETCH_ASSOC)){
					array_push($array_nxt, $nxt_fres[$fld]);
				}

				$opsql="optimize table $tbl";
				$opres=$this->lnk->query($opsql);
			
			}
		
		}
		if ($opres){
			$msg="Duplicate Entry is removed";
		}
		return $array_nxt;
	
	}
	
	public function FirstID($tbl, $fld, $param=""){
	
		$sql="select min($fld) from $tbl";
		
		if ($param){
			$sql.=" where $param";
		}
		
		try {
			$res=$this->lnk->query($sql);
		} catch (Exception $e) {
			$res= 'ERROR: ' . $e->getMessage();
		}
		
		
		$fres=$res->fetch(PDO::FETCH_NUM);
		
		return $fres[0];
	}
	
	public function LastRec($tbl, $param=""){
		
		$sql="select * from $tbl";
		if ($param){
			$sql.=" where $param";
		}
		
		try {
			$res=$this->lnk->query($sql);
		} catch (Exception $e) {
			$res= 'ERROR: ' . $e->getMessage();
		}
		
		$rows=$res->rowCount();
		$fres=$res->fetch(PDO::FETCH_NUM);
		
		$last_row=$rows - 1;
		if ($last_row >= 0 ){
			$final_sql="select * from $tbl ";
			if($param){
				$final_sql.="where $param ";
			}
			$final_sql.="limit $last_row,1";
		
			
		}
		try {
			$finalRes=$this->lnk->query($final_sql);
		} catch (Exception $e) {
			$finalRes= 'ERROR: ' . $e->getMessage();
		}
			
		return $finalRes;
	}
	
	public function ShowTables(){

		$res="show tables";
		return $res;
	}	
	
}
?>
