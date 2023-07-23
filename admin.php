<?php
/*
   T.C.E.D.I. Open Visitors Management System
   Copyright (c) 2016-2023 by T.C.E.D.I. (Jean-Denis Tenaerts)

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

// admin page for reporting and database creation and administration
// page should be password protected with any format currently using
// .htacces file with un/pw of admin:admin

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

include 'database.php';

//set default sort by if none in url
$returnRows = "50";
$sort = "DESC";
$qDate = $sqldate;
$query_mod = " ORDER BY inDate $sort LIMIT $returnRows";

//sql Injection removal
function SecureStringForDB($data)
{
	global $database_link;
        // apply stripslashes if magic_quotes_gpc is enabled
	if(function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc())
	{
		$data = stripslashes($data);
	}
	// a mySQL connection is required before using this function
	$data = mysqli_real_escape_string($database_link, $data);
	return $data;
}

//check URL for return row length
if(isset($_GET["rows"]) && !empty($_GET["rows"])) {$returnRows = $_GET["rows"];}
//check URL for qdate
if(isset($_GET["qdate"]) && !empty($_GET["qdate"])) {$qDate = rawurldecode($_GET["qdate"]);}
// check URL for sort order on displaying sql data
if(isset($_GET["sort"]) && !empty($_GET["sort"])) {$sort = ($_GET["sort"]=="ASC") ? "DESC" : "ASC";}
//set sort by column from URL
if( isset($_GET["orderBy"]) && !empty($_GET["orderBy"]) ) {switch ($_GET["orderBy"]) {
  case 2:
      $query_mod = " ORDER BY lastName $sort LIMIT $returnRows";
      break;
  case 3:
      $query_mod = " ORDER BY Company $sort LIMIT $returnRows";
      break;
   case 4:
      $query_mod = " ORDER BY Visiting $sort LIMIT $returnRows";
      break;
   case 5:
      $query_mod = " ORDER BY legal $sort LIMIT $returnRows";
      break;
   case 6:
      $query_mod = " ORDER BY location $sort LIMIT $returnRows";
      break;
  default:
      $query_mod = " ORDER BY inDate $sort LIMIT $returnRows";
      break;
} } 

// database view report function
function RunReport($sqlQ) {

global $database_link;
global $sort;
global $returnRows;
global $sDefaultLanguage;

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

//check URL for return row length
if(isset($_GET["rows"]) && !empty($_GET["rows"])) {$returnRows = $_GET["rows"];}
//check URL for qdate
if(isset($_GET["qdate"]) && !empty($_GET["qdate"])) {$qDate = rawurldecode($_GET["qdate"]);}
// check URL for sort order on displaying sql data
if(isset($_GET["sort"]) && !empty($_GET["sort"])) {$sort = ($_GET["sort"]=="ASC") ? "DESC" : "ASC";}
//set sort by column from URL
if( isset($_GET["orderBy"]) && !empty($_GET["orderBy"]) ) {switch ($_GET["orderBy"]) {
  case 2:
      $query_mod = " ORDER BY lastName $sort LIMIT $returnRows";
      break;
  case 3:
      $query_mod = " ORDER BY companyName $sort LIMIT $returnRows";
      break;
   case 4:
      $query_mod = " ORDER BY visiting $sort LIMIT $returnRows";
      break;
   case 5:
      $query_mod = " ORDER BY legal $sort LIMIT $returnRows";
      break;
   case 6:
      $query_mod = " ORDER BY location $sort LIMIT $returnRows";
      break;
  default:
      $query_mod = " ORDER BY inDate $sort LIMIT $returnRows";
      break;
} } 

echo "$TEXT_REPORT_RUN_ON ";
echo date("Y-m-d H:i:s");
echo "\n&emsp;";
echo '<a href="javascript:window.location.reload(true)">'.$TEXT_REFRESH.'</a>';
echo "<br><br>$TEXT_QUERY $sqlQ<br>";
//pull data for table view
$result = mysqli_query($database_link, $sqlQ);

if (!$result) {
    die("$TEXT_ONE_ERROR_HAS_OCCURED_WHILE_RUNNING_THE_REPORT_QUERY");}

$fields_num = mysqli_num_fields($result);
echo "<table style=\"font-family: verdana; font-size: 10px; border: none;height: 5; width: 100%; \"><tr>";
echo "<TH ALIGN='left'>$TEXT_VISITOR_ID</TH>";
echo "<TH ALIGN='left'><a href='admin.php?".http_build_query(array_merge($_GET, array("orderBy"=>6, "sort"=>$sort)))."'>$TEXT_LOCATION</a></TH>";
echo "<TH ALIGN='left'>$TEXT_FIRST_NAME</TH>";
echo "<TH ALIGN='left'><a href='admin.php?".http_build_query(array_merge($_GET, array("orderBy"=>2, "sort"=>$sort)))."'>$TEXT_LAST_NAME</a></TH>";
echo "<TH ALIGN='left'><a href='admin.php?".http_build_query(array_merge($_GET, array("orderBy"=>3, "sort"=>$sort)))."'>$TEXT_COMPANY_NAME</a></TH>";
echo "<TH ALIGN='left'><a href='admin.php?".http_build_query(array_merge($_GET, array("orderBy"=>4, "sort"=>$sort)))."'>$TEXT_VISIT_REASON</a></TH>";
echo "<TH ALIGN='left'>$TEXT_EMAIL</TH>";
echo "<th align='left'>$TEXT_VEHICLE_ON_SITE</th>";
echo "<th align='left'>$TEXT_LICENSE_PLATE</th>";
echo "<TH ALIGN='left'><a href='admin.php?".http_build_query(array_merge($_GET, array("orderBy"=>5, "sort"=>$sort)))."'>$TEXT_HAS_SIGNED</a></TH>";
echo "<TH ALIGN='left'><a href='admin.php?".http_build_query(array_merge($_GET, array("orderBy"=>1, "sort"=>$sort)))."'>$TEXT_ARRIVAL</a></TH>";
echo "<TH ALIGN='left'>$TEXT_DEPARTURE</TH>";
echo "<TH ALIGN='left'>$TEXT_GONE</TH>";

// printing table rows
while($row = mysqli_fetch_row($result))
{
    echo "<tr>";
    // $row is array... foreach( .. ) puts every element
    // of $row to $cell variable
    foreach($row as $cell)
        echo "<td>$cell</td>";
    echo "</tr>\n";
}
mysqli_free_result($result);
echo "</table>\n";
  } //end run report function



// check URL POST for commands from database managment tab
if (isset($_POST['delete']) && $_POST['delete'] == "yes") {
// Delete database
if (!mysqli_query($database_link,"DELETE FROM $table"))
die("$TEXT_ERROR_CANNOT_DELETE_TABLE_CONTENT ". mysqli_error($database_link));
if (!mysqli_query($database_link,"ALTER TABLE $table AUTO_INCREMENT = 1"))
die("$TEST_ERROR_CANNOT_RESET_AUTO_INCREMENT_COUNTER ". mysqli_error($database_link));
}
if (isset($_POST['checkout']) && $_POST['checkout'] == "yes") {
// clear sign-out flags
if (!mysqli_query($database_link,"UPDATE $table SET SignOutFlag=1, outDate='didnt check out' WHERE SignOutFlag=0 ORDER by inDate DESC"))
die("$TEXT_ERROR_IMPOSSIBLE_TO_SET_ALL_CHECK_OUT_FLAGS ". mysqli_error($database_link));
} 

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo "$shortname - $TEXT_ADMINISTRATION_PAGE - $TEXT_TCEDI_OPEN_VISITORS_MANAGEMENT_SYSTEM"; ?></title>
<meta http-equiv="Expires" content="Tue, 01 Jan 2000 12:12:12 GMT">
<meta http-equiv="Pragma" content="no-cache">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" sizes="16x16 32x32 64x64"/>
<link rel="stylesheet" type="text/css" href="visitors.css">
<link href="jquery/css/jquery-ui.min.css" rel="stylesheet">
<link href="jquery/css/jquery-ui.theme.min.css" rel="stylesheet">
<script type="text/javascript" src="jquery/js/jquery.min.js"></script>
<script type="text/javascript" src="jquery/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="jquery/js/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript">
  $(function() {
    $( "#tabs" ).tabs();
  });
  
  $(function() {
    $( "#accordion" ).accordion({
	heightStyle: "content"
	});
  });
</script>
<script type="text/javascript">
<!--
function UpdateQuery() {
//which date box is checked
qdate = document.query.singleday.value;
var val = 0;
for( i = 0; i < document.query.dates.length; i++ )
{
	if( document.query.dates[i].checked == true )
		val = document.query.dates[i].value;
}
if(val=='All')
{
	qdate = encodeURI("%");
}
if(val=='Single')
{
	qdate = encodeURI(document.query.singleday.value);
}
if(val=='Range')
{
	sfromdate = encodeURI(document.query.datebegin.value);
	stodate = encodeURI(document.query.dateend.value);
}
//find rows
rowreturn = document.query.MaxRows.options[document.query.MaxRows.selectedIndex].value;
//reload document
if(val!='Range')
{
  vdate = "&qdate=" + qdate;
}
else
{
  vdate = "&fromdate=" + sfromdate + "&todate=" + stodate;
}
sselect = "&select=" + val;
page = "admin.php?language=<?php echo "$sLanguage"; ?>&orderBy=1&sort=ASC&rows=" + rowreturn + vdate + sselect;
//reload page with options
self.location = page;
}
-->
</script>
</head>
<body>
<div class="visitors">
<h1><?php echo "$shortname - $TEXT_ADMINISTRATION_PAGE - $TEXT_TCEDI_OPEN_VISITORS_MANAGEMENT_SYSTEM"; ?></h1>
<p> </p>
</div>
<p> </p>
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
?>
<div id="tabs">
	<ul>
		<li><a href="#tabs-1"><?php echo "$TEXT_REPORTS"; ?></a></li>
		<li><a href="#tabs-2"><?php echo "$TEXT_DATA_BASE_ADMINISTRATION"; ?></a></li>
	</ul>
<div id="tabs-1">
<form name="query" action="admin.php" method="post">
<p>
<?php echo "$TEXT_GO_TO"; ?>
&nbsp;
<a href="main.php"><?php echo "$TEXT_MAIN_PAGE"; ?></a>
&emsp;
<a href="reception-view.php?language=<?php echo "$sLanguage"; ?>"><?php echo "$TEXT_RECEPTION_VIEW_PAGE"; ?></a>
<br>
<br><?php echo "$TEXT_NOTE_ABOUT_INPUT_VALIDATION"; ?>
</p>
<fieldset class="filterFieldset">
<legend class="smallLegendHeader">
<?php echo "$TEXT_DATES"; ?>
</legend>
<div>
<?php
$sDefaultSelectOption = "Single";
if(isset($_GET["select"]) && !empty($_GET["select"]))
{
	$sSelectOption = $_GET["select"];
}
else
{
	$sSelectOption = $sDefaultSelectOption;
}

if($sSelectOption === "All")
{
	$sChecked = "checked ";
}
else
{
	$sChecked = "";
}
?>
<input type="radio" <?php echo "$sChecked"; ?> value="All"  name="dates" id="alldates" onclick="UpdateQuery()">
<?php echo "$TEXT_ALL_DATES"; ?>
</div>
<div>
<?php
if($sSelectOption === "Single")
{
	$sChecked = "checked ";
}
else
{
	$sChecked = "";
}
?>
<input type="radio" name="dates" id="singledate" <?php echo "$sChecked"; ?> value="Single" onclick="UpdateQuery()">
<?php echo "$TEXT_SINGLE_DAY"; ?>
&emsp;
<?php echo "$TEXT_DATE"; ?>
<?php
  if($qDate === "%")
  {
    $sSingleDate = $sqldate;
  }
  else
  {
    $sSingleDate = $qDate;
  }
?>
<input type="text" id="singleday" value="<?php echo "$sSingleDate"; ?>" onchange="UpdateQuery()" >
   <span class="fieldHint"> (<?php echo "$TEXT_SINGLE_DAY_HINT $sqldate"; ?>)</span>
</div>
<div>
<?php
if($sSelectOption === "Range")
{
	$sChecked = "checked ";
}
else
{
	$sChecked = "";
}
?>
<input type="radio" name="dates" id="daterange" <?php echo "$sChecked"; ?> value="Range" onclick="UpdateQuery()">
<?php echo "$TEXT_DATE_RANGE"; ?>
&emsp;
<?php echo "$TEXT_FROM"; ?>
<?php
  if(isset($_GET["fromdate"]) && !empty($_GET["fromdate"]))
  {
    $sFromDate = rawurldecode($_GET["fromdate"]);
  }
  else
  {
    $sFromDate = $sqldate;
  }
?>
<input type="text" id="datebegin" value="<?php echo "$sFromDate"; ?>" size="20" onchange="UpdateQuery()">
&nbsp;
<?php echo "$TEXT_TO"; ?>
<?php
  if(isset($_GET["todate"]) && !empty($_GET["todate"]))
  {
    $sToDate = rawurldecode($_GET["todate"]);
  }
  else
  {
    $sToDate = $sqldate;
  }
?>
<input type="text" id="dateend" value="<?php echo "$sToDate"; ?>" size="20" onchange="UpdateQuery()">
</div>
</fieldset>
<fieldset class="filterFieldset">
<legend class="smallLegendHeader">
<?php echo "$TEXT_MAX_ROWS_TO_DISPLAY"; ?>
</legend>
<div>
      <select size="1" id="MaxRows" style="width:250px" onchange="UpdateQuery(MaxRows)">
	  <?php
		$aNumberOfRows = array(25, 50, 100, 500, 1000, 5000, 10000);
		$iDefaultNumberOfRows = 50;
		
		if(isset($_GET["rows"]) && !empty($_GET["rows"]))
		{
			if(!is_numeric($_GET["rows"]))
				die("$TEXT_ERROR_NON_NUMERIC_VALUE");
			
			if((string)$_GET["rows"] !== (string)(int)$_GET["rows"])
				die("$TEXT_ERROR_NON_INTEGER_VALUE");
			$iSelectedNumberOfRows = (int)$_GET["rows"];
		}
		else
		{
			$iSelectedNumberOfRows = $iDefaultNumberOfRows;
		}
		
		foreach ($aNumberOfRows as $iNumberOfRows)
		{
			if($iNumberOfRows === $iSelectedNumberOfRows)
			{
				$sSelected = "selected ";
			}
			else
			{
				$sSelected = "";
			}
			
			echo "<option $sSelected value=\"$iNumberOfRows\">$iNumberOfRows</option>\n";
		}
	  ?>
      </select>
</div>
</fieldset>
</form>


<div id="accordion">
<h3><?php echo "$TEXT_VISITORS_IN_FACILITY"; ?></h3>
<div>
<?php
// sending query for HTML print
if($sSelectOption !== "Range")
{
  RunReport("SELECT * FROM {$table} WHERE `inDate` like '".SecureStringForDB($qDate)."%' AND SignOutFlag=0 $query_mod");
}
else
{
  RunReport("SELECT * FROM {$table} WHERE CAST(`inDate` AS DATE) BETWEEN CAST('".SecureStringForDB($sFromDate)."' AS DATE) AND CAST('".SecureStringForDB($sToDate)."' AS DATE) AND SignOutFlag=0 $query_mod");
}
?>
</div>
<h3><?php echo "$TEXT_ALL_VISITORS"; ?></h3>
<div>
<?php
// sending query for HTML print
if($sSelectOption !== "Range")
{
  RunReport("SELECT * FROM {$table} WHERE `inDate` like '".SecureStringForDB($qDate)."%' $query_mod");
}
else
{
  RunReport("SELECT * FROM {$table} WHERE CAST(`inDate` AS DATE) BETWEEN CAST('".SecureStringForDB($sFromDate)."' AS DATE) AND CAST('".SecureStringForDB($sToDate)."' AS DATE) $query_mod");
}
?>
</div>

</div>
</div>
<div id="tabs-2">


 <form name="admintasks" action="admin.php" autocomplete="off" method="post">
    <p>
<?php echo "$TEXT_GO_TO"; ?>
&nbsp;
<a href="main.php"><?php echo "$TEXT_MAIN_PAGE"; ?></a>
&emsp;
<a href="reception-view.php?language=<?php echo "$sLanguage"; ?>"><?php echo "$TEXT_RECEPTION_VIEW_PAGE"; ?></a>
<br>
<br>
<strong><?php echo "$TEXT_ADMIN_SETTINGS_WARNING"; ?></strong>
<br><br>

<input type="checkbox" name="checkout" value="yes"><?php echo "$TEXT_SET_ALL_CHECK_OUT_FLAGS"; ?><br>

<input type="checkbox" name="delete" value="yes"><?php echo "$TEXT_DELETE_ALL_RECORDS_AND_RESET_AUTO_INCREMENT_COUNTER"; ?><br>
<br>
    <input type="submit" value="<?php echo "$TEXT_APPLY_CHANGES"; ?>"> <input type="reset" value="<?php echo "$TEXT_RESET_SELECTIONS_ABOVE"; ?>">
    </p>
 </form>
</div>
</div>
</body>
</html>
