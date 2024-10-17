<?php

if(isset($_POST['unarchive-btn'])){
    $_SESSION['unarcId'] = $_POST['unarchive'];
    $unarc_ID = $_SESSION['unarcId'];

    $query = "SELECT * FROM `tb_archive_event` WHERE `arc_id` = '$unarc_ID'";
    $rows = mysqli_query($conn, $query);
    $row = mysqli_fetch_row($rows);

    $rowData = array();

    if ($row) {
        $rowData = $row;
    }

    $name = htmlspecialchars($rowData[2]);
    $description = htmlspecialchars($rowData[3]);
    $location = htmlspecialchars( $rowData[4]);
    $date = $rowData[5];
    $image = $rowData[6];
    $instruction = htmlspecialchars($rowData[7]);
    $lat = $rowData[8];
    $lng = $rowData[9];

    if ($name && $description) {

        $unarcQuery = "DELETE FROM `tb_archive_event` WHERE `arc_id` = '$unarc_ID'";
        $unarcrows = mysqli_query($conn, $unarcQuery);
    
        if ($unarcrows) {

            $queryid = "SELECT evt_id FROM tb_event_details ORDER BY evt_id DESC LIMIT 1";
            $result = mysqli_query($conn, $queryid);
                        
            $initialid = "evt-";
                        
            if ($row = mysqli_fetch_assoc($result)) {     
            $lastID = $row['evt_id'];
            $numericPart = (int)substr($lastID, -6);
               
            $numericPart++;
            $evt_id = $initialid . str_pad($numericPart, 6, '0', STR_PAD_LEFT);
            }
            else {
                // If no records, start with the initial ID
                $evt_id = $initialid . '000001';
            }               
            
            $fquery = "INSERT INTO `tb_event_details`(`evt_id`, `evt_name`, `evt_description`, `evt_location`, `evt_date`, `evt_image`, `evt_instruction`, `evt_latitude`, `evt_longitude`) 
            VALUES ('$evt_id','$name','$description','$location',' $date','$image ','$instruction','$lat','$lng')";
            $fres = mysqli_query($conn, $fquery);

            if ($fres) {
                $_SESSION['unarc_success'] = true;
            }
            
        }
        
    }
    header("Location: ".$_SERVER['PHP_SELF']);
    exit; // Terminate script execution
}


?>