<?php
header('Access-Control-Allow-Origin: *'); 
header('Content-Type: application/json; charset=UTF-8');
session_set_cookie_params(3600);
session_start();
include "connection.php";

$clients = array(); 

$query = "SELECT 
            clients.fullname, 
            clients.email, 
            tickets.t_price AS price, 
            events.e_name AS event_name
        FROM 
            tickets
        JOIN 
            clients ON tickets.client_id = clients.id
        JOIN 
            events ON tickets.event_id = events.e_id";

$result = mysqli_query($con, $query);


    if (mysqli_num_rows($result) > 0) {
        
        while ($row = mysqli_fetch_assoc($result)) { 
            
            $clients[] = $row; 
        }
    } else {
        echo "No clients found";
    }

$con->close();


header('Content-Type: application/json');
echo json_encode($clients);
?>
