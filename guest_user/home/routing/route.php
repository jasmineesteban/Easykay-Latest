<?php

$csvFile = 'your_file.csv';
$file = fopen($csvFile, 'r');

while (($line = fgetcsv($file)) !== FALSE) {
    // Process each line of the CSV
    $vehicleType = $line[0];
    $routeName = $line[1];
    $latitude = $line[2];
    $longitude = $line[3];
    $waypointID = $line[4];
    $fullWaypointID = $line[5];

    
}
fclose($file);

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


