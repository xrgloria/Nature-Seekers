<!DOCTYPE html>
<!-- 
Author: Mia Frederick
Date 3/12/16
IS 448
Professor Sampath
This document will fullfill the Search Use Case for Vestigetek Group Project. The CSS style used is mia.css
The Validation will not be perfect, but it is due to the jQuery Library and the compiled JavaScript. 
-->
<html>
<head>
    <title>Test site</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous" />
    <link rel="stylesheet" href="./style/lavish-bootstrap.css" />
    <link rel="stylesheet" href="./style/mia.css" />
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
<div class="navbar navbar-inverse" style="border-radius:0pt;">
    <div class="content">
        <span class="navbar-brand">
            Nature Seekers
        </span>
        <ul class="nav navbar-nav">
            <li><a href="./login.php">Home</a></li>
            <li class="active"><a href="./search.html">View Map</a></li>
            <li><a href="./points_of_interest.html ">Add Markers</a></li>
            <li ><a href="#">View Route</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="./logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
        </ul>
    </div>
</div>
<div class="row content">
    <div class="col-sm-3">
        <div class="panel panel-primary" >
            <div class="panel-heading">
                <h3>Search</h3>
            </div>
            <div class="panel-body">
                <form action="" method="post">
                    <label for="cityName">City Name</label>
                    <input type="text" class="form-control" name="city" id="cityName" value="Baltimore" />
                    <label for="stateName">State</label>
                    <input type="text" class="form-control" name="state" id="stateName" value="Maryland" />
                    <label for="zipcode">ZipCode</label>
                    <input type="text" class="form-control" name="zip" id="zipcode" />
                     <label for="latitude">Latitude</label>
                    <input type="text" class="form-control" name="latitude" id="latitude" />
                    <label for="longitude">Longitude</label>
                    <input type="text" class="form-control" name="longitude" id="longitude" />
                    <br />
                    <input name="submit" type="submit" name = "submit"/>
                </form>
            </div>
        </div>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3>Results </h3>
            </div>
            <div class="panel-body">
            <div class="panel-title">
                             <?php
	//gets the data from the same page and stays there
    // for testing to actually see listed results, just put 3 in latitude and longitude 
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$userLatitude  = $_POST['latitude'];
		$userLongitude = $_POST['longitude'];
	}

	//connecting to the database
	$db = mysql_connect("studentdb-maria.gl.umbc.edu", "mia5", "carrot");
	
	if (!$db)    exit("Error! Database not found.");
	$er = mysql_select_db("mia5");
	
	if (!$er)    exit("Error, User not found.");
	//sql query
	$searchResults = mysql_query("SELECT * FROM POINTS");
                
	//goes through all of the entries in the table 
	while ($row_array = mysql_fetch_array($searchResults)) {
		$latitude  = $row_array['latitude'];
		$longitude = $row_array['longitude'];
		//looks for results that match
		
		if ($latitude == $userLatitude and $longitude == $userLongitude) {
			print "$latitude , $longitude";
		}

	}

	?>
               </div>
            </div>
        </div>
    </div>
    <div class="col-sm-9">
        <h3>Google Maps</h3>
        <hr />
        <iframe
  width="100%"
  height="657"
  frameborder="0" style="border:solid #335216 .5em"
  src="https://www.google.com/maps/embed/v1/place?key=AIzaSyCLc5AIKWU7lm7hbUWW48lc_TkRvyIoy4w
    &q=Patapsco+Valley+State+Park" allowfullscreen>
</iframe>
    </div>
</div>
</body>
</html>