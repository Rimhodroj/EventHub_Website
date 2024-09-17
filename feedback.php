<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');

session_start();
include "connection.php";


// if (!isset($_SESSION['user_id'])) {
//     die(json_encode(array('error' => 'User session not found. Please login.')));
// }

// $user_id = $_SESSION['user_id'];

$events = array();

$sql = "SELECT e_name, e_image, e_date, e_category, status FROM events ";

$result = $con->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}

$con->close();

echo json_encode($events);
?>
