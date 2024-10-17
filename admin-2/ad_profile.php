<?php

session_start();

    include "../connection.php";
    include "../login/idset.php";

    if(isset($_POST['save'])){
        $name = $_POST['name'];
        $username = $_POST['username'];
        $query = "UPDATE `tb_admin_info` SET `admin_name`='$name',`admin_username`='$username' WHERE 1";

        $res = mysqli_query($conn, $query);

        $_SESSION['savesuccess'] = true;
    }

    if (isset($_POST['save-pass'])) {
        $cur_password = $_POST['curpassword'];
    
        $stmt = $conn->prepare("SELECT admin_password FROM tb_admin_info WHERE 1");
        $stmt->execute();
        $stmt->bind_result($hash_pass);
        $stmt->fetch();
        $stmt->close();
    
        if ($hash_pass !== null) {
            if (password_verify($cur_password, $hash_pass)) {
                $new_pass = $_POST['newpassword'];
                $hash_new_pass = password_hash($new_pass, PASSWORD_DEFAULT);
    
                // Use prepared statement for the update query
                $query = "UPDATE `tb_admin_info` SET `admin_password`=? WHERE 1";
                $update_stmt = $conn->prepare($query);
                $update_stmt->bind_param("s", $hash_new_pass);
                $update_stmt->execute();
                $update_stmt->close();
    
                $_SESSION['savesuccess'] = true;
            } else {
                $_SESSION['show_modal'] = true;
            }
        } else {
            $_SESSION['show_modal'] = true;
        }
    }

    $result = mysqli_query($conn, "SELECT * FROM tb_admin_info"); // WHERE admin_id ='$id'"
    $rows = mysqli_fetch_assoc($result);

    $rowData = array();

    if ($rows) {
        $row = $rows;
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

    <script src="ad_sidebar.js"></script>

    <link rel="stylesheet" type="text/css" href="prof_2.css">

    <title>Admin | Profile</title>
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
                                <a class="nav-link side-active" href="ad_profile.php">Profile</a>
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
                            <a class="nav-link" href="ad_home.php">
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

        <div class="container profile-section">
            <div class="col-lg-10 float-end">
                <div class="ad-profile shadow-sm ">
                    <div class="user mb-5 text-center d-flex justify-content-center">
                        <div class="details ">
                            <p class="fa-solid fa-user icon mt-4"></p>
                            <div class="horizontal-line"><span class="line"></span></div>
                            <div class="row">
                                <div class="col-2 text-start">
                                    <p>Name:</p>
                                    <p>Username:</p>
                                </div>
                                <div class="col-10 text-end">
                                    <p><?php echo $rows['admin_name']; ?></p>
                                    <p><?php echo $rows['admin_username']; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row text-center">
                        <div class="col buttons my-4"> 
                            <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#editBackdrop">Edit Profile</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="editBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Profile</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" method="POST" class="needs-validation" novalidate>
                    <div class="modal-body">
                        
                            <label for="name" class="form-label">Name <span class="required-asterisk">*</span></label><br>
                            <input class="form-control pass my-1" type="text" name="name" value="<?php echo $row['admin_name'];?>"> <br>
                            <div class="invalid-feedback">Please fill up this field.</div>
                            <label for="username" class="form-label">Username <span class="required-asterisk">*</span></label> <br>
                            <input class="form-control pass my-1" type="text" name="username" value="<?php echo $row['admin_username'];?>">
                            <div class="invalid-feedback">Please fill up this field.</div>

                            <div class="text-end my-3" >
                                <a class="admin-btn" data-bs-target="#change" data-bs-toggle="modal">Change password</a>
                            </div> 
                    </div>
                    <div class="modal-footer">
                    <div class="col-4 text-end"><button type="submit" class="btn btn-primary" name="save">Save</button></div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>	
    <!-- Modal -->
    <div class="modal fade" id="change" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Change Password</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" method="POST" class="needs-validation" novalidate>
                    <div class="modal-body">
                    
                        <label for="curpassword" class="form-label">Current password <span class="required-asterisk">*</span></label>
                            <input type="password" class="form-control my-1 mb-3" id="myInput" name="curpassword" required>
                            <div class="invalid-feedback">
                                Incorrect password.
                            </div>
                            <label for="newpassword" class="form-label">New password <span class="required-asterisk">*</span></label>
                        <input type="password" class="form-control my-1" id="mynewInput" name="newpassword" required>
                        <div class="invalid-feedback">
                            Incorrect password.
                        </div>
                        <div class="my-1 mb-3">
                            <input type="checkbox" onclick="myFunction()">Show Password
                        </div>
                    
                    </div>
                    <div class="modal-footer">
                    <div class="col-4 text-end"><button type="submit" class="btn btn-primary" name="save-pass">Save</button></div>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            function myFunction() {
                var x = document.getElementById("myInput");
                var y = document.getElementById("mynewInput");
                if (x.type === "password") {
                    x.type = "text";
                } else {
                    x.type = "password";
                }
                if (y.type === "password") {
                    y.type = "text";
                } else {
                    y.type = "password";
                }
            }
        </script>
    
</body>
</html>