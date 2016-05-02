<?php

$db = mysql_connect("localhost","root","root");

if(!$db)
	exit("Error - could not connect to MySQL");

#select database luke5
$er = mysql_select_db("natureSeekers");
if(!$er)
	exit("Error - could not select database");

$latitudeTop = mysql_real_escape_string(htmlspecialchars($_GET['latitudeTop']));
$longitudeLeft = mysql_real_escape_string(htmlspecialchars($_GET['longitudeLeft']));
$latitudeBottom = mysql_real_escape_string(htmlspecialchars($_GET['latitudeBottom']));
$longitudeRight = mysql_real_escape_string(htmlspecialchars($_GET['longitudeRight']));
$sql = "SELECT OVERLAY_ID, TYPE
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
		$json[$id] = array(
			'id' => $id,
			'type' => $type);
		$activityQuery = "SELECT A.ACTIVITY_NAME FROM ACTIVITIES A JOIN OVERLAY_ACTIVITIES O
							ON A.ACTIVITY_ID = O.ACTIVITY_ID
							WHERE O.OVERLAY_ID = $id";
		$activityResult = mysql_query($activityQuery);
		$activities = array();
		while($activityRow = mysql_fetch_array($activtyResult)) {
			array_push($activites, $activityRow['ACTIVITY_NAME');
		}
		$json[$id]['activities'] = $activities;
		$pointQuery = "SELECT LATITUDE, LONGITUDE FROM POINTS WHERE OVERLAY_ID = $id;";
		$pointResult = mysql_query($pointQuery);
		$points = array();
		while($pointRow = mysql_fetch_array($pointResult)) {
			array_push($points, array('lat' => $pointRow['LATITUDE'], 'lng' => $pointRow['LONGITUDE']));
		}
		$json[$id]['points'] = $points;
			
	}
}

echo json_encode($json, JSON_NUMERIC_CHECK);
?>
