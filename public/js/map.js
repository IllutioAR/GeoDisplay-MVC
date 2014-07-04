var map;
var initialLocation;
var marker;

function initialize() {
	var mapOptions = {
		zoom: 16,
		zoomControl: true,
		streetViewControl: false
	};
	map = new google.maps.Map(document.getElementById("map"),
		mapOptions);

	if(navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function(position) {
			initialLocation = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
			map.setCenter(initialLocation);
			marker = new google.maps.Marker({
			    position: initialLocation,
			    draggable: true,
			    animation: google.maps.Animation.DROP
			});
			marker.setMap(map);
			setPositionForm();
		}, function() {
			handleNoGeolocation();
		});
	}
	else {
		handleNoGeolocation();
	}

	function handleNoGeolocation(){
		var illutio = new google.maps.LatLng(20.680985099999997, -103.38298850000001);
		map.setCenter(illutio);
	}
}

function setPositionForm(){
	if ( marker != null ){
		var markerLatLng = marker.getPosition();
		document.getElementById('latitude').value = markerLatLng.lat().toFixed(6);
		document.getElementById('longitude').value = markerLatLng.lng().toFixed(6);
	}else{
		window.setTimeout("setPositionForm();",10);
	}
	google.maps.event.addListener(marker, 'mouseup', function() {
		setPositionForm();
	});
} 

google.maps.event.addDomListener(window, 'load', initialize);