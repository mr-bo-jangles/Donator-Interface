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

function sb_add($steamid , $username , $email){
    
    $steam_id = $steamid;
    $user_name = $username;
    $payer_email = $email;
    $password = "No-Login-for-Donos";
    
    
    
    include __DIR__.'/config.php';
    include __DIR__.'/config.sb.php';
    
    $mysql_con_sb=mysql_connect($mysql_sb_host, $mysql_sb_user, $mysql_sb_password) ;
    mysql_select_db($mysql_sb_database, $mysql_con_sb) ;

    $sql1 = "SELECT * FROM `".$integration_sb_admintable."` WHERE `authid` = '".$steam_id."' LIMIT 1"; //check for Duplicate
    
    $res1 = mysql_query($sql1, $mysql_con_sb);

    $num1 = mysql_num_rows($res1);

    // mail($inform_email, 'Valid IPN', "SB step 1 done");

    if(isset($num1)){

        //add the User to the adm table

        $sql2 = "INSERT INTO `sb_admins`(`user`, `authid`, `password`, `gid`, `email`, `srv_group`, `extraflags`, `immunity` ) VALUES ('".$user_name."','".$steam_id."','".$password."',".$integration_sb_webadmgroup_id.",'".$payer_email."','".$integration_sb_srvadmgroup_name."',0 ,0 )";
        mysql_query($sql2);
        
        
        //get the UserID of the added User
        $sql3 = "SELECT * FROM `".$integration_sb_admintable."` WHERE `authid` = '".$steam_id."' LIMIT 1";
        $res3 = mysql_query ($sql3 , $mysql_con_sb);
        $data3=  mysql_fetch_assoc($res3);
        $aid = $data3["aid"];



        //add the user to the adm_srv_grp table

        $sql4 = "INSERT INTO `".$integration_sb_admintable_sg."`(`admin_id`, `group_id`, `srv_group_id`, `server_id`) VALUES ( ".$aid.",".$integration_sb_webadmgroup_id.",".$integration_sb_srvgroup_id.",-1)";
        mysql_query($sql4);

        $log .= "sb_query_4: " . $sql4 . "\n";
        


        mail($inform_email, 'SB done', "User added");


    }else{ mail($inform_email, 'SB done', "User already exist"); } 
    
}


function sb_remove($steamid){
    
    $steam_id = $steamid;
    
    include __DIR__.'/config.php';
    include __DIR__.'/config.sb.php';    
    
    
    $mysql_con_sb = mysql_connect($mysql_sb_host , $mysql_sb_user , $mysql_sb_password);
    mysql_select_db($mysql_sb_database, $mysql_con_sb);

    $sql2 = "SELECT * FROM `sb_admins` WHERE `authid` = '".$steam_id."'";
    $res2= mysql_query($sql2, $mysql_con_sb);
    $data2= mysql_fetch_assoc($res2);
    $aid = $data2["aid"];
    echo "aid:" . $aid . "<br/>";

    $sql3 = "DELETE FROM `sb_admins` WHERE `aid` = '".$aid."'";

    $sql4 = "DELETE FROM `sb_admins_servers_groups` WHERE `admin_id` = '".$aid."'";

    mysql_query($sql3, $mysql_con_sb);
    mysql_query($sql4, $mysql_con_sb);

    echo "sb sql2: ". $sql2 ."<br/>";
    echo "sb sql3: ". $sql3 ."<br/>";
    echo "sb sql4: ". $sql4 ."<br/>";
    
    
    
    
    
}
?>
