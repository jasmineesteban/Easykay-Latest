<?php

include "../../connection.php";

if (isset($_POST['selectedValue'])) {
    $selectedTodaId = $_POST['selectedValue'];

    $toda_query = "SELECT * FROM tb_tricycle_toda WHERE toda_id = '$selectedTodaId'";
    $result = mysqli_query($conn, $toda_query);

    if ($row = mysqli_fetch_assoc($result)) {
        // Display the selected Toda's details
        echo '<div class="row mt-3">';
        echo '<div class="col-6">';
        echo '<h5 class="title-fare">' . $row['toda_name'] . '</h5>';
        echo '<p>Terminal: ' . $row['toda_terminal'] . '</p>';
        echo '</div>';
        echo '<div class="col-2 text-center">';
        echo '<button class="btn" id="sub-btn" data-bs-toggle="modal" data-bs-target="#editTodaFare">';
        echo '<i class="fa-solid fa-pen-to-square"></i><span class="text"> Edit Toda</span>';
        echo '</button>';
        echo '</div>';
        echo '<div class="col-2 text-center">';
        echo '<button type="button" class="btn" id="sub-btn" data-bs-toggle="modal" data-bs-target="#archiveTodaFare">';
        echo '<i class="fa-solid fa-box-archive arc mx-2"></i></i><span class="text"> Archive Toda</span>';
        echo '</button>';
        echo '</div>';
        echo '<div class="col-2 text-center">';
        echo '<button class="btn" id="sub-btn" data-bs-toggle="modal" data-bs-target="#addTodaFare">';
        echo '<i class="fa-solid fa-plus mx-1"></i><span class="text">Add Route</span>';
        echo '</button>';
        echo '</div>';
        echo '</div>';
        echo '<div class="horizontal-line">';
        echo '<span class="line"></span>';
        echo '</div>';

        $_SESSION['selectedTodaId'] = $row['toda_id'];

        // Fetch and display routes and fares
        $routes_query = "SELECT * FROM tb_toda_fare WHERE toda_id = '$selectedTodaId'";
        $routes_result = mysqli_query($conn, $routes_query);

        echo '<div class="">';
        echo '<div class="col-lg-12">';
        echo '<div class="m-5 py-2">';
        echo '<div class="row row-fare" style="margin-top: -30px">';
        echo '<div class="col-3 text-center">';
        echo '<span><b>Route</b> </span>';
        echo '</div>';
        echo '<div class="col-3 text-center">';
        echo '<span><b>1 Passenger Fare</b> </span>';
        echo '</div>';
        echo '<div class="col-3 text-center">';
        echo '<span><b>2 Passengers Fare</b> </span>';
        echo '</div>';
        echo '</div>';


    while ($routeRow = mysqli_fetch_assoc($routes_result)) {
        echo '<div class="row row-fare my-2 py-2 shadow-sm">';
        echo '<div class="col-3 text-center my-auto">';
        echo '<span>' . $routeRow['toda_route'] . '</span>';
        echo '</div>';
        echo '<div class="col-3 text-center my-auto">';
        echo '<span>' . $routeRow['toda_one_pass'] . '</span>';
        echo '</div>';
        echo '<div class="col-3 text-center my-auto">';
        echo '<span>' . $routeRow['toda_two_pass'] . '</span>';
        echo '</div> ';
        echo '<div class="col-3 text-center">';
        echo '<form method="POST">
                <input type="hidden" class="form-control" id="updateFare" name="updateFare" '. $routeRow['toda_fare_id'] .' required>
                <button type="submit" class="btn btn-light fs-6" name="update-fare"><span class="fw-light text-muted">Update</span></button>
                </form>';
        echo '</div> ';
        echo '</div> ';
    }
        echo '</div>';
        echo '</div></div>';
    } else {
        echo "";
    }
}

