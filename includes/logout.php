<?php
// Initialize the session
session_start();

require_once 'config.php';
if (isset($_POST['logout'])) {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } else if (!empty($_SERVER['HTTP_X_FORWARDED'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    $ip = $_SERVER['REMOTE_ADDR'];

    date_default_timezone_set('Asia/Manila');
    $current_username = $_SESSION["empid"];

    $user_activity = "Successfully logout";
    $details = "Successfully logout";

    $sql = "INSERT INTO audit_trail(ip_address, emp_id, user_activity, details, date, time) VALUES (?,?,?,?,NOW(),NOW());";
    $stmt = mysqli_stmt_init($conn);

    if (mysqli_stmt_prepare($stmt, $sql)) {

        mysqli_stmt_bind_param($stmt, "ssss", $ip, $current_username, $user_activity, $details);
        if (mysqli_stmt_execute($stmt)) {

            unset($_SESSION['loggedin']);
            unset($_SESSION['empid']);
            unset($_SESSION['usernames']);
            unset($_SESSION['password']);
            unset($_SESSION["fname"]);
            unset($_SESSION["lname"]);
            unset($_SESSION["utstaff"]);
            unset($_SESSION["utadmin"]);
            unset($_SESSION["utvet"]);

            session_destroy();
            header("location: ../index.php");
            exit;
        }
    }
} elseif ($_SESSION["inactive"]) {
    unset($_SESSION['loggedin']);
    unset($_SESSION['empid']);
    unset($_SESSION['usernames']);
    unset($_SESSION['password']);
    unset($_SESSION["fname"]);
    unset($_SESSION["lname"]);
    unset($_SESSION["utstaff"]);
    unset($_SESSION["utadmin"]);
    unset($_SESSION["utvet"]);

    session_destroy();
    header("location: ../index.php");
    exit;
}
