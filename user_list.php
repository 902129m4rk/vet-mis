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
        <title>User List </title>

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
            $page = 'usermanager';
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
                        <h5 class="navbar-header-text">User List </h5>
                        <?php include 'includes/top_navbar.php'; ?>
                    </nav>

                    <!--MAIN CONTENT-->
                    <div class="container-fluid">
                        <div class="card shadow">
                            <div class="card-header py-3">
                                <p class="text-primary m-0 font-weight-normal">User List </p>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-bordered table-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="align-middle">EMP ID </th>
                                                <th class="align-middle">Employee Name </th>
                                                <th class="align-middle">User Type</th>
                                                <th class="align-middle">Mobile Number </th>
                                                <th class="align-middle">Account Status</th>
                                                <th class="align-middle">Action </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            require_once 'includes/config.php';
                                            $query2 = mysqli_query($conn, "SELECT *
                                        FROM `users`  AS u
                                        LEFT JOIN city_municipality AS cm
                                        ON cm.id = u.city
                                        LEFT JOIN province AS prov
                                        ON prov.id = u.province
                                        ;");

                                            while ($fetch = mysqli_fetch_array($query2)) {
                                            ?>
                                                <tr>
                                                    <td><?php if (($fetch['empid']) <= 9) {
                                                            // echo 'PTNT-0', $fetch['id'];
                                                            echo 'EMP-000', $fetch['empid'];
                                                        } elseif (($fetch['empid']) <= 99) {
                                                            echo 'EMP-00', $fetch['empid'];
                                                        } elseif (($fetch['empid']) <= 999) {
                                                            echo 'EMP-0', $fetch['empid'];
                                                        } else {
                                                            echo 'EMP-', $fetch['empid'];
                                                        }  ?></td>
                                                    <td><?php echo $fetch['user_fname'], ' ', $fetch['user_lname'] ?></td>
                                                    <td><?php echo $fetch['user_type'] ?></td>
                                                    <td><?php echo $fetch['contact_no'] ?></td>
                                                    <td>
                                                        <button class="btn btn-sm  action-btn btn-no-border  <?php if ($fetch['user_status'] == 'Active') {
                                                                                                                    echo "btn-outline-primary";
                                                                                                                } elseif ($fetch['user_status'] == 'Inactive') {
                                                                                                                    echo "btn-outline-danger";
                                                                                                                }  ?>" data-toggle="modal" type="button" data-target="#status<?php echo $fetch['empid'] ?>" data-toggle-title="tooltip" data-placement="bottom" title="Change Account Status">

                                                            <?php echo $fetch['user_status'] ?>
                                                    </td>
                                                    <td>
                                                        <a role="button" class="btn btn-info text-light btn-sm" data-toggle="modal" href="#view-user<?php echo $fetch['empid']; ?>" data-toggle-title="tooltip" data-placement="bottom" title="View Information">
                                                            <i class="fa fa-info"></i>
                                                            <span class="mobile-icon-only"> </span>
                                                        </a>

                                                        <button class="btn btn-orange text-light btn-sm update" data-toggle="modal" type="button" data-target="#update_modal<?php echo $fetch['empid'] ?>" data-toggle-title="tooltip" data-placement="bottom" title="Update Information">
                                                            <i class="fa fa-pencil"></i>
                                                            <span class="mobile-icon-only"></span>
                                                        </button>
                                                        <button class="btn btn-primary text-light btn-sm update" data-toggle="modal" type="button" data-target="#update_username<?php echo $fetch['empid'] ?>" data-toggle-title="tooltip" data-placement="bottom" title="Change Username">
                                                            <i class="fa fa-user"></i>
                                                            <span class="mobile-icon-only"></span>
                                                        </button>
                                                        <button class="btn btn-dark text-light btn-sm update" data-toggle="modal" type="button" data-target="#update_user_security<?php echo $fetch['empid'] ?>" data-toggle-title="tooltip" data-placement="bottom" title="Change Password">
                                                            <i class='fa fa-lock'></i>
                                                            <span class="mobile-icon-only"> </span>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <?php
                                                include 'includes/modal/update_emp_status.php';
                                                include 'includes/modal/update_user.php';
                                                include 'includes/modal/update_user_security.php';
                                                include 'includes/modal/view_info_of_user.php';
                                                include 'includes/modal/update_username.php';
                                                ?>
                                                <!-- Note hindi pwede tong ilipat sa ibang folder. Dapat nandito or sa pinakang file talaga to, kasi kapag nilipat hindi gagana ang select breed -->
                                                <script>
                                                    function getcitymodal<?php echo $fetch['empid']; ?>(val) {
                                                        $.ajax({
                                                            type: "POST",
                                                            url: "get_citymunicipality.php",
                                                            data: 'prov_id=' + val,
                                                            success: function(data) {
                                                                $("#city-list<?php echo $fetch['empid']; ?>").html(data);
                                                            }
                                                        });
                                                    }
                                                </script>
                                            <?php }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
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
                        searchPlaceholder: "Search User"
                    },
                    //Disable Action sorting (yung arrow up and down)
                    columnDefs: [{
                        'targets': [5],
                        /* column index */
                        'orderable': false,
                        /* true or false */
                    }],
                    order: [
                        [0, "desc"]
                    ],
                });
            </script>
            <!--  DEPENDENT DROPDOWN/ SELECT-->
            <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
            <script src="js/bootstrap.min.js"></script>
            <!-- PASSWORD -->
            <script>
                $(document).ready(function() {
                    $("#show_hide_password a").on('click', function(event) {
                        event.preventDefault();
                        if ($('#show_hide_password input').attr("type") == "text") {
                            $('#show_hide_password input').attr('type', 'password');
                            $('#show_hide_password i').addClass("fa-eye-slash");
                            $('#show_hide_password i').removeClass("fa-eye");
                        } else if ($('#show_hide_password input').attr("type") == "password") {
                            $('#show_hide_password input').attr('type', 'text');
                            $('#show_hide_password i').removeClass("fa-eye-slash");
                            $('#show_hide_password i').addClass("fa-eye");
                        }
                    });
                    $("#show_hide_password2 a").on('click', function(event) {
                        event.preventDefault();
                        if ($('#show_hide_password2 input').attr("type") == "text") {
                            $('#show_hide_password2 input').attr('type', 'password');
                            $('#show_hide_password2 i').addClass("fa-eye-slash");
                            $('#show_hide_password2 i').removeClass("fa-eye");
                        } else if ($('#show_hide_password2 input').attr("type") == "password") {
                            $('#show_hide_password2 input').attr('type', 'text');
                            $('#show_hide_password2 i').removeClass("fa-eye-slash");
                            $('#show_hide_password2 i').addClass("fa-eye");
                        }
                    });
                });
            </script>
    </body>

    </html>
<?php } else {
    include '404.php';
} ?>