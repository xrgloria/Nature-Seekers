<?php
	session_start();
	/*
	Author: Steven Nguyen
	Date last modified: 05/04/2016
	IS 448
	Professor Sampath
	This document will be used to log out a user. ANY PAGE WITH A LOG OUT BUTTON NEEDS TO LINK TOT HIS PAGE.
	*/
	
	//Redirects the user to a new page.
	function Redirect($newURL){
		header("Location: ".$newURL);
		exit();
	}
	
	//Resets the 'LoggedIn' cookie, effectively destroying the session. Assigns $newURL to link to login.php.
	if(isset($_SESSION)){
		session_destroy();
		unset($_SESSION);
	}
	
	$newURL = "login.php";
	
	//Calls the Redirect function.
	Redirect($newURL);

?>
