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
$name = isset($_GET["name"]) ? trim($_GET["name"]) : '';
$type = isset($_GET["type"]) ? trim($_GET["type"]) : '';
$number = isset($_GET["number"]) ? trim($_GET["number"]) : '';
$message = $name && $type && $number ? 'Please check if your Membership Number or Phone Number is correct' : '';
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
/* END translations support section */

echo "<title>$companyname</title>"; ?>
<meta http-equiv="Expires" content="Tue, 01 Jan 2000 12:12:12 GMT">
<meta http-equiv="Pragma" content="no-cache">
<script type="text/javascript">
$(document).ready(function(){
	$('#signin_form').validate({
		rules: {
			name: {
				required: true,
			},
			number: {
				required: true,
				membershipNumberOrPhoneNumber: true
			},
			type: {
				required: true
			}
		},
		messages: {
			type: {
				required: "Please select visitor type"
			}
		},
		errorPlacement: function(error, element) {
			if (element.attr("name") === "type") {
				$('.types').append(error);
			} else {
				error.insertAfter(element);
			}
		},
		ignore: [],
	});

	$(document).on('keyup', '[name="number"]', function(){
		$('#wrong_number').remove();
	});

	$(document).on('change', '[name="type"]', function(){
		$('[name="login"]').trigger('click');
	});
});
</script>
</head>
<body>
<div id="warning"><script type="text/javascript"><!-- // --> </script>
<noscript><p>$TEXT_JAVASCRIPT_SUPPORT_REQUIRED</p></noscript></div>
<div class="greeting">
	<!-- Welcome to Makerspace, Please sign in -->
For volunteer use only
</div>
<form class="form" id="signin_form" action="process.php" autocomplete="off" method="post" name="newvisitor">
	<div class="table-row">
		<label>Name (First and Last)</label>
		<input placeholder="Tap here to enter"  required type="text" name="name" autocomplete="off" maxlength="255" value="<?php echo $name ?>">
	</div>
	<div class="table-row">
		<label>Membership Number or Phone Number</label>
		<input placeholder="Tap here to enter"  class="<?php echo $message ? 'error' : '' ?>" required type="number" min="0" inputmode="numeric" pattern="[0-9]*" name="number" autocomplete="off" maxlength="10"  value="<?php echo $number ?>">
		<label id="wrong_number" class="error"><?php echo $message ?></label>
	</div>
	<div class="table-row">
		<label>Visitor Type</label>
		<div class="types">
			<!--<input value="member" type="radio" name="type" required id="member" />
			<label for="member" class="type">
				Member
			</label>
			<input value="casual" type="radio" name="type" id="casual_user" />
			<label class="type" for="casual_user">
				Casual
			</label>
			<input value="guest" type="radio" name="type" id="guest_user" />
			<label class="type" for="guest_user">
				Guest
			</label>-->
			<input value="volunteer" type="radio" name="type" id="volunteer" />
			<label class="type" for="volunteer">
				Volunteer
			</label>
		</div>
	</div>
	<div class="actions">
		<button type="reset" onclick="window.location='main.php'">Clear</button>
		<button type="submit" name="login">Sign In</button>
	</div>
</form>
<div class="separator">
	<span>OR</span>
</div>
<div class="centered-flow-block centered-flow-block-column">
<button type="button" onclick="window.location='signout.php'">Sign-out / Leave</button>
<p class="note">
	To "Sign-out / Leave", you don't have to fill in the entrance form above.
</p>
</div>
</body>
</html>
