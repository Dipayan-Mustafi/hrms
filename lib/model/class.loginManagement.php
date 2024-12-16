<?php
class loginManagement{
	
	public $obj;
	
	public $misc;
	
	public $set;
	
	
	public function __construct(){
	
		$this->obj= new dbsql();
	
		$this->obj->Connect(HOST, USER, PWD, DATABASE);
	
	
		$this->misc=new misc();
	
		$this->set=new Setting();
	
	
	}
	
	
	
	
	public function LoginView( $url){
	
		$cprint="
			
			<div id=\"logBox\" style=\"width:40%;margin-top:20%;\">
	
				<form name=\"form1\" method=\"post\" action=\"".$url."logChk\" style=\"padding:5pt;\">
					<fieldset>
						<legend>Login</legend>
						<table border=\"0\" cellpadding=\"3\" cellspacing=\"0\" style=\"margin-top: 5pt; width:100%\">
							<tr>
								<td align='left' valign='top' width='20%'>Login ID</td>
								<td align='left' valign='top' width='80%'><input type='text' name='usrid' value='' size='20' autofocus='true'></td>
				
							</tr>
							<tr>
								<td align='left' valign='top'>Password</td>
								<td align='left' valign='top'><input type='password' name='pwd' value='' size='20'></td>
				
							</tr>
				
							<tr>
	
								<td align='center' valign='top' colspan='2'><input type='submit' name='blog' value='Login'></td>
				
							</tr>
	
	
						</table>
					</fieldset>
			
				</form>
		
		
		
			</div>
		
	
	
				";
	
		return $cprint;
	
	}
	
	
	public function chkLogin($u, $p){
		
		$ep=base64_encode(base64_encode(base64_encode($p)));
		$res=$this->obj->select("userdetail", "logID='$u' and pswd='$ep'");
		$rows=$this->obj->rows($res);
		
		return $rows;
		
		
	}
	
	
	public function regSession($u){
		
		$res=$this->obj->select("userdetail", "logID='$u'");
		$fres=$this->obj->fetchrow($res);
		
		$sessReg[0]=date('Y').date('m').date('d').sprintf("%02d",$fres[0]);
		$sessReg[1]=$fres[0];
		$sessReg[2]=$fres[3];
		$sessReg[3]=$fres[4];
		$sessReg[4]=$fres[5];
		
		
		return $sessReg;
		
	}
	
	public function genLogBook($v,$u){
		
		$cdt=date('Y-m-d');
		$ctm=date('H:i:s');
		
		$fld="chnNo, logID, loginDate, loginTime, active";
		$val="$v, '$u', '$cdt', '$ctm',1";
		
		$insRes=$this->obj->chkinsert("logbook", "chnNo=$v", $fld, $val);
		
		
	}
	
	
}