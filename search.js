/*Author: Mia Frederick
Date 5/3/2016
IS 448
Professor Sampath
This document drives the Search Use Case. It creates a google map, validates user inputs, moves the map, and checks
the database to see if there are any markers that match. If there are markers, it then displays them to the user. 
*/

var map;
var marker;
var geocoder = new google.maps.Geocoder();

/*
This initializes the google maps and set the marker at New York City. 
It also sets the user's marker red to distinguish it from the other markers. 
*/
function initialize() {
    var myLatlng = new google.maps.LatLng(40.65, -74);
    var myOptions = {
        zoom: 10,
        center: myLatlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
    }
    map = new google.maps.Map(document.getElementById('map'), myOptions);
    var zoomLevel = map.getZoom();
	var  icon = "http://maps.google.com/mapfiles/ms/icons/red.png";
    marker = new google.maps.Marker({
        position: myLatlng,
        map: map,
        draggable: true,
	 icon: new google.maps.MarkerImage(icon)
    });
};

//creates the map onload
google.maps.event.addDomListener(window, 'load', initialize);

/*
this function drives the entire program. It calls the city, state, zipcode, latitude, longitude from the user.
It does the validation, and once the validation has passed it will call the methods needed to search the database.
If zipcode is entered, it calls geocodeAddress to get the coordinates, which then calls moveMarkerZipcode, then callPHP.
If coordinates are entered, it uses callPHP to search the database. 
*/
function validate() {
    var city = $("city").value;
    var state = $("state").value;
    var zipcode = $("zip").value;
    var latitude = $("latitude").value;
    var longitude = $("longitude").value;
    if (validateBlank(city, state, zipcode, latitude, longitude)) {
        if (latitude.length == 0 && longitude.length == 0) {
            if (validateAddress(city, state, zipcode)) {
                geocodeAddress(geocoder, map);
            }
        } else {
            if (validateCoordinates(latitude,longitude)) {
                moveMarker();
                callPHP(latitude, longitude);
            }
        }
    }
}

/*
If coordinates are entered, this places a marker at the user coordinates and then moves the map to the location.
*/
function moveMarker() {
    var lat = parseFloat(document.getElementById('latitude').value);
    var lng = parseFloat(document.getElementById('longitude').value);
    var newLatLng = new google.maps.LatLng(lat, lng);
    marker.setPosition(newLatLng);
    map.panTo(newLatLng);
}

/*
If a zipcode was entered, it takes in latitude/longitude, and then  places a marker at the user coordinates and then moves the map to the location.
*/
function moveMarkerZipcode(latitude, longitude) {
    var lat = latitude;
    var lng = longitude;
    var newLatLng = new google.maps.LatLng(lat, lng);
    marker.setPosition(newLatLng);
    map.panTo(newLatLng);
}

/*
This searches the database by using latitude and longitude. Once the map is moved to the user inputted coordinates, it 
creates a range to look for by using the bounds of the map. It creates a range by grabbing
the coordinates at the corners of the map. These map bounds are fed into SearchDatabase.php using an Ajax request. 
On success, it calls displayResult.
*/
function callPHP(latitude, longitude) {
	//even though we don't use jQuery, bootstrap does, so we had to use this to get Ajax to work.
    jQuery.noConflict();
    var bounds = map.getBounds()
    var northEast = bounds.getNorthEast();
    var southWest = bounds.getSouthWest();
    var latitudeTop = northEast.lat();
    var latitudeBottom = southWest.lat();
    var longitudeRight = northEast.lng();
    var longitudeLeft = southWest.lng();
	//ajax request
    new Ajax.Request("searchDatabase.php", {
        method: "get",
        parameters: {
            latitudeTop: latitudeTop,
            longitudeLeft: longitudeLeft,
            latitudeBottom: latitudeBottom,
            longitudeRight: longitudeRight,
        },
        onSuccess: displayResult
    });
}

/* If callPHP succeeds, this shows the results */
function displayResult(ajax) {
  
    var pointsArray = ajax.responseText;
    var length = pointsArray.length;
    
	//if the text returned is longer than 2, then results were found. the reason it's 2 instead of 
	//0 is because in searchDatabase.php I append 2 commas.
      if(length>2){
      $('searchResult').innerHTML ="Results were found! The points are displayed on the map.";
        
    }
    else{
        $('searchResult').innerHTML ="There were no points of interest for this location.";
        //this highlights the fact that no results were found. 
        document.getElementById('searchResult').style.color="red";
    }
	
	//creates a green icon for other found points of interest
	var  icon = "http://maps.google.com/mapfiles/ms/icons/green.png";

	//converts the response string into usable coordinates
	//does this by stripping the commas 
    var coords = pointsArray.split(",");
    for (var x = 0; x < length - 1; x++) {
        var lat = parseFloat(coords[x]);
        var lng = parseFloat(coords[x + 1]);
        var myLatlng = new google.maps.LatLng(lat, lng);
        marker = new google.maps.Marker({
            position: myLatlng,
            map: map,
            draggable: true,
			icon: new google.maps.MarkerImage(icon)
        });
    }
    return true;
}