if (isset($_POST['add-route'])) {
    $selectedTodaId = $_POST['selectedTodaId'];
    $toda_route = isset($_POST['route']) ? $_POST['route'] : '';
    $toda_one_pass = isset($_POST['passenger1']) ? $_POST['passenger1'] : '';
    $toda_two_pass = isset($_POST['passenger2']) ? $_POST['passenger2'] : '';

    $toda_fare_id = generateFareId($conn);

    $query1 = "INSERT INTO `tb_toda_fare` (`toda_fare_id`, `toda_id`, `toda_route`, `toda_one_pass`, `toda_two_pass`)
               VALUES ('$toda_fare_id', '$selectedTodaId', '$toda_route', '$toda_one_pass', '$toda_two_pass')";

    $res = mysqli_query($conn, $query1);

    if ($res) {
        $message = "You have successfully added a route and fare for this TODA.";
        activityLog($message, $toda_fare_id, $conn);
        $_SESSION['addFare_success'] = true;
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit; // Terminate script execution
}

$rows1 = mysqli_query($conn, "SELECT * FROM tb_toda_fare");

function generateFareId($conn){
    $queryid1 = "SELECT toda_fare_id FROM tb_toda_fare ORDER BY toda_fare_id DESC LIMIT 1"; 
    $result1 = mysqli_query($conn, $queryid1);
        
    $initialid1 = "fare-";
                
    if ($row1 = mysqli_fetch_assoc($result1)) { 
        $lastID1 = $row1['toda_fare_id'];
        $numericPart1 = (int)substr($lastID1, -6);
                
        $numericPart1++;                    

        $toda_fare_id = $initialid1 . str_pad($numericPart1, 6, '0', STR_PAD_LEFT);
    }
    else {  
        $toda_fare_id = $initialid1 . '000001';
    }

    return $toda_fare_id;
}

if (isset($_POST['add-route'])) {
    $selectedTodaId = $_POST['selectedTodaId'];

    $_SESSION['selectedValue'] = $selectedTodaId;

    // Redirect to the same page to avoid form resubmission on page refresh
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit;
}

    // Retrieve the selected TODA ID from the session
    $selectedTodaId = isset($_SESSION['selectedTodaId']) ? $_SESSION['selectedTodaId'] : '';

    // Fetch TODA details from the database based on the selected TODA ID
    $toda_query = "SELECT * FROM tb_tricycle_toda WHERE toda_id = '$selectedTodaId'";
    $result = mysqli_query($conn, $toda_query);

    if ($row = mysqli_fetch_assoc($result)) {
        // Populate input fields in the edit TODA modal form with TODA details
        echo '<script>';
        echo 'document.getElementById("editToda").value = "' . $row['toda_name'] . '";';
        echo 'document.getElementById("editTodaTerminal").value = "' . $row['toda_terminal'] . '";';
        echo 'document.getElementById("latitudeEditEvent").value = "' . $row['toda_latitude'] . '";';
        echo 'document.getElementById("longitudeEditEvent").value = "' . $row['toda_longitude'] . '";';
        echo '</script>';
    }

    // Fetch fare details for the selected TODA
    $fare_query = "SELECT * FROM tb_toda_fare WHERE toda_id = '$selectedTodaId'";
    $fare_result = mysqli_query($conn, $fare_query);

    if ($fare_row = mysqli_fetch_assoc($fare_result)) {
        
        // Populate input fields in the add route modal form with fare details
        echo '<script>';
        echo 'document.getElementById("editRoute").value = "' . $fare_row['toda_route'] . '";';
        echo 'document.getElementById("editPassenger1").value = "' . $fare_row['toda_one_pass'] . '";';
        echo 'document.getElementById("editPassenger2").value = "' . $fare_row['toda_two_pass'] . '";';
        echo '</script>';
    }

    $toda_query = "SELECT * FROM `tb_tricycle_toda` WHERE `toda_id` = '$selectedTodaId'";
    $toda_result = mysqli_query($conn, $toda_query);

    if ($toda_row = mysqli_fetch_assoc($toda_result)) {
        
        // Populate input fields in the add route modal form with fare details
        echo '<script>';
        echo 'document.getElementById("archive-name").textContent = "'. $toda_row['toda_name'] .'";';
        echo '</script>';
    }
    
?>





