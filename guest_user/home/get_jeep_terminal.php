<?php
include '../../connection.php';

// Assuming your table structure is as mentioned earlier
$query = "SELECT jeep_latitude, jeep_longitude FROM tb_jeep_terminal WHERE jeepId = 1"; // Assuming jeepId 1 is the terminal you want to locate

$result = mysqli_query($conn, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $location = array(
        'latitude' => $row['jeep_latitude'],
        'longitude' => $row['jeep_longitude']
    );
    echo json_encode($location);
} else {
    echo json_encode(array('error' => 'Unable to fetch jeepney terminal location.'));
}

mysqli_close($conn);

?>