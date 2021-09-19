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

// badge printing page called by process.php which displays the badge and print dialog.

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

include 'database.php';
//get visitorID
if(isset($_GET["visitorID"]) && !empty($_GET["visitorID"])) {
	$visitorID = $_GET["visitorID"] ;
	//now spit out the badge data

	$result = mysqli_query($database_link, "SELECT Name FROM $table WHERE visitorID = $visitorID ORDER by inDate DESC LIMIT 1");
	
	$sThisCompanyShortName = "";
	$sVisitorBadgeText = "";
	$sBadgePrintAndRetrievalInstructionsText = "";
	$sVisitorName = "";
	$sVisitorLastName = "";
	$sCompanyLabelText = "";
	$sVisitorCompany = "";
	$sReasonForVisitLabelText = "";
	$sReasonForVisitValue = "";
	$sBadgeIDNumberLabelText = "";
	$sBadgeIDNumberValue = "";
	$sEscortRequiredNDALabelText = "";
	$sEscortRequiredNDAValue = "";
	$sValidDateLabelText = "";
	$sValidDateValue = "";
	$sPleaseReturnToTheReceptionistAndSignOutOnExitText = "";
	
	if(version_compare(PHP_VERSION, '5.3.0', '>='))
	{
	  //IntlDateFormatter is only available from PHP 5.3.0.
	  if(class_exists('IntlDateFormatter'))
	  {
	  	//IntlDateFormatter class is available. php_intl extension is installed.
	  	$idfLocalizedDateFormatter = new IntlDateFormatter($ISO_639_1_LANGUAGE_CODE, IntlDateFormatter::LONG, IntlDateFormatter::NONE);
	  	$day = $idfLocalizedDateFormatter->format(new DateTime());
	  }
	}
	
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		$sThisCompanyShortName = $shortname;
		$sVisitorBadgeText = $TEXT_VISITOR_BADGE;
		$sBadgePrintAndRetrievalInstructionsText = $TEXT_BADGE_PRINT_AND_RETRIEVAL_INSTRUCTIONS;
		$sVisitorName = $row['Name'];
	}
	
		echo '
	<!DOCTYPE html>
	<html>
	<head>
	<meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
	';
	
	echo "<title>$companyname - $TEXT_VISITOR_BADGE</title>";
	require_once 'includes/header.php';
	echo '
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" sizes="16x16 32x32 64x64"/>
<link rel="stylesheet" type="text/css" href="css/main.css">
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
<body onload="AutoCloseWindowIn(6);">
<div class="successpage">
<svg class="icon" focusable="false" viewBox="0 0 24 24" aria-hidden="true" data-testid="DoneIcon"><path d="M9 16.2 4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"></path></svg>
	';
	echo "<h1>$TEXT_GENERATING_BADGE</h1>";
	echo "<h2>$TEXT_PLEASE_SIGN_OUT_ON_EXIT</h2>";
	// echo "<p>$TEXT_YOUR_BADGE_IS_BEING_GENERATED_AND_PRINTED</p>";
	
	// For generating badge in PDF format.
	// require 'fpdf/fpdf_autoprint.php';
	// include './languages/'.$sLanguage.'/badgetemplate.php';
	// For client side destination with automatic display of the print dialog. Please note that no output (echo or else) can be performed in that case !!!!!
	//$pdf->AutoPrint(true);
	//$pdf->Output('badge.pdf', 'I');
	
	// For server side automatic printing.
	// require_once 'ipp_printing/PrintIPP.php';
	
	// $ipp = new PrintIPP();
	// if(array_key_exists($_SERVER['REMOTE_ADDR'], $aIPPPrinterPerClientFixedIPArray))
	// {
	// 	// One specific IPP printer is defined for the current client fixed IP address.
	// 	$ipp->setHost($aIPPPrinterPerClientFixedIPArray[$_SERVER['REMOTE_ADDR']]['IPPPrinterOrServerHost']);
	// 	$ipp->setPort($aIPPPrinterPerClientFixedIPArray[$_SERVER['REMOTE_ADDR']]['IPPPrinterOrServerPort']);
	// 	$ipp->setPrinterURI($aIPPPrinterPerClientFixedIPArray[$_SERVER['REMOTE_ADDR']]['IPPPrinterURI']);
	// }
	// else
	// {
	// 	// Default IPP printer is going to be used.
	// 	$ipp->setHost($sIPPPrinterOrServerHost);
	// 	$ipp->setPort($sIPPPrinterOrServerPort);
	// 	$ipp->setPrinterURI($sIPPPrinterURI);
	// }
	// $ipp->setDocumentName($sVisitorBadgeText.' '.$sBadgeIDNumberValue);
	// $ipp->setJobName($sVisitorBadgeText.' '.$sBadgeIDNumberValue, false);
	// $ipp->setUserName($sIPPJobUserName);
	// $ipp->setData($pdf->Output("",'S'));
	// $ipp->printJob();
	
echo "
<p>
";
	echo "$TEXT_THIS_WINDOW_WILL_BE_CLOSED_AUTOMATICALLY_IN <strong class=\"secondsleft\" id=\"secondsleft\"></strong>&nbsp;$TEXT_SECONDS...";
echo "
</p>
";
echo '
</div>
</body>
</html>
';
}
?>
