<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}
if (isset($_SESSION["loggedin"]) && ($_SESSION["utvet"]) or ($_SESSION["utstaff"])) {
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="img/logo.png">
        <title>Laboratory List </title>

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
            $page = 'lab';
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

                        <h5 class="navbar-header-text">Laboratory List</h5>
                        <?php include 'includes/top_navbar.php'; ?>
                    </nav>

                    <!--MAIN CONTENT-->
                    <div class="container-fluid">
                        <div class="card shadow">
                            <div class="card-header py-3">
                                <p class="text-primary m-0 font-weight-normal">Laboratory List</p>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-bordered table-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="align-middle">Lab Test Number </th>
                                                <th class="align-middle">Pet Name </th>
                                                <th class="align-middle">Species</th>
                                                <th class="align-middle">Pet Owner Name </th>
                                                <th class="align-middle">Created Date </th>
                                                <th class="align-middle">Action </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            require_once 'includes/config.php';

                                            $query2 = mysqli_query($conn, "SELECT *
                                         FROM transaction AS t
                                        LEFT JOIN pet AS p
                                        ON p.id=t.pet_id 
                                        LEFT JOIN transaction_details AS td
                                        ON t.transaction_details_no = td.transaction_details_no 
                                        LEFT JOIN test_result AS tr
                                         ON tr.transaction_no = t.trans_id
                                        LEFT JOIN lab_tests_details AS ltd
                                        ON ltd.lab_test_details_id  = tr.lab_test_id 
                                        LEFT JOIN owner AS o
                                        ON o.id = t.pet_owner_id
                                        WHERE invoice_type = 'Laboratory' 
                                        AND status = 'Paid' 
                                        AND result IS NOT NULL
                                     
                                        GROUP BY trans_id

                                        ;");

                                            while ($fetch = mysqli_fetch_array($query2)) {
                                            ?>
                                                <tr>
                                                    <td>
                                                        <?php echo 'LBT-', $fetch['test_no']; ?>
                                                    </td>
                                                    <td> <?php echo $fetch['name']; ?></td>
                                                    <td> <?php echo $fetch['species']; ?></td>
                                                    <td> <?php echo $fetch['fname'], ' ', $fetch['lname']; ?></td>
                                                    <td>
                                                        <?php
                                                        $source =  $fetch['date_created'];
                                                        $date = new DateTime($source);
                                                        echo $date->format('F d\, Y');
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <a type="button" class="btn text-light btn-sm update" data-toggle="modal" type="button" href="lab_test_result_information.php?id=<?php echo $fetch['transaction_no'] ?>" data-toggle-title="tooltip" data-placement="bottom" title="View" style="background-color:#3895D3;">
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
                        'targets': [3],
                        'orderable': false,
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