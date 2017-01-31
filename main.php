<?php
/*
   T.C.E.D.I. Open Visitors Management System
   Copyright (c) 2016-2017 by T.C.E.D.I. (Jean-Denis Tenaerts)

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

// Main application page.
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
$bLanguageSelected=false;

if(isset($_GET["language"]) && !empty($_GET["language"]))
{
  $sLanguage = $_GET["language"];
  if(!file_exists('./languages/'.$sLanguage.'/'.basename($_SERVER["PHP_SELF"])))
  {
    $sLanguage = $sDefaultLanguage;
  }
  else
  {
    $bLanguageSelected=true;
  }
}
else
{
  $sLanguage = $sDefaultLanguage;
}

include './languages/'.$sLanguage.'/'.basename($_SERVER["PHP_SELF"]);
/* END translations support section */

echo "<title>$companyname - $TEXT_VISITOR_BADGE_TITLE</title>"; ?>
<meta http-equiv="Expires" content="Tue, 01 Jan 2000 12:12:12 GMT">
<meta http-equiv="Pragma" content="no-cache">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" sizes="16x16 32x32 64x64"/>
<link href="jquery/css/jquery-ui.min.css" rel="stylesheet">
<link href="jquery/css/jquery-ui.theme.min.css" rel="stylesheet">
<script type="text/javascript" src="jquery/js/jquery.min.js"></script>
<script type="text/javascript" src="jquery/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="jquery/js/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript">
  $(function() {
    $( "#accordion" ).accordion({
	heightStyle: "content"<?php if($bLanguageSelected===true) echo ", active: 1"; ?>
	});
  });
</script>
<script>
  $(function() {
    $( "input[type=submit], input[type=reset], input[type=button]" )
      .button();
  });
</script>
<script>
  $(function() {
    $( "#vehicleonsiteradio" ).buttonset();
  });
  </script>
