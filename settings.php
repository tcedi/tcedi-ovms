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

// User variables page called by all pages in application.

// Edit the following for your company.
$db_host = 'localhost';//hostname of MySQL server//
$db_user = 'visitors';//username of MySQL web-app account//
$db_pwd = 'yourpassword';//password of MySQL web-app account//
$database = 'visitors';//MySQL database name for this application//
$table = 'visitors';//MySQL table name in the database//
$companyname = 'Your Company corp.' ;//Your Company Name//
$shortname = 'Your Company' ;//Your Company Short Name ie. IBM for International Business Machines//
$requireLegal = 'yes' ;//Do you want show a non disclosure before badge print//
$bBadgelessMode = false; // Set it to true if you want to enable badgeless mode (no badge will be printed and thus no message will be shown before badge print), false otherwise.
$bShowAdditionalMessageBeforeBadgePrint = true; // Set it to true if you want to display an additional message before the printing of the badge, false otherwise. Very useful to give additional instructions to the visitor.
$bAllowReceptionistToChangeLocation = true; // Set it to true if you want to allow the receptionist to change of location, false otherwise. Very useful if the receptionist must manage several locations and/or if she/he must get access to reception view from her/his computer and not the visitors one !
$bAllowVisitorsToOptionallyEnterTheirEMailAddress = true; // Set it to true if you want to display the optional input field to get the e-Mail address of the visitors, false otherwise.
$bEnableVirtualKeyboard = true; // Set it to true if you want to enable virtual keyboard support for touch screens, false otherwise.
$bShowLinkToAdministrationPage = true; // Set it to true if you wish to show a link to the administration page (admin.php) in the footer of the main page (main.php), false otherwise.
$bShowLinkToReceptionViewPage = true; // Set it to true if you wish to show a link to the reception view page (reception-view.php) in the footer of the main page (main.php), false otherwise.

//following is building site which is stored in database and used in reception view
//sites are top down with the last rule being less spicific. so interesting traffic is 10.0.2.1
//rule 1 would be 10.0.1 and rule 4 would be 10.0 rule 4 would match

//start site copy for more sites
$site1 = 'Washington';//site name for IP subnet 1//
$subnet1 = '192.168.1';//subnet for Reception 1 Location (building) match regex//
//end site copy

$site2 = 'Oregon';//site name for IP subnet 2//
$subnet2 = '172.16.0';//subnet for Reception 2 Location (building) match regex//
$site3 = 'California';//site name for IP subnet 3//
$subnet3 = '10.0.0';//subnet for Reception 3 Location (building) match regex//
$siteLH = 'LocalHost';//site name for IP LocalHost//

/* BEGIN translations support section */
$sDefaultLanguage = 'English'; // Choose the name of the default language.  It must be one of the languages available in the "languages" folder. WARNING : It is case sensitive !
/* END translations support section */

/* BEGIN Joomla 1.5-3.x contacts support section */
$bEnableJoomlaContactsSupport = false; //true to enable Joomla 1.5-3.x contacts support, false to disable it.

// PREREQUISITES :
// The data base of Joomla 1.5-3.x is supposed to be on the same mysql server as the one for T.C.E.D.I. Open Visitors Management System.
// The data base user used to access T.C.E.D.I. Open Visitors Management System data base must have read only (SELECT) access granted on Joomla 1.5-3.x data base.

$sJoomlaDataBase = 'joomla'; // Joomla's data base name.
$sJoomlaTablesPrefix = 'jos_'; // Joomla's tables prefix.
$sJoomlaContactDetailsTable = 'contact_details'; // The name of the contacts table.
$sJoomlaValueToUseAsEmployeeOrServiceConcerned = "CASE WHEN `mobile` IS NOT NULL AND TRIM(`mobile`) <> '' THEN CONCAT(`name`, ' [', SUBSTRING(`telephone` FROM 17 FOR 7), ']', ' - ', `mobile`) ELSE CONCAT(`name`, ' [', SUBSTRING(`telephone` FROM 17 FOR 7), ']') END"; // The value to select for use as employee or service concerned (reason for visit).  Please note that you can't define an alias here. Of course, this value is mandatory !
// Other examples :
// $sJoomlaValueToUseAsEmployeeOrServiceConcerned = "`name`";
// $sJoomlaValueToUseAsEmployeeOrServiceConcerned = "CONCAT(`name`, ' [', `telephone`, ']')";
// $sJoomlaValueToUseAsEmployeeOrServiceConcerned = "CONCAT(`name`, ' [', SUBSTRING(`telephone` FROM 17 FOR 3), ']')";
// $sJoomlaValueToUseAsEmployeeOrServiceConcerned = "CONCAT(`name`, ' [', SUBSTRING(`telephone` FROM 17 FOR 7), ']')";
$sJoomlaContactCategoryIDs = '38, 39'; // If you wish to retrieve several categories of contacts, separates the different IDs with a comma. Example : '38, 25, 9, 23'. Of course, this value is mandatory !
$sJoomlaOmitContactsWithThisTagInMisc = '[DO_NOT_SHOW_TO_VISITORS]'; // Defines the tag you wish to put in "misc" field for the contact to be omitted.
/* END Joomla 1.5-3.x contacts support section */

