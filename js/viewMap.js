 var map;
function initMap() {
	map = new google.maps.Map(document.getElementById('map'), {
	  center: {lat: 38.940965, lng: -77.127542},
	  zoom: 14
	});
	
	marker = new google.maps.Marker({
		map: map,
		draggable: true,
		position: {lat: 38.929515, lng:  -77.116106}
	});
	
	var infoWindow = new google.maps.InfoWindow();
	var contentString = "<b>Activity:</b> Sightseeing<br />" +
						"<b>Description:</b> Top of the chain bridge, not very" +
						"exciting<br/>" +
						"<button class=\"btn btn-primary btn-xs\">Add</button>";
	infoWindow.setContent(contentString);
	infoWindow.setPosition(marker.getPosition());

	infoWindow.open(map);
	
	var littleFallsCoords = [
		{lat: 38.946706, lng: -77.125461},
		{lat: 38.947173, lng: -77.127542},
		{lat: 38.940965, lng: -77.127542},
		{lat: 38.934756, lng: -77.119818},
		{lat: 38.932219, lng: -77.117243}
	];
	var littleFalls = new google.maps.Polyline({
		path: littleFallsCoords,
		geodesic: true,
		strokeColor: '#FF0000',
		strokeOpacity: 1.0,
		strokeWeight: 4
	});
	
	var coCoords = [
		{lat: 38.930617, lng: -77.113016},
		{lat: 38.935023, lng: -77.115741},
		{lat: 38.939062, lng: -77.121534},
		{lat: 38.943802, lng: -77.123809},
		{lat: 38.948475, lng: -77.126341}
	];
	var co = new google.maps.Polyline({
		path: coCoords,
		geodesic: true,
		strokeColor: '#FFFF00',
		strokeOpacity: 1.0,
		strokeWeight: 4
	});

  littleFalls.setMap(map);
  co.setMap(map);
}