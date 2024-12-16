<?php





//define ("TEMP_PATH", $app['info']['path']."temp/");
//define ("TEMP_SITE", $app['info']['url']."temp/");
//define ("ADM_PATH", $app['info']['path']."admin/");
//define ("ADM_SITE", $app['info']['url']."admin/");

define ("SIGNATURE", $app['info']['develop']);

$root=$app['info']['path'];
$url=$app['info']['url'];

$rpath=$root."resource/";
$rurl=$url."resource/";


$DepTypArray=array("", "RD", "Fixed", "MIS", "PGDF");

$IncTypArray=array("", "MIS", "QIS", "Redeem Maturity");

$acsTyp=array("--", "Super Admin", "Admin", "Operator");

$genTyp=array("", "M", "F");

$relgnTypArray=array("", "Hindu", "Muslim", "All");

$nmTypArray=array("", "Nominee", "Family member");

$contractorArray=array("", "BH", "MU");

$configType=array("", "ESI", "PF", "EPS", "EDLS", "PTAX", "TDS", "GROUP");


$mnthArray=array("", "Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sept","Oct","Nov","Dec");


$actType=array("",
		"Direct Expenditure",
		"Direct Income",
		"Indirect Expenditure",
		"Indirect Income",
		"Fixed Assets",
		"Investment",
		"Current Assets",
		"Cash-in-hand",
		"Cash-at-Bank",
		"Advances & Provisions",
		"Closing Stock",
		"Sundry Debtors",
		"Capital Fund",
		"Loan Fund",
		"Reserve Fund",
		"Current Liabilities",
		"Sundry Creditors",
		"Provisions & Payable",
		"Depreciation",
		"Drawings",
		"Memberr",
		"Customer",		
		"Employee");
$actCode=array("",
"101", 
"102",
"201",
"202", 
"301", 
"302", 
"303", 
"3031", 
"3032",
"3033", 
"304", 
"3034",
"401",
"402", 
"403",
"404", 
"4041",
"4042",
"3011",
"4011",
"501", 
"502", 
"503");

$tranTyp=array("","Dr", "Cr");

$vchTyp=array("","Receipt", "Payment", "Contra", "Journal Entry");

$loanTypArray=array("", "Secured", "Unsecured");

$docReqArray=array("", "Required", "Not Required");


$payTyp=array("--", "Salary", "Wages", "Director Salary");

$empTyp=array("--", "Permanent", "Casual");
$sxTyp=array("", "Male", "Female");

$marTyp=array("", "Married", "Unmarried", "Divorced");
$conTyp=array("", "Yes", "No");


$salTyp=array("", "Add", "Deduction");
$salRTyp=array("", "Actual", "Percentage");
$uTyp=array("--","Monthly", "Daily");

$suid=($_SESSION['usr']['id']) ? $_SESSION['usr']['id'] : 1;



require ($app['info']['path']."lib/header/HeaderLink.php");



?>