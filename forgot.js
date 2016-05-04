/*
Author: Steven Nguyen
Date last modified: 05/02/2016
IS 448
Professor Sampath
This document will be used to validate forgot.html and creates a response depending on the user input email address.
*/

//AJAX call to verify an email address
function validateEmail(inputString){
	
	new Ajax.Request(
		"emailCheck.php",
		{
			method: "get",
			parameters: {email:inputString},
			onSuccess: displayResult
		}
	)
}

//Function to display the response from emailCheck.php trhough the previous AJAX call
function displayResult(ajax){
	var r = ajax.responseText;
	$("msgbox").innerHTML = r;	
}

//Function to validate the user input email address
function validateRecovery(){
	var emailValue = document.getElementById("email").value;
	var emailPattern = /^[a-z0-9_.]+@+[a-z0-9_.]+[.][a-z]+$/i;
	var emailResult = emailPattern.test(emailValue);
	
	//If the user does not input anything
	if (emailValue == ""){
		alert("You did not enter an email address. Please go back and try again.");
		return false;
	}
	
	//If the user inputs an email address not in the "XXX@YYY.ZZZ" form
	if (emailResult == false){
		alert("You did not enter an email address in the correct form. Please only use letters, numbers, underscores, and/or periods. Your email address must contain exactly one '@' symbol.");
		return false;	
	}
	
	//Success
	else{
		alert("You did it!");
		return true;
	}
}
