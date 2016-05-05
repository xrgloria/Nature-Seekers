<?php
/*Created by Luke Schubert*/
/*Handles checking the user being logged in*/

session_start();
if(!isset($_SESSION['user_id'] $$ !isset($_GET['routeID'])){
	header('Location: ./login.php');
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

	<!-- jQuery library  for bootstrap-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/prototype/1.6.0.3/prototype.js"></script>

</head>
<body>
<div class="navbar navbar-inverse" style="border-radius:0pt;">
	<div class="content">
		<span class="navbar-brand">
			Nature Seekers
		</span>
		<ul class="nav navbar-nav">
			<li><a href="./login.php">Home</a></li>
			<li><a href="./search.php">Search Map</a></li>
			<li><a href="./points_of_interest.php">Add Markers</a></li>
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
			<div class="panel-body routeContent" id="overlayList">
				<?php
				if(isset($_GET['routeID']))
				{
					$overlayPoints = array();
					$db = mysql_connect("studentdb-maria.gl.umbc.edu","xr43817","xr43817");
					if(!$db)
						exit("Error - could not connect to MySQL");
					
					#select database natureseekers
					$er = mysql_select_db("xr43817");
					if(!$er)
						exit("Error - could not select database");
					$routeID = mysql_real_escape_string(htmlspecialchars($_GET['routeID']));
					$selectQuery = "SELECT O.OVERLAY_NAME,O.ACTIVITY_NAME, P.LATITUDE, P.LONGITUDE
									FROM OVERLAYS O
									JOIN ROUTE_OVERLAYS R
									ON R.OVERLAY_ID = O.OVERLAY_ID
									JOIN POINTS P
									ON P.OVERLAY_ID = O.OVERLAY_ID
									WHERE R.ROUTE_ID= $routeID";
					$result = mysql_query($selectQuery);
					
					$divClass = True;
					if (mysql_num_rows($result) > 0) {
						while($row = mysql_fetch_array($result)) {
							
							$overlayID = $row['OVERLAY_ID'];
							echo '<div class="' . ($divClass) ? 'route-A' : 'route-B' . ' id="'. $overlayID . '">';
							$activityQuery = "SELECT O.OVERLAY_NAME, O.ACTIVITY_NAME FROM OVERLAYS O
											  WHERE O.OVERLAY_ID = $overlayID";
							$activityResults = mysql_query($activityQuery);
							echo '<b>' . $activityResults['OVERLAY_NAME'] . '</b><br />';
							echo $activityResults['ACTIVITY_NAME'];
							echo '<br />';
							echo '<button type="button" class="btn btn-primary btn-xs removeButton" onclick="removeOverlay(' . $overlayID . ')">Remove</button><br />';
							$divClass = !$divClass;
							echo '<input type="hidden" name="overlayID[]" value="' . $overlayID . '"/>';
							echo '</div>';
							array_push($overlayPoints, array( $activityResults['LATITUDE'],$activityResults['LONGITUDE']));
						}
						
					} else {
					   
					}
				}
				?>
			</div>
		</div>
			<?php
				if(!isset($_GET['routeID'])){
					echo '<input type="submit" class="btn btn-primary btn-xs"></input>';
				}
			?>
		</form>
	</div>
	<div class="col-sm-9 fillHeight">
		<div id="map"></div>
	</div>
</div>
<?php
	if(!isset($_GET['routeID'])){
		echo '<script src="./js/mapUpdater.js"></script>';
	}else {
		echo '<script src="./js/loadRoute.js"></script>';
	}
?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyABvCBMSTZPK8Wllny5VJVD0cujfAaWZYk&callback=initMap&libraries=geometry" async defer></script>
<?php
if(isset($_GET['routeID'])){
		echo '<script >';
		foreach($overlayPoints as $pair){
			echo 'addOverlays(' . $pair[0] . ',' . $pair[1]. ');';
		}
		echo '</script';
	}
?>
</body>
</html>