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
 *
 *  A few last words:
 *  This software is free and will remain free forever.
 *  There are no charges at the Donations (only the PayPal-Fee)
 *  I will try to support you as good as I can.
 *  If you like my Software, it would help me alot if you donate per PayPal (donation@hfc.pf-control.de)
 *  Do not send Support-Requests to my PayPal-Mail-Adress
 *  There is a Support-System aviable
 *  http://hfc.pf-control/support
 * 
 */




/** Payment-Provider-Config **/


/*PayPal - Internet Payment Provider*/

$pp_enable = 1;
/* Enable Paypal Payment
 * Fill out the information for paypal and set pp_enable to 1
 */

$pp_url = 'https://www.paypal.com/cgi-bin/webscr';
/* The PayPal-URL
 * The URL above ist the URL for the PP Testing environment
 * Enter this URL, if you want to recieve donations:
 * https://www.paypal.com/cgi-bin/webscr
 */

$pp_email = 'donation@hfc.pf-control.de'; //Your Paypal-Email
/* Your PayPal-Email
 * Enter the PayPal-Email, where you want to recieve the donations * 
 */

$pp_currency = 'EUR'; 
/* The Currency, you would like to recieve.
 * See https://cms.paypal.com/cms_content/US/en_US/files/developer/PP_WebsitePaymentsStandard_IntegrationGuide.pdf Appendix D
 * for Valid Codes
 * Examples: EUR USD
 */

$pp_ammount = '10'; 
/* The Ammount you would like to Recieve
 * This is the Ammount you would like to recieve in the above selected Currency
 */

$pp_name = 'Your Service Name';
/* This variable is Used to tell PG the name of your pg service
 * Example:
 * XYZ Community Donation System
 */



/*payGol - SMS Payment Provider*/
$pg_url = "http://www.paygol.com/micropayment/paynow_post";

$pg_serviceid = "36984";
/* The ID of you PayGol Service
 */

$pg_currency = "EUR";
/* The Currency, you would like to recieve.
 */

$pg_name = "Donation-System-Test";
/* The Name That shoud be shown
 */

$pg_price = "10";
/* The Ammount you would like to recieve
 */




/** Mail Config **/

$mail_smtp_host = ''; // NA
/* Your SMTP-Server
 * Example:
 * mail.provider.com
 */

$mail_smtp_port = ''; // NA
/* The Port of your SMTP-Server
 * Standard-Port: 25
 */

$mail_smtp_user = ''; // NA
/* The User used to Auth with the SMPT-Server
 * Example:
 * donation@provider.com
 */

$mail_smtp_password = ''; // NA
/* The SMTP-Password used to Auth with the SMTP-Server
 * 
 */

$mail_from_address = 'donation@hfc-pf-control.de';
/* The FROM address in the Mail
 * Example:
 * donation@provider.com
 */

$mail_from_name = 'Test Donation System';
/* The name of the Person/System who sent the mail
 * Example:
 * XYZ-Community Donation System 
 */

$inform_email = 'donation@hfc.pf-control.de';
/* The E-Mail where the Payment Message should be sent to
 * Example:
 * paymentnot@provider.com
 */






/** MySQL Config **/


$mysql_don_user = "";
/* The MySQL-Username used for the Database
 * If you dont have one, create one
 */

$mysql_don_password = "";
/* The Password for the MySQL_Database
 * You should use a Password
 */

$mysql_don_host = "localhost";
/* The Host of the Database
 * Usualy localhost
 */

$mysql_don_database = "";
/* The name of the Database
 * Give it a name you like, but dont forget to create it and instert the data
 */



/** Site Config **/

$your_community_name = "XYZ-Community";
/* The name of your Community,
 * it is used in the Answer-Mail, when you have recieved the payment
 */

$template_payment_recieved =    
"Thank you for your donation.
Our System has Processed your Payment.
You are now a official Donator at our Servers";
/* The Mail-Template, that is sent to the Donators
 * Edit it how you like, but remember this is a BETA Feature
 * It my not work how you expect !
 */

$donation_reset_time = 30;
/* With this setting you can control the time,
 * when the donators are reset to their default values
 * 
 * Do not set it to short or you might not get any donations
 * This setting is shown at paypal, to prefent fraud from the admins of this script
 */

$payment_success_url = "http://vpfastdl.pf-control.de/projects/testing/smf";
/* This is the Payment Success URL
 * Your Users will be redirected here if they have payed at your Payment Provider
 * If they have payed, it does not mean, that you have recieved the money, so dont put any Dono-Only Functions at this URL
 * I recommend putting a Description Site at this URL, where you describe what abilitys they have and when the donation exceeds
 */

$payment_cancel_url = "http://vpfastdl.pf-control.de/projects/testing/smf";
/* This is the Payment Cancel URL
 * You Users will be ridirceted to that URL, if they have NOT payed / or they have canceled the payment
 * I recommend putting a Page there, where you ask them, if they want to try it again or if they need help
 * Or you could simply set their IP on a BAN-List :-) (Just kidding )
 */

$needed_per_month = "50";
/* The donation Goal per month
 * 
 * 
 */






?>
