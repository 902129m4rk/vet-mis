<?php
require_once 'includes/config.php';

// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}

if (isset($_GET['id'])) {
    unset($_SESSION['pointofsale']);
    $tid = mysqli_real_escape_string($conn, $_GET['id']);

    $sql = "SELECT *
    FROM transaction AS tr
    LEFT JOIN transaction_details AS td
    ON td.transaction_details_no = tr.transaction_details_no
    LEFT JOIN owner AS o
    ON o.id = tr.client_id
    LEFT JOIN patient AS p
    ON p.id= tr.patient_id
    INNER JOIN company_info
    WHERE tr.trans_id= '$tid'
    ";

    $result = mysqli_query($conn, $sql);

    $fetch = mysqli_fetch_assoc($result);

    // $petid = $fetch['id'];
    // $log = "View patient id '$petid' ";
    // include 'includes/log.php';
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/logo.png">
    <title>Transaction Information </title>

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
        $page = 'transaction';
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

                    <h5 class="navbar-header-text"> <?php if (($fetch['trans_id']) <= 9) {
                                                        echo 'TRNS-0000', $fetch['trans_id'];
                                                    } elseif (($fetch['trans_id']) <= 99) {
                                                        echo 'TRNS-000', $fetch['trans_id'];
                                                    } elseif (($fetch['trans_id']) <= 999) {
                                                        echo 'TRNS-00', $fetch['trans_id'];
                                                    } elseif (($fetch['trans_id']) <= 9999) {
                                                        echo 'TRNS-0', $fetch['trans_id'];
                                                    } else {
                                                        echo 'TRNS-00-', $fetch['trans_id'];
                                                    }  ?></h5>

                    <?php include 'includes/top_navbar.php'; ?>
                </nav>

                <!--MAIN CONTENT-->
                <div class="container-fluid printbg">

                    <?php if ($fetch) : ?>

                        <div class="row mb-3 my-flex-card">
                            <div class="col">
                                <div class="shadow card mb-3" style="background-color: white;">
                                    <div class="card-header py-3 printccs">
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                                <p class="text-primary m-0 font-weight-normal"> <?php if (($fetch['trans_id']) <= 9) {
                                                                                                    echo 'TRNS-0000', $fetch['trans_id'];
                                                                                                } elseif (($fetch['trans_id']) <= 99) {
                                                                                                    echo 'TRNS-000', $fetch['trans_id'];
                                                                                                } elseif (($fetch['trans_id']) <= 999) {
                                                                                                    echo 'TRNS-00', $fetch['trans_id'];
                                                                                                } elseif (($fetch['trans_id']) <= 9999) {
                                                                                                    echo 'TRNS-0', $fetch['trans_id'];
                                                                                                } else {
                                                                                                    echo 'TRNS-00-', $fetch['trans_id'];
                                                                                                }  ?> </p>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                                <div class=" float-lg-right float-md-right float-xl-right float-md-right float-sm-right float-right">
                                                    <?php
                                                    $sql = "SELECT * FROM inventory";

                                                    $result = mysqli_query($conn, $sql);

                                                    $addservice = mysqli_fetch_assoc($result);
                                                    ?>
                                                    <button class="btn btn-primary text-light btn-sm " data-toggle="modal" type="button" data-target="#add_transaction" data-toggle-title="tooltip" data-placement="bottom" title="Add Transaction">
                                                        <i class="fa fa-plus"> </i>
                                                        <span class="mobile-icon-only">Add Transaction</span>
                                                    </button>
                                                    <?php include 'includes/modal/transaction_add_new_transac_in_client.php'; ?>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="card-body ">
                                        <div class="row mt-3">
                                            <div class="col-6">
                                                <div class="row mt-2">
                                                    <div class="col">
                                                        <h5 class="text-primary">CLIENT DETAILS</h5>
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <span> <strong> Client ID: </strong>
                                                        <?php if (($fetch['client_id']) <= 9) {
                                                            echo 'CLNT-000', $fetch['client_id'];
                                                        } elseif (($fetch['client_id']) <= 99) {
                                                            echo 'CLNT-00', $fetch['client_id'];
                                                        } elseif (($fetch['client_id']) <= 999) {
                                                            echo 'CLNT-0', $fetch['client_id'];
                                                        } else {
                                                            echo 'CLNT-', $fetch['client_id'];
                                                        }  ?> </span>
                                                </div>
                                                <div class="row mt-2">
                                                    <span> <strong> Name: </strong>
                                                        <?php echo $fetch['fname'], ' ', $fetch['lname']; ?> </span>
                                                </div>
                                                <div class="row mt-2">
                                                    <span> <strong> Address: </strong>
                                                        <?php echo $fetch['city'], ', ', $fetch['province']; ?> </span>
                                                </div>
                                                <div class="row mt-2">
                                                    <span> <strong> Contact Numer: </strong>
                                                        <?php echo $fetch['contactno']; ?> </span>
                                                </div>
                                            </div>
                                            <?php


                                            if (!empty($fetch['patient_id'])) { ?>
                                                <div class="col-6">
                                                    <div class="row mt-2">
                                                        <div class="col">
                                                            <h5 class="text-primary">PATIENT DETAILS</h5>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <span> <strong> Patient ID: </strong>

                                                            <?php if (($fetch['patient_id']) <= 9) {
                                                                // echo 'PTNT-0', $fetch['id'];
                                                                echo 'PTNT-000', $fetch['patient_id'];
                                                            } elseif (($fetch['patient_id']) <= 99) {
                                                                echo 'PTNT-00', $fetch['patient_id'];
                                                            } elseif (($fetch['patient_id']) <= 999) {
                                                                echo 'PTNT-0', $fetch['patient_id'];
                                                            } else {
                                                                echo 'PTNT-', $fetch['patient_id'];
                                                            }  ?> </span>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <span> <strong> Name: </strong>
                                                            <?php echo $fetch['name']; ?> </span>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <span> <strong> Species </strong>
                                                            <?php echo $fetch['species']; ?> </span>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <span> <strong> Gender: </strong>
                                                            <?php echo $fetch['gender']; ?> </span>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <div class="row mt-5">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th width="8%">Quantity</th>
                                                            <th width="20%">Price</th>
                                                            <th width="20%">Subtotal</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $sql = "SELECT *
                                                               FROM transaction AS tr
                                                               INNER JOIN transaction_details AS td
                                                               ON td.transaction_details_no = tr.transaction_details_no
                                                                WHERE tr.trans_id= '$tid'
                                                               ";
                                                        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                                                        while ($row = mysqli_fetch_assoc($result)) {

                                                            $Sub = number_format(($row['quantity'] * $row['price']), 2);
                                                            $price =  number_format($row['price'], 2);

                                                            echo '<tr>';
                                                            echo '<td>' . $row['products'] . '</td>';
                                                            echo '<td>' . $row['quantity'] . '</td>';
                                                            echo '<td>₱ ' . $price . '</td>';
                                                            echo '<td>₱ ' . $Sub . '</td>';
                                                            echo '</tr> ';
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="row mt-3 mb-5">
                                            <div class="col-12">
                                                <div class="row mt-2">
                                                    <span> <strong> Total: </strong>
                                                        ₱ <?php echo number_format($fetch['grand_total'], 2); ?> </span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                </div>
            <?php else :  ?>

                <h5 class="text-center"> No such transaction exists :( </h5>
                <div class="text-center mt-4">
                    <a class="btn btn-primary text-light " type="button" href="transaction_list.php">
                        <span class="">Go to Transaction List</span>
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
                // processing: true,
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