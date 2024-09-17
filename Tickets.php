<?php
session_set_cookie_params(3600);
session_start();
include "connection.php";

$user_id = $_SESSION["user_id"];


$sql = "SELECT e_name, e_total , e_sold FROM events WHERE user_id = '$user_id'";
$result = mysqli_query($con , $sql);

$events=array();

if ($result->num_rows > 0) {
     while ($row = $result->fetch_assoc()) {
         $events[] = $row;
     }
}
 else {
    echo "No events found.";
}

$con->close();

?>