<?php

if(isset($_POST['unarchive-resort-btn'])){
    $_SESSION['unarcId'] = $_POST['unarchive'];
    $unarc_ID = $_SESSION['unarcId'];

    $query = "SELECT * FROM `tb_archive_resorts` WHERE `arc_id` = '$unarc_ID'";
    $rows = mysqli_query($conn, $query);
    
    list($name, $description, $location, $contact, $image, $other, $lat, $lng) = fetchArchivesData($rows);

    if ($name && $description) {

        $unarcQuery = "DELETE FROM `tb_archive_resorts` WHERE `arc_id` = '$unarc_ID'";
        $unarcrows = mysqli_query($conn, $unarcQuery);
    
        if ($unarcrows) {

            $queryid = "SELECT rest_id FROM tb_explore_resorts ORDER BY rest_id DESC LIMIT 1";
            $result = mysqli_query($conn, $queryid);
                        
            $initialid = "rest-";
                        
            if ($row = mysqli_fetch_assoc($result)) {     
            $lastID = $row['rest_id'];
            $numericPart = (int)substr($lastID, -6);
               
            $numericPart++;
            $exp_id = $initialid . str_pad($numericPart, 6, '0', STR_PAD_LEFT);
            }
            else {
                // If no records, start with the initial ID
                $exp_id = $initialid . '000001';
            }               
            
            $fquery = "INSERT INTO `tb_explore_resorts`(`rest_id`, `rest_name`, `rest_description`,
             `rest_location`, `rest_contact`, `rest_image`, `rest_other_info`, `rest_latitude`, `rest_longitude`)
            VALUES ('$exp_id','$name','$description','$location',' $contact','$image','$other','$lat','$lng')";
            $fres = mysqli_query($conn, $fquery);

            if ($fres) {
                $_SESSION['unarc_success'] = true;
            }
            
        }
        
    }
} elseif(isset($_POST['unarchive-recreational-btn'])){
    $_SESSION['unarcId'] = $_POST['unarchive'];
    $unarc_ID = $_SESSION['unarcId'];

    $query = "SELECT * FROM `tb_archive_recreational` WHERE `arc_id` = '$unarc_ID'";
    $rows = mysqli_query($conn, $query);
    
    list($name, $description, $location, $contact, $image, $other, $lat, $lng) = fetchArchivesData($rows);

    if ($name && $description) {

        $unarcQuery = "DELETE FROM `tb_archive_recreational` WHERE `arc_id` = '$unarc_ID'";
        $unarcrows = mysqli_query($conn, $unarcQuery);
    
        if ($unarcrows) {

            $queryid = "SELECT rec_id FROM tb_explore_recreational ORDER BY rec_id DESC LIMIT 1";
            $result = mysqli_query($conn, $queryid);
                        
            $initialid = "rec-";
                        
            if ($row = mysqli_fetch_assoc($result)) {     
            $lastID = $row['rec_id'];
            $numericPart = (int)substr($lastID, -6);
               
            $numericPart++;
            $exp_id = $initialid . str_pad($numericPart, 6, '0', STR_PAD_LEFT);
            }
            else {
                // If no records, start with the initial ID
                $exp_id = $initialid . '000001';
            }               
            
            $fquery = "INSERT INTO `tb_explore_recreational`(`rec_id`, `rec_name`, `rec_description`, `rec_location`,
             `rec_contact`, `rec_image`, `rec_other_info`, `rec_latitude`, `rec_longitude`)
            VALUES ('$exp_id','$name','$description','$location',' $contact','$image','$other','$lat','$lng')";
            $fres = mysqli_query($conn, $fquery);

            if ($fres) {
                $_SESSION['unarc_success'] = true;
            }
            
        }
        
    }
} elseif(isset($_POST['unarchive-hotel-btn'])){
    $_SESSION['unarcId'] = $_POST['unarchive'];
    $unarc_ID = $_SESSION['unarcId'];

    $query = "SELECT * FROM `tb_archive_hotel_lodge` WHERE `arc_id` = '$unarc_ID'";
    $rows = mysqli_query($conn, $query);
    
    list($name, $description, $location, $contact, $image, $other, $lat, $lng) = fetchArchivesData($rows);

    if ($name && $description) {

        $unarcQuery = "DELETE FROM `tb_archive_hotel_lodge` WHERE `arc_id` = '$unarc_ID'";
        $unarcrows = mysqli_query($conn, $unarcQuery);
    
        if ($unarcrows) {

            $queryid = "SELECT hotel_id FROM tb_explore_hotel_lodge ORDER BY hotel_id DESC LIMIT 1";
            $result = mysqli_query($conn, $queryid);
                        
            $initialid = "hotel-";
                        
            if ($row = mysqli_fetch_assoc($result)) {     
            $lastID = $row['hotel_id'];
            $numericPart = (int)substr($lastID, -6);
               
            $numericPart++;
            $exp_id = $initialid . str_pad($numericPart, 6, '0', STR_PAD_LEFT);
            }
            else {
                // If no records, start with the initial ID
                $exp_id = $initialid . '000001';
            }               
            
            $fquery = "INSERT INTO `tb_explore_hotel_lodge`(`hotel_id`, `hotel_name`, `hotel_description`, `hotel_location`,
             `hotel_contact`, `hotel_image`, `hotel_other_info`, `hotel_latitude`, `hotel_longitude`)
            VALUES ('$exp_id','$name','$description','$location',' $contact','$image','$other','$lat','$lng')";
            $fres = mysqli_query($conn, $fquery);

            if ($fres) {
                $_SESSION['unarc_success'] = true;
            }
            
        }
        
    }
} elseif(isset($_POST['unarchive-natural-btn'])){
    $_SESSION['unarcId'] = $_POST['unarchive'];
    $unarc_ID = $_SESSION['unarcId'];

    $query = "SELECT * FROM `tb_archive_natural_manmade` WHERE `arc_id` = '$unarc_ID'";
    $rows = mysqli_query($conn, $query);
    
    list($name, $description, $location, $contact, $image, $other, $lat, $lng) = fetchArchivesData($rows);

    if ($name && $description) {

        $unarcQuery = "DELETE FROM `tb_archive_natural_manmade` WHERE `arc_id` = '$unarc_ID'";
        $unarcrows = mysqli_query($conn, $unarcQuery);
    
        if ($unarcrows) {

            $queryid = "SELECT natural_id FROM tb_explore_natural_manmade ORDER BY natural_id DESC LIMIT 1";
            $result = mysqli_query($conn, $queryid);
                        
            $initialid = "natural-";
                        
            if ($row = mysqli_fetch_assoc($result)) {     
            $lastID = $row['natural_id'];
            $numericPart = (int)substr($lastID, -6);
               
            $numericPart++;
            $exp_id = $initialid . str_pad($numericPart, 6, '0', STR_PAD_LEFT);
            }
            else {
                // If no records, start with the initial ID
                $exp_id = $initialid . '000001';
            }               
            
            $fquery = "INSERT INTO `tb_explore_natural_manmade`(`natural_id`, `natural_name`, `natural_description`,
             `natural_location`, `natural_contact`, `natural_image`, `natural_other_info`, `natural_latitude`, `natural_longitude`)
            VALUES ('$exp_id','$name','$description','$location',' $contact','$image','$other','$lat','$lng')";
            $fres = mysqli_query($conn, $fquery);

            if ($fres) {
                $_SESSION['unarc_success'] = true;
            }
            
        }
        
    }
} elseif(isset($_POST['unarchive-cultural-btn'])){
    $_SESSION['unarcId'] = $_POST['unarchive'];
    $unarc_ID = $_SESSION['unarcId'];

    $query = "SELECT * FROM `tb_archive_cultural_religious` WHERE `arc_id` = '$unarc_ID'";
    $rows = mysqli_query($conn, $query);
    
    list($name, $description, $location, $contact, $image, $other, $lat, $lng) = fetchArchivesData($rows);

    if ($name && $description) {

        $unarcQuery = "DELETE FROM `tb_archive_cultural_religious` WHERE `arc_id` = '$unarc_ID'";
        $unarcrows = mysqli_query($conn, $unarcQuery);
    
        if ($unarcrows) {

            $queryid = "SELECT cul_id FROM tb_explore_cultural_religious ORDER BY cul_id DESC LIMIT 1";
            $result = mysqli_query($conn, $queryid);
                        
            $initialid = "cul-";
                        
            if ($row = mysqli_fetch_assoc($result)) {     
            $lastID = $row['cul_id'];
            $numericPart = (int)substr($lastID, -6);
               
            $numericPart++;
            $exp_id = $initialid . str_pad($numericPart, 6, '0', STR_PAD_LEFT);
            }
            else {
                // If no records, start with the initial ID
                $exp_id = $initialid . '000001';
            }               
            
            $fquery = "INSERT INTO `tb_explore_cultural_religious`(`cul_id`, `cul_name`, `cul_description`,
             `cul_location`, `cul_contact`, `cul_image`, `cul_other_info`, `cul_latitude`, `cul_longitude`) 
            VALUES ('$exp_id','$name','$description','$location',' $contact','$image','$other','$lat','$lng')";
            $fres = mysqli_query($conn, $fquery);

            if ($fres) {
                $_SESSION['unarc_success'] = true;
            }
            
        }
        
    }
} elseif(isset($_POST['unarchive-restaurant-btn'])){
    $_SESSION['unarcId'] = $_POST['unarchive'];
    $unarc_ID = $_SESSION['unarcId'];

    $query = "SELECT * FROM `tb_archive_restaurants` WHERE `arc_id` = '$unarc_ID'";
    $rows = mysqli_query($conn, $query);
    
    list($name, $description, $location, $contact, $image, $other, $lat, $lng) = fetchArchivesData($rows);

    if ($name && $description) {

        $unarcQuery = "DELETE FROM `tb_archive_restaurants` WHERE `arc_id` = '$unarc_ID'";
        $unarcrows = mysqli_query($conn, $unarcQuery);
    
        if ($unarcrows) {

            $queryid = "SELECT resto_id FROM tb_explore_restaurants ORDER BY resto_id DESC LIMIT 1";
            $result = mysqli_query($conn, $queryid);
                        
            $initialid = "resto-";
                        
            if ($row = mysqli_fetch_assoc($result)) {     
            $lastID = $row['resto_id'];
            $numericPart = (int)substr($lastID, -6);
               
            $numericPart++;
            $exp_id = $initialid . str_pad($numericPart, 6, '0', STR_PAD_LEFT);
            }
            else {
                // If no records, start with the initial ID
                $exp_id = $initialid . '000001';
            }               
            
            $fquery = "INSERT INTO `tb_explore_restaurants`(`resto_id`, `resto_name`, `resto_description`, `resto_location`,
             `resto_contact`, `resto_image`, `resto_other_info`, `resto_latitude`, `resto_longitude`)
            VALUES ('$exp_id','$name','$description','$location',' $contact','$image','$other','$lat','$lng')";
            $fres = mysqli_query($conn, $fquery);

            if ($fres) {
                $_SESSION['unarc_success'] = true;
            }
            
        }
        
    }
}




function fetchArchivesData($unarcrows) {
    $row = mysqli_fetch_row($unarcrows);

    $rowData = array();

    if ($row) {
        $rowData[] = htmlspecialchars($row[2]); // name
        $rowData[] = htmlspecialchars($row[3]);
        $rowData[] = htmlspecialchars($row[4]);
        $rowData[] = htmlspecialchars($row[5]);
        $rowData[] = htmlspecialchars($row[6]);
        $rowData[] = htmlspecialchars($row[7]);
        $rowData[] = htmlspecialchars($row[8]);
        $rowData[] = htmlspecialchars($row[9]);
    }

    return $rowData;
}


?>