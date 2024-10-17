<?php

if(isset($_POST['edit-resort'])){
    
    if($_SESSION['editId'] != ""){
        $eId = $_SESSION['editId'];

    list($name, $description, $location, $contact, $other_info, $lat, $lng, $newImageName, $tmpName) = updatedDetails();

    if ($newImageName === ""){
        $query = "UPDATE `tb_explore_resorts` SET
        `rest_name`='$name', `rest_description`='$description',
        `rest_location`='$location', `rest_contact`='$contact',
        `rest_other_info`='$other_info', `rest_latitude`='$lat',`rest_longitude`='$lng' WHERE `rest_id`='$eId'";
            
        $res = mysqli_query($conn, $query);

        if($res){

            $activityMessage = "You edited a resort named \"" . $name . "\"";
            $_SESSION['edit_success'] = true;
            activityLog($activityMessage, $eId, $conn);

        }       
    } else{
       
        move_uploaded_file($tmpName, '../../images/resort_img/' . $newImageName);

        $result = mysqli_query($conn, "SELECT rest_image FROM tb_explore_resorts WHERE rest_id = '$eId'");

        if ($result && $row = mysqli_fetch_assoc($result)){
            $imageFilename = $row["rest_image"];
            $imageFilePath = "../../images/resort_img/" . $imageFilename;
    
            if (file_exists($imageFilePath)){
                unlink($imageFilePath); // Delete the image file
            }
        }

        $query = "UPDATE `tb_explore_resorts` SET
        `rest_name`='$name', `rest_description`='$description',
        `rest_location`='$location', `rest_contact`='$contact',
        `rest_image`='$newImageName', `rest_other_info`='$other_info', 
        `rest_latitude`='$lat',`rest_longitude`='$lng' WHERE `rest_id`='$eId'";
            
        $res = mysqli_query($conn, $query);

        if($res){

            $activityMessage = "You edited a resort named \"" . $name . "\"";
            $_SESSION['edit_success'] = true;
            activityLog($activityMessage, $eId, $conn);

        }     }
    }
} elseif (isset($_POST['edit-recreational'])) {
    if($_SESSION['editId'] != ""){
        $eId = $_SESSION['editId'];

    list($name, $description, $location, $contact, $other_info, $lat, $lng, $newImageName, $tmpName) = updatedDetails();
    if ($newImageName === ""){
        $query = "UPDATE `tb_explore_recreational` SET
        `rec_name`='$name', `rec_description`='$description',
        `rec_location`='$location', `rec_contact`='$contact',
        `rec_other_info`='$other_info', 
        `rec_latitude`='$lat',`rec_longitude`='$lng' WHERE `rec_id`='$eId'";
            
        $res = mysqli_query($conn, $query);
        if($res){

            $activityMessage = "You edited a recreational facility named \"" . $name . "\"";
            $_SESSION['edit_success'] = true;
            activityLog($activityMessage, $eId, $conn);
        }     
    } else{
        move_uploaded_file($tmpName, '../../images/recreational_img/' . $newImageName);

        $result = mysqli_query($conn, "SELECT rec_image FROM tb_explore_recreational WHERE rec_id = '$eId'");

        if ($result && $row = mysqli_fetch_assoc($result)){
            $imageFilename = $row["rec_image"];
            $imageFilePath = "../../images/recreational_img/" . $imageFilename;
    
            if (file_exists($imageFilePath)){
                unlink($imageFilePath); // Delete the image file
            }
        }

        $query = "UPDATE `tb_explore_recreational` SET
        `rec_name`='$name', `rec_description`='$description',
        `rec_location`='$location', `rec_contact`='$contact',
        `rec_image`='$newImageName', `rec_other_info`='$other_info', 
        `rec_latitude`='$lat',`rec_longitude`='$lng' WHERE `rec_id`='$eId'";
            
        $res = mysqli_query($conn, $query);

        if($res){
            $activityMessage = "You edited a recreational facility named \"" . $name . "\"";
            $SESSION['edit_success'] = true;
            activityLog($activityMessage, $eId, $conn);
        }
    }}
} elseif (isset($_POST['edit-hotel'])) {
    if($_SESSION['editId'] != ""){
        $eId = $_SESSION['editId'];
    list($name, $description, $location, $contact, $other_info, $lat, $lng, $newImageName, $tmpName) = updatedDetails();

    if ($newImageName === ""){
        
        $query = "UPDATE `tb_explore_hotel_lodge` SET
        `hotel_name`='$name', `hotel_description`='$description',
        `hotel_location`='$location', `hotel_contact`='$contact',
        `hotel_other_info`='$other_info', 
        `hotel_latitude`='$lat',`hotel_longitude`='$lng' WHERE `hotel_id`='$eId'";
            
        $res = mysqli_query($conn, $query);

        if($res){

            $activityMessage = "You edited a hotel & Lodging named \"" . $name . "\"";
            $_SESSION['edit_success'] = true;
            activityLog($activityMessage, $eId, $conn);

        }    
               
    } else{

        move_uploaded_file($tmpName, '../../images/hotel_lodging_img/' . $newImageName);

        $result = mysqli_query($conn, "SELECT hotel_image FROM tb_explore_hotel_lodge WHERE hotel_id = '$eId'");

        if ($result && $row = mysqli_fetch_assoc($result)){
            $imageFilename = $row["hotel_image"];
            $imageFilePath = "../../images/hotel_lodging_img/" . $imageFilename;
    
            if (file_exists($imageFilePath)){
                unlink($imageFilePath); // Delete the image file
            }
        }

        $query = "UPDATE `tb_explore_hotel_lodge` SET
        `hotel_name`='$name', `hotel_description`='$description',
        `hotel_location`='$location', `hotel_contact`='$contact',
        `hotel_image`='$newImageName', `hotel_other_info`='$other_info', 
        `hotel_latitude`='$lat',`hotel_longitude`='$lng' WHERE `hotel_id`='$eId'";
            
        $res = mysqli_query($conn, $query);

        if($res){

            $activityMessage = "You edited a hotel & Lodging named \"" . $name . "\"";
            $_SESSION['edit_success'] = true;
            activityLog($activityMessage, $eId, $conn);

        }     
    }}
} elseif (isset($_POST['edit-natural'])) {
    if($_SESSION['editId'] != ""){
        $eId = $_SESSION['editId'];
    list($name, $description, $location, $contact, $other_info, $lat, $lng, $newImageName, $tmpName) = updatedDetails();

    if ($newImageName === ""){
        
        $query = "UPDATE `tb_explore_natural_manmade` SET
        `natural_name`='$name', `natural_description`='$description',
        `natural_location`='$location', `natural_contact`='$contact',
        `natural_other_info`='$other_info', `natural_latitude`='$lat',
        `natural_longitude`='$lng' WHERE `natural_id`='$eId'";
            
        $res = mysqli_query($conn, $query);

        if($res){

            $activityMessage = "You edited a natural/man-made attraction named \"" . $name . "\"";
            $_SESSION['edit_success'] = true;
            activityLog($activityMessage, $eId, $conn);
        }    

    } else{
        move_uploaded_file($tmpName, '../../images/natural_manmade_img/' . $newImageName);

        $result = mysqli_query($conn, "SELECT natural_image FROM tb_explore_natural_manmade WHERE natural_id = '$eId'");

        if ($result && $row = mysqli_fetch_assoc($result)){
            $imageFilename = $row["natural_image"];
            $imageFilePath = "../../images/natural_manmade_img/" . $imageFilename;
    
            if (file_exists($imageFilePath)){
                unlink($imageFilePath); // Delete the image file
            }
        }

        $query = "UPDATE `tb_explore_natural_manmade` SET
        `natural_name`='$name', `natural_description`='$description',
        `natural_location`='$location', `natural_contact`='$contact',
        `natural_image`='$newImageName', `natural_other_info`='$other_info', 
        `natural_latitude`='$lat',`natural_longitude`='$lng' WHERE `natural_id`='$eId'";
            
        $res = mysqli_query($conn, $query);

        if($res){

            $activityMessage = "You edited a natural/man-made attraction named \"" . $name . "\"";
            $_SESSION['edit_success'] = true;
            activityLog($activityMessage, $eId, $conn);

        }  
    }}
} elseif (isset($_POST['edit-cultural'])) {
    if($_SESSION['editId'] != ""){
        $eId = $_SESSION['editId'];
    list($name, $description, $location, $contact, $other_info, $lat, $lng, $newImageName, $tmpName) = updatedDetails();

    if ($newImageName === ""){   
        $query = "UPDATE `tb_explore_cultural_religious` SET
        `cul_name`='$name', `cul_description`='$description',
        `cul_location`='$location', `cul_contact`='$contact',
         `cul_other_info`='$other_info', `cul_latitude`='$lat',
         `cul_longitude`='$lng' WHERE `cul_id`='$eId'";
            
        $res = mysqli_query($conn, $query);

        if($res){

            $activityMessage = "You edited a cultural/religious attraction named \"" . $name . "\"";
            $_SESSION['edit_success'] = true;
            activityLog($activityMessage, $eId, $conn);

        }  
    } else{
        move_uploaded_file($tmpName, '../../images/cultural_religious_img/' . $newImageName);
                        
        $result = mysqli_query($conn, "SELECT cul_image FROM tb_explore_cultural_religious WHERE cul_id = '$eId'");

        if ($result && $row = mysqli_fetch_assoc($result)){
            $imageFilename = $row["cul_image"];
            $imageFilePath = "../../images/cultural_img/" . $imageFilename;
    
            if (file_exists($imageFilePath)){
                unlink($imageFilePath); // Delete the image file
            }
        }

        $query = "UPDATE `tb_explore_cultural_religious` SET
        `cul_name`='$name', `cul_description`='$description',
        `cul_location`='$location', `cul_contact`='$contact',
        `cul_image`='$newImageName', `cul_other_info`='$other_info', 
        `cul_latitude`='$lat',`cul_longitude`='$lng' WHERE `cul_id`='$eId'";
            
        $res = mysqli_query($conn, $query);

        if($res){

            $activityMessage = "You edited a cultural/religious attraction named \"" . $name . "\"";
            $_SESSION['edit_success'] = true;
            activityLog($activityMessage, $eId, $conn);

        }  
    }}
} elseif (isset($_POST['edit-restaurant'])) {
    if($_SESSION['editId'] != ""){
        $eId = $_SESSION['editId'];
    list($name, $description, $location, $contact, $other_info, $lat, $lng, $newImageName, $tmpName) = updatedDetails();

    if ($newImageName === ""){   
        $query = "UPDATE `tb_explore_restaurants` SET
        `resto_name`='$name', `resto_description`='$description',
        `resto_location`='$location', `resto_contact`='$contact',
        `resto_other_info`='$other_info', `resto_latitude`='$lat',
        `resto_longitude`='$lng' WHERE `resto_id`='$eId'";
            
        $res = mysqli_query($conn, $query);

        if($res){

            $activityMessage = "You edited a restaurants named \"" . $name . "\"";
            $_SESSION['edit_success'] = true;
            activityLog($activityMessage, $eId, $conn);

        }  
    } else{
        move_uploaded_file($tmpName, '../../images/restaurants_img/' . $newImageName);
                        
        $result = mysqli_query($conn, "SELECT resto_image FROM tb_explore_restaurants WHERE resto_id = '$eId'");

        if ($result && $row = mysqli_fetch_assoc($result)){
            $imageFilename = $row["resto_image"];
            $imageFilePath = "../../images/restaurants_img/" . $imageFilename;
    
            if (file_exists($imageFilePath)){
                unlink($imageFilePath); // Delete the image file
            }
        }

        $query = "UPDATE `tb_explore_restaurants` SET
        `resto_name`='$name', `resto_description`='$description',
        `resto_location`='$location', `resto_contact`='$contact',
        `resto_image`='$newImageName', `resto_other_info`='$other_info', 
        `resto_latitude`='$lat',`resto_longitude`='$lng' WHERE `resto_id`='$eId'";
            
        $res = mysqli_query($conn, $query);

        if($res){

            $activityMessage = "You edited a restaurants named \"" . $name . "\"";
            $_SESSION['edit_success'] = true;
            activityLog($activityMessage, $eId, $conn);

        }  
    }
}}

function updatedDetails(){
    $name = htmlspecialchars($_POST["exp_name"]);
    $description = htmlspecialchars($_POST['exp_description']);
    $location = htmlspecialchars($_POST['exp_location']);
    $contact = $_POST['contact'];
    $other_info = htmlspecialchars($_POST['exp_other']);
    $lat = $_POST['latitude'];
    $lng = $_POST['longitude'];
    $newImageName = "";
    $tmpName = "";
            
    if($_FILES["image"]["error"] === 4){ // checks if there's no image
        return array($name, $description, $location, $contact, $other_info, $lat, $lng, $newImageName, $tmpName);
    } else{
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

            return array($name, $description, $location, $contact, $other_info, $lat, $lng, $newImageName, $tmpName);
        }
    }
    
    
        
}

?>