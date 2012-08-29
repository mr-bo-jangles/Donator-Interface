<?php

$timestamp = time();
$date = date("Y-m-d",$timestamp);



$custom = "STEAM_0:1:37448035,Achmet,dswf17983abs";
echo $custom . "<br/>";
$data = explode("," , $custom);
$steam_id = $data[0];
$user_name = $data[1];
$password = $data[2];
$payer_email= "buyer1_1345798097_pre@sbg.at";

//echo "Steam ".$steam_id . "<br/>";
//echo "Usern ".$username . "<br/>";
//echo "pass ".$password . "<br/>";

include (__DIR__ . '/config.php');

    /* SBIntegration */
    if (file_exists(__DIR__ . "/integration.sb.php")){
        
         include (__DIR__ . "/integration.sb.php");
        
         sb_add($steam_id , $username , $payer_email);
    }









                
                


?>
