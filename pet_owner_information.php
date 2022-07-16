<?php
include 'includes/config.php';
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}

if (!isset($pet_name)) {
    $petname = "";
}

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // $sql = "SELECT * FROM owner  WHERE id = $id";
    $sql = "SELECT name, o.id, o.bday, o.gender, contactno, email, province, city, o.fname, o.lname, pet_id, species, vitality_status,citymunicipality_name,province_name,breed
    FROM pet AS p 
    LEFT JOIN pet_owner AS po 
    ON p.id=po.pet_id 
    LEFT JOIN owner AS o
    ON po.owner_id=o.id
    LEFT JOIN city_municipality AS cm
    ON cm.id = o.city
    LEFT JOIN province AS prov
    ON prov.id = o.province 
    WHERE o.id=$id;";

    $result = mysqli_query($conn, $sql);

    $ownerinfo = mysqli_fetch_assoc($result);

    // $mysqli_free_result($result);
    // mysqli_close($conn);
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/logo.png">
    <title>Pet Owner Information </title>

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

                    <h5 class="navbar-header-text">Pet Owner Information </h5>
                    <?php include 'includes/top_navbar.php'; ?>
                </nav>

                <!--MAIN CONTENT-->
                <div class="container-fluid">

                    <?php if ($ownerinfo) : ?>

                        <div class="row mb-3 my-flex-card">
                            <div class="col-lg-4">
                                <div class="card shadow card-body text-center shadow">

                                    <div>
                                        <h3 class="mt-3"> <?php echo htmlspecialchars($ownerinfo['fname']), ' ', htmlspecialchars($ownerinfo['lname']); ?> </h3>
                                    </div>
                                    <span class="border border-primary border-1 mt-3 mb-3"> </span>
                                    <div class="row mb-3">
                                        <div class="col-6 text-right">
                                            <div class="text-secondary"> Pet Owner ID</div>
                                        </div>
                                        <div class="col-6 text-left">
                                            <div>
                                                <?php if (($ownerinfo['id']) <= 9) {
                                                    // echo 'PTNT-0', $fetch['id'];
                                                    echo 'PTOWNR-000', $ownerinfo['id'];
                                                } elseif (($ownerinfo['id']) <= 99) {
                                                    echo 'PTOWNR-00', $ownerinfo['id'];
                                                } elseif (($ownerinfo['id']) <= 999) {
                                                    echo 'PTOWNR-0', $ownerinfo['id'];
                                                } else {
                                                    echo 'PTOWNR-', $ownerinfo['id'];
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
                                                <?php echo htmlspecialchars($ownerinfo['gender']); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-6 text-right">
                                            <div class="text-secondary"> Date of Birth</div>
                                        </div>
                                        <div class="col-6 text-left">
                                            <div>
                                                <?php
                                                $source = $ownerinfo['bday'];
                                                $date = new DateTime($source);
                                                // echo $date->format('m-d-Y'); // 31-07-2012
                                                echo $date->format('F d\, Y');
                                                ?>
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
                                                $dateofbirth = $ownerinfo['bday'];
                                                $today = date("Y-m-d");
                                                $diff = date_diff(date_create($dateofbirth), date_create($today));
                                                echo  $diff->format('%y');
                                                ?>
                                                years old
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-6 text-right">
                                            <div class="text-secondary"> Mobile Number</div>
                                        </div>
                                        <div class="col-6 text-left">
                                            <div>
                                                <?php echo htmlspecialchars($ownerinfo['contactno']); ?>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-6 text-right">
                                            <div class="text-secondary "> E-mail Address</div>
                                        </div>
                                        <div class="col-6 text-left">
                                            <div>
                                                <?php echo htmlspecialchars($ownerinfo['email']); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-6 text-right">
                                            <div class="text-secondary">Address</div>
                                        </div>
                                        <div class="col-6 text-left">
                                            <div>
                                                <span> <?php echo $ownerinfo['citymunicipality_name'], ', ', $ownerinfo['province_name']; ?> </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="card shadow">
                                    <div class="card-header py-3">
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 ">
                                                <p class="text-primary m-0 font-weight-normal">
                                                    <?php echo htmlspecialchars($ownerinfo['fname']),
                                                    " 's Pet"; ?>
                                                </p>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 ">
                                                <div class=" float-lg-right float-md-right float-xl-right float-md-right">
                                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-toggle-title="tooltip" data-placement="bottom" title="Add Pet" data-target="#add_pet<?php echo $ownerinfo['id'] ?>">
                                                        <i class="fa fa-plus"> </i>
                                                        <span class="mobile-icon-only">Add Pet </span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php include 'includes/modal/add_pet.php' ?>

                                    <div class="card-body">
                                        <div class="table-responsive mb-4">
                                            <table id="dataTable" class="table table-bordered table-hover" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th class="align-middle">Pet </th>
                                                        <th class="align-middle">Species</th>
                                                        <th class="align-middle">Vitality Status</th>
                                                        <th class="action ">Action </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $query = mysqli_query($conn, "SELECT name, species, pet_id, p.id, p.gender, p.bday, weight, vitality_status,breed
                                                    FROM pet AS p 
                                                    INNER JOIN pet_owner AS po 
                                                    ON p.id=po.pet_id 
                                                    INNER JOIN owner AS o
                                                    ON po.owner_id=o.id  WHERE o.id='$id';");

                                                    while ($fetch = mysqli_fetch_array($query)) {
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $fetch['name'] ?></td>
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

                                                        <?php
                                                        include 'includes/modal/update_pet.php';
                                                    }
                                                        ?>
                                                        </tr>

                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>


                    <?php else :  ?>

                        <h5 class="text-center"> No such pet owner exists :( </h5>
                        <div class="text-center mt-4">
                            <a class="btn btn-primary text-light " type="button" href="pet_owner_list.php">
                                <!-- <i class="fa fa-pencil"></i> -->
                                <span class="">Go to Pet Owner List</span>
                            </a>
                        </div>
                        <!-- <a type="button" href="patient_list.php" class="text-center text-primary text-primary client-info link-primary"> Go to Patient List </a> -->
                    <?php endif;    ?>
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
                processing: true,
                // serverSide: true,
                // ajax: "patient_list.inc.php",
                lengthMenu: [10, 5, 10, 25, 50, 100],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search Pet"
                },
                //Disable Action sorting (yung arrow up and down)
                columnDefs: [{
                    'targets': [3],
                    /* column index */
                    'orderable': false,
                    /* true or false */
                }]
            });
        </script>

</body>

</html>