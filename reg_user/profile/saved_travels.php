<?php
    session_start();

    include "../../connection.php";
    include "../../login/userid.php";

    $userid = $_SESSION['setId'];

    $stmt = $conn->prepare("SELECT * FROM tb_user_profile WHERE user_id = ?");
    $stmt->bind_param("s", $userid);
    $stmt->execute();
    $result = $stmt->get_result();

    $username = "";
    $email = "";

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $username = $row['user_name'];
            $email = $row['user_email'];
        }
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
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/99c24c4877.js" crossorigin="anonymous"></script>
    <link rel="icon" href="../../images/logo.png">

    <link rel="stylesheet" type="text/css" href="prof_1.css">
    <title>Travel Plan</title>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="../../login/logout.php">EasyKay</a>
            <button class="navbar-icon fa-solid fa-bars" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item mx-2">
                        <a class="nav-link" href="../home/reg_home.php">Home</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link" href="../event/reg_event.php">Events</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Explore
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="../explore/resorts.php">Resorts</a></li>
                            <li><a class="dropdown-item" href="../explore/recreational.php">Recreational Facilities</a></li>
                            <li><a class="dropdown-item" href="../explore/hotel_lodge.php">Hotel & Lodge</a></li>
                            <li><a class="dropdown-item" href="../explore/natural_manmade.php">Natural/Man-made Attractions</a></li>
                            <li><a class="dropdown-item" href="../explore/cultural_religious.php">Cultural/Religious Attractions</a></li>
                            <li><a class="dropdown-item" href="../explore/restaurants.php">Restaurants</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Profile
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="profile.php">Profile Info</a></li>
                            <li><a class="dropdown-item sub-active" href="saved_travels.php">Saved Travels</a></li>
                            <li><a class="dropdown-item" href="../../login/logout.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class= "dropdown dropdown-info mx-2">
                <a class="dropdown-icon fas fa-info-circle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"></a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#faqsModal">FAQs</a></li>
                    <li><a type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#aboutModal">About Us</a></li>
                    <li><a type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#termsModal">Terms and conditions</a></li>
                    <li><a type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#dataModal">Data Privacy</a></li>
                </ul>
            </div>
            </div>
        </div>
    </nav>

    <?php 
        include "../../info/faqs.php";
        include "../../info/about.php";
        include "../../info/terms.php";
        include "../../info/data.php";
    ?>

<div class="container profile-section">
    <div class="row user-profile p-5 shadow-sm">
        <div class="col-lg-10 col-12 mx-auto">
            <div class="text-center"> <!-- Center the content -->
                <div class="px-3">
                    <p class="fa-solid fa-user icon mt-4"></p>
                    <div class="horizontal-line"><span class="line"></span></div>
                </div>
                <div class="row text-lg-center">
                    <div class="col-12 col-md-6 col-lg-6"><p>Name:</p></div>
                    <div class="col-12 col-md-6 col-lg-6"><p><?php echo $username; ?></p></div>
                </div>
                <div class="row text-lg-center">
                    <div class="col-12 col-md-6 col-lg-6"><p>Username:</p></div>
                    <div class="col-12 col-md-6 col-lg-6"><p><?php echo $email; ?></p></div>
                </div>
                <br>
                <div class="row text-center">
                    <div class="col-12 col-md-6 col-lg-6 buttons my-2"> 
                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#deleteBackdrop">Delete account permanently</button>
                    </div>
                </div>
                <br> 
            </div>
        </div>
    </div>
</div>
    <div class="modal fade" id="deleteBackdrop" data-bs-backdrop="static" tabindex="-1" aria-labelledby="deleteBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteBackdropLabel">Archive FAQs</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div> 
                <form action="" method="POST">
                    <div class="modal-body">
                        <div class="form-group m-2">
                            <div class="col-sm-12">
                                <p class="text-center fs-5">Are you sure you want to delete your account permanently? </p>
                            </div>
                        </div>
                    <div class="modal-footer">
                        <div class="col-4 mx-4">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">No</button>
                            <button type="submit" name="delete-permanently" class="btn btn-primary">Yes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
</body>
</html>


