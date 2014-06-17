var map;
var initialLocation;
var marker;

var infowindow = null;

function openInfoWindow() {
  var markerLatLng = marker.getPosition();
	document.getElementById('latitude').value = markerLatLng.lat();
	document.getElementById('longitude').value = markerLatLng.lng();
    infowindow.setContent([
      'Your position is: ',
      markerLatLng.lat(),
      markerLatLng.lng()
    ].join(''));
    infowindow.open(map, marker);
}

function initialize() {
	var mapOptions = {
		zoom: 14,
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

	function handleNoGeolocation() {
		var newyork = new google.maps.LatLng(40.69847032728747, -73.9514422416687);
		map.setCenter(newyork);
	}
}

function setPositionForm(){
	if ( marker != null ){
		var markerLatLng = marker.getPosition();
		document.getElementById('latitude').value = markerLatLng.lat();
		document.getElementById('longitude').value = markerLatLng.lng();
		infowindow = new google.maps.InfoWindow({
			maxWidth: 140
		});
		google.maps.event.addListener(marker, 'mouseup', function() {
			openInfoWindow();
		});
	}else{
		window.setTimeout("setPositionForm();",100);
	}
	openInfoWindow();
} 

google.maps.event.addDomListener(window, 'load', initialize);