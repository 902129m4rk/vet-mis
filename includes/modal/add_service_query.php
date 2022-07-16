<?php
require_once '../config.php';
session_start();
if (isset($_POST['add'])) {
    $id = filter_input(INPUT_POST, 'id');

    //Species Name
    $name = ucfirst(filter_input(INPUT_POST, 'service_name'));
    $price = filter_input(INPUT_POST, 'service_price');
    $status = 'Active';

    // REGEX/ FORM VALIDATION
    $regexname = "/^[a-zA-Z0-9\d\s\.\-\/\(\)\&]+$/";

    $sql = "SELECT * FROM service WHERE name = '$name'";
    $query = mysqli_query($conn, $sql);

    if (mysqli_num_rows($query) > 0) {
        echo "<script language='javascript'>";
        echo 'alert("Sorry, this service name is already existed. Please try another name");';
        echo 'window.location.replace("../../services.php?addservice=failed");';
        echo "</script>";
    } else {
        if (preg_match($regexname, $name)) {

            $sql = "INSERT INTO service(name, price, status) VALUES (?,?,?);";
            $stmt = mysqli_stmt_init($conn);

            if (mysqli_stmt_prepare($stmt, $sql)) {
                mysqli_stmt_bind_param($stmt, "sss", $name, $price, $status);

                if (mysqli_stmt_execute($stmt)); {
                    $service_id = mysqli_insert_id($conn);

                    $user_activity = "Add Service";
                    $details = "Added service named '$name', id '$service_id'";
                    include '../log.php';

                    echo "<script language='javascript'>";
                    echo 'alert("' . $name . ' is successfully added!");';
                    echo 'window.location.replace("../../services.php?addservice=success");';
                    echo "</script>";
                    exit();
                }
            } else {
                echo "<script language='javascript'>";
                echo 'alert(" Something went wrong, Please try again later");';
                echo 'window.location.replace("../..//services.php?addservice=failed");';
                echo "</script>";
            }
        } else {
            echo "<script language='javascript'>";
            echo 'alert("Please enter a valid service name");';
            echo 'window.location.replace("../../services.php?addservice=failed");';
            echo "</script>";
        }
    }
} else {
    echo "<script language='javascript'>";
    echo 'alert("Something went wrong, Please try again later");';
    echo 'window.location.replace("../../services.php?addservice=failed");';
    echo "</script>";
}
