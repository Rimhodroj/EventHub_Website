<?php

header('Access-Control-Allow-Origin: *'); 
header('Content-Type: application/json; charset=UTF-8');
header('Content-Type: application/json');

include "connection.php"; // Make sure this file contains your database connection code


$sql = "SELECT COUNT(*) AS client_count FROM clients";
$result = mysqli_query($con, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    echo json_encode(['client_count' => $row['client_count']]);
} else {
    echo json_encode(['client_count' => 0]);
}

mysqli_close($con);
?>
