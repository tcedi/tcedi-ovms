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
$(document).ready(function(){
	$('#number').focus();

	$('#signout_form').validate({
		rules: {
			number: {
				required: true,
				membershipNumberOrPhoneNumber: true
			}
		}
	});
});
</script>
</head>
<body>
<div class="signout">
  <h1><?php echo "$TEXT_THANKS_FOR_VISITING $shortname"?></h1>
  <form action="process.php?language=<?php echo "$sLanguage"?>" autocomplete="off" method="post" name="oldvisitor" id="signout_form">
    <div class="table-row">
      <label><?php echo "$TEXT_ENTER_THE_NUMBER"?></label>
      <input require id="number" type="text" name="number" autocomplete="off">
    </div>
    <div class="actions">
      <button type="button" class="secondary" onClick="window.location='main.php'">Cancel</button>
      <button type="submit" name="logout">Sign Out</button>
    </div>
  </form>
</div>
</body>
</html>
