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
require_once 'includes/header.php';
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
<!-- <link href="jquery/css/jquery-ui.min.css" rel="stylesheet"> -->
<!-- <link href="jquery/css/jquery-ui.theme.min.css" rel="stylesheet"> -->
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

<!-- <link rel="stylesheet" type="text/css" href="visitors.css"> -->

<script type="text/javascript" src="validation.js"></script>
<SCRIPT type="text/javascript">
//client side validation checking
function CheckName(sName)
{
  var sError;
  sError = "";
  
  if(sName == "")
  {
    sError = "<?php echo $TEXT_PLEASE_ENTER_YOUR_FULL_NAME ?>\n";
  }
  
  return sError;
}

function CheckNumber(sNumber)
{
  var sError;
  sError = "";
  
  if(sNumber == "")
  {
    sError = "<?php echo $TEXT_PLEASE_ENTER_YOUR_NUMBER ?>\n";
  }
  
  return sError;
}

function checkWholeForm(theForm) {
    var why = "";
    //why += checkUsername(theForm.vname.value);
	why += CheckName(theForm.name.value);
	why += CheckLastName(theForm.lastname.value);
    why += CheckNumber(theForm.number.value);
    why += CheckReasonForVisit(theForm.visiting.value);
	why += CheckVehicleOnSite(theForm.vehicleonsite);
	if(theForm.vehicleonsite[0].checked)
	{
	  why += CheckLicensePlate(theForm.licenseplate.value);
	}
    why += checkEmail(theForm.email.value);
    if (why != "") {
       alert(why);
       return false;
alert(error);
    }
return true;
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
<img width="200" src="images/makerspacelogo.svg" alt="Makerspace" />
<h2><?php echo "$TEXT_VISITOR_PLEASE_SIGN_IN"?></h2>
</div>
<div id="accordion">
<?php
/* BEGIN translations support section */
echo "<h3>".$TEXT_CHOOSE_YOUR_LANGUAGE."</h3>";
echo "<div>";
echo "<div class=\"centered-flow-block languages\">";

$dDirectory = dir("./languages/");

while (false !== ($sEntry = $dDirectory->read()))
{
   if($sEntry !== "." && $sEntry !== "..")
   { 
     echo "<a href=\"".basename($_SERVER["PHP_SELF"])."?language=".$sEntry."\">".$sEntry."<br><img src=\"languages/".$sEntry."/lang.png\"/></a>";
   }
}
$dDirectory->close();
echo "</div>";
echo "</div>";
/* END translations support section */
?>
<h3><?php echo $TEXT_ENTRANCE ?></h3>
<div>
<div class="centered-flow-block">
<form class="form" action="process.php?language=<?php echo $sLanguage ?>" autocomplete="off" method="post" name="newvisitor">
<!--<form action="process.php?language=<?php echo $sLanguage ?>" method="post" name="newvisitor">-->
	<div class="table-row">
		<div class="table-cell-right-align">
			<b><?php echo "$TEXT_FULL_NAME"?></b>
		</div>
		<div class="table-cell-left-align">
			<input required id="nameinternational" type="text" name="name" autocomplete="off" placeholder="<?php echo "$TEXT_ENTER_YOUR_FULL_NAME";?>" maxlength="255">
		</div>
	</div>
	<div class="table-row">
		<div class="table-cell-right-align">
			<b><?php echo "$TEXT_NUMBER" ?></b>
		</div>
		<div class="table-cell-left-align">
			<input required id="numberinternational" type="number" min="0" inputmode="numeric" pattern="[0-9]*" name="number" autocomplete="off" placeholder="<?php echo "$TEXT_ENTER_YOUR_NUMBER";?>" maxlength="10">
		</div>
	</div>
	<div class="table-row">
		<div class="table-cell-right-align">
			<b><?php echo "$TEXT_VISITOR_TYPE" ?></b>
		</div>
		<div class="table-cell-left-align types">
			<input value="member" type="radio" name="type" required id="member" />
			<label for="member" class="type">
				<?php echo "$TEXT_VISITOR_TYPE_MEMBER" ?>
			</label>
			<input value="casual user" type="radio" name="type" id="casual_user" />
			<label class="type" for="casual_user">
				<?php echo "$TEXT_VISITOR_TYPE_CASUAL_USER" ?>
			</label>
			<input value="guest user" type="radio" name="type" id="guest_user" />
			<label class="type" for="guest_user">
				<?php echo "$TEXT_VISITOR_TYPE_GUEST_USER" ?>
			</label>
			<input value="volunteer" type="radio" name="type" id="volunteer" />
			<label class="type" for="volunteer">
				<?php echo "$TEXT_VISITOR_TYPE_VOLUNTEER" ?>
			</label>
		</div>
	</div>
	<div class="actions">
		<button type="reset"><?php echo "$TEXT_CLEAR" ?></button>
		<button type="submit" name="login" OnClick="return checkWholeForm(newvisitor);"><?php echo "$TEXT_SIGN_IN" ?></button>
	</div>
</form>
	</div>
	</div>
	<h3><?php echo $TEXT_EXIT ?></h3>
	<div>
	<div class="centered-flow-block centered-flow-block-column">
	<form name="leave">
	<p>
	<button type="button" onclick="javascript:logoutload()"><?php echo "$TEXT_SIGN_OUT_LEAVE" ?></button>
	</p>
	</form>
	<p class="note">
		<?php echo $TEXT_NOTE ?> : <?php echo $TEXT_TO_SIGN_OUT_LEAVE_YOU_DONT_HAVE_TO_FILL_IN_THE_FORM ?>
	</p>
	</div>
	</div>
</div>
</body>
</html>
