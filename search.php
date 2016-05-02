
<?php


	//gets the data from the same page and stays there
    // for testing to actually see listed results, just put 3 in latitude and longitude 

		$latitudeTop  = $_GET['latitudeTop'];
		$latitudeBottom= $_GET['latitudeBottom'];
		$longitudeLeft = $_GET['longitudeLeft'];
		$longitudeRight = $_GET['longitudeRight'];
		
		
    

	//connecting to the database
	$db = mysql_connect("studentdb-maria.gl.umbc.edu", "mia5", "carrot");
	
	if (!$db)    exit("Error! Database not found.");
	$er = mysql_select_db("mia5");
	
	if (!$er)    exit("Error, User not found.");
	//sql query
	$searchResults = mysql_query("SELECT * FROM POINTS WHERE latitude BETWEEN $latitudeBottom AND $latitudeTop AND longitude BETWEEN $longitudeLeft AND $longitudeRight");

                
    $resultFound = false;      

	$resultArray;

	//goes through all of the entries in the table 

	while ($row_array = mysql_fetch_array($searchResults)) {
		$latitude  = $row_array["latitude"];
		$longitude = $row_array["longitude"];
		
		
		$coordinates=$latitude.",".$longitude.",";
		$resultArray .= $coordinates; 
		
	}
	echo $resultArray;
	
   

?>