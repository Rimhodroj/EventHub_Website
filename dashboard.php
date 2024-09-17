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

        $legal_name = $_POST["Legal_Name"];
        $business_locations = $_POST["Business_Locations"];
        $current_currency = $_POST["Current_Currency"];
        $name = $_POST["name"];
        $email = $_POST["email"];
        $phone = $_POST["phonenb"];
        $address = $_POST["address"];
        $city = $_POST["city"];
        $country = $_POST["country"];
        $tax_identifiers = $_POST["Tax_Identifiers"];
        $registration_numbers = $_POST["Registration_Numbers"];
        $user_id = $_SESSION['user_id'];

        $check_sql = "SELECT * FROM dashboard WHERE user_id = '$user_id'";
        $check_result = mysqli_query($con,$check_sql);

        if ($check_result->num_rows > 0) {
             $update_fields = array(
                "Legal_Name='$legal_name'",
                "Business_Locations='$business_locations'",
                "Current_Currency='$current_currency'",
                "name='$name'",
                "email='$email'",
                "phonenb='$phone'",
                "address='$address'",
                "city='$city'",
                "country='$country'",
                "Tax_Identifiers='$tax_identifiers'",
                "Registration_Numbers='$registration_numbers'"
    );

    $update_sql = "UPDATE dashboard SET ";
    $update_sql .= implode(", ", $update_fields);
    $update_sql .= " WHERE user_id='$user_id'";


            if ($con->query($update_sql) === TRUE) {
                header("Location: http://127.0.0.1:5500/pages/organizer.html");
                exit();
            } else {
                echo "error " . $con->error;
            }
        } else {
            $insert_sql = "INSERT INTO dashboard (Legal_Name, Business_Locations, Current_Currency, name, email, phonenb, address, city, country, Tax_Identifiers, Registration_Numbers, user_id) 
            
                VALUES ('$legal_name', '$business_locations', '$current_currency', '$name', '$email', '$phone', '$address', '$city', '$country', '$tax_identifiers', '$registration_numbers', '$user_id')";
                
                $result = mysqli_query($con,$insert_sql);

            if ($result === TRUE) {
                header("Location: http://127.0.0.1:5500/pages/organizer.html");
                exit();
            } else {
                echo "eror " . $con->error;
            }
        }
    } elseif (isset($_POST["cancel"])) {
    }

}

$con->close();
?>