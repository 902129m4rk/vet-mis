<?php
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
}
//kapag nakapag login na
else {

    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } else if (!empty($_SERVER['HTTP_X_FORWARDED'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    $ip = $_SERVER['REMOTE_ADDR'];

    date_default_timezone_set('Asia/Manila');
    // $current_username = $_SESSION["usernames"];
    $current_username =  $_SESSION["empid"];


    $sql = "INSERT INTO audit_trail(ip_address, emp_id, user_activity, details, date, time) VALUES (?,?,?,?,NOW(),NOW());";
    $stmt = mysqli_stmt_init($conn);

    if (mysqli_stmt_prepare($stmt, $sql)) {

        mysqli_stmt_bind_param($stmt, "ssss", $ip, $current_username, $user_activity, $details);
        mysqli_stmt_execute($stmt);
    } else {
        echo "Something went wrong in the audit trail";
    }
}
