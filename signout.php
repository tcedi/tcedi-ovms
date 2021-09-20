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

echo "<title>$TEXT_SIGN_OUT - $companyname</title>";
?>
<script type="text/javascript">

<SCRIPT type="text/javascript">
//client side input validation
function checkWholeForm(theForm) {
    var why = "";
    why += checkNumber(theForm.number.value);
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
<form action="process.php?language=<?php echo "$sLanguage"?>" autocomplete="off" method="post" name="oldvisitor" onsubmit="return checkWholeForm(this)">
<p>
<div class="centered-flow">
<div class="centered-flow-block">
<div class="table-row">
    <div class="table-cell-right-align">
			<b><?php echo "$TEXT_ENTER_THE_NUMBER"?></b>
		</div>
		<div class="table-cell-left-align">
			<input require id="number" type="text" name="number" placeholder="<?php echo $TEXT_ENTER_YOUR_NUMBER ?>" autofocus autocomplete="off">
		</div>
	</div>
</div>
</div>
<div class="actions">
  <button type="button" class="secondary" onClick="window.location='main.php'"><?php echo $TEXT_CANCEL ?></button>
  <button type="submit" name="logout"><?php echo $TEXT_SIGN_OUT_FOR_THE_DAY ?></button>
</div>
</p>
</form>
</div>
</body>
</html>
