<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');

include "connection.php";

$currentDateTime = date('Y-m-d H:i:s'); 

$previousDateTime = date('Y-m-d H:i:s', strtotime('-24 hours'));

$sql = "SELECT events.e_name, COUNT(tickets.event_id) as tickets_sold 
        FROM tickets 
        JOIN events ON tickets.event_id = events.e_id 
        WHERE tickets.purchase_date BETWEEN '$previousDateTime' AND '$currentDateTime' 
        GROUP BY tickets.event_id 
        ORDER BY tickets_sold DESC 
        LIMIT 1";

$result = $con->query($sql);

$response = array();

if ($result->num_rows > 0) {
    $response = $result->fetch_assoc(); 
} else {
    $response = array("e_name" => "No events", "tickets_sold" => 0); 
}

$con->close();

echo json_encode($response); 
?>
