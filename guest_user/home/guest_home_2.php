<?php
    session_start();

    include "../../connection.php";
    include "route_handler.php";
     // Retrieve latitude and longitude from URL parameters
    $destinationLatitude = isset($_GET['latitude']) ? $_GET['latitude'] : null;
    $destinationLongitude = isset($_GET['longitude']) ? $_GET['longitude'] : null;
    $destination = isset($_GET['destination']) ? $_GET['destination'] : null;

    $vehicleType = isset($_GET['vehicleType']) ? $_GET['vehicleType'] : null;

    $jeepFare = array();

    $jeepQuery = mysqli_query($conn, "SELECT * FROM jeep_fare");
    
    if($jeepQuery){
        // Fetching the result row by row
        while ($row = mysqli_fetch_assoc($jeepQuery)) {
            $jfare = [
                'jeep_regular' => $row['jeep_regular'],
                'jeep_regular_succeeding' => $row['jeep_regular_succeeding'],
                'jeep_discounted' => $row['jeep_discounted'],
                'jeep_discounted_succeeding' => $row['jeep_discounted_succeeding'],
            ];
            $jeepFare = $jfare;
        }
    }

    $busFare = array();

    $busQuery = mysqli_query($conn, "SELECT * FROM bus_fare");

    if ($busQuery) {
        // Fetching the result row by row
        while ($row = mysqli_fetch_assoc($busQuery)) {
            $bfare = [
                'bus_regular' => $row['bus_regular'],
                'bus_regular_succeeding' => $row['bus_regular_succeeding'],
                'bus_discounted' => $row['bus_discounted'],
                'bus_discounted_succeeding' => $row['bus_discounted_succeeding'],
            ];
            $busFare = $bfare;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/99c24c4877.js" crossorigin="anonymous"></script>
    <link rel="icon" href="../../images/logo.png">

    <?php include "leaflet_header.php"; ?>
    <link rel="stylesheet" type="text/css" href="emap.css">
    <title>Guest User | Home</title>

    <style>
    .leaflet-routing-container .leaflet-control-container .leaflet-routing-container-hide {
        display: none;
    }
    .directions{
        font-size: 14px;
    }
    </style>
</head>
<body>
<div id="map">

</div>
</body>
<script>
    var map = L.map('map', {
            zoomControl: false
        }).setView([14.8191792, 120.9617524], 13);
    
        // osm layer
        var osm = L.tileLayer("https://mt0.google.com/vt/lyrs=m&hl=en&x={x}&y={y}&z={z}&s=Ga", {
            maxZoom: 20,
            minZoom: 12,
            // attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        });
        osm.addTo(map);

       //navbar

    var burMenuControl = L.Control.extend({
        options: {
            position: 'topright'
        },

        onAdd: function (map) {
            var container = L.DomUtil.create('div', "dropdown-menu-content");
            container.innerHTML =  `<div class="dropdown">
                <button class="btn btn-secondary burger-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <ul class="dropdown-menu px-1 ">
                    <li><a class="dropdown-item py-1 my-2 btn-active" href="guest_home.php">Home</a></li>
                    <li><a class="dropdown-item py-1 my-2" href="../event/guest_event.php">Events</a></li>
                </ul>
            </div>
            `;
            return container;
        }
    });

    // zoom control
    L.control.zoom({
            position: 'bottomright', 
            zoomInText: '+',       
            zoomOutText: '-',      
        }).addTo(map);


        var ToggleLocationControl = L.Control.extend({
            options: {
                position: 'bottomright'
            },

            onAdd: function (map) {
                var container = L.DomUtil.create('div', 'leaflet-bar leaflet-control leaflet-control-custom');
                container.innerHTML = '<button id="toggleLocationBtn" class="btn fa-solid fa-location-crosshairs location-icon"></button>';
                return container;
            }
        });

        var jeepTerminalButton = L.Control.extend({
        options: {
            position: 'bottomright'
        },

        onAdd: function (map) {
            var container = L.DomUtil.create('div', 'leaflet-bar leaflet-control leaflet-control-custom');

            // Include your SVG code here
            var svgIcon = '<img class="jeep-icon" width="24" height="24" src="icons/jeep.svg"></img>';

            container.innerHTML = '<button id="jeepTerminalBtn" class="btn">' + svgIcon + '</button>';
            return container;
        }
    });

    var burMenuControlInstance = new burMenuControl();
    burMenuControlInstance.addTo(map);

    var jeepTerminalButtonInstance = new jeepTerminalButton();
    jeepTerminalButtonInstance.addTo(map);

</script>

<script>
        var currLocMarker, currLocCircle, destinationMarker, destinationCircle, originMarker;
        var currentLocation, destinationLocation;
        var lat, long, accuracy;
        var watchId;
        var destinationInput, originInput, numPassenger;
        var polyline, currpolyline;
        var nearestBusCoordinates, nearestJeepCoordinates;
        var totalBusDistance = 0;
        var originBusDistance = 0;
        var destinationBusDistance = 0;
        var vehicleType, dataOrigin;

        //real time location
        if(!navigator.geolocation){
            console.log('Your browser does not support geolocation feature')
        } 
        else{
            navigator.geolocation.getCurrentPosition(getPosition);
        }
    
        function getPosition(position){
                // console.log(position)
            lat = position.coords.latitude
            long = position.coords.longitude
            
            if(currLocMarker){
                map.removeLayer(currLocMarker);
                map.removeLayer(currLocCircle);
            }

            currLocMarker = L.marker([lat, long])
            currLocCircle = L.circle([lat, long], {
                color: '#20A2AA',
                fillColor: '#20A2AA',
                fillOpacity: 0.5,
                radius: 20
            })
            currLocMarker.bindPopup('You are here.').openPopup();

            currentLocation = L.featureGroup([currLocMarker, currLocCircle]).addTo(map);
            //dataOrigin = lat + ',' + long;
            document.getElementById('origin').placeholder = 'Your location';

            console.log(lat, long)
           
        }

        function toggleLocation() {
            if(navigator.geolocation){
                if (watchId) {
                    navigator.geolocation.clearWatch(watchId);
                    watchId = null;

                    if (currLocMarker && currLocCircle) {
                        map.removeLayer(currLocMarker);
                        map.removeLayer(currLocCircle);
                    }
                   
                    document.getElementById('origin').placeholder = 'Origin';
                
                } else {
                    watchId = navigator.geolocation.watchPosition(getPosition);  

                    console.log(lat + ", " + long)
                    document.getElementById('origin').placeholder = 'Your location';
                    
                }
            } else {
                alert('Geolocation is not supported on this device.');
            }
        }
        
        function updateButtonState() {
            if (navigator.permissions) {
                navigator.permissions.query({ name: 'geolocation' }).then(function (result) {
                    if (result.state === 'granted') {
                        // Geolocation permission granted, enable the button
                        document.getElementById('toggleLocationBtn').disabled = false;
                        
                    } else {
                        // Geolocation permission denied, disable the button
                        document.getElementById('toggleLocationBtn').disabled = true;

                        if(currLocMarker){
                            map.removeLayer(currLocMarker);
                            map.removeLayer(currLocCircle);
                        }
                        document.getElementById('origin').placeholder = 'Origin';

                    }
                });
            }
        }

        map.addControl(new ToggleLocationControl());
        document.getElementById('toggleLocationBtn').addEventListener('click', toggleLocation);

        setInterval(updateButtonState, 1000);

</script>
<script src="jeep.js"></script>
<!---------------------- SIDE PANEL ---------------------->
<script>
var sidepanel = L.Control.extend({
    options: {
        position: 'topleft'
    },
    onAdd: function (map) {
        var container = L.DomUtil.create('div', "sidepanel-content");
        container.innerHTML =  `

        <button class="btn btn-primary open-side px-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidepanelScrolling"
         aria-controls="sidepanelScrolling"><i class="fa-solid fa-caret-right fs-6"></i></button>
        
         <div class="offcanvas offcanvas-start shadow-sm" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="sidepanelScrolling" aria-labelledby="offcanvasScrollingLabel">
            <div class="offcanvas-header sidepanel-header py-2">
                <div class="row">
                    <div class="col-2 m-auto"><img class="sidepanel-logo w-100" src="../../images/logo.png" alt="Easykay Logo"></div>
                    <div class="col-7"><a class="navbar-brand fs-5" href="../../index.php">EasyKay</a></div>
                    <div class="col-3 text-end">
                    <button type="button" class="fa-solid fa-xmark btn fs-5 mx-2 my-1 col-3" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    
                    </div>
                </div>
            </div>
            <div class="offcanvas-body sidepanel-body">
                <div class="location-form">
                    <form class="" method="POST" id="myGoForm">
                        <input class="form-control mb-2" type="text" placeholder="Origin" id="origin">
                        <input class="form-control mb-3" type="text" placeholder="Your Destination" id="destination">
                    
                        <div class="d-flex mb-3 ">
                            <div class="col-9 col-lg d-flex justify-content-center align-items-center">
                                <span class="fa-solid fa-user"> <span class="mx-2 me-3 "> Passenger</span></span>
                                <div class="input-group-append">
                                    <button class="button px-2" type="button" onclick="decrementValue()"> - </button>
                                </div>
                                <div class="input-group-num">
                                    <input type="number" class="" id="passengerInput" value="1" min="1" max="3" readonly>
                                </div>
                                <div class="input-group-prepend">
                                    <button class="button px-2" type="button" onclick="incrementValue()">+</button>
                                </div>
                            </div>
                            <div class="col-3 text-end">
                                <button type="submit" class="btn btn-outline-primary go">Go</button>
                            </div>
                        </div>  
                    </form>
                </div>
                <hr>
                <div class="travels p-2 bg-light">

                </div>
                <hr>
                <div class="sidepanel-footer">
                <div><p class="text-muted text-end pt-2">*Price may vary according to the time of your commute.</p></div>
            </div>
            </div>
            
        </div>

        `;
       
    return container;
}
})

var sidepanelInstance = new sidepanel();
sidepanelInstance.addTo(map);

function incrementValue() {
    var value = parseInt(document.getElementById('passengerInput').value, 10);
    value = isNaN(value) ? 1 : value;
    value = value < 3 ? value + 1 : 3;
    document.getElementById('passengerInput').value = value;
}

function decrementValue() {
    var value = parseInt(document.getElementById('passengerInput').value, 10);
    value = isNaN(value) ? 1 : value;
    value = value > 1 ? value - 1 : 1;
    document.getElementById('passengerInput').value = value;
}

// Function to get URL parameters
function getUrlParameter(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    var results = regex.exec(location.search);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
}

document.addEventListener('DOMContentLoaded', function () {
    var urlLatitude = getUrlParameter('latitude');
    var urlLongitude = getUrlParameter('longitude');
    var urlDestination = getUrlParameter('destination');

    console.log('urlLatitude:', urlLatitude);
    console.log('urlLongitude:', urlLongitude);
    console.log('urlDestination:', urlDestination);

    // Check if the form is not already submitted and latitude and longitude are present
    if (urlLatitude && urlLongitude) {
        console.log('Setting destination from latitude and longitude:', urlLatitude, urlLongitude);
        document.getElementById('destination').value = urlLatitude + ', ' + urlLongitude;
    } 
    if (urlDestination) {
        console.log('Setting destination from urlDestination:', urlDestination);
        document.getElementById('destination').value = urlDestination;
    }
});

var destinationMarker, originMarker, desMarkerLatLng;

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

function removePolyline(polyline) {
    if (polyline) {
        map.removeLayer(polyline); // Remove the previously drawn polyline
        polyline = null; // Reset the reference to null
    }
}
function geocodeOrigin(numPassenger) {
    var originInput = document.getElementById('origin').value;
    removePolyline(polyline);

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
                    if(currLocMarker){
                        map.removeLayer(currLocMarker);
                        map.removeLayer(currLocCircle);
                    }
                    var originMarker = L.marker(originCoordinates).addTo(map);
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
                   // drawPolyline(originMarker, destinationMarker);
                  
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

function geocodeLocationOrigin(numPassenger, dataOrigin){
    removePolyline(polyline);
    if (dataOrigin !== '') {
        // Make a request to Nominatim API for geocoding
        fetch(`https://nominatim.openstreetmap.org/search?q=${dataOrigin}&format=json`)
            .then(response => response.json())
            .then(data => {
                if (data && data.length > 0) {
                    var originCoordinates = [parseFloat(data[0].lat), parseFloat(data[0].lon)];

                    if (originMarker) {
                        map.removeLayer(originMarker);
                        map.removeLayer(originCircle);
                    }
                    if(currLocMarker){
                        map.removeLayer(currLocMarker);
                        map.removeLayer(currLocCircle);
                    }
                    var originMarker = L.marker(originCoordinates).addTo(map);
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
                   // drawPolyline(originMarker, destinationMarker);
                  
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

function updateOriginRouteDistance(distance, type) {
    document.getElementById('origin-route-distance').textContent = distance + ' km';
    var originRouteDistance = document.getElementById('origin-route-distance');
    
    if (distance < 0.500) {
        document.getElementById('origin-mode-tanspo').innerHTML = '<i class="fa-solid fa-person-walking fs-5"></i>';
        document.getElementById('origin-fare').style.display = 'none'; 
    } else {
        document.getElementById('origin-mode-tanspo').textContent = 'Tricycle';
        document.getElementById('origin-regular').textContent = '25';
        document.getElementById('origin-discounted').textContent = '25';
    }
    
    if(type === 'Jeep'){
        document.getElementById('vehicle-type').innerHTML = '<i class="fa-solid fa-truck-front fs-5"></i>';
    } else if(type === 'Bus'){
        document.getElementById('vehicle-type').innerHTML = '<i class="fa-solid fa-bus fs-5"></i>';
    }
}
function updateDestinationRouteDistance(distance, type) {
    document.getElementById('destination-route-distance').textContent = distance + ' km';
    var originRouteDistance = document.getElementById('destination-route-distance');
    
    if (distance <= 0.500) {
        document.getElementById('destination-mode-tanspo').innerHTML = '<i class="fa-solid fa-person-walking fs-5"></i>';
        document.getElementById('destination-fare').style.display = 'none'; 
    } else if(distance > 0.500){
        document.getElementById('destination-mode-tanspo').textContent = 'Tricycle';
        document.getElementById('destination-regular').textContent = '25';
        document.getElementById('destination-discounted').textContent = '25';
    }
    if(type === 'Jeep'){
        document.getElementById('vehicle-type').innerHTML = '<i class="fa-solid fa-truck-front fs-5"></i>';
    } else if(type === 'Bus'){
        document.getElementById('vehicle-type').innerHTML = '<i class="fa-solid fa-bus fs-5"></i>';
    }
}

function drawJeepPolyline(originMarker, destinationMarker){
    var originLatLng = originMarker.getLatLng();
    var destinationLatLng = destinationMarker.getLatLng();
    var jeepRoutes = <?php echo json_encode($routes); ?>;
    var type = 'Jeep';
    var originvalue = document.getElementById('origin').value;
    var destinationvalue = document.getElementById('destination').value;
    var pass = document.getElementById('passengerInput').value;

    var jeepRoutePathCoordinates = [];
    var polylineCoordinates = [];
    console.log(originLatLng);

    var origin = findNearestJeepCoordinates(originLatLng, jeepRoutes);
    var origRow = origin.nearestRowNumber;
    var destination = findNearestJeepCoordinates(destinationLatLng, jeepRoutes);
    var destRow = destination.nearestRowNumber;
    console.log(origin);
    console.log('orig: ', origRow);
    console.log('DEST: ', destRow);

    if(origRow < destRow){
        for(var i = 1; i < jeepRoutes.length; i++){
            var route = jeepRoutes[i];
            console.log('route: ', route)
                if (route.latitude === origin.latitude && route.longitude === origin.longitude) {
                    jeepRoutePathCoordinates.push([route.latitude, route.longitude]);
                    var k=0;
                    for (var j = i + 1; j < jeepRoutes.length; j++) {
                        var nextRoute = jeepRoutes[j];
                        jeepRoutePathCoordinates.push([nextRoute.latitude, nextRoute.longitude]);
                    //  console.log(jeepRoutePathCoordinates[k]);
                        k++;
                        if(nextRoute.latitude === destination.latitude && nextRoute.longitude === destination.longitude) {
                            break;
                        }
                    }
                    break; 
            }
        }
        for (var j = 0; j < jeepRoutePathCoordinates.length; j++) {
            var routePath = jeepRoutePathCoordinates[j]; // Access the coordinates using index j, not k
            polylineCoordinates.push([routePath[0], routePath[1]]);
           // console.log(polylineCoordinates[j]);
        }

        var routeDistance = 0;
        for (var l = 0; l < polylineCoordinates.length - 1; l++) {
            var firstroute = polylineCoordinates[l];
            var nextroute = polylineCoordinates[l + 1];

            var latlng1 = L.latLng(firstroute[0], firstroute[1]);
            var latlng2 = L.latLng(nextroute[0], nextroute[1]);

            // Calculate distance between latlng1 and latlng2 (in meters)
            var distance = latlng1.distanceTo(latlng2);

            // Add the distance to the total distance
            routeDistance += distance;

            var polyline = L.polyline([
                [firstroute[0], firstroute[1]],
                [nextroute[0], nextroute[1]]
            ], { color: '#20A2AA', weight: 5 }).addTo(map);
        }

            var oRouteDistance;
            var dRouteDistance; 

            var routeDistanceinKm = parseFloat((routeDistance / 1000).toFixed(2));
           
            var originRoutingControl = L.Routing.control({
                waypoints: [
                    L.latLng([originLatLng.lat, originLatLng.lng]),
                    L.latLng([origin.latitude, origin.longitude])
                ],
                createMarker: function() { return null; },
                show: false,
                lineOptions: {
                styles: [{ color: '#20A2AA', weight: 5 }]
            }
            }).on('routeselected', function(e) {
                var route = e.route;
                oRouteDistance = route.summary.totalDistance/1000;
                var routeCoordinates = route.coordinates;
                var polyline = L.polyline(routeCoordinates, { color: '#20A2AA', weight: 5 }).addTo(map);

                updateOriginRouteDistance(oRouteDistance, type);
            });

            var destinationRoutingControl = L.Routing.control({
                waypoints: [
                    L.latLng([destinationLatLng.lat, destinationLatLng.lng]),
                    L.latLng([destination.latitude, destination.longitude])
                ],
                createMarker: function() { return null; },
                show: false,
                lineOptions: {
                styles: [{ color: '#20A2AA', weight: 5 }]
            }
            }).on('routeselected', function(e) {
                var route = e.route;
                dRouteDistance = route.summary.totalDistance/1000;
                var routeCoordinates = route.coordinates;
                var polyline = L.polyline(routeCoordinates, { color: '#20A2AA', weight: 5 }).addTo(map);

                updateDestinationRouteDistance(dRouteDistance, type);
            });
           
            originRoutingControl.addTo(map);
            destinationRoutingControl.addTo(map);

            defineDirections(routeDistanceinKm, type, originvalue, destinationvalue, pass);
    } else if(origRow > destRow){

        var i = jeepRoutes.length - 1;

        for(i; i > 0; i--){
            var route = jeepRoutes[i];
            console.log('route: ', route)
                if (route.latitude === origin.latitude && route.longitude === origin.longitude) {
                    jeepRoutePathCoordinates.push([route.latitude, route.longitude]);
                    var k=0;
                    for (var j = i - 1; j < jeepRoutes.length; j--) {
                        var nextRoute = jeepRoutes[j];
                        jeepRoutePathCoordinates.push([nextRoute.latitude, nextRoute.longitude]);
                    //  console.log(jeepRoutePathCoordinates[k]);
                        k++;
                        if(nextRoute.latitude === destination.latitude && nextRoute.longitude === destination.longitude) {
                            break;
                        }
                    }
                    break; 
            }
        }
        for (var j = 0; j < jeepRoutePathCoordinates.length; j++) {
            var routePath = jeepRoutePathCoordinates[j]; // Access the coordinates using index j, not k
            polylineCoordinates.push([routePath[0], routePath[1]]);
           // console.log(polylineCoordinates[j]);
        }

        var routeDistance = 0;
        for (var l = 0; l < polylineCoordinates.length - 1; l++) {
            var firstroute = polylineCoordinates[l];
            var nextroute = polylineCoordinates[l + 1];

            var latlng1 = L.latLng(firstroute[0], firstroute[1]);
            var latlng2 = L.latLng(nextroute[0], nextroute[1]);

            // Calculate distance between latlng1 and latlng2 (in meters)
            var distance = latlng1.distanceTo(latlng2);

            // Add the distance to the total distance
            routeDistance += distance;

            var polyline = L.polyline([
                [firstroute[0], firstroute[1]],
                [nextroute[0], nextroute[1]]
            ], { color: '#20A2AA', weight: 5 }).addTo(map);
        }

        var routeDistanceinKm = parseFloat((routeDistance / 1000).toFixed(2));

        var originRoutingControl = L.Routing.control({
                waypoints: [
                    L.latLng([originLatLng.lat, originLatLng.lng]),
                    L.latLng([origin.latitude, origin.longitude])
                ],
                createMarker: function() { return null; },
                show: false,
                lineOptions: {
                styles: [{ color: '#20A2AA', weight: 5 }]
            }
            }).on('routeselected', function(e) {
                var route = e.route;
                var originRouteDistance = route.summary.totalDistance / 1000;
                var routeCoordinates = route.coordinates;
                var polyline = L.polyline(routeCoordinates, { color: '#20A2AA', weight: 5 }).addTo(map);
                updateOriginRouteDistance(originRouteDistance, type);
            });

            var destinationRoutingControl = L.Routing.control({
                waypoints: [
                    L.latLng([destinationLatLng.lat, destinationLatLng.lng]),
                    L.latLng([destination.latitude, destination.longitude])
                ],
                createMarker: function() { return null; },
                show: false,
                lineOptions: {
                styles: [{ color: '#20A2AA', weight: 5 }]
            }
            }).on('routeselected', function(e) {
                var route = e.route;
                var destRouteDistance = route.summary.totalDistance / 1000;
                var routeCoordinates = route.coordinates;
                var polyline = L.polyline(routeCoordinates, { color: '#20A2AA', weight: 5 }).addTo(map);
                updateDestinationRouteDistance(destRouteDistance, type);
            });
           
            originRoutingControl.addTo(map);
            destinationRoutingControl.addTo(map);

            defineDirections(routeDistanceinKm, type, originvalue, destinationvalue, pass);

    }
}

function drawBusPolyline(originMarker, destinationMarker){
    var originLatLng = originMarker.getLatLng();
    var destinationLatLng = destinationMarker.getLatLng();
    var busRoutes = <?php echo json_encode($busRoutes); ?>;
    var type = 'Bus';
    var originvalue = document.getElementById('origin').value;
    var destinationvalue = document.getElementById('destination').value;
    var pass = document.getElementById('passengerInput').value;
    var busRoutePathCoordinates = [];
    var polylineCoordinates = [];
    console.log(originLatLng);

    var origin = findNearestBusCoordinates(originLatLng, busRoutes);
    var destination = findNearestBusCoordinates(destinationLatLng, busRoutes);

    var origRow = origin.nearestRowNumber;
    var destRow = destination.nearestRowNumber;

    console.log(origin);
    if(origRow < destRow){
        for(var i = 1; i < busRoutes.length; i++){
            var route = busRoutes[i];
            console.log('route: ', route)
            if (route.latitude === origin.latitude && route.longitude === origin.longitude) {
                busRoutePathCoordinates.push([route.latitude, route.longitude]);
                var k=0;
                for (var j = i + 1; j < busRoutes.length; j++) {
                    var nextRoute = busRoutes[j];
                    busRoutePathCoordinates.push([nextRoute.latitude, nextRoute.longitude]);
                    console.log(busRoutePathCoordinates[k]);
                    k++;
                    if(nextRoute.latitude === destination.latitude && nextRoute.longitude === destination.longitude) {
                        break;
                    }
                }
                break; 
            }
        }
        for (var j = 0; j < busRoutePathCoordinates.length; j++) {
            var routePath = busRoutePathCoordinates[j]; // Access the coordinates using index j, not k
            polylineCoordinates.push([routePath[0], routePath[1]]);
            console.log(polylineCoordinates[j]);
        }
        var routeDistance = 0;
        for (var l = 0; l < polylineCoordinates.length - 1; l++) {
            var firstroute = polylineCoordinates[l];
            var nextroute = polylineCoordinates[l + 1];

            var latlng1 = L.latLng(firstroute[0], firstroute[1]);
            var latlng2 = L.latLng(nextroute[0], nextroute[1]);

            // Calculate distance between latlng1 and latlng2 (in meters)
            var distance = latlng1.distanceTo(latlng2);

            // Add the distance to the total distance
            routeDistance += distance;

            var polyline = L.polyline([
                [firstroute[0], firstroute[1]],
                [nextroute[0], nextroute[1]]
            ], { color: '#20A2AA', weight: 5 }).addTo(map);
        }

        var routeDistanceinKm = parseFloat((routeDistance / 1000).toFixed(2));

        var originRoutingControl = L.Routing.control({
                waypoints: [
                    L.latLng([originLatLng.lat, originLatLng.lng]),
                    L.latLng([origin.latitude, origin.longitude])
                ],
                createMarker: function() { return null; },
                show: false,
                lineOptions: {
                styles: [{ color: '#20A2AA', weight: 5 }]
            }
            }).on('routeselected', function(e) {
                var route = e.route;
                var routeDistance = route.summary.totalDistance/1000;
                var originRouteDistance = parseFloat((routeDistance).toFixed(2));
                var routeCoordinates = route.coordinates;
                var polyline = L.polyline(routeCoordinates, { color: '#20A2AA', weight: 5 }).addTo(map);

                updateOriginRouteDistance(originRouteDistance, type);
            });

            var destinationRoutingControl = L.Routing.control({
                waypoints: [
                    L.latLng([destinationLatLng.lat, destinationLatLng.lng]),
                    L.latLng([destination.latitude, destination.longitude])
                ],
                createMarker: function() { return null; },
                show: false,
                lineOptions: {
                styles: [{ color: '#20A2AA', weight: 5 }]
            }
            }).on('routeselected', function(e) {
                var route = e.route;
                var routeDistance = route.summary.totalDistance/1000;
                var dRouteDistance = parseFloat((routeDistance).toFixed(2));
            
                var routeCoordinates = route.coordinates;
                var polyline = L.polyline(routeCoordinates, { color: '#20A2AA', weight: 5 }).addTo(map);

                console.log('route distance(0.00): '. dRouteDistance);

                updateDestinationRouteDistance(dRouteDistance, type);
            });

            originRoutingControl.addTo(map);
            destinationRoutingControl.addTo(map);
            defineDirections(routeDistanceinKm, type, originvalue, destinationvalue, pass);

    }else if(origRow > destRow){

        var i = busRoutes.length - 1;
        for(i; i > 0 ; i--){
            var route = busRoutes[i];
            console.log('route: ', route)
            if (route.latitude === origin.latitude && route.longitude === origin.longitude) {
                busRoutePathCoordinates.push([route.latitude, route.longitude]);
                var k=0;
                for (var j = i - 1; j < busRoutes.length; j--) {
                    var nextRoute = busRoutes[j];
                    busRoutePathCoordinates.push([nextRoute.latitude, nextRoute.longitude]);
                    console.log(busRoutePathCoordinates[k]);
                    k++;
                    if(nextRoute.latitude === destination.latitude && nextRoute.longitude === destination.longitude) {
                        break;
                    }
                }
                break; 
            }
        }
        for (var j = 0; j < busRoutePathCoordinates.length; j++) {
            var routePath = busRoutePathCoordinates[j]; // Access the coordinates using index j, not k
            polylineCoordinates.push([routePath[0], routePath[1]]);
            console.log(polylineCoordinates[j]);
        }
        var routeDistance = 0;
        for (var l = 0; l < polylineCoordinates.length - 1; l++) {
            var firstroute = polylineCoordinates[l];
            var nextroute = polylineCoordinates[l + 1];

            var latlng1 = L.latLng(firstroute[0], firstroute[1]);
            var latlng2 = L.latLng(nextroute[0], nextroute[1]);

            // Calculate distance between latlng1 and latlng2 (in meters)
            var distance = latlng1.distanceTo(latlng2);

            // Add the distance to the total distance
            routeDistance += distance;

            var polyline = L.polyline([
                [firstroute[0], firstroute[1]],
                [nextroute[0], nextroute[1]]
            ], { color: '#20A2AA', weight: 5 }).addTo(map);
        }

        var routeDistanceinKm = parseFloat((routeDistance / 1000).toFixed(2));

        var originRoutingControl = L.Routing.control({
                waypoints: [
                    L.latLng([originLatLng.lat, originLatLng.lng]),
                    L.latLng([origin.latitude, origin.longitude])
                ],
                createMarker: function() { return null; },
                show: false,
                lineOptions: {
                styles: [{ color: '#20A2AA', weight: 5 }]
            }
            }).on('routeselected', function(e) {
                var route = e.route;
                var originRouteDistance = route.summary.totalDistance / 1000;
                var routeCoordinates = route.coordinates;
                var polyline = L.polyline(routeCoordinates, { color: '#20A2AA', weight: 5 }).addTo(map);

                updateOriginRouteDistance(originRouteDistance, type);
            });

            var destinationRoutingControl = L.Routing.control({
                waypoints: [
                    L.latLng([destinationLatLng.lat, destinationLatLng.lng]),
                    L.latLng([destination.latitude, destination.longitude])
                ],
                createMarker: function() { return null; },
                show: false,
                lineOptions: {
                styles: [{ color: '#20A2AA', weight: 5 }]
            }
            }).on('routeselected', function(e) {
                var route = e.route;
                var dRouteDistance = route.summary.totalDistance / 1000;
                var routeCoordinates = route.coordinates;
                var polyline = L.polyline(routeCoordinates, { color: '#20A2AA', weight: 5 }).addTo(map);

                updateDestinationRouteDistance(dRouteDistance, type);
            });

            originRoutingControl.addTo(map);
            destinationRoutingControl.addTo(map);

            defineDirections(routeDistanceinKm, type, originvalue, destinationvalue, pass);
    }
}
</script>
<script>
    
    function defineDirections(routeDistanceinKm, type, originvalue, destinationvalue, pass){

    if(type === 'Jeep'){
        var eta = computeJeepETA(routeDistanceinKm);
        var reg = computeRegularJeepFare(routeDistanceinKm, pass);
        var discount = computeDiscountJeepFare(routeDistanceinKm, pass)
    }else if(type === 'Bus'){
        var eta = computeETA(routeDistanceinKm);
        var reg = computeRegularBusFare(routeDistanceinKm, pass);
        var discount = computeDiscountBusFare(routeDistanceinKm, pass)
    }
        var travelsSection = document.querySelector('.travels');
        travelsSection.innerHTML = '';
            travelsSection.innerHTML += `
            <div><h6><b>${originvalue}</b></h6></div>
            <div class="row mx-3 my-2 directions">
                <div class="col">
                    <div class="row my-1">
                        <div class="col">
                            <div>
                                <span id="origin-mode-tanspo"></span>
                            </div>
                        </div>
                        <div class="col">
                            <div>
                                <span id="origin-route-distance"></span>
                            </div>
                        </div>
                        <div class="col">
                            <div>
                                <span id="origin-route-eta">2mins</span>
                            </div>
                        </div>
                    </div>
                    <div class="row text-center mt-2" id="origin-fare">
                        <div class="col d-flex flex-column text-start">
                            <span id="">Regular: </span>
                            <span id="">Discounted: </span>
                        </div>
                        <div class="col d-flex flex-column">
                            <span id="">PHP sample</span>
                            <span id="">PHP sample</span>
                        </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row my-1">
                        <div class="col">
                            <div>
                                <span id="vehicle-type"></span>
                            </div>
                        </div>
                        <div class="col">
                            <div>
                                <span id="">${routeDistanceinKm} km</span>
                            </div>
                        </div>
                        <div class="col">
                            <div>
                                <span id="origin-route-eta">${eta} mins</span>
                            </div>
                        </div>
                    </div>
                    <div class="row my-1 text-center mt-2" id="">
                        <div class="col d-flex flex-column text-start">
                            <span id="">Regular: </span>
                            <span id="">Discounted: </span>
                        </div>
                        <div class="col d-flex flex-column">
                            <span id="">PHP ${reg}</span>
                            <span id="">PHP ${discount}</span>
                        </div>
                    </div>
                    <hr>
                    <div class="row my-1">
                        <div class="col">
                            <div>
                                <span id="destination-mode-tanspo"></span>
                            </div>
                        </div>
                        <div class="col">
                            <div>
                                <span id="destination-route-distance"></span>
                            </div>
                        </div>
                        <div class="col">
                            <div>
                                <span id="destination-route-eta">2mins</span>
                            </div>
                        </div>
                    </div>
                    <div class="row text-center mt-2" id="destination-fare">
                        <div class="col d-flex flex-column text-start">
                            <span id="">Regular: </span>
                            <span id="">Discounted: </span>
                        </div>
                        <div class="col d-flex flex-column">
                            <span id="">PHP sample</span>
                            <span id="">PHP sample</span>
                        </div>
                    </div>
                </div>
            </div>
            <div><h6><b>${destinationvalue}</b></h6></div>
        `;    
}

</script>
<script>
var originInput, destinationInput;
var originLatLng, destinationLatLng;
                    
var myGoForm = document.getElementById('myGoForm');
if (myGoForm) {
    myGoForm.addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent the form from submitting

        originInput = document.getElementById('origin').value.trim();
        destinationInput = document.getElementById('destination').value.trim();
        var numPassenger = document.getElementById('passengerInput').value.trim();

        if(originInput !== '' && destinationInput !== ''){
            originLatLng;
            destinationLatLng;

            geocodeDestination();
            geocodeOrigin(numPassenger);

            if (polyline) {
                removePolyline(polyline);
            }
        }
        else if(originInput === '' && destinationInput !== ''){
            destinationLatLng;
            geocodeDestination();
        } else if(dataOrigin !== '' && destinationInput !== ''){
            console.log('location: ', dataOrigin);
            geocodeDestination();
            geocodeLocationOrigin(numPassenger, dataOrigin);
        }
    });
}

function defineMarker(originLatLng, destinationLatLng, numPassenger){
    var pass = numPassenger;
    console.log('originmarker:' +  originLatLng);

    if(originLatLng  && destinationLatLng){
            var busRoutes = <?php echo json_encode($busRoutes); ?>;
            var jeepRoutes = <?php echo json_encode($routes); ?>;
            console.log('Origin Coordinates:' + originLatLng.lng);

            var nearestOriginBusCoordinates = findNearestBusCoordinates(originLatLng, busRoutes);
            var nearestDestinationBusCoordinates = findNearestBusCoordinates(destinationLatLng, busRoutes);

            var nearestOriginJeepCoordinates = findNearestJeepCoordinates(originLatLng, jeepRoutes);
            var nearestDestinationJeepCoordinates = findNearestJeepCoordinates(destinationLatLng, jeepRoutes);

            var busRoutePathCoordinates = storeBusPath(nearestOriginBusCoordinates, nearestDestinationBusCoordinates);
            var busDistance = computeDistance(busRoutePathCoordinates);
            var busETA = computeETA(busDistance);
            var busFareRegular = computeRegularBusFare(busDistance, pass);
            var busFareDiscount = computeDiscountBusFare(busDistance, pass)

            var jeepRoutePathCoordinates = storeJeepPath(nearestOriginJeepCoordinates, nearestDestinationJeepCoordinates);
            var jeepDistance = computeJeepDistance(jeepRoutePathCoordinates);
            var jeepETA = computeJeepETA(jeepDistance);
            var jeepFareRegular = computeRegularJeepFare(jeepDistance, pass);
            var jeepFareDiscount = computeDiscountJeepFare(jeepDistance, pass)

            console.log('Origin bus: ' + JSON.stringify(nearestOriginBusCoordinates));
            console.log('Bus Fare: ' + busFareRegular);
            console.log('distanceToTarget', nearestOriginBusCoordinates.distanceToTarget);
    }
    var travelsSection = document.querySelector('.travels');
    travelsSection.innerHTML = '';
    if(nearestOriginBusCoordinates && nearestDestinationBusCoordinates){
        if(nearestOriginBusCoordinates.distanceToTarget < 200){
            travelsSection.innerHTML += `
            <form class="travels-form" method="GET" id="myForm">
                <input type="hidden" name="origin" id="origin" value="${originInput}">
                <input type="hidden" name="destination" id="destination" value="${destinationInput}">
                <input type="hidden" name="passenger" id="passenger" value="${pass}">
                <input type="hidden" name="vehicleType" id="vehicleType" value="Bus">
                <button type="submit" class="form-control my-3 py-3">
                    <div class="row">
                        <div class="col my-auto">
                            <div class="d-flex flex-column">
                                <span class="fa-solid fa-bus-simple fs-5"></span>
                                <span>Bus</span>
                            </div>
                        </div>
                        <div class="col">
                            <div class="d-flex flex-column">
                                <span>Regular</span>
                                <span>PHP ${busFareRegular}</span>
                            </div>
                        </div>
                        <div class="col">
                        <div class="d-flex flex-column">
                                <span>Discounted</span>
                                <span>PHP ${busFareDiscount}</span>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <span>Distance: ${busDistance} km</span>
                        </div>
                        <div class="col">
                            <span>ETA: ${busETA} m</span>
                        </div>
                    </div>
                </button>
                </form>
            `;
    }}
    if(nearestOriginJeepCoordinates && nearestDestinationJeepCoordinates){
            travelsSection.innerHTML += `
            <form class="travels-form" method="GET" id="myForm">
                <input type="hidden" name="origin" id="origin" value="${originInput}">
                <input type="hidden" name="destination" id="destination" value="${destinationInput}">
                <input type="hidden" name="passenger" id="passenger" value="${pass}">
                <input type="hidden" name="vehicleType" id="busDestination" value="Jeep">
                <button type="submit" class="form-control my-3 py-3">
                    <div class="row">
                        <div class="col my-auto">
                            <div class="d-flex flex-column">
                                <span class="fa-solid fa-bus-simple fs-5"></span>
                                <span>Jeep</span>
                            </div>
                        </div>
                        <div class="col">
                            <div class="d-flex flex-column">
                                <span>Regular</span>
                                <span>PHP ${jeepFareRegular}</span>
                            </div>
                        </div>
                        <div class="col">
                        <div class="d-flex flex-column">
                                <span>Discounted</span>
                                <span>PHP ${jeepFareDiscount}</span>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <span>Distance: ${jeepDistance} km</span>
                        </div>
                        <div class="col">
                            <span>ETA: ${jeepETA} m</span>
                        </div>
                    </div>
                </button>
            </form>
            `;
    }

    if (!nearestOriginBusCoordinates && !nearestDestinationBusCoordinates && !nearestOriginJeepCoordinates && !nearestDestinationJeepCoordinates) {
    var travelsSection = document.querySelector('.travels-form');
    travelsSection.innerHTML += `
        <p>No found Route Path.</p>
    `;
    }
}

var myForm = document.getElementById('myForm');
if (myForm) {
    myForm.addEventListener('submit', function (event) {
        event.preventDefault();
    });
}

document.addEventListener('DOMContentLoaded', function () {
    var urlOrigin = getUrlParameter('origin');
    var urlDestination = getUrlParameter('destination');
    var urlPassenger = getUrlParameter('passenger');
    var urlvehicleType = getUrlParameter('vehicleType');

    if (urlOrigin && urlDestination && urlvehicleType && urlPassenger) {
        console.log('Origin and Destination', urlOrigin, urlDestination);
        document.getElementById('origin').value = urlOrigin;
        document.getElementById('destination').value = urlDestination;
        document.getElementById('passengerInput').value = urlPassenger;

        // Geocode origin and destination
        geocodePlace(urlOrigin, function(originCoords) {
            geocodePlace(urlDestination, function(destinationCoords) {
                if (originCoords && destinationCoords) {
                    var originMarker = L.marker(originCoords).addTo(map);

                    var originCircle = L.circle(originCoords, {
                        color: '#20A2AA',
                        fillColor: '#20A2AA',
                        fillOpacity: 0.5,
                        radius: 20
                    }).addTo(map);
                    var destinationMarker = L.marker(destinationCoords, {
                        icon: L.icon({
                            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
                            iconSize: [25, 41],
                            iconAnchor: [12, 41],
                            popupAnchor: [1, -34],
                        })
                    }).addTo(map);
                    var destinationCircle = L.circle(destinationCoords, {
                        color: 'red',
                        fillColor: 'red',
                        fillOpacity: 0.5,
                        radius: 20
                    }).addTo(map);

                    var origLatLng = originMarker.getLatLng();
                    var destLatLng = destinationMarker.getLatLng();

                    console.log('Origin Latitude:', origLatLng.lat);
                    console.log('Origin Longitude:', origLatLng.lng);
                    console.log('Destination Latitude:', destLatLng.lat);
                    console.log('Destination Longitude:', destLatLng.lng);          
                    
                    if(urlvehicleType === 'Jeep'){
                        drawJeepPolyline(originMarker, destinationMarker);
                    } else if(urlvehicleType === 'Bus'){
                        drawBusPolyline(originMarker, destinationMarker);
                    }
                } else {
                    console.error('Failed to geocode origin or destination.');
                }
            });
        });
    } else {
        console.error('Required URL parameters missing.');
    }
});

function geocodePlace(place, callback) {
    L.Control.Geocoder.nominatim().geocode(place, function(results) {
        if (results && results.length > 0) {
            var coords = [results[0].center.lat, results[0].center.lng];
            callback(coords);
        } else {
            callback(null);
        }
    });
}



</script>

<script>
// functions

function storeBusPath(nearestOriginBusCoordinates, nearestDestinationBusCoordinates){
    var busRoutes = <?php echo json_encode($busRoutes); ?>;
    var busRoutePathCoordinates = [];

    console.log('Bus nearest origin: ' + JSON.stringify(nearestOriginBusCoordinates));
    console.log('Bus nearest Destination: ' + JSON.stringify(nearestDestinationBusCoordinates));

    if(nearestOriginBusCoordinates && nearestDestinationBusCoordinates){
            for (var i = 1; i < busRoutes.length; i++) {
                var route = busRoutes[i];
                if (route.latitude === nearestOriginBusCoordinates.latitude && route.longitude === nearestOriginBusCoordinates.longitude) {
                    busRoutePathCoordinates.push([route.latitude, route.longitude]);
                    var k=0;
                    for (var j = i + 1; j < busRoutes.length; j++) {
                        var nextRoute = busRoutes[j];
                        busRoutePathCoordinates.push([nextRoute.latitude, nextRoute.longitude]);

                        console.log(busRoutePathCoordinates[k]);
                        k++;
                        if (nextRoute.latitude === nearestDestinationBusCoordinates.latitude && nextRoute.longitude === nearestDestinationBusCoordinates.longitude) {
                            break;}
                    }
                    break; 
                }
            }
    }

    return busRoutePathCoordinates;
}

function storeJeepPath(nearestOriginJeepCoordinates, nearestDestinationJeepCoordinates){
    var jeepRoutes = <?php echo json_encode($routes); ?>;
    var jeepRoutePathCoordinates = [];

    console.log('Jeep nearest origin: ' + JSON.stringify(nearestOriginJeepCoordinates));
    console.log('Jeep nearest Destination: ' + JSON.stringify(nearestDestinationJeepCoordinates));

    if(nearestOriginJeepCoordinates && nearestDestinationJeepCoordinates){
            for (var i = 1; i < jeepRoutes.length; i++) {
                var route = jeepRoutes[i];
                if (route.latitude === nearestOriginJeepCoordinates.latitude && route.longitude === nearestOriginJeepCoordinates.longitude) {
                    jeepRoutePathCoordinates.push([route.latitude, route.longitude]);
                    var k=0;
                    for (var j = i + 1; j < jeepRoutes.length; j++) {
                        var nextRoute = jeepRoutes[j];
                        jeepRoutePathCoordinates.push([nextRoute.latitude, nextRoute.longitude]);

                        console.log(jeepRoutePathCoordinates[k]);
                        k++;
                        if (nextRoute.latitude === nearestDestinationJeepCoordinates.latitude && nextRoute.longitude === nearestDestinationJeepCoordinates.longitude) {
                            break;}
                    }
                    break; 
                }
            }
    }

    return jeepRoutePathCoordinates;
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
    var etaMinutes = parseFloat(travelTimeMinutes).toFixed(2);
    console.log("ETA: " + etaMinutes + "m");

    return etaMinutes;
}
function computeJeepETA(jeepDistance){
    var averageSpeedKph = 21; 
    var travelTimeHours = jeepDistance / averageSpeedKph;
    var travelTimeMinutes = travelTimeHours * 60;
    var etaMinutes = parseFloat(travelTimeMinutes).toFixed(2);
    console.log("ETA: " + etaMinutes + "m");

    return etaMinutes;
}

function computeRegularBusFare(busDistance, pass){
    var busFares = <?php echo json_encode($busFare); ?>;
    var regularFare = busFares.bus_regular; // Accessing the first element of the array
    var regularSucceeding = busFares.bus_regular_succeeding; // Accessing the first element of the array
    var totalRegularBusFare = 0;

    if (busDistance <= 4) {
        totalFarepass = parseFloat(regularFare) * parseFloat(pass);
    } else if (busDistance > 4) {
        var differenceDistance = busDistance - 4;
        var distanceFare = differenceDistance * regularSucceeding;
        totalRegularBusFare = parseFloat(regularFare) + parseFloat(distanceFare);
        var totalFarepass =  totalRegularBusFare * pass;
    }

    return totalFarepass;
}

function computeRegularJeepFare(jeepDistance, pass){
    var jeepFares = <?php echo json_encode($jeepFare); ?>;
    var regularFare = jeepFares.jeep_regular; // Accessing the first element of the array
    var regularSucceeding = jeepFares.jeep_regular_succeeding; // Accessing the first element of the array
    var totalRegularJeepFare = 0;
    var totalFarepass = 0;
    console.log("Regular Fare: " + regularFare);
    console.log("Regular Succeeding: " + regularSucceeding);

    if (jeepDistance <= 4) {
        totalFarepass = parseFloat(regularFare) * parseFloat(pass);
    } else if (jeepDistance > 4) {
        var differenceDistance = jeepDistance - 4;
        var distanceFare = differenceDistance * regularSucceeding;
        totalRegularJeepFare = parseFloat(regularFare) + parseFloat(distanceFare);
        totalFarepass =  (totalRegularJeepFare * pass).toFixed(2);
    }

    return totalFarepass;
}

function computeDiscountBusFare(busDistance, pass){
    var busFares = <?php echo json_encode($busFare); ?>;
    var discountFare = busFares.bus_discounted; // Accessing the first element of the array
    var discountSucceeding = busFares.bus_discounted_succeeding; // Accessing the first element of the array
    var totaldiscountBusFare = 0;

    if (busDistance <= 4) {
        totaldiscountFarepass = parseFloat(discountFare) * parseFloat(pass);
    } else if (busDistance > 4) {
        var differenceDistance = busDistance - 4;
        var distanceFare = differenceDistance * discountSucceeding;
        totaldiscountBusFare = parseFloat(discountFare) + parseFloat(distanceFare);
        var totaldiscountFarepass =  totaldiscountBusFare * pass;
    }

    return totaldiscountFarepass;
}
function computeDiscountJeepFare(jeepDistance, pass){
    var jeepFares = <?php echo json_encode($jeepFare); ?>;
    var discountFare = jeepFares.jeep_discounted; // Accessing the first element of the array
    var discountSucceeding = jeepFares.jeep_discounted_succeeding; // Accessing the first element of the array
    var totaldiscountJeepFare = 0;

    if (jeepDistance <= 4) {
        totaldiscountFarepass = parseFloat(discountFare) * parseFloat(pass);
    } else if (jeepDistance > 4) {
        var differenceDistance = jeepDistance - 4;
        var distanceFare = differenceDistance * discountSucceeding;
        totaldiscountJeepFare = parseFloat(discountFare) + parseFloat(distanceFare);
        var totaldiscountFarepass =  (totaldiscountJeepFare * pass).toFixed(2);
    }

    return totaldiscountFarepass;
}
/////////////////////////////////
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
    var nearestRowNumber = nearestIndex + 1;

    return { latitude: nearestCoordinate.latitude, longitude: nearestCoordinate.longitude, nearestRowNumber};
}

function findNearestBusCoordinates(targetLatLng, bRoutes){
    
    var nearestDistance = Number.MAX_VALUE;
    var nearestCoordinate = null;
    var nearestIndex = -1;
    var vehicleRoute = null;
    
    for (var i = 1; i < bRoutes.length; i++) {
        var route = bRoutes[i];
        var routeLatLng = L.latLng(route.latitude, route.longitude); // Create LatLng object properly
        var distance = targetLatLng.distanceTo(routeLatLng);
        
        if (distance < nearestDistance) {
            nearestDistance = distance;
            nearestCoordinate = route;
            nearestIndex = i;
            vehicleRoute = route.route_name;
        }
    }
    console.log('Route Name: ', vehicleRoute)
    var nearestRowNumber = nearestIndex + 1; 

    return { latitude: nearestCoordinate.latitude, longitude: nearestCoordinate.longitude, nearestRowNumber: nearestRowNumber, distanceToTarget: nearestDistance, vehicleRoute: vehicleRoute};
}


</script>
</html>