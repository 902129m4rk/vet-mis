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
        <title>Product Category</title>

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

                        <h5 class="navbar-header-text">Product Category</h5>
                        <?php include 'includes/top_navbar.php'; ?>

                    </nav>

                    <!--MAIN CONTENT-->
                    <div class="container-fluid">


                        <!--BODY/TABLE-->
                        <div class="card shadow">
                            <div class="card-header py-3">
                                <div class="row">
                                    <div class="col-6">
                                        <p class="text-primary m-0 font-weight-normal">Product Category </p>
                                    </div>
                                    <div class="col-6">
                                        <div class=" float-right">
                                            <?php
                                            $sql = "SELECT * FROM product_category";

                                            $result = mysqli_query($conn, $sql);

                                            $addproductcat = mysqli_fetch_assoc($result);
                                            ?>
                                            <button class="btn btn-primary text-light btn-sm " data-toggle="modal" type="button" data-target="#add_productcat<?php echo $addproductcat['id'] ?>" data-toggle-title="tooltip" data-placement="bottom" title="Add Product Category">
                                                <i class="fa fa-plus"> </i>
                                                <span class="mobile-icon-only">Add Product Category</span>
                                            </button>
                                            <?php include 'includes/modal/add_product_category.php'; ?>
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
                                                <th class="align-middle">Product Category ID</th>
                                                <th class="align-middle">Name</th>
                                                <th class="align-middle">Status</th>
                                                <th class="align-middle">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            require_once 'includes/config.php';
                                            $query2 = mysqli_query($conn, "SELECT *FROM `product_category`; ");

                                            while ($fetch = mysqli_fetch_array($query2)) {
                                            ?>
                                                <tr>
                                                    <td><?php if (($fetch['id']) <= 9) {
                                                            echo 'PRCTGY-000', $fetch['id'];
                                                        } elseif (($fetch['id']) <= 99) {
                                                            echo 'PRCTGY-00', $fetch['id'];
                                                        } elseif (($fetch['id']) <= 999) {
                                                            echo 'PRCTGY-0', $fetch['id'];
                                                        } else {
                                                            echo 'PRCTGY-', $fetch['id'];
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
                                                        <button class="btn btn-orange text-light btn-sm action-btn" data-toggle="modal" data-target="#update<?php echo $fetch['id'] ?>" data-toggle-title="tooltip" data-placement="bottom" title="Update">
                                                            <i class="fa fa-pencil"></i>
                                                            <span class="mobile-icon-only">Update</span>
                                                        </button>
                                                    </td>

                                                </tr>

                                            <?php
                                                include 'includes/modal/update_product_category.php';
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
                                searchPlaceholder: "Search "
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