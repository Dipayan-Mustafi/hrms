<?php





class Setting {
	
	public function metaHeading(){
		print "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />";
	
		
	}
	
	public function PageTitle($cont){
		print "<title>$cont</title>";
	}
	
	public function EndHeader(){
		print "</head>";
	}
	

	
	public function Body($func=""){
		if (empty($func)){
			print "<body>";
		}else{
			print "<body $func>";
		}
	}
	
	public function Redirect($page){
		print "<meta http-equiv='refresh' content='0;url=$page'>";
	}
	
	public function DomainDet(){
		$domain=$_SERVER['HTTP_HOST'];
		return $doamin;
	}
	
	public function RequestQry(){
		$qry=$_SERVER['QUERY_STRING'];
		return $qry;
	}
	
	public function FilterWords($word){
		
		$ban_words_array=array(" a "," an "," for "," in "," into ", " within ", " by ", " at ", " and " , " or ", " = ", " + ", " - "," to ", " of ", " than ", " then ", " about ", "looking", " is ", "what", "how", "where", "sexy", "sexc", "who", "want", "fuck", "fcuk", "though", "would", "will", "am",  "are", "shall", "like" );
		
		
	
	}
	
	public function JScriptAlert($alert){
	
		$print="<script type='text/javascript'>alert('$alert')</script>";
		
		return $print;
	}
	
	
	public function JSClose(){
	
		$print="<script type='text/javascript'>window.close();</script>";
		
		return $print;
	}
	
	public function JSOSubmit($form){
		$print="<script type='text/javascript'>opener.document.".$form.".submit();</script>";
		
		return $print;
	}
	
	public function JSOReload(){
		$print="<script type='text/javascript'>window.opener.location.reload();</script>";
		
		return $print;
	}
	
	public function JSLReplace($url){
		$print="<script type='text/javascript'>window.location.replace('".$url."');</script>";
		
		return $print;
	}
	
	public  function jsoredirect($p){
		$print="
				<script type='text/javascript'>
				window.opener.document.location='$p';
				
				</script>
				
				";
		
		return $print;
	}
	
	
	public function jsoValueSet($i,$v){
		print "
			<script type='text/javascript>'

			opener.document.getElementById($i).value=$v;
			</script>	
				";
		
	} 
	
}


?>