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
    <script src="jeep.js"> // locate jeep terminal </script> 
    <script src="side_panel.js"> // side panel </script> 
    <script>
        var lat, long, currLocMarker, currLocCircle, currentLocation, watchId;

       // var  destinationMarker, destinationCircle, originMarker;
       // var currentLocation, destinationLocation;
       // var lat, long, accuracy;
       // var watchId;
       // var destinationInput, originInput, numPassenger;
       // var polyline, currpolyline;
       // var nearestBusCoordinates, nearestJeepCoordinates;
       // var totalBusDistance = 0;
       // var originBusDistance = 0;
       // var destinationBusDistance = 0;
       // var vehicleType;

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

            currLocMarker = L.marker([lat, long]).addTo(map);
            currLocCircle = L.circle([lat, long], {
                color: '#20A2AA',
                fillColor: '#20A2AA',
                fillOpacity: 0.5,
                radius: 20
            }).addTo(map);
            currLocMarker.bindPopup('You are here.').openPopup();

            document.getElementById('origin').placeholder = 'Your location';

            console.log(lat, long)
           
        }

         // Function to toggle geolocation updates
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

        var destinationMarker, originMarker, desMarkerLatLng, destinationCircle;
        var originMarker, originCircle;

    </script>
    <script src="functions.js"></script>
    <script>
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

        var myGoForm = document.getElementById('myGoForm');
        if (myGoForm) {
            myGoForm.addEventListener('submit', function (event) {
                event.preventDefault(); // Prevent the form from submitting

                var originInput = document.getElementById('origin').value.trim();
                var destinationInput = document.getElementById('destination').value.trim();
                var numPassenger = document.getElementById('passengerInput').value.trim();

                if(originInput !== '' && destinationInput !== ''){
                    geocodeDestination();
                    geocodeOrigin(numPassenger);
                }
                if(originInput === '' && destinationInput !== ''){
                    geocodeDestination();
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
        }
        var travelsSection = document.querySelector('.travels');
        travelsSection.innerHTML = '';
        if(nearestOriginBusCoordinates && nearestDestinationBusCoordinates){
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
        }
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

    </script>
    <script>
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
    </script>
</html>
