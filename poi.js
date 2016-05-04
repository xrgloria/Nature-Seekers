/*
*Created by Gloria Ngo
*
*IS448 - Markup Languages
*Gloria Ngo
*
*Description: It uses Google's Map API to have a map drawn onto the page and to
*	be manipulated.
*
*File Contents: javascript
*/

var map;
var type;
var newOverlay;
var latPoints = [];
var lngPoints = [];

var drawingManager = new google.maps.drawing.DrawingManager();

google.maps.event.addDomListener(window, 'load', initMap);

function initMap() {
	map = new google.maps.Map(document.getElementById('map'), {
		center: {lat: 36.098967, lng: -112.100166},
		zoom: 17
	});
	
	var position = new google.maps.LatLng(36.098967, -112.100166);
	
	/*var string = "<div><p><strong>Name: </strong>Devil\'s Rock <br />" +
		"<strong>Activity: </strong>Rock Climbing <br />" + 
		"<strong>Description: </strong> Difficulty: 10a</p></div>";

	infoWindow = new google.maps.InfoWindow();
	
	infoWindow.setOptions({
		content: string,
		position: position,
	});
	infoWindow.open(map);
	
	marker = new google.maps.Marker({
			position: position,
			map: map
		});
	
	marker.setMap(map);*/

	drawingManager.setOptions({
		drawingMode : google.maps.drawing.OverlayType.MARKER,
		drawingControl : true,
		drawingControlOptions : {
			position : google.maps.ControlPosition.TOP_CENTER,
			drawingModes : [ 
				google.maps.drawing.OverlayType.MARKER,
				//google.maps.drawing.OverlayType.POLYGON,
				//google.maps.drawing.OverlayType.POLYLINE
				//google.maps.drawing.OverlayType.RECTANGLE 
			]
		},
		/*rectangleOptions : {
			editable: true,
			draggable: true
		},*/
		polygonOptions : {
			editable: true,
			draggable: true
		}
		
	});

	drawingManager.setMap(map);
	
	google.maps.event.addListener(drawingManager, 'polygoncomplete', function(polygon) {
		var coor = polygon.getPath().getArray();
		//alert(coor[0] + " LAT=" + coor[0].lat() + " LNG=" + coor[0].lng());
		
		newOverlay = polygon;
		//alert(newOverlay);
		type = 2;
		overlayComplete(coor);
	});
	
	google.maps.event.addListener(drawingManager, 'markercomplete', function(marker) {
		newOverlay = marker;
		//alert(newOverlay);
		type = 0;
		latPoints.push(marker.getPosition().lat());
		lngPoints.push(marker.getPosition().lng());
		
		//alert("lat=" + latPoints + " | lng=" + lngPoints);
		
		drawingManager.setOptions({
			drawingControl: false
		});
		drawingManager.setDrawingMode(null);
		//alert(latPoints + " " + lngPoints);
	});
	
	google.maps.event.addListener(drawingManager, 'polylinecomplete', function(polyline) {
		var coor = polyline.getPath().getArray();
		//alert(coordinates);	
		type = 1;
		newOverlay = polyline;	
		
		overlayComplete(coor);
	});
	//google.maps.event.addListener(drawingManager, 'circlecomplete', overlayComplete);
	//google.maps.event.addListener(drawingManager, 'rectanglecomplete', overlayComplete);
	
	google.maps.event.addDomListener(document.getElementById('create-new-button'), 'click', createNewOverlay);
}

//submitForm function
function submitForm() {
	//alert("Submitting form");
	//check if lat and lng points are empty
	if(isEmpty(latPoints) || isEmpty(lngPoints)) {
		alert("Please mark your Point of Interest before submitting.");
	//if they are filled submit the form
	} else {
		var latSubmit = document.getElementById('latInput');
		var lngSubmit = document.getElementById('lngInput');
		var typeSubmit = document.getElementById('typeInput');
		latSubmit.value = latPoints;
		lngSubmit.value = lngPoints;
		typeSubmit.value = type;
		
		//submit the form
		document.forms["formPoi"].submit();
	}
}

//overlayComplete function
function overlayComplete(coor) {
	//alert(coor);
	
	for(i = 0; i < coor.length; i++) {
		//alert("I'm in for-loop looping");
		latPoints.push(coor[i].lat());
		lngPoints.push(coor[i].lng());
	}
	
	//alert("lat=" + latPoints + " | lng=" + lngPoints);
	
	drawingManager.setOptions({
		drawingControl: false
	});
	drawingManager.setDrawingMode(null);
	//alert(latPoints + " " + lngPoints);
	
} 

//drawOverlay function
function createNewOverlay() {
	//alert("I'm being clicked!");
	latPoints = [];
	lngPoints = [];
	
	newOverlay.setMap(null);
	
	
	drawingManager.setOptions({
		drawingControl: true
	});
	
}

//deletePoi
function deletePoi(id) {
	alert("id= " + id + "\nRemoving now!");
	//implement ajax to connect to server and delete and remove from list
}

//isEmpty function
function isEmpty(value) {
	return (value == null || value.length === 0);
}