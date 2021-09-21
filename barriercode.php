<?php
/*
   T.C.E.D.I. Open Visitors Management System
   Copyright (c) 2016 by T.C.E.D.I. (Jean-Denis Tenaerts)

   T.C.E.D.I. Open Visitors Management System is a derivative work based on phpVisitorBadge Enhanced.
   phpVisitorBadge Enhanced
   Copyright (c) 2010-2016 RKW ACE S.A.

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

// Page containing the barrier code.
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php 
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

echo "<title>$TEXT_BARRIER_CODE - $companyname</title>";
?>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" sizes="16x16 32x32 64x64"/>
<link rel="stylesheet" type="text/css" href="visitors.css">
<script type="text/javascript">
var iSecondsLeft;

function AutoCloseWindowIn(iSeconds)
{
	iSecondsLeft = iSeconds;
	
	var iTimePeriod;
	iTimePeriod = 1000;
	
	var iI;
	iI = iSeconds * iTimePeriod;
	
	DisplayTimeLeft();
	setTimeout("PerformWindowClose();", iI);
}

function DisplayTimeLeft()
{
	document.getElementById("secondsleft").innerHTML = iSecondsLeft;
	iSecondsLeft = iSecondsLeft-1;
	
	if(iSecondsLeft > 0)
	{	
		var iTimePeriod;
		iTimePeriod = 1000;
		
		setTimeout("DisplayTimeLeft();", iTimePeriod);
	}
}

function PerformWindowClose()
{
	//self.close();
	window.location="main.php";
}
</script>
</head>
<body onload="AutoCloseWindowIn(20)">
<?php
	include "database.php";
	
	$sCode = $TEXT_UNKNOWN;
	
	if(is_numeric($_GET["visitorID"]))
	{
		$bShowBarrierCode = false;
		
		if($bEnableSimpleBarrierManagementSupport === true)
		{
			$sRequest = "SELECT vehicleonsite FROM $table WHERE visitorID='$_GET[visitorID]' AND SignOutFlag = 1";
		
			$rResult = mysqli_query($database_link, $sRequest);
		
			if($rRow = mysqli_fetch_array($rResult, MYSQLI_ASSOC))
			{
				if($rRow["vehicleonsite"] == 1)
				{
					$bShowBarrierCode = true;
				}
			}
			
			mysqli_free_result($rResult);
		}
	
		if($bShowBarrierCode === true)
		{
			$sRequest = "SELECT code FROM $sSimpleBarrierManagementDataBase.$sSimpleBarrierManagementBarrierCodeTable ORDER BY identifier DESC LIMIT 1";
	
			$rResult = mysqli_query($database_link, $sRequest);
	
			if($rRow = mysqli_fetch_array($rResult, MYSQLI_ASSOC))
			{
				$sCode = $rRow["code"];
			}
	
			mysqli_free_result($rResult);
			mysqli_close($database_link);
		}
		else
		{
			die("$TEXT_YOU_HAVE_TO_SIGN_OUT_BEFORE_AND_SIMPLE_BARRIER_MANAGEMENT_MUST_BE_ENABLED");
		}
	}
	else
	{
		die("Error : Invalid visitor ID.");
	}
?>
<div class="signout set-font-size">
<h1><?php echo "$TEXT_THANKS_AGAIN_FOR_VISITING $shortname"?></h1>
<h2><?php echo "$TEXT_BARRIER_CODE : $sCode"?></h2>
<div class="centered-flow">
<div class="centered-flow-block">
<p class="barriercode">
	<?php echo "$TEXT_BECAUSE_YOUR_VEHICLE_IS_ON_THE_SITE_YOU_WILL_NEED_BARRIER_CODE"?>
</p>
</div>
</div>
<p class="close">
	<a href="javascript:window.location='main.php';"><?php echo "$TEXT_CLOSE_WINDOW"?></a>
</p>
<p>
	<?php echo "$TEXT_THIS_WINDOW_WILL_BE_CLOSED_AUTOMATICALLY_IN <strong id=\"secondsleft\"></strong>&nbsp;$TEXT_SECONDS..."?>
</p>
</div>
</body>
</html>
