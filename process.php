<?php

include __DIR__ .'/include/paypal.class.php'; // include the PayPalclass file

$this_script = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

$p = new paypal_class;      // initiate an instance of the class

if (empty($_GET['action'])) $_GET['action'] = 'donate';  

switch ($_GET['action']) {
    
   case 'donate':      // Process and order...

       include __DIR__ . '/include/config.php';
       
      
       if ( $_POST["provider"] === "paypal"){
           
          $steam_id = $_POST["steam_id"]; 
          $username = $_POST["username"];
          $password = "No-Need-for-a-PW-atm";

          $userdata = $steam_id .",".$username.",".$password;

          $p->paypal_url = $pp_url;   // paypal url
          $p->add_field('custom', $userdata);
          $p->add_field('no_shipping', '1');
          $p->add_field('business', $pp_email);
          $p->add_field('return', $this_script.'?action=success');
          $p->add_field('cancel_return', $this_script.'?action=cancel');
          $p->add_field('notify_url', $this_script.'?action=ipn_pp');
          $p->add_field('item_name', "Reminder: Your donation is reset after ". $donation_reset_time . " Days");
          $p->add_field('amount', $pp_ammount );
          $p->add_field('currency_code', $pp_currency);
          $p->add_field('rm','2');           // Return method = POST
          $p->add_field('cmd','_donations'); 

          $p->submit_paypal_post(); // submit the fields to paypal
          //$p->dump_fields();      // for debugging, output a table of all the fields
           
       }elseif($_POST["provider"] === "paygol"){
          
          $steam_id = $_POST["steam_id"]; 
          $username = $_POST["username"];
          $password = "No-Need-for-a-PW-atm";
          $email = $_POST["email"];

          $userdata = $steam_id .",".$username.",".$password.",".$email;     
          
          $p->paypal_url = $pg_url;
          $p->add_field('pg_serviceid', $pg_serviceid);
          $p->add_field('pg_currency' , $pg_currency);
          $p->add_field('pg_name', $pg_name);
          $p->add_field('pg_custom' , $userdata);
          $p->add_field('pg_price', $pg_price);
          $p->add_field('pg_cancel_url' , $this_script.'?action=cancel' );
          $p->add_field('pg_return_url' , $this_script.'?action=success' );
          $p->add_field('pg_notify_url' , $this_script.'?action=ipn_pg');
          $p->submit_paypal_post();
           
           
       }
       
       

      break;
      
   case 'success':      // Order was successful...
   
       require (__DIR__."/include/config.php");

       
       
       // Defining Variables
       $donation_money_recieved = $_POST["mc_gross"]; // The Money you have recieved
       $donation_donator = $_POST["payer_email"]; // The E-Mail of the Donator
       $donation_status = $_POST["payment_status"]; // The status of the Payment
       $userdata = explode (",",$_POST["custom"]);
       $steam_id = $userdata[0];
       $username = $userdata[1];
       $password = $userdata[2];
       
       
       echo "<html><head><title>Success</title></head><body><h3>Thank you for your order.</h3>";
       //foreach ($_POST as $key => $value) { echo "$key: $value<br>"; }
       //echo '</hr>';
       //echo 'Money Recieved: '. $_POST["mc_gross"]. "</br>";
       //$userdata = $_POST["custom"];
       //$username = $userdata[1];
       //$steam_id = $userdata[0];
       //echo $username;
       //echo $steam_id;
       
       echo "</body></html>";
       
       header ("Location: " . $payment_success_url); 
       
      break;
      
   case 'cancel':       // Order was canceled...
       
      require (__DIR__."/include/config.php");

      // The order was canceled before being completed.
 
      echo "<html><head><title>Canceled</title></head><body><h3>The order was canceled.</h3>";
      echo "</body></html>";
      header ("Location: " . $payment_cancel_url); 
      
      break;
   
    case 'ipn_pg':
      
        require_once __DIR__.'/include/config.php';
        include __DIR__ .'/include/functions.php'; // include the functions

        ini_set('log_errors', true);
        ini_set('error_log' , dirname(__File__). 'ipn_errors.log');

        // check that the request comes from PayGol server
        if(!in_array($_SERVER['REMOTE_ADDR'],
          array('109.70.3.48', '109.70.3.146', '109.70.3.58'))) {
          header("HTTP/1.0 403 Forbidden");
          die("Error: Unknown IP");
        }
        
        mail($inform_email, 'Valid PayGol IPN recieved' , 'You have recieved a Valid Paygol IPN');
        
        //Fraund Check
        $error = ""; //Initialize var for error msg
        
        // get the variables from PayGol system
        $message_id	= $_GET['message_id'];
        $service_id	= $_GET['service_id'];
        $shortcode	= $_GET['shortcode'];
        $keyword	= $_GET['keyword'];
        $message	= $_GET['message'];
        $sender	= $_GET['sender'];
        $operator	= $_GET['operator'];
        $country	= $_GET['country'];
        $points	= $_GET['points'];
        $price	= $_GET['price'];
        $currency	= $_GET['currency'];
        $userdata = explode (",",$_GET["custom"]);
        
        
//        if($service_id != $pg_serviceid){
//            $error .= 'Invalid Service ID \n';
//        }
        
//        if($price != $pg_price){
//            $error .= 'Invalid Price \n';
//        }
//        
//        if($currency != $pg_currency){
//            $error .= 'Invalid Currency \n';
//        }
        
        $mysql_con_donation = mysql_connect($mysql_don_host, $mysql_don_user, $mysql_don_password) ;
        mysql_select_db($mysql_don_database, $mysql_con_donation) ;

        $txn_id = mysql_real_escape_string($_POST['txn_id']);
        $sql = "SELECT COUNT(*) FROM orders WHERE txn_id = '$message_id'";
        $r = mysql_query($sql, $mysql_con_donation);
        
        $exists = mysql_result($r, 0);
        mysql_free_result($r);

        if (!$r) {
            error_log(mysql_error());
            mail($inform_email, 'MySQL_Error', "MySQL_Error");
            exit(0);
        }
        
        if ($exists) {
            $error .= "'txn_id' has already been processed: ".$_POST['txn_id']."\n";
            //mail($inform_email, 'Payment already Processed', "Payment already Processed");
        }        

            
        // Fraud checks passed
        
        
        if($error === ""){
            
            //mail($inform_email, 'Fraud Check Passed', "Fraund check passed");

            // Postprocess Donation


            // add this order to a table of completed orders

            $txn_id = mysql_real_escape_string($message_id); //Transaktion id
            $payer_email = mysql_real_escape_string($userdata[3]); //E-Mail
            $mc_gross = mysql_real_escape_string($price);
            $steam_id = mysql_real_escape_string($userdata[0]);
            $username = mysql_real_escape_string($userdata[1]);
            $password = mysql_real_escape_string($userdata[2]);
            $timestamp = time();
            $date = date("Y-m-d",$timestamp);
            $provider = "paygol";


            $payment_data = array("txn_id" => $txn_id , "payer_email" => $payer_email , "mc_gross" => $mc_gross ,"steam_id" => $steam_id, "username" => $username , "password" => $password , "date" => $date , "provider" => $provider  );

            global $payment_data;



            donation_postprocess($payment_data);            
            
            
            
            
            
        }else{
            mail($inform_email, 'PayGol Fraud Warning' , $error);
            
        }
        
        
        
        
        
        
        break;
  
    case 'ipn_pp':          // Paypal is calling page for IPN validation...
       
   
        require_once __DIR__.'/include/config.php';
        include __DIR__ .'/include/functions.php'; // include the functions
        
        mail($inform_email, 'Paypal IPN recieved', "Recieved a paypal IPN");
        // tell PHP to log errors to ipn_errors.log in this directory
        ini_set('log_errors', true);
        ini_set('error_log', dirname(__FILE__).'/ipn_errors.log');

        // intantiate the IPN listener
        require_once('./include/ipnlistener.php');
        $listener = new IpnListener();

        // tell the IPN listener to use the PayPal test sandbox
        $listener->use_sandbox = true;

        // try to process the IPN POST
        try {
        $listener->requirePostMethod();
        $verified = $listener->processIpn();
        } catch (Exception $e) {
        error_log($e->getMessage());
        exit(0);
        }

        
        // Send Status Mail
        
//        if ($verified) {
//        // TODO: Implement additional fraud checks and MySQL storage
//        mail($inform_email, 'Valid IPN', $listener->getTextReport());
//        } else {
//        // manually investigate the invalid IPN
//        mail($inform_email , 'Invalid IPN', $listener->getTextReport());
//        }

        
        // Check if Payment is Valid (Ammount, Reciever, Status, Currency)
        
        if ($verified) {
            
            // mail($inform_email, 'Verify check passed', "Verify check passed");

            $errmsg = '';   // stores errors from fraud checks

            // 1. Make sure the payment status is "Completed" 
            if ($_POST['payment_status'] != 'Completed') { 
                // simply ignore any IPN that is not completed
                mail($inform_email, 'Valid IPN', "Payment not complete");
                exit(0);
            }

            // 2. Make sure seller email matches your primary account email.
            if ($_POST['receiver_email'] != $pp_email) {
                $errmsg .= "'receiver_email' does not match: ";
                $errmsg .= $_POST['receiver_email']."\n";
            }
            
            // 3. Make sure the amount(s) paid match
            if ($_POST['mc_gross'] != $pp_ammount) {
                $errmsg .= "'mc_gross' does not match: ";
                $errmsg .= $_POST['mc_gross']."\n";
            }
            
            // 4. Make sure the currency code matches
            if ($_POST['mc_currency'] != $pp_currency) {
                $errmsg .= "'mc_currency' does not match: ";
                $errmsg .= $_POST['mc_currency']."\n";
            }

            // 5. Ensure the transaction is not a duplicate.
            $mysql_con_donation = mysql_connect($mysql_don_host, $mysql_don_user, $mysql_don_password) ;
            mysql_select_db($mysql_don_database, $mysql_con_donation) ;

            $txn_id = mysql_real_escape_string($_POST['txn_id']);
            $sql = "SELECT COUNT(*) FROM orders WHERE txn_id = '$txn_id'";
            $r = mysql_query($sql, $mysql_con_donation);

            if (!$r) {
                error_log(mysql_error());
                mail($inform_email, 'MySQL_Error', "MySQL_Error");
                exit(0);
               
            }
            
            
            $exists = mysql_result($r, 0);
            mysql_free_result($r);

            if ($exists) {
                $errmsg .= "'txn_id' has already been processed: ".$_POST['txn_id']."\n";
                //mail($inform_email, 'Payment already Processed', "Payment already Processed");
            }

            if (!empty($errmsg)) {

                // manually investigate errors from the fraud checking
                $body = "IPN failed fraud checks: \n$errmsg\n\n";
                $body .= $listener->getTextReport();
                mail($inform_email, 'IPN Fraud Warning', $body);

            }else {
                
                //mail($inform_email, 'Fraud Check Passed', "Fraund check passed");
                
                // Postprocess Donation
                
                
                // add this order to a table of completed orders
                
                $txn_id = mysql_real_escape_string($_POST["txn_id"]);
                $payer_email = mysql_real_escape_string($_POST['payer_email']);
                $mc_gross = mysql_real_escape_string($_POST['mc_gross']);
                $custom = explode(",", $_POST["custom"]);
                $steam_id = mysql_real_escape_string($custom[0]);
                $username = mysql_real_escape_string($custom[1]);
                $password = mysql_real_escape_string($custom[2]);
                $timestamp = time();
                $date = date("Y-m-d",$timestamp);
                $provider = "paypal";
                
                
                $payment_data = array("txn_id" => $txn_id , "payer_email" => $payer_email , "mc_gross" => $mc_gross ,"steam_id" => $steam_id, "username" => $username , "password" => $password , "date" => $date , "provider" => $provider  );
                
                global $payment_data;
                
                
                
                donation_postprocess($payment_data);
                
                
                
                


            }

        } else {
            // manually investigate the invalid IPN
            mail($inform_email, 'Invalid IPN', $listener->getTextReport());
        }


        break;
      
      
    case 'cron': //Auto Removal of old donos
        
        
        include __DIR__ . "/include/config.php";
        
        $date_today = time();
        
        $mysql_con_donation = mysql_connect($mysql_don_host, $mysql_don_user, $mysql_don_password) ;
        mysql_select_db($mysql_don_database, $mysql_con_donation) ;          
        
        
        
        
        
        // Query the Order DB
        $sql1 = "SELECT * FROM `users` WHERE 1";
        
        echo "sql1: ". $sql1 ."<br/>";
        
        $res1 = mysql_query($sql1, $mysql_con_donation);
        
        while($data = mysql_fetch_assoc($res1)){
            
            $date_donation = strtotime($data["last_donation"]);
                   
            
            
            $diff = $date_today - $date_donation;
            $diff = $diff / 86400;
            
            echo "diff: ". $diff ."<br/>";
            
            $username = $data["nickname"];
            $email = $data["email"];
            $steam_id = $data["steam_id"];
            $old_mybbgrp = $data["old_mybbgrp"];
            $old_smfgrp = $data["old_smfgrp"];
            $old_vbullgrp = $data["old_vbullgrp"];
            echo "user: ". $username ."<br/>";
            echo "email: ". $email ."<br/>";
            echo "steam_id: ". $steam_id ."<br/>";
            echo "donation_res_time: ". $donation_reset_time . "<br/>";
            
            
            // Check if the Donation is too old
            if ($donation_reset_time <= $diff){
                
                echo "old_mybbgrp: ". $old_mybbgrp ."<br/>";
                
                echo "old_smfgrp: ". $old_smfgrp ."<br/>";
                
                echo "old_vbullgrp: ". $old_vbullgrp ."<br/>";
                
                
                
                /** BDI Integration **/

                if(file_exists(__DIR__ . "/include/integration.bdi.php")){
                    
                    echo "doing bdi <br/>";

                    include (__DIR__ . "/include/integration.bdi.php");

                    bdi_remove($steam_id);


                }

                
                /** MyBB Integraion **/
                
                if (file_exists(__DIR__ . "/include/integration.mybb.php")){
                    
                    echo "doing mybb <br/>";

                    include (__DIR__ . "/include/integration.mybb.php");

                    mybb_remove( $username, $old_mybbgrp);
                    
                }
                
                
                
                
                if (file_exists(__DIR__ . "/include/integration.smf.php")){
                    
                    echo "doing smf <br/>";

                    include (__DIR__ . "/include/integration.smf.php");

                    smf_remove($username, $old_smfgrp);
                    
                }
                
                
                
                if (file_exists(__DIR__ . "/include/integration.sb.php")){
                    
                    echo "doing sb <br/>";

                    include (__DIR__ . "/include/integration.sb.php");

                   sb_remove($steam_id);
                    
                }                
                   

                
            }
        }
        break;
                
        
  }     

?>
