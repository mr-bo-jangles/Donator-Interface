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

function smf_add($payeremail, $username){
    
    $payer_email = $payeremail;
    $user_name = $username;
    
    include __DIR__.'/config.php';
    include __DIR__.'/config.smf.php';
    
    
    $mysql_con_smf = mysql_connect($mysql_smf_host, $mysql_smf_user, $mysql_smf_password) ;
    mysql_select_db($mysql_smf_database, $mysql_con_smf) ;


    $sql1 = "SELECT `id_member` ,`additional_groups`, `email_address` FROM `".$integration_smf_usertable."` WHERE `member_name` = '".$user_name."' LIMIT 1";
    
    $res1 = mysql_query($sql1,$mysql_con_smf);

    $data = mysql_fetch_array($res1);

    $uid = $data["id_member"];
    
    $usergroup = $data["additional_groups"];
    
    $new_usergroup = $integration_smf_donogroup . "," . $usergroup;
    
    if (isset($uid)){

        $sql2 = "UPDATE `$integration_smf_usertable` SET `additional_groups` = '".$new_usergroup."' WHERE `id_member` = '".$uid."' LIMIT 1 ";
        
        $res2 = mysql_query($sql2, $mysql_con_smf);
        
        $mysql_con_donation = mysql_connect($mysql_don_host, $mysql_don_user, $mysql_don_password) ;
        mysql_select_db($mysql_don_database, $mysql_con_donation) ;                        
        
        $sql3 = "UPDATE `users` SET `old_smfgrp`=".$usergroup." WHERE `email` = '".$payer_email."'";
        
        mysql_query($sql3, $mysql_con_donation);
        
        mail($inform_email, 'MyBB done', "User found and updated");

    }else{
        mail($inform_email, 'MyBB done', "No User aviable");
    }
    
    
    
}

function smf_remove($username , $old_smfgroup){
    
    $old_smfgrp = $old_smfgroup;
    $user_name = $username;
    
    include __DIR__.'/config.php';
    include __DIR__.'/config.smf.php';
    
    $mysql_con_smf=mysql_connect($mysql_smf_host, $mysql_smf_user, $mysql_smf_password) ;
    mysql_select_db($mysql_smf_database, $mysql_con_smf) ;

    $sql2 = "UPDATE `".$integration_smf_usertable."` SET `additional_groups` = '".$old_smfgrp."' WHERE `member_name` = '".$user_name."' LIMIT 1 ";

    echo "smf sql2: ". $sql2 ."<br/>";

    mysql_query($sql2, $mysql_con_smf);
    
    
}


?>
