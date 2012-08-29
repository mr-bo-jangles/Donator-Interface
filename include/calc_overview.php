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
include (__DIR__ . "/config.php");

if($use_overview != 1){
    echo "Not Licensed";
    exit();


}

$mysql_con_donation = mysql_connect($mysql_don_host, $mysql_don_user, $mysql_don_password) ;
mysql_select_db($mysql_don_database, $mysql_con_donation) ;

$sql1="SELECT `mc_gross`, `date` FROM `orders` WHERE 1";

$res1 = mysql_query($sql1);

$year_month_today = date('Y-m');

$total_ammount = 0;
$monthly_ammount = 0;

while($data = mysql_fetch_assoc($res1)){

    $date_data = explode("-", $data["date"]);

    $year_month_donation = $date_data[0] . "-" . $date_data[1];

    if($year_month_donation === $year_month_today){

        $monthly_ammount += $data["mc_gross"];
    }

    $total_ammount += $data["mc_gross"];  

}

$percent = $monthly_ammount / $needed_per_month;

if($percnet >= 1){
    $percent = 1; //
}
?>
