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
    <title>Appointment List </title>

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
        $page = 'appointment';
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
                    <h5 class="navbar-header-text">Appointment List</h5>
                    <?php include 'includes/top_navbar.php'; ?>
                </nav>

                <!--MAIN CONTENT-->
                <div class="container-fluid">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 font-weight-normal">Appointment List</p>
                        </div>
                        <div class="card-body">

                            <!-- VET -->
                            <?php if (isset($_SESSION["loggedin"]) && ($_SESSION["utvet"])) {
                                $sessionvetid =  $_SESSION["empid"];
                            ?>
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-bordered table-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="align-middle">APT ID </th>
                                                <th class="align-middle">Pet Name </th>
                                                <th class="align-middle">Service</th>
                                                <th class="align-middle">Date </th>
                                                <th class="align-middle"> Time </th>
                                                <th class="align-middle">Status</th>
                                                <th class="align-middle">Action </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            require_once 'includes/config.php';

                                            $query2 = mysqli_query($conn, "SELECT a.id, p.name, o.fname, o.lname, status, service, date, time, pet_id, p.id AS patientid, user_fname, user_lname, assigned_vet, empid
                                        FROM `appointment`  AS a
                                        LEFT JOIN users AS u
                                        ON u.empid = a.assigned_vet
                                        LEFT  JOIN pet AS p
                                        ON a.pet_id=p.id 
                                        LEFT JOIN owner AS o
                                        ON a.owner_id=o.id
                                        WHERE status ='Scheduled'
                                        AND assigned_vet = '$sessionvetid'
                                        ;");

                                            while ($fetch = mysqli_fetch_array($query2)) {
                                            ?>
                                                <tr>
                                                    <td><?php if (($fetch['id']) <= 9) {
                                                            // echo 'PTNT-0', $fetch['id'];
                                                            echo 'APT-000', $fetch['id'];
                                                        } elseif (($fetch['id']) <= 99) {
                                                            echo 'APT-00', $fetch['id'];
                                                        } elseif (($fetch['id']) <= 999) {
                                                            echo 'APT-0', $fetch['id'];
                                                        } else {
                                                            echo 'APT-', $fetch['id'];
                                                        }  ?></td>
                                                    <td><?php echo $fetch['name'] ?></td>
                                                    <td><?php echo $fetch['service'] ?></td>
                                                    <td> <?php
                                                            $source =  $fetch['date'];
                                                            $date = new DateTime($source);
                                                            echo $date->format('F d\, Y');
                                                            ?></td>
                                                    <td> <?php
                                                            $source =  $fetch['time'];
                                                            $date = new DateTime($source);
                                                            echo $date->format('h:i a'); // 31-07-2012
                                                            ?></td>
                                                    <td>
                                                        <button class="btn btn-sm  action-btn btn-no-border  <?php if ($fetch['status'] == 'Scheduled') {
                                                                                                                    echo "btn-outline-primary";
                                                                                                                } elseif ($fetch['status'] == 'Canceled') {
                                                                                                                    echo "btn-outline-danger";
                                                                                                                } elseif ($fetch['status'] == 'Completed') {
                                                                                                                    echo "btn-outline-success";
                                                                                                                } elseif ($fetch['status'] == 'No Show') {
                                                                                                                    echo "btn-outline-dark";
                                                                                                                } ?>" data-toggle="modal" type="button" data-target="#status<?php echo $fetch['id'] ?>" data-toggle-title="tooltip" data-placement="bottom" title="Change Appointment Status">

                                                            <?php echo $fetch['status'] ?>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-orange text-light btn-sm update" data-toggle="modal" type="button" data-target="#update_modal<?php echo $fetch['id'] ?>" data-toggle-title="tooltip" data-placement="bottom" title="Update Information">
                                                            <i class="fa fa-pencil"></i>
                                                            <span class="mobile-icon-only">Update</span>
                                                        </button>
                                                        <a role="button" class="btn btn-info text-light btn-sm" data-toggle="modal" href="#view-apt<?php echo $fetch['id']; ?>" data-toggle-title="tooltip" data-placement="bottom" title="View Information">
                                                            <i class="fa fa-info"></i>
                                                            <span class="mobile-icon-only"> Information</span>
                                                        </a>

                                                    </td>
                                                </tr>
                                            <?php
                                                include 'includes/modal/update_apt_status.php';
                                                include 'includes/modal/update_appointment.php';
                                                include 'includes/modal/view_info_of_apt.php';
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>


                                <!-- STAFF -->
                            <?php } elseif (isset($_SESSION["loggedin"]) && ($_SESSION["utstaff"])) { ?>
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-bordered table-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="align-middle">APT ID </th>
                                                <th class="align-middle">Pet Name </th>
                                                <th class="align-middle">Service</th>
                                                <th class="align-middle">Date </th>
                                                <th class="align-middle"> Time </th>
                                                <th class="align-middle">Status</th>
                                                <th class="align-middle">Action </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            require_once 'includes/config.php';
                                            $query2 = mysqli_query($conn, "SELECT a.id, p.name, o.fname, o.lname, status, service, date, time,pet_id, p.id AS patientid, user_fname, user_lname, assigned_vet,empid
                                        FROM `appointment`  AS a
                                        LEFT JOIN users AS u
                                        ON u.empid = a.assigned_vet
                                        LEFT  JOIN pet AS p
                                        ON a.pet_id=p.id 
                                        LEFT JOIN owner AS o
                                        ON a.owner_id=o.id
                                        WHERE status ='Scheduled'
                                        ;");

                                            while ($fetch = mysqli_fetch_array($query2)) {
                                            ?>
                                                <tr>
                                                    <td><?php if (($fetch['id']) <= 9) {
                                                            // echo 'PTNT-0', $fetch['id'];
                                                            echo 'APT-000', $fetch['id'];
                                                        } elseif (($fetch['id']) <= 99) {
                                                            echo 'APT-00', $fetch['id'];
                                                        } elseif (($fetch['id']) <= 999) {
                                                            echo 'APT-0', $fetch['id'];
                                                        } else {
                                                            echo 'APT-', $fetch['id'];
                                                        }  ?></td>
                                                    <td><?php echo $fetch['name'] ?></td>
                                                    <td><?php echo $fetch['service'] ?></td>
                                                    <td> <?php
                                                            $source =  $fetch['date'];
                                                            $date = new DateTime($source);
                                                            echo $date->format('F d\, Y');
                                                            ?>

                                                    </td>
                                                    <td> <?php
                                                            $source =  $fetch['time'];
                                                            $date = new DateTime($source);
                                                            echo $date->format('h:i a'); // 31-07-2012
                                                            ?></td>
                                                    <td>
                                                        <button class="btn btn-sm  action-btn btn-no-border  <?php if ($fetch['status'] == 'Scheduled') {
                                                                                                                    echo "btn-outline-primary";
                                                                                                                } elseif ($fetch['status'] == 'Canceled') {
                                                                                                                    echo "btn-outline-danger";
                                                                                                                } elseif ($fetch['status'] == 'Completed') {
                                                                                                                    echo "btn-outline-success";
                                                                                                                } elseif ($fetch['status'] == 'No Show') {
                                                                                                                    echo "btn-outline-dark";
                                                                                                                } ?>" data-toggle="modal" type="button" data-target="#status<?php echo $fetch['id'] ?>" data-toggle-title="tooltip" data-placement="bottom" title="Change Appointment Status">

                                                            <?php echo $fetch['status'] ?>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-orange text-light btn-sm update" data-toggle="modal" type="button" data-target="#update_modal<?php echo $fetch['id'] ?>" data-toggle-title="tooltip" data-placement="bottom" title="Update Information">
                                                            <i class="fa fa-pencil"></i>
                                                            <span class="mobile-icon-only">Update</span>
                                                        </button>
                                                        <a role="button" class="btn btn-info text-light btn-sm" data-toggle="modal" href="#view-apt<?php echo $fetch['id']; ?>" data-toggle-title="tooltip" data-placement="bottom" title="View Information">
                                                            <i class="fa fa-info"></i>
                                                            <span class="mobile-icon-only"> Information</span>
                                                        </a>

                                                    </td>
                                                </tr>
                                            <?php
                                                include 'includes/modal/update_apt_status.php';
                                                include 'includes/modal/update_appointment.php';
                                                include 'includes/modal/view_info_of_apt.php';
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- ADMIN -->
                            <?php
                            } else { ?>
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-bordered table-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="align-middle">APT ID </th>
                                                <th class="align-middle">Pet Name </th>
                                                <th class="align-middle">Service</th>
                                                <th class="align-middle">Date </th>
                                                <th class="align-middle"> Time </th>
                                                <th class="align-middle">Status</th>
                                                <th class="align-middle">Action </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            require_once 'includes/config.php';
                                            $query2 = mysqli_query($conn, "SELECT a.id, p.name, o.fname, o.lname, status, service, date, time,pet_id, p.id AS patientid, user_fname, user_lname, assigned_vet,empid
                                        FROM `appointment`  AS a
                                        LEFT JOIN users AS u
                                        ON u.empid = a.assigned_vet
                                        LEFT  JOIN pet AS p
                                        ON a.pet_id=p.id 
                                        LEFT JOIN owner AS o
                                        ON a.owner_id=o.id
                                        ;");

                                            while ($fetch = mysqli_fetch_array($query2)) {
                                            ?>
                                                <tr>
                                                    <td><?php if (($fetch['id']) <= 9) {
                                                            // echo 'PTNT-0', $fetch['id'];
                                                            echo 'APT-000', $fetch['id'];
                                                        } elseif (($fetch['id']) <= 99) {
                                                            echo 'APT-00', $fetch['id'];
                                                        } elseif (($fetch['id']) <= 999) {
                                                            echo 'APT-0', $fetch['id'];
                                                        } else {
                                                            echo 'APT-', $fetch['id'];
                                                        }  ?></td>
                                                    <td><?php echo $fetch['name'] ?></td>
                                                    <td><?php echo $fetch['service'] ?></td>
                                                    <td> <?php
                                                            $source =  $fetch['date'];
                                                            $date = new DateTime($source);
                                                            echo $date->format('F d\, Y');
                                                            ?></td>
                                                    <td> <?php
                                                            $source =  $fetch['time'];
                                                            $date = new DateTime($source);
                                                            echo $date->format('h:i a'); // 31-07-2012
                                                            ?></td>
                                                    <td>
                                                        <button class="btn btn-sm  action-btn btn-no-border  <?php if ($fetch['status'] == 'Scheduled') {
                                                                                                                    echo "btn-outline-primary";
                                                                                                                } elseif ($fetch['status'] == 'Canceled') {
                                                                                                                    echo "btn-outline-danger";
                                                                                                                } elseif ($fetch['status'] == 'Completed') {
                                                                                                                    echo "btn-outline-success";
                                                                                                                } elseif ($fetch['status'] == 'No Show') {
                                                                                                                    echo "btn-outline-dark";
                                                                                                                } ?>" data-toggle="modal" type="button" data-target="#status<?php echo $fetch['id'] ?>" data-toggle-title="tooltip" data-placement="bottom" title="Change Appointment Status">

                                                            <?php echo $fetch['status'] ?>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-orange text-light btn-sm update" data-toggle="modal" type="button" data-target="#update_modal<?php echo $fetch['id'] ?>" data-toggle-title="tooltip" data-placement="bottom" title="Update Information">
                                                            <i class="fa fa-pencil"></i>
                                                            <span class="mobile-icon-only">Update</span>
                                                        </button>
                                                        <a role="button" class="btn btn-info text-light btn-sm" data-toggle="modal" href="#view-apt<?php echo $fetch['id']; ?>" data-toggle-title="tooltip" data-placement="bottom" title="View Information">
                                                            <i class="fa fa-info"></i>
                                                            <span class="mobile-icon-only"> Information</span>
                                                        </a>

                                                    </td>
                                                </tr>
                                            <?php
                                                include 'includes/modal/update_apt_status.php';
                                                include 'includes/modal/update_appointment.php';
                                                include 'includes/modal/view_info_of_apt.php';
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
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
                    searchPlaceholder: "Search Appointment"
                },
                //Disable Action sorting (yung arrow up and down)
                columnDefs: [{
                    'targets': [6],
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