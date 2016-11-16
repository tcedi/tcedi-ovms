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

// Sign-out page.
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

echo "<title>$TEXT_SIGN_OUT - $companyname</title>";
?>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" sizes="16x16 32x32 64x64"/>
<link href="jquery/css/jquery-ui.min.css" rel="stylesheet">
<link href="jquery/css/jquery-ui.theme.min.css" rel="stylesheet">
<script type="text/javascript" src="jquery/js/jquery.min.js"></script>
<script type="text/javascript" src="jquery/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="jquery/js/jquery-migrate-1.2.1.min.js"></script>
<?php
if($bEnableVirtualKeyboard === true)
{
echo '
<!-- keyboard widget css & script (required) -->
<link href="virtualkeyboard/css/keyboard.min.css" rel="stylesheet">
<script type="text/javascript" src="virtualkeyboard/js/jquery.keyboard.min.js" charset="utf-8"></script>
<script type="text/javascript" src="virtualkeyboard/layouts/numsmall.js" charset="utf-8"></script>
';
}
?>

<script>
  $(function() {
    $( "input[type=submit], input[type=reset], input[type=button]" )
      .button();
  });
</script>

<link rel="stylesheet" type="text/css" href="visitors.css">
<script type="text/javascript" src="validation.js"></script>
<SCRIPT type="text/javascript">
//client side input validation
function checkWholeForm(theForm) {
    var why = "";
    why += checkNumber(theForm.badgeID.value);
    if (why != "") {
       alert(why);
       return false;
alert(error);
    }
return true;
}
</script>
</head>
<body>
<div class="signout">
<h1><?php echo "$TEXT_THANKS_FOR_VISITING $shortname"?></h1>
<h2><?php echo "$TEXT_ENTER_THE_NUMBER_OF_YOUR_BADGE"?></h2>
<form action="process.php?language=<?php echo "$sLanguage"?>" autocomplete="off" method="post" name="oldvisitor" onsubmit="return checkWholeForm(this)">
<p>
<div class="centered-flow">
<div class="centered-flow-block">
<div class="table">
	<div class="table-row">
		<div class="table-cell">
			<p class="set-font-size"><?php echo $TEXT_BADGE_ID_NUMBER ?></p>
		</div>
		<div class="table-cell">
			<input class="set-font-size" id="badgeidnum" type="text" name="badgeID" placeholder="<?php echo $TEXT_ENTER_YOUR_BADGE_ID_NUMBER ?>" autocomplete="off">
<?php
if($bEnableVirtualKeyboard === true)
{
echo '
			<script type="text/javascript">
				$(\'#badgeidnum\')
				.keyboard({ layout: \'numsmall\', autoAccept: true })
				.addTyping();
			</script>
';
}
?>
		</div>
	</div>
</div>
</div>
</div>
<input type="submit" name="logout" value="<?php echo $TEXT_SIGN_OUT_FOR_THE_DAY ?>"> 
<input type="button" value="<?php echo $TEXT_CANCEL ?>" onClick="window.location='main.php'">
</p>
</form>
</div>
</body>
</html>
