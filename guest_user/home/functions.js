// Function to get URL parameters
function getUrlParameter(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    var results = regex.exec(location.search);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
}

function geocodeDestination(callback) {
    var destinationInput = document.getElementById('destination').value;

    if (destinationInput.trim() !== '') {
        // Make a request to Nominatim API for geocoding
        fetch(`https://nominatim.openstreetmap.org/search?q=${destinationInput}&format=json`)
            .then(response => response.json())
            .then(data => {
                if (data && data.length > 0) {
                    var destinationCoordinates = [parseFloat(data[0].lat), parseFloat(data[0].lon)];
                    map.setView(destinationCoordinates, 15);
                    
                    if (destinationMarker) {
                        map.removeLayer(destinationMarker);
                        map.removeLayer(destinationCircle);
                    }

                    destinationMarker = L.marker(destinationCoordinates, {
                        icon: L.icon({
                            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
                            iconSize: [25, 41],
                            iconAnchor: [12, 41],
                            popupAnchor: [1, -34],
                        })
                    }).addTo(map);
                    destinationCircle = L.circle(destinationCoordinates, {
                        color: 'red',
                        fillColor: 'red',
                        fillOpacity: 0.5,
                        radius: 20
                    }).addTo(map);

                    desMarkerLatLng = destinationMarker.getLatLng();
                    destinationMarker.bindPopup('Your destination.').openPopup();
                    console.log('sample: ', desMarkerLatLng.lat);

                } else {
                    alert('Destination not found. Please enter a valid address.');
                }
            })
            .catch(error => {
                console.error('Error fetching geocoding data:', error);
            });
    } else {
        alert('Please enter a destination address.');
    }   
}

function geocodeOrigin(numPassenger) {
    var originInput = document.getElementById('origin').value;

    if (originInput.trim() !== '') {
        // Make a request to Nominatim API for geocoding
        fetch(`https://nominatim.openstreetmap.org/search?q=${originInput}&format=json`)
            .then(response => response.json())
            .then(data => {
                if (data && data.length > 0) {
                    var originCoordinates = [parseFloat(data[0].lat), parseFloat(data[0].lon)];

                    if (originMarker) {
                        map.removeLayer(originMarker);
                        map.removeLayer(originCircle);
                    }

                    originMarker = L.marker(originCoordinates).addTo(map);
                    originCircle = L.circle(originCoordinates, {
                        color: '#20A2AA',
                        fillColor: '#20A2AA',
                        fillOpacity: 0.5,
                        radius: 20
                    }).addTo(map);

                    originMarker.bindPopup('Your origin.').openPopup();
                    originLatLng = originMarker.getLatLng();
                    destinationLatLng = destinationMarker.getLatLng();
                    defineMarker(originLatLng, destinationLatLng, numPassenger);
                
                } else {
                    alert('Origin not found');
                }
            })
            .catch(error => {
                console.error('Error fetching geocoding data:', error);
            });
    } else {
        alert('Please enter an origin destination address.');
    }
}

function computeDistance(busRoutePathCoordinates){
    var totalBusDistance = 0;
    for (var l = 0; l < busRoutePathCoordinates.length -1 ; l++) {
                var firstroute = busRoutePathCoordinates[l];
                var nextroute = busRoutePathCoordinates[l + 1];
                        
                var distance = L.latLng(firstroute[0], firstroute[1]).distanceTo(L.latLng(nextroute[0], nextroute[1]));

                totalBusDistance += distance;
            }

        var totalKm = (totalBusDistance / 1000).toFixed(2);
    return parseFloat(totalKm);

}

function computeJeepDistance(jeepRoutePathCoordinates){
    var totalJeepDistance = 0;
    for (var l = 0; l < jeepRoutePathCoordinates.length -1 ; l++) {
                var firstroute = jeepRoutePathCoordinates[l];
                var nextroute = jeepRoutePathCoordinates[l + 1];
                        
                var distance = L.latLng(firstroute[0], firstroute[1]).distanceTo(L.latLng(nextroute[0], nextroute[1]));

                totalJeepDistance += distance;
            }

        var totalKm = (totalJeepDistance / 1000).toFixed(2);
    return parseFloat(totalKm);
}

function computeETA(busDistance){
    var averageSpeedKph = 23; 
    var travelTimeHours = busDistance / averageSpeedKph;
    var travelTimeMinutes = travelTimeHours * 60;
    var etaMinutes = Math.round(travelTimeMinutes);
    console.log("ETA: " + etaMinutes + "m");

    return etaMinutes;
}
function computeJeepETA(jeepDistance){
    var averageSpeedKph = 21; 
    var travelTimeHours = jeepDistance / averageSpeedKph;
    var travelTimeMinutes = travelTimeHours * 60;
    var etaMinutes = Math.round(travelTimeMinutes);
    console.log("ETA: " + etaMinutes + "m");

    return etaMinutes;
}

function findNearestJeepCoordinates(targetLatLng, jRoutes){

    var nearestDistance = Number.MAX_VALUE;
    var nearestCoordinate = null;
    var nearestIndex = -1;

    for (var i = 1; i < jRoutes.length; i++) {
        var route = jRoutes[i];
        var routeLatLng = L.latLng(route.latitude, route.longitude); // Create LatLng object properly
        var distance = targetLatLng.distanceTo(routeLatLng);
        
        if (distance < nearestDistance) {
            nearestDistance = distance;
            nearestCoordinate = route;
            nearestIndex = i;
        }
    }
    return { latitude: nearestCoordinate.latitude, longitude: nearestCoordinate.longitude};
    }

    function findNearestBusCoordinates(targetLatLng, bRoutes){

    var nearestDistance = Number.MAX_VALUE;
    var nearestCoordinate = null;
    var nearestIndex = -1;

    for (var i = 1; i < bRoutes.length; i++) {
        var route = bRoutes[i];
        var routeLatLng = L.latLng(route.latitude, route.longitude); // Create LatLng object properly
        var distance = targetLatLng.distanceTo(routeLatLng);
        
        if (distance < nearestDistance) {
            nearestDistance = distance;
            nearestCoordinate = route;
            nearestIndex = i;
        }
    }
    return { latitude: nearestCoordinate.latitude, longitude: nearestCoordinate.longitude};
}