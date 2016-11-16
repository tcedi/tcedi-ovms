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

// Additional message to show before print.
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

echo "<title>$companyname - $TEXT_VISITOR_BADGE</title>"; ?>
<meta http-equiv="Expires" content="Tue, 01 Jan 2000 12:12:12 GMT">
<meta http-equiv="Pragma" content="no-cache">
<link rel="stylesheet" type="text/css" href="visitors.css">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" sizes="16x16 32x32 64x64"/>
<link href="jquery/css/jquery-ui.min.css" rel="stylesheet">
<link href="jquery/css/jquery-ui.theme.min.css" rel="stylesheet">
<script type="text/javascript" src="jquery/js/jquery.min.js"></script>
<script type="text/javascript" src="jquery/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="jquery/js/jquery-migrate-1.2.1.min.js"></script>

<script>
  $(function() {
    $( "input[type=submit], input[type=reset], input[type=button]" )
      .button();
  });
</script>

<script type="text/javascript">
// Performs the redirection to the badge page.
function badgeload(ID) {
page = 'printbadge.php?language=<?php echo $sLanguage ?>&visitorID=' + ID
window.location=page;
}
</script>
</head>
<body>
<div class="visitors set-font-size">
<?php
//get visitorID
if(isset($_GET["visitorID"]) && !empty($_GET["visitorID"]) && is_numeric($_GET["visitorID"]))
{
	$visitorID = $_GET["visitorID"];
}
else
{
	$visitorID = -1;
}

include "database.php";

$sRequest = "SELECT FirstName, LastName, Company, Visiting, Email, vehicleonsite, licenseplate, Legal, inDate FROM $table WHERE visitorID=$visitorID";

$rResult = mysqli_query($database_link, $sRequest);

if($rRow = mysqli_fetch_array($rResult, MYSQLI_ASSOC))
{
	$sFirstName = $rRow["FirstName"];
	$sLastName = $rRow["LastName"];
	$sCompany = $rRow["Company"];
	$sReasonForVisit = $rRow["Visiting"];
	$sEMail = $rRow["Email"];
	$iVehicleOnSite = $rRow["vehicleonsite"];
	$sLicensePlate = $rRow["licenseplate"];
	$sLegal = $rRow["Legal"];
	$sInDate = $rRow["inDate"];
}

mysqli_free_result($rResult);

mysqli_close($database_link);

$sTemplateString=file_get_contents('./languages/'.$sLanguage.'/messagebeforeprinttemplate.html');

if($sTemplateString===FALSE)
{
  echo "One error occured during message before print template load.";
}
else
{
	$iBodyStartIndex = stripos($sTemplateString, "<body>");
	if($iBodyStartIndex!==FALSE)
	{
		$sTemplateString=substr($sTemplateString, $iBodyStartIndex + strlen("<body>"));
	}
	
	$iBodyEndIndex = stripos($sTemplateString, "</body>");
	if($iBodyEndIndex!==FALSE)
	{
		$sTemplateString=substr($sTemplateString, 0, $iBodyEndIndex);
	}
	
	$sTemplateString = str_replace('%MY_COMPANY_NAME%', $companyname, $sTemplateString);
	$sTemplateString = str_replace('%MY_COMPANY_SHORT_NAME%', $shortname, $sTemplateString);
	$sTemplateString = str_replace('%VISITOR_BADGE_LABEL%', $TEXT_VISITOR_BADGE, $sTemplateString);
	$sTemplateString = str_replace('%VISITOR_FIRST_NAME%', $sFirstName, $sTemplateString);
	$sTemplateString = str_replace('%VISITOR_LAST_NAME%', $sLastName, $sTemplateString);
	$sTemplateString = str_replace('%VISITOR_COMPANY%', $sCompany, $sTemplateString);
	$sTemplateString = str_replace('%REASON_FOR_VISIT%', $sReasonForVisit, $sTemplateString);
	$sTemplateString = str_replace('%VISITOR_EMAIL_ADDRESS%', $sEMail, $sTemplateString);
	$sTemplateString = str_replace('%VEHICLE_ON_SITE%', $iVehicleOnSite, $sTemplateString);
	$sTemplateString = str_replace('%LICENSE_PLATE_NUMBER%', $sLicensePlate, $sTemplateString);
	$sTemplateString = str_replace('%AGREEMENT_SIGNED%', $sLegal, $sTemplateString);
	$sTemplateString = str_replace('%IN_DATE%', $sInDate, $sTemplateString);
	$sTemplateString = str_replace('%BADGE_ID_NUMBER%', $visitorID, $sTemplateString);
	
	echo $sTemplateString;
}

echo "<form action='javascript: badgeload($visitorID);' method='post'>";
?>
<p>
	<input type="submit" name="continue" value="<?php echo $TEXT_CONTINUE ?>">
</p>
</form>
</div>
</body>
</html>
