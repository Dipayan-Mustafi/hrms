<?php
class Pagination{
	
	var $page=0;
	var $page_num=0;
	var $tot_rows=0;
	var $limit=0;
	
	
	
	public function SetPage($page, $limit, $rows){
	
		$this->page=$page;
		$this->limit=$limit;
		$this->tot_rows=$rows;
		
	}
	
	public function PageCalcuation(){
	
		$this->page_num=intval($this->tot_rows / $this->limit);
		
		
		if (($this->tot_rows % $this->limit > 0) && ($this->tot_rows > $this->limit)){
			$this->page_num++;
		}
		
		return $this->page_num;
	}
	
	public function Total_Page_Control($page){
		
		if (($this->page_num > 10)&& ($page < 10)){
			
			$page_rec[0]=1;
			$page_rec[1]=10;
		}elseif (($this->page_num > 10) && ($page >=10)){
			$page_rec[0]=$page-5;
			$page_rec[1]=$page+5;
		
		}
		
		return $page_rec;
	}
	
	
	
	

}


?>