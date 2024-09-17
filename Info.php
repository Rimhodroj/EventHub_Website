<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');

session_start();
include "connection.php";



$sql = "SELECT o.name AS organizer_name, o.email AS organizer_email, o.address AS organizer_address, e.e_name AS event_name
        FROM organizer o
        LEFT JOIN events e ON o.user_id = e.user_id";
      
$result = $con->query($sql);

$organizers = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $organizer_name = $row['organizer_name'];
        $organizers[$organizer_name]['name'] = $row['organizer_name'];
        $organizers[$organizer_name]['email'] = $row['organizer_email'];
        $organizers[$organizer_name]['address'] = $row['organizer_address'];

        if ($row['event_name'] != null) {
            $organizers[$organizer_name]['events'][] = $row['event_name'];
        }
    }
} else {
    echo "0 results";
}

$con->close();

echo json_encode(array_values($organizers));
?>
