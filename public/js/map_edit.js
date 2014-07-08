var map;
var initialLocation;
var marker;

function initialize() {
	var mapOptions = {
		zoom: 18,
		zoomControl: true,
		streetViewControl: false
	};
	map = new google.maps.Map(document.getElementById("map"),
		mapOptions);

	initialLocation = new google.maps.LatLng(document.getElementById('latitude').value, 
											 document.getElementById('longitude').value);
	map.setCenter(initialLocation);
	marker = new google.maps.Marker({
	    position: initialLocation,
	    draggable: true,
	    animation: google.maps.Animation.DROP
	});
	marker.setMap(map);
	google.maps.event.addListener(marker, 'mouseup', function() {
		setPositionForm();
	});

}

function setPositionForm(){
	if ( marker != null ){
		var markerLatLng = marker.getPosition();
		document.getElementById('latitude').value = markerLatLng.lat().toFixed(6);
		document.getElementById('longitude').value = markerLatLng.lng().toFixed(6);
	}else{
		window.setTimeout("setPositionForm();",10);
	}
} 

google.maps.event.addDomListener(window, 'load', initialize);