<?php

	/*
	Author: Steven Nguyen
	Date last modified: 05/02/2016
	IS 448
	Professor Sampath
	This document will be used to verify the user input from login.php.
	*/
	
	#PHP function that takes the $newURL variable and redirects the user depending on their login result.
	function Redirect($newURL){
		header("Location: ".$newURL);
		exit();
	}
	
	#connect to mysql database
	#Natureseeker's database
	$db = mysql_connect("localhost","root","root");
	
	#Steven's database
	#$db = mysql_connect("studentdb-maria.gl.umbc.edu","snguyen5","natureseekers");
	
	if(!$db)
		exit("Error - could not connect to MySQL");
	
	#select database natureSeekers
	#Steven's database
	#$er = mysql_select_db("snguyen5");
	
	#Natureseeker's database
	$er = mysql_select_db("natureSeekers");
	if(!$er)
		exit("Error - could not select database");
	
	#Retrieve username and password from login.html
	$uname = mysql_real_escape_string(htmlspecialchars($_POST['Username']));
	$pword = mysql_real_escape_string(htmlspecialchars($_POST['Password']));
	
	#select * from users where username = '$uname';
	#Constructs the query to match the login information
	#Steven's database
	#$constructed_query = "select * from users where username = '$uname' and password = '$pword'";
	
	#Natureseeker's database
	$constructed_query = "select * from USERS where user_name = '$uname' and password = '$pword'";
	
	#Execute query
	$login_result = mysql_query($constructed_query);
	
	#if result object is not returned, then print an error and exit the PHP program
	if(! $login_result){
		print("Error - query could not be executed");
		$error = mysql_error();
		print "<p> . $error . </p>";
		exit;
	}
	
	#Returns the number of rows retrieved from the database that match the login query
	$num_rows = mysql_num_rows($login_result);
	
	#If statement that assigns the proper destination to $newURL depending on the login result
	if($num_rows == 1){
		setcookie('LoggedIn', $uname, time()+86400, "/");
		$newURL = "search.html";
		
	}else{
		$newURL = "login.php";
	}
	
	#Calls the Redirect function
	Redirect($newURL);
	
?>
