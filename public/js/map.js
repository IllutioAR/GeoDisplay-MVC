var map;
var initialLocation;
var marker = null;
var searchBox;

function initialize() {
	var mapOptions = {
		zoom: 16,
		zoomControl: true,
		streetViewControl: false
	};
	map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
	
	//Se selecciona el elemento html para la caja de busqueda y se posiciona en el mapa
	var input = ( document.getElementById('map-search') );
	map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
	searchBox = new google.maps.places.SearchBox((input));

	//Se llama el método search_place al buscar un lugar
	google.maps.event.addListener(searchBox, 'places_changed', search_place);

	google.maps.event.addListener(map, 'bounds_changed', function() {
	    var bounds = map.getBounds();
	    searchBox.setBounds(bounds);
	    input.style.display = "block";
	});

	if(navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function(position) {
			initialLocation = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
			map.setCenter(initialLocation);

			var contentString = "Arrastra el marker para localizar un punto!<br>Drag the marker to locate a point!";

			var infowindow = new google.maps.InfoWindow({
				content: contentString
			});

			marker = new google.maps.Marker({
			    position: initialLocation,
			    draggable: true,
			    animation: google.maps.Animation.DROP
			});

			marker.setMap(map);
			setPositionForm();

			infowindow.open(map,marker);

			google.maps.event.addListener(marker, "mousedown", function() {
				infowindow.close();
			});
		}, function() {
			handleNoGeolocation();
		});
	}else {
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
		window.setTimeout("setPositionForm();",500);
	}
	google.maps.event.addListener(marker, 'mouseup', function() {
		setPositionForm();
	});
} 

function search_place(){
	var places = searchBox.getPlaces();

    if (places.length == 0) {
    	return;
    }
    marker.setMap(null);

    //For each place, get place name, and location.
    var bounds = new google.maps.LatLngBounds();

    console.log(places[0]);
    
    var place = places[0];
    //Crea un marker
    marker = new google.maps.Marker({
        title: place.name,
        position: place.geometry.location,
        draggable: true
    });
    marker.setMap(map);
	setPositionForm();

    bounds.extend(place.geometry.location);
    map.fitBounds(bounds);
}

google.maps.event.addDomListener(window, 'load', initialize);