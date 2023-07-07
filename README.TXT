=======================================================================================================
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

Please see NOTICE file for details about portions of code from other sources and third-party libraries
used in this software.
=======================================================================================================

Web based visitors management system for enterprise internal use.

FEATURES
- Visitor check-in;
- Visitor badge direct printing;
- Visitor check-out;
- Optional integration with Joomla contacts;
- Virtual keyboard for touch screens (may be enabled/disabled from settings);
- Monitoring of visitors in facility for receptionist;
- check-out on behalf of a visitor who forgot to check-out for receptionist;
- Search/basic reporting for administrator;

SYSTEM REQUIREMENTS FOR SERVER SIDE
- Apache 2.2, Apache 2.4 or newer (should also work with other HTTP servers like Nginx or IIS [compatibility with IIS confirmed by users]);
- PHP 5.6, PHP 7 or newer (should also work with older versions of PHP 5, but they are not supported anymore...);
- MySQL 5.5, MySQL 5.7 or newer (should also work with older versions of MySQL 5, but they are not supported anymore...);

SYSTEM REQUIREMENTS FOR CLIENTS SIDE
- Modern browser supporting HTML 5 with Ecmascript (Javascript) enabled;

SYSTEM REQUIREMENTS FOR LABELS PRINTING
- DYMO LabelWriter 450/DYMO LabelWriter 450 Turbo or compatible DYMO LabelWriter printer with 99012 labels, if you wish to use the existing Badge template as is.
- IPP server must be used for sharing the printer (only tested with CUPS), but should also work with IPP network label printers. Of course, a linux client can be used as IPP server or if you use a Windows client, you can use a rasperry Pi, other a card board, or a virtual machine with Linux to share the printer with CUPS.

ABOUT

T.C.E.D.I. Open Visitors Management System allows visitors to check-in from web client front end.
Depending on the configuration, the visitors may be required to sign a non-disclosure agreement with your company.
Once the visitor has performed check-in and signed the non-disclosure agreement (if required), a visitor badge is
automatically printed on a label printer by the system.
For the visitors (main.php) and receptionist (reception-view.php) front ends, data base user needs the rights to add (INSERT) and modify (UPDATE) records, but 
no need to remove (DELETE) or execute (EXECUTE).
For administrator frontend (admin.php), data base user needs the right to remove (DELETE) for using the feature to clear the database.

htaccess.dist file (basis for an .htaccess file) is included for Apache.

INSTALL

