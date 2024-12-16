<?

require ($app['info']['path']."class/dbsql.php");
require ($app['info']['path']."class/misc_class.php");
require ($app['info']['path']."class/setting.php");
require ($app['info']['path']."lib/setup/class.SetupManagement.php");
require ($root."lib/hr/empManagement.php");




$obj=new dbsql();
$obj->connect(HOST, USER, PWD, DATABASE);

$set=new Setting();
$misc=new misc();

function convert_number($amount) 

{

	$exp=explode(".", $amount);
	
	$number=$exp[0];
	
	$paisa=sprintf("%02d",$exp[1]);
	
    if (($number < 0) || ($number > 999999999)) 
    { 
    throw new Exception("Number is out of range");
    } 

    $Gn = floor($number / 10000000);  /* Millions (giga) */ 
    $number -= $Gn * 10000000; 
	$lk = floor($number / 100000);    /* Lacs */
	$number -= $lk * 100000; 
    $kn = floor($number / 1000);     /* Thousands (kilo) */ 
    $number -= $kn * 1000; 
    $Hn = floor($number / 100);      /* Hundreds (hecto) */ 
    $number -= $Hn * 100; 
    $Dn = floor($number / 10);       /* Tens (deca) */ 
    $n = $number % 10;               /* Ones */ 

    $res = ""; 

    if ($Gn) 
    { 
        $res .= convert_number($Gn) . " Crore"; 
    } 
	
	if ($lk){
		$res.= (empty($res) ? "" : " "). convert_number($lk) . " Lac";
	}

    if ($kn) 
    { 
        $res .= (empty($res) ? "" : " ") . 
            convert_number($kn) . " Thousand"; 
    } 

    if ($Hn) 
    { 
        $res .= (empty($res) ? "" : " ") . 
            convert_number($Hn) . " Hundred"; 
    } 

    $ones = array("", "One", "Two", "Three", "Four", "Five", "Six", 
        "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", 
        "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", 
        "Nineteen"); 
    $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", 
        "Seventy", "Eigthy", "Ninety"); 

    if ($Dn || $n) 
    { 
        if (!empty($res)) 
        { 
            $res .= " "; 
        } 

        if ($Dn < 2) 
        { 
            $res .= $ones[$Dn * 10 + $n]; 
        } 
        else 
        { 
            $res .= $tens[$Dn]; 

            if ($n) 
            { 
                $res .= "-" . $ones[$n]; 
            } 
        } 
    } 
	
	if ($paisa && $paisa > 0){
	 
		if (strlen($paisa) < 3){
	
			$Pn=floor($paisa / 10);
			$pt=$paisa % 10;
		
		
			if ($Pn || $pt){
				if ($Pn < 2){
					$res .=" and ".$tens[$Pn *10 + $pt];
				}else{
					$res .= " and ".$tens[$Pn];
					if ($pt){
						$res .= "-".$ones[$pt];
					}
				}
				
			}
		}else{
			
			$pt=$paisa % 10;
			
			$res .=" and ".$tens[$pt];
		
		}
		$res .= " paise";
	}
	
	

    if (empty($res)) 
    { 
        $res = "zero"; 
    } 

    return $res; 
} 



?>