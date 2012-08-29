<?php

/*
 *  The Donator Interface - A donator interface and management system for Source game servers and various Forum Systems.
 *  Copyright (C) 2012 Werner "Arrow768" Maisl
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU Affero General Public License as
 *  published by the Free Software Foundation, either version 3 of the
 *  License, or (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Affero General Public License for more details.
 *
 *  You should have received a copy of the GNU Affero General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * 
 */

function donation_postprocess($Payment_Data)
{    
    include (__DIR__ . '/config.php');
    
    //mail($inform_email, 'Fraund check passed', " Fraud check passed - Function started");
    
    
    $txn_id = $Payment_Data["txn_id"];
    $payer_email = $Payment_Data["payer_email"];
    $mc_gross = $Payment_Data["mc_gross"];
    $steam_id = $Payment_Data["steam_id"];
    $username = $Payment_Data["username"];
    $password = $Payment_Data["password"];
    $date = $Payment_Data["date"];
    $provider = $Payment_Data["provider"];
    
//    echo "txn_id: " . $txn_id . "<br/>";
//    echo "payer_email: " . $payer_email . "<br/>";
//    echo "mc_gross: " . $mc_gross . "<br/>";
//    echo "steam_id: " . $steam_id . "<br/>";
//    echo "username: " . $username . "<br/>";
//    echo "password: " . $password . "<br/>";
//    echo "date: " . $date . "<br/>";
//    echo "provider: ". $provider ."<br/>";
//    echo "enable_sb_integraion: " . $integration_sb_enable . "<br/>";
//    echo "mysql_don_database = " .$mysql_don_database . "<br/>";

    $mysql_con_donation = mysql_connect($mysql_don_host, $mysql_don_user, $mysql_don_password) ;
    mysql_select_db($mysql_don_database , $mysql_con_donation);
    
    $sql = "INSERT INTO orders VALUES (NULL, '$txn_id', '$payer_email', '$mc_gross', '$steam_id', '$username', '$password', '$date', '$provider', 0, 0)";
    
    
    if (!mysql_query($sql, $mysql_con_donation)) {
        error_log(mysql_error());
        exit(0);
    }

    // send user an email with a link to their digital download
    $to = filter_var($_POST['payer_email'], FILTER_SANITIZE_EMAIL);
    $subject = $your_community_name ." has recieved your Donation";


    $template_payment_recieved .= 
"
    
This System is Written by Arrow768
Feel free to Conatct him at arrow768@hfc.pf-control.de , if you have any questions about this System
Please do not ask him questions about your Donation, he does not have access to the Donation-Data
If you think there has been a fraud, open a support ticket at http://hfc.pf-control.de/support
";


    //mail($to, $subject, $template_payment_recieved);   

    
    

    // Add the Userdata to the User table

    $mysql_con_donation = mysql_connect($mysql_don_host, $mysql_don_user, $mysql_don_password) ;
    mysql_select_db($mysql_don_database, $mysql_con_donation);

    $sql1 = "SELECT * FROM `users` WHERE `nickname` = '".$username."'";

    //echo $sql1 . "<br/>";

    $res1 = mysql_query($sql1, $mysql_con_donation);

    $data1 = mysql_fetch_assoc($res1);

    $uid = $data1["user_id"];

    $num1 = mysql_num_rows($res1);

    //echo "num1 : ". $num1 . "</br>";

    //echo "uid : ". $uid . "</br>";

    if ($num1 === 1 ){ 

        //echo "User already added <br/>";

        $sql2 = "UPDATE `users` SET `last_donation`='".$date."' WHERE `user_id` = ".$uid." LIMIT 1";

        mysql_query($sql2 , $mysql_con_donation);

        //echo $sql2 . "<br/>";

    }elseif($num1 === 0){

        //echo "User not alreday added <br/>";

        $sql3 = "INSERT INTO `users`(`user_id`, `nickname`, `email`, `last_donation` , `steam_id`) VALUES (NULL, '".$username."','".$payer_email."','".$date."','".$steam_id."')";

        mysql_query($sql3 , $mysql_con_donation);

        //echo $sql3 . "<br/>";

    }                
    
    
    /** BDI Integration **/
    
    if(file_exists(__DIR__ . "/integration.bdi.php")){
            
            include (__DIR__ . "/integration.bdi.php");

            bdi_add($steam_id);          
         
    }
    
    
    
    /* Mybb Integration */
    if (file_exists(__DIR__ . "/integration.mybb.php")){
            
        
            include (__DIR__ . "/integration.mybb.php");
        
            mybb_add($payer_email, $username);
        
    }
    
    

    /* SMF Integration */
    if (file_exists(__DIR__ . "/integration.smf.php")){
        

            
            include (__DIR__ . "/integration.smf.php");

            smf_add($payer_email, $username);                
        

    }

    

    /* SBIntegration */
    if (file_exists(__DIR__ . "/integration.sb.php")){
        
            
            include (__DIR__ . "/integration.sb.php");

            sb_add($steam_id , $username , $payer_email);                 
        

    }




}
?>
