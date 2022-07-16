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
        <title>Species</title>

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

                        <h5 class="navbar-header-text">Species</h5>
                        <?php include 'includes/top_navbar.php'; ?>

                    </nav>

                    <!--MAIN CONTENT-->
                    <div class="container-fluid">
                        <div class="card shadow">
                            <div class="card-header py-3">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                        <p class="text-primary m-0 font-weight-normal">Species </p>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class=" float-lg-right float-md-right float-xl-right float-md-right float-sm-right float-right">
                                            <?php
                                            $sql = "SELECT * FROM species";

                                            $result = mysqli_query($conn, $sql);

                                            $fetch = mysqli_fetch_assoc($result);
                                            ?>
                                            <button class="btn btn-primary text-light btn-sm " data-toggle="modal" type="button" data-target="#add_species<?php echo $fetch['id'] ?>" data-toggle-title="tooltip" data-placement="bottom" title="Add Species">
                                                <i class="fa fa-plus"> </i>
                                                <span class="mobile-icon-only">Add Species</span>
                                            </button>
                                            <?php include 'includes/modal/add_species.php'; ?>
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
                                                <th class="align-middle">Species ID </th>
                                                <th class="align-middle">Species Name </th>
                                                <th class="align-middle">Status </th>
                                                <th class="align-middle">Action </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            require_once 'includes/config.php';
                                            $query2 = mysqli_query($conn, "SELECT * FROM `species`");

                                            while ($fetch = mysqli_fetch_array($query2)) {
                                            ?>
                                                <tr>
                                                    <td><?php if (($fetch['id']) <= 9) {
                                                            // echo 'PTNT-0', $fetch['id'];
                                                            echo 'SPCS-000', $fetch['id'];
                                                        } elseif (($fetch['id']) <= 99) {
                                                            echo 'SPCS-00', $fetch['id'];
                                                        } elseif (($fetch['id']) <= 999) {
                                                            echo 'SPCS-0', $fetch['id'];
                                                        } else {
                                                            echo 'SPCS-', $fetch['id'];
                                                        }  ?></td>
                                                    <td><?php echo $fetch['name'] ?></td>
                                                    <td class="<?php if ($fetch['status'] == 'Active') {
                                                                    echo 'text-success';
                                                                } else {
                                                                    echo 'text-danger';
                                                                } ?>">
                                                        <?php echo $fetch['status'] ?>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-orange text-light btn-sm action-btn" data-toggle="modal" data-target="#update_species<?php echo $fetch['id'] ?>" data-toggle-title="tooltip" data-placement="bottom" title="Update">
                                                            <i class="fa fa-pencil"></i>
                                                            <span class="mobile-icon-only">Update</span>
                                                        </button>
                                                    </td>

                                                </tr>

                                            <?php
                                                include 'includes/modal/update_species.php';
                                            }
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
                        searchPlaceholder: "Search Species"
                    },
                    //Disable Action sorting (yung arrow up and down)
                    columnDefs: [{
                        'targets': [3], //ACTION BUTTON
                        /* column index */
                        'orderable': false,
                        /* true or false */
                    }],
                    "order": [
                        [1, "asc"]
                    ]
                });
            </script>


    </body>

    </html>
<?php } else {
    include '404.php';
} ?>