<?php
session_set_cookie_params(3600);
session_start();

if (!isset($_SESSION['e_id'])) {
    echo "Event session not found.";
    exit();
}

include "connection.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $section_id = $_POST['section_id'];
    $price = $_POST['price'];
    $event_id = $_SESSION['e_id'];

    $sql = "INSERT INTO EventSectionPrices (e_id, s_id, price) VALUES ('$event_id', '$section_id', '$price')";
    $res = mysqli_query($con, $sql);

    if ($res === TRUE) {
        header("Location: http://127.0.0.1:5500/pages/profile.html");
        exit();
    } 
    else {
        echo "Error adding event price " ;
    }
}

$con->close();
?>
