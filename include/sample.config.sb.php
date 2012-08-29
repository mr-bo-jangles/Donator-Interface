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

$mysql_sb_user = "";
/* The MySQL-Username used for the Database
 * If you dont have one, create one
 */

$mysql_sb_password = "";
/* The Password for the MySQL_Database
 * You should use a Password
 */

$mysql_sb_host = "localhost";
/* The Host of the Database
 * Usualy localhost
 */

$mysql_sb_database = "";
/* The name of the Database
 * Give it a name you like, but dont forget to create it and instert the data
 */


/* Sourcebans */
$integration_sb_enable = 0;
/* To Enable Sourcebans Integration fill out the connection data for the MyBB Database
 * and Enable this Option
 */

$integration_sb_admintable = "sb_admins";
/* This is the Admin-Table of Sourcebans
 * If you have NOT changed your Prefix, it is OK to enter the default one
 * The Default is: sb_admins
 */

$integration_sb_admintable_sg = "sb_admins_servers_groups";
/* This is the Admin-Server-Group-Table of Sourcebans
 * If you have NOT changed your Prefix, it is OK to enter the default one
 * The Default is: sb_admins_servers_groups
 */

$integration_sb_srvadmgroup_name = "Donator_srvadm";
/* The name of the Server-Admin Gorup
 * where donators should be added to
 */

$integration_sb_webadmgroup_id = "1";
/* This is the Group ID of the Webadmin Group
 * where you have entered the rights for the donators at the SB Website
 */

$integration_sb_srvgroup_id = "2";
/* This is the Group ID of the SERVER-Group
 * Where you have set up the server-access for the donators
 */


$integration_sb_ignore_string = "";
/* This group tells the System to update People to Donator-Status if they have alreday been added to the System
 * First the teble is searched for the Steam_id entered at the donation Page.
 * 
 * If the steam_id is found, the upgrade process is abortet.
 * But if the steam_id has the entered groups assigned the upgrade process is continued.
 * When the donation time is over, the Users
 */
?>
