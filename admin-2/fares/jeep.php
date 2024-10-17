<?php
    session_start();
    include "../../connection.php";
    include "../activity_log.php";
    include "../../login/idset.php";

    if(isset($_POST['fare-update'])){
        $fare_id = 1;
        $updated_regular = $_POST['regular'];
        $updated_regular_succ = $_POST['regular-succ'];
        $updated_discounted = $_POST['disc'];
        $updated_discounted_succ = $_POST['disc-succ'];

        $query = "UPDATE `jeep_fare` SET `jeep_regular`='$updated_regular',`jeep_regular_succeeding`='$updated_regular_succ',
                `jeep_discounted`='$updated_discounted',`jeep_discounted_succeeding`='$updated_discounted_succ ' WHERE 1";
                            
        $res = mysqli_query($conn, $query);
        
        if($res) {
            $message = "You updated the Jeepney Fare.";
            activityLog($message, $fare_id , $conn);
            $_SESSION['update_success'] = true;
        }
        header("Location: ".$_SERVER['PHP_SELF']);
        exit; // Terminate script execution
    }

    $rows = mysqli_query($conn, "SELECT * FROM jeep_fare");

    while ($row = mysqli_fetch_assoc($rows)) {
        $regular = $row['jeep_regular'];
        $regular_succeeding = $row['jeep_regular_succeeding'];
        $discounted = $row['jeep_discounted'];
        $discounted_succeeding = $row['jeep_discounted_succeeding'];
    }
    $modal_regular = $regular;
    $modal_discounted = $discounted;
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

    <link rel="stylesheet" type="text/css" href="fares_2.css">
    <title>Admin | Jeepney's Fares</title>
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
                                    <a href="jeep.php" class="nav-link side-active">Jeepney</a>
                                </li>
                                <li class="nav-item">
                                    <a href="bus.php" class="nav-link">Bus</a>
                                </li>
                                <li class="nav-item">
                                    <a href="tricycle.php" class="nav-link">Tricycle</a>
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
                    <div class="row">
                        <div class="col-10">
                            <h3 class="title-fare mb-3">Jeepney's Fare</h3>
                        </div>
                        <div class="col-2 text-center">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateFare">
                                <i class="fa-solid fa-pen-to-square mx-2"></i><span class="text">Update</span>
                            </button>
                        </div>
                    </div>
                    <div class="horizontal-line">
                        <span class="line"></span>
                    </div>
                    <div class="row mx-auto p-2 mt-3">
                        <div class="col-6">
                            <p>Regular: <?php echo $regular ?></p>
                            <p>Succeeding kilometers: <?php echo $regular_succeeding ?></p>
                        </div>
                        <div class="col-6">
                            <p>Discounted: <?php echo $discounted ?></p>
                            <p>Succeeding kilometers:  <?php echo $discounted_succeeding ?></p>
                        </div>
                    </div>
                    <div class="horizontal-line">
                        <span class="line"></span>
                    </div>

                    <div class="row mx-auto p-2">
                        <div class="col-4 text-center">
                            <span><b>Distance (km)</b> </span>
                        </div>
                        <div class="col-4 text-center">
                            <span><b>Regular Fare</b> </span>
                        </div>
                        <div class="col-4 text-center">
                            <span><b>Discounted Fare</b> </span>
                        </div>
                    </div>
                    
                    <!-- body --->

                    <?php
                        for ($i=1; $i < 51; $i++) { 
                            if($i < 5){ ?>
                               <div class="row row-fare mx-auto my-2 p-2 shadow-sm">
                                    <div class="col-4 text-center">
                                        <span><?php echo $i; ?></span>
                                    </div>
                                    <div class="col-4 text-center">
                                        <span><?php echo $regular; ?></span>
                                    </div>
                                    <div class="col-4 text-center">
                                        <span><?php echo $discounted; ?></span>
                                    </div>
                                </div>
                    <?php   }else{
                                $regular += $regular_succeeding;
                                $discounted += $discounted_succeeding; 
                                
                                $regular = number_format($regular, 2);
                                $discounted = number_format($discounted, 2);
                                
                                ?>
                                
                                <div class="row row-fare mx-auto my-2 p-2 shadow-sm">
                                    <div class="col-4 text-center">
                                        <span><?php echo $i; ?></span>
                                    </div>
                                    <div class="col-4 text-center">
                                        <span><?php echo $regular; ?></span>
                                    </div>
                                    <div class="col-4 text-center">
                                        <span><?php echo $discounted; ?></span>
                                    </div>
                                </div>           
                    <?php
                            }
                        }?>
                </div>

            </div>
        </div>
        
        <!-- Modal -->
        <div class="modal fade" id="updateFare" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updateFareLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="updateFareLabel">Update Jeepney's Fare</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div> 
                <form action="" method="POST" class="needs-validation" novalidate>
                    <div class="modal-body">
                        <h6><b>Regular Fare</b></h4>
                        <div class="row form-group m-2">
                            <label for="regular" class="col-sm-6 col-form-label">First 4 kilometers <span class="required-asterisk">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="regular" name="regular" value="<?php echo $modal_regular;?>" required pattern="[0-9]+(\.[0-9]+)?"> 
                                <div class="invalid-feedback">Please enter a valid number.</div>
                            </div>
                        </div>
                        <div class="row form-group m-2">
                            <label for="regular-succ" class="col-sm-6 col-form-label">Succeeding kilometers <span class="required-asterisk">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="regular-succ" name="regular-succ" value="<?php echo $regular_succeeding;?>" required pattern="[0-9]+(\.[0-9]+)?">
                                <div class="invalid-feedback">Please enter a valid number.</div>
                            </div>
                        </div>
                        <h6><b>Discounted Fare</b></h4>
                        <div class="row form-group m-2">
                            <label for="disc" class="col-sm-6 col-form-label">First 4 kilometers<span class="required-asterisk">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="disc" name="disc" value="<?php echo $modal_discounted;?>" required pattern="[0-9]+(\.[0-9]+)?">
                                <div class="invalid-feedback">Please enter a valid number.</div>
                            </div>
                        </div>
                        <div class="row form-group m-2">
                            <label for="disc-succ" class="col-sm-6 col-form-label">Succeeding kilometers<span class="required-asterisk">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="disc-succ" name="disc-succ" value="<?php echo $discounted_succeeding;?>" required pattern="[0-9]+(\.[0-9]+)?">
                                <div class="invalid-feedback">Please enter a valid number.</div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col-4 mx-4">
                            <button type="submit" name="fare-update" class="btn btn-primary " >Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

        <script src="modal.js"></script>

    </div> 

    <?php if(isset($_SESSION['update_success']) && $_SESSION['update_success']): ?>
        <script src="message.js"></script>
        <?php unset($_SESSION['update_success']); ?>
    <?php endif; ?>

    <!-- Update success modal -->
    <div class="modal fade" id="updateSuccessModal" tabindex="-1" aria-labelledby="updateSuccessModalLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content success-message">
                <div class="modal-body d-flex justify-content-between">
                    <span>Jeepney fare successfully updated!</span>
                    <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

            </div>
        </div>
    </div>

    
</body>
</html>
