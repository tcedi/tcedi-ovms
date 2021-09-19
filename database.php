<?php
/*
   T.C.E.D.I. Open Visitors Management System
   Copyright (c) 2016 by T.C.E.D.I. (Jean-Denis Tenaerts)

   T.C.E.D.I. Open Visitors Management System is a derivative work based on phpVisitorBadge Enhanced.
   phpVisitorBadge Enhanced
   Copyright (c) 2010-2016 RKW ACE S.A.

   phpVisitorBadge Enhanced is a derivative work based on the original version of phpVisitorBadge.
   phpVisitorBadge
   Copyright (c) 2010 by NCA/KRK.

   Licensed under the Apache License, Version 2.0 (the "License");
   you may not use this file except in compliance with the License.
   You may obtain a copy of the License at

       http://www.apache.org/licenses/LICENSE-2.0

   Unless required by applicable law or agreed to in writing, software
   distributed under the License is distributed on an "AS IS" BASIS,
   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
   See the License for the specific language governing permissions and
   limitations under the License.
*/

// database and application variable page called by all pages in application
date_default_timezone_set('Australia/Adelaide');
require 'settings.php';
$sqltime = date("y-m-d G:i:s T");
$sqldate = date("y-m-d");
$day = date("Y-m-d"); //This will be used as validity date fallback, if php_intl is not available.
//connect database
$database_link = mysqli_connect($db_host, $db_user, $db_pwd, $database);
if (!$database_link) die("Could not Connect to MySQL at $db_host (Is MySQL running? Have you <a href=\"install.php\">configured MySQL database and tables</a>, as well as database.php settings?). Error: " . mysqli_error($database_link));

?>
