<?php
    session_start();
    include "../connection.php";
    include_once "delete_archive.php";
    include "../login/idset.php";

    // Calculate the date one year ago
    $oneYearAgo = date('Y-m-d', strtotime('-1 year'));

    // Delete records older than one year
    $deleteQuery = "DELETE FROM tb_activity_log WHERE log_date < ?";
    $deleteStmt = $conn->prepare($deleteQuery);
    $deleteStmt->bind_param('s', $oneYearAgo);
    $deleteStmt->execute();
    $deleteStmt->close();

    $rows = mysqli_query($conn, "SELECT * FROM tb_activity_log ORDER BY log_id DESC");
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../images/logo.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  	<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/99c24c4877.js" crossorigin="anonymous"></script>

    <script src="ad_sidebar.js"></script>

    <link rel="stylesheet" type="text/css" href="home_2.css">

    <title>Admin | Home</title>
</head>
<body>
    <div class="wrapper">
        <div class="top_navbar">
            <div class="hamburger mx-3">
                <div class="nav-icon d-flex justify-content-center"><img class="" src="../images/logo.png" alt=""></div>
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
                                <a class="nav-link" href="ad_profile.php">Profile</a>
                            </div>
                            <div class="dd_item"> 
                                <a class="nav-link" href="../login/logout.php">Logout</a>
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
                            <a class="nav-link side-active" href="ad_home.php">
                                <span class= "icon"><i class="fa-solid fa-house"></i></span>
                                <span class="title ms-2">Home</span>
                            </a>
                        </li>
                        <li class="nav-item my-2">
                            <a class="nav-link" href="events/ad_event.php">
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
                                <a href="explore/resorts.php" class="nav-link">Resorts</a>
                            </li>
                            <li class="nav-item">
                                <a href="explore/recreational.php" class="nav-link">Recreational Facilities</a>
                            </li>
                            <li class="nav-item">
                                <a href="explore/hotel_lodge.php" class="nav-link">Hotel & Lodge</a>
                            </li>
                            <li class="nav-item">
                                <a href="explore/natural_manmade.php" class="nav-link">Natural/Man-Made</a>
                            </li>
                            <li class="nav-item">
                                <a href="explore/cultural.php" class="nav-link">Cultural/Religious</a>
                            </li>
                            <li class="nav-item">
                                <a href="explore/restaurants.php" class="nav-link">Restaurants</a>
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
                                    <a href="fares/jeep.php" class="nav-link">Jeepney</a>
                                </li>
                                <li class="nav-item">
                                    <a href="fares/bus.php" class="nav-link">Bus</a>
                                </li>
                                <li class="nav-item">
                                    <a href="fares/tricycle.php" class="nav-link">Tricycle</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item my-2">
                            <a class="nav-link" href="faqs/ad_faqs.php">
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
                <div class="home">
                    <div class="row">
                        <div class="col-10">
                            <h3 class="title mb-3">Activity Log</h3>
                        </div>
                    </div>
                    <div class="horizontal-line">
                        <span class="line"></span>
                    </div>
                  
                    <!-- body --->
                    <div class="mt-3">
                    <?php foreach($rows as $row) : 
                ?>
                
                <div class="row logs mx-auto my-2 p-2 shadow-sm">
                    <div class="col-4 text-center">
                        <span><?php echo $row['log_date']; ?></span>
                    </div>
                    <div class="col-8">
                        <span><?php echo $row['log_message']; ?></span>
                    </div>
                </div>
            <?php endforeach; ?>   
                </div></div>

            </div>
        </div>
    </div>	
    
  
</body>
</html>