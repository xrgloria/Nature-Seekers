 var map;
 var overlays;
 var infoWindows = [];
function initMap() {
	map = new google.maps.Map(document.getElementById('map'), {
	  center: {lat: 38.940965, lng: -77.127542},
	  zoom: 14
	});
	updateMap();
}


function updateMap(){
	new Ajax.Request("./getOverlays.php",{
		method: 'get',
		onSuccess: redrawMap
	});
}


function redrawMap(ajax){
	overlays = JSON.parse(ajax.responseText);
	for(i in overlays){
		newOverlay = new google.maps.Marker({
			map: map,
			position: overlays[i]['POINTS'][0]
			});
		listenerAdd(i, newOverlay)
		
}

function listenerAdd(idTemp, overlayTemp){
	overlayTemp.addListener('click', function(e) {
				addToRoute(idTemp)
			});
		}
}

function addToRoute(id){
	var routeList = document.getElementById("overlayList");
	var classColor = "route-B";
	if(routeList.LastChild === undefined){
		classColor = "route-A";
	} else if(routeList.LastChild.class == 'route-B'){
		classColor = "route-A";
	}
	routeList.innerHTML += '<div class="' + classColor + '" id="' + id + '">' + '<b>' + overlays[id]['OVERLAY_NAME'] + '</b><br />' + overlays[id]['ACTIVITY_NAME'] + '<br />' + '<button type="button" class="btn btn-primary btn-xs removeButton" onclick="removeOverlay(' + id + ')">Remove</button><br />' + '<input type="hidden" name="overlayID[]" value="' + id + '"/></div>';
	
}


function removeOverlay(id){
	var overlay = document.getElementById(id);
	overlay.style.visibility = "hidden";
	overlay.remove();
}

