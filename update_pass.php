<?php
session_set_cookie_params(3600);
session_start();
include "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $old_password = trim($_POST["old_password"]);
    $new_password = $_POST["new_pass"];
    $confirm_password = $_POST["confirm_password"];
    $user_id = $_SESSION['user_id'];

    if ($new_password !== $confirm_password) {
        $error_message = 'New password and confirm password do not match.';
        header("Location: http://127.0.0.1:5500/pages/profile.html?error=" . urlencode($error_message));
        exit();
    }

    $sql = "SELECT u_password FROM users WHERE user_id = '$user_id'";
    $res = mysqli_query($con, $sql);

    if ($res && mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        $stored_password = $row["u_password"];

        if (password_verify($old_password, $stored_password)) {
            $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

            $update_sql = "UPDATE users SET u_password = '$hashed_new_password' WHERE user_id = '$user_id'";
            $update_result = mysqli_query($con, $update_sql);

            if ($update_result) {
                $success_message = 'Password updated successfully.';
                header("Location: http://127.0.0.1:5500/pages/profile.html?success=" . urlencode($success_message));
                exit();
            } else {
                $error_message = 'Password update failed.';
            }
        } else {
            $error_message = 'Old password is incorrect.';
        }
    } else {
        $error_message = 'User not found.';
    }

    header("Location: http://127.0.0.1:5500/pages/profile.html?error=" . urlencode($error_message));
    exit();
}
?>
