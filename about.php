<?php
/*
   T.C.E.D.I. Open Visitors Management System
   Copyright (c) 2016 by T.C.E.D.I. (Jean-Denis Tenaerts)

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

// About page.
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

echo "<title>$companyname - $TEXT_ABOUT $TEXT_TCEDI_OPEN_VISITORS_MANAGEMENT_SYSTEM</title>"; ?>
<meta http-equiv="Expires" content="Tue, 01 Jan 2000 12:12:12 GMT">
<meta http-equiv="Pragma" content="no-cache">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" sizes="16x16 32x32 64x64"/>
<link href="libraries/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="jumbotron text-center">
<h1><?php echo "$TEXT_ABOUT $TEXT_TCEDI_OPEN_VISITORS_MANAGEMENT_SYSTEM $appVer";?></h1>
</div>
<div class="container">
<div class="row text-center">
<p><a class="btn btn-primary btn-lg" href="main.php"><?php echo "$TEXT_GO_BACK_TO_THE_MAIN_PAGE";?></a></p>
<?php
$sTemplateString=file_get_contents('./languages/'.$sLanguage.'/abouttemplate.html');

if($sTemplateString===FALSE)
{
  echo "One error occured during about template load.";
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
	
	//$sTemplateString = str_replace('%MY_COMPANY_NAME%', $companyname, $sTemplateString);
	//$sTemplateString = str_replace('%MY_COMPANY_SHORT_NAME%', $shortname, $sTemplateString);
	
	echo $sTemplateString;
}
?>
<textarea rows="15" style="min-width: 100%" readonly>
<?php
$sNoticeString=file_get_contents('./NOTICE');

if($sNoticeString===FALSE)
{
  echo "One error occured during NOTICE load.";
}
else
{
	echo $sNoticeString;
}
?>
</textarea>
<p> </p>
<p><a class="btn btn-primary btn-lg" href="main.php"><?php echo "$TEXT_GO_BACK_TO_THE_MAIN_PAGE";?></a></p>
</div>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="libraries/jquery/js/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="libraries/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
