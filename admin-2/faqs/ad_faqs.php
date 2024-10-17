<?php
    session_start();
    include "../../connection.php";
    include "../activity_log.php";
    include "../../login/idset.php";

    if (isset($_POST['edit-btn'])) {

        $_SESSION['editId'] = $_POST['edit'];
        $edit_ID = $_SESSION['editId'];

        if ($_SESSION['editId'] != null) {
            $editQuery = "SELECT * FROM tb_faqs WHERE faqs_id = '$edit_ID'";
            $editrows = mysqli_query($conn, $editQuery);
            $row = mysqli_fetch_row($editrows);

            $rowData = array();

            if ($row) {
                $rowData = $row;
            }
            $_SESSION['edit_modal'] = true;
        }
    }

    if(isset($_POST['edit-faqs'])){

        $fId = $_SESSION['editId'];
        $question = $_POST['question'];
        $answer = $_POST['answer'];

        $query = "UPDATE `tb_faqs` SET `faqs_question`='$question',`faqs_answer`=' $answer' WHERE `faqs_id` = '$fId'";

        $res = mysqli_query($conn, $query);

        if($res) {
            
            $message = "You edited a FAQs.";
            activityLog($message, $fId, $conn);
            $_SESSION['edit_success'] = true;
            
        }
        header("Location: ".$_SERVER['PHP_SELF']);
            exit; // Terminate script execution
    }
    
    if(isset($_POST['archive-btn'])){
        $_SESSION['arcId'] = $_POST['archive'];
        $arc_ID = $_SESSION['arcId'];
        if ($_SESSION['arcId'] != null) {
            $arcQuery = "SELECT * FROM tb_faqs WHERE faqs_id = '$arc_ID'";
            $arcrows = mysqli_query($conn, $arcQuery);
            $row = mysqli_fetch_row($arcrows);

            $rowData = array();

            if ($row) {
                $rowData = $row;
            }
            $_SESSION['archive_modal'] = true;
        }

    }

    if(isset($_POST['archive-faqs'])){
        $arc_ID = $_SESSION['arcId'];
        $arcQuery = "SELECT * FROM tb_faqs WHERE faqs_id = '$arc_ID'";
        $arcrows = mysqli_query($conn, $arcQuery);
        $row = mysqli_fetch_row($arcrows);

        $rowData = array();

        if ($row) {
            $rowData = $row;
        }
        
        $fId = $rowData[0];
        $question = $rowData[1];
        $answer = $rowData[2];;

        $query = "DELETE FROM `tb_faqs` WHERE `faqs_id` = '$fId'";

        $res = mysqli_query($conn, $query);

        if($res) {
            $year = date('Y');

            $queryid = "SELECT arc_id FROM tb_archive_faqs ORDER BY arc_id DESC LIMIT 1"; // it select the id that has highest value
            $result = mysqli_query($conn, $queryid);
            //10 characters log-2023-000000

            $initialid = "arc-" . $year . "-";
                    
            if ($row = mysqli_fetch_assoc($result)) { // check if there's value
                // Extract the numeric part of the last ID       
                $lastID = $row['arc_id'];
                $numericPart = (int)substr($lastID, -6);
                            
                // Increment the numeric part
                $numericPart++;
                            
                // Generate the new ID
                $arc_id = $initialid . str_pad($numericPart, 6, '0', STR_PAD_LEFT);
            }
            else {
                // If no records, start with the initial ID
                $arc_id = $initialid . '000001';
            }

            $arcquery = "INSERT INTO `tb_archive_faqs`(`arc_id`, `arc_faqs_id`, `arc_quest`, `arc_ans`)
             VALUES ('$arc_id','$fId','$question','$answer')";

            $arcres = mysqli_query($conn, $arcquery);
            
            if ($arcres) {
                $message = "You archived a FAQs.";
                activityLog($message, $arc_id, $conn);
                $_SESSION['arc_success'] = true;
                
            }
            
        }
        header("Location: ".$_SERVER['PHP_SELF']);
                exit; // Terminate script execution
    }

    if(isset($_POST['unarchive-btn'])){
        $_SESSION['unarcId'] = $_POST['unarchive'];
        $unarc_ID = $_SESSION['unarcId'];

        $query = "SELECT * FROM `tb_archive_faqs` WHERE `arc_id` = '$unarc_ID'";
        $rows = mysqli_query($conn, $query);
        $row = mysqli_fetch_row($rows);

        $rowData = array();

        if ($row) {
            $rowData = $row;
        }

        $quest = $rowData[2];
        $ans = $rowData[3];

        if ($quest && $ans) {

            $unarcQuery = "DELETE FROM `tb_archive_faqs` WHERE `arc_id` = '$unarc_ID'";
            $unarcrows = mysqli_query($conn, $unarcQuery);
        
            if ($unarcrows) {

                $year = date('Y');

                $queryid = "SELECT faqs_id FROM tb_faqs ORDER BY faqs_id DESC LIMIT 1";
                $result = mysqli_query($conn, $queryid);
                            
                $initialid = "faqs-" . $year . "-";
                            
                if ($row = mysqli_fetch_assoc($result)) {     
                $lastID = $row['faqs_id'];
                $numericPart = (int)substr($lastID, -6);
                   
                $numericPart++;
                $faqs_id = $initialid . str_pad($numericPart, 6, '0', STR_PAD_LEFT);
                }
                else {
                    // If no records, start with the initial ID
                    $faqs_id = $initialid . '000001';
                }               
                
                $fquery = "INSERT INTO `tb_faqs`(`faqs_id`, `faqs_question`, `faqs_answer`) VALUES ('$faqs_id','$quest','$ans')";
                $fres = mysqli_query($conn, $fquery);

                if ($fres) {
                    $_SESSION['unarc_success'] = true;
                }
                
            }
            
        }
        header("Location: ".$_SERVER['PHP_SELF']);
            exit; // Terminate script execution
    }

    if(isset($_POST['add-faqs'])){

        $question = $_POST['question'];
        $answer = $_POST['answer'];

        $year = date('Y');

        $queryid = "SELECT faqs_id FROM tb_faqs ORDER BY faqs_id DESC LIMIT 1"; // it select the id that has highest value
        $result = mysqli_query($conn, $queryid);
        //10 characters log-2023-000000
                    
        $initialid = "faqs-" . $year . "-";
                    
        if ($row = mysqli_fetch_assoc($result)) { // check if there's value
        // Extract the numeric part of the last ID       
        $lastID = $row['faqs_id'];
        $numericPart = (int)substr($lastID, -6);
                    
        // Increment the numeric part
        $numericPart++;
                    
        // Generate the new ID
        $faqs_id = $initialid . str_pad($numericPart, 6, '0', STR_PAD_LEFT);
        }
        else {
            // If no records, start with the initial ID
            $faqs_id = $initialid . '000001';
        }
        $query2 = "INSERT INTO `tb_faqs`(`faqs_id`, `faqs_question`, `faqs_answer`) VALUES ('$faqs_id','$question','$answer')";
                            
        $res = mysqli_query($conn, $query2);

        if($res) {
            
            $message = "You have added a FAQs.";
            activityLog($message, $faqs_id, $conn);
            $_SESSION['add_success'] = true;
        }
        header("Location: ".$_SERVER['PHP_SELF']);
            exit; // Terminate script execution
    }

    $rows = mysqli_query($conn, "SELECT * FROM tb_faqs");
    $listArcQuery = "SELECT * FROM `tb_archive_faqs`";
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

    <link rel="stylesheet" type="text/css" href="ad_faqs_2.css">

    <title>Admin | FAQs</title>
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
                            <a class="nav-link side-active" href="ad_faqs.php">
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
                <div class="faqs">
                    <div class="row">
                        <div class="col-8">
                            <h3 class="title-faqs mb-3">FAQs</h3>
                        </div>
                        <div class="col-2">
                            <button type="button" class="btn archive" data-bs-toggle="modal" data-bs-target="#faqsArchives">
                                <i class="fa-solid fa-box-archive arc mx-2"></i><span class="arc-text">Archive</span>
                            </button>
                        </div>
                        <div class="col-2 text-center">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFaqs">
                                <i class="fa-solid fa-plus mx-2" id="add-icon" name='btn btn-primary'></i><span class="text">Add</span>
                            </button>
                        </div>
                    </div>
                    <div class="horizontal-line mb-4">
                        <span class="line"></span>
                    </div>

                    <!-- body --->
                    <?php foreach($rows as $row) : ?>
                        <div class="row mx-4 mt-3">
                            <div class="col-10">
                                <h5><b><?php echo $row['faqs_question'];?></b></h5>
                                <p class="mx-4"><?php echo $row['faqs_answer'];?></p>
                            </div>
                            <div class="col-1 text-center">
                                <form action="" method="post" class="frm-btn">
                                    <input type="hidden" name="edit" value="<?php echo $row["faqs_id"]; ?>">
                                    <button type="submit" class="btn mx-1" name="edit-btn"><i class="fa-solid fa-pen-to-square"></i></button>
                                </form>
                            </div>
                            <div class="col-1 text-center">
                                <form action="" method="post" class="frm-btn">
                                    <input type="hidden" name="archive" value="<?php echo $row["faqs_id"]; ?>">
                                    <button type="submit" class="btn mx-1" name="archive-btn"><i class="fa-solid fa-box-archive"></i></button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                
                    <!-- Modal -->
                    <?php include "faqs_modal.php";?>
                    <script src="validation.js"></script>
                
                </div>
            </div>
        </div>
    </div>

    <?php if(isset($_SESSION['add_success']) && $_SESSION['add_success']): ?>
        <script src="add_message.js"></script>
        <?php unset($_SESSION['add_success']); ?>
    <?php endif; ?>

    <!-- add success modal -->
    <div class="modal fade" id="addsuccessmessage" tabindex="-1" aria-labelledby="addsuccessmessageLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content success-message">
                <div class="modal-body d-flex justify-content-between">
                    <span>Successfuly added!!</span>
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
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addExploreLabel">Edit FAQs</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div> 
                <form action="" method="POST" class="needs-validation" novalidate>
                    <div class="modal-body">
                        <div class="form-group m-2">
                            <label for="question" class="col-sm-4 col-form-label">Question<span class="required-asterisk">*</span></label>
                            <div class="col-sm-12">
                                <textarea class="form-control" id="question" name="question" rows="3" required><?php echo $rowData[1];?></textarea>
                                <div class="invalid-feedback">Please fill up the field.</div>
                            </div>
                        </div>
                        <div class="form-group m-2">
                            <label for="answer" class="col-sm-4 col-form-label">Answer<span class="required-asterisk">*</span></label>
                            <div class="col-sm-12">
                                <textarea class="form-control" id="answer" name="answer" rows="3" required><?php echo $rowData[2];?></textarea>
                                <div class="invalid-feedback">Please fill up the field.</div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col-4 mx-4">
                            <button type="submit" name="edit-faqs" class="btn btn-primary">Save</button>
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
                    <span>Successfully updated!</span>
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
                                <p class="text-center fs-5">You're about to archive the <b>"<?php echo $rowData[1];?>"</b> FAQ. </p>
                                <br>
                                <p class="opacity-75 fw-light text-muted" >*Archives will automatically be deleted after 30 days.</p>
                            </div>
                        </div>
                    <div class="modal-footer">
                        <div class="col-4 mx-4">
                            <button type="submit" name="archive-faqs" class="btn btn-primary">Yes</button>
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

    <!-- Update success modal -->
    <div class="modal fade" id="arcsuccessmessage" tabindex="-1" aria-labelledby="arcsuccessmessageLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content success-message">
                <div class="modal-body d-flex justify-content-between">
                    <span>FAQs successfully archived!</span>
                    <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

            </div>
        </div>
    </div>

    <!-- LIST OF FAQS ARCVIVES MODAL -->

    <div class="modal fade" id="faqsArchives" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="faqsArchivesLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="faqsArchives">Archives</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php foreach($arcRows as $row) : ?>
                        <div class="row shadow-sm my-3 py-2 mx-1">
                            <div class="col-8">
                                <span class=""><?php echo $row['arc_quest'];?></span>
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
                    <span>FAQs successfully unarchived!</span>
                    <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

            </div>
        </div>
    </div>

</body>
</html>
