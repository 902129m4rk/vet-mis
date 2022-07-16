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
    <title>Pet Owner List </title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css" integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.min.js" integrity="sha384-5h4UG+6GOuV9qXh6HqOLwZMY4mnLPraeTrjT5v07o347pj6IkfuoASuGBhfDsp3d" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
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

                    <h5 class="navbar-header-text">Pet Owner List</h5>

                    <?php include 'includes/top_navbar.php'; ?>
                </nav>

                <!--MAIN CONTENT-->
                <div class="container-fluid">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 font-weight-normal">Pet Owner List</p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="dataTable" class="table table-bordered table-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Pet Owner ID</th>
                                            <th>Name</th>
                                            <th>Age</th>
                                            <th>Contact Number</th>
                                            <!-- <th>E-mail Address</th> -->
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        require_once 'includes/config.php';
                                        $query2 = mysqli_query($conn, "SELECT o.id, fname, lname, o.bday, o.gender, contactno, email, province, city,  citymunicipality_name,province_name 
                                        FROM `owner` AS o
                                        LEFT JOIN city_municipality AS cm
                                        ON cm.id = o.city
                                        LEFT JOIN province AS prov
                                        ON prov.id = o.province
                                 ");

                                        while ($fetch = mysqli_fetch_array($query2)) {
                                        ?>
                                            <tr>
                                                <td><?php if (($fetch['id']) <= 9) {
                                                        // echo 'PTNT-0', $fetch['id'];
                                                        echo 'PTOWNR-000', $fetch['id'];
                                                    } elseif (($fetch['id']) <= 99) {
                                                        echo 'PTOWNR-00', $fetch['id'];
                                                    } elseif (($fetch['id']) <= 999) {
                                                        echo 'PTOWNR-0', $fetch['id'];
                                                    } else {
                                                        echo 'PTOWNR-', $fetch['id'];
                                                    }  ?></td>
                                                <td><?php echo $fetch['fname'], ' ', $fetch['lname'] ?></td>
                                                <td><?php $dateofbirth = $fetch['bday'];
                                                    $today = date("Y-m-d");
                                                    $diff = date_diff(date_create($dateofbirth), date_create($today));
                                                    echo  $diff->format('%y');

                                                    $age = $diff->format('%y');
                                                    if ($age > 1) {
                                                        echo ' years old';
                                                    } else {
                                                        echo ' year old';
                                                    } ?></td>
                                                <td><?php echo $fetch['contactno'] ?></td>
                                                <!-- <td><?php echo $fetch['email'] ?></td> -->

                                                <td>
                                                    <?php if (isset($_SESSION["loggedin"]) && ($_SESSION["utadmin"])) { ?>
                                                        <button class="btn btn-orange text-light btn-sm update" data-toggle="modal" type="button" data-target="#update_modal<?php echo $fetch['id'] ?>" data-toggle-title="tooltip" data-placement="bottom" title="Update">
                                                            <i class="fa fa-pencil"></i>
                                                            <span class="mobile-icon-only">Update</span>
                                                        </button>
                                                    <?php } ?>

                                                    <a type="button" class="btn text-light btn-sm update" data-toggle="modal" type="button" href="pet_owner_information.php?id=<?php echo $fetch['id'] ?>" data-toggle-title="tooltip" data-placement="bottom" title="View" style="background-color:#3895D3;">
                                                        <i class="fa fa-eye"></i>
                                                        <span class="mobile-icon-only">View</span>
                                                    </a>


                                                    <?php $id =  $fetch['id'];
                                                    $query3 = mysqli_query($conn, "SELECT name, o.id, o.bday, o.gender, contactno, email, province, city, o.fname, o.lname, pet_id, species,breed
                                                            FROM pet AS p 
                                                            INNER JOIN pet_owner AS po 
                                                            ON p.id=po.pet_id 
                                                            INNER JOIN owner AS o
                                                            ON po.owner_id=o.id  WHERE o.id=$id;;");
                                                    $ownerinfo = mysqli_fetch_assoc($query3);
                                                    ?>
                                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-toggle-title="tooltip" data-placement="bottom" title="Add Pet" data-target="#add_pet<?php echo $ownerinfo['id']; ?>">
                                                        <i class="fa fa-plus"> </i>
                                                        <span class="mobile-icon-only">Add Pet </span>
                                                    </button>
                                                </td>
                                            </tr>
                                            <?php
                                            include 'includes/modal/add_pet.php';
                                            include 'includes/modal/update_pet_owner.php';
                                            ?>

                                            <!-- Note hindi pwede tong ilipat sa ibang folder. Dapat nandito or sa pinakang file talaga to, kasi kapag nilipat hindi gagana ang select breed -->
                                            <script>
                                                function getcitymodal<?php echo $fetch['id']; ?>(val) {
                                                    $.ajax({
                                                        type: "POST",
                                                        url: "get_citymunicipality.php",
                                                        data: 'prov_id=' + val,
                                                        success: function(data) {
                                                            $("#city-list<?php echo $fetch['id']; ?>").html(data);
                                                        }
                                                    });
                                                }
                                            </script>
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

            <?php include 'includes/footer.php'; ?>

        </div>


        <!--  DEPENDENT DROPDOWN/ SELECT-->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
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
                lengthMenu: [10, 25, 50, 100],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search pet owner"
                },
                //Disable Action sorting (yung arrow up and down)
                columnDefs: [{
                    'targets': [4], //action
                    /* column index */
                    'orderable': false,
                    /* true or false */
                }],
                order: [
                    [0, "desc"]
                ],
            });
        </script>
        <!--from bootstrap-->
        <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js " integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo " crossorigin="anonymous "></script> -->
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js " integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1 " crossorigin="anonymous "></script> -->
        <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js " integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM " crossorigin="anonymous "></script> -->


</body>

</html>