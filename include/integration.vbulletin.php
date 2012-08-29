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


function vbull_add($payeremail, $username){
    
    $payer_email = $payeremail;
    $user_name = $username;
    
    include __DIR__.'/config.php';
    include __DIR__.'/config.vbulletin.php';


    $mysql_con_vbull=mysql_connect($mysql_vbull_host, $mysql_vbull_user, $mysql_vbull_password) ;
    mysql_select_db($mysql_vbull_database, $mysql_con_vbull) ;


    $sql1 = "SELECT `uid` ,`additionalgroups`, `email` FROM `".$integration_vbull_usertable."` WHERE `username` = '".$user_name."' LIMIT 1";

    $res1 = mysql_query($sql1,$mysql_con_vbull);
    
    $data = mysql_fetch_array($res1);

    $uid = $data["uid"];

    $usergroup = $data["additionalgroups"];

    $new_usergroup = $integration_vbull_donogroup . "," . $usergroup;

    if (isset($uid)){

        $sql2 = "UPDATE `".$integration_vbull_usertable."` SET `additionalgroups` = '".$new_usergroup."' WHERE `uid` = ".$uid." LIMIT 1";

        $res2 = mysql_query($sql2, $mysql_con_mybb);

        $mysql_con_donation = mysql_connect($mysql_don_host, $mysql_don_user, $mysql_don_password) ;
        mysql_select_db($mysql_don_database, $mysql_con_donation) ;                        

        $sql3 = "UPDATE `users` SET `old_vbullgrp`=".$usergroup." WHERE `email` = '".$payer_email."'";

        mysql_query($sql3, $mysql_con_donation);
        
        mail($inform_email, 'vbull done', "User found and updated");

    }else{
        mail($inform_email, 'vbull done', "No User aviable");
    }
    
    


}

function vbull_remove($username, $old_vbullgroup){
    
    $old_vbullgrp = $old_vbullgrp;
    $user_name = $username;
    
    require_once __DIR__.'/config.php';
    require_once __DIR__.'/config.vbull.php';

    $mysql_con_vbull=mysql_connect($mysql_vbull_host, $mysql_vbull_user, $mysql_vbull_password) ;
    mysql_select_db($mysql_vbull_database, $mysql_con_vbull) ;

//    echo $old_vbullgrp;

    $sql2 = "UPDATE `".$integration_vbull_usertable."` SET `additionalgroups` = '".$old_vbullgrp."' WHERE `username` = '".$user_name."' LIMIT 1 ";

//    echo "vbull sql2: ". $sql2 ."<br/>";

    mysql_query($sql2, $mysql_con_vbull);


}
?>
