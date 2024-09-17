<?php
session_set_cookie_params(3600);
session_start();

include "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["save"])) {
        $username = $_POST["u_username"];
        $password = $_POST["u_password"];
        $email = $_POST["u_email"];
        $role = $_POST["u_role"];

        $check_sql = "SELECT * FROM users WHERE u_email = '$email'";
        $check_result = mysqli_query($con, $check_sql);

        if ($check_result) {
            if (mysqli_num_rows($check_result) > 0) {
                $user = mysqli_fetch_assoc($check_result);

                if ($user['u_username'] === $username) {
                    if (password_verify($password, $user['u_password'])) {
                        $_SESSION['user_id'] = $user['user_id'];

                        if ($role === 'admin') {
                            header("Location: http://127.0.0.1:5500/pages/Admin.html");
                        } 
                        else if ($role === 'organizer') {
                            header("Location: http://127.0.0.1:5500/pages/dashboard.html");
                        }
                        exit();
                    } else {
                       
                        $error_message = "Wrong password or username!";
                        header("Location: http://127.0.0.1:5500/pages/sign-in.html?error=" . urlencode($error_message));
                        exit();
                    }
                } else {
                   
                    $error_message = "Wrong password or username!";
                    header("Location: http://127.0.0.1:5500/pages/sign-in.html?error=" . urlencode($error_message));
                    exit();
                }
            } else {
                
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $sql = "INSERT INTO users (u_username, u_password, u_email, u_role) 
                        VALUES ('$username', '$hashedPassword', '$email', '$role')";

                if ($con->query($sql) === TRUE) {
                    $_SESSION['user_id'] = $con->insert_id;
                     $_SESSION['user_id'] = $row['user_id'];

                    if ($role === 'admin') {
                        header("Location: http://127.0.0.1:5500/pages/Admin.html");
                    } 
                    else if ($role === 'organizer') {
                        header("Location: http://127.0.0.1:5500/pages/dashboard.html");
                    }
                    exit();
                } 
                else {
                    echo "Error: " . $con->error;
                }
            }
        } 
        else {
            echo "Error: " . $con->error;
        }
    } elseif (isset($_POST["cancel"])) {
    }
}

$con->close();
?>
