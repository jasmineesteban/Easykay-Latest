<?php

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

    $csvBusFile = 'coordinates_bus.csv';
    $bfile = fopen($csvBusFile, 'r');

    $busRoutes = [];

    while (($bline = fgetcsv($bfile)) !== FALSE) {
        // Process each line of the CSV
        $broute = [
            'vehicle_type' => $bline[0],
            'route_name' => $bline[1],
            'latitude' => $bline[2],
            'longitude' => $bline[3],
            'waypoint_id' => $bline[4],
            'full_waypoint_id' => $bline[5],
        ];

        $busRoutes[] = $broute;
    }
?>