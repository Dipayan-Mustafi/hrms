<?php
class dbsql{
	
	public function Connect($host,$user,$pass,$db){
		
		$lnk=mysqli_connect($host, $user, $pass);
		mysqli_select_db($db, $lnk) ;
		
	}
	
	public function Select($tbl, $param=""){
		
		$sql="select * from $tbl";
		if (!empty($param)){
			$sql.=" where $param";
		}
				
		$res=mysqli_query($sql) or die (mysqli_error());
		
		return $res;
	}
	
	public function AdvSelect( $tbl,$fld, $param=""){
		
		$sql="select $fld from $tbl";
		if (!empty($param)){
			$sql.=" where $param";
		}
				
		$res=mysqli_query($sql) or die (mysqli_error());
		
		return $res;
	}
	
	public function GroupBy( $tbl,$fld,$group, $param=""){
		
		$sql="select $fld from $tbl";
		if ($param){
			$sql.=" where $param";
		}
		
		$sql.=" group by $group";
		
				
		$res=mysqli_query($sql) or die (mysqli_error());
		
		return $res;
	}
	
	public function Insert($tbl, $fld, $val){
		$sql="insert into $tbl ($fld) value ($val)";
		$res=mysqli_query($sql) or die (mysqli_error());
		return $res;
	}
	
	
	public function Update($tbl, $set, $param=""){
		$sql="update $tbl set $set";
		if (!empty($param)){
			$sql.= " where $param";
		}
		
		$res= mysqli_query($sql) or die(mysqli_error());
		
		return $res;
	}
	
	public function Delete($tbl, $param=""){
		$sql="delete from $tbl";
		if (!empty($param)){
			$sql.= " where $param";
		}
		$res=mysqli_query($sql) or die (mysqli_error());
		$opsql="optimize table $tbl";
		$opres=mysqli_query($opsql);
		
		return $res;
	}
	
	public function Rows($qry){
		$rows=mysqli_num_rows($qry);
		return $rows;
	}
	
	public function FetchArray($qry){
		$fres=mysqli_fetch_array($qry);
		return $fres;
	}
	
	public function FetchAssoc($qry){
		$fres=mysqli_fetch_assoc($qry);
		return $fres;
	}
	
	public function FetchRow($qry){
		$fres=mysqli_fetch_row($qry);
		return $fres;
	}
	
	public function Distinct($tbl, $fld, $param=""){
		$sql="select distinct($fld) from $tbl";
		if (!empty($param)){
			$sql.=" where $param";
		}
		 
		$res=mysqli_query($sql) or die (mysqli_error());
		return $res;
	}
	
	public function ChkInsert($tbl, $param="", $fld, $val){
		$sql="select * from $tbl";
		if (!empty($param)){
			$sql.=" where $param";
		}
				
		$res=mysqli_query($sql)or die (mysqli_error());
		
		$rows = mysqli_num_rows($res);
		
		if ($rows<1){
			$inssql="insert into $tbl ($fld) value ($val)";
			$insres=mysqli_query($inssql) or die (mysqli_error());
			
			return $insres;
		}
	}
	
	public function FullTextSearch($tbl, $fld, $val){
		
		$qry="select * from $tbl where ($fld) AGAINST ($val with query expansion )";
		
		$res=mysqli_query($qry) or die (mysqli_error());
		
		return $res;
		
	}
	
	
	
	public function Truncate($tbl){
	
		$sql="truncate table $tbl";
		$res=mysqli_query($sql) or die (mysqli_error());
		
		return $res;
	}
	
	public function LastID($tbl, $fld, $param=""){
	
		$sql="select max($fld) from $tbl";
		
		if ($param){
			$sql.=" where $param";
		}
		
		$res=mysqli_query($sql);
		
		$fres=mysqli_fetch_row($res);
		
		return $fres[0];
	}

	public function SumField($tbl, $fld, $param=""){
	
		$sql="select sum($fld) as total from $tbl";
		
		if ($param){
			$sql.=" where $param";
		}
		
		$res=mysqli_query($sql) or die(mysqli_error());
		$rows=mysqli_num_rows($res);
		if ($rows > 0){
			$fres=mysqli_fetch_assoc($res);
		
			return $fres['total'];
			
		}else{
			$total=0;
			return $total;
		}
	}
	
	public function AvgField($tbl, $fld, $param=""){
	
		$sql="select avg($fld) as total from $tbl";
		
		if ($param){
			$sql.=" where $param";
		}
		
		$res=mysqli_query($sql);
		$fres=mysqli_fetch_assoc($res);

		return $fres['total'];
	}
	
	public function CopyTable($tbl1, $tbl2, $param="" ){
		
		$sql="insert into $tbl1 select * from $tbl2";
		
		if ($param){
			$sql .=" where $param";
		}
		
		$res=mysqli_query($sql);
		
		return $res;
	}
	
	
	public function InsertSelect($tbl1, $fld1, $tbl2, $fld2, $param=""){
	
		$sql="insert into $tbl1 ($fld1) select from ($fld2) from $tbl2";
		
		if ($param){
		
			$sql.=" where $param";
		}
		$res = mysqli_query($sql);
		
		return $res;
	
	}
	
	public function DuplicateDelete($tbl, $fld,  $typ=""){
		
		$sql="select $fld from $tbl group by $fld having (count($fld) > 1 )";
		$res=mysqli_query($sql);
		$rows=mysqli_num_rows($res);

		$array_nxt=array("");
		
		if ($rows > 0){

			while ($fres=mysqli_fetch_row($res)){
				$nsql="select * from $tbl ";
				if ($typ=0){
					$nsql.="where $fld=$fres[0]";
				}else{
					$nsql.="where $fld='$fres[0]'";
				}
				$nxt_res=mysqli_query($nsql);
				$nxt_rows=mysqli_num_rows($nxt_res);
				
				$last_val=$nxt_rows-1;
				
				while ($nxt_fres=mysqli_fetch_array($nxt_res)){
					array_push($array_nxt, $nxt_fres[$fld]);
				}

				$opsql="optimize table $tbl";
				$opres=mysqli_query($opsql);
			
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
		
		$res=mysqli_query($sql);
		
		$fres=mysqli_fetch_row($res);
		
		return $fres[0];
	}
	
	public function LastRec($tbl, $param=""){
		
		$sql="select * from $tbl";
		if ($param){
			$sql.=" where $param";
		}
		
		$res=mysqli_query($sql);
		$rows=mysqli_num_rows($res);
		
		$last_row=$rows - 1;
		if ($last_row >= 0 ){
			$final_sql="select * from $tbl ";
			if($param){
				$final_sql.="where $param ";
			}
			$final_sql.="limit $last_row,1";
		
			
		}
		$final_res=mysqli_query($final_sql);
			
		return $final_res;
	}
	
	public function ShowTables(){

		$res="show tables";
		return $res;
	}	
	
}
?>
