<?php
include 'includes/config.php';

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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/logo.png">
    <title>Dashboard </title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css">
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>

    <!--BOX ICONS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <!--FONT AWESOME-->
    <link rel="stylesheet" href="path/to/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">

    <!-- OUR CUSTOM CSS-->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/dashboard.css">

</head>

<body>
    <div class="wrapper ">

        <?php $page = 'dashboard';
        include_once 'includes/sidebar.php'; ?>

        <div class="d-flex flex-column" id="content-wrapper">

            <!-- IF ADMIN YUNG NAG LOG-IN -->
            <?php if (isset($_SESSION["loggedin"]) && ($_SESSION["utadmin"])) { ?>
                <!--CONTENT-->

                <div class="content">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light top-header">
                        <button type="button" id="sidebarCollapse" class="btn menu-btn">
                            <i class="fa fa-align-justify"> </i>
                        </button>
                        <h5 class="navbar-header-text"> Dashboard</h5>

                        <!-- SEARCH BAR -->
                        <form class="form-inline my-2 my-lg-0 ml-3" action="search_pet.php" method="POST">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search-patient" placeholder="Search Pet" required="required">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit" name="submit-search">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                        <?php include 'includes/top_navbar.php'; ?>
                    </nav>
                    <!-- DASHBOARD CONTENT/BOXES -->
                    <div class="container-fluid  dashboard-row">
                        <div class="row dashboard-row1">
                            <div class="col col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                                <div class="text-center ">
                                    <button type="button" class="dashboard-btn btn-light  p-3 mb-4 bg-white rounded dashboard-btn-hover ">
                                        <a href="add_pet.php">
                                            <img src="img/dashboard/pet add.png" class="dashboard-img" />
                                            <p class="dashboard-p"> Add Pet</p>
                                        </a>
                                    </button>
                                </div>
                            </div>
                            <div class="col col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                                <div class="text-center">
                                    <button type="button" class="dashboard-btn btn-light  p-3 mb-4 bg-white rounded dashboard-btn-hover ">
                                        <a href="add_lab_test_list.php">
                                            <img src="img/dashboard/lab add.png" class="dashboard-img" />
                                            <p class="dashboard-p"> Add Lab Result</p>
                                        </a>
                                    </button>
                                </div>
                            </div>

                            <div class="col col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                                <div class="text-center">
                                    <button type="button" class="dashboard-btn btn-light  p-3 mb-4 bg-white rounded dashboard-btn-hover ">
                                        <a href="add_transaction.php">
                                            <img src="img/dashboard/transaction add.png " class="dashboard-img " />
                                            <p class="dashboard-p "> Add Transaction</p>
                                        </a>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row dashboard-row2 ">
                            <div class="col col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                                <div class="text-center ">
                                    <button type="button " class="dashboard-btn btn-light p-3 mb-4 bg-white rounded dashboard-btn-hover ">
                                        <a href="add_pet_medical_records.php">
                                            <img src="img/dashboard/docu add.png " class="dashboard-img " />
                                            <p class="dashboard-p "> Add Medical Record</p>
                                        </a>
                                    </button>
                                </div>
                            </div>
                            <div class="col col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                                <div class="text-center">
                                    <button type="button" class="dashboard-btn btn-light  p-3 mb-4 bg-white rounded dashboard-btn-hover ">
                                        <a href="add_appointment.php">
                                            <img src="img/dashboard/appointment add.png" class="dashboard-img" />
                                            <p class="dashboard-p"> Add Appointment</p>
                                        </a>
                                    </button>
                                </div>
                            </div>
                            <div class="col col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                                <div class="text-center ">
                                    <button type="button " class="dashboard-btn btn-light p-3 mb-4 bg-white rounded dashboard-btn-hover ">
                                        <a href="add_product.php">
                                            <img src="img/dashboard/inventory add.png " class="dashboard-img " />
                                            <p class="dashboard-p "> Add Product</p>
                                        </a>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- IF VET YUNG NAG LOG-IN -->
            <?php
            } elseif (isset($_SESSION["loggedin"]) && ($_SESSION["utvet"])) {
            ?>

                <div class="content">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light top-header">
                        <button type="button" id="sidebarCollapse" class="btn menu-btn">
                            <i class="fa fa-align-justify"> </i>
                        </button>
                        <h5 class="navbar-header-text"> Dashboard</h5>

                        <!-- SEARCH BAR -->
                        <form class="form-inline my-2 my-lg-0 ml-3" action="search_pet.php" method="POST">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search-patient" placeholder="Search Pet" required="required">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit" name="submit-search">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                        <?php include 'includes/top_navbar.php'; ?>
                    </nav>
                    <!-- DASHBOARD CONTENT/BOXES -->
                    <div class="container-fluid  dashboard-row">
                        <div class="row dashboard-row1">
                            <div class="col col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                                <div class="text-center ">
                                    <button type="button" class="dashboard-btn btn-light  p-3 mb-4 bg-white rounded dashboard-btn-hover ">
                                        <a href="add_pet.php">
                                            <img src="img/dashboard/pet add.png" class="dashboard-img" />
                                            <p class="dashboard-p"> Add Pet</p>
                                        </a>
                                    </button>
                                </div>
                            </div>
                            <div class="col col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                                <div class="text-center">
                                    <button type="button" class="dashboard-btn btn-light  p-3 mb-4 bg-white rounded dashboard-btn-hover ">
                                        <a href="add_lab_test_list.php">
                                            <img src="img/dashboard/lab add.png" class="dashboard-img" />
                                            <p class="dashboard-p"> Add Lab Result</p>
                                        </a>
                                    </button>
                                </div>
                            </div>
                            <div class="col col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                                <div class="text-center">
                                    <button type="button" class="dashboard-btn btn-light  p-3 mb-4 bg-white rounded dashboard-btn-hover ">
                                        <a href="add_appointment.php">
                                            <img src="img/dashboard/appointment add.png" class="dashboard-img" />
                                            <p class="dashboard-p"> Add Appointment</p>
                                        </a>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row dashboard-row2 ">
                            <div class="col col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                                <div class="text-center ">
                                    <!-- <button type="button " class="dashboard-btn btn-light p-3 mb-4 bg-white rounded dashboard-btn-hover ">
                                        <a href="pet_list.php">
                                            <img src="img/dashboard/pet view.png " class="dashboard-img " />
                                            <p class="dashboard-p "> View All Pet</p>
                                        </a>
                                    </button> -->
                                    <button type="button " class="dashboard-btn btn-light p-3 mb-4 bg-white rounded dashboard-btn-hover ">
                                        <a href="add_pet_medical_records.php">
                                            <img src="img/dashboard/docu add.png " class="dashboard-img " />
                                            <p class="dashboard-p "> Add Medical Record</p>
                                        </a>
                                    </button>
                                </div>
                            </div>
                            <div class="col col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                                <div class="text-center">
                                    <button type="button" class="dashboard-btn btn-light  p-3 mb-4 bg-white rounded dashboard-btn-hover ">
                                        <a href="laboratory_list.php">
                                            <img src="img/dashboard/lab view.png" class="dashboard-img" />
                                            <p class="dashboard-p"> View All Lab Test</p>
                                        </a>
                                    </button>
                                </div>
                            </div>
                            <div class="col col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                                <div class="text-center">
                                    <button type="button" class="dashboard-btn btn-light  p-3 mb-4 bg-white rounded dashboard-btn-hover ">
                                        <a href="appointment_list.php">
                                            <img src="img/dashboard/appointment view.png" class="dashboard-img" />
                                            <p class="dashboard-p"> Appointment List</p>
                                        </a>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- IF STAFF YUNG NAG LOG-IN -->
            <?php } elseif (isset($_SESSION["loggedin"]) && ($_SESSION["utstaff"])) {
            ?>


                <div class="content">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light top-header">
                        <button type="button" id="sidebarCollapse" class="btn menu-btn">
                            <i class="fa fa-align-justify"> </i>
                        </button>
                        <h5 class="navbar-header-text"> Dashboard</h5>

                        <!-- SEARCH BAR -->
                        <form class="form-inline my-2 my-lg-0 ml-3" action="search_pet.php" method="POST">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search-patient" placeholder="Search Pet" required="required">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit" name="submit-search">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                        <?php include 'includes/top_navbar.php'; ?>
                    </nav>
                    <!-- DASHBOARD CONTENT/BOXES -->
                    <div class="container-fluid  dashboard-row">
                        <div class="row dashboard-row1">
                            <div class="col col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                                <div class="text-center ">
                                    <button type="button" class="dashboard-btn btn-light  p-3 mb-4 bg-white rounded dashboard-btn-hover ">
                                        <a href="add_pet.php">
                                            <img src="img/dashboard/pet add.png" class="dashboard-img" />
                                            <p class="dashboard-p"> Add Pet</p>
                                        </a>
                                    </button>
                                </div>
                            </div>
                            <div class="col col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                                <div class="text-center">
                                    <button type="button" class="dashboard-btn btn-light  p-3 mb-4 bg-white rounded dashboard-btn-hover ">
                                        <a href="add_appointment.php">
                                            <img src="img/dashboard/appointment add.png" class="dashboard-img" />
                                            <p class="dashboard-p"> Add Appointment</p>
                                        </a>
                                    </button>
                                </div>
                            </div>

                            <div class="col col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                                <div class="text-center">
                                    <button type="button" class="dashboard-btn btn-light  p-3 mb-4 bg-white rounded dashboard-btn-hover ">
                                        <a href="add_transaction.php">
                                            <img src="img/dashboard/transaction add.png " class="dashboard-img " />
                                            <p class="dashboard-p "> Add Transaction</p>
                                        </a>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row dashboard-row2 ">
                            <div class="col col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                                <div class="text-center ">
                                    <!-- <button type="button " class="dashboard-btn btn-light p-3 mb-4 bg-white rounded dashboard-btn-hover ">
                                        <a href="pet_list.php">
                                            <img src="img/dashboard/pet view.png " class="dashboard-img " />
                                            <p class="dashboard-p "> View All Pet</p>
                                        </a>
                                    </button> -->
                                    <button type="button " class="dashboard-btn btn-light p-3 mb-4 bg-white rounded dashboard-btn-hover ">
                                        <a href="add_pet_doc.php">
                                            <img src="img/dashboard/docu add.png " class="dashboard-img " />
                                            <p class="dashboard-p "> Add Pet Document</p>
                                        </a>
                                    </button>
                                </div>
                            </div>
                            <div class="col col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                                <div class="text-center">
                                    <button type="button" class="dashboard-btn btn-light  p-3 mb-4 bg-white rounded dashboard-btn-hover ">
                                        <a href="laboratory_list.php">
                                            <img src="img/dashboard/lab view.png" class="dashboard-img" />
                                            <p class="dashboard-p"> View All Lab Test</p>
                                        </a>
                                    </button>
                                </div>
                            </div>
                            <div class="col col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                                <div class="text-center ">
                                    <button type="button " class="dashboard-btn btn-light p-3 mb-4 bg-white rounded dashboard-btn-hover ">
                                        <a href="transaction_list.php">
                                            <img src="img/dashboard/transaction view.png " class="dashboard-img " />
                                            <p class="dashboard-p "> View All Transaction</p>
                                        </a>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>




            <?php
            } else {
                header('Location: index.php');
            } ?>


            <?php include_once 'includes/footer.php'; ?>
        </div>
    </div>







    <!--Icon-->
    <script src="https://unpkg.com/ionicons@5.2.3/dist/ionicons.js "></script>
    <!--OUR JS-->
    <script src="js/script.js "></script>
    <!--OUR JS-->
    <script src="js/script.js"></script>

</body>





</html>