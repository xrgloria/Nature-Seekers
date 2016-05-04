<?php

	/*
	Author: Steven Nguyen
	Date last modified: 05/04/2016
	IS 448
	Professor Sampath
	This document will be used to check if an input email address is in the database.
	*/

	#connect to mysql database
	#Gloria's database
	$db = mysql_connect("studentdb-maria.gl.umbc.edu","xr43817","xr43817");
	
	#Steven's database
	#$db = mysql_connect("studentdb-maria.gl.umbc.edu","snguyen5","natureseekers");
	
	if(!$db)
		exit("Error - could not connect to MySQL");
	
	#select database natureSeekers
	#Steven's database
	#$er = mysql_select_db("snguyen5");
	
	#Gloria's database
	$er = mysql_select_db("xr43817");
	
	if(!$er)
		exit("Error - could not select database");
	
	#select user_email from users;
	#Constructs the query to match the login information
	$constructed_query = "select user_email from USERS";
	
	#$constructed_query = "select user_email from users";
	
	#Execute query
	$email_result = mysql_query($constructed_query);
	
	#if result object is not returned, then print an error and exit the PHP program
	if(! $email_result){
		print("Error - query could not be executed");
		$error = mysql_error();
		print "<p> . $error . </p>";
		exit;
	}
	
	#Array declaration
	$emailArray=array();
	
	#Populates array with email addresses from the database
	while($row = mysql_fetch_array($email_result)){
		$emailArray[]=$row["user_email"];
	}
	
	#retrieve value of parameter by name 'email' and store the value in the local variable $chkEmail
	$chkEmail=$_GET["email"];
	
	#Query to retrieve password of specified email.
	$pwdQuery = "select password from USERS where user_email = '$chkEmail'";
	$pwdResult = mysql_query($pwdQuery);
	$pwdRow = mysql_fetch_array($pwdResult);
	
	#Checks user input to see if their email is in the database
	if (in_array($chkEmail,$emailArray)){
		$response="Email in database. Your password is " . $pwdRow[password] . ".";
	}
	else{
		$response="Email not in database.";
	}
	echo $response;
?>
