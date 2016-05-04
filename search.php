<?php ini_set('display_errors', 1);
session_start();
if(!isset($_SESSION['user_id'])){
	header('Location: ./login.php');
	}
?>
<!DOCTYPE html>
<!-- 
Author: Mia Frederick
Date 5/3/2016
IS 448
Professor Sampath
This document will fullfill the Search Use Case for Vestigetek Group Project. The CSS style used is mia.css
It also calls search.js, searchDatabase.php, and uses various Ajax Prototype/Google Map Libraries.
If you want to test a successful case:

City: Ellicott City
State: MD
Zipcode: 21042
or
Coordinates: 

39.304125
-76.788064


You can test other things, but either City, State, Zipcode are all required or latitude and longitude. You cannot put in only city or only state.
-->
<html>
<head>


	
    <title>Nature Seekers</title><!-- Latest compiled and minified CSS -->
    <link crossorigin="anonymous" href=
    "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
    integrity=
    "sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
    rel="stylesheet">
    <link href="./style/lavish-bootstrap.css" rel="stylesheet">
    <link href="./style/mia.css" rel="stylesheet"><!-- jQuery library -->

    <script src=
    "https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js">
    </script>
    <script src=
    "http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js">
    </script>
    <script src=
    "http://ajax.googleapis.com/ajax/libs/prototype/1.6.0.3/prototype.js" type=
    "text/javascript">
    </script>
   <!-- Mia's Google API with Key -->
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCLc5AIKWU7lm7hbUWW48lc_TkRvyIoy4w&v=3.exp&sensor=false"></script>
    <!-- Mia's Javascript -->
	<script src="search.js" type="text/javascript"></script>
    
 
   
</head>
<body>
    <div class="navbar navbar-inverse" style="border-radius:0pt;">
        <div class="content">
            <span class="navbar-brand">Nature Seekers</span>
            <ul class="nav navbar-nav">
                <li>
                    <a href="./login.php">Home</a>
                </li>
                <li class="active">
                    <a href="./search.php">View Map</a>
                </li>
                <li>
                    <a href="./points_of_interest.html">Add Markers</a>
                </li>
                <li>
                    <a href="#">View Route</a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="./logout.php"><span class=
                    "glyphicon glyphicon-log-out"></span> Logout</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="row content">
        <div class="col-sm-3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3>Search</h3>
                </div>
                <div class="panel-body" id="searchBody">
                    <p id = "userprompt"> Please enter either City, State and Zipcode or Latitude and Longitude</p>
                    <!--Got rid of the form because it was disrupting the Google Maps -->
                        <label for="city">City Name</label> <input class=
                        "form-control" id="city" name="city" type="text">
                        <label for="state">State Abbreviation</label>
                        <input class="form-control" id="state" name="state"
                        type="text"> <label for="zip">ZipCode</label>
                        <input class="form-control" id="zip" name="zip" type=
                        "text"> <label for="latitude">Latitude in Signed
                        Degrees Format</label> <input class="form-control" id=
                        "latitude" name="latitude" type="text"> <label for=
                        "longitude">Longitude in Signed Degrees Format</label>
                        <input class="form-control" id="longitude" name=
                        "longitude" type="text"><br>
                        <input name="submit" type="submit" onclick="validate()">
                    <!--</form> -->
                </div>
            </div>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3>Results</h3>
                </div>
				
                <div class="panel-body" id="resultBody">
                    <div class="panel-title"></div>
					<span id="searchResult"></span>
                </div>
            </div>
        </div>
        <div class="col-sm-9">
            <h3>Google Maps</h3>
            <hr>
            <div id="map"></div>
        </div>
    </div>
</body>
</html>
