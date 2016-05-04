/*
Author: Steven Nguyen
Date last modified: 05/02/2016
IS 448
Professor Sampath
This document will be used to validate the user input on login.php. This page also will be used to change CSS properties on login.php. FInally, this page will open links to other pages to provide assistance with logging in.
*/

//Function to validate the user input
function validateLogin(){
	var userValue = document.getElementById("user").value;
	var loginPattern = /^[a-z0-9_]+$/i;
	var userResult = loginPattern.test(userValue);
	
	//If user inputs nothing in the username field
	if (userValue == ""){
		alert("You did not enter a username. Please go back and try again.");
		return false;
	}
	
	//If user input contains bad characters
	if (userResult == false){
		alert("You did not enter a username in the correct form. Please only use letters, numbers, and/or underscores.");
		return false;	
	}
	
	var passValue = document.getElementById("pass").value;
	var passResult = loginPattern.test(passValue);
	
	//If user inputs nothing in the password field
	if (passValue == ""){
		alert("You did not enter a password. Please go back and try again.");
		return false;
	}
	
	//If user input contains bad characters
	if (passResult == false){
		alert("You did not enter a password in the correct form. Please only use letters, numbers, and/or underscores.");
		return false;	
	}
	
	//Success
	else{
		return true;
	}
}

//Opens a new window to forgot.html
function forgotRedirect(){
	window.open("./forgot.html",height=100,width=100);
}

//Opens a new tab to registration.html
function registerRedirect(){
	window.open("./registration.html");
}

//Changes the CSS properties for the background color, font color, and button color of login.php
function nightMode(){	
	var chkbox = document.getElementById("chk");
	
	//If the checkbox is checked, activates night mode
	if(chkbox.checked){
		document.getElementById("body").style.backgroundColor = "#335216";
		document.getElementById("body").style.color = "#DAE3B0";
		document.getElementById("loginSubmit").style.background='#17270C';
		document.getElementById("registerButton").style.background='#17270C';
		document.getElementById("forgotButton").style.background='#17270C';
	}
	//If the checkbox is unchecked, deactivates night mode
	else{
		document.getElementById("body").style.backgroundColor = "#DAE3B0";
		document.getElementById("body").style.color = "#335216";
		document.getElementById("loginSubmit").style.background="";
		document.getElementById("registerButton").style.background="";
		document.getElementById("forgotButton").style.background="";
	}
}
