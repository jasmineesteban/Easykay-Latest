<?php
    session_start();

    include "../../connection.php";
    include "../activity_log.php";
    include "add_function.php";
    include "../../login/idset.php";
    include "edit_function.php";
    include "archive_function.php";
    include "unarchive_function.php";
    
    $_SESSION['editId'] = "";
    $_SESSION['arcId'] = "";
    
    if(isset($_POST['archive-btn'])){
        $_SESSION['arcId'] = $_POST['archive'];
        $arc_ID = $_SESSION['arcId'];
        if ($_SESSION['arcId'] != null) {
            $arcQuery = "SELECT * FROM tb_event_details WHERE evt_id = '$arc_ID'";
            $arcrows = mysqli_query($conn, $arcQuery);
            $row = mysqli_fetch_row($arcrows);

            $rowData = array();

            if ($row) {
                $rowData = $row;
            }
            $_SESSION['archive_modal'] = true;
        }
    }

    if (isset($_POST['edit-btn'])) {

        $_SESSION['editId'] = $_POST['edit'];
        $edit_ID = $_SESSION['editId'];

        if ($_SESSION['editId'] != null) {
            $editQuery = "SELECT * FROM `tb_event_details` WHERE evt_id = '$edit_ID'";
            $editrows = mysqli_query($conn, $editQuery);
            $row = mysqli_fetch_row($editrows);

            $rowData = array();

            if ($row) {
                $rowData = $row;
            }
            $_SESSION['edit_modal'] = true;
        }
    }

    if(isset($_POST["search-btn"])){
        $search = $_POST['search'];

        $query = "SELECT evt_id, evt_image, evt_name FROM tb_event_details WHERE evt_name LIKE '%$search%' ORDER BY evt_date DESC";
    }
    else{
        $query = "SELECT evt_id, evt_image, evt_name FROM tb_event_details ORDER BY evt_date DESC";
    }

    $rows = mysqli_query($conn, $query);
    $listArcQuery = "SELECT * FROM `tb_archive_event`";
    $arcRows = mysqli_query($conn, $listArcQuery);
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

    <link rel="stylesheet" type="text/css" href="ad_events_2.css">

    <title>Admin | Events</title>
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
                            <a class="nav-link side-active" href="ad_event.php">
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
                                    <a href="../fares/jeep.php" class="nav-link">Jeepney</a>
                                </li>
                                <li class="nav-item">
                                    <a href="../fares/bus.php" class="nav-link">Bus</a>
                                </li>
                                <li class="nav-item">
                                    <a href="../fares/tricycle.php" class="nav-link">Tricycle</a>
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
                <div class="evt">
                    <div class="row">
                        <div class="col-10">
                            <h3 class="title-attraction mb-2">Events</h3>
                        </div>
                        <div class="col-2 text-center">
                            <button type="button" class="btn archive" data-bs-toggle="modal" data-bs-target="#Archives">
                                <i class="fa-solid fa-box-archive arc mx-2"></i><span class="arc-text">Archive</span>
                            </button>
                        </div>
                    </div>
                    <div class="add-search shadow-sm d-flex flex-row">
                        <form class="input-group" method="post">
                            <input type="text" class="form-control" placeholder="Search" name="search" aria-label="Recipient's username" aria-describedby="basic-addon2">
                            <button class="input-group-text" name="search-btn" id="search"><i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </form>
                        <form class="frm-add-event" method="post" action="add_events.php">
                            <button type="button" class="add-events" data-bs-toggle="modal" data-bs-target="#addEvent">
                                <i class="fa-solid fa-plus" id="add-icon" name='btn'></i><span class="add-text">Add</span>
                            </button>
                        </form>
                    </div>
                    
                    <div class="list shadow-sm">
                        <div class="row">
                        <?php foreach($rows as $row) : ?>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="item shadow">
                                <div class="event-img">
                                    <img class="evt-img" src="../../images/event_img/<?php echo $row["evt_image"]; ?>" alt="">
                                </div>

                                <?php
                                    $eventTitle = $row["evt_name"]; 
                                    $truncatedTitle = truncateText($eventTitle, 40);
                                ?>

                                <div class="name my-2"><h5 class="event-title text-center"><?php echo $truncatedTitle; ?></h5></div>

                                <div class="d-flex justify-content-center">
                                    <div class="actions my-2">
                                        <form action="" method="post" class="frm-btn">
                                            <input type="hidden" name="edit" value="<?php echo $row["evt_id"]; ?>">
                                            <button type="submit" class="btn mx-1" name="edit-btn"><i class="fa-solid fa-pen-to-square"></i></button>
                                        </form>
                                        <form action="" method="post" class="frm-btn">
                                            <input type="hidden" name="archive" value="<?php echo $row["evt_id"]; ?>">
                                            <button type="submit" class="btn mx-1" name="archive-btn"><i class="fa-solid fa-box-archive"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                        </div>
                    </div>
                
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addEvent" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addEventLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addEventLabel">Add New</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div> 
                <form action="" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group ">
                            <label for="evt_name" class="col col-form-label">Event Name <span class="required-asterisk">*</span></label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="evt_name" name="evt_name" required>
                                <div class="invalid-feedback">Please fill up this field.</div>
                            </div>
                        </div>
                        <div class="form-group my-2">
                            <label for="evt_description" class="col col-form-label">Event Description <span class="required-asterisk">*</span></label>
                            <div class="col-sm-12">
                                <textarea class="form-control" id="evt_description" name="evt_description" required ></textarea>
                                <div class="invalid-feedback">Please fill up this field.</div>
                            </div>
                        </div>
                        <div class="form-group my-2">
                            <label for="evt_location" class="colcol-form-label my-1">Event Location <span class="required-asterisk">*</span></label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="evt_location" name="evt_location" required>
                                <div class="invalid-feedback">Please fill up this field.</div>
                            </div>
                    
                            <div class="d-flex justify-content-between flex-column mt-2">
                                <div class="form-group row col-sm-12 my-2">
                                    <label for="latitude" class="col-sm-4 col-form-label">Latitude <span class="required-asterisk">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="latitude" name="latitude" required pattern="[0-9]+(\.[0-9]+)?">
                                        <div class="invalid-feedback">Please enter a valid latitude.</div>
                                    </div> 
                                </div>
                                <div class="form-group row col-sm-12 my-2">
                                    <label for="longitude" class="col-sm-4 col-form-label">Longitude<span class="required-asterisk">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="longitude" name="longitude" required pattern="[0-9]+(\.[0-9]+)?">
                                        <div class="invalid-feedback">Please enter a valid longitude.</div>
                                    </div> 
                                </div>
                            </div>
                        </div>
                        <div class="form-group d-flex my-3">
                            <label for="evt_date" class="col-sm-4 col-form-label">Event Date <span class="required-asterisk">*</span></label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" id="evt_date" name="evt_date" min="<?php echo date('Y-m-d'); ?>">
                            </div>
                        </div>
                        <div class="form-group d-flex my-2">
                            <label for="image" class="col-sm-4 col-form-label">Upload Image<span class="required-asterisk">*</span></label>
                            <div class="col-sm-8">
                                <input type="file" class="form-control" name="image" id="image" accept=".jpg, .jpeg, .png" required>
                                <div class="invalid-feedback">Please upload an image.</div>
                            </div>
                        </div>
                        <div class="form-group my-2">
                            <label for="evt_instruction" class="col col-form-label">Instructions</label>
                            <div class="col-sm-12">
                                <textarea class="form-control" id="evt_instruction" name="evt_instruction"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col-4 mx-4">
                            <button type="submit" name="add-event" class="btn btn-primary">Add</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <script src="validation.js"></script>
    </div>

    <?php if(isset($_SESSION['add_success']) && $_SESSION['add_success']): ?>
        <script src="message.js"></script>
        <?php unset($_SESSION['add_success']); ?>
    <?php endif; ?>

    <!-- Update success modal -->
    <div class="modal fade" id="addsuccessmessage" tabindex="-1" aria-labelledby="addsuccessmessageLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content success-message">
                <div class="modal-body d-flex justify-content-between">
                    <span>Event successfully added!</span>
                    <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

            </div>
        </div>
    </div>

    <!--  edit  -->

    <?php if(isset($_SESSION['edit_modal']) && $_SESSION['edit_modal']): ?>
        <script src="show.js"></script>
        <?php unset($_SESSION['edit_modal']); ?>
    <?php endif; ?>

    <!-- Edit modal -->
    <div class="modal fade" id="editmodal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="editmodalLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addExploreLabel">Edit Event</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div> 
                <form action="" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group ">
                            <label for="evt_name" class="col col-form-label">Event Name <span class="required-asterisk">*</span></label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="evt_name" name="evt_name" value="<?php echo $rowData['1']?>" required>
                                <div class="invalid-feedback">Please fill up this field.</div>
                            </div>
                        </div>
                        <div class="form-group my-2">
                            <label for="evt_description" class="col col-form-label">Event Description <span class="required-asterisk">*</span></label>
                            <div class="col-sm-12">
                                <textarea class="form-control" id="evt_description" name="evt_description" required ><?php echo $rowData['2']?></textarea>
                                <div class="invalid-feedback">Please fill up this field.</div>
                            </div>
                        </div>
                        <div class="form-group my-2">
                            <label for="evt_location" class="colcol-form-label my-1">Event Location <span class="required-asterisk">*</span></label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="evt_location" name="evt_location" value="<?php echo $rowData['3']?>" required>
                                <div class="invalid-feedback">Please fill up this field.</div>
                            </div>
                    
                            <div class="d-flex justify-content-between flex-column mt-2">
                                <div class="form-group row col-sm-12 my-2">
                                    <label for="latitude" class="col-sm-4 col-form-label">Latitude <span class="required-asterisk">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="latitude" name="latitude" value="<?php echo $rowData['7']?>" required pattern="[0-9]+(\.[0-9]+)?">
                                        <div class="invalid-feedback">Please enter a valid latitude.</div>
                                    </div> 
                                </div>
                                <div class="form-group row col-sm-12 my-2">
                                    <label for="longitude" class="col-sm-4 col-form-label">Longitude<span class="required-asterisk">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="longitude" name="longitude" value="<?php echo $rowData['8']?>" required pattern="[0-9]+(\.[0-9]+)?">
                                        <div class="invalid-feedback">Please enter a valid longitude.</div>
                                    </div> 
                                </div>
                            </div>
                        </div>
                        <div class="form-group d-flex my-3">
                            <label for="evt_date" class="col-sm-4 col-form-label">Event Date <span class="required-asterisk">*</span></label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" id="evt_date" name="evt_date" value="<?php echo $rowData['4']?>" min="<?php echo date('Y-m-d'); ?>">
                            </div>
                        </div>
                        <div class="form-group d-flex my-2">
                            <label for="image" class="col-sm-4 col-form-label">Upload Image</label>
                            <div class="col-sm-8">
                                <input type="file" class="form-control" name="image" id="image" accept=".jpg, .jpeg, .png">
                                <div class="invalid-feedback">Please upload an image.</div>
                            </div>
                        </div>
                        <div class="form-group my-2">
                            <label for="evt_instruction" class="col col-form-label">Instructions</label>
                            <div class="col-sm-12">
                                <textarea class="form-control" id="evt_instruction" name="evt_instruction"><?php echo $rowData['6']?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col-4 mx-4">
                            <button type="submit" name="edit-event" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="validation.js"></script>
    </div>
    <?php if(isset($_SESSION['edit_success']) && $_SESSION['edit_success']): ?>
        <script src="edit_success_msg.js"></script>
        <?php unset($_SESSION['edit_success']); ?>
    <?php endif; ?>

    <!-- Update success modal -->
    <div class="modal fade" id="editsuccessmessage" tabindex="-1" aria-labelledby="editsuccessmessageLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content success-message">
                <div class="modal-body d-flex justify-content-between">
                    <span>Event successfully updated!</span>
                    <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

            </div>
        </div>
    </div>

    <!--  archive  -->

    <?php if(isset($_SESSION['archive_modal']) && $_SESSION['archive_modal']): ?>
        <script src="show_arc.js"></script>
        <?php unset($_SESSION['archive_modal']); ?>
    <?php endif; ?>

    <!-- archive modal -->
    <div class="modal fade" id="arcmodal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="arcmodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addExploreLabel">Archive FAQs</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div> 
                <form action="" method="POST">
                    <div class="modal-body">
                        <div class="form-group m-2">
                            <div class="col-sm-12">
                                <p class="text-center fs-5">You're about to archive the <b>"<?php echo $rowData[1];?>"</b> Event. </p>
                                <br>
                                <p class="opacity-75 fw-light text-muted" >*Archives will automatically be deleted after 30 days.</p>
                            </div>
                        </div>
                    <div class="modal-footer">
                        <div class="col-4 mx-4">
                            <button type="submit" name="archive-event" class="btn btn-primary">Yes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>

    <?php if(isset($_SESSION['arc_success']) && $_SESSION['arc_success']): ?>
        <script src="arc_message.js"></script>
        <?php unset($_SESSION['arc_success']); ?>
    <?php endif; ?>

    <!-- archive success modal -->
    <div class="modal fade" id="arcsuccessmessage" tabindex="-1" aria-labelledby="arcsuccessmessageLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content success-message">
                <div class="modal-body d-flex justify-content-between">
                    <span>Event successfully archived!</span>
                    <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

            </div>
        </div>
    </div>
        
     <!-- LIST OF FAQS ARCVIVES MODAL -->

     <div class="modal fade" id="Archives" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="ArchivesLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="Archives">Archives</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php foreach($arcRows as $row) : ?>
                        <div class="row shadow-sm my-3 py-2 mx-1">
                            <div class="col-8">
                                <span class=""><?php echo $row['arc_evt_name'];?></span>
                            </div>
                            <div class="col-4 text-center">
                                <form action="" method="post" class="frm-btn">
                                    <input type="hidden" name="unarchive" value="<?php echo $row["arc_id"]; ?>">
                                    <button type="submit" class="btn btn-light fs-6" name="unarchive-btn"><span class="fw-light text-muted">Unarchive</span></button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="modal-footer">
                    <p class="opacity-75 fw-light text-muted" >*Archives will automatically be deleted after 30 days.</p>
                </div>
            </div>
        </div>
    </div>

    <?php if(isset($_SESSION['unarc_success']) && $_SESSION['unarc_success']): ?>
        <script src="unarc_message.js"></script>
        <?php unset($_SESSION['unarc_success']); ?>
    <?php endif; ?>

     <!-- unarchive success modal -->
     <div class="modal fade" id="unarcsuccessmessage" tabindex="-1" aria-labelledby="unarcsuccessmessageLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content success-message">
                <div class="modal-body d-flex justify-content-between">
                    <span>Event successfully unarchived!</span>
                    <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
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
