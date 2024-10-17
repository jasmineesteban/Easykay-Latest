<?php

if (isset($_POST['add-resort'])) {

    list($name, $description, $location, $contact, $other_info, $lat, $lng, $newImageName, $tmpName) = details();

    if ($name && $description && $location && $contact && $lat && $lng && $newImageName){

        move_uploaded_file($tmpName, '../../images/resort_img/' . $newImageName);

        $queryid = "SELECT rest_id FROM tb_explore_resorts ORDER BY rest_id DESC LIMIT 1"; // it select the expId that has highest value
        $result = mysqli_query($conn, $queryid);
            
        //11 characters rest-000000
                    
        $initialid = "rest-";
                    
        if ($row = mysqli_fetch_assoc($result)) { // check if there's value
            // Extract the numeric part of the last ID
                    
            $lastID = $row['rest_id'];
            $numericPart = (int)substr($lastID, -6);
                    
            // Increment the numeric part
            $numericPart++;                    
            // Generate the new ID
            $expId = $initialid . str_pad($numericPart, 6, '0', STR_PAD_LEFT);
        }
        else {                // If no records, start with the initial ID
            $expId = $initialid . '000001';
        }

        $query = "INSERT INTO tb_explore_resorts VALUES('$expId', '$name', '$description', '$location', '$contact', '$newImageName', '$other_info', '$lat', '$lng')";            
        
        $res = mysqli_query($conn, $query);

        if($res){
            $activityMessage = "You have added a resort named \"" . $name . "\"";
            activityLog($activityMessage, $expId, $conn);
            $_SESSION['add_success'] = true;

        }
    }
    

} elseif (isset($_POST['add-recreational'])) {

    list($name, $description, $location, $contact, $other_info, $lat, $lng, $newImageName, $tmpName) = details();

    if ($name && $description && $location && $contact && $lat && $lng && $newImageName){
        move_uploaded_file($tmpName, '../../images/recreational_img/' . $newImageName);

        $queryid = "SELECT rec_id FROM tb_explore_recreational ORDER BY rec_id DESC LIMIT 1"; // it select the id that has highest value
        $result = mysqli_query($conn, $queryid);
        //10 characters rec-000000

        $initialid = "rec-";

        if ($row = mysqli_fetch_assoc($result)) { 

            $lastID = $row['rec_id'];
            $numericPart = (int)substr($lastID, -6);
            $numericPart++;
            $expId = $initialid . str_pad($numericPart, 6, '0', STR_PAD_LEFT);
        }
        else {
            $expId = $initialid . '000001';
        }


        $query = "INSERT INTO tb_explore_recreational VALUES('$expId', '$name', '$description', '$location', '$contact', '$newImageName', '$other_info', '$lat', '$lng')";
        $res = mysqli_query($conn, $query);
        
        if($res){

            $activityMessage = "You have added a recreational facility named \"" . $name . "\"";
            activityLog($activityMessage, $expId, $conn);
            $_SESSION['add_success'] = true;

        }
    }

} elseif (isset($_POST['add-hotel'])) {

    list($name, $description, $location, $contact, $other_info, $lat, $lng, $newImageName, $tmpName) = details();

    if ($name && $description && $location && $contact && $lat && $lng && $newImageName){
        move_uploaded_file($tmpName, '../../images/hotel_lodging_img/' . $newImageName);

        $queryid = "SELECT hotel_id FROM tb_explore_hotel_lodge ORDER BY hotel_id DESC LIMIT 1"; // it select the id that has highest value
        $result = mysqli_query($conn, $queryid);
        //12 characters hotel-000000
                    
        $initialid = "hotel-";
                    
        if ($row = mysqli_fetch_assoc($result)) { 
            $lastID = $row['hotel_id'];
            $numericPart = (int)substr($lastID, -6);
            $numericPart++;
            $expId = $initialid . str_pad($numericPart, 6, '0', STR_PAD_LEFT);
        }
        else {
            $expId = $initialid . '000001';
        }

        $query = "INSERT INTO tb_explore_hotel_lodge VALUES('$expId', '$name', '$description', '$location', '$contact', '$newImageName', '$other_info', '$lat', '$lng')";
        $res = mysqli_query($conn, $query);
                            
        if($res){
            $activityMessage = "You have added an hotel & lodging named \"" . $name . "\"";
            activityLog($activityMessage, $expId, $conn);
            $_SESSION['add_success'] = true;
        }
    }
} elseif (isset($_POST['add-natural'])) {

    list($name, $description, $location, $contact, $other_info, $lat, $lng, $newImageName, $tmpName) = details();

    if ($name && $description && $location && $contact && $lat && $lng && $newImageName){
        move_uploaded_file($tmpName, '../../images/natural_manmade_img/' . $newImageName);

        $queryid = "SELECT natural_id FROM tb_explore_natural_manmade ORDER BY natural_id DESC LIMIT 1"; // it select the id that has highest value
        $result = mysqli_query($conn, $queryid);
        //14 characters natural-000000
                    
        $initialid = "natural-";
                    
        if ($row = mysqli_fetch_assoc($result)) { 
                        
            $lastID = $row['natural_id'];
            $numericPart = (int)substr($lastID, -6);
            $numericPart++;
            $expId = $initialid . str_pad($numericPart, 6, '0', STR_PAD_LEFT);
        }
        else {
            $expId = $initialid . '000001';
        }

        $query = "INSERT INTO tb_explore_natural_manmade VALUES('$expId', '$name', '$description', '$location', '$contact', '$newImageName', '$other_info', '$lat', '$lng')";
        $res = mysqli_query($conn, $query);

        if($res){
            $activityMessage = "You have added a natural/man-made attraction named \"" . $name . "\"";
            activityLog($activityMessage, $expId, $conn);
            $_SESSION['add_success'] = true;
        }
    }
} elseif (isset($_POST['add-cultural'])) {

    list($name, $description, $location, $contact, $other_info, $lat, $lng, $newImageName, $tmpName) = details();

    if ($name && $description && $location && $contact && $lat && $lng && $newImageName){
        move_uploaded_file($tmpName, '../../images/cultural_religious_img/' . $newImageName);

        $queryid = "SELECT cul_id FROM tb_explore_cultural_religious ORDER BY cul_id DESC LIMIT 1"; 
        $result = mysqli_query($conn, $queryid);
        //15 characters cultural-000000
                    
        $initialid = "cultural-";
                    
        if ($row = mysqli_fetch_assoc($result)) {
            $lastID = $row['cul_id'];
            $numericPart = (int)substr($lastID, -6);
            $numericPart++;
            $expId = $initialid . str_pad($numericPart, 6, '0', STR_PAD_LEFT);
        }
        else {
            $expId = $initialid . '000001';
        }

        $query = "INSERT INTO tb_explore_cultural_religious VALUES('$expId', '$name', '$description', '$location', '$contact', '$newImageName', '$other_info', '$lat', '$lng')";
        $res = mysqli_query($conn, $query);

        if($res){

            $activityMessage = "You have added a cultural/religious attractions named \"" . $name . "\"";
            activityLog($activityMessage, $expId, $conn);
            $_SESSION['add_success'] = true;

        }
    }
} elseif (isset($_POST['add-restaurant'])) {

    list($name, $description, $location, $contact, $other_info, $lat, $lng, $newImageName, $tmpName) = details();

    if ($name && $description && $location && $contact && $lat && $lng && $newImageName){
        move_uploaded_file($tmpName, '../../images/restaurants_img/' . $newImageName);

        $queryid = "SELECT resto_id FROM tb_explore_restaurants ORDER BY resto_id DESC LIMIT 1"; 
        $result = mysqli_query($conn, $queryid);

        $initialid = "resto-";

        if ($row = mysqli_fetch_assoc($result)) { 

            $lastID = $row['resto_id'];
            $numericPart = (int)substr($lastID, -6);
            $numericPart++;
            $expId = $initialid . str_pad($numericPart, 6, '0', STR_PAD_LEFT);
        }
        else {
            $expId = $initialid . '000001';
        }

        $query = "INSERT INTO tb_explore_restaurants VALUES('$expId', '$name', '$description', '$location', '$contact', '$newImageName', '$other_info', '$lat', '$lng')";
        $res = mysqli_query($conn, $query);

        if($res){

            $activityMessage = "You have added a restaurants named \"" . $name . "\"";
            activityLog($activityMessage, $expId, $conn);
            $_SESSION['add_success'] = true;

        }
    }
} 