<?php
if($bEnableVirtualKeyboard === true)
{
echo('
<!-- keyboard widget css & script (required) -->
<link href="virtualkeyboard/css/keyboard.min.css" rel="stylesheet">
<script type="text/javascript" src="virtualkeyboard/js/jquery.keyboard.min.js" charset="utf-8"></script>
<script type="text/javascript" src="virtualkeyboard/layouts/alphasmall.js" charset="utf-8"></script>
');
}
?>

<link rel="stylesheet" type="text/css" href="visitors.css">
<script type="text/javascript">
//client side validation checking
function CheckFirstName(sFirstName)
{
  var sError;
  sError = "";
  
  if(sFirstName == "")
  {
    sError = "<?php echo $TEXT_PLEASE_ENTER_YOUR_FIRST_NAME ?>\n";
  }
  
  return sError;
}

function CheckLastName(sLastName)
{
  var sError;
  sError = "";
  
  if(sLastName == "")
  {
    sError = "<?php echo $TEXT_PLEASE_ENTER_YOUR_LAST_NAME ?>\n";
  }
  
  return sError;
}

function CheckCompanyName(sCompanyName)
{
  var sError;
  sError = "";
  
  if(sCompanyName == "")
  {
    sError = "<?php echo $TEXT_PLEASE_ENTER_YOUR_COMPANY_NAME ?>\n";
  }
  
  return sError;
}

<?php
if($bEnableJoomlaContactsSupport === true)
{
echo "
function CheckReasonForVisit(sReasonForVisit)
{
  var sError;
  sError = \"\";
  
  if(sReasonForVisit == \"\" || sReasonForVisit == \"-1\")
  {
    sError = \"$TEXT_PLEASE_SELECT_EMPLOYEE_OR_SERVICE_CONCERNED\\n\";
  }
  
  return sError;
}
";
}
else
{
  echo "
function CheckReasonForVisit(sReasonForVisit)
{
  var sError;
  sError = \"\";
  
  if(sReasonForVisit == \"\")
  {
    sError = \"$TEXT_PLEASE_ENTER_REASON_FOR_VISIT\\n\";
  }
  
  return sError;
}
";
}
?>

function CheckVehicleOnSite(rVehicleOnSite)
{
  var sError;
  sError = "";
  
  if(rVehicleOnSite[0].checked == false && rVehicleOnSite[1].checked == false)
  {
    sError = "<?php echo $TEXT_PLEASE_INDICATE_WHETHER_YOUR_VEHICLE_IS_ON_THE_SITE ?>\n";
  }
  
  return sError;
}

function CheckLicensePlate(sLicensePlate)
{
  var sError;
  sError = "";
  
  if(sLicensePlate == "")
  {
    sError = "<?php echo $TEXT_PLEASE_ENTER_YOUR_LICENSE_PLATE_NUMBER ?>\n";
  }
  
  return sError;
}

function OnVehicleOnSiteValueChanged(fForm)
{
  if(fForm.vehicleonsite[0].checked)
  {
    document.getElementById("licenseplatenumberlabel").innerHTML ="<b><?php echo "$TEXT_LICENSE_PLATE_NUMBER" ?><\/b>";
    fForm.licenseplate.disabled=false;
  }
  else
  {
    document.getElementById("licenseplatenumberlabel").innerHTML ="<?php echo "$TEXT_LICENSE_PLATE_NUMBER" ?>";
    fForm.licenseplate.value="";
    fForm.licenseplate.disabled=true;
  }
  
  return true;
}

function CheckEMailAddress(sEMailAddress)
{
  var sError;
  sError = "";

  if(sEMailAddress.length > 0)
  {
    var reEMailValidationPattern;
    // e-Mail validation regular expression from HTML 5.1 recommendation (not compliant with RFC 5322) is used: https://www.w3.org/TR/2016/REC-html51-20161101/sec-forms.html#valid-e-mail-address
    reEMailValidationPattern = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;

    if(!reEMailValidationPattern.test(sEMailAddress))
    {
      sError = "<?php echo $TEXT_PLEASE_CHECK_YOUR_EMAIL_ADDRESS ?>\n";
    }
  }
  return sError;
}

function CheckWholeForm(theForm)
{
  var why = "";
  why += CheckFirstName(theForm.firstname.value);
  why += CheckLastName(theForm.lastname.value);
  why += CheckCompanyName(theForm.company.value);
  why += CheckReasonForVisit(theForm.visiting.value);
  why += CheckVehicleOnSite(theForm.vehicleonsite);
  
  if(theForm.vehicleonsite[0].checked)
  {
    why += CheckLicensePlate(theForm.licenseplate.value);
  }

  why += CheckEMailAddress(theForm.email.value);

  if (why != "")
  {
    alert(why);
    return false;
  }
  else
  {
    return true;
  }
}
//logout page
function logoutload() {
page = 'signout.php?language=<?php echo $sLanguage ?>'
window.location=page;
}
</script>
</head>
<body>
<div id="warning"><script type="text/javascript"><!-- // --> </script>
<noscript><p>$TEXT_JAVASCRIPT_SUPPORT_REQUIRED</p></noscript></div>
<div class="visitors">
<h1><?php echo "$TEXT_WELCOME_TO $shortname"?></h1>
<h2><?php echo "$TEXT_VISITOR_PLEASE_SIGN_IN"?></h2>
</div>
<div id="accordion">
<?php
/* BEGIN translations support section */
echo "<h3>".$TEXT_CHOOSE_YOUR_LANGUAGE."</h3>";
echo "<div>";
echo "<div class=\"centered-flow\">";

$dDirectory = dir("./languages/");

while (false !== ($sEntry = $dDirectory->read()))
{
   if($sEntry !== "." && $sEntry !== "..")
   { 
     echo "<div class=\"centered-flow-block\"><a href=\"".basename($_SERVER["PHP_SELF"])."?language=".$sEntry."\">".$sEntry."<br><img src=\"languages/".$sEntry."/lang.png\"/></a></div>";
   }
}
$dDirectory->close();
echo "</div>";
echo "</div>";
/* END translations support section */
?>
<h3><?php echo $TEXT_ENTRANCE ?></h3>
<div>
<div class="centered-flow">
<div class="centered-flow-block">
<form action="process.php?language=<?php echo $sLanguage ?>" autocomplete="off" method="post" name="newvisitor">
<!--<form action="process.php?language=<?php echo $sLanguage ?>" method="post" name="newvisitor">-->
	<div class="centered-table">
		<div class="table-row">
			<div class="table-cell-right-align">
				<b><?php echo "$TEXT_FIRST_NAME"?></b>
			</div>
			<div class="table-cell-left-align">
				<input id="firstnameinternational" type="text" name="firstname" autocomplete="off" placeholder="<?php echo "$TEXT_ENTER_YOUR_FIRST_NAME";?>" maxlength="255">
<?php
if($bEnableVirtualKeyboard === true)
{
echo '
				<script type="text/javascript">
				$(\'#firstnameinternational\')
	.keyboard({ layout: \'alphasmall\', autoAccept: true, tabNavigation: true, enterNavigation: true })
	.addTyping();
	</script>
';
}
?>
			</div>
		</div>
		<div class="table-row">
			<div class="table-cell-right-align">
				<b><?php echo "$TEXT_LAST_NAME"?></b>
			</div>
			<div class="table-cell-left-align">
				<input id="lastnameinternational" type="text" name="lastname" autocomplete="off" placeholder="<?php echo "$TEXT_ENTER_YOUR_LAST_NAME";?>" maxlength="255">
<?php
if($bEnableVirtualKeyboard === true)
{
echo '
				<script type="text/javascript">
				$(\'#lastnameinternational\')
	.keyboard({ layout: \'alphasmall\', autoAccept: true, tabNavigation: true, enterNavigation: true })
	.addTyping();
	</script>
';
}
?>
			</div>
		</div>
		<div class="table-row">
			<div class="table-cell-right-align">
				<b><?php echo "$TEXT_COMPANY"?></b>
			</div>
			<div class="table-cell-left-align">
				<input id="companyinternational" type="text" name="company" autocomplete="off" placeholder="<?php echo "$TEXT_ENTER_YOUR_COMPANY_NAME";?>" maxlength="255">
<?php
if($bEnableVirtualKeyboard === true)
{
echo '
				<script type="text/javascript">
				$(\'#companyinternational\')
	.keyboard({ layout: \'alphasmall\', autoAccept: true, tabNavigation: true, enterNavigation: true })
	.addTyping();
	</script>
';
}
?>
			</div>
		</div>
		<?php
			if($bEnableJoomlaContactsSupport === true)
			{
				echo "
		<div class=\"table-row\">
			<div class=\"table-cell-right-align\">
			<div class=\"plain-centered-block\">
				<b>$TEXT_EMPLOYEE_OR_SERVICE_CONCERNED</b>
			</div>
			</div>
			<div class=\"table-cell-left-align\">
				<select id=\"visitingselect\" name=\"visiting\">
				<option selected value=\"-1\">$TEXT_PLEASE_SELECT</option>
				";
				require 'database.php';
					
				$sRequest = "SELECT `id`, ".$sJoomlaValueToUseAsEmployeeOrServiceConcerned." AS nameandphone FROM `".$sJoomlaDataBase."`.`".$sJoomlaTablesPrefix.$sJoomlaContactDetailsTable."`WHERE `published` = 1 AND `catid` IN (".$sJoomlaContactCategoryIDs.") AND `misc` NOT LIKE '%".$sJoomlaOmitContactsWithThisTagInMisc."%' ORDER BY `catid` DESC,`name` ASC";
				$qResults = mysqli_query($database_link, $sRequest);
					
				while($rRow = mysqli_fetch_array($qResults, MYSQLI_ASSOC))
				{
					echo '<option value="'.$rRow['nameandphone'].'">'.$rRow['nameandphone'].'</option>'."\n";
				}
				
				mysqli_free_result($qResults);
				mysqli_close($database_link);
				
				echo "
				</select>
				<script type=\"text/javascript\">
    $( \"#visitingselect\" ).selectmenu({width:\"105%\"})
	.selectmenu( \"menuWidget\" )
    .addClass( \"overflow\" );
  </script>
			</div>
		</div>
				";	
			}
			else
			{
				echo "
		<div class=\"table-row\">
			<div class=\"table-cell-right-align\">
				<b>$TEXT_REASON_FOR_VISIT</b>
			</div>
			<div class=\"table-cell-left-align\">
				<input id=\"visitinginternational\" type=\"text\" name=\"visiting\" autocomplete=\"off\" placeholder=\"$TEXT_ENTER_REASON_FOR_VISIT\" maxlength=\"255\">
";
if($bEnableVirtualKeyboard === true)
{
echo "
				<script type=\"text/javascript\">
				$('#visitinginternational')
	.keyboard({ layout: 'alphasmall', autoAccept: true, tabNavigation: true, enterNavigation: true })
	.addTyping();
	</script>
";
}
echo "
			</div>
		</div>
				";
			}
		?>
		
		<div class="table-row">
			<div class="table-cell-right-align">
				<b><?php echo "$TEXT_VEHICLE_ON_SITE" ?></b>
			</div>
			<div class="table-cell-left-align">
				<div id="vehicleonsiteradio">
				<input type="radio" id="vehicleonsiteradio1" name="vehicleonsite" value="1" onchange="OnVehicleOnSiteValueChanged(newvisitor)"><label for="vehicleonsiteradio1"><?php echo $TEXT_YES ?></label>
				<input type="radio" id="vehicleonsiteradio2" name="vehicleonsite" value="0" onchange="OnVehicleOnSiteValueChanged(newvisitor)"><label for="vehicleonsiteradio2"><?php echo $TEXT_NO ?></label>
				</div>
			</div>
		</div>
		<div class="table-row">
			<div class= "table-cell-right-align" id="licenseplatenumberlabel">
				<?php echo "$TEXT_LICENSE_PLATE_NUMBER" ?>
			</div>
			<div class="table-cell-left-align">
				<input id="licenseplateinternational" type="text" name="licenseplate" autocomplete="off" placeholder="<?php echo "$TEXT_ENTER_YOUR_LICENSE_PLATE_NUMBER";?>" maxlength="25" disabled>
<?php
if($bEnableVirtualKeyboard === true)
{
echo '
				<script type="text/javascript">
				$(\'#licenseplateinternational\')
	.keyboard({ layout: \'alphasmall\', autoAccept: true, tabNavigation: true, enterNavigation: true })
	.addTyping();
	</script>
';
}
?>
			</div>
		</div>
		<div class="<?php if($bAllowVisitorsToOptionallyEnterTheirEMailAddress === true) {echo 'table-row';} else {echo 'hide';} ?>">
			<div class="table-cell-right-align">
				<?php echo "$TEXT_EMAIL_ADDRESS"?>
			</div>
			<div class="table-cell-left-align">
				<input id="emailinternational" type="text" name="email" autocomplete="off" placeholder="<?php echo "$TEXT_ENTER_YOUR_EMAIL_ADDRESS";?>" maxlength="255">
<?php
if($bEnableVirtualKeyboard === true)
{
echo '
				<script type="text/javascript">
				$(\'#emailinternational\')
	.keyboard({ layout: \'alphasmall\', autoAccept: true, tabNavigation: true, enterNavigation: true })
	.addTyping();
	</script>
';
}
?>
			</div>
		</div>
	</div>
	<p>
	<input type="submit" name="login" value="<?php echo "$TEXT_SIGN_IN_AND_PRINT_VISITOR_BADGE" ?>" OnClick="return CheckWholeForm(newvisitor);">
	<input type="reset" value="<?php echo "$TEXT_CLEAR" ?>">
	</p>
	</form>
	<div class="centered-flow-block">
	<p class="note">
		<?php echo $TEXT_NOTE ?> : <?php echo $TEXT_FIELDS_IN_BOLD_ARE_MANDATORY ?>
	</p>
	</div>
	</div>
	</div>
	</div>
	<h3><?php echo $TEXT_EXIT ?></h3>
	<div>
	<div class="centered-flow">
	<div class="centered-flow-block">
	<form name="leave">
	<p>
	<input type="button" onclick="javascript:logoutload()" value="<?php echo "$TEXT_SIGN_OUT_LEAVE" ?>">
	</p>
	</form>
	<p class="note">
		<?php echo $TEXT_NOTE ?> : <?php echo $TEXT_TO_SIGN_OUT_LEAVE_YOU_DONT_HAVE_TO_FILL_IN_THE_FORM ?>
	</p>
	</div>
	</div>
	</div>
</div>
<p class="copyright">
	T.C.E.D.I. Open Visitors Management System <?php echo $appVer ?>
	<br>
	Copyright &copy; 2016 by T.C.E.D.I. (Jean-Denis Tenaerts)
	<br>
<?php
if($bShowLinkToAdministrationPage === true)
{
  echo "<a href=\"admin.php?language=$sLanguage\">$TEXT_ADMINISTRATION</a>&emsp;"."\n";
}
if($bShowLinkToReceptionViewPage === true)
{
  echo "<a href=\"reception-view.php?language=$sLanguage\">$TEXT_RECEPTION_VIEW</a>&emsp;"."\n";
}
?>
	<a href="about.php?language=<?php echo $sLanguage ?>"><?php echo $TEXT_ABOUT ?></a>
</p>
</body>
</html>
