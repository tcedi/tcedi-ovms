/*
   phpVisitorBadge Enhanced Version 2.00 BETA 8
   Copyright (c) 2010-2016 RKW ACE S.A.

   phpVisitorBadge Enhanced is a derivative work based on the original version of phpVisitorBadge.
   phpVisitorBadge (Original version)
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

// email

function checkEmail (strng) {
var error="";
if (strng == "") {
return error
}

    var emailFilter=/^.+@.+\..{2,3}$/;
    if (!(emailFilter.test(strng))) { 
       error = "Please enter a valid email address. \n";
    }
    else {
//test email for illegal characters
       var illegalChars= /[\(\)\<\>\,\;\:\\\"\[\]]/
         if (strng.match(illegalChars)) {
          error = "The email address contains illegal characters.\n";
       }
    }
return error;    
}

// username - 4-25 chars, uc, lc, and underscore only.

function checkUsername (strng) {
var error = "";
if (strng == "") {
   error = "You didn't enter a name.\n";
}
//count words code from http://home.cogeco.ca/~ve3ll/jstutorc.htm
char_count = strng.length;   // very crude measure
fullStr = strng + " "; // add space delimiter to end of text
initial_whitespace_rExp = /^[^A-Za-z0-9]+/gi; //use for complex whitespace
left_trimmedStr = fullStr.replace(initial_whitespace_rExp, " ");
non_alphanumerics_rExp = /[^A-Za-z0-9]+/gi;   // and for delimiters
cleanedStr = left_trimmedStr.replace(non_alphanumerics_rExp, " ");
splitString = cleanedStr.split(" ");word_count = splitString.length -1;
if(fullStr.length <2) {word_count = 0; }
if(word_count != 2) { error = "You didn't enter a proper name. \nFormat is - FirstName LastName\n"; }

    var illegalChars = /[^\w ]/; // allow letters, numbers, and Space
    if ((strng.length < 2) || (strng.length > 27)) {
       error = "The username is the wrong length.\n";
    }
    else if (illegalChars.test(strng)) {
    error = "The username contains illegal characters.\n";
    } 
return error;
}       

// numbers - digits underscore only.

function checkNumber (strng) {
var error = "";
if (strng == "") {
   error = "You didn't enter a proper number.\n";
}
     // allow numbers
   if (strng.length > 4 && strng.length !== 10) {
       error = "The input is the wrong length.\n";
    }
return error;
}    

// non-empty textbox 

function isEmpty(strng) {
var error = "";
  if (strng.length == 0) {
     error = "The mandatory text area has not been filled in.\n"
  }
return error;	  
}

// non-empty textbox -Company

function isEmptyC(strng) {
var error = "";
  if (strng.length == 0) {
     error = "The Company Name has not been filled in.\n"
  }
return error;	  
}

// non-empty textbox -Visiting

function isEmptyV(strng) {
var error = "";
  if (strng.length == 0) {
     error = "The Employee Name or Reason for Visit has not been filled in.\n"
  }
return error;	  
}

// http://developer.apple.com/internet/webcontent/validation.html

