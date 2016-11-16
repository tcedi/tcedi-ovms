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

// Non Disclosure page.
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
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" sizes="16x16 32x32 64x64"/>
<link rel="stylesheet" type="text/css" href="visitors.css">

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

</head>
<body>
<div class="visitors set-font-size">
<?php
$sTemplateString=file_get_contents('./languages/'.$sLanguage.'/legaltemplate.html');

if($sTemplateString===FALSE)
{
  echo "One error occured during badge template load.";
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
	
	echo $sTemplateString;
}

//get visitorID
if(isset($_GET["visitorID"]) && !empty($_GET["visitorID"])) {
  $visitorID = $_GET["visitorID"];
echo "<form action='process.php?language=".$sLanguage."&visitorID=$visitorID' method='post'>";
;}?>
<p class="signature"><strong><?php echo $TEXT_I_DIGITALLY_SIGN_THE_NON_DISCLOSURE_AGREEMENT ?></strong></p>
<p class="signature">
	<input type="submit" name="legal" value="<?php echo $TEXT_AGREE ?>">&nbsp;<input type="submit" name="Decline" value="<?php echo $TEXT_DECLINE ?>" onClick="window.location='main.php'">
</p>
</form>
</div>
</body>
</html>
