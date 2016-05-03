
<?php
/*Author: Mia Frederick
Date 5/3/2016
IS 448
Professor Sampath
This php file searches my database for any points of interest. It uses this by using the range of coordinates from the Ajax request,
appends the results to a string, and then returns that string. 
*/

	//input being fed in from Ajax

		$latitudeTop  = $_GET['latitudeTop'];
		$latitudeBottom= $_GET['latitudeBottom'];
		$longitudeLeft = $_GET['longitudeLeft'];
		$longitudeRight = $_GET['longitudeRight'];
		
		
	//connecting to the database
	$db = mysql_connect("studentdb-maria.gl.umbc.edu", "xr43817", "xr43817");
	
	if (!$db)    exit("Error! Database not found.");
	$er = mysql_select_db("xr43817");
	
	if (!$er)    exit("Error, User not found.");
	//sql query
	$searchResults = mysql_query("SELECT * FROM POINTS WHERE latitude BETWEEN $latitudeBottom AND $latitudeTop AND longitude BETWEEN $longitudeLeft AND $longitudeRight");

                
    $resultFound = false;      

	$resultArray;

	//goes through all of the entries in the table 

	while ($row_array = mysql_fetch_array($searchResults)) {
		$latitude  = $row_array["latitude"];
		$longitude = $row_array["longitude"];
		
		//appends the coordinates to a long string
		$coordinates=$latitude.",".$longitude.",";
		$resultArray .= $coordinates; 
		
	}
	//response text 
	echo $resultArray;
	
   

?>