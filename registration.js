/*This page is the registration javascript page called registration.js. This page
is used to validate input from the user and change the color of the title.
Created by: Mark Cirincione
Date of Creation: 4/15/16
Last Date of Modification: 5/4/16 */

function onText() {
    var a = document.getElementById("header").style.backgroundColor="yellow";
	var b = document.getElementById("header").style.textDecoration="underline";
}

function offText() {
    var c = document.getElementById("header").style.backgroundColor="white";
	var d = document.getElementById("header").style.textDecoration="none";
}

function checkUsername(inputString){
	new Ajax.Request(
		"./checkUsername.php",
		{
			method: "get",
			parameters: {user_name:inputString},
			onSuccess: displayResult,
			onFailure: weFailed
		}
	)
}

function displayResult(ajax){
	var test = ajax.responseText;
	$("msgbox").innerHTML = test;
	if(test == "Username in database."){
		$("msgbox").style.backgroundColor="red";
		$("msgbox").style.color="white";
		$("msgbox").style.fontWeight="bold";
		$("msgbox").focus();
	}
	else{
		$("msgbox").style.backgroundColor="green";
		$("msgbox").style.color="white";
		$("msgbox").style.fontWeight="bold";
		$("msgbox").focus();
	}
}
function weFailed(){
	alert("WHY!");
}
function validatePage() {
	//First Name
	var first_name = document.getElementById("first_name").value;
	
	if (first_name == ""){
		alert("First name is empty. Re-Enter");
		return false;
	}
	
	var pattern1 = /^[a-z]+$/i;
	var result = pattern1.test(first_name);
	
	
	if (result==false) 
	{
		alert("The name you entered (" + first_name + ") is not in the correct form. It should only contain letters. Please go back and fix your name");
		document.getElementById("first_name").select();
    
		return false;
	}
	
	//Last Name
	var last_name = document.getElementById("last_name").value;
	
	if (last_name == ""){
		alert("Last name is empty. Re-Enter");
		return false;
	}
	var pattern2 = /^[a-z]+$/i;
	var result = pattern2.test(last_name);
	
	if (result==false) 
	{
		alert("The last name you entered (" + last_name + ") is not in the correct form. It should only contain letters. Please go back and fix your name");
		document.getElementById("last_name").select();
    
		return false;
	}
	
	//Username
	var user_name = document.getElementById("user_name").value;
	
	if (user_name == ""){
		alert("Username is empty. Re-Enter");
		return false;
	}
	var pattern3 = /\w+/;
	var result = pattern3.test(user_name);
	
	if (result==false) 
	{
		alert("The Username you entered (" + user_name + ") is not in the correct form. Your username can only have letters or digits. Please go back and fix your name");
		document.getElementById("user_name").select();
    
		return false;
	}
	
	//Password Check
	var password = document.getElementById("password").value;
	var retyped_password = document.getElementById("retyped_password").value;
	if (password == ""){
		alert("Password is empty. Re-Enter");
		return false;
	}
	if (retyped_password == ""){
		alert("Retyped password is empty. Re-Enter");
		return false;
	}
	//comparison
	if (password != retyped_password) 
	{
		alert("Your passwords do not match. Please try again.");
    
		return false;
	}

	//Email Check
	var user_email = document.getElementById("user_email").value;
	var retyped_email = document.getElementById("retyped_email").value;
	
	if (user_email == ""){
		alert("Email is empty. Re-Enter");
		return false;
	}
	
	var pattern4 = /^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/i;
	var result = pattern4.test(user_email);
	
	if (result==false) 
	{
		alert("The email you entered is not valid. Please try again.");
		return false;
	}
	
	if (retyped_email == ""){
		alert("Retyped email is empty. Re-Enter");
		return false;
	}
	//comparison
	if (user_email != retyped_email) 
	{
		alert("Your emails do not match. Please try again.");
    
		return false;
	}
	
	else {
		alert ("Successfully registered.");
		return true
	}
}