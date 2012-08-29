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

$mysql_bdi_user = "";
/* The MySQL-Username used for the Database
 * If you dont have one, create one
 */

$mysql_bdi_password = "";
/* The Password for the MySQL_Database
 * You should use a Password
 */

$mysql_bdi_host = "localhost";
/* The Host of the Database
 * Usualy localhost
 */

$mysql_bdi_database = "";
/* The name of the Database
 * Give it a name you like, but dont forget to create it and instert the data
 */

$integration_bdi_enable = 1;
/* Enables the BDI Integraion
 * There is no Connection Data for the BDI
 */

$integration_bdi_level = 1;
/*Sets the Default Level for the BDI
 * Only use 1 Digit (the database cant hanle more)
*/

?>
