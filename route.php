<!--Luke Schubert
	IS448
-->
<?php
/*Handles checking the user being logged in*/
session_start();
if(!isset($_SESSION['user'])){
	header('Location: ./login.php');
}
?>

<?php
/*If a get request is passed in with a route ID autopopulate with that information*/
if(isset($_GET['routeID']))
{
	$db = mysql_connect("localhost","root","root");
	
	if(!$db)
		exit("Error - could not connect to MySQL");
	
	#select database natureseekers
	$er = mysql_select_db("natureseekers");
	if(!$er)
		exit("Error - could not select database");
	$routeID = mysql_real_escape_string(htmlspecialchars($_GET['routeID']));
	$selectQuery = "SELECT * FROM ROUTE OVERLAYS WHERE ROUTE_ID = $routeID";
	$result = mysql_query($selectQuery);
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Test site</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<link rel="stylesheet" href="./style/lavish-bootstrap.css">
	<link rel="stylesheet" href="./style/luke.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
<div class="navbar navbar-inverse" style="border-radius:0pt;">
	<div class="content">
		<span class="navbar-brand">
			Nature Seekers
		</span>
		<ul class="nav navbar-nav">
			<li><a href="./login.html">Home</a></li>
			<li><a href="./search.php">Search Map</a></li>
			<li><a href="./points_of_interest.html">Add Markers</a></li>
			<li class="active"><a href="#">View Route</a></li>
		</ul>
		<ul class="nav navbar-nav navbar-right">
		  <li><a href="./logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
		</ul>
	</div>
</div>
<div class="row content fillHeight">
	<div class="col-sm-3">
		<form method="post" action="addRoute.php">
		<div class="panel panel-primary route">
			<div class="panel-heading">
				<h3>Overlays</h3>
			</div>
			<div class="panel-body routeContent">
				<?php
				$divClass = True;
				if (mysql_num_rows($result) > 0) {
					while($row = mysql_fetch_array($result)) {
						echo '<div class="' . ($divClass) ? 'route-A' : 'route-B' . '">';
						$overlayID = $row['OVERLAY_ID'];
						$activityQuery = "SELECT A.ACTIVITY_NAME FROM ACTIVITIES A
										  JOIN OVERLAY_ACTIVITES O
										  ON A.ACTIVITY_ID = O.ACTIVITY_ID
										  WHERE O.OVERLAY_ID = $overlayID";
						$activityResults = mysql_query($activityQuery);
						if (mysql_num_rows($activityResults) > 0) {
							while($activityRow = mysql_fetch_array($activityResults)) {
								echo $activityRow['ACTIVITY_NAME'] . ' ';
						} else {
						   
						}
						echo '<br />';
						echo '<button type="button" class="btn btn-primary btn-xs removeButton">Remove</button><br />';
						$divClass = !$divClass
						echo '<input type="hidden" name="overlayID[]" value="$overlayID"/>';
					}
					
				} else {
				   
				}
				?>
				<div class="route-A">
					Kayaking-Whitewater<br/>
					Length: 2.4 mi
					<button type="button" class="btn btn-primary btn-xs removeButton">Remove</button><br />
				</div>
				<div class="route-B">
					Walking/Biking<br />
					Length: 5 mi
					<button type="button" class="btn btn-primary btn-xs removeButton">Remove</button><br />
				</div>
			</div>
		</div>
			<input type="hidden" name="overlayID[]" />
			<input type="submit"></input>
		</form>
	</div>
	<div class="col-sm-9 fillHeight">
		<div id="map"></div>
	</div>
</div>

<script src="./js/viewMap.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyABvCBMSTZPK8Wllny5VJVD0cujfAaWZYk&callback=initMap&libraries=geometry" async defer></script>
</body>
</html>