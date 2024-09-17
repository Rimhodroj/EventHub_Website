<?php
session_set_cookie_params(3600);
session_start();
include "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["save"])) {
        
        if (!isset($_SESSION['user_id'])) {
            echo "User session not found. Please log in again.";
            exit();
        }

        
        $name = $_POST["e_name"];
        $description = $_POST["e_description"];
        $date = $_POST["e_date"];
        $country = $_POST["e_country"];
        $time = $_POST["e_time"];
        $category = $_POST["e_category"];
        $location = $_POST["e_location"];
        $artist = $_POST["artist_name"];
        $user_id = $_SESSION["user_id"];
        

        $upload_dir = "images/";
        $image_name = $_FILES["e_image"]["name"];
        $image_tmp = $_FILES["e_image"]["tmp_name"];

        move_uploaded_file($image_tmp, $upload_dir . $image_name);
        $e_image_url = $upload_dir . $image_name;

            
            
            $sql = "INSERT INTO events (e_name, e_description, e_image , e_date, e_country, e_time, e_category, e_location, artist_name, user_id) 
                    VALUES ('$name', '$description', '$image_name', '$date', '$country', '$time', '$category', '$location', '$artist', '$user_id')";
                    
                    
            $result = mysqli_query($con, $sql);
            
            if ($result === true) {
                 $event_id = mysqli_insert_id($con);
                 $_SESSION['e_id'] = $event_id;
                 
                 session_write_close();

                 
                header("Location: http://127.0.0.1:5500/pages/profile.html");
                exit();
            }
            else {
                echo "Error in the insert " ;
            }
        }
        else {
            echo "";
        }
    } 
    elseif (isset($_POST["cancel"])) {
        echo "It is canceled";
    
}

$con->close();

?>