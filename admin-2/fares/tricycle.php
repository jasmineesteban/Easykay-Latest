<?php

    session_start();
    include "../../connection.php";
    include "../activity_log.php";
    include "../../login/idset.php";
    include "toda_process.php";

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

    <script src="../ad_sidebar.js"></script>

    <link rel="stylesheet" type="text/css" href="tricyy.css">

    <title>Admin | Tricycle's Fares</title>
</head>
<body>
    <div class="wrapper">
        <div class="top_navbar">
            <div class="hamburger mx-3">
                <div class="nav-icon d-flex justify-content-center"><img class="" src="../../images/logo.png" alt=""></div>
            </div>
            <div class="menu">
                <div class="logo">
                    EasyKay
                </div>
                <div class="right_menu">
                    <ul>
                        <li><i class="fas fa-user"></i>
                        <div class="profile_dd">
                            <div class="dd_item"> 
                                <a class="nav-link" href="../ad_profile.php">Profile</a>
                            </div>
                            <div class="dd_item"> 
                                <a class="nav-link" href="../../login/logout.php">Logout</a>
                            </div>
                        </div>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="main_container">
            <div class="sidebar">
                <div class="sidebar__inner">
                <div class="profile mx-4">
                        <div class="profile_info">
                            <p>Welcome</p>
                            <p class="profile_name fs-5"><b>Administrator</b></p>
                        </div>
                    </div>
                    <ul class="nav nav-pills flex-column mt-2 mt-sm-0" id="menu">
                        <li class="nav-item my-2">
                            <a class="nav-link" href="../ad_home.php">
                                <span class= "icon"><i class="fa-solid fa-house"></i></span>
                                <span class="title ms-2">Home</span>
                            </a>
                        </li>
                        <li class="nav-item my-2">
                            <a class="nav-link" href="../events/ad_event.php">
                                <span class= "icon"><i class="fa-solid fa-calendar"></i></span>
                                <span class=" title ms-2">Events</span>
                            </a>
                        </li>
                        <li class="nav-item disabled my-2">
                            <a class="nav-link" href="#exploresidemenu" data-bs-toggle="collapse">
                                <span class= "icon"><i class="fa-solid fa-map"></i></span>
                                <span class="title ms-2">Explore  <i class="fa-solid fa-caret-down ms-2"></i></span>
                            </a>
                        <ul class="nav collapse ms-4 flex-column" id="exploresidemenu" data-bs-parent="#menu">
                            <li class="nav-item">
                                <a href="../explore/resorts.php" class="nav-link">Resorts</a>
                            </li>
                            <li class="nav-item">
                                <a href="../explore/recreational.php" class="nav-link">Recreational Facilities</a>
                            </li>
                            <li class="nav-item">
                                <a href="../explore/hotel_lodge.php" class="nav-link">Hotel & Lodge</a>
                            </li>
                            <li class="nav-item">
                                <a href="../explore/natural_manmade.php" class="nav-link">Natural/Man-Made</a>
                            </li>
                            <li class="nav-item">
                                <a href="../explore/cultural.php" class="nav-link">Cultural/Religious</a>
                            </li>
                            <li class="nav-item">
                                <a href="../explore/restaurants.php" class="nav-link">Restaurants</a>
                            </li>
                        </ul>
                        </li>
                        <li class="nav-item my-2">
                            <a class="nav-link" href="#faressidemenu" data-bs-toggle="collapse">
                                <span class= "icon"><i class="fa-solid fa-ticket"></i></span>
                                <span class="title ms-2">Fares</span>
                                <i class="fa-solid fa-caret-down ms-2"></i>
                            </a>
                            <ul class="nav collapse ms-4 flex-column" id="faressidemenu" data-bs-parent="#menu">
                                <li class="nav-item">
                                    <a href="jeep.php" class="nav-link">Jeepney</a>
                                </li>
                                <li class="nav-item">
                                    <a href="bus.php" class="nav-link">Bus</a>
                                </li>
                                <li class="nav-item">
                                    <a href="tricycle.php" class="nav-link side-active">Tricycle</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item my-2">
                            <a class="nav-link" href="../faqs/ad_faqs.php">
                                <span class= "icon"><i class="fa-solid fa-question"></i></span>
                                <span class="title ms-2">FAQs</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div> 

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
                    <div class="modal-body">
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
                        
                        <div class="d-flex form-group m-2 my-3">
                            <label for="latitude" class="col-sm-4 col-form-label">Latitude<span class="required-asterisk">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="latitude" name="latitude" required pattern="[0-9]+(\.[0-9]+)?">
                                <div class="invalid-feedback">Please enter a valid latitude.</div>
                            </div>
                        </div>
                        <div class="d-flex form-group m-2">
                            <label for="longitude" class="col-sm-4 col-form-label">Longitude<span class="required-asterisk">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="longitude" name="longitude" required pattern="[0-9]+(\.[0-9]+)?">
                                <div class="invalid-feedback">Please enter a valid longitude.</div>
                            </div> 
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col-4 mx-4">
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
                <div class="modal-body">
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
                    <div class="col-4 mx-4">
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
                    <div class="modal-body">
                    <div class="form-group mx-5 my-1">
                        <label for="editToda" class="col-sm-3 col-form-label">TODA Name<span class="required-asterisk">*</span></label>
                        <div class="row-sm-12">
                            <input type="text" class="form-control" id="editToda" name="editToda" required> 
                            <div class="invalid-feedback">Please fill up this field.</div>
                        </div>
                    </div>
                    <div class="form-group mx-5 my-1">
                        <label for="editTodaTerminal" class="col-sm-6 col-form-label">Terminal <span class="required-asterisk">*</span></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="editTodaTerminal" name="editTodaTerminal" required>
                            <div class="invalid-feedback">Please fill up this field.</div>
                        </div>
                    </div>

                        <div class="row mx-auto p-4">
                            <div class="col-4 text-center">
                                <span>Route</span>
                            </div>
                            <div class="col-4 text-center">
                                <span>1 passenger</span>
                            </div>
                            <div class="col-4 text-center">
                                <span>2 passenger</span>
                            </div>
                    
                            <div class="col-4 text-center p-4">
                                <input type="text" class="form-control" id="editRoute" name="editRoute" required>
                                <div class="invalid-feedback">Please enter a valid number.</div>
                            </div>
                            <div class="col-4 text-center p-4">
                                <input type="text" class="form-control" id="editPassenger1" name="editPassenger1" required>
                                <div class="invalid-feedback">Please enter a valid number.</div>
                            </div>
                            <div class="col-4 text-center p-4">
                                <input type="text" class="form-control" id="editPassenger2" name="editPassenger2" required>
                                <div class="invalid-feedback" >Please enter a valid number</div>
                            </div> 
                    
                    <div class="modal-footer">
                        <div class="col-3 mx-4">
                        <button type="submit" name="edit-toda" class="btn btn-primary" >Save Changes</button>
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

<?php
if (isset($_SESSION['selectedTodaId'])) {
    $selectedTodaId = $_SESSION['selectedTodaId'];
}
?>

</script>
</body>
</html>