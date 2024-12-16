<?php
  require ("mSetup.inc");

$title="Demand Preview";

require (TEMP_PATH."viewTemp.php");


require($root."lib/loan/Class.DemandManager.php");

$dman=new DemandMan();

$m=$_REQUEST['m'];
$y=$_REQUEST['y'];
if (intval($m)>1){

  $prm=sprintf("%02d",($m-1));
  $pry=$y;
}else{
   $prm="12";
   $pry=$y-1;
}

$duDt="$pry-$prm-28";

$fyr=$misc->currentfinyear($curYear, $curMonth);
?>
<style type='text/css'>
 .ddhead { width:990px; padding:5px; display:table; font-weight:bold; font-family:arial; font-size:13px;}
 .rowHead {width:990px; display:table; font-family:arial; font-size:13px; border:solid 1px #666666; border-left:none; border-right:none;}
 .rowFoot {width:990px; display:table; font-family:arial; font-size:13px; border:solid 1px #666666; border-left:none; border-right:none;page-break-after:always}
 .divCell { float:left}

</style>
<script type="text/javascript">
function DetView(m,y){
  window.location="viewDemand?m="+m+"&y="+y;
}
function PrintView(m,y){
  window.location="printODemand?m="+m+"&y="+y;
}
</script>
 <div style="text-align:right"><input type="button" value="Summary View" onclick="DetView('<?= $m?>', '<?= $y?>')">&nbsp;<input type="button" value="Print" onclick="PrintView('<?= $m?>', '<?= $y?>')"></div>
<?

$disRes=$obj->distinct("demandmast","ddoID", "demandMonth='$m' and demandYear='$y' and endFlg<2");
while ($disFres=$obj->fetchrow($disRes)){
    $ddRes=$obj->select("ddomaster", "ddoID=$disFres[0]");
    $ddFres=$obj->fetchrow($ddRes);


    print "<div class='ddhead' style='width:1500px;'>$ddFres[1]</div>";
    print "
    <div class='rowHead' style='font-weight:bold; width:1500px'>
        <div class='divCell' style='width:80px;'>Member ID</div>
        <div class='divCell' style='width:150px;'>Member Name</div>
        <div class='divCell' style='width:80px; text-align:center'>Thrift Fund</div>
        <div class='divCell' style='width:85px; text-align:center'>DCRB Fund</div>
		 <div class='divCell' style='width:85px; text-align:center'>RD</div>";
    $mstRes=$obj->Select("loanmaster order by pos");
    while ($mstFres=$obj->fetchrow($mstRes)){
        print "
        <div class='divCell' style='width:100px; text-align:right'>$mstFres[1]</div>
		<div class='divCell' style='width:100px; text-align:right'>Balance $mstFres[1] / Installment</div>
        ";
    }
    print "<div class='divCell' style='width:100px; text-align:right'>Total Demand</div>";
   

    print "</div>";
    $memRes=$obj->select("membermast", "DDCode=$disFres[0] and demandTyp=1");
    while ($memFres=$obj->Fetchrow($memRes)){
        $dmstRes=$obj->select("demandmast","demandMonth='$m' and demandYear='$y' and memID=$memFres[0]");
        $dmstRows=$obj->rows($dmstRes);
        $dmstFres=$obj->fetchrow($dmstRes);
         print "
        <div class='rowHead' style='width:1500px;'>
            <div class='divCell' style='width:80px;'>$memFres[0]</div>
            <div class='divCell' style='width:150px;'>".strtoupper($memFres[1])."</div>
            <div class='divCell' style='width:80px; text-align:right'>$dmstFres[5] </div>
            <div class='divCell' style='width:85px; text-align:right'>$dmstFres[7] </div>
			 <div class='divCell' style='width:85px; text-align:right'>$dmstFres[9] </div>

         ";
         $totTF=$totTF+$dmstFres[5];
         $totWF=$totWF+$dmstFres[7];
		 $totRD=$totRD+$dmstFres[9];
         $totPay=$totPay + $dmstFres[5] + $dmstFres[7]+$dmstFres[9];
         $mstRes=$obj->Select("loanmaster order by pos");
         while ($mstFres=$obj->fetchrow($mstRes)){
            $ldmRes=$obj->select("demandmast", "demandMonth='$m' and demandYear='$y' and memID=$memFres[0] and LoanID=$mstFres[0]");
            $ldmFres=$obj->fetchrow($ldmRes);

            $expInt=explode(".",$ldmFres[15]);
            if ($expInt[1] >=50){
              $roundInt=$expInt[0]+1;
            }else{
              $roundInt=$expInt[0];
            }
             print "
                <div class='divCell' style='width:100px; text-align:right'>".sprintf("%0.2f", round($ldmFres[13]))."<br>".sprintf("%0.2f",$roundInt)."</div>

                ";
			print "<div class='divCell' style='width:100px; text-align:right'>".sprintf("%0.2f", $ldmFres[24])."<br>$ldmFres[25]</div>";
              $totPay=$totPay+$ldmFres[13]+$roundInt;
              $loanPay=$ldmFres[13]+$roundInt;
              $lni=$mstFres[0];
              $totLoan[$lni]=$totLoan[$lni]+$ldmFres[13];
              $totInt[$lni]=$totInt[$lni]+$roundInt;

         }

          print "<div class='divCell' style='width:100px; text-align:right;'>".sprintf("%0.2f", round($totPay))."</div>";
		  
          $grossPay=$grossPay+$totPay;
          $grandPay=$grandPay+$grossPay;
          $totPay=0;
          $roundInt=0;
          
          $mstRes=$obj->Select("loanmaster order by pos");
          while ($mstFres=$obj->fetchrow($mstRes)){

             $lmRes=$obj->select("loanmem","memID=$memFres[0] and LoanID=$mstFres[0] and endFlg=1");
             $lmRows=$obj->rows($lmRes);
             if ($lmRows > 0){
               $lmFres=$obj->fetchrow($lmRes);
               $sumRepay=$obj->sumfield("loanrepaylist", "amount", "LmID=$lmFres[0]");
               
               $curDRes=$obj->select("demandmast", "memID=$memFres[0] and LoanID=$mstFres[0] and demandMonth<>'$m' and demandYear<>'$y' and prinPay=0");
               $curDFres=$obj->fetchrow($curDRes);
               
               $balAmount=$dmstFres[24];
               
               $balPeriod=$dmstFres[25];

             }else{
                $countRows=0;
                
             }
            
             $balPeriod=0;
			 $balAmount=0;

          }
        print "</div>";

     }
     print "<div class='rowFoot' style='font-weight:bold; width:1500px;'>
        <div class='divCell' style='width:80px;'>&nbsp;</div>
        <div class='divCell' style='width:150px; '>Total</div>
        <div class='divCell' style='width:80px; text-align:right; '>".sprintf("%0.2f",$totTF)."</div>
        <div class='divCell' style='width:85px; text-align:right;'>".sprintf("%0.2f",$totWF)."</div>
		 <div class='divCell' style='width:85px; text-align:right;'>".sprintf("%0.2f",$totRD)."</div>";
     $mstRes=$obj->Select("loanmaster order by pos");
     while ($mstFres=$obj->fetchrow($mstRes)){
           $lni=$mstFres[0];
          print "<div class='divCell' style='width:100px; text-align:right'>".sprintf("%0.2f",$totLoan[$lni])."<br>".sprintf("%0.2f",$totInt[$lni])."</div>";
		  print "<div class='divCell' style='width:100px; text-align:right'>&nbsp;</div>";
      
          $totLoan[$lni]=0;
          $totInt[$lni]=0;
      }
    print "  <div class='divCell' style='width:100px; text-align:right'>".sprintf("%0.2f", round($grossPay))."</div>";
    $mstRes=$obj->Select("loanmaster order by pos");
          
          
          
    print"</div>";

     
       $grossPay=0;
       $totTF=0;
       $totWF=0;
	   $totRD=0;



}



?>