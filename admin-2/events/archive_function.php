<?php



if(isset($_POST['archive-event'])){
    if($_SESSION['arcId'] != ""){
        $eId = $_SESSION['arcId'];
    $arc_ID = $_SESSION['arcId'];
    $arcQuery = "SELECT * FROM tb_event_details WHERE evt_id = '$arc_ID'";
    $arcrows = mysqli_query($conn, $arcQuery);
    $row = mysqli_fetch_row($arcrows);

    $rowData = array();

    if ($row) {
        $rowData = $row;
    }

    $fId = $rowData[0];
    $name = htmlspecialchars($rowData[1]);
    $description = htmlspecialchars($rowData[2]);
    $location = htmlspecialchars( $rowData[3]);
    $date = $rowData[4];
    $image = $rowData[5];
    $instruction = htmlspecialchars($rowData[6]);
    $lat = $rowData[7];
    $lng = $rowData[8];

    $query = "DELETE FROM `tb_event_details` WHERE `evt_id` = '$fId'";
    $res = mysqli_query($conn, $query);

    if($res) {
        $year = date('Y');

        $queryid = "SELECT arc_id FROM tb_archive_event ORDER BY arc_id DESC LIMIT 1";
        $result = mysqli_query($conn, $queryid);
        $initialid = "arc-" . $year . "-";
                
        if ($row = mysqli_fetch_assoc($result)) {      
            $lastID = $row['arc_id'];
            $numericPart = (int)substr($lastID, -6);         
            $numericPart++;
            $arc_id = $initialid . str_pad($numericPart, 6, '0', STR_PAD_LEFT);
        }
        else {
            $arc_id = $initialid . '000001';
        }

        $description = mysqli_real_escape_string($conn, $description);
        $arcquery = "INSERT INTO `tb_archive_event`(`arc_id`, `arc_evt_id`, `arc_evt_name`, `arc_evt_description`, `arc_evt_location`, `arc_evt_date`, `arc_evt_image`, `arc_evt_instruction`, `arc_evt_latitude`, `arc_evt_longitude`) 
        VALUES ('$arc_id','$fId','$name','$description','$location',' $date','$image','$instruction','$lat','$lng')";

        $arcres = mysqli_query($conn, $arcquery);
        
        if ($arcres) {
            $message = "You archived ". $name ." Event ."; 
            activityLog($message, $arc_id, $conn);
            $_SESSION['arc_success'] = true;
        }
        
    }
    header("Location: ".$_SERVER['PHP_SELF']);
    exit; // Terminate script execution
}
}
?>