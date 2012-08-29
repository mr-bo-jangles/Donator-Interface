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

$mysql_vbull_user = "";
/* The MySQL-Username used for the Database
 * If you dont have one, create one
 */

$mysql_vbull_password = "";
/* The Password for the MySQL_Database
 * You should use a Password
 */

$mysql_vbull_host = "localhost";
/* The Host of the Database
 * Usualy localhost
 */

$mysql_vbull_database = "";
/* The name of the Database
 * Give it a name you like, but dont forget to create it and instert the data
 */


$integration_vbull_enable = 1;
/* To Enable MyBB Integration fill out the connection data for the MyBB Database
 * and Enable this Option
 */

$integration_vbull_usertable = "users";
/* This is the User-table of MyBB
 * If you have NOT changed your Prefix, it is OK to enter the default one
 * The Default is: mybb_users
 */

$integration_vbull_donogroup = 8;
/* The !! Group_ID !! of the Donator Group
 * Beware:
 * There is no Idiot Protection !!
 * If you enter the name, you could f**k up your whole Database
 * 
 * If you dont Change this Setting and enable the Integration,
 * every donator will be assigned to the banned group
 */
?>
