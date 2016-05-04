<?php
session_start();
//testing --> set user_id as 1 for username gngo
$_SESSION['user_id'] = 1;

if(!isset($_SESSION['user_id'])){
	header('Location: ./login.php');
}

$user = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<!--***************************************************************************
*Created by Gloria Ngo
*
*IS448 - Markup Languages
*Gloria Ngo
*
*Description: This is the php page for adding points of interest to the map
*	for the nature seeker project. It uses Google's Map API to have a map
*	drawn onto the page and to be manipulated.
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
		
		<!--Script sources-->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>	
	
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyABvCBMSTZPK8Wllny5VJVD0cujfAaWZYk&callback=initMap"></script>
		<!--script	src="http://maps.google.com/maps/api/js?sensor=false&amp;language=en"></script-->
		<script src="https://maps.googleapis.com/maps/api/js?key=&AIzaSyABvCBMSTZPK8Wllny5VJVD0cujfAaWZYk&libraries=drawing"></script>
	
		<script src="poi.js" type="text/javascript"></script>
	</head>
	
	<!--Body of the page-->
	<body>	
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
					<li><a href="search.php">Search</a></li>
					<li class="active"><a href="points_of_interest.html">Add Markers</a></li>
					<li><a href="route.php">View Route</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li><a href="login.html"><span class="glyphicon glyphicon-log-out"></span>Logout</a></li>
					</ul>
				</ul>
			</div>
		</div>
		<!--Bootstrap row content-->
		<div class="row content">
			<!--Left column-->
			<div class="col-sm-3">
				<div class="panel panel-primary" >
					<div class="panel-heading">
						<h3>Points of Interest</h3>
					</div>
					<div class="panel-body poi_select">
						<!--Grab points of interests as a whole from db and display in the following
							format, use a loop to pull all available ones-->
						<?
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

						#construct a query insert overlay information
						$constructed_query = "SELECT * FROM OVERLAYS where user_id = '$user' or private = 0";
											  
						#Execute query
						$result = mysql_query($constructed_query);
						
						#if result object is not returned, then print an error and exit the PHP program
						if(! $result){
							print("Error - query could not be executed");
							$error = mysql_error();
							print "<p> . $error . </p>";
							exit;
						}
						print("<div class=\"poi\">");
						while($row_array = mysql_fetch_array($result)){
							print("<p>
								<strong>Name: </strong>$row_array[overlay_name]<br />
								<strong>Activity: </strong>$row_array[activity_name]<br />
								<strong>Description: </strong>$row_array[description]
								<span>
									<button type=\"button\" class=\"btn btn-primary btn-xs pull-right\">Remove</button>
								</span>
								</p>");
						}
						print("</div>");
						?>
						<!--div class="poi">
							<p>
								<strong>Name: </strong>Devil's Rock <br />
								<strong>Activity: </strong>Rock Climbing <br />
								<strong>Description: </strong>Difficulty: 10a
								<span>
									<button type="button" class="btn btn-primary btn-xs pull-right">Remove</button>
									<button type="button" class="btn btn-primary btn-xs pull-right">View</button>
								</span>
							</p>
						</div>
						<!--Fix this button to do more shit-->
						<button class="btn btn-primary" id="create-new-button">Create New Point of Interest</button>
					</div>
				</div>
				
				<div class="panel panel-primary" >
					<div class="panel-heading">
						<h3>Create New Point of Interest</h3>
					</div>
					<div class="panel-body ">
						<!--On submit add the following information into the database-->
						<form action="addPoi.php" id="formPoi" method="POST">
							<label for="name">Name</label>
							<input type="text" class="form-control" name="name" id="name"/>
							<br/>
							<label for="activity">Activity (Select One):</label>
							<select class="form-group" name="activity">
								<?
								#construct a query insert overlay information
								$constructed_query = "SELECT * FROM ACTIVITIES";
													  
								#Execute query
								$result2 = mysql_query($constructed_query);
								
								#if result object is not returned, then print an error and exit the PHP program
								if(! $result2){
									print("Error - Could not select from ACTIVITIES");
									$error = mysql_error();
									print "<p> . $error . </p>";
									exit;
								}
								
								while($row_array = mysql_fetch_array($result2)){
									print("<option>$row_array[activity_name]</option>");
								}
								?>
							</select><br/>
							<!--input type="text" class="form-control" name="activity" id="activity"/-->
							<label for="description">Description</label>
							<textarea class="form-control" rows="5" name="description" id="description"></textarea>
							<div class="radio">
								<label><input type="radio" name="privacy" value="public">Public</label>
							</div>
							<div class="radio">
							<label><input type="radio" name="privacy" value="private">Private</label>
							</div>
							<input type="hidden" id="latInput" name="lat">
							<input type="hidden" id="lngInput" name="lng">
							<input type="hidden" id="typeInput" name="type">
							<br />
							<button type="button" onclick="submitForm();" class="btn btn-primary">Create</button>
							<button type="reset" class="btn btn-primary">Discard</button>
						</form>
					</div>
				</div>
			</div>
			<div class="col-sm-9">
				<div id="map"></div>
			</div>
		</div>
	</body>
</html>