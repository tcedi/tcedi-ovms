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

// Page displayed after signout whether there is no barrier code.
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php 
include 'settings.php';
require_once 'includes/header.php';
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

echo "<title>$TEXT_GOODBYE - $companyname</title>";
?>

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
<body onload="AutoCloseWindowIn(10)">
<div class="successpage">
	<svg class="icon" focusable="false" viewBox="0 0 24 24" aria-hidden="true" data-testid="DoneIcon"><path d="M9 16.2 4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"></path></svg>
<h1>Thanks for visitng Makerspace</h1>
<h2>See you soon!</h2>
<p class="close">
	<a href="javascript:PerformWindowClose();">Close window</a>
</p>
<p>
	This window will be closed in <span class="secondsleft" id="secondsleft"></span> seconds
</p>
</div>
</body>
</html>
