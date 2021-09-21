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

// Install on first run to configure MySQL - remove for security after inital setup (or if not needed)
require 'settings.php';
include 'database.php';
// create table if missing 
$check = mysqli_query ($database_link, "SELECT * FROM $table LIMIT 0,1");
if ($check){
// query was legal therefore table exists
}else{
if (!mysqli_query($database_link, "CREATE TABLE IF NOT EXISTS $table 
(
 visitorID int(10) NOT NULL AUTO_INCREMENT,
 PRIMARY KEY(visitorID),
 Location VARCHAR(50),
 FirstName VARCHAR(255),
 LastName VARCHAR(255),
 Company VARCHAR(255),
 Visiting VARCHAR(255),
 Email VARCHAR(255),
 vehicleonsite INTEGER,
 licenseplate VARCHAR(25),
 Legal VARCHAR(10),
 inDate VARCHAR(30),
 outDate VARCHAR(30),
 SignOutFlag Binary 
)"))
  die('Database exists but, can\'t create table '  . mysqli_error($database_link));
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>T.C.E.D.I. Open Visitors Management</title>
<meta http-equiv="Expires" content="Tue, 01 Jan 2000 12:12:12 GMT">
<meta http-equiv="Pragma" content="no-cache">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" sizes="16x16 32x32 64x64"/>
</head>
<body>
<strong>T.C.E.D.I. Open Visistors Management - Installation</strong>
<br><br>
Once the installation is finished, please remove all the access rights to "install.php" or simply delete the file "install.php", for security purposes.
<br><br>
If you see no error at the top of this page, then everything should be working properly for the application.
<br><br>
To go to the main page, please click <a href="main.php">here</a>.
<br><br>
<div id="warning">
<script type="text/javascript">
<!--
//
-->
</script>
<noscript>
<p>Your browser doesn't support JavaScript or JavaScript support has been disabled. You must enable JavaScript to use this application.</p>
</noscript>
</div>
</body>
