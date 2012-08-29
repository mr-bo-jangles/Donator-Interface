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

function bdi_add ($steamid){
    
    $steam_id = $steamid;
    
    include __DIR__.'/config.php';
    include __DIR__.'/config.bdi.php';
    

    $mysql_con_bdi = mysql_connect($mysql_bdi_host, $mysql_bdi_user, $mysql_bdi_password) ;
    mysql_select_db($mysql_bdi_database, $mysql_con_bdi);
    
    $sql1= "INSERT INTO `donators`(`steamid`, `level`) VALUES ('".$steam_id."', ".$integration_bdi_level.")";
    // echo "bdi sql1:" .$sql1. "<br/>";
    
    mysql_query($sql1, $mysql_con_bdi);

    mail($inform_email, 'BDI done', "BDI done");
        
}


function bdi_remove ($steam_id){
    
    include __DIR__.'/config.php';
    include __DIR__.'/config.bdi.php';    
    
    $mysql_con_bdi = mysql_connect($mysql_bdi_host, $mysql_bdi_user, $mysql_bdi_password) ;
    mysql_select_db($mysql_bdi_database, $mysql_con_bdi);

    $sql1 = "DELETE FROM `donators` WHERE `steamid` = '".$steam_id."' ";

    mysql_query($sql1, $mysql_con_bdi);
    
}
?>
