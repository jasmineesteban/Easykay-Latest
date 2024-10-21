<?php
    session_start();

    include "../../connection.php";

    // Retrieve latitude and longitude from URL parameters
    $destinationLatitude = isset($_GET['latitude']) ? $_GET['latitude'] : null;
    $destinationLongitude = isset($_GET['longitude']) ? $_GET['longitude'] : null;

    $csvFile = 'coordinates_jeep.csv';
$file = fopen($csvFile, 'r');

$routes = [];

while (($line = fgetcsv($file)) !== FALSE) {
    // Process each line of the CSV
    $route = [
        'vehicle_type' => $line[0],
        'route_name' => $line[1],
        'latitude' => $line[2],
        'longitude' => $line[3],
        'waypoint_id' => $line[4],
        'full_waypoint_id' => $line[5],
    ];

    $routes[] = $route;
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
            minZoom: 7,
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
        var currLocMarker, currLocCircle, destinationMarker, destinationCircle;
        var currentLocation, destinationLocation;
        var lat, long, accuracy;
        var watchId;

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
            accuracy = position.coords.accuracy

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
            document.getElementById('origin').placeholder = 'Your location';

            console.log(lat, long, accuracy)
           
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

</script>
<script src="jeep.js"></script>
<!---------------------- SIDE PANEL ---------------------->
<script src="side_panel.js"></script>
<script>
    var destinationInput, originInput, numPassenger
    var destinationMarker, originMarker; 
    var polyline, currpolyline;

var myForm = document.getElementById('myForm');
if (myForm) {
    myForm.addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent the form from submitting

    var originInput = document.getElementById('origin').value.trim();
    var destinationInput = document.getElementById('destination').value.trim();
    var numPassenger = document.getElementById('passengerInput').value.trim();

    if(originInput !== '' && destinationInput !== ''){
        geocodeDestination();
        geocodeOrigin();
        if(currLocMarker){
            map.removeLayer(currLocMarker);
            map.removeLayer(currLocCircle);
        }
        if (currpolyline) {
            map.removeLayer(currpolyline);
        }
        
        console.log(numPassenger);
    } else if(destinationInput !== '' && originInput === ''){
        geocodeDestination();
        if (originMarker) {
            map.removeLayer(originMarker);
            map.removeLayer(originCircle);
        }
       

        console.log(numPassenger);
    } 
    
});
}
else{
    console.log('No form found');
}

function geocodeDestination() {
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

                    destinationMarker.bindPopup('Your destination.').openPopup();

                    
                    if (currLocMarker && destinationMarker) {
                        var currLatLng = currLocMarker.getLatLng();
                        var destinationLatLng = destinationMarker.getLatLng();
                        var polylineCoordinates = [currLatLng, destinationLatLng];
                        if (polyline) {
                            map.removeLayer(polyline);
                        }
                        currpolyline = L.polyline(polylineCoordinates, { color: '#20A2AA', weight: 5}).addTo(map);
                    }
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

function geocodeOrigin() {
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

                    if (originMarker && destinationMarker) {
                        var routes = <?php echo json_encode($routes); ?>;

                        var originLatLng = originMarker.getLatLng();
                        var destinationLatLng = destinationMarker.getLatLng();
                        routes[0].latitude = originLatLng.lat;
                        routes[0].longitude = originLatLng.lng;

                        if (currpolyline) {
                            map.removeLayer(currpolyline);
                        }

                        j = 2;
                        for (var i = 1; i < routes.length; i++) {
                            var route = routes[i];
                            var droute = routes[j];
                            

                            console.log("coordinates: ", route.latitude, route.longitude)
                            if(j < routes.length){
                            var polyline = L.polyline([
                                [route.latitude, route.longitude], [droute.latitude, droute.longitude]
                            ], { color: 'blue' }).addTo(map);
                            j++;
                        }
                            
                        }  
                    }
                  
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

</script>

</html>
