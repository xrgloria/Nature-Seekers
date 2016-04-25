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
$sql = "SELECT O.OVERLAY_ID, O.TYPE, P.LATITUDE, P.LONGITUDE
		FROM OVERLAYS O
		JOIN POINTS P
		ON O.OVERLAY_ID = P.OVERLAY_ID
		WHERE O.OVERLAY_ID IN (SELECT OVERLAY_ID FROM POINTS WHERE LATITUDE BETWEEN $latitudeBottom AND $latitudeTop 
			AND LONGITUDE BETWEEN $longitudeLeft AND $longitudeRight);";
$result = mysql_query($sql);

$xml = new XMLWriter();

$xml->openURI("php://output");
$xml->startDocument();
$xml->setIndent(true);

$xml->startElement('overlays');
$previousOverlayID = -1;

if (mysql_num_rows($result) > 0) {
    while($row = mysql_fetch_array($result)) {
		if($row['OVERLAY_ID'] != $previousOverlayID){
			if($previousOverlayID != -1){
				$xml->endElement();
			}

			$xml->startElement("overlay");
			$xml->writeAttribute('OVERLAY_ID', $row['OVERLAY_ID']);
			$xml->writeAttribute('TYPE', $row['OVERLAY_TYPE']); 	
		}
		$xml->startElement("coordinate");
		$xml->startElement("latitude");
		$xml->writeRaw($row['LATITUDE']);
		$xml->endElement();
		$xml->startElement("longitude");
		$xml->writeRaw($row['LONGITUDE']);
		$xml->endElement();
		$xml->endElement();
		$previousOverlayID = $row['OVERLAY_ID'];
	}
}

$xml->endElement();
$xml->endElement();

header('Content-type: text/xml');
$xml->flush();
?>
