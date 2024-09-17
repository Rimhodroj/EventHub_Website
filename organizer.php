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

        $name = $_POST["name"];
        $description = $_POST["description"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $instagram_link = $_POST["instagram_link"];
        $facebook_link = $_POST["facebook_link"];
        $linkedin_link = $_POST["linkedin_link"];
        $address = $_POST["address"];
        $city = $_POST["city"];
        $country = $_POST["country"];
        $user_id = $_SESSION['user_id'];
        
        $upload_dir = "images/";
        $image_name = $_FILES["image"]["name"];
        $image_tmp = $_FILES["image"]["tmp_name"];

        move_uploaded_file($image_tmp, $upload_dir . $image_name);
        $e_image_url = $upload_dir . $image_name;

        $check_sql = "SELECT * FROM organizer WHERE user_id = '$user_id'";
        $check_result = mysqli_query($con,$check_sql);

        if ($check_result->num_rows > 0) {
            $update_fields = array();
            if (!empty($name)) $update_fields[] = "name='$name'";
            if (!empty($description)) $update_fields[] = "description='$description'";
            if (!empty($email)) $update_fields[] = "email='$email'";
            if (!empty($phone)) $update_fields[] = "phone='$phone'";
            if (!empty($instagram_link)) $update_fields[] = "instagram_link='$instagram_link'";
            if (!empty($facebook_link)) $update_fields[] = "facebook_link='$facebook_link'";
            if (!empty($linkedin_link)) $update_fields[] = "linkedin_link='$linkedin_link'";
            if (!empty($address)) $update_fields[] = "address='$address'";
            if (!empty($city)) $update_fields[] = "city='$city'";
            if (!empty($country)) $update_fields[] = "country='$country'";
            if (!empty($image_name)) $update_fields[] = "image='$image_name'";

            $update_sql = "UPDATE organizer SET " . implode(", ", $update_fields) . " WHERE user_id='$user_id'";

            if ($con->query($update_sql) === TRUE) {
                header("Location: http://127.0.0.1:5500/pages/tables.html");
                exit();
            } else {
                
            }
        } else {
            $insert_sql = "INSERT INTO organizer (name, image, description, email, phone, instagram_link, facebook_link, linkedin_link, address, city, country, user_id) 
                VALUES ('$name', '$image_name', '$description', '$email', '$phone', '$instagram_link', '$facebook_link', '$linkedin_link', '$address', '$city', '$country','$user_id')";

            if ($con->query($insert_sql) === TRUE) {
                header("Location: http://127.0.0.1:5500/pages/tables.html");
                exit();
            } else {
                
                
            }
        }
    } elseif (isset($_POST["cancel"])) {
        echo "Information cancelled.";
    }

    $con->close();
}
?>
