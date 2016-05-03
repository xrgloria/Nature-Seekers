<?php

$db = mysql_connect("studentdb-maria.gl.umbc.edu","xr43817","xr43817");

if(!$db)
	exit("Error - could not connect to MySQL");

#select database luke5
$er = mysql_select_db("xr43817");
if(!$er)
	exit("Error - could not select database");
//$userID = $_SESSION['user'];
$latitudeTop = mysql_real_escape_string(htmlspecialchars($_GET['latitudeTop']));
$longitudeLeft = mysql_real_escape_string(htmlspecialchars($_GET['longitudeLeft']));
$latitudeBottom = mysql_real_escape_string(htmlspecialchars($_GET['latitudeBottom']));
$longitudeRight = mysql_real_escape_string(htmlspecialchars($_GET['longitudeRight']));
$sql = "SELECT O.OVERLAY_ID, O.TYPE, O.ACTIVITY, O.DESCRIPTION
		FROM OVERLAYS O
		WHERE O.OVERLAY_ID IN (SELECT OVERLAY_ID FROM POINTS WHERE LATITUDE BETWEEN $latitudeBottom AND $latitudeTop 
			AND LONGITUDE BETWEEN $longitudeLeft AND $longitudeRight)
		ORDER BY O.OVERLAY_ID;";
$result = mysql_query($sql);

$jsonData = array();
$previousOverlayID = -1;

if (mysql_num_rows($result) > 0) {
    while($row = mysql_fetch_array($result)) {
		$id = $row['OVERLAY_ID'];
		$type = $row['TYPE'];
		$activity = $row['ACTIVITY'];
		$description = $row['DESCRIPTION'];
		$json[$id] = array(
			'id' => $id,
			'type' => $type,
			'activity' => $activity,
			'description' => $description);
		$activityResult = mysql_query($activityQuery);
		$activities = array();
		$json[$id]['activities'] = $activities;
		$pointQuery = "SELECT LATITUDE, LONGITUDE FROM POINTS WHERE OVERLAY_ID = $id;";
		$pointResult = mysql_query($pointQuery);
		$points = array();
		while($pointRow = mysql_fetch_array($pointResult)) {
			array_push($points, array('lat' => $pointRow['LATITUDE'], 'lng' => $pointRow['LONGITUDE']));
		}
		if($type = 2){
			array_push($points, $points[0]);
		}
		
		$json[$id]['points'] = $points;
			
	}
}
$json = new Services_JSON();
return $json->encode($data);
?>
