<?php
session_start();
$db = mysql_connect("localhost","root","root");

if(!$db)
	exit("Error - could not connect to MySQL");

#select database natureseekers
$er = mysql_select_db("natureseekers");
if(!$er)
	exit("Error - could not select database");
$user = $_SESSION['user_id'];
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