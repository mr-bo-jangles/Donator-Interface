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

require_once (__DIR__."/include/calc_overview.php");
    
    
    echo "Ammount donated this month: " .$monthly_ammount . " ". $pp_currency ."<br/>";
    echo "Needed Ammount per Month: ". $needed_per_month . " ". $pp_currency . "<br/>";
    echo "Percent donated: " .$percent * 100  . " %<br/>";
    echo "Total Ammount Donated: " .$total_ammount . " ". $pp_currency ."<br/>";
    
    
?>
