<?php
header('Access-Control-Allow-Origin: *'); 
header('Content-Type: application/json; charset=UTF-8'); 

include "connection.php";

$sql = "SELECT 
            e.e_name AS event_name,
            SUM(s.max_capacity) AS total_capacity,
            SUM(esp.remaining_seats) AS remaining_seats
        FROM 
            events e
        JOIN 
            EventSectionPrices esp ON e.e_id = esp.e_id
        JOIN 
            sections s ON esp.s_id = s.s_id
        GROUP BY 
            e.e_name";

$result = mysqli_query($con, $sql);

$data = array();
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
             $event = array(
            "e_name" => $row['event_name'],
            "total_tickets" => $row['total_capacity'],
            "sold_tickets" => $row['total_capacity'] - $row['remaining_seats']
        );
        $data[] = $event;
    }
    echo json_encode($data);
} else {
    echo json_encode(["message" => "Error: " . mysqli_error($con)]);
}

mysqli_close($con);
?>