//this is used to access google's library of zipcodes, and rip their coordinates from the zipcode.
//this makes it much easier to use the map.
function geocodeAddress(geocoder, resultsMap, userLatitude, userLongitude) {
    var address = $("zip").value;
    geocoder.geocode({
        'address': address
    }, function(results, status) {
        if (status === google.maps.GeocoderStatus.OK) {
            var userLatitude = results[0].geometry.location.lat();
            var userLongitude = results[0].geometry.location.lng();
			//moves the user inputted marker and pans the map
            moveMarkerZipcode(userLatitude, userLongitude);
			//checks to see if there are any matching points at that zipcode
            callPHP(userLatitude, userLongitude);
        } else {
            alert(
                'Geocode was not successful for the following reason: ' +
                status);
        }
    });
}

/*this makes sure that the fields are not all blank. It also checks if
they fill in city, state and zipcode it will accept it. If they only
fill in latitude and longitude it is okay as well.*/
function validateBlank(city, state, zipcode, latitude, longitude) {
    var message = new Array();
    var isFilled = true;
    if (city.length == 0) {
        message.push("city");
        isFilled = false;
    }
    if (state.length == 0) {
        message.push("state");
        isFilled = false;
    }
    if (zipcode.length == 0) {
        message.push("zip");
        isFilled = false;
    }
    if (latitude.length == 0) {
        message.push("latitude");
        isFilled = false;
    }
    if (longitude.length == 0) {
        message.push("longitude");
        isFilled = false;
    }
    if (zipcode.length == 0 && latitude.length != 0 && longitude.length !=
        0) {
        isFilled = true;
    }
    if (zipcode.length != 0 && latitude.length == 0 && longitude.length ==
        0) {
        isFilled = true;
    }
    if (isFilled == false) {

        var fullMessage = "";
		//iterates through and compiles the error message
        for (i = 0; i < message.length; i++) {
            fullMessage += "," + message[i]
			//changes the input text border to make sure the user understands what to do
		
			if(message[i]!=null){

				document.getElementById(message[i]).style.borderColor="red";
			}
			
        }
        alert(
            "Please fill in all the necessary fields. The blank fields are"
            .concat(fullMessage));
        return false;
    } else {
        return true;
    }
}

//this function validates the address. City can only contain letters or preapproved characters.
//The state has to match one of the capitals below. 
//regex library online was used as a reference
//zipcode also needs to be in an approved pattern, it can have 5 numbers or have 5 numbers-4 numbers
function validateAddress(city, state, zipcode) {
    var patternCity = /^[a-zA-Z]+(?:[\s-][a-zA-Z]+)*$/
    var patternState =
        /^(?:A[KLRZ]|C[AOT]|D[CE]|FL|GA|HI|I[ADLN]|K[SY]|LA|M[ADEINOST]|N[CDEHJMVY]|O[HKR]|PA|RI|S[CD]|T[NX]|UT|V[AT]|W[AIVY])*$/
    var patternZipcode = /^([0-9]{5}(?:-[0-9]{4})?)*$/
    var resultCity = patternCity.test(city);
    var resultState = patternState.test(state);
    var resultZipcode = patternZipcode.test(zipcode);
    var message = new Array();
    var isCorrect = true;
    if (resultCity == false) {
        message.push("city");
        isCorrect = false;
    }
    if (resultState == false) {
        message.push("state");
        isCorrect = false;
    }
    if (resultZipcode == false) {
        message.push("zip");
        isCorrect = false;
    }
    if (isCorrect == false) {
        var fullMessage = "";
        for (i = 0; i < message.length; i++) {
            fullMessage += "," + message[i]
			if(message[i]!=null){
				document.getElementById(message[i]).style.borderColor="red";
			}
        }
        alert("There are errors with the input. Please fix the format of: "
            .concat(fullMessage));
        return false;
    } else {
        return true;
    }
}

//validates the coordinates, makes sure that latitude and longitude is in Signed Degrees Format and in a correct range.
//This means no letters denoting N,S, W or E. Instead, positive or negative helps denote those directions.
function validateCoordinates(latitude, longitude) {


    var pattern = /^\-?\d{1,3}\.?\d{0,8}$/
    var resultLatitude = pattern.test(latitude);
    var resultLongitude = pattern.test(longitude);
    if (resultLatitude == true && resultLongitude == true) {
        if (latitude < -90 || latitude > 90) {
            alert(
                "Latitudes can only fall within the range -90 to 90. Please enter the correct latitude."
            );
            return false;
        } else if (longitude < -180 || longitude > 180) {
            alert(
                "Longitudes can only fall within the range -180 to 180. Please enter the correct longitude."
            );
            return false;
        } else {
            return true;
        }
    } else {
        alert(
            "The coordinates need to be in Signed Degrees Format. For example, 41.25 and -120.9762. Please enter the coordinates in the correct format."
        );
        return false;
    }
}