if(isset($_SESSION['add_success'])){
    unset($_SESSION['add_success']);
    header("Location: ".$_SERVER['PHP_SELF']);
    exit; // Terminate script execution
}

function details(){
    $name = htmlspecialchars($_POST["exp_name"]);
    $description = htmlspecialchars($_POST['exp_description']);
    $location = htmlspecialchars($_POST['exp_location']);
    $contact = $_POST['contact'];
    $other_info = htmlspecialchars($_POST['exp_other']);
    $lat = $_POST['latitude'];
    $lng = $_POST['longitude'];
            
    if($_FILES["image"]["error"] !== 4){ // checks if there was no error during upload // means image was successfully uploaded
        $filename = $_FILES["image"]["name"];
        $filesize = $_FILES["image"]["size"];
        $tmpName = $_FILES["image"]["tmp_name"];
    
        $validImageExtension = ['jpg', 'jpeg', 'png'];
        $imageExtension = explode('.', $filename);  
        $imageExtension = strtolower(end($imageExtension)); // retrieves "jpg", "jpeg", or "png" - value
    
        if(!in_array($imageExtension, $validImageExtension)){
            echo '<div class="alert alert-danger" role="alert">Invalid Image Extension</div>'; 
        }
        elseif($filesize > 5000000){ // 5mb
            echo '<div class="alert alert-danger" role="alert">Image size is too large</div>'; 
        }
        else{
            $newImageName = uniqid() . "." . $imageExtension;
        }
    }
    
    return array($name, $description, $location, $contact, $other_info, $lat, $lng, $newImageName, $tmpName);
        
}



?>