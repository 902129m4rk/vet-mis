<?php
require_once '../config.php';
session_start();

if (isset($_POST['add'])) {
    $id = filter_input(INPUT_POST, 'id');

    //Lab Test Group
    $unit = filter_input(INPUT_POST, 'lab_unit');
    $status = 'Active';

    $sql = "SELECT unit_name FROM units WHERE unit_name = '$unit'";
    $query = mysqli_query($conn, $sql);

    if (mysqli_num_rows($query) > 0) {
        echo "<script language='javascript'>";
        echo 'alert("Sorry, this unit is already existed. Please try another name");';
        echo 'window.location.replace("../../lab_units.php?addunit=failed");';
        echo "</script>";
        exit();
    } else {

        $sql = "INSERT INTO units(unit_name, unit_status) VALUES (?,?);";
        $stmt = mysqli_stmt_init($conn);

        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, "ss",  $unit, $status);

            if (mysqli_stmt_execute($stmt)); {
                $unit_id = mysqli_insert_id($conn);

                $user_activity = "Add Lab Unit";
                $details = "Added unit named '$unit', id '$unit_id '";
                include '../log.php';

                echo "<script language='javascript'>";
                echo 'alert("' .   $unit . ' is successfully added!");';
                echo 'window.location.replace("../../lab_units.php?addunit=success");';
                echo "</script>";
                exit();
            }
        } else {
            echo "<script language='javascript'>";
            echo 'alert(" Something went wrong, Please try again later");';
            echo 'window.location.replace("../../lab_units.php?addunit=failed");';
            echo "</script>";
        }
    }
} else {
    echo "<script language='javascript'>";
    echo 'alert(" Something went wrong, Please try again later");';
    echo 'window.location.replace("../../lab_units.php?addunit=failed");';
    echo "</script>";
}
