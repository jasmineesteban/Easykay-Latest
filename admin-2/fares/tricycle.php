<?php

    session_start();
    include "../../connection.php";
    include "../activity_log.php";
    include "../../login/idset.php";
    include "toda_process.php";
    include "archive_function.php";

    if (isset($_SESSION['todaId'])) {
        $toda_id = $_SESSION['todaId'];
    }

    if(isset($_POST['add-toda'])){
        $toda_name = $_POST['todaName'];
        $toda_terminal = $_POST['todaTerminal'];
        $toda_latitude = $_POST['latitude'];
        $toda_longitude = $_POST['longitude'];

        $toda_id = generateId($conn);

        $query = "INSERT INTO `tb_tricycle_toda`(`toda_id`, `toda_name`, `toda_terminal`, `toda_latitude`, `toda_longitude`)
         VALUES ('$toda_id', '$toda_name','$toda_terminal', '$toda_latitude' ,'$toda_longitude')";
                            
        $res = mysqli_query($conn, $query);
        
        if($res) {
            $message = "You added tricycle toda ". $toda_name .".";
            activityLog($message, $toda_id, $conn);
            $_SESSION['add_success'] = true;
        }
        header("Location: ".$_SERVER['PHP_SELF']);
        exit; // Terminate script execution
    }

    $rows = mysqli_query($conn, "SELECT * FROM tb_tricycle_toda");

    function generateId($conn){
        $queryid = "SELECT toda_id FROM tb_tricycle_toda ORDER BY toda_id DESC LIMIT 1"; 
        $result = mysqli_query($conn, $queryid);
            
        //11 characters toda-000000
                    
        $initialid = "toda-";
                    
        if ($row = mysqli_fetch_assoc($result)) { 
            $lastID = $row['toda_id'];
            $numericPart = (int)substr($lastID, -6);
                    
            $numericPart++;                    

            $toda_id = $initialid . str_pad($numericPart, 6, '0', STR_PAD_LEFT);
        }
        else {  
            $toda_id = $initialid . '000001';
        }

        return $toda_id;
    }

    if(isset($_POST['edit-toda'])){
        $editId = $_POST['editselectedTodaId'];
        $todaName =  $_POST['editToda'];
        $todaTerminal =  $_POST['editTodaTerminal'];
        $todaLat =  $_POST['latitude'];
        $todaLong =  $_POST['longitude'];
        $query = "UPDATE `tb_tricycle_toda` SET `toda_name`='$todaName', `toda_terminal`='$todaTerminal', `toda_latitude`='$todaLat', `toda_longitude`='$todaLong' WHERE `toda_id` = '$editId'";
        $result = mysqli_query($conn, $query);

    }

    if(isset($_POST['update-fare'])){
        $updateId = $_POST['updateFare'];
        
        if ($updateId != null) {
            $query = "SELECT * FROM `tb_toda_fare` WHERE `toda_fare_id` = '$updateId'";
            $fare = mysqli_query($conn, $query);
            $row = mysqli_fetch_row($fare);
            $rowDataFare = array();

            if ($row) {
                $rowDataFare = $row;
            }
            $_SESSION['update_fare_modal'] = true;
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../images/logo.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  	<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/99c24c4877.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    <script src="../ad_sidebar.js"></script>

    <link rel="stylesheet" type="text/css" href="tricyy.css">

    <title>Admin | Tricycle's Fares</title>
</head>
<body>
    <div class="wrapper">
        

        <div class="containter">
            <div class="col-lg-10 float-end">
                <div class="fares">
                    <div class="row mb-3">
                        <div class="col-3 my-auto ">
                            <h3 class="title-fare">Tricycle Fare</h3>
                        </div>
                        <div class="col-5 my-auto">
                            <select class="form-select toda-select w-50 p-1"id="toda" name="toda">
                                <option value="">Toda</option>
                                <?php
                                    $toda_query = "SELECT toda_id, toda_name FROM tb_tricycle_toda";
                                    $result = mysqli_query($conn, $toda_query );
                                
                                    // Generate dropdown options dynamically
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<option class='option' value='" . $row['toda_id'] . "'>" . $row['toda_name'] . "</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-2 text-center">
                            <button type="button" class="btn archive" data-bs-toggle="modal" data-bs-target="#Archives">
                                <i class="fa-solid fa-box-archive arc mx-2"></i><span class="arc-text">Archive</span>
                            </button>
                        </div>
                        <div class="col-2 text-center my-auto">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addToda">
                                <i class="fa-solid fa-plus mx-2"></i><span class="text">Add Toda</span>
                            </button>
                        </div>
                    </div>
                    <div class="horizontal-line">
                        <span class="line"></span>
                    </div>

    <!-- get id of selected toda-->
    <script>
        $(document).ready(function() {
        $('#toda').change(function() {
            var selectedValue = $(this).val();
            
            // AJAX request
            $.ajax({
                type: 'POST',
                url: 'toda_process.php',
                data: { selectedValue: selectedValue,
                        id: selectedValue
                 },
                success: function(response) {
                    // Display the selected value in a designated HTML element
                    $('#selectedValueDisplay').html(response);
                    
                    var id = document.getElementById('selectedTodaId').value = selectedValue;
                    var editid = document.getElementById('editselectedTodaId').value = selectedValue;
                    var archiveid = document.getElementById('archiveId').value = selectedValue;
                    console.log(id);
                },
                error: function(error) {
                    console.log(error);
                }
            });

        });
    });

    </script>

    <div id="selectedValueDisplay"></div>

                </div>
            </div>
        </div>
    </div>

   

    <!-- ADD TODA Modal -->
    <div class="modal fade" id="addToda" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addTodaLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addTodaLabel">Add Toda</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div> 
                <form action="" method="POST" class="needs-validation" novalidate>
                    <div class="modal-body px-5 py-2">
                        <div class="form-group m-2">
                            <label for="todaName" class="col-sm-6 col-form-label">Toda Name <span class="required-asterisk">*</span></label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="todaName" name="todaName" required> 
                                <div class="invalid-feedback">Please fill up this field.</div>
                            </div>
                        </div>
                        <div class="form-group m-2">
                            <label for="todaTerminal" class="col-sm-6 col-form-label">Terminal <span class="required-asterisk">*</span></label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="todaTerminal" name="todaTerminal" required>
                                <div class="invalid-feedback">Please fill up this field.</div>
                            </div>
                        </div>
                            <br>
                            <div id="mapAddEvent" style="width: 100%; height: 400px; margin: auto; border: 1px solid #20a2aa; border-radius: 10px; overflow: hidden;"></div>
                            <div class="d-flex justify-content-between flex-column mt-2">
                                <div class="form-group d-flex my-2">
                                    <label for="latitudeAddEvent" class="col-sm-4 col-form-label">Latitude <span class="required-asterisk">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="latitudeAddEvent" name="latitude" required readonly>
                                        <div class="invalid-feedback">Please enter a valid latitude.</div>
                                    </div>
                                </div>
                                <div class="form-group d-flex my-2">
                                    <label for="longitudeAddEvent" class="col-sm-4 col-form-label">Longitude<span class="required-asterisk">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="longitudeAddEvent" name="longitude" required readonly>
                                        <div class="invalid-feedback">Please enter a valid longitude.</div>
                                    </div>
                                </div>
                            </div>
                        <div class="modal-footer">
                            <div class="col-3">
                            <button type="submit" name="add-toda" class="btn btn-primary " >Add</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="modal.js"></script>

    </div> 

    <!-- add success modal -->
    <div class="modal fade" id="addsuccessmodal" tabindex="-1" aria-labelledby="addsuccessmodalLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content success-message">
                <div class="modal-body d-flex justify-content-between">
                    <span>Tricycle toda successfully added!</span>
                    <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

            </div>
        </div>
    </div>
    <?php if(isset($_SESSION['add_success']) && $_SESSION['add_success']): ?>
        <script src="add_message.js"></script>
        <?php unset($_SESSION['add_success']); ?>
    <?php endif; ?>

<!-- ADD ROUTE Modal -->
<div class="modal fade" id="addTodaFare" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addTodaFareLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addTodaFareLabel">Add Route</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" class="needs-validation" novalidate>
                <div class="modal-body px-5 py-2">
                    <!-- Existing input fields for Toda details -->
                    <div class="form-group m-2">
                        <div class="col-sm-12">
                            <input type="hidden" class="form-control" id="selectedTodaId" name="selectedTodaId"  required>
                        </div>
                    </div>
                    <!-- Add new input fields for route, 1 passenger, and 2 passengers -->
                    <div class="form-group m-2">
                        <label for="route" class="col-sm-6 col-form-label">Route <span class="required-asterisk">*</span></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="route" name="route" required>
                            <div class="invalid-feedback">Please fill up this field.</div>
                        </div>
                    </div>
                    <div class="form-group m-2">
                        <label for="passenger1" class="col-sm-6 col-form-label">1 Passenger Fare <span class="required-asterisk">*</span></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="passenger1" name="passenger1" required>
                            <div class="invalid-feedback">Please fill up this field.</div>
                        </div>
                    </div>
                    <div class="form-group m-2">
                        <label for="passenger2" class="col-sm-6 col-form-label">2 Passengers Fare <span class="required-asterisk">*</span></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="passenger2" name="passenger2" required>
                            <div class="invalid-feedback">Please fill up this field.</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-3 mx-4">
                        <button type="submit" name="add-route" class="btn btn-primary">Add Route</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

 <!-- add success modal -->
 <div class="modal fade" id="addFaresuccessmodal" tabindex="-1" aria-labelledby="addFaresuccessmodalLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content success-message">
                <div class="modal-body d-flex justify-content-between">
                    <span>You have successfully added a route and fare.</span>
                    <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

            </div>
        </div>
    </div>
    <?php if(isset($_SESSION['addFare_success']) && $_SESSION['addFare_success']): ?>
        <script src="addFare_message.js"></script>
        <?php unset($_SESSION['addFare_success']); ?>
    <?php endif; ?>

<!-- Edit TODA Modal -->
    <div class="modal fade" id="editTodaFare" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addTodaLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 900px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editTodaFare">Edit TODA</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div> 
                <form action="" method="POST" class="needs-validation" novalidate p-1>
                    <div class="modal-body px-5 py-2">
                        <div class="form-group ">
                            <label for="editToda" class="col-sm-3 col-form-label">TODA Name<span class="required-asterisk">*</span></label>
                            <div class="row-sm-12">
                                <input type="text" class="form-control" id="editToda" name="editToda" required> 
                                <div class="invalid-feedback">Please fill up this field.</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="editTodaTerminal" class="col-sm-6 col-form-label">Terminal <span class="required-asterisk">*</span></label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="editTodaTerminal" name="editTodaTerminal" required>
                                <div class="invalid-feedback">Please fill up this field.</div>
                            </div>
                        </div>
                        <br>
                        <div id="mapEditEvent" style="width: 100%; height: 400px; margin: auto; border: 1px solid #20a2aa; border-radius: 10px; overflow: hidden;"></div>
                            <div class="d-flex justify-content-between flex-column mt-2">
                                <div class="form-group d-flex my-2">
                                    <label for="latitudeEditEvent" class="col-sm-4 col-form-label">Latitude <span class="required-asterisk">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="latitudeEditEvent" name="latitude" required readonly>
                                        <div class="invalid-feedback">Please enter a valid latitude.</div>
                                    </div>
                                </div>
                                <div class="form-group d-flex my-2">
                                    <label for="longitudeEditEvent" class="col-sm-4 col-form-label">Longitude<span class="required-asterisk">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="longitudeEditEvent" name="longitude" required readonly>
                                        <div class="invalid-feedback">Please enter a valid longitude.</div>
                                    </div>
                                </div>
                            </div>
                    
                        <div class="modal-footer">
                            <div class="col-3">
                                <input type="hidden" class="form-control" id="editselectedTodaId" name="editselectedTodaId"  required>
                                <button type="submit" name="edit-toda" class="btn btn-primary">Save Changes</button>
                            </div>
                        </div>
                    </div>
                
                </form>
            </div>
        </div>
    </div>

    <script src="modal.js"></script>

    </div> 

    <!-- add success modal -->
    <div class="modal fade" id="addsuccessmodal" tabindex="-1" aria-labelledby="addsuccessmodalLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content success-message">
                <div class="modal-body d-flex justify-content-between">
                    <span>Tricycle toda successfully added!</span>
                    <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

            </div>
        </div>
    </div>
    <?php if(isset($_SESSION['add_success']) && $_SESSION['add_success']): ?>
        <script src="add_message.js"></script>
        <?php unset($_SESSION['add_success']); ?>
    <?php endif; ?>

    <!-- archive modal -->
    <div class="modal fade" id="archiveTodaFare" data-bs-backdrop="static" tabindex="-1" aria-labelledby="arcmodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addExploreLabel">Archive Toda</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div> 
                <form action="" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <p class="text-center fs-5">You're about to archive the <b><span id="archive-name"></span></b>.</p>
                                <br>
                                <p class="opacity-75 fw-light text-muted" >*Archives will automatically be deleted after 30 days.</p>
                            </div>
                        </div>        
                    <div class="modal-footer">
                        <div class="col-4 mx-4">
                            <input type="hidden" class="form-control" id="archiveId" name="archiveId" required>
                            <button type="submit" name="archive-toda" class="btn btn-primary">Archive</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>












    <?php if(isset($_SESSION['update_fare_modal']) && $_SESSION['update_fare_modal']):
        echo '<script src="updatefare.js"></script>';
        unset($_SESSION['update_fare_modal']);
    endif; ?>

    <div class="modal fade" id="updateFareModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updateFareModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 900px;">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editTodaFare">Update Fare</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div> 
            <form action="" method="POST" class="needs-validation" novalidate p-1>
                <div class="modal-body px-5 py-2">
                    <div class="form-group ">
                        <label for="editToda" class="col-sm-3 col-form-label">Fare<span class="required-asterisk">*</span></label>
                        <div class="row-sm-12">
                            <input type="text" class="form-control" id="editToda" name="editToda" value="<?php $rowDataFare[3]; ?>"required> 
                            <div class="invalid-feedback">Please fill up this field.</div>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <div class="col-3">
                            <input type="hidden" class="form-control" id="updateFareId" name="updateFareId" required>
                            <button type="submit" name="updateFare" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
if (isset($_SESSION['selectedTodaId'])) {
    $selectedTodaId = $_SESSION['selectedTodaId'];
}
?>

<script>
        // Function to initialize a map and geocoder for an event form
        function initializeMapAndGeocoder(mapContainerId, latitudeInputId, longitudeInputId, isEditForm) {
            var map = L.map(mapContainerId).setView([14.8064, 120.9614], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            var marker = L.marker([14.8064, 120.9614], {
                draggable: true,
                iconAnchor: [16, 37]
            }).addTo(map);

            // Update latitude and longitude input fields when marker is dragged
            marker.on('drag', function (event) {
                var markerLatLng = marker.getLatLng();
                document.getElementById(latitudeInputId).value = markerLatLng.lat.toFixed(15);
                document.getElementById(longitudeInputId).value = markerLatLng.lng.toFixed(15);
            });

            // If it's an edit form, set the marker position based on the existing latitude and longitude
            if (isEditForm) {
                var existingLatitude = parseFloat(document.getElementById(latitudeInputId).value);
                var existingLongitude = parseFloat(document.getElementById(longitudeInputId).value);

                if (!isNaN(existingLatitude) && !isNaN(existingLongitude)) {
                    var existingLatLng = L.latLng(existingLatitude, existingLongitude);
                    map.setView(existingLatLng, 13);
                    marker.setLatLng(existingLatLng);
                }
            }

            var geocoder = L.Control.geocoder({
                defaultMarkGeocode: false
            }).on('markgeocode', function(e) {
                var latlng = e.geocode.center;
                map.setView(latlng, 13);
                marker.setLatLng(latlng);
                document.getElementById(latitudeInputId).value = latlng.lat.toFixed(15);
                document.getElementById(longitudeInputId).value = latlng.lng.toFixed(15);
            }).addTo(map);

            geocoder.on('markgeocode', function (event) {
                var location = event.geocode.center;
                map.setView(location, 13); // Set the map view to the searched location
                marker.setLatLng(location); // Move the marker to the searched location
                document.getElementById(latitudeInputId).value = location.lat.toFixed(15);
                document.getElementById(longitudeInputId).value = location.lng.toFixed(15);
            });
        }

        // Initialize maps and geocoders for each form
        initializeMapAndGeocoder('mapAddEvent', 'latitudeAddEvent', 'longitudeAddEvent', false);
        initializeMapAndGeocoder('mapEditEvent', 'latitudeEditEvent', 'longitudeEditEvent', true);
    </script>
</body>
</html>