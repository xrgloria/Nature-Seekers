var map;
var marker;
var geocoder = new google.maps.Geocoder();

function initialize() {
    var myLatlng = new google.maps.LatLng(40.65, -74);
    var myOptions = {
        zoom: 10,
        center: myLatlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
    }
    map = new google.maps.Map(document.getElementById('map'), myOptions);
    var zoomLevel = map.getZoom();
    marker = new google.maps.Marker({
        position: myLatlng,
        map: map,
        draggable: true
    });
};

function moveMarker() {
    var lat = parseFloat(document.getElementById('latitude').value);
    var lng = parseFloat(document.getElementById('longitude').value);
    var newLatLng = new google.maps.LatLng(lat, lng);
    marker.setPosition(newLatLng);
    map.panTo(newLatLng);
}

function moveMarkerZipcode(latitude, longitude) {
    var lat = latitude;
    var lng = longitude;
    var newLatLng = new google.maps.LatLng(lat, lng);
    marker.setPosition(newLatLng);
    map.panTo(newLatLng);
}
google.maps.event.addDomListener(window, 'load', initialize);

function callPHP(latitude, longitude) {
    jQuery.noConflict();
    var bounds = map.getBounds()
    var northEast = bounds.getNorthEast();
    var southWest = bounds.getSouthWest();
    var latitudeTop = northEast.lat();
    var latitudeBottom = southWest.lat();
    var longitudeRight = northEast.lng();
    var longitudeLeft = southWest.lng();
    new Ajax.Request("search.php", {
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

function displayResult(ajax) {
  
    var pointsArray = ajax.responseText;
    var length = pointsArray.length;
    
      if(length>2){
      $('searchResult').innerHTML ="Results were found! The points are displayed on the map.";
        
         
    }
    else{
        $('searchResult').innerHTML ="There were no points of interest for this location.";
        //this fulfills a requirement for changing a CSS color
        document.getElementById('searchResult').style.color="red";
    }
 
    var coords = pointsArray.split(",");
    for (var x = 0; x < length - 1; x++) {
        var lat = parseFloat(coords[x]);
        var lng = parseFloat(coords[x + 1]);
        var myLatlng = new google.maps.LatLng(lat, lng);
        marker = new google.maps.Marker({
            position: myLatlng,
            map: map,
            draggable: true
        });
    }
    return true;
}

function geocodeAddress(geocoder, resultsMap, userLatitude, userLongitude) {
    var address = $("zip").value;
    geocoder.geocode({
        'address': address
    }, function(results, status) {
        if (status === google.maps.GeocoderStatus.OK) {
            var userLatitude = results[0].geometry.location.lat();
            var userLongitude = results[0].geometry.location.lng();
            moveMarkerZipcode(userLatitude, userLongitude);
            callPHP(userLatitude, userLongitude);
        } else {
            alert(
                'Geocode was not successful for the following reason: ' +
                status);
        }
    });
}

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
            if (validateCoordinates(longitude, latitude)) {
                moveMarker();
                callPHP(latitude, longitude);
            }
        }
    }
}

function validateBlank(city, state, zipcode, latitude, longitude) {
    var message = new Array();
    var isFilled = true;
    if (city.length == 0) {
        message.push("City")
        isFilled = false;
    }
    if (state.length == 0) {
        message.push("State")
        isFilled = false;
    }
    if (zipcode.length == 0) {
        message.push("Zipcode")
        isFilled = false;
    }
    if (latitude.length == 0) {
        message.push("Latitude")
        isFilled = false;
    }
    if (longitude.length == 0) {
        message.push("Longitude")
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
         document.getElementById('userprompt').style.color="red";
         document.getElementById('userprompt').style.fontSize = "xx-large";
        var fullMessage = "";
        for (i = 0; i < message.length; i++) {
            fullMessage += "," + message[i]
        }
        alert(
            "Please fill in all the necessary fields. The blank fields are"
            .concat(fullMessage));
        return false;
    } else {
        return true;
    }
}

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
        message.push("City");
        isCorrect = false;
    }
    if (resultState == false) {
        message.push("State");
        isCorrect = false;
    }
    if (resultZipcode == false) {
        message.push("Zipcode");
        isCorrect = false;
    }
    if (isCorrect == false) {
        var fullMessage = "";
        for (i = 0; i < message.length; i++) {
            fullMessage += "," + message[i]
        }
        alert("There are errors with the input. Please fix the format of: "
            .concat(fullMessage));
        return false;
    } else {
        return true;
    }
}

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


