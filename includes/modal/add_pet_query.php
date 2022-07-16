<?php
require_once '../config.php';
session_start();
if (isset($_POST['add'])) {
    $id = filter_input(INPUT_POST, 'id');

    //Pet
    $petname = ucfirst(filter_input(INPUT_POST, 'pet_name'));
    $petgender = ucfirst(filter_input(INPUT_POST, 'pet_gender'));
    $petbirthday = filter_input(INPUT_POST, 'pet_bday');
    $petweight = filter_input(INPUT_POST, 'pet_weight');
    $petspecies = ucfirst(filter_input(INPUT_POST, 'pet_species'));
    $petbreed = ucfirst(filter_input(INPUT_POST, 'pet_breed'));
    $vitalitystatus =  'Alive';

    //Regular Expression Variable
    $regexpetname = "/^[a-zA-Z0-9\d\s\.\-]+$/";
    $regexname = "/^[a-zA-Z\s\,\-]+$/";

    //FETCH PET OWNER NAME
    $logquerypetowner = "SELECT * FROM owner WHERE id ='$id';";
    $logsqlpetowner = mysqli_query($conn, $logquerypetowner);
    $logfetchpetownertb = mysqli_fetch_assoc($logsqlpetowner);
    $logpetownerfname = $logfetchpetownertb['fname'];
    $logpetownerlname = $logfetchpetownertb['lname'];

    if (preg_match($regexpetname, $petname)) {
        if (!empty($petbreed)) {
            if (preg_match($regexname, $petbreed)) {
                $sql = "INSERT INTO pet(name, gender, bday, weight, species, breed, vitality_status) VALUES (?,?,?,?,?,?,?);";

                $stmt = mysqli_stmt_init($conn);

                if (mysqli_stmt_prepare($stmt, $sql)) {
                    mysqli_stmt_bind_param($stmt, "sssssss", $petname, $petgender, $petbirthday,  $petweight, $petspecies, $petbreed, $vitalitystatus);
                    if (mysqli_stmt_execute($stmt)); {
                        $pet_id = mysqli_insert_id($conn);

                        $sql3 = "INSERT INTO pet_owner(owner_id, pet_id) VALUES (?,?);";
                        $stmt3 = mysqli_stmt_init($conn);

                        if (mysqli_stmt_prepare($stmt3, $sql3)) {

                            $user_activity = "Add Pet";
                            $details = "Added pet named '$petname', id '$pet_id' for pet owner named '$logpetownerfname $logpetownerlname', id '$id';";
                            include '../log.php';

                            mysqli_stmt_bind_param($stmt3, "ii",  $id, $pet_id);

                            mysqli_stmt_execute($stmt3);
                            echo "<script language='javascript'>";
                            echo 'alert("' . $petname . ' is successfully added!");';
                            echo 'window.location.replace("../../pet_owner_information.php?id=' . $id . '");';
                            echo "</script>";
                            exit();
                        } else {
                            echo "<script language='javascript'>";
                            echo 'alert("Something went wrong,Please try again later");';
                            echo 'window.location.replace("../../dashboard.php?addpet=failed");';
                            echo "</script>";
                            exit();
                        }
                    }
                } else {
                    echo "<script language='javascript'>";
                    echo 'alert(" Something went wrong, Please try again later");';
                    echo 'window.location.replace("../../pet_owner_information.php?id=' . $id . '");';
                    echo "</script>";
                    exit();
                }
            } else {
                echo "<script language='javascript'>";
                echo 'alert("Please enter a valid breed name");';
                echo 'window.location.replace("../../pet_list.php?updatepet=failed");';
                echo "</script>";
            }
        } else {
            $sql = "INSERT INTO pet(name, gender, bday, weight, species, vitality_status) VALUES (?,?,?,?,?,?);";

            $stmt = mysqli_stmt_init($conn);

            if (mysqli_stmt_prepare($stmt, $sql)) {
                mysqli_stmt_bind_param($stmt, "ssssss", $petname, $petgender, $petbirthday, $petweight, $petspecies, $vitalitystatus);
                if (mysqli_stmt_execute($stmt)); {
                    $pet_id = mysqli_insert_id($conn);

                    $sql3 = "INSERT INTO pet_owner(owner_id, pet_id) VALUES (?,?);";
                    $stmt3 = mysqli_stmt_init($conn);

                    if (mysqli_stmt_prepare($stmt3, $sql3)) {
                        $user_activity = "Add Pet";
                        $details = "Added pet named '$petname', id '$pet_id' for pet owner named '$logpetownerfname $logpetownerlname', id '$id';";
                        include '../log.php';

                        mysqli_stmt_bind_param($stmt3, "ii",  $id, $pet_id);

                        mysqli_stmt_execute($stmt3);
                        echo "<script language='javascript'>";
                        echo 'alert("' . $petname . ' is successfully added!");';
                        echo 'window.location.replace("../../pet_owner_information.php?id=' . $id . '");';
                        echo "</script>";
                        exit();
                    } else {
                        echo "<script language='javascript'>";
                        echo 'alert("Something went wrong,Please try again later");';
                        echo 'window.location.replace("../../dashboard.php?addpet=failed");';
                        echo "</script>";
                        exit();
                    }
                }
            } else {
                echo "<script language='javascript'>";
                echo 'alert(" Something went wrong, Please try again later");';
                echo 'window.location.replace("../../pet_owner_information.php?id=' . $id . '");';
                echo "</script>";
                exit();
            }
        }
    } else {
        echo "<script language='javascript'>";
        echo 'alert("Please enter a valid pet name");';
        echo 'window.location.replace("../../pet_owner_information.php?id=' . $id . '");';
        echo "</script>";
        exit();
    }
} else {
    echo "<script language='javascript'>";
    echo 'alert(" Something went wrong, Please try again later");';
    echo 'window.location.replace("../../pet_owner_information.php?id=' . $id . '");';
    echo "</script>";
    exit();
}
mysqli_close($stmt3);
