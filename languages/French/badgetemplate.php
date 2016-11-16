<?php
/*
   T.C.E.D.I. Open Visitors Management System
   Copyright (c) 2016 by T.C.E.D.I. (Jean-Denis Tenaerts)

   T.C.E.D.I. Open Visitors Management System is a derivative work based on phpVisitorBadge Enhanced.
   phpVisitorBadge Enhanced
   Copyright (c) 2010-2016 RKW ACE S.A.

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

/*
$sThisCompanyShortName = The name of this company.
$sVisitorBadgeText = The visitor badge text translated into the correct language.
$sBadgePrintAndRetrievalInstructionsText = The text for badge printing and retrieval instructions translated into the correct language.
$sVisitorFirstName = The first name of the visitor.
$sVisitorLastName = The last name of the visitor.
$sCompanyLabelText = The company label text translated into the correct language.
$sVisitorCompany = Visitor's company name.
$sReasonForVisitLabelText = The reason for visit label text translated into the correct language.
$sReasonForVisitValue = The reason for visit value.
$sBadgeIDNumberLabelText = The badge ID number label text translated into the correct language.
$sBadgeIDNumberValue = The badge ID number value.
$sEscortRequiredNDALabelText = The escort required NDA label text translated into the correct language.
$sEscortRequiredNDAValue = The escort required NDA value.
$sValidDateLabelText = The valid date label text translated into the correct language.
$sValidDateValue = The valid date value.
$sPleaseReturnToTheReceptionistAndSignOutOnExitText = The text for asking the visitor to return to the receptionist and sign out on exit translated into the correct language.
*/

/* Badge template designed for Dymo 99012 labels. */
// French localization.

//FPDF does not support UTF-8, except with SetTitle() when its second parameter is set to true.
//So here comes a little helper section to help you build your template.
//To use it, you just have to call the function ConvertUTF_8toISO_8859_1 for each variable you wish to use.
//Example for variable $sVisitorFirstName: ConvertUTF_8toISO_8859_1($sVisitorFirstName, $bIconvAvailable)

//BEGINNING OF FPDF HELPER SECTION.
if(function_exists('iconv'))
{
	$bIconvAvailable = true;
}
else
{
	$bIconvAvailable = false;
}

function ConvertUTF_8toISO_8859_1($sStringToConvert, $bUseIconv = false)
{
	if($bUseIconv)
	{
		return iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $sStringToConvert);
	}
	else
	{
		return utf8_decode($sStringToConvert);
	}
}
//END OF FPDF HELPER SECTION.

// The FPDF_AutoPrint class has to be instanciated here and the $pdf object name can not be changed, because it is used later !

$pdf = new FPDF_AutoPrint('Landscape', 'mm', array(35.73, 88.6));
$pdf->SetTitle($sVisitorBadgeText.' '.$sBadgeIDNumberValue, true);
$pdf->AddPage('Landscape', array(35.73,88.6));
$pdf->SetMargins(0,0);
$pdf->SetAutoPageBreak(true, 0);
$pdf->SetFont('Arial', 'B', 8);
$pdf->SetXY(0,0);
$pdf->Write(4, ConvertUTF_8toISO_8859_1($sThisCompanyShortName, $bIconvAvailable).' - '.ConvertUTF_8toISO_8859_1($sVisitorBadgeText, $bIconvAvailable)."\n");
$pdf->SetFont('Arial', 'B', 12);
$pdf->Write(5, ConvertUTF_8toISO_8859_1($sVisitorFirstName, $bIconvAvailable).' '.ConvertUTF_8toISO_8859_1($sVisitorLastName, $bIconvAvailable)."\n");
$pdf->SetFont('Arial', 'B', 11);
$pdf->Write(5, ConvertUTF_8toISO_8859_1($sCompanyLabelText, $bIconvAvailable).' : '.ConvertUTF_8toISO_8859_1($sVisitorCompany, $bIconvAvailable)."\n");
$pdf->SetFont('Arial', '', 9);
$pdf->Write(4, ConvertUTF_8toISO_8859_1($sReasonForVisitLabelText, $bIconvAvailable).' : '.ConvertUTF_8toISO_8859_1($sReasonForVisitValue, $bIconvAvailable)."\n");
$pdf->SetFont('Arial', 'B', 9);
$pdf->Write(4, ConvertUTF_8toISO_8859_1($sValidDateLabelText, $bIconvAvailable).' : '.ConvertUTF_8toISO_8859_1($sValidDateValue, $bIconvAvailable)."\n");
$pdf->SetFont('Arial', 'B', 10);
$pdf->Write(4, ConvertUTF_8toISO_8859_1($sBadgeIDNumberLabelText, $bIconvAvailable).' : '.ConvertUTF_8toISO_8859_1($sBadgeIDNumberValue, $bIconvAvailable)."\n");
$pdf->SetFont('Arial', 'I', 8);
$pdf->Write(3, ConvertUTF_8toISO_8859_1($sPleaseReturnToTheReceptionistAndSignOutOnExitText, $bIconvAvailable)."\n");
$pdf->Image('./badgelogo.jpg', 73, 0, 15, 0);
?>
