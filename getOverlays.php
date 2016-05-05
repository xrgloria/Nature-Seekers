<?php

$db = mysql_connect("studentdb-maria.gl.umbc.edu","xr43817","xr43817");

if(!$db)
	exit("Error - could not connect to MySQL");

#select database luke5
$er = mysql_select_db("xr43817");
if(!$er)
	exit("Error - could not select database");
//$userID = $_SESSION['user'];

$sql = "SELECT O.OVERLAY_ID, O.TYPE, O.ACTIVITY_NAME, O.OVERLAY_NAME
		FROM OVERLAYS O ORDER BY O.OVERLAY_ID;";
$result = mysql_query($sql) or die(mysql_error());


echo '{';
$numOfRows = mysql_num_rows($result);
$counter = 0;
if (mysql_num_rows($result) > 0) {
    while($row = mysql_fetch_array($result)) {
		$id = $row['OVERLAY_ID'];
		echo '"' . $id . '": {';
		echo '"OVERLAY_TYPE" :' . $row['TYPE'] . ",";
		echo '"ACTIVITY_NAME" : "' . $row['ACTIVITY_NAME'] . '",';
		echo '"OVERLAY_NAME" : "' . $row['OVERLAY_NAME'] . '",';
		echo '"POINTS" :[';
		
		$pointQuery = "SELECT LATITUDE, LONGITUDE FROM POINTS WHERE OVERLAY_ID = $id;";
		$pointResult = mysql_query($pointQuery) or die(mysql_error());
		$numOfRowsPoint = mysql_num_rows($pointResult);
		$counterPoint = 0;
		while($pointRow = mysql_fetch_array($pointResult)) {
		echo '{"lat":'. $pointRow['LATITUDE'] . ',"lng":' . $pointRow['LONGITUDE'] . '}' ;
			if (++$counterPoint == $numOfRowsPoint) {
			} else {
			echo ',';
			}
		}
		echo ']}' ;
		if (++$counter == $numOfRows) {
		} else {
		echo ',';
		}
	}
}
echo '}';
?>