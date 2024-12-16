<?php
class fyManagement {
	
	public $obj;
	
	public $misc;
	
	public $set;
	
	
	public function __construct(){
	
		$this->obj= new dbsql();
	
		$this->obj->Connect(HOST, USER, PWD, DATABASE);
	
	
		$this->misc=new misc();
	
		$this->set=new Setting();
	
	
	}
	
	
	public function chkMasterAccounts($acTyp, $acCode, $tt,$url, $fyr=""){
		
		$res=$this->obj->Select("ledgermaster");
		$rows=$this->obj->rows($res);
		
		if ($rows <1){
			
			$cprint=$this->genMaster($acTyp, $acCode, $tt);	
			
		}else{
			
			$cprint.=$this->listMasterLed($fyr, $url);
		}
		
		return $cprint;
	}
	
	
	public function genMaster($acTyp, $acCode, $tt){
		
		$count=count($acTyp);
		$tcount=count($tt);
		
		$cfin=$this->misc->CurrentFinYear(date('y'), date('m'));
		
		$opDt=$this->misc->OpeningDate($cfin);
		
		$cprint.="
			<div id=\"fyMan\">	
				<form name='form1' method='post' action='addAccount'>
				
					<table border=\"0\" cellpadding=\"3\" cellspacing=\"0\" width=\"100%\">
						<tr>
							<th colspan='2' align='left' valign='top'>New Ledger Generation</th>
						</tr>
						<tr>
							<td align='left' valign='top'>Account Name </td>
							<td align='left' valign='top'><input type='text' name='aname' value='' size='20' id='aname' autofocus='autofocus'></td>	
						</tr>
						<tr>
							<td align='left' valign='top'>Account Type</td>
							<td align='left' valign='top'><select name='acTyp'>
								<option value='0'>--</option>";
								for ($i=1; $i < $count; $i++){
									
									$cprint.="<option value='$acCode[$i]'>$acTyp[$i]</option>";
								}
				
				$cprint.="	</select>
							</td>	
						</tr>
						<tr>
							<td align='left' valign='top'>Sub Ledger of</td>
							<td align='left' valign='top'>
								<select name='mled'>
									<option value='0'>--</option>
							
						";
							
							$res=$this->obj->select("ledgermaster");
							while ($fres=$this->obj->fetchrow($res)){
								
								$cprint.="<option value='$fres[0]'>$fres[1]</option>";
								
								
							}
							
							
							
							
				$cprint.="</select>	</td>
						</tr>
						<tr>
							<td align='left' valign='top'>Financial Year</td>
							<td align='left' valign='top'><input type='text' name='fyr' value='$cfin' size='20' id='fyr'></td>	
						</tr>
						<tr>
							<td align='left' valign='top'>Opening Balance </td>
							<td align='left' valign='top'><input type='text' name='opbal' value='0' size='20' id='opbal'></td>	
						</tr>
						<tr>
							<td align='left' valign='top'>Opening Date</td>
							<td align='left' valign='top'><input type='text' name='opdt' value='$opDt' size='20' id='opdt'></td>	
						</tr>
						<tr>
							<td align='left' valign='top'>Balance Type </td>
							<td align='left' valign='top'>
							<select name='btyp'>
								<option value='0'>--</option>";
							for ($t=1; $t <$tcount; $t++){
								
								$cprint.= "<option value='$t'>$tt[$t]</option>";
							}	
				$cprint.="	</select>
							</td>	
						</tr>
						<tr>
							
							<td align='center' valign='top' colspan='2'><input type='submit' name='bsav' value='Insert'></td>	
						</tr>
					</table>
				
				</form>
				
			</div>	
				";
		
		return $cprint;
		
	}
	
