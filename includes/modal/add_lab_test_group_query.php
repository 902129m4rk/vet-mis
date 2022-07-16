<?php
require_once '../config.php';

session_start();
if (isset($_POST['add'])) {
    $id = filter_input(INPUT_POST, 'id');

    //Lab Test Group
    $testgroupname = ucfirst(filter_input(INPUT_POST, 'test_group_name'));
    $cost = filter_input(INPUT_POST, 'tg_cost');
    $status = 'Active';

    // REGEX/ FORM VALIDATION
    $regexname = "/^[a-zA-Z\s\,\-\(\)\/]+$/";

    $sql = "SELECT * FROM test_group WHERE test_group_name = '$testgroupname'";
    $query = mysqli_query($conn, $sql);

    if (mysqli_num_rows($query) > 0) {
        echo "<script language='javascript'>";
        echo 'alert("Sorry, this test group name is already existed. Please try another name");';
        echo 'window.location.replace("../../lab_test_group.php?addlabtestgroup=failed");';
        echo "</script>";
    } else {

        if (preg_match($regexname, $testgroupname)) {
            $sql = "INSERT INTO test_group(test_group_name, price,status) VALUES (?,?,?);";
            $stmt = mysqli_stmt_init($conn);

            if (mysqli_stmt_prepare($stmt, $sql)) {
                mysqli_stmt_bind_param($stmt, "sss",  $testgroupname, $cost, $status);

                if (mysqli_stmt_execute($stmt)); {
                    $tg_id = mysqli_insert_id($conn);

                    $user_activity = "Add Test Group";
                    $details = "Added test group named '$testgroupname', id '$tg_id'";
                    include '../log.php';

                    echo "<script language='javascript'>";
                    echo 'alert("' .   $testgroupname . ' is successfully added!");';
                    echo 'window.location.replace("../../lab_test_group.php?addlabtestgroup=success");';
                    echo "</script>";
                    exit();
                }
            } else {
                echo "<script language='javascript'>";
                echo 'alert(" Something went wrong, Please try again later");';
                echo 'window.location.replace("../../lab_test_group.php?addlabtestgroup=failed");';
                echo "</script>";
            }
        } else {
            echo "<script language='javascript'>";
            echo 'alert("Please enter a valid test group name");';
            echo 'window.location.replace("../../lab_test_group.php?addlabtestgroup=failed");';
            echo "</script>";
        }
    }
} else {
    echo "<script language='javascript'>";
    echo 'alert("Something went wrong, Please try again later");';
    echo 'window.location.replace("../../lab_test_group.php?addlabtestgroup=failed");';
    echo "</script>";
}
