<? 
error_reporting(E_ALL);
require ("../../../config/setup.inc");

$type=$_REQUEST['typ'];
$flg=$_REQUEST['flg'];
$fdt=$_REQUEST['frm'];
$tdt=$_REQUEST['to'];
$dept=$_REQUEST['dept'];
$ecode=$_REQUEST['eq'];
$eCode=$_REQUEST['ename'];
$mnth=$_REQUEST['mth'];
$yr=$_REQUEST['yr'];
$rad=$_REQUEST['stp'];

$expFdt=explode("-",$fdt);
$syr=$expFdt[0];

$expTdt=explode("-",$tdt);
$eyr=$expTdt[0];


$smnth=date("m", strtotime($fdt));
$emnth=date("m", strtotime($tdt));
$mdiff=$emnth-$smnth;
$ydiff=$eyr-$syr;

#esi Reports
switch(true){
	case ($flg==1 && $type==1):
		
			$set->redirect("ESImnth.php?fdt=".$fdt."&amp;tdt=".$tdt."&amp;dept=".$dept);
		
		break;
		
	case ($flg==1 && $type==2):
		$set->redirect("form5.php?fdt=".$fdt."&amp;tdt=$tdt");
		break;
		
	case ($flg==2 && $type==1):
			$set->redirect("EPFmnth.php?mnth=".$mnth."&amp;year=".$yr."&amp;dept=".$dept."&amp;typ=".$type);
		break;
		
	case ($flg==3):
		if($ecode || $eCode){
			$set->redirect("misInd.php?fdt=".$fdt."&amp;tdt=".$tdt."&amp;ecode=".$ecode);
		}else if($dept){
			//print $rad;
			$set->redirect("misDept.php?fdt=".$fdt."&amp;tdt=".$tdt."&amp;dept=".$dept."&amp;flg=1&amp;slc=".$rad);	
		}else{		
			//print $rad;
			$set->redirect("misDept.php?fdt=".$fdt."&amp;tdt=".$tdt."&amp;flg=1&amp;slc=".$rad);
		}
		break;
	default:
		print "me 3";
		break;
		
}

?>