	public function listMasterLed($fyr,$url){
		
		$cprint.="<div id='fyMan'>
				
					<table border=\"0\" cellpadding=\"3\" cellspacing=\"0\" width=\"100%\">
						<tr>
							<th colspan='7' align='left' valign='top'>Ledger List</th>
							<th align='right' valign='top'><input type='button' name='bNew' value=\"Insert\" accesskey=\"I\" onclick='navigate(\"newLedger\");'></th>
						</tr>
						<tr>
							<th align='center' valign='top' width='8%'>Ledger No.</th>
							<th align='center' valign='top' width='25%'>Ledger Name</th>
							<th align='center' valign='top' width='15%'>Ledger Alias</th>
							<th align='center' valign='top' width='8%'>Financial Year</th>
							<th align='center' valign='top' width='10%'>Opening Balance</th>
							<th align='center' valign='top' width='6%%'>Type</th>
							<th align='center' valign='top' width='10%'>Closing Balance</th>
							<th align='center' valign='top' width='22%'>#</th>
						</tr>";
		
			$res=$this->obj->select("ledgermaster order by LedName");
			while ($fres=$this->obj->fetchrow($res)){
				
				$getOBal=$this->ledOpeningBalance($fres[0], $fyr);
				
				$typ=($getOBal[1]==1) ? "Dr" : "Cr";
				
				$cprint.="<tr>
						<td  align='center' valign='top'>$fres[0]</td>
						<td  align='center' valign='top'>$fres[1]</td>
						<td  align='center' valign='top'>$fres[2]</td>
						<td  align='center' valign='top'>$fyr</td>
						<td  align='right' valign='top'>$getOBal[0]</td>
						<td  align='center' valign='top'>$typ</td>
						<td  align='center' valign='top'>0</td>
						<td  align='center' valign='top'><input type='button' value='Detail' onclick='navigate(".$url."accounts/ledDet?lid=$fres[0]);'>
						<input type='button' value='Modify' onclick='navigate(\"ModLed?lid=$fres[0]\");'>
						</td>
						</tr>
						";
				
			}
				
			$cprint.="</table>
				
				</div>
				";
			
		return $cprint;
	}
	
	
	public function ledOpeningBalance($lid, $fyr){
		
		$res=$this->obj->select("ledbaldet", "LedID=$lid and finYear='$fyr'");
		$fres=$this->obj->fetchrow($res);
		
		$balDet[0]=$fres[4];
		$balDet[1]=$fres[5];
		
		return $balDet;
		
	}
	
	public function modLedDet($lid, $fyr, $acTyp, $acCode, $tt){
		
		$count=count($acTyp);
		$tcount=count($tt);
		
		$cfin=$fyr;
		
		$opDt=$this->misc->OpeningDate($cfin);
		
		$res=$this->obj->select("ledgermaster", "LedID=$lid");
		$fres=$this->obj->fetchrow($res);
		
		$opBal=$this->ledOpeningBalance($lid, $fyr);
		
		$cprint.="
			<div id=\"fyMan\">
				<form name='form1' method='post' action='addAccount'>
		
					<table border=\"0\" cellpadding=\"3\" cellspacing=\"0\" width=\"100%\">
						<tr>
							<th colspan='2' align='left' valign='top'>Modification of Ledger</th>
						</tr>
						<tr>
							<td align='left' valign='top'>Account Name <input type='hidden' value='$lid' name='lid'></td>
							<td align='left' valign='top'><input type='text' name='aname' value='".htmlspecialchars_decode($fres[1])."' size='20' id='aname'></td>
						</tr>
						<tr>
							<td align='left' valign='top'>Account Type</td>
							<td align='left' valign='top'><select name='acTyp'>
								<option value='0'>--</option>";
		for ($i=1; $i < $count; $i++){
			if ($fres[4]==$acCode[$i]){	
				$cprint.="<option value='$acCode[$i]' selected>$acTyp[$i]</option>";
			}else{
				$cprint.="<option value='$acCode[$i]'>$acTyp[$i]</option>";
			}
		}
		
		$cprint.="	</select>
							</td>
						</tr>
						<tr>
							<td align='left' valign='top'>Sub Ledger of</td>
							<td align='left' valign='top'>
								<select name='mled'>
									<option value='0'>--</option>
				
						";
			
		$lres=$this->obj->select("ledgermaster");
		while ($lfres=$this->obj->fetchrow($lres)){
			if ($fres[3]==$lfres[0]){
				$cprint.="<option value='$lfres[0]' selected>$lfres[1]</option>";
			}else{
				$cprint.="<option value='$lfres[0]'>$lfres[1]</option>";
			}
		
		
		}
			
			
			
			
		$cprint.="</select>	</td>
		</tr>
		<tr>
		<td align='left' valign='top'>Financial Year</td>
		<td align='left' valign='top'><input type='text' name='fyr' value='$cfin' size='20' id='fyr'></td>
		</tr>
		<tr>
		<td align='left' valign='top'>Opening Balance </td>
		<td align='left' valign='top'><input type='text' name='opbal' value='$opBal[0]' size='20' id='opbal'></td>
		</tr>
		<tr>
		<td align='left' valign='top'>Opening Date</td>
		<td align='left' valign='top'><input type='text' name='opdt' value='$opDt' size='20' id='opdt'></td>
		</tr>
		<tr>
		<td align='left' valign='top'>Balance Type </td>
		<td align='left' valign='top'>
		<select name='btyp'>
		<option value='0'>--</option>";
		for ($t=1; $t <$tcount; $t++){
			if ($fres[5]==$t){
				$cprint.= "<option value='$t' selected>$tt[$t]</option>";
			}else{
				$cprint.= "<option value='$t'>$tt[$t]</option>";
				
			}
		}
			$cprint.="	</select>
			</td>
			</tr>
			<tr>
				
			<td align='center' valign='top' colspan='2'><input type='submit' name='bsav' value='Insert'></td>
						</tr>
					</table>
		
				</form>
		
			</div>
				";
		
		return $cprint;
		
	
		
		
	}
	
	
	
 	
}


?>