<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}
if (isset($_SESSION["loggedin"]) && ($_SESSION["utadmin"])) {
?>


    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="img/logo.png">
        <title>Collection Report </title>

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
            $page = 'report';
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

                        <h5 class="navbar-header-text">Collection Report</h5>
                        <?php include 'includes/top_navbar.php'; ?>
                    </nav>

                    <!--MAIN CONTENT-->
                    <div class="container-fluid">
                        <div class="card shadow">
                            <div class="card-header py-3">
                                <p class="text-primary m-0 font-weight-normal">Collection Report</p>
                            </div>
                            <div class="card-body">
                                <form class="row g-3 mt-2" method="POST">
                                    <div class="col-auto">
                                        <label for="staticEmail2">From:</label>
                                    </div>
                                    <div class="col-auto">
                                        <input type="date" class="form-control" name="startdate" value="<?php if (isset($_POST['startdate'])) {
                                                                                                            echo $_POST['startdate'];
                                                                                                        } ?>">
                                    </div>
                                    <div class="col-auto">
                                        <label for="staticEmail2">To:</label>
                                    </div>
                                    <div class="col-auto">
                                        <input type="date" class="form-control" name="enddate" value="<?php if (isset($_POST['enddate'])) {
                                                                                                            echo $_POST['enddate'];
                                                                                                        } ?>">
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-primary mb-3" name="searchreportdate">Generate</button>
                                    </div>
                                </form>

                                <?php
                                if (isset($_POST['searchreportdate'])) {
                                    $startdate = $_POST['startdate'];
                                    $enddate = $_POST['enddate'];

                                    $querydate = mysqli_query($conn, "SELECT * 
                                FROM transaction AS t 
                                LEFT JOIN owner AS o
                                ON o.id = t.pet_owner_id
                                WHERE status='Paid' AND
                                t.payment_date BETWEEN '$startdate' AND '$enddate'
                                ;");

                                    $count = mysqli_num_rows($querydate);


                                    if ($count == "0") {
                                        echo '<h5 class="mt-5 text-center mb-5"> No results found, Please try again.</h5>';
                                    } else {
                                        $user_activity = "Generate collection report";
                                        $details = "Generate collection report, from '$startdate' to '$enddate'";
                                        include 'includes/log.php';
                                ?>
                                        <hr>
                                        <div>
                                        </div>
                                        <div class="table-responsive mt-4">
                                            <table id="dataTable" class="table table-bordered table-hover" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th class="align-middle">Transaction ID </th>
                                                        <th class="align-middle">Pet Owner Name</th>
                                                        <th class="align-middle">Total Amount</th>
                                                        <th class="align-middle">Payment Date</th>
                                                        <th class="align-middle">Action </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    while ($fetch = mysqli_fetch_array($querydate)) {
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
                                                            <td> <?php echo $fetch['fname'], ' ', $fetch['lname']; ?></td>
                                                            <td> <?php echo '₱ ', number_format($fetch['grand_total'], 2); ?></td>
                                                            <td>
                                                                <?php
                                                                $source = $fetch['payment_date'];
                                                                $date = new DateTime($source);
                                                                // echo $date->format('m-d-Y'); // 31-07-2012
                                                                echo $date->format('F d\, Y');
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <a type="button" class="btn text-light btn-sm update" data-toggle="modal" type="button" href="transaction_information.php?id=<?php echo $fetch['trans_id'] ?>" data-toggle-title="tooltip" data-placement="bottom" title="View" style="background-color:#3895D3;">
                                                                    <i class="fa fa-eye"></i>
                                                                    <span class="mobile-icon-only">View</span>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                <?php
                                    }
                                }

                                ?>


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
            <script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>
            <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css"> -->
            <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css">
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
            <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
            <script>
                $('#dataTable').dataTable({
                    processing: true,
                    // serverSide: true,
                    // ajax: "patient_list.inc.php",
                    lengthMenu: [10, 5, 10, 25, 50, 100],
                    language: {
                        search: "_INPUT_",
                        searchPlaceholder: "Search "
                    },
                    columnDefs: [{
                        'targets': [4],
                        'orderable': false,
                    }],
                    "order": [
                        [3, "asc"]
                    ],
                    dom: 'Blfrtip',
                    buttons: [{
                            extend: 'excelHtml5',
                            exportOptions: {
                                columns: [0, 1, 2, 3] //Your Column value those you want
                            },
                            messageBottom: '<?php
                                            $printeddate = new DateTime(); ?>
                            <?php echo 'Generate Date: ', $printeddate->format('F d\, Y'); ?> ',
                            messageTop: '<?php $starttdate = new DateTime($startdate);
                                            $endddate = new DateTime($enddate); ?>
                            <?php echo 'As of ', $starttdate->format('F d\, Y'), ' to ', $endddate->format('F d\, Y'); ?> ',
                        },
                        {
                            extend: 'pdfHtml5',
                            exportOptions: {
                                columns: [0, 1, 2, 3] //Your Column value those you want
                            },
                            messageBottom: '<?php
                                            $printeddate = new DateTime(); ?>
                            <?php echo 'Generate Date: ', $printeddate->format('F d\, Y'); ?> ',
                            messageTop: '<?php $starttdate = new DateTime($startdate);
                                            $endddate = new DateTime($enddate); ?>
                            <?php echo 'As of ', $starttdate->format('F d\, Y'), ' to ', $endddate->format('F d\, Y'); ?> ',
                        }, {
                            extend: 'print',
                            exportOptions: {
                                columns: [0, 1, 2, 3] //Your Column value those you want
                            },
                            customize: function(win) {
                                $(win.document.body)
                                    .css('font-size', '10pt')

                                $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                            },

                            messageBottom: '<?php
                                            $printeddate = new DateTime(); ?>
                            <?php echo '<div class="mt-5 text-danger ">Printed on ', $printeddate->format('F d\, Y'), '</div>'; ?> ',
                            messageTop: 'As of <?php $starttdate = new DateTime($startdate);
                                                $endddate = new DateTime($enddate); ?>
                            <?php
                            echo $starttdate->format('F d\, Y'); ?> <?php echo ' to '; ?>
                            <?php echo $endddate->format('F d\, Y'); ?> ',

                        },
                    ]

                });
            </script>
    </body>

    </html>
<?php } else {
    include '404.php';
} ?>