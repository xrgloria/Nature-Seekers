<html xmlns = "http://www.w3.org/1999/xhtml">

<!--This page is the registration php page called registration.php. This page
collects the form data from registration.html for the first and last name, 
username, password, and email address fields.
It then inputs them into the database. 
Created by: Mark Cirincione
Date of Creation: 4/5/16
Last Date of Modification: 4/3/16 -->

<head>
	<title>Registration PHP</title>
	<!--<link rel="stylesheet" type="text/css" href="mark.css" /> -->
</head>
<body>

<?php
	#connect to mysql database
	$db = mysql_connect("natureseekers.ddns.net","root","root");

	if(!$db) {
		echo 'Could not connect using natureseekers.ddns.net: ' . mysql_error();
		
		$db = mysql_connect("localhost","root","root");
		if(!$db)
			die('Could not connect using localhost: ' . mysql_error());
	}	

	#select database root
	$er = mysql_select_db("natureSeekers");
	if(!$er)
		exit("Error - could not select database");

	#get the parameter from the HTML form that this PHP program is connected to
	#since data from the form is sent by the HTTP POST action, use the $_POST array here

	$first_name = htmlspecialchars($_POST['first_name']); 
	$last_name = htmlspecialchars($_POST['last_name']); 
	$user_name = htmlspecialchars($_POST['user_name']); 
	$password = htmlspecialchars($_POST['password']); 
	$email = htmlspecialchars($_POST['email']); 
	
	$first_name = mysql_real_escape_string($first_name);
	$last_name = mysql_real_escape_string($last_name);
	$user_name = mysql_real_escape_string($user_name);
	$password = mysql_real_escape_string($password);
	$user_email = mysql_real_escape_string($user_email);
?>

<?php
	#construct a query
	
	$constructed_query = "INSERT INTO blog (first_name, last_name, user_name, password, user_email) values ('$first_name', '$last_name', '$user_name', '$password', '$user_email')";
						  
	#sanity check: print query to see if constructed query is correct
	#print("CHECK PROGRAM IS WORKING MESSAGE: The query is: $constructed_query</br>");

	#Execute query
	$result = mysql_query($constructed_query);
	
?>
</body>
</html>