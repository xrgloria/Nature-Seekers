<?php
	session_start();
	
	/*
	Author: Steven Nguyen
	Date last modified: 05/04/2016
	IS 448
	Professor Sampath
	This document will be used to verify the user input from login.php.
	*/
	
	#PHP function that takes the $newURL variable and redirects the user depending on their login result.
	function Redirect($newURL){
		header("Location: ".$newURL);
		exit();
	}
	
	#Destroys all existing sessions before creating new ones.
	/*if(isset($_SESSION)){
		session_destroy();
		unset($_SESSION);
	}*/
	
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
	
	#Retrieve username and password from login.html
	$uname = mysql_real_escape_string(htmlspecialchars($_POST['Username']));
	$pword = mysql_real_escape_string(htmlspecialchars($_POST['Password']));
	
	#select * from users where username = '$uname';
	#Constructs the query to match the login information
	#Steven's database
	#$constructed_query = "select * from users where username = '$uname' and password = '$pword'";
	
	#Gloria's database
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
	
	$rowArray = mysql_fetch_array($login_result);
	
	#If statement that assigns the proper destination to $newURL depending on the login result
	if($num_rows == 1){
		$_SESSION['user_id'] = $rowArray[user_id];
		$newURL = "search.php";
		
	}else{
		$_SESSION['login_fail'] = time();
		$newURL = "login.php";
	}
	
	#Calls the Redirect function
	Redirect($newURL);
	
?>
