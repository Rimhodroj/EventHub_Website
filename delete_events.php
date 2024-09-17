<?php
session_set_cookie_params(3600);
session_start();
include "connection.php";

if (!isset($_SESSION['user_id'])) {
    echo "Organizer session not found. Please log in again.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["delete"])) {
        $eventname = $_POST["e_name"];
        $user_id = $_SESSION["user_id"];

        $delete = "DELETE FROM events WHERE e_name = '$eventname' AND user_id= '$user_id'";
        $res = mysqli_query($con, $delete);

        if ($res === TRUE) {
            header("Location: http://127.0.0.1:5500/pages/delete.html?success=Event%20deleted%20successfully");
            exit();
        } else {
            $error_message = "Error deleting record: " . $con->error;
            header("Location: http://127.0.0.1:5500/pages/delete.html?error=" . urlencode($error_message));
            exit();
        }
    }
}
?>
