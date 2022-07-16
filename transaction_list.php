<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/logo.png">
    <title>Transaction List </title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css" integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.min.js" integrity="sha384-5h4UG+6GOuV9qXh6HqOLwZMY4mnLPraeTrjT5v07o347pj6IkfuoASuGBhfDsp3d" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>

    <!--FONT AWESOME-->
    <link rel="stylesheet" href="path/to/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">

    <!-- OUR CUSTOM CSS-->
    <link rel="stylesheet" href="css/style.css">
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
                <nav class="navbar navbar-expand-lg navbar-light bg-light top-header">
                    <button type="button" id="sidebarCollapse" class="btn menu-btn">
                        <i class="fa fa-align-justify"> </i>
                    </button>

                    <h5 class="navbar-header-text">Transaction List</h5>
                    <?php include 'includes/top_navbar.php'; ?>
                </nav>

                <!--MAIN CONTENT-->
                <div class="container-fluid">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 font-weight-normal">Unpaid Transaction List</p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="dataTable" class="table table-bordered table-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="align-middle">Transaction ID </th>
                                            <th class="align-middle">Pet Owner Name </th>
                                            <!-- <th class="align-middle">Invoice Type</th> -->
                                            <th class="align-middle">Total Amount</th>
                                            <th class="align-middle"> Payment Status </th>
                                            <th class="align-middle">Action </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        require_once 'includes/config.php';
                                        $query2 = mysqli_query($conn, "SELECT *
                                        FROM transaction AS t
                                        INNER JOIN owner AS o
                                        ON o.id=t.pet_owner_id 
                                        WHERE status = 'Unpaid';
                                        ");

                                        while ($fetch = mysqli_fetch_array($query2)) {
                                        ?>
                                            <tr>

                                                <td>
                                                    <?php if (($fetch['trans_id']) <= 9) {
                                                        echo 'TRNS-0000', $fetch['trans_id'];
                                                    } elseif (($fetch['trans_id']) <= 99) {
                                                        echo 'TRNS-000', $fetch['trans_id'];
                                                    } elseif (($fetch['trans_id']) <= 999) {
                                                        echo 'TRNS-00', $fetch['trans_id'];
                                                    } elseif (($fetch['trans_id']) <= 9999) {
                                                        echo 'TRNS-0', $fetch['trans_id'];
                                                    } else {
                                                        echo 'TRNS-00-', $fetch['trans_id'];
                                                    }  ?>
                                                </td>
                                                <!-- <td><?php echo $fetch['products'] ?></td> -->
                                                <td><?php echo $fetch['fname'], ' ', $fetch['lname'] ?></td>
                                                <!-- <td><?php echo $fetch['invoice_type'] ?></td> -->
                                                <td>
                                                    <?php echo '₱ ', number_format($fetch['grand_total'], 2); ?>
                                                </td>
                                                <td>
                                                    <?php $paymentstat = $fetch['status']; ?>
                                                    <span class="<?php if ($paymentstat === 'Paid') {
                                                                        echo "text-success";
                                                                    } elseif ($paymentstat === 'Unpaid') {
                                                                        echo "text-danger";
                                                                    } else {
                                                                        echo "text-dark";
                                                                    } ?>">


                                                        <?php echo $fetch['status'] ?> </span>
                                                </td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm" data-toggle="modal" type="button" data-target="#processtransaction<?php echo $fetch['trans_id']; ?>" data-toggle-title="tooltip" data-placement="bottom" title="Update">
                                                        <i class="fa fa-credit-card"></i>
                                                        <span class="mobile-icon-only"> Process Transaction</span>
                                                    </button>
                                                    <!-- <a type="button" class="btn btn-info text-light btn-sm update" data-toggle="modal" type="button" href="transaction_information.php?id=<?php echo $fetch['trans_id'] ?>" data-toggle-title="tooltip" data-placement="bottom" title="View">
                                                        <ion-icon name="eye"></ion-icon>
                                                        <span class="mobile-icon-only">View</span>
                                                    </a> -->


                                                </td>
                                            </tr>
                                        <?php
                                            include 'includes/modal/transaction_process_payment2.php';
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            include 'includes/footer.php'; ?>

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
                    searchPlaceholder: "Search transaction"
                },
                //Disable Action sorting (yung arrow up and down)
                columnDefs: [{
                    'targets': [4],
                    'orderable': false,
                }],
                "order": [
                    [0, "desc"]
                ]
            });
        </script>
</body>

</html>