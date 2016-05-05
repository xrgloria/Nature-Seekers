<?php
session_start();
$db = mysql_connect("studentdb-maria.gl.umbc.edu","xr43817","xr43817");

if(!$db)
	exit("Error - could not connect to MySQL");

#select database natureseekers
$er = mysql_select_db("xr43817");
if(!$er)
	exit("Error - could not select database");
$user = 1 /*$_SESSION['user_id']*/;
$routeQuery = "INSERT INTO ROUTES(USER_ID) VALUES($user);";
$result = mysql_query($routeQuery);
$routeID = mysql_insert_id();

$overlays = $_POST['overlayID'];
foreach ($overlays as $entry)
{
	$overlayQuery = "INSERT INTO ROUTE_OVERLAYS VALUES($routeID, $entry);";
	mysql_query($overlayQuery);
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
			<li><a href="./login.php">Home</a></li>
			<li><a href="./search.php">Search Map</a></li>
			<li><a href="./points_of_interest.php">Add Markers</a></li>
			<li><a href="./route.php">View Route</a></li>
		</ul>
		<ul class="nav navbar-nav navbar-right">
		  <li><a href="./logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
		</ul>
	</div>
</div>
<br /><br />
<div class="content">
Your route has been succesfully created. Here is the link to the route
<a href="./route.php?routeID=<?php echo $routeID ?>">
	www.natureseekers.ddns.net/route.php?routeID=<?php echo $routeID ?>
</a>
</div>

</body>
</html>