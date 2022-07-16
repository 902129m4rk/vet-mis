<?php
require_once '../config.php';
session_start();
if (isset($_POST['add'])) {
    $id = filter_input(INPUT_POST, 'id');

    //Species Name
    $name = ucfirst(filter_input(INPUT_POST, 'species_name'));
    $status = 'Active';

    // REGEX/ FORM VALIDATION
    $regexname = "/^[a-zA-Z\s\,\-]+$/";

    $sql = "SELECT * FROM species WHERE name = '$name'";
    $query = mysqli_query($conn, $sql);

    if (mysqli_num_rows($query) > 0) {
        echo "<script language='javascript'>";
        echo 'alert("Sorry, this species name is already existed. Please try another name");';
        echo 'window.location.replace("../../species.php?addspecies=failed");';
        echo "</script>";
    } else {
        if (preg_match($regexname, $name)) {
            $sql = "INSERT INTO species(name, status) VALUES (?,?);";
            $stmt = mysqli_stmt_init($conn);

            if (mysqli_stmt_prepare($stmt, $sql)) {
                mysqli_stmt_bind_param($stmt, "ss",  $name, $status);

                if (mysqli_stmt_execute($stmt)); {
                    $species_id = mysqli_insert_id($conn);

                    $user_activity = "Add Species";
                    $details = "Added species named '$name', id '$species_id'";
                    include '../log.php';

                    echo "<script language='javascript'>";
                    echo 'alert("' . $name . ' is successfully added!");';
                    echo 'window.location.replace("../../species.php?addspecies=success");';
                    echo "</script>";
                }
            } else {
                echo "<script language='javascript'>";
                echo 'alert(" Something went wrong, Please try again later");';
                echo 'window.location.replace("../../species.php?addspecies=failed");';
                echo "</script>";
            }
        } else {
            echo "<script language='javascript'>";
            echo 'alert("Please enter a valid species name");';
            echo 'window.location.replace("../../species.php?addspecies=failed");';
            echo "</script>";
        }
    }
} else {
    echo "<script language='javascript'>";
    echo 'alert("Something went wrong, Please try again later");';
    echo 'window.location.replace("../../species.php?addspecies=failed");';
    echo "</script>";
}
