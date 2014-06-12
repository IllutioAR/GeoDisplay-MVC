var map;
var initialLocation;

function initialize() {
    var mapOptions = {
        zoom: 14,
        zoomControl: true
    };
    map = new google.maps.Map(document.getElementById("map"),
          mapOptions);
    if(navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
          initialLocation = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
          map.setCenter(initialLocation);
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

google.maps.event.addDomListener(window, 'load', initialize);