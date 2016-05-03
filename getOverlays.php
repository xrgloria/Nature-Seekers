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
$sql = "SELECT O.OVERLAY_ID, O.TYPE, O.OVERLAY_ACTIVITY, O.OVERLAY_NAME
		FROM OVERLAYS O
		WHERE O.OVERLAY_ID IN (SELECT OVERLAY_ID FROM POINTS WHERE LATITUDE BETWEEN $latitudeBottom AND $latitudeTop 
			AND LONGITUDE BETWEEN $longitudeLeft AND $longitudeRight)
		ORDER BY O.OVERLAY_ID;";
$result = mysql_query($sql);


echo '{';
if (mysql_num_rows($result) > 0) {
    while($row = mysql_fetch_array($result)) {
		echo '"OVERLAY" : {' . $row['OVERLAY_ID']) . ",";
		echo '"OVERLAY_TYPE" :' . $row['OVERLAY_TYPE']) . ",";
		echo '"ACTIVITY_NAME" :' . $row['ACTIVITY_NAME']) . ",";
		echo '"OVERLAY_NAME" :' . $row['OVERLAY_NAME']) . ",";
		echo '"POINTS" :[';
		
		$pointQuery = "SELECT LATITUDE, LONGITUDE FROM POINTS WHERE OVERLAY_ID = $id;";
		$pointResult = mysql_query($pointQuery);
		while($pointRow = mysql_fetch_array($pointResult)) {
			echo '{"lat":'. $pointRow['LATITUDE']) . ',"lng":' . $pointRow['LONGITUDE']) . '},' ;
		}
		echo ']},' 
}
echo '}';
?>
