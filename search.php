
<?php


$file = 'people.txt';
// Open the file to get existing content
$current = file_get_contents($file);
// Append a new person to the file
$current .= "John Smith\n";
// Write the contents back to the file
file_put_contents($file, $current);

	//gets the data from the same page and stays there
    // for testing to actually see listed results, just put 3 in latitude and longitude 

		$userLatitude  = $_GET['latitude'];
		$userLongitude = $_GET['longitude'];
    

	//connecting to the database
	$db = mysql_connect("studentdb-maria.gl.umbc.edu", "mia5", "carrot");
	
	if (!$db)    exit("Error! Database not found.");
	$er = mysql_select_db("mia5");
	
	if (!$er)    exit("Error, User not found.");
	//sql query
	$searchResults = mysql_query("SELECT * FROM POINTS");
                
    $resultFound = false;             
	//goes through all of the entries in the table 
	while ($row_array = mysql_fetch_array($searchResults)) {
		$latitude  = $row_array['latitude'];
		$longitude = $row_array['longitude'];
		
		//looks for results that match
		if ($latitude == $userLatitude and $longitude == $userLongitude) {
			echo "A match was found at latitude: ". $latitude ." longitude: ". $longitude."\r\n";
            $resultFound=true;
		}

	}
        //if no results were found, then it tells the user that
        if(!$resultFound)
            echo "No points were found that matched those coordinates.";
   

?>