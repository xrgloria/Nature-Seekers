var map;
function initMap() {
	inputType = -1;
	map = new google.maps.Map(document.getElementById('map'), {
	  center: {lat: 38.341656, lng: -76.508789},
	  zoom: 8
	});
	
	
	var drawingManager = new google.maps.drawing.DrawingManager({
    drawingMode: google.maps.drawing.OverlayType.MARKER,
    drawingControl: true,
    drawingControlOptions: {
      position: google.maps.ControlPosition.TOP_CENTER,
      drawingModes: [
        google.maps.drawing.OverlayType.MARKER,
        google.maps.drawing.OverlayType.POLYGON,
        google.maps.drawing.OverlayType.POLYLINE
      ]
    }
	});
	
	drawingManager.setMap(map);

}



