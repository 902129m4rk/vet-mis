<?php
include 'includes/config.php';

// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}

if (isset($_GET['id'])) {
    $pid = $_GET['id'];


    $id = mysqli_real_escape_string($conn, $_GET['id']);

    $sql = "SELECT name, p.bday, p.id, species, p.gender, weight, breed, o.fname, o.lname, owner_id, vitality_status, po.pet_id
    FROM pet AS p 
    INNER JOIN pet_owner AS po
    ON p.id=po.pet_id 
    INNER JOIN owner AS o
    ON po.owner_id=o.id
    WHERE p.id=$id;";

    $result = mysqli_query($conn, $sql);

    $fetch = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/logo.png">
    <title>Pet Information </title>

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
    <link rel="stylesheet" href="css/form.css">

</head>

<body>
    <div class="wrapper ">

        <?php
        $page = 'pet';
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

                    <h5 class="navbar-header-text">Pet Information</h5>

                    <?php include 'includes/top_navbar.php'; ?>
                </nav>

                <!--MAIN CONTENT-->
                <div class="container-fluid">

                    <?php if ($fetch) : ?>

                        <div class="row mb-3 my-flex-card">
                            <div class="col-lg-4">
                                <div class="card shadow card-body text-center shadow">
                                    <div>
                                        <h3 class="mt-3"> <?php echo htmlspecialchars($fetch['name']); ?> </h3>
                                    </div>
                                    <span class="border border-primary border-1 mt-3 mb-3"> </span>
                                    <div class="row mb-3">
                                        <div class="col-6 text-right">
                                            <div class="text-secondary"> Pet ID</div>
                                        </div>
                                        <div class="col-6 text-left">
                                            <div>
                                                <?php if (($fetch['id']) <= 9) {
                                                    // echo 'PTNT-0', $fetch['id'];
                                                    echo 'PT-000', htmlspecialchars($fetch['id']);
                                                } elseif (($fetch['id']) <= 99) {
                                                    echo 'PT-00', htmlspecialchars($fetch['id']);
                                                } elseif (($fetch['id']) <= 999) {
                                                    echo 'PT-0', htmlspecialchars($fetch['id']);
                                                } else {
                                                    echo 'PT-', htmlspecialchars($fetch['id']);
                                                }  ?>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-6 text-right">
                                            <div class="text-secondary"> Gender</div>
                                        </div>
                                        <div class="col-6 text-left">
                                            <div>
                                                <?php echo htmlspecialchars($fetch['gender']); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-6 text-right">
                                            <div class="text-secondary"> Age</div>
                                        </div>
                                        <div class="col-6 text-left">
                                            <div>
                                                <?php
                                                $dateofbirth = $fetch['bday'];
                                                $today = date("Y-m-d");
                                                $diff = date_diff(date_create($dateofbirth), date_create($today));
                                                echo  $diff->format('%y');

                                                $age = $diff->format('%y');
                                                if ($age > 1) {
                                                    echo ' years old';
                                                } else {
                                                    echo ' year old';
                                                }  ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-6 text-right">
                                            <div class="text-secondary"> Pet Owner</div>
                                        </div>
                                        <div class="col-6 text-left">
                                            <div class="text-primary client-info">
                                                <a href="pet_owner_information.php?id=<?php echo $fetch['owner_id'] ?>" data-toggle-title="tooltip" data-placement="bottom" title="View">
                                                    <?php echo htmlspecialchars($fetch['fname']), ' ' . htmlspecialchars($fetch['lname']); ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-6 text-right">
                                            <div class="text-secondary"> Vitality Status</div>
                                        </div>
                                        <div class="col-6 text-left">
                                            <div class=" <?php if ($fetch['vitality_status'] == 'Alive') {
                                                                echo "text-primary ";
                                                            } elseif ($fetch['vitality_status'] == 'Dead') {
                                                                echo "text-danger";
                                                            } ?>">
                                                <div>
                                                    <?php echo htmlspecialchars($fetch['vitality_status']); ?>
                                                    <?php if ($fetch['vitality_status'] == 'Alive') { ?>
                                                        <button class="btn btn-sm vitalitystatus" data-toggle="modal" type="button" data-target="#vitalitystatus<?php echo $fetch['id'] ?>" data-toggle-title="tooltip" data-placement="bottom" title="Change Vitality Status">
                                                            <i class="fa fa-pencil text-warning"></i>
                                                        </button>
                                                    <?php } ?>
                                                </div>


                                            </div>
                                            <!--Vitality Status Modal -->
                                            <?php include 'includes/modal/update_vitality_status.php'; ?>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-6 text-right ">
                                            <div class="text-secondary ">Date of Birth</div>
                                        </div>
                                        <div class="col-6 text-left ">
                                            <div>
                                                <?php
                                                $source = $fetch['bday'];
                                                $date = new DateTime($source);
                                                // echo $date->format('m-d-Y'); // 31-07-2012
                                                echo $date->format('F d\, Y');
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-6 text-right">
                                            <div class="text-secondary "> Weight</div>
                                        </div>
                                        <div class="col-6 text-left ">
                                            <div>
                                                <?php echo htmlspecialchars($fetch['weight']); ?> kg
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3 <?php if (empty($fetch['breed'])) {
                                                                echo 'mb-4';
                                                            } ?>">
                                        <div class="col-6 text-right">
                                            <div class="text-secondary "> Species</div>
                                        </div>
                                        <div class="col-6 text-left ">
                                            <div>
                                                <?php echo htmlspecialchars($fetch['species']); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if (!empty($fetch['breed'])) { ?>
                                        <div class="row mb-4">
                                            <div class="col-6 text-right ">
                                                <div class="text-secondary ">Breed</div>
                                            </div>
                                            <div class="col-6 text-left ">
                                                <div>
                                                    <?php echo htmlspecialchars($fetch['breed']); ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>

                                </div>
                            </div>
                            <div class="col-lg-8 ">
                                <div class="card shadow">
                                    <div class="card-header py-3">
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 ">
                                                <p class="text-primary m-0 font-weight-normal">Medical Records</p>
                                            </div>
                                            <?php if (isset($_SESSION["loggedin"]) && ($_SESSION["utstaff"])) { ?>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                                    <div class="btn-group dropleft  float-lg-right float-md-right float-xl-right float-md-right">
                                                        <button class="btn btn btn-primary btn-sm " data-toggle="modal" type="button" data-target="#add_document<?php echo $fetch['id'] ?>" data-toggle-title="tooltip" data-placement="bottom" title="Add Document">
                                                            <i class="fa fa-plus"> </i>
                                                            <span class="mobile-icon-only">Add Document</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            <?php } else { ?>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                                    <div class="text-lg-right text-xl-right text-md-right ">

                                                        <!-- Medical Record -->
                                                        <div class="btn-group dropleft">
                                                            <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="fa fa-plus"> </i>
                                                                Medical Diagnosis
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item" type="button" data-toggle="modal" data-target="#add_document<?php echo $fetch['id'] ?>">
                                                                    Add Document
                                                                </a>
                                                                <a class="dropdown-item" type="button" data-toggle="modal" data-target="#add_medicalrecord<?php echo $fetch['id'] ?>">Add Medical Diagnosis</a>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <?php include 'includes/modal/add_pet_doc.php';
                                            include 'includes/modal/add_pet_medical_records.php';
                                            ?>

                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive mb-4">
                                            <table id="dataTable" class="table table-bordered table-hover" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th class="align-middle ">Create Date</th>
                                                        <th class="action ">Action </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $sql = "SELECT * 
                                                    FROM medical_records AS mr
                                                    LEFT JOIN users AS u
                                                    ON u.empid = mr.provider
                                                    WHERE mr.pet_id=$id";

                                                    $result = mysqli_query($conn, $sql);
                                                    while ($row = mysqli_fetch_array($result)) {
                                                    ?>
                                                        <tr>
                                                            <td><?php
                                                                $source = $row['date_created'];
                                                                $date = new DateTime($source);
                                                                // echo $date->format('m-d-Y'); // 31-07-2012
                                                                echo $date->format('F d\, Y');
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php if (!empty($row['prescription'] or !empty($row['findings']))) { ?>
                                                                    <a type="button" class="btn text-light btn-sm update" type="button" href="medical_records_information.php?medical_records=<?php echo $row['medical_records_id']; ?>" data-toggle-title="tooltip" data-placement="bottom" title="View" style="background-color:#3895D3;">
                                                                        <i class="fa fa-eye"></i>
                                                                        <span class="mobile-icon-only">View</span>
                                                                    </a>
                                                                <?php } ?>

                                                                <a role="button" class="btn btn-info text-light btn-sm" data-toggle="modal" href="#view-info-docu<?php echo $row['medical_records_id']; ?>" data-toggle-title="tooltip" data-placement="bottom" title="View Information">
                                                                    <i class="fa fa-info"></i>
                                                                    <span class="mobile-icon-only">Information</span>
                                                                </a>
                                                                <?php if (!empty($row['file_name'])) { ?>
                                                                    <a href="file/<?php echo $row['file_name']; ?>" download="<?php echo $row['file_name']; ?>" class=" btn btn-success btn-sm text-light action-btn download_link" data-toggle-title="tooltip" data-placement="bottom" title="Download File" name="dlfile">
                                                                        <i class="fa fa-download"></i>
                                                                        <span class="mobile-icon-only"> Download</span>
                                                                    </a>
                                                                <?php } ?>
                                                            </td>
                                                        </tr>

                                                    <?php
                                                        include 'includes/modal/view_info_of_docu.php';
                                                    }

                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else :  ?>

                        <h5 class="text-center"> No such pet exists :( </h5>
                        <div class="text-center mt-4">
                            <a class="btn btn-primary text-light " type="button" href="pet_list.php">
                                <span class="">Go to Pet List</span>
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
                    // ajax: "pet_list.inc.php",
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
                    }],
                    "order": [
                        [0, "desc"]
                    ]
                });
            </script>
</body>

</html>