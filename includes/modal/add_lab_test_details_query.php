<?php
require_once '../config.php';
session_start();
if (isset($_POST['add'])) {
    // $id = filter_input(INPUT_POST, 'id');

    //Lab Details
    $testname = ucfirst(filter_input(INPUT_POST, 'test_name'));
    $testgroup = filter_input(INPUT_POST, 'test_group');
    $testunit = filter_input(INPUT_POST, 'test_unit');
    $normalmin = filter_input(INPUT_POST, 'normal_min');
    $normalmax = filter_input(INPUT_POST, 'normal_max');
    $status = 'Active';

    // REGEX/ FORM VALIDATION


    if (empty($testunit)) {
        $sql = "INSERT INTO lab_tests_details(test_group ,test_name, normal_min, normal_max, lab_details_status) VALUES (?,?,?,?,?);";
        $stmt = mysqli_stmt_init($conn);

        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, "sssss",  $testgroup, $testname,  $normalmin, $normalmax, $status);

            if (mysqli_stmt_execute($stmt)); {
                $labtestdetails_id = mysqli_insert_id($conn);

                $user_activity = "Add lab test details";
                $details = "Added Lab test details named '$testname', id '$labtestdetails_id'";
                include '../log.php';

                echo "<script language='javascript'>";
                echo 'alert("' .  $testname . ' is successfully added!");';
                echo 'window.location.replace("../../lab_setting.php?addlabtestdetails=success");';
                echo "</script>";
            }
        } else {
            echo "<script language='javascript'>";
            echo 'alert(" Something went wrong, Please try again later");';
            echo 'window.location.replace("../../lab_setting.php?addlabtestdetails=failed");';
            echo "</script>";
        }
    } else {

        $sql = "INSERT INTO lab_tests_details(test_group ,test_name, normal_min, normal_max, unit, lab_details_status) VALUES (?,?,?,?,?,?);";
        $stmt = mysqli_stmt_init($conn);

        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssssss",  $testgroup, $testname,  $normalmin, $normalmax, $testunit, $status);

            if (mysqli_stmt_execute($stmt)); {
                $labtestdetails_id = mysqli_insert_id($conn);

                $user_activity = "Add lab test details";
                $details = "Added Lab test details named '$testname', id '$labtestdetails_id'";
                include '../log.php';

                echo "<script language='javascript'>";
                echo 'alert("' .  $testname . ' is successfully added!");';
                echo 'window.location.replace("../../lab_setting.php?addlabtestdetails=success");';
                echo "</script>";
            }
        } else {
            echo "<script language='javascript'>";
            echo 'alert(" Something went wrong, Please try again later");';
            echo 'window.location.replace("../../lab_setting.php?addlabtestdetails=failed");';
            echo "</script>";
        }
    }
} else {
    echo "<script language='javascript'>";
    echo 'alert("Something went wrong, Please try again later");';
    echo 'window.location.replace("../../lab_setting.php?addlabtestdetails=failed");';
    echo "</script>";
}
