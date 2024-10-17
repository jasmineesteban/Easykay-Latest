<?php
    session_start();

    include "../../connection.php";
    include "../../login/userid.php";

    $_SESSION['viewId'] = "";

    if (isset($_POST['view-btn'])) {

        $_SESSION['viewId'] = $_POST['view'];
        $view_ID =  $_SESSION['viewId'];

        if ($_SESSION['viewId'] != null) {
            $viewQuery = "SELECT * FROM `tb_explore_natural_manmade` WHERE natural_id = '$view_ID '";
            $viewrows = mysqli_query($conn, $viewQuery);
            $row = mysqli_fetch_row($viewrows);

            $rowData = array();

            if ($row) {
                $rowData = $row;
            }
            $_SESSION['view_modal'] = true;
        }
    }

    if(isset($_POST["search-btn"])){
        $search = $_POST['search'];

        $query = "SELECT * FROM ttb_explore_natural_manmade WHERE natural_name LIKE '%$search%' ORDER BY natural_name ASC";
    }
    else{
        $query = "SELECT * FROM tb_explore_natural_manmade ORDER BY natural_name ASC";
    }

    $exprows = mysqli_query($conn, $query);

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

    <link rel="stylesheet" type="text/css" href="../../css/exp_u.css">
    <title>Explore | Cultural/Religious Attractions</title>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="./../login/logout.php">EasyKay</a>
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
                        <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Explore
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="resorts.php">Resorts</a></li>
                            <li><a class="dropdown-item" href="recreational.php">Recreational Facilities</a></li>
                            <li><a class="dropdown-item" href="hotel_lodge.php">Hotel & Lodge</a></li>
                            <li><a class="dropdown-item sub-active" href="natural_manmade.php">Natural/Man-made Attractions</a></li>
                            <li><a class="dropdown-item" href="cultural_religious.php">Cultural/Religious Attractions</a></li>
                            <li><a class="dropdown-item" href="restaurants.php">Restaurants</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Profile
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="../profile/profile.php">Profile Info</a></li>
                            <li><a class="dropdown-item" href="../profile/saved_travels.php">Saved Travels</a></li>
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

    <div class="container ">
        <div class="explore-row">
            <div class="row mb-4">
                <div class="col-12 col-sm-6 col-lg-6 explore-title">
                    <h5><b>List of Natural/Man-Made Attractions</b></h5>
                </div>
                <div class="col-12 col-sm-6 col-lg-6 search">
                    <form class="input-group" method="post">
                        <input type="text" class="form-control" placeholder="Search" name="search" aria-label="Recipient's username" aria-describedby="basic-addon2">
                        <button class="input-group-text" name="search-btn" id="search"><i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </form>
                </div>
            </div>
        
            <?php foreach($exprows as $row) : ?>
                <div class="item shadow-sm my-4">
                    <div class="row">
                        <div class="col-12 col-lg-4">
                            <div class="explore-img">
                                <img class="img" src="../../images/natural_manmade_img/<?php echo $row["natural_image"]; ?>" alt="">
                            </div>
                        </div>
                        <div class="col-12 col-lg-8">
                            <div class="content m-4">
                            <?php
                            $title = $row["natural_name"]; 

                            $desc = $row["natural_description"]; 
                            $truncatedDesc = truncateText($desc, 250);
                            ?>

                            <div class="name my-2 mb-3"><h5 class="title"><?php echo $title; ?></h5></div>

                            <div class="d-flex">
                                <p class="desc"><?php echo $truncatedDesc; ?></p>
                            </div>
                            <div class="mb-5">
                                <p class="desc"><i class="fa-solid fa-location-dot me-3"></i> <?php echo $row['natural_location']; ?></p>
                            </div>
                            
                            <div class="row">
                                <div class="col-5 mt-4">
                                    <form class="frm" method="post">
                                        <input type="hidden" name="view" value="<?php echo $row["natural_id"]; ?>">
                                        <button class="btn view-more text-muted" type="submit" name="view-btn">View more<i class="fa-solid fa-angle-right"></i></button>
                                    </form>
                                </div>
                                <div class="col-7 mt-4">
                                    <form class="frm d-flex justify-content-end" method="GET" action="../home/reg_home.php">
                                        <input type="hidden" name="route" value="<?php echo $row["natural_id"]; ?>">
                                        <input type="hidden" name="latitude" value="<?php echo $row["natural_latitude"]; ?>">
                                        <input type="hidden" name="longitude" value="<?php echo $row["natural_longitude"]; ?>">
                                        <button class="btn btn-primary show" type="submit" name="route-btn">Show Route</button>
                                    </form>
                                </div>
                            </div>
                            </div>
                        </div>
                            
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!--  edit  -->

    <?php if(isset($_SESSION['view_modal']) && $_SESSION['view_modal']): ?>
        <script src="view.js"></script>
        <?php unset($_SESSION['view_modal']); ?>
    <?php endif; ?>

    <div class="modal fade" id="viewmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="viewmodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="viewmodalLabel"><?php echo $rowData[1]; ?></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="explore-img">
                        <img class="img" src="../../images/natural_manmade_img/<?php echo $rowData[5]; ?>" alt="">
                    </div>
                    <div class="mx-1">
                        <h5 class="title my-3"><?php echo $rowData[1]; ?></h5>
                        <p class="desc my-3"><?php echo $rowData[2]; ?></p>
                        <p class="desc my-3"><i class="fa-solid fa-location-dot me-3"></i> <?php echo $rowData[3]; ?></p>
                        <p class="desc my-3"><i class="fa-solid fa-phone me-3"></i> <?php echo $rowData[4]; ?></p>
                        <p class="desc my-3"> <?php echo $rowData[6]; ?></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <form class="" method="GET" action="../home/reg_home.php">
                        <input type="hidden" name="route" value="<?php echo $row["natural_id"]; ?>">
                        <input type="hidden" name="latitude" value="<?php echo $row["natural_latitude"]; ?>">
                        <input type="hidden" name="longitude" value="<?php echo $row["natural_longitude"]; ?>">
                        <button class="btn btn-primary show" type="submit" name="route-btn">Show Route</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>
<?php
  function truncateText($text, $limit){ // It removes the characters that exceed the limit(45) and adds an ellipsis.
    if (strlen($text) > $limit) {
        $text = substr($text, 0, $limit) . '...'; 
    }
    return $text;
  }
?>