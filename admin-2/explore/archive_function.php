<?php

if(isset($_POST['archive-resort'])){
    if($_SESSION['arcId'] != ""){
        $expId = $_SESSION['arcId'];
   
    $arcQuery = "SELECT * FROM tb_explore_resorts WHERE rest_id = '$expId'";
    $arcrows = mysqli_query($conn, $arcQuery);

    list($expId, $name, $description, $location, $contact, $image, $other, $lat, $lng) = fetchData($arcrows);
    
    $query = "DELETE FROM `tb_explore_resorts` WHERE `rest_id` = '$expId'";
    $res = mysqli_query($conn, $query);

    if($res) {
        $year = date('Y');

        $queryid = "SELECT arc_id FROM tb_archive_resorts ORDER BY arc_id DESC LIMIT 1";
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
        $arcquery = "INSERT INTO `tb_archive_resorts`(`arc_id`, `arc_exp_id`, `arc_exp_name`,
         `arc_evt_description`, `arc_exp_location`, `arc_exp_contact`, `arc_exp_image`,
         `arc_exp_other`, `arc_exp_latitude`, `arc_exp_longitude`)  
        VALUES ('$arc_id','$expId','$name','$description','$location',' $contact','$image','$other','$lat','$lng')";

        $arcres = mysqli_query($conn, $arcquery);
        
        if ($arcres) {
            $message = "You archived ". $name ."."; 
            activityLog($message, $arc_id, $conn);
            $_SESSION['arc_success'] = true;
        }
        
    }}
} elseif(isset($_POST['archive-recreational'])){
    if($_SESSION['arcId'] != ""){
        $expId = $_SESSION['arcId'];
   
    $arcQuery = "SELECT * FROM tb_explore_recreational WHERE rec_id = '$expId'";
    $arcrows = mysqli_query($conn, $arcQuery);

    list($expId, $name, $description, $location, $contact, $image, $other, $lat, $lng) = fetchData($arcrows);
    
    $query = "DELETE FROM `tb_explore_recreational` WHERE `rec_id` = '$expId'";
    $res = mysqli_query($conn, $query);

    if($res) {
        $year = date('Y');

        $queryid = "SELECT arc_id FROM tb_archive_recreational ORDER BY arc_id DESC LIMIT 1";
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
        $arcquery = "INSERT INTO `tb_archive_recreational`(`arc_id`, `arc_exp_id`, `arc_exp_name`,
         `arc_evt_description`, `arc_exp_location`, `arc_exp_contact`, `arc_exp_image`,
         `arc_exp_other`, `arc_exp_latitude`, `arc_exp_longitude`)  
        VALUES ('$arc_id','$expId','$name','$description','$location',' $contact','$image','$other','$lat','$lng')";

        $arcres = mysqli_query($conn, $arcquery);
        
        if ($arcres) {
            $message = "You archived ". $name ."."; 
            activityLog($message, $arc_id, $conn);
            $_SESSION['arc_success'] = true;
        }
    }
    }
} elseif(isset($_POST['archive-hotel'])){
    if($_SESSION['arcId'] != ""){
        $expId = $_SESSION['arcId'];
   
    $arcQuery = "SELECT * FROM tb_explore_hotel_lodge WHERE hotel_id = '$expId'";
    $arcrows = mysqli_query($conn, $arcQuery);

    list($expId, $name, $description, $location, $contact, $image, $other, $lat, $lng) = fetchData($arcrows);
    
    $query = "DELETE FROM `tb_explore_hotel_lodge` WHERE `hotel_id` = '$expId'";
    $res = mysqli_query($conn, $query);

    if($res) {
        $year = date('Y');

        $queryid = "SELECT arc_id FROM tb_archive_hotel_lodge ORDER BY arc_id DESC LIMIT 1";
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
        $arcquery = "INSERT INTO `tb_archive_hotel_lodge`(`arc_id`, `arc_exp_id`, `arc_exp_name`,
         `arc_evt_description`, `arc_exp_location`, `arc_exp_contact`, `arc_exp_image`,
         `arc_exp_other`, `arc_exp_latitude`, `arc_exp_longitude`)  
        VALUES ('$arc_id','$expId','$name','$description','$location',' $contact','$image','$other','$lat','$lng')";

        $arcres = mysqli_query($conn, $arcquery);
        
        if ($arcres) {
            $message = "You archived ". $name ."."; 
            activityLog($message, $arc_id, $conn);
            $_SESSION['arc_success'] = true;
        }
    }}
} elseif(isset($_POST['archive-natural'])){
    if($_SESSION['arcId'] != ""){
        $expId = $_SESSION['arcId'];
   
    $arcQuery = "SELECT * FROM tb_explore_natural_manmade WHERE natural_id = '$expId'";
    $arcrows = mysqli_query($conn, $arcQuery);

    list($expId, $name, $description, $location, $contact, $image, $other, $lat, $lng) = fetchData($arcrows);
    
    $query = "DELETE FROM `tb_explore_natural_manmade` WHERE `natural_id` = '$expId'";
    $res = mysqli_query($conn, $query);

    if($res) {
        $year = date('Y');

        $queryid = "SELECT arc_id FROM tb_archive_natural_manmade ORDER BY arc_id DESC LIMIT 1";
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
        $arcquery = "INSERT INTO `tb_archive_natural_manmade`(`arc_id`, `arc_exp_id`, `arc_exp_name`,
         `arc_evt_description`, `arc_exp_location`, `arc_exp_contact`, `arc_exp_image`,
         `arc_exp_other`, `arc_exp_latitude`, `arc_exp_longitude`)  
        VALUES ('$arc_id','$expId','$name','$description','$location',' $contact','$image','$other','$lat','$lng')";

        $arcres = mysqli_query($conn, $arcquery);
        
        if ($arcres) {
            $message = "You archived ". $name ."."; 
            activityLog($message, $arc_id, $conn);
            $_SESSION['arc_success'] = true;
        }
    }}
} elseif(isset($_POST['archive-cultural'])){
    if($_SESSION['arcId'] != ""){
        $expId = $_SESSION['arcId'];
    $arcQuery = "SELECT * FROM tb_explore_cultural_religious WHERE cul_id = '$expId'";
    $arcrows = mysqli_query($conn, $arcQuery);

    list($expId, $name, $description, $location, $contact, $image, $other, $lat, $lng) = fetchData($arcrows);
    
    $query = "DELETE FROM `tb_explore_cultural_religious` WHERE `cul_id` = '$expId'";
    $res = mysqli_query($conn, $query);

    if($res) {
        $year = date('Y');

        $queryid = "SELECT arc_id FROM tb_archive_cultural_religious ORDER BY arc_id DESC LIMIT 1";
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
        $arcquery = "INSERT INTO `tb_archive_cultural_religious`(`arc_id`, `arc_exp_id`, `arc_exp_name`,
         `arc_evt_description`, `arc_exp_location`, `arc_exp_contact`, `arc_exp_image`,
         `arc_exp_other`, `arc_exp_latitude`, `arc_exp_longitude`)  
        VALUES ('$arc_id','$expId','$name','$description','$location',' $contact','$image','$other','$lat','$lng')";

        $arcres = mysqli_query($conn, $arcquery);
        
        if ($arcres) {
            $message = "You archived ". $name ."."; 
            activityLog($message, $arc_id, $conn);
            $_SESSION['arc_success'] = true;
        }
    }}
} elseif(isset($_POST['archive-restaurant'])){
    if($_SESSION['arcId'] != ""){
        $expId = $_SESSION['arcId'];
    $arcQuery = "SELECT * FROM tb_explore_restaurants WHERE resto_id = '$expId'";
    $arcrows = mysqli_query($conn, $arcQuery);

    list($expId, $name, $description, $location, $contact, $image, $other, $lat, $lng) = fetchData($arcrows);
    
    $query = "DELETE FROM `tb_explore_restaurants` WHERE `resto_id` = '$expId'";
    $res = mysqli_query($conn, $query);

    if($res) {
        $year = date('Y');

        $queryid = "SELECT arc_id FROM tb_archive_restaurants ORDER BY arc_id DESC LIMIT 1";
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
        $arcquery = "INSERT INTO `tb_archive_restaurants`(`arc_id`, `arc_exp_id`, `arc_exp_name`,
         `arc_evt_description`, `arc_exp_location`, `arc_exp_contact`, `arc_exp_image`,
         `arc_exp_other`, `arc_exp_latitude`, `arc_exp_longitude`)  
        VALUES ('$arc_id','$expId','$name','$description','$location',' $contact','$image','$other','$lat','$lng')";

        $arcres = mysqli_query($conn, $arcquery);
        
        if ($arcres) {
            $message = "You archived ". $name ."."; 
            activityLog($message, $arc_id, $conn);
            $_SESSION['arc_success'] = true;
        }
    }
}}



function fetchData($arcrows) {
    $row = mysqli_fetch_row($arcrows);

    $rowData = array();

    if ($row) {
        $rowData = array_map('htmlspecialchars', $row);
    }

    return $rowData;
}

?>