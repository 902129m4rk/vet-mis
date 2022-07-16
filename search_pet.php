<?php
include 'includes/config.php';

// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}
if (isset($_POST['submit-search'])) {
    $searchinput = $_POST['search-patient'];
    $log = "Search for patient '$searchinput'";
    include 'includes/log.php';

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="img/logo.png">
        <title>Search Pet </title>

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

    </head>

    <body>
        <div class="wrapper ">

            <?php $page = 'dashboard';
            include_once 'includes/sidebar.php'; ?>

            <div class="d-flex flex-column" id="content-wrapper">
                <!--CONTENT-->
                <div class="content">

                    <!--TOP NAVBAR/ HEADER-->
                    <nav class="navbar navbar-expand-lg navbar-light bg-light top-header">
                        <button type="button" id="sidebarCollapse" class="btn menu-btn">
                            <i class="fa fa-align-justify"> </i>
                        </button>

                        <h5 class="navbar-header-text">Dashboard</h5>

                        <!-- SEARCH BAR -->
                        <form class="form-inline my-2 my-lg-0 ml-3" action="search_pet.php" method="POST">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search-patient" placeholder="Search Patient" required="required">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit" name="submit-search">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                        <?php include 'includes/top_navbar.php'; ?>
                    </nav>

                    <!--MAIN CONTENT-->
                    <div class="container-fluid">
                        <div class="card shadow">
                            <div class="card-body">

                                <?php
                                $search = mysqli_real_escape_string($conn, $_POST['search-patient']);
                                $sql = "SELECT * FROM pet WHERE name LIKE '%$search%' ";
                                $result = mysqli_query($conn, $sql);
                                $queryResult = mysqli_num_rows($result);

                                echo "<h5>  Seach Result</h5>";
                                echo "There are " . $queryResult . " results!";

                                if ($queryResult > 0) {
                                ?>
                                    <div class="table-responsive">
                                        <table id="dataTable" class="table table-bordered table-hover" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Pet ID</th>
                                                    <th>Name</th>
                                                    <th>Gender</th>
                                                    <th>Species</th>
                                                    <th>Vitality Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while ($fetch = mysqli_fetch_assoc($result)) { ?>
                                                    <tr>
                                                        <td><?php if (($fetch['id']) <= 9) {
                                                                // echo 'PTNT-0', $fetch['id'];
                                                                echo 'PT-000', $fetch['id'];
                                                            } elseif (($fetch['id']) <= 99) {
                                                                echo 'PT-00', $fetch['id'];
                                                            } elseif (($fetch['id']) <= 999) {
                                                                echo 'PT-0', $fetch['id'];
                                                            } else {
                                                                echo 'PT-', $fetch['id'];
                                                            }  ?></td>
                                                        <td><?php echo $fetch['name'] ?></td>
                                                        <td><?php echo $fetch['gender'] ?></td>
                                                        <td><?php echo $fetch['species'] ?></td>
                                                        <td>
                                                            <div class=" <?php if ($fetch['vitality_status'] == 'Alive') {
                                                                                echo "text-primary ";
                                                                            } elseif ($fetch['vitality_status'] == 'Dead') {
                                                                                echo "text-danger";
                                                                            } ?>">


                                                                <?php echo $fetch['vitality_status'] ?>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <?php if (isset($_SESSION["loggedin"]) && ($_SESSION["utadmin"])) { ?>
                                                                <button class="btn btn-orange text-light btn-sm update" data-toggle="modal" type="button" data-target="#update_modal<?php echo $fetch['id'] ?>" data-toggle-title="tooltip" data-placement="bottom" title="Update">
                                                                    <i class="fa fa-pencil"></i>
                                                                    <span class="mobile-icon-only">Update</span>
                                                                </button>
                                                            <?php } ?>
                                                            <a type="button" class="btn text-light btn-sm update" data-toggle="modal" type="button" href="pet_information.php?id=<?php echo $fetch['id'] ?>" data-toggle-title="tooltip" data-placement="bottom" title="View" style="background-color:#3895D3;">
                                                                <i class="fa fa-eye"></i>
                                                                <span class="mobile-icon-only">View</span>
                                                            </a>
                                                        </td>
                                                    </tr>

                                                <?php include 'includes/modal/update_pet.php';
                                                } ?>

                                            </tbody>
                                        </table>
                                    </div>
                                <?php
                                } else { ?>
                                    <h5 class='text-center  mt-4 '>There are no result matching your pet search</h5>
                                    <h6 class='text-center  mt-4 '>Try another name or</h6>
                                    <div class="text-center mt-4">
                                        <a class="btn btn-primary text-light " type="button" href="pet_list.php">
                                            <span class="">Go to Pet List</span>
                                        </a>
                                    </div>
                                <?php
                                }

                                ?>

                            </div>
                        </div>
                    </div>
                </div>
                <?php include_once 'includes/footer.php'; ?>
            </div>
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
                    searchPlaceholder: "Search patient"
                },
                //Disable Action sorting (yung arrow up and down)
                columnDefs: [{
                    /* column index */
                    'targets': [5],
                    /* true or false */
                    'orderable': false,
                }],
                //disable or hide search box
                searching: false,
                //disable or hide sorting dropdown box
                lengthChange: false
            });
        </script>

    </body>

    </html>

<?php } else {
    include '404.php';
} ?>