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

$xml = new XMLWriter();

$xml->openURI("php://output");
$xml->startDocument();
$xml->setIndent(true);

$xml->startElement('OVERLAYS');

if (mysql_num_rows($result) > 0) {
    while($row = mysql_fetch_array($result)) {
		$xml->startElement("OVERLAY");
		$xml->writeAttribute('OVERLAY_ID', $row['OVERLAY_ID']);
		$xml->writeAttribute('OVERLAY_TYPE', $row['OVERLAY_TYPE']);
		$xml->writeAttribute('ACTIVITY_NAME', $row['ACTIVITY_NAME']);
		$xml->writeAttribute('OVERLAY_NAME', $row['OVERLAY_NAME']);
		
		$pointQuery = "SELECT LATITUDE, LONGITUDE FROM POINTS WHERE OVERLAY_ID = $id;";
		$pointResult = mysql_query($pointQuery);
		while($pointRow = mysql_fetch_array($pointResult)) {
			$xml->startElement("COORDINATES");
			$xml->startElement("LATITUDE");
			$xml->writeRaw($pointRow['LATITUDE']);
			$xml->endElement();
			$xml->startElement("LONGITUDE");
			$xml->writeRaw($pointRow['LONGITUDE']);
			$xml->endElement();
			$xml->endElement();
		}
	}
}
$xml->endElement();
header('Content-type: text/xml');
$xml->flush();
?>
