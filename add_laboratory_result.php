<?php
require_once 'includes/config.php';

// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}
?>
<?php
if (isset($_POST['submit'])) {

    //Pet
    $petid = filter_input(INPUT_POST, 'pet_id');
    $transaction_no = $_POST['transaction_no'];
    $result = $_POST['result'];
    $labtestid = $_POST['labtestid'];
    $labtesstatus = "Success";
    $transdetailsid = $_POST['transdetailsid'];

    $provider = $_SESSION["empid"];

    if (($petid) <= 9) {
        $petidmessage = 'PT-000';
        $petidmessage .= $petid;
    } elseif (($petid) <= 99) {
        $petidmessage = 'PT-00';
        $petidmessage .= $petid;
    } elseif (($petid) <= 999) {
        $petidmessage = 'PT-0';
        $petidmessage .= $petid;
    } else {
        $petidmessage = 'PT-';
        $petidmessage .= $petid;
    }

    //FETCH PET NAME
    $logquerypet = "SELECT * FROM pet WHERE id ='$petid';";
    $logsqlpet = mysqli_query($conn, $logquerypet);
    $logfetchpettb = mysqli_fetch_assoc($logsqlpet);
    $logpetname = $logfetchpettb['name'];

    date_default_timezone_set('Asia/Manila');
    $samelabtest = date("mdY");

    $samelabtest .= $transaction_no;

    foreach (array_combine($labtestid, $result) as $labtestidd => $resultt) {

        $sql = "INSERT INTO test_result(test_no, provider_empid, pet_id, lab_test_id, result, transaction_no, date_created) VALUES ($samelabtest, $provider,  $petid, $labtestidd, $resultt, $transaction_no, NOW());";
        mysqli_query($conn, $sql);
    }
    $user_activity = "Add Lab Test";
    $details = "Add lab test number '$samelabtest' for pet named '$logpetname', id '$petid'";
    include 'includes/log.php';

    // unset($_SESSION['pointofsale']);
    echo "<script language='javascript'>";
    echo 'alert("Adding lab test for ' . $logpetname . ' was successful");';
    echo 'window.location.replace("lab_test_result_information.php?id=' . $transaction_no . '");';
    echo "</script>";
}
?>
<?php
if (isset($_GET['id'])) {

    $tid = mysqli_real_escape_string($conn, $_GET['id']);


    $sql = "SELECT *
    FROM transaction AS t
    LEFT JOIN transaction_details AS td
    ON td.transaction_details_no = t.transaction_details_no
    LEFT JOIN owner AS o
    ON o.id = t.pet_owner_id
    LEFT JOIN pet AS p
    ON p.id= t.pet_id
    LEFT JOIN test_group AS tg
    ON tg.test_group_name = td.products
    -- WHERE td.transaction_details_id = '$tid'
    WHERE t.trans_id = $tid;
    ";

    $result = mysqli_query($conn, $sql);
    $fetch = mysqli_fetch_assoc($result);

    $tdnumber =  $fetch['transaction_details_no'];
    $labchoice = $fetch['products'];
    $transid = $fetch['trans_id'];
    $transdetailsid = $fetch['transaction_details_id'];
    $labinvoice = $fetch['invoice_type'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/logo.png">
    <title>Add Laboratory Result </title>

    <!-- Bootstrap CSS CDN -->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">

    <!--FONT AWESOME-->
    <link rel="stylesheet" href="path/to/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">

    <!-- OUR CUSTOM CSS-->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/form.css">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css">

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

    <!-- (Optional) Latest compiled and minified JavaScript translation files -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/i18n/defaults-*.min.js"></script> -->



</head>

<body>
    <div class="wrapper ">

        <?php
        $page = 'lab';
        include 'includes/sidebar.php';
        ?>

        <div class="d-flex flex-column" id="content-wrapper">
            <!--CONTENT-->
            <div class="content">

                <!--TOP NAVBAR/ HEADER-->
                <nav class="navbar navbar-expand-lg navbar-light bg-light top-header">
                    <button type="button" id="sidebarCollapse" class="btn menu-btn">
                        <i class="fa fa-align-justify"> </i>
                    </button>
                    <h5 class="navbar-header-text">Add Laboratory Result</h5>
                    <?php include 'includes/top_navbar.php'; ?>
                </nav>

                <!--MAIN CONTENT-->
                <div class="container-fluid">
                    <?php if ($labinvoice = 'Laboratory') : ?>
                        <div class="row mb-3 my-flex-card">
                            <div class="col">
                                <div class="row">
                                    <div class="col">
                                        <div class="card shadow mb-3">
                                            <div class="card-header py-3">
                                                <p class="text-primary m-0 font-weight-normal">Input Lab Test Result</p>
                                            </div>
                                            <div class="card-body">

                                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                                    <div class="row mt-2">
                                                        <div class="col">
                                                            <h5 class="text-primary">PET DETAILS</h5>
                                                        </div>
                                                    </div>
                                                    <?php if ($fetch['name'] == 'A Walk-in Patient' or $fetch['name'] == 'A Walk-in Pet' or $fetch['name'] == 'A Walk-in') { ?>

                                                        <div class="row mt-2">
                                                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                                                <span> <strong> Name: </strong>
                                                                    <?php echo $fetch['name']; ?> </span>
                                                                <input type="hidden" name="pet_name" value="<?php echo $fetch['name']; ?>">
                                                                <input type="hidden" name="pet_id" value="<?php echo $fetch['pet_id']; ?>">
                                                            </div>
                                                        </div>
                                                    <?php } else { ?>
                                                        <div class="row mt-2">
                                                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                                                <span> <strong> Pet ID: </strong>

                                                                    <?php if (($fetch['pet_id']) <= 9) {
                                                                        // echo 'PTNT-0', $fetch['id'];
                                                                        echo 'PT-000', $fetch['pet_id'];
                                                                    } elseif (($fetch['pet_id']) <= 99) {
                                                                        echo 'PT-00', $fetch['pet_id'];
                                                                    } elseif (($fetch['pet_id']) <= 999) {
                                                                        echo 'PT-0', $fetch['pet_id'];
                                                                    } else {
                                                                        echo 'PT-', $fetch['pet_id'];
                                                                    }  ?> </span>
                                                            </div>
                                                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">

                                                                <span> <strong> Age: </strong>
                                                                    <?php
                                                                    $dateofbirth = $fetch['bday'];
                                                                    $today = date("Y-m-d");
                                                                    $diff = date_diff(date_create($dateofbirth), date_create($today));
                                                                    echo  $diff->format('%y');

                                                                    $age = $diff->format('%y');
                                                                    if ($age > 1) {
                                                                        echo ' years old';
                                                                    } else {
                                                                        echo ' year old';
                                                                    }  ?>
                                                                </span>

                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                                                <span> <strong> Name: </strong>
                                                                    <?php echo $fetch['name']; ?> </span>
                                                                <input type="hidden" name="pet_name" value="<?php echo $fetch['name']; ?>">
                                                                <input type="hidden" name="pet_id" value="<?php echo $fetch['pet_id']; ?>">
                                                            </div>
                                                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                                                <span class="mt-"> <strong> Gender: </strong>
                                                                    <?php echo $fetch['gender']; ?> </span>

                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                                                <span> <strong> Species </strong>
                                                                    <?php echo $fetch['species']; ?> </span>
                                                            </div>
                                                            <?php if (!empty($fetch['breed'])) { ?>
                                                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                                                    <span> <strong> Species: </strong>
                                                                        <?php echo $fetch['breed']; ?> </span>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    <?php } ?>


                                                    <?php
                                                    $sql3 = "SELECT *
                                                 FROM transaction AS t
                                                 LEFT JOIN transaction_details AS td
                                                 ON td.transaction_details_no = t.transaction_details_no
                                                 LEFT JOIN owner AS o
                                                 ON o.id = t.pet_owner_id
                                                 LEFT JOIN pet AS p
                                                 ON p.id= t.pet_id
                                                 LEFT JOIN test_group AS tg
                                                 ON tg.test_group_name = td.products
                                                 WHERE t.trans_id = $tid AND invoice_type = 'Laboratory' 
                                                 ORDER by `test_group_name` ASC;

                                                 ";

                                                    $result3 = mysqli_query($conn, $sql3);

                                                    while ($fetchy = mysqli_fetch_assoc($result3)) {
                                                        $fetchtg = $fetchy['test_group_name'];
                                                    ?>

                                                        <div class="row mt-4 mb-2">
                                                            <div class="col-12">
                                                                <h5 class="text-danger text-center">
                                                                    <?php echo strtoupper($fetchy['products']); ?>
                                                                </h5>
                                                            </div>
                                                        </div>

                                                        <?php
                                                        $sql2 = "SELECT * FROM lab_tests_details AS ltb
                                                    LEFT JOIN transaction_details AS td
                                                    ON td.products = ltb.test_name
                                                    LEFT JOIN test_group AS tg
                                                    ON tg.test_group_name = ltb.test_name
                                                    WHERE test_group = '$fetchtg'
                                                    AND lab_details_status = 'Active'
                                                    ";
                                                        $query2 = mysqli_query($conn, $sql2);
                                                        ?>

                                                        <div class="table-responsive">
                                                            <table id="dataTable" class="table table-bordered table-hover" style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="align-middle">Test Name </th>
                                                                        <th class="align-middle">Result</th>
                                                                        <th class="align-middle"> Reference Value </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <input type="hidden" name="transaction_no" value="<?php echo $transid; ?>">
                                                                    <input type="hidden" name="transdetailsid" value="<?php echo $transdetailsid; ?>">
                                                                    <?php
                                                                    while ($row = mysqli_fetch_array($query2)) {
                                                                    ?>
                                                                        <tr>

                                                                            <input type="hidden" name="testgroup[]" value="<?php echo $row['test_group']; ?>">
                                                                            <input type="hidden" name="labtestid[]" value="<?php echo $row['lab_test_details_id']; ?>">


                                                                            <td><?php echo $row['test_name']; ?>
                                                                            </td>
                                                                            <td>
                                                                                <div>
                                                                                    <input type="number" min="0" step="0.01" class="form-control" name="result[]" style="min-width:7em">
                                                                                </div>
                                                                            </td>
                                                                            <td><?php echo $row['normal_min'], ' - ', $row['normal_max'], ' ', $row['unit']; ?></td>

                                                                        </tr>
                                                                    <?php

                                                                    }
                                                                    ?>
                                                                </tbody>
                                                            </table>

                                                        </div>

                                                    <?php } ?>
                                                    <div class="mt-3 text-danger ">
                                                        <span> Please make sure all fields are filled in correctly </span>
                                                    </div>
                                                    <div class="form-group ">
                                                        <button class="mt-3 btn btn-primary " type="submit" name="submit">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else :  ?>

                        <h5 class="text-center"> No such lab test exists :( </h5>
                        <div class="text-center mt-4">
                            <a class="btn btn-primary text-light " type="button" href="dashboard.php">
                                <span class="">Go to Back to Dashboard</span>
                            </a>
                        </div>
                    <?php endif;    ?>
                </div>
            </div>
            <?php include 'includes/footer.php'; ?>
        </div>


        <!--Icon-->
        <script src="https://unpkg.com/ionicons@5.2.3/dist/ionicons.js "></script>
        <!--OUR JS-->
        <script src="js/script.js "></script>
        <!--Icon-->
        <script src="https://unpkg.com/ionicons@5.2.3/dist/ionicons.js "></script>
        <!--OUR JS-->
        <script src="js/script.js"></script>
        <!-- SELECT SPECIES AND BREED -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <!-- Note hindi pwede tong ilipat sa ibang folder. Dapat nandito or sa pinakang file talaga to, kasi kapag nilipat hindi gagana ang select breed -->
        <script>
            function getpatient(val) {
                $.ajax({
                    type: "POST",
                    url: "get_patient.php",
                    data: 'patient_id=' + val,
                    success: function(data) {
                        $("#patient-list").html(data);
                    }
                });
            }
        </script>

</body>

</html>