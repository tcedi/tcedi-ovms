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

// Front desk or reception view of the database. 

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

require 'database.php';

//sql Injection removal
 function sanitize($data){
global $database_link;
// remove whitespaces (not a must though)
$data = trim($data);
// apply stripslashes if magic_quotes_gpc is enabled
if(get_magic_quotes_gpc()){
	$data = stripslashes($data);
}
// a mySQL connection is required before using this function
$data = mysqli_real_escape_string($database_link, $data);
return $data;
}

if(isset($_POST['logout']))
{
  //change SignOutFlag = 1
  if (!mysqli_query($database_link, "UPDATE $table SET SignOutFlag=1, outDate='$sqltime' WHERE Number='$_POST[number]' ORDER by inDate DESC LIMIT 1"))
  {
    die('!Error: ' . mysqli_error($database_link));
  }
  //echo "<script>self.close();</script>";
  header("Location: ".$_SERVER["REQUEST_URI"]);
} //end if logout


//get IP for Location data
$ip;
if (getenv("HTTP_CLIENT_IP")) $ip = getenv("HTTP_CLIENT_IP"); 
else if(getenv("HTTP_X_FORWARDED_FOR")) $ip = getenv("HTTP_X_FORWARDED_FOR"); 
else if(getenv("REMOTE_ADDR")) $ip = getenv("REMOTE_ADDR"); 
else $ip = "UNKNOWN";

//turn IP into location name
if(stristr($ip, $subnet1) !== FALSE) {$location = $site1; }
else if(stristr($ip, $subnet2) !== FALSE) {$location = $site2; }
else if(stristr($ip, $subnet3) !== FALSE) {$location = $site3; }
else if(stristr($ip, $subnetLH) !== FALSE) {$location = $siteLH; }
else $location = $ip;

if($bAllowReceptionistToChangeLocation === true)
{
	if(isset($_GET["location"]) && !empty($_GET["location"]))
	{
	  $location = sanitize($_GET["location"]);
	}
	else
	{
		//set the location to all locations by default.
		$location = '%';
	}
}

//start report
$returnRows = "50";
$sort = "DESC";
$qDate = $sqldate;
$query_mod = " ORDER BY inDate $sort LIMIT $returnRows";
$query="SELECT visitorID, Name, Number, Type FROM $table WHERE( inDate like '$qDate%' AND Location like '$location') AND SignOutFlag=0 $query_mod";

// sending query
$result = mysqli_query($database_link, $query);
$fields_num = mysqli_num_fields($result);
// printing query
if($location === "%")
{
	$sLocationLabel = $TEXT_ALL_LOCATIONS;
}
else
{
	$sLocationLabel = $location;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php echo "<title>$TEXT_VISITOR_BADGE - $shortname - $TEXT_RECEPTIONIST_VIEW</title>";?>
<meta http-equiv="Expires" content="Tue, 01 Jan 2000 12:12:12 GMT">
<meta http-equiv="Pragma" content="no-cache">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" sizes="16x16 32x32 64x64"/>
<link href="libraries/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<body>
<div class="jumbotron text-center">
<?php echo "<h1>$companyname, $TEXT_VISITOR_VIEW_FOR $sLocationLabel</h1>";?>
</div>
<div class="container">
<div class="row text-center">

<?php
/* BEGIN translations support section */
echo "<p class=\"translation\">".$TEXT_CHOOSE_YOUR_LANGUAGE." ";

$dDirectory = dir("./languages/");
$bFirstTime = true;

while (false !== ($sEntry = $dDirectory->read()))
{
   if($sEntry !== "." && $sEntry !== "..")
   {
	 if($bFirstTime == true)
	 {
	   $bFirstTime = false;
	   $sPrefix = "";
	 }
	 else
	 {
	   $sPrefix = " |";
	 }
	 
     echo $sPrefix." <a href=\"".basename($_SERVER["PHP_SELF"])."?language=".$sEntry."\">".$sEntry."</a>";
   }
}
$dDirectory->close();
echo "</p>";
/* END translations support section */

if($bAllowReceptionistToChangeLocation === true)
{
	echo "
	<form action=\"reception-view.php?language=$sLanguage\" autocomplete=\"off\" method =\"GET\" name=\"changelocation\">
	<p class=\"changelocation\">
		$TEXT_CHANGE_LOCATION :&nbsp;
		<input type=\"hidden\" name=\"language\" value=\"$sLanguage\">
		<select name=\"location\">
	";

	$sRequest = "SELECT DISTINCT Location FROM $table ORDER BY Location ASC";
	$rResults = mysqli_query($database_link, $sRequest);
	while($rRow = mysqli_fetch_array($rResults, MYSQLI_ASSOC))
	{
		$sSelected = "";
		if($rRow['Location'] === $location)
		{
			$sSelected = " selected";
		}
		echo '<option'.$sSelected.' value="'.$rRow['Location'].'">'.$rRow['Location'].'</option>'."\n";
	}

	mysqli_free_result($rResults);

	$sSelected = "";
	if($location === "%")
	{
		$sSelected = " selected";
	}
	echo "
		<option $sSelected value=\"%\">$TEXT_ALL_LOCATIONS</option>
		</select>
		&nbsp;
		<input type=\"submit\" name=\"ok\" value=\"$TEXT_OK\">
	</p>
	</form>
	";
}

echo '<div class="table-responsive">';
echo "<table class=\"table table-striped table-bordered\"><tr>";
// printing table headers
echo "
<th class=\"text-center\">
	$TEXT_ACTION
</th>
<th class=\"text-center\">
	$TEXT_NAME
</th>
<th class=\"text-center\">
	$TEXT_NUMBER
</th>
<th class=\"text-center\">
	$TEXT_TYPE
</th>
";
echo "</tr>\n";
// printing table rows
while($row = mysqli_fetch_row($result)){
$logoutlink = 1;
    echo "<tr>";

    // $row is array... foreach( .. ) puts every element
    // of $row to $cell variable
    //place a logout ontop of each row
	foreach($row as $cell){
	echo "<td>";
	if ($logoutlink == 1) 
		{echo "
<form action=\"reception-view.php?".http_build_query($_GET)."\" autocomplete=\"off\" method=\"POST\" name=\"oldvisitor\">
	<div>
	<input type=\"hidden\" value='".$row[2]."' name=\"number\">
	<input type=\"submit\" name=\"logout\" value=\"$TEXT_SIGN_OUT_FOR_THE_DAY\" OnClick=\"meta:refresh\">
	</div>
</form>
";}
	if ($logoutlink == 0) echo "$cell</td>"; $logoutlink = 0;
	} //foreach
    echo "</tr>\n"; ;
}
echo "</table>";
echo '</div>';
mysqli_free_result($result);
?>
</div>
<div class="container-fluid">
<div class="row text-center">
<div class="col-xs-5 col-sm-4 col-md-4">
<p><a class="btn btn-default btn-lg" href="javascript:window.location.reload(true)"><?php echo "$TEXT_REFRESH";?></a></p>
</div>
<div class="col-xs-7 col-sm-4 col-md-4">
<p><a class="btn btn-primary btn-lg" href="javascript:window.print()"><?php echo "$TEXT_PRINT_PAGE";?></a></p>
</div>
<div class="col-xs-12 col-sm-4 col-md-4">
<p><a class="btn btn-default btn-lg" href="main.php"><?php echo "$TEXT_GO_TO_THE_MAIN_PAGE";?></a></p>
</div>
</div>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="libraries/jquery/js/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="libraries/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
