<?php
    session_start();

    include "../../connection.php";
    $currentDate = date("Y-m-d");

    $latestrows = mysqli_query($conn, "SELECT * FROM tb_event_details WHERE evt_date >= '$currentDate' ORDER BY evt_date DESC");
    $previousrows = mysqli_query($conn, "SELECT * FROM tb_event_details WHERE evt_date < '$currentDate' ORDER BY evt_date DESC");

    $firstEvtId;
    $selectedEvtId;
    $evtid ="";

    if(isset($_SESSION['selectedEvtId'])){
        $selectedEvtId = $_SESSION['selectedEvtId'];
        $selectedrow = mysqli_query($conn, "SELECT * FROM tb_event_details where evt_id = '$selectedEvtId'");
    
        if ($selectedrow) {
            $row = mysqli_fetch_assoc($selectedrow);

            if ($row) {
                $evtid = $row['evt_id'];
                $evtname = $row['evt_name'];
                $evtdescript = $row['evt_description'];
                $evtlocation = $row['evt_location'];
                $evtlatitude = $row['evt_latitude'];
                $evtlongitude = $row['evt_longitude'];
                $evtdate = $row['evt_date'];
                $evtimage = $row['evt_image'];
                $evtinstruction = $row['evt_instruction'];

            } else {
                echo "No matching rows found";
            }
        } else {
            echo "Error executing query: " . mysqli_error($conn);
        }

    }else{
        $rows = mysqli_query($conn, "SELECT * FROM tb_event_details ORDER BY evt_date DESC");
        if ($row = mysqli_fetch_assoc($rows)) {
            $firstEvtId = $row['evt_id'];
            $selectedEvtId = $firstEvtId;
    
            $selectedrow = mysqli_query($conn, "SELECT * FROM tb_event_details where evt_id = '$selectedEvtId'");
    
            if ($selectedrow != null) {
                $row = mysqli_fetch_assoc($selectedrow);
    
                if ($row) {
                    $evtid = $row['evt_id'];
                    $evtname = $row['evt_name'];
                    $evtdescript = $row['evt_description'];
                    $evtlocation = $row['evt_location'];
                    $evtlatitude = $row['evt_latitude'];
                    $evtlongitude = $row['evt_longitude'];
                    $evtdate = $row['evt_date'];
                    $evtimage = $row['evt_image'];
                    $evtinstruction = $row['evt_instruction'];
    
                } else {
    
                    echo "No Events for now!";
                }
            } else {
    
                echo "Error executing query: " . mysqli_error($conn);
            }
    
        } else {
    
            echo "No Events for now!";
        }

    }

    if(isset($_POST['selectedevt-btn'])){
        $selectedEvtId = $_POST['selectedevt'];

        $_SESSION['selectedEvtId'] = $selectedEvtId;

        // Redirect to the same page to avoid form resubmission on page refresh
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit;

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
    

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/99c24c4877.js" crossorigin="anonymous"></script>
    <link rel="icon" href="../../images/logo.png">

    <link rel="stylesheet" type="text/css" href="../../css/evt_u.css">
    <title>Guest User | Events</title>
    <style>
        @media (max-width: 767px){
    .modal-dialog{
        max-width: 100% !important;
    }}
    </style>

</head>
<body>
    <nav class="navbar navbar-expand-lg bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="../../index.php">EasyKay</a>
            
            <button class="navbar-icon fa-solid fa-bars" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item mx-2">
                        <a class="nav-link" href="../home/guest_home.php">Home</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link active" href="guest_event.php">Events</a>
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
    </nav>
    
    <?php 
        include "../../info/faqs.php";
        include "../../info/about.php";
        include "../../info/terms.php";
        include "../../info/data.php";
    ?>

    <div class="container">
        <div class="row row-event">
            <div class="col-12 col-lg-9 selected">
                <div class="d-flex flex-column">
                <?php if ($evtid != null) {?>
                    <div class="col-12">
                        <div class="selected-event-img my-4">
                            <img class="selected-img" src="../../images/event_img/<?php echo $evtimage ?>" alt="">
                        </div>

                        <div class="evt-name mx-2 mb-4">
                            <h3><b><?php echo $evtname; ?></b></h3>
                        </div>

                        <div class="evt-details mx-2 ">
                            <p class="description"><?php echo $evtdescript ?></p>
                            <p class="description"><span class="fa-regular fa-calendar me-4"></span><?php echo $evtdate; ?></p>
                            <p class="description"><span class="fa-solid fa-location-dot me-4"></span><?php echo  $evtlocation; ?></p>
                            <p class="description"><?php echo  $evtinstruction; ?></p>
                        </div>

                        <div class="mt-5 mb-3">
                            <form class="col-12"  method="GET" action="../home/guest_home.php">
                                <input type="hidden" name="view" value="<?php echo $evtid ?>">
                                <input type="hidden" name="latitude" value="<?php echo $evtlatitude ?>">
                                <input type="hidden" name="longitude" value="<?php echo $evtlongitude ?>">
                                <button class="btn btn-primary" type="submit" name="show-btn">Show Route</button>
                            </form>
                        </div>
                    </div>
                    <?php } else{ 
                        echo '<div class="col-12">
                        No events for now.
                    </div>';
                    }?>
                    <div class="row my-5">
                    <h5 class="py-1 mb-3"><b>Previous Events</b></h5>
                        <?php foreach($previousrows as $row) : ?>
                            <div class="col-12 col-md-6 col-lg-3 prev">
                                <div class="item">
                                    <div class="event-img shadow-sm">
                                        <img class="img" src="../../images/event_img/<?php echo $row["evt_image"]; ?>" alt="">
                                    </div>

                                    <?php
                                        $eventTitle = $row["evt_name"]; 
                                        $truncatedTitle = truncateText($eventTitle, 40);
                                    ?>
                                    <form action="" method="POST">
                                        <div class="name my-2">
                                            <input type="hidden" name="selectedevt" value="<?php echo $row["evt_id"]; ?>">
                                            <button type="submit" class="btn-event" name="selectedevt-btn"><h6 class="event-title"><?php echo $truncatedTitle; ?></h6></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>


                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3 list">
                <h5 class="py-3"><b>Latest Events</b></h5>
                <?php foreach($latestrows as $row) : ?>
                    <div class="col-12">
                        <div class="item">
                            <div class="event-img shadow-sm">
                                <img class="img" src="../../images/event_img/<?php echo $row["evt_image"]; ?>" alt="">
                            </div>

                            <?php
                                $eventTitle = $row["evt_name"]; 
                                $truncatedTitle = truncateText($eventTitle, 40);
                            ?>
                            <form action="" method="POST">
                                <div class="name my-2">
                                    <input type="hidden" name="selectedevt" value="<?php echo $row["evt_id"]; ?>">
                                    <button type="submit" class="btn-event" name="selectedevt-btn"><h6 class="event-title"><?php echo $truncatedTitle; ?></h6></button>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
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