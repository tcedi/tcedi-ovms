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

// visitor POST processing page calls database.php, legal.php, printbadge.php, signout.php, and so on.

include 'settings.php';

/* BEGIN translations support section */
if(isset($_GET["language"]) && !empty($_GET["language"]))
{
	$sLanguage = $_GET["language"];
	if(!file_exists('./languages/'.$sLanguage.'/'.basename($_SERVER["PHP_SELF"])))
		$sLanguage = $sDefaultLanguage;
}
else
{
	$sLanguage = $sDefaultLanguage;
}

include './languages/'.$sLanguage.'/'.basename($_SERVER["PHP_SELF"]);
/* END translations support section */
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $TEXT_VISITOR_BADGE_TITLE ?></title>
<meta http-equiv="Expires" content="Tue, 01 Jan 2000 12:12:12 GMT">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="refresh" content="1;url=main.php">
<script type="text/javascript">
//badge page
function badgeload(ID)
{
	page = 'printbadge.php?language=<?php echo $sLanguage ?>&visitorID=' + ID
	window.location=page;
}

//legal page
function legalload(ID)
{
	page = 'legal.php?language=<?php echo $sLanguage ?>&visitorID=' + ID
	window.location=page;
}

//barrier code page
function barriercodeload(ID)
{
	page = 'barriercode.php?language=<?php echo $sLanguage ?>&visitorID=' + ID
	window.location=page;
}

//goodbye page
function goodbyeload()
{
	page = 'goodbye.php?language=<?php echo $sLanguage ?>';
	window.location=page;
}

//message before print page
function messagebeforeprintload(ID)
{
	page = 'messagebeforeprint.php?language=<?php echo $sLanguage ?>&visitorID=' + ID
	window.location=page;
}
</script>

<?php

require 'database.php';

//sql Injection removal
function sanitize($data)
{
	global $database_link;
        // remove whitespaces (not a must though)
	$data = trim($data);
	// apply stripslashes if magic_quotes_gpc is enabled
	// if(get_magic_quotes_gpc())
	// {
	// 	$data = stripslashes($data);
	// }
	// a mySQL connection is required before using this function
	$data = mysqli_real_escape_string($database_link, $data);
	return $data;
}

//get IP for Location data
$ip;
if (getenv("HTTP_CLIENT_IP"))
	$ip = getenv("HTTP_CLIENT_IP"); 
else if(getenv("HTTP_X_FORWARDED_FOR"))
	$ip = getenv("HTTP_X_FORWARDED_FOR"); 
else if(getenv("REMOTE_ADDR"))
	$ip = getenv("REMOTE_ADDR"); 
else
	$ip = "UNKNOWN";

//turn IP into location name
if(stristr($ip, $subnet1) !== FALSE)
{
	$location = $site1;
}
else if(stristr($ip, $subnet2) !== FALSE)
{
	$location = $site2;
}
else if(stristr($ip, $subnet3) !== FALSE)
{
	$location = $site3;
}
else if(stristr($ip, $subnetLH) !== FALSE)
{
	$location = $siteLH;
}
else
	$location = $ip;

//POST data parsing
//legal signed pop-up badge print
if (isset($_POST['legal']) && $_POST['legal'] == "$TEXT_AGREE")
{
	//get visitorID
	if(isset($_GET["visitorID"]) && !empty($_GET["visitorID"]) && is_numeric($_GET["visitorID"]))
	{
		$visitorID = $_GET["visitorID"] ;
	}
	else
	{
		$visitorID = -1;
	}
	//process legal record to signed
	if (!mysqli_query($database_link, "UPDATE $table SET Legal='signed' WHERE visitorID = $visitorID ORDER by inDate DESC LIMIT 1"))
	{
		die('!Error: ' . mysqli_error($database_link));
	}
	if($bShowAdditionalMessageBeforeBadgePrint === true)
	{
		echo "<script>messagebeforeprintload($visitorID)</script>";
	}
	else
	{
		echo "<script>badgeload($visitorID)</script>";
	}
	//echo "<script>self.close();</script>";
} //end if legal

//process logout
if(isset($_POST['logout']))
{
	if(isset($_POST["number"]))
	{
		//change SignOutFlag = 1
		if (!mysqli_query($database_link, "UPDATE $table SET SignOutFlag=1, outDate='$sqltime' WHERE Number='$_POST[number]' AND SignOutFlag <> 1"))
		{
			die('!Error: ' . mysqli_error($database_link));
		}
		
		// $bShowBarrierCode = false;
		
		// if($bEnableSimpleBarrierManagementSupport === true)
		// {
		// 	$sRequest = "SELECT vehicleonsite FROM $table WHERE visitorID='$_POST[badgeID]' AND SignOutFlag = 1";
			
		// 	$rResult = mysqli_query($database_link, $sRequest);
			
		// 	if($rRow = mysqli_fetch_array($rResult, MYSQLI_ASSOC))
		// 	{
		// 		if($rRow["vehicleonsite"] == 1)
		// 		{
		// 			$bShowBarrierCode = true;
		// 		}
		// 	}
			
		// 	mysqli_free_result($rResult);
		// }
		
		// if($bShowBarrierCode === true)
		// {
		// 	echo "<script type=\"text/javascript\">barriercodeload(".$_POST["badgeID"].");</script>";
			//echo "<script type=\"text/javascript\">self.close();</script>";
		// }
		// else
		// {
			echo "<script type=\"text/javascript\">goodbyeload();</script>";
			//echo "<script type=\"text/javascript\">self.close();</script>";
		// }
	}
	else
	{
		die("Error : Invalid Membership Number or Phone Number provided.");
	}
} //end if logout

//process login
if(isset($_POST['login']))
{
	//save record with SQL injection sanitize
	$location = sanitize($location);
	$name = sanitize($_POST['name']);
	$number =sanitize($_POST['number']);
	$type =sanitize($_POST['type']);
	$sqltime =sanitize($sqltime);
	$sqldate =sanitize($sqldate);
	$sqlnextdate =sanitize(date('y-m-d', strtotime($sqldate .' +1 day')));

	$query = "SELECT visitorID from $table WHERE Number='$_POST[number]' AND inDate >='$sqldate 00:00:00' AND inDate <'$sqlnextdate 00:00:00' AND SignOutFlag=0";
	$result = mysqli_query($database_link, $query);
	if(mysqli_num_rows($result) === 0) {
		if (!mysqli_query($database_link, "INSERT INTO $table (Location, Name, Number, Type, inDate, outDate, SignOutFlag) VALUES ('$location','$name','$number','$type','$sqltime','not checked out',0)"))
	{
		die('!Error: ' . mysqli_error($database_link));
	}

	$query = "SELECT LAST_INSERT_ID() ID";
	$result = mysqli_query($database_link, $query);
	while($row = mysqli_fetch_array($result))
	{
		$id = $row['ID'];
	}

	if ($requireLegal == 'yes')
	{
		echo "<script>legalload($id)</script>";
	}
	else 
	{
		if($bShowAdditionalMessageBeforeBadgePrint === true)
		{
			echo "<script>messagebeforeprintload($id)</script>";
		}
		else
		{
			echo "<script>badgeload($id)</script>";
		}
	}
	} else {
		header('Location: main.php?name='.$name.'&type='.$type.'&number='.$number);
	}
}
?>