- Uncompress the archive into a directory and edit "settings.php" variables for your company.
- Replace the image "badgelogo.jpg" by the logo of your company. The image should be of size 188x136 and in grayscale.
- [Can be done later] If you use an Apache server, you should use "htaccess.dist" as a basis to create your own ".htaccess" file. If you use another HTTP server, use "htaccess.dist" as a hint for securing accesses to administration and reception view pages.
- [If you've set $bShowAdditionalMessageBeforeBadgePrint to true], edit "messagebeforeprinttemplate.html" (or use one of the Sample templates provided as a basis) with your favourite editor in "languages -> LanguageName" sub-folders, for every language you wish to use.
- If you are not going to use Dymo 99012 Large Address Labels with a compatible Dymo LabelWriter printer, you should adapt badgetemplate.php (or use one of the Sample templates provided as a basis) with your favourite text editor in "languages -> LanguageName" sub-folders, for every language you wish to use. For more details on FPDF use, please consult "./fpdf/doc/index.htm".
- Then, upload these files to your web server.
- You should then create a database "CREATE DATABASE IF NOT EXISTS visitors CHARACTER SET utf8 COLLATE utf8_unicode_ci;" and a user (visitors or else) to access it (minimum privileges: SELECT, INSERT, UPDATE). If you wish to use "install.php" to create the table, CREATE and ALTER rights are also required (at least for setup).
- Once the database and user are created and configured (of course these ones must match your configuration in "settings.php"), you can either enter the address of "install.php" in your browser or  create the table manually:

CREATE TABLE IF NOT EXISTS visitors 
(
 visitorID int(10) NOT NULL AUTO_INCREMENT,
 PRIMARY KEY(visitorID),
 Location VARCHAR(50),
 FirstName VARCHAR(255),
 LastName VARCHAR(255),
 Company VARCHAR(255),
 Visiting VARCHAR(255),
 Email VARCHAR(255),
 vehicleonsite INTEGER,
 licenseplate VARCHAR(25),
 Legal VARCHAR(10),
 inDate VARCHAR(30),
 outDate VARCHAR(30),
 SignOutFlag Binary 
);

- The setup is now finished, you can use your browser to access T.C.E.D.I. Open Visitors Management System.

UPGRADE

- Uncompress the archive into a directory and edit "settings.php" variables for your company using your current "settings.php" as a basis.
- [For upgrade from the original version of phpVisitorBadge] Replace the image "badgelogo.jpg" by the logo of your company. The image should be of size 188x136 and in grayscale.
- [Can be done later] If you use an Apache server, you should use "htaccess.dist" as a basis to create your own ".htaccess" file. If you use another HTTP server, use "htaccess.dist" as a hint for securing accesses to administration and reception view pages.
- [If you've set $bShowAdditionalMessageBeforeBadgePrint to true], edit "messagebeforeprinttemplate.html" (or use one of the Sample templates provided as a basis) with your favourite editor in "languages -> LanguageName" sub-folders, for every language you wish to use. If your are currently using phpVisitorBadge Enhanced, you can reuse a part of the content of "messagebeforeprinttemplate.html" to prepare the new version of the file.
- If you are not going to use Dymo 99012 Large Address Labels with a compatible Dymo LabelWriter printer, you should adapt badgetemplate.php (or use one of the Sample templates provided as a basis) with your favourite text editor in "languages -> LanguageName" sub-folders, for every language you wish to use. For more details on FPDF use, please consult "./fpdf/doc/index.htm".
- Then, upload these files to your web server.
- You should then use the appropriate SQL upgrade script to perform the required changes to your current database. If you are using phpVisitorBadge Enhanced, you should use "SQL Upgrade Script from phpVisitorBadge Enhanced 2.00 BETA 8.sql". If you are using phpVisitorBadge, you should use "SQL Upgrade Script from phpVisitorBadge.sql". Some changes may have to be applied to the scripts to match your current setup, before upgrade. Please ensure that the user you'll use to perform the upgrade has enough rights.

TRANSLATIONS

- To create a new translation, you just have to make a copy of the "English" sub-folder inside "languages" folder and rename it into the destination language name (without special character).
- Then translate the values in all PHP files (please follow the instructions, if available) ;
- Then translate the content of all HTML files (please follow the instructions, if available) ;
- Finally replace the image "lang.png" by the flag(s) corresponding to the language of the translation. The image should be of size 300x160 in colors (RGB).

If you wish to remove/disable a translation, move or cut and paste the folder containing the translation outside "languages" folder. For example, in a new folder named "disabled-languages".

FULL DATABASE CREATION SCRIPT


CREATE DATABASE IF NOT EXISTS visitors CHARACTER SET utf8 COLLATE utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS visitors 
(
 visitorID int(10) NOT NULL AUTO_INCREMENT,
 PRIMARY KEY(visitorID),
 Location VARCHAR(50),
 FirstName VARCHAR(255),
 LastName VARCHAR(255),
 Company VARCHAR(255),
 Visiting VARCHAR(255),
 Email VARCHAR(255),
 vehicleonsite INTEGER,
 licenseplate VARCHAR(25),
 Legal VARCHAR(10),
 inDate VARCHAR(30),
 outDate VARCHAR(30),
 SignOutFlag Binary 
);



RELEASE HISTORY

Legend:

[+] = Added
[*] = Changed
[#] = Fixed
[-] = Removed
[?] = Information


T.C.E.D.I. Open Visitors Management System 0.15 ()

[?] All the changes below were backported from 0.20 (development) branch.
[*] "NOTICE" file has been updated to reflect the removal of obsolete files.
[-] Obsolete validation.js file has been removed.
[-] validation.js is not used in signout.php anymore.
[+] New translations for badge ID number check texts added for signout.php (English and French).
[+] CheckUnsignedIntegerString JavaScript function added in signout.php.
[-] validation.js is not used in main.php anymore.
[+] New translations for e-Mail address check texts added for main.php (English and French).
[+] CheckEMailAddress JavaScript function added in main.php.

T.C.E.D.I. Open Visitors Management System 0.10 (2016-11-16)

[+] It is now possible to show or hide the link to the reception view page (reception-view.php) in the footer of the main page (main.php) from settings.php (parameter).
[+] It is now possible to show or hide the link to the administration page (admin.php) in the footer of the main page (main.php) from settings.php (parameter).
[+] Some indications have been added in "README.TXT" to improve clarity of the content.
[*] Several small changes have been performed in "README.TXT" to improve clarity of the content.
[#] Some typos in "README.TXT" have been fixed.
[*] "NOTICE" file has been updated to reflect the removal of obsolete files.
[-] Obsolete "tabber.js" file has been removed.
[-] Obsolete "tab.css" file has been removed.


T.C.E.D.I. Open Visitors Management System 0.10 Release Candidate 2 (2016-10-11)

[*] If the receptionist is allowed to change location, the default location is now "All locations".
[+] English and French translation added for admin.php.
[+] Translation support added to admin.php.
[*] admin.php has been completely redesigned. It now uses jQuery UI. All the tables have been replaced by DIVs, etc.
[*] Documentation has been improved. System requirements are now available, as well as an updated install procedure, an upgrade procedure, instructions for translations, etc.
[+] htaccess.dist file has been added as a basis for .htaccess file for Apache.
[+] Reception view can now be accessed from main page (main.php).
[+] favicon has been added to the system.
[+] Go to main page button has been added to reception-view.php.
[*] reception-view.php has been redesigned and is now based on bootstrap and responsive.
[*] reception-view.php migrated to HTML5.
[*] reception-view.php converted to UTF-8.
[*] process.php migrated to HTML5.
[*] process.php converted to UTF-8.
[+] Samples for messagebeforeprinttemplate.html.
[*] messagebeforeprinttemplate.html migrated to HTML5.
[*] messagebeforeprinttemplate.html converted to UTF-8.
[*] messagebeforeprint.php migrated to HTML5.
[*] messagebeforeprint.php converted to UTF-8.
[+] About page added.
[*] legaltemplate.html migrated to HTML5.
[*] legaltemplate.html converted to UTF-8.
[*] Places of the informations in the title have been inverted in legal.php.
[*] legal.php migrated to HTML5.
[*] legal.php converted to UTF-8.
[*] install.php migrated to HTML5.
[*] install.php converted to UTF-8.
[+] index.html now shows a message whether JavaScript is not supported or disabled.
[*] index.html migrated to HTML5.
[*] index.html converted to UTF-8.
[*] goodbye.php migrated to HTML5.
[*] goodbye.php converted to UTF-8.
[*] database.php converted to UTF-8.
[+] placeholder support added in order to improve UI friendliness in signout.php.
[#] Auto complete is now also disabled in input fields from the virtual keyboard in signout.php.
[*] signout.php migrated to HTML5.
[*] signout.php converted to UTF-8.
[*] printbadge.php migrated to HTML5.
[*] Variable values are now converted from UTF-8 to ISO-8859-1 in badgetemplate.php files, because FPDF does not support UTF-8, except for SetTitle() with second parameter set to true.
[+] Helper section for FPDF added to badgetemplate.php files.
[*] badgetemplate.php converted to UTF-8.
[+] It is now possible to define the username to use for printing jobs with IPP.
[*] Validity date fallback value is now in ISO format "yyyy-mm-dd".
[+] Date localization support added to printbadge.php. Requires PHP >= 5.3.0 with php_intl extension. Not used if unavailable.
[*] printbadge.php converted to UTF-8.
[*] barriercode.php migrated to HTML5.
[*] barriercode.php converted to UTF-8.
[#] Auto complete is now also disabled in input fields from the virtual keyboard in main.php.
[*] Adapt maxlength attribute for input fields in main.php.
[*] admin.php migrated to HTML5.
[*] admin.php converted to UTF-8.
[*] Places of the informations in the title have been inverted in main.php.
[+] placeholder support added in order to improve UI friendliness in main.php.
[*] main.php converted to UTF-8.
[*] main.php migrated to HTML5.
[+] It is now possible to enable/disable virtual keyboard support from settings.php.
[*] Joomla contacts support should now be compatible with Joomla 1.5 up to 3.x.
[*] accessdenied.html is now based on bootstrap.
[*] accessdenied.html converted to UTF-8.
[*] accessdenied.html migrated to HTML5.
[+] PHP 7 support added.
[+] PHP 5.6 support added.
[-] PHP 4 support dropped.
[*] Upgrade to PHP::PRINT:IPP 0.83.
[*] Migration from MySQL extension to MySQLi.
[*] ereg_replace replaced by preg_replace.


phpVisitorBadge Enhanced 2.00 BETA 8 (2016-04-04)

[*] Version information has been updated.
[+] It is now possible to hide optional e-Mail input field from settings.php


phpVisitorBadge Enhanced 2.00 BETA 7 (2015-05-18)

[#] Some parts of the code have been improved/fixed in order to avoid useless PHP notices in the error log.
[+] Default IPP Printer support added, for use as a fallback.
[+] IPP Printer per client fixed IP array support added.
[+] Flag per language added.
[*] Major UI changes for language selection which are also touch screen friendly have been made.
[*] Major UI improvements for optimizing touch screen support.
[+] jQuery UI with theme support added.
[+] Javascript virtual keyboard added for touch screen support.
[*] Javascript popup based system replaced by a redirection system in the whole frontend, so that no more window can be "hidden" in the background by mistake.


phpVisitorBadge Enhanced 2.00 BETA 4 (2014-07-17)

[*] reception-view.php short php tag form replaced for compatibility with newer versions of PHP.


phpVisitorBadge Enhanced 2.00 BETA 3 (2010-08-25)

[+] table.admin style added to visitors.css.
[+] h1.admin style added to visitors.css.
[*] W3C compatibility improvements have been initiated in admin.php.
[#] DataBaseAdmin form fixed. The form tag was closed twice and one time before any input tag. This was a big problem under Internet Explorer 8.


phpVisitorBadge Enhanced 2.00 BETA 3 (2010-08-23)

[*] process.php updated accordingly for goodbye page support.
[+] Goodbye page (with translations) added. This page is displayed after signout whether the barriercode page is not shown.


phpVisitorBadge Enhanced 2.00 BETA 3 (2010-08-12)

[*] Sorting now also works with date range mode in admin.php.
[*] Small note added for explaining to the users how to validate their input in admin.php.
[*] Small layout improvements to reception-view.php.
[*] Translations for reception-view.php updated.
[+] Link to print the page added to reception-view.php.
[+] Some values (dates) have been secured from SQL injection in admin.php.
[*] SecureStringForDB function added to admin.php.
[+] Date range full support added to admin.php.
[*] Range select mode enabled in admin.php.
[*] When "All Dates" is checked, single day input box value is set back to today in admin.php. Like this when the user switch back to single day mode, he can change the date instead of typing it from scratch.
[+] Automatically checks correct Select mode (All dates, single day, date range) in admin.php.
[*] "MaxRows" options list is now automatically generated and the option choosen by the user is also automatically selected in admin.php.
[*] "MaxRows" options habe been sorted in an ascending way in admin.php.
[+] "5000" and "10000" options have been added to "MaxRows" in admin.php.
[*] "50" option in "MaxRows" from admin.php is now selected by default.
[*] "Select" option in "MaxRows" from admin.php has been removed.
[*] When "Sign out" is used from reception-view.php the window is not closed anymore. Now the page is actualized.
[*] Location change mecanism now uses GET instead of POST in order to avoid annoying confirmations for the receptionist in case of manual refresh.
[-] Automatic page refresh removed from reception-view.php.


phpVisitorBadge Enhanced 2.00 BETA 2 (2010-07-17)

[+] Added accessdenied.html for having the possibility to go back to main.php if the user has not the right to access admin.php (for use with .htaccess sample).
[+] Added very simple .htaccess sample for allowing access to admin.php and reception-view.php only from specified fixed IP addresses.
[*] Some protections against SQL injections added in process.php, etc.
[+] Optional Additional Before Print message with template support (head ignored => only BODY content is retrieved) added.
[+] Simple Barrier Management Integration Support added.
[*] Partial HTML clean up following W3C recommandations within admin.php.
[#] Javascript code of UpdateQuery() in admin.php fixed to also work with IE.
[+] Partial French translation added.
[+] The receptionist can now be allowed to change location.
[+] Legal template support added (head ignored => only BODY content is retrieved).
[+] Integration with Joomla 1.5 contact details added (main.php and settings.php affected).
[*] UI Design of main.php completely rewritten for better and easier visitor experience (visitor.css).
[*] Several fields changed to VARCHAR(255) (Some composed names are very very long).
[+] Two fields added for "Vehicle on site" and "License plate" to the data base.
[+] JavaScripts checks moved to main.php for translation support.
[*] Integrated CSS removed from printbadge.php (design configuration moved to badgetemplate.html translations).
[+] Badge template support added.
[*] Does not update the out date if the user has already performed a sign out anymore.
[*] HTML clean up following W3C recommandations within signout.php.
[#] Fixed some mistakes with HTML elements within signout.php.
[*] First name and last name are asked instead of full name because it is very hard to automatically split names and especially composed names.
[*] Integrated CSS removed from legal.php, main.php, reception-view.php, signout.php and replaced by visitors.css.
[*] HTML clean up following W3C recommandations within main.php.
[#] Fixed some mistakes with HTML elements within main.php.
[+] Very basic multilingual support added to legal.php, main.php, printbadge.php, process.php, reception-view.php, signout.php.


phpVisitorBadge 1.70 (2010-03-29)

[#] repaired some various subnet code
[#] repaired some admin page code for better reporting with dates


phpVisitorBadge 1.10 (2009-11-20)

[+] added injection sanitize code


phpVisitorBadge 1.06 (2009-09-19)

[+] added the sign out ability for receptionist
[#] fixed a bug on signout page


phpVisitorBadge 1.055 (2009-09-15)

[+] added the reception-view.php page for a local view for front desk staff


phpVisitorBadge 1.051 (2009-08-28)

[*] change the table text-wrap for long names
[*] cleaned up badge print


phpVisitorBadge 1.05 (2009-08-07)

[*] cleaned up the GUI


phpVisitorBadge 1.04 (2009-07-28)

[*] more kiosk like with a javascript page load


phpVisitorBadge 1.03 (2009-06-29)

[*] general GUI enhancements
[+] added location key's for multiple sites


phpVisitorBadge 1.02 (2009-06-28)

[*] cleaned up some errors and page display issues
[+] added some warnings if things go bad.
[+] autocomplete="off" added for ease of administration
[+] created a install.php for all database creation and browser settings checks
[*] prevented a refresh, posting last user and re-print of data


phpVisitorBadge 1.01 (2009-06-24)

[#] bug with the URL capture on visitorID with some versions of PHP should now be using a PHP generic call


phpVisitorBadge 1.00 (2009-04-20)

[?] inital release
