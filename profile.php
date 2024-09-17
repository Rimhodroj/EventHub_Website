<?php
header("Access-Control-Allow-Origin: http://127.0.0.1:5500");

session_set_cookie_params(3600);
session_start();
include "connection.php";

if (!isset($_SESSION['user_id'])) {
   // header("Location: http://127.0.0.1:5500/pages/sign-in.html");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT image, name FROM organizer WHERE user_id = '$user_id'";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $organizer_image = $row['image'];
    $organizer_name = $row['name'];
}
else {
    $organizer_image = ""; 
    $organizer_name = "Organizer Name Not Available";
}
$organizer_data = array(
    "image" => $organizer_image,
    "name" => $organizer_name
);


header('Content-Type: application/json');
echo json_encode($organizer_data);
?>