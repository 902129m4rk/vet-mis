<?php
include 'includes/config.php';

// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}

if (isset($_GET['id'])) {

    $transactionno = $_GET['id'];

    $sql = "SELECT * FROM transaction AS t
    LEFT JOIN test_result AS tr
    ON tr.transaction_no = t.trans_id
    LEFT JOIN lab_tests_details AS ltb
    ON ltb.lab_test_details_id = tr.lab_test_id
    LEFT JOIN pet AS p
    ON p.id= t.pet_id
    INNER JOIN company_info AS ci
    LEFT JOIN city_municipality AS cm
    ON cm.id = ci.city
    LEFT JOIN province AS prov
    ON prov.id = ci.province
    WHERE tr.transaction_no = '$transactionno';
    ";


    $result = mysqli_query($conn, $sql);

    $fetch = mysqli_fetch_assoc($result);

    $provider = $fetch['provider_empid'];
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/logo.png">
    <title>Lab Test Information </title>

    <!-- Bootstrap CSS CDN latest-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css" integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK" crossorigin="anonymous">
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.min.js" integrity="sha384-5h4UG+6GOuV9qXh6HqOLwZMY4mnLPraeTrjT5v07o347pj6IkfuoASuGBhfDsp3d" crossorigin="anonymous"></script> -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>


    <!--from bootstrap old-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js " integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1 " crossorigin="anonymous "></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js " integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM " crossorigin="anonymous "></script>


    <!--FONT AWESOME-->
    <link rel="stylesheet" href="path/to/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">

    <!-- OUR CUSTOM CSS-->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/tb.css">
    <link rel="stylesheet" href="css/form.css">
    <link rel="stylesheet" type="text/css" href="css/print.css" media="print">


</head>

<body>
    <div class="wrapper ">

        <?php
        $page = '';
        include 'includes/sidebar.php';
        ?>

        <div class="d-flex flex-column" id="content-wrapper">
            <!--CONTENT-->
            <div class="content">

                <!--TOP NAVBAR/ HEADER-->
                <nav class="navbar navbar-expand-lg navbar-light bg-light top-header printccs">
                    <button type="button" id="sidebarCollapse" class="btn menu-btn">
                        <i class="fa fa-align-justify"> </i>
                    </button>

                    <h5 class="navbar-header-text">Lab Test Information</h5>

                    <?php include 'includes/top_navbar.php'; ?>
                </nav>

                <!--MAIN CONTENT-->
                <div class="container-fluid printbg">

                    <?php if ($fetch) : ?>

                        <div class="row mb-3 my-flex-card">
                            <div class="col">
                                <!-- <div class="card shadow mb-3"> -->
                                <div class="no-shadow no-border mb-3" style="background-color: white;">
                                    <div class="card-header py-3 printccs">
                                        <p class="text-primary m-0 font-weight-normal"> Lab Test Result
                                        </p>
                                    </div>
                                    <div class="card-body ">
                                        <div class="row mt-3 mb-3">
                                            <div class="col text-right">
                                                <button onclick="window.print()" class="btn btn-primary printccs" data-toggle-title="tooltip" data-placement="bottom" title="Print">
                                                    <i class="fa fa-print"></i>
                                                    <span class="mobile-icon-only">Print</span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="row">
                                                    <div class="col">
                                                        <h2> <?php echo strtoupper($fetch['clinic_name']); ?> </h2>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <span> <strong> Address: </strong>
                                                        <?php echo $fetch['citymunicipality_name'], ', ', $fetch['province_name']; ?>
                                                </div>
                                                <div class="row">
                                                    <span> <strong> Contact Number: </strong>
                                                        <?php echo $fetch['clinic_contactno']; ?> </span>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="row">
                                                    <div class="col text-right">
                                                        <h2 class="text-primary">LAB TEST</h2>

                                                    </div>
                                                </div>
                                                <div class="row text-right">
                                                    <div class="col">
                                                        <span>
                                                            <strong> Lab Test Number: </strong>
                                                            <?php echo 'LBT-', $fetch['test_no']; ?>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="row text-right">
                                                    <div class="col">
                                                        <span> <strong> Date: </strong>
                                                            <!-- <?php
                                                                    $source = htmlspecialchars($fetch['date_created']);
                                                                    $date = new DateTime($source);
                                                                    echo $date->format('m-d-Y'); // 31-07-2012
                                                                    ?> </span> -->
                                                            <?php
                                                            $source = htmlspecialchars($fetch['date_created']);
                                                            $date = new DateTime($source);
                                                            echo $date->format('F d\, Y'); // 31-07-2012
                                                            ?> </span>

                                                    </div>
                                                </div>

                                            </div>

                                        </div>

                                        <div class="row mt-4">
                                            <div class="col">
                                                <h5 class="text-primary">PET DETAILS</h5>
                                            </div>

                                        </div>
                                        <?php if ($fetch['name'] == 'A Walk-in Patient' or $fetch['name'] == 'A Walk-in Pet' or $fetch['name'] == 'A Walk-in') { ?>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="row">
                                                        <span> <strong> Name: </strong>
                                                            <?php echo $fetch['name']; ?> </span>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="row mt-2">
                                                <div class="col-6">
                                                    <div class="row">
                                                        <span> <strong> Pet ID: </strong>

                                                            <?php if (($fetch['pet_id']) <= 9) {
                                                                echo 'PT-000', $fetch['pet_id'];
                                                            } elseif (($fetch['pet_id']) <= 99) {
                                                                echo 'PT-00', $fetch['pet_id'];
                                                            } elseif (($fetch['pet_id']) <= 999) {
                                                                echo 'PT-0', $fetch['pet_id'];
                                                            } else {
                                                                echo 'PT-', $fetch['pet_id'];
                                                            }  ?> </span>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="row">
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
                                                            }
                                                            ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="row">
                                                        <span> <strong> Name: </strong>
                                                            <?php echo $fetch['name']; ?> </span>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <span> <strong> Gender: </strong>
                                                        <?php echo $fetch['gender']; ?> </span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <span> <strong> Species: </strong>
                                                        <?php echo $fetch['species']; ?> </span>
                                                </div>
                                                <?php if (!empty($fetch['breed'])) { ?>
                                                    <div class="col-6">
                                                        <span> <strong> Breed: </strong>
                                                            <?php echo $fetch['breed']; ?> </span>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        <?php } ?>

                                        <?php
                                        $samelabtest_no  = $fetch['test_no'];

                                        $sql2 = "SELECT *
                                        FROM transaction AS t
                                        LEFT JOIN transaction_details AS td
                                        ON td.transaction_details_no = t.transaction_details_no
                                        LEFT JOIN owner AS o
                                        ON o.id = t.pet_owner_id
                                        LEFT JOIN pet AS p
                                        ON p.id= t.pet_id
                                        LEFT JOIN test_group AS tg
                                        ON tg.test_group_name = td.products
                                        LEFT JOIN test_result AS tr
                                        ON tr.pet_id = p.id
                                        LEFT JOIN lab_tests_details AS ltd
                                        ON ltd.lab_test_details_id = tr.lab_test_id 

                                        WHERE tr.transaction_no = '$transactionno'
                                        AND invoice_type = 'Laboratory' 
                                        AND tr.test_no = '$samelabtest_no'
                                        AND products = ltd.test_group

                                        GROUP BY test_group_name
                                    ORDER by `test_group_name` ASC
                                        ";

                                        $result2 = mysqli_query($conn, $sql2);

                                        while ($fetchy = mysqli_fetch_assoc($result2)) {
                                            $fetchtg = $fetchy['products']; ?>
                                            <div class="row mt-3 mb-2">
                                                <div class="col-12">
                                                    <h5 class="text-danger text-center">
                                                        <?php echo strtoupper($fetchy['products']); ?>
                                                    </h5>
                                                </div>
                                            </div>


                                            <?php
                                            $sqllab = "SELECT * FROM transaction AS t
                                        LEFT JOIN test_result AS tr
                                        ON tr.transaction_no = t.trans_id
                                        LEFT JOIN lab_tests_details AS ltb
                                        ON ltb.lab_test_details_id = tr.lab_test_id
                                        LEFT JOIN pet AS p
                                        ON p.id= t.pet_id
                                        LEFT JOIN users AS u
                                        ON u.empid = tr.provider_empid
                                        WHERE test_group = '$fetchtg'
                                        AND tr.transaction_no = '$transactionno';";

                                            $resultlab = mysqli_query($conn, $sqllab);
                                            ?>

                                            <div class="row rows-print-as-pages print">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-hover table-sm" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Test Name</thwidth=>
                                                                <th>Result</th>
                                                                <th>Reference Value</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php

                                                            while ($row = mysqli_fetch_array($resultlab)) {

                                                                $provider = $row['provider_empid'];
                                                            ?>

                                                                <tr>
                                                                    <td> <?php echo $row['test_name']; ?> </td>
                                                                    <td> <?php echo $row['result']; ?> </td>
                                                                    <?php if (empty($row['unit'])) { ?>
                                                                        <td> <?php echo $row['normal_min'], ' - ', $row['normal_max'] ?> </td>
                                                                    <?php } else { ?>
                                                                        <td> <?php echo $row['normal_min'], ' - ', $row['normal_max'], ' ', $row['unit']; ?> </td>
                                                                    <?php } ?>
                                                                </tr>

                                                            <?php
                                                            } ?>
                                                        </tbody>
                                                    </table>


                                                </div>
                                            </div>
                                        <?php } ?>
                                        <?php
                                        $sql3 = "SELECT *
                                     FROM users AS u
                                     LEFT JOIN test_result AS tr
                                        ON tr.provider_empid = u.empid
                                        WHERE u.empid = '$provider';
                                     ";

                                        $result3 = mysqli_query($conn, $sql3);

                                        $fetch3 = mysqli_fetch_assoc($result3)

                                        ?>
                                        <div class="row mt-4">
                                            <div class="col-8">
                                            </div>
                                            <div class="col-4 text-center">
                                                <span>
                                                    <?php echo $fetch3['user_fname'], ' ', $fetch3['user_lname']; ?>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="row mt-2 mb-5">
                                            <div class="col-8">
                                            </div>
                                            <div class="col-4 text-center">
                                                <span>
                                                    <strong> VETERINARIAN </strong>
                                                </span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                </div>
            <?php else :  ?>

                <h5 class="text-center"> No such lab test result exists :( </h5>
                <div class="text-center mt-4">
                    <a class="btn btn-primary text-light " type="button" href="dashboard.php">
                        <span class="">Go to Back to Dashboard</span>
                    </a>
                </div>
            <?php endif;    ?>
            </div>

            <?php include 'includes/footer.php'; ?>

        </div>


        <!--Icon-->
        <script src="https://unpkg.com/ionicons@5.2.3/dist/ionicons.js "></script>
        <!--OUR JS-->
        <script src="js/script.js "></script>
        <!-- DATA TABLE -->
        <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"> </script>
        <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"> </script>

        <script>
            $('#dataTable').dataTable({
                processing: true,
                // serverSide: true,
                // ajax: "patient_list.inc.php",
                lengthMenu: [10, 5, 10, 25, 50, 100],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search"
                },
                //Disable Action sorting (yung arrow up and down)
                columnDefs: [{
                    'targets': [1],
                    /* column index */
                    'orderable': false,
                    /* true or false */
                }]
            });
        </script>
</body>

</html>