/* BEGIN Simple Barrier Management support section */
$bEnableSimpleBarrierManagementSupport = false; // true to enable Simple Barrier Management support, false to disable it.

// PREREQUISITES :
// The data base of Simple Barrier Management is supposed to be on the same mysql server as the one for phpVisitorBadge Enhanced Version.
// The data base user used to access phpVisitorBadge data base must have read only (SELECT) access granted on Simple Barrier Management data base.

$sSimpleBarrierManagementDataBase = 'barrier'; // Simple Barrier Management's data base name.
$sSimpleBarrierManagementBarrierCodeTable = 'barrier_code'; // The name of the barrier code table.
/* END Simple Barrier Management support section */

/* BEGIN FPDF specific options section */
$bTryToDefineFpdfFontpathConstant = false; //true to try to define FPDF_FONTPATH constant for FPDF (used for badge printing), false otherwise.
/* END FPDF specific options section */

/* BEGIN Server side printing section */
$sIPPPrinterOrServerHost = '127.0.0.1'; // The host name or the IP address of the IPP Printer or IPP Server.
$sIPPPrinterOrServerPort = '631'; // By default it is set to IANA assigned port (631).
$sIPPPrinterURI = '/printers/DYMO-LabelWriter-450'; // The URI of the IPP printer (examples : '/printers/epson', 'ipp://localhost:631/printers/epson').
$sIPPJobUserName = 'anonymous'; // Depending on the configuration of your printer, you may have to set this to 'anonymous' or a valid username on your system.
$aIPPPrinterPerClientFixedIPArray = array();
$aIPPPrinterPerClientFixedIPArray['192.168.1.20'] = array();
$aIPPPrinterPerClientFixedIPArray['192.168.1.20']['IPPPrinterOrServerHost'] = '192.168.1.20';
$aIPPPrinterPerClientFixedIPArray['192.168.1.20']['IPPPrinterOrServerPort'] = '631';
$aIPPPrinterPerClientFixedIPArray['192.168.1.20']['IPPPrinterURI'] = '/printers/DYMO-LabelWriter-450-Turbo';

$bEnableIPPLogging = true; //true to enable IPP logging, false otherwise.
$sLoggingDestination = ''; // Log destination. Should contain the log file name in case of 'file' logging.
                           // Should be the destination e-Mail address in case of 'e-mail' logging.
                           // Is not used in case of 'logger' logging.
                           // See PHP:Print:IPP documentation and source code for more details.
$sLoggingType = 'logger';  // Log type. It can be 'logger', 'file' or 'e-mail'.
$iLoggingLevel = 2; // Log level.
/* END Server side printing section */

// The following variables should not be edited. These ones are application variables.
$base_url    = "http://".$_SERVER['SERVER_NAME'];
$directory   = $_SERVER['PHP_SELF'];
$script_base = "$base_url$directory";
//$base_path   = $_SERVER['PATH_TRANSLATED'];
$root_path_www = $_SERVER['DOCUMENT_ROOT'];
$remove_end  = strrchr($root_path_www,"/");
$root_path   = preg_replace("$remove_end/", '', $root_path_www);
$root_path_www_ending_with_slash = $root_path_www;
if(strcmp(substr($root_path_www, -1, 1), '/')!==0)
{
    $root_path_www_ending_with_slash = $root_path_www_ending_with_slash.'/';
}
//$url_base    = "$base_url$directory";
//$url_base    = ereg_replace("main.php", '', "$_SERVER[PATH_TRANSLATED]");
$appVer      = '0.15';
$subnetLH = '::1';//subnet for Localhost Location match regex//
?>
