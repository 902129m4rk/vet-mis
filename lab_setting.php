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
        <title>Laboratory Setting</title>

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
        <link rel="stylesheet" href="css/tb.css">
        <link rel="stylesheet" href="css/form.css">

    </head>

    <body>
        <div class="wrapper ">

            <?php
            $page = 'setting';
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

                        <h5 class="navbar-header-text">Laboratory Setting</h5>


                        <?php include 'includes/top_navbar.php'; ?>

                    </nav>

                    <!--MAIN CONTENT-->
                    <div class="container-fluid">

                        <!-- NAV -->
                        <ul class="nav topnav mb-4">
                            <li class="nav-item">
                                <a class=" nav-link active" href="lab_setting.php">Laboratory Test Details</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-secondary" href="lab_test_group.php">Test Group</a>
                            </li>
                            <li class=" nav-item ">
                                <a class="nav-link text-secondary " href="lab_units.php">Units</a>
                            </li>
                        </ul>

                        <!--BODY/TABLE-->
                        <div class="card shadow">
                            <div class="card-header py-3">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                        <p class="text-primary m-0 font-weight-normal">Test Details </p>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class=" float-lg-right float-md-right float-xl-right float-md-right float-sm-right float-right">
                                            <?php
                                            $sql = "SELECT * FROM lab_tests_details";
                                            $result = mysqli_query($conn, $sql);
                                            $addtestdetails = mysqli_fetch_assoc($result);
                                            ?>
                                            <button class="btn btn-primary text-light btn-sm " data-toggle="modal" type="button" data-target="#add_lab_test_details" data-toggle-title="tooltip" data-placement="bottom" title="Add Test Details">
                                                <i class="fa fa-plus"> </i>
                                                <span class="mobile-icon-only">Add Test Details</span>
                                            </button>
                                            <?php include 'includes/modal/add_lab_test_details.php'; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">

                                <!-- TABLE /LIST -->
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-bordered table-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="align-middle">Test ID</th>
                                                <th class="align-middle">Test Group</th>
                                                <th class="align-middle">Test Name </th>
                                                <th class="align-middle">Reference</th>
                                                <th class="align-middle">Unit</th>
                                                <th class="align-middle">Status</th>
                                                <th class="align-middle">Action </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            require_once 'includes/config.php';
                                            $query2 = mysqli_query($conn, "SELECT * 
                                        FROM `lab_tests_details`AS lb 
                                        INNER JOIN test_group AS tg
                                        ON tg.test_group_name = lb.test_group
                                        WHERE status = 'Active'
                                        ");

                                            while ($fetch = mysqli_fetch_array($query2)) {
                                            ?>
                                                <tr>
                                                    <td><?php if (($fetch['lab_test_details_id']) <= 9) {
                                                            echo 'TD-000', $fetch['lab_test_details_id'];
                                                        } elseif (($fetch['lab_test_details_id']) <= 99) {
                                                            echo 'TD-00', $fetch['lab_test_details_id'];
                                                        } elseif (($fetch['lab_test_details_id']) <= 999) {
                                                            echo 'TD-0', $fetch['lab_test_details_id'];
                                                        } else {
                                                            echo 'TD-', $fetch['lab_test_details_id'];
                                                        }  ?></td>
                                                    <td><?php echo $fetch['test_group'] ?></td>
                                                    <td><?php echo $fetch['test_name'] ?></td>
                                                    <td><?php echo $fetch['normal_min'], ' - ', $fetch['normal_max']  ?></td>
                                                    <td><?php echo $fetch['unit'] ?></td>
                                                    <td class="<?php if ($fetch['lab_details_status'] == 'Active') {
                                                                    echo 'text-success';
                                                                } else {
                                                                    echo 'text-danger';
                                                                } ?>">
                                                        <?php echo $fetch['lab_details_status'] ?>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-orange text-light btn-sm action-btn" data-toggle="modal" data-target="#update<?php echo $fetch['lab_test_details_id'] ?>" data-toggle-title="tooltip" data-placement="bottom" title="Update">
                                                            <i class="fa fa-pencil"></i>
                                                            <span class="mobile-icon-only">Update</span>
                                                        </button>
                                                    </td>

                                                </tr>

                                            <?php
                                                include 'includes/modal/update_lab_test_details.php';
                                            }
                                            ?>
                                        </tbody>

                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>

                    <?php include 'includes/footer.php'; ?>


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
                                searchPlaceholder: "Search Lab Details"
                            },
                            //Disable Action sorting (yung arrow up and down)
                            columnDefs: [{
                                'targets': [6], //ACTION BUTTON
                                /* column index */
                                'orderable': false,
                                /* true or false */
                            }],
                            "order": [
                                [0, "desc"]
                            ]
                        });
                    </script>

    </body>

    </html>
<?php } else {
    include '404.php';
} ?>