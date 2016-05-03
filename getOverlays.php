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
$sql = "SELECT O.OVERLAY_ID, O.TYPE, O.ACTIVITY_NAME, O.OVERLAY_NAME
		FROM OVERLAYS O ORDER BY O.OVERLAY_ID;";
		/*WHERE O.OVERLAY_ID IN (SELECT OVERLAY_ID FROM POINTS WHERE LATITUDE BETWEEN $latitudeBottom AND $latitudeTop 
			AND LONGITUDE BETWEEN $longitudeLeft AND $longitudeRight)*/
$result = mysql_query($sql) or die(mysql_error());


echo '{';
if (mysql_num_rows($result) > 0) {
    while($row = mysql_fetch_array($result)) {
		$id = $row['OVERLAY_ID'];
		echo '"' . $id . '": {';
		echo '"OVERLAY_TYPE" :' . $row['OVERLAY_TYPE'] . ",";
		echo '"ACTIVITY_NAME" :' . $row['ACTIVITY_NAME'] . ",";
		echo '"OVERLAY_NAME" :' . $row['OVERLAY_NAME'] . ",";
		echo '"POINTS" :[';
		
		$pointQuery = "SELECT LATITUDE, LONGITUDE FROM POINTS WHERE OVERLAY_ID = $id;";
		$pointResult = mysql_query($pointQuery) or die(mysql_error());
		while($pointRow = mysql_fetch_array($pointResult)) {
			echo '{"lat":'. $pointRow['LATITUDE'] . ',"lng":' . $pointRow['LONGITUDE'] . '},' ;
		}
		echo ']},' ;
	}
}
echo '}';
?>