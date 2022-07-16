<?php
// Initialize the session


// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
} ?>

<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/logo.png">
    <title>404 ERROR </title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css" integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.min.js" integrity="sha384-5h4UG+6GOuV9qXh6HqOLwZMY4mnLPraeTrjT5v07o347pj6IkfuoASuGBhfDsp3d" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

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
        $page = '';
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
                    <?php include 'includes/top_navbar.php'; ?>
                </nav>

                <!--MAIN CONTENT-->
                <div class="container-fluid">
                    <div class="card shadow">
                        <div class="card-body">
                            <div class="row mt-5">
                                <img src="img/404.png" alt="404 error" class="img-fluid mx-auto d-block">
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <div class="text-center mt-3 mb-5">
                                        <a class="btn btn-lg btn-primary " type="button" name="submit" href="dashboard.php">
                                            Go Back to Dashboard
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <?php include 'includes/footer.php'; ?>


    <!--Icon-->
    <script src="https://unpkg.com/ionicons@5.2.3/dist/ionicons.js "></script>
    <!--OUR JS-->
    <script src="js/script.js "></script>
</body>

</html>