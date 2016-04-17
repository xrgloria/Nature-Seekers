<!DOCTYPE html>
<!--***************************************************************************
*Created by Gloria Ngo
*
*IS448 - Markup Languages
*Deliverable 5 - PHP/MySQL
*Gloria Ngo
*
*Description: This is the php page will confirm the created polygons and push
*	it to the server.
*
*File Contents: php
*****************************************************************************-->
<html>
	<head>
	<!--Page Title-->
		<title>Nature Seekers | Add Points of Interest</title>
		
		<!--Meta things-->
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<!--Stylesheet stuff-->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<link rel="stylesheet" href="style/lavish-bootstrap.css">
		<link rel="stylesheet" href="style/gloria.css">
	</head>
	
	<body>
		<?php
			#connect to mysql database
			$db = mysql_connect("studentdb-maria.gl.umbc.edu","xr43817","xr43817");

			if(!$db)
				exit("Error - could not connect to MySQL");

			#select database xr43817
			$er = mysql_select_db("xr43817");
			if(!$er)
				exit("Error - could not select xr43817 database");

			#get the parameter from the HTML form that this PHP program is connected to
			#since data from the form is sent by the HTTP POST action, use the $_POST array here

			$name = mysql_real_escape_string(htmlspecialchars($_POST['name']));
			$activity = mysql_real_escape_string(htmlspecialchars($_POST['activity']));
			$description = mysql_real_escape_string(htmlspecialchars($_POST['description']));
			$privacy = mysql_real_escape_string(htmlspecialchars($_POST['privacy']));
			//$lat = json_decode($_POST['lat']);
			//$lng = json_decode($_POST['lng']);
			
			if($privacy === "private") {
				$private = true;
			} else {
				$private = false;
			}

			#construct a query
			$constructed_query = "INSERT into OVERLAYS (type, description, user_id, private) values (1, '$description', (select user_id from USERS where user_id = 1), '$private')";
								  
			#Execute query
			$result = mysql_query($constructed_query);
			


			#if result object is not returned, then print an error and exit the PHP program
			if(! $result){
				print("Error - query could not be executed");
				$error = mysql_error();
				print "<p> . $error . </p>";
				exit;
			}
		?>
		<!--Navbar-->
		<div class="navbar navbar-inverse">
			<div class="content">
				<!--Nav title-->
				<span class="navbar-brand">
					Nature Seekers
				</span>
				<!--Links for nav bar-->
				<ul class=" nav navbar-nav">
					<li><a href="login.html">Home</a></li>
					<li><a href="search.html">Search</a></li>
					<li class="active"><a href="points_of_interest.html">Add Markers</a></li>
					<li><a href="route.html">View Route</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li><a href="login.html"><span class="glyphicon glyphicon-log-out"></span>Logout</a></li>
					</ul>
				</ul>
			</div>
		</div>
		<!--Bootstrap row content-->
		<div class="row content">
			<div class="col-sm-2">
			</div>
			<!--Left column-->
			<div class="col-sm-6">
				<div class="panel panel-primary" >
					<div class="panel-heading">
						<h3>Overlay Created</h3>
					</div>
					<div class="panel-body ">
						<p>
						<? echo "Name:".$name." Act:".$activity." Desc:".$description." Privacy:".$privacy;//." ".$lat." ".$lng;?>
						</p>
					</div>
				</div>
			</div>
			<div class="col-sm-2">
			</div>
		</div>
	</body>
</html>