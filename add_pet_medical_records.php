<?php
require_once 'includes/config.php';

// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}
if (isset($_SESSION["loggedin"]) && ($_SESSION["utadmin"]) or ($_SESSION["utvet"])) {
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="img/logo.png">
        <title>Add Medical Record </title>

        <!-- Bootstrap CSS CDN -->
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">

        <!--FONT AWESOME-->
        <link rel="stylesheet" href="path/to/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
        <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">

        <!-- OUR CUSTOM CSS-->
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/form.css">

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css">

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

        <!-- (Optional) Latest compiled and minified JavaScript translation files -->
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/i18n/defaults-*.min.js"></script> -->



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

                        <h5 class="navbar-header-text">Add Medical Record</h5>

                        <?php include 'includes/top_navbar.php'; ?>
                    </nav>

                    <!--MAIN CONTENT-->
                    <div class="container-fluid">
                        <div class="row mb-3 my-flex-card">
                            <div class="col">
                                <div class="row">
                                    <div class="col">
                                        <div class="card shadow mb-3">
                                            <div class="card-header py-3">
                                                <p class="text-primary m-0 font-weight-normal">Add Medical Record</p>
                                            </div>
                                            <div class="card-body">
                                                <!-- <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> -->
                                                <form action="includes/modal/add_pet_medical_records_query.php" method="post" enctype="multipart/form-data">
                                                    <div class="row mb-2">
                                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                                            <div class="form-col">
                                                                <label for="select_owner">Pet Owner Name <span class="text-danger"> * </span> </label>
                                                                <select class="form-control placeholder js-example-basic-single" title="Select Pet Owner" data-actions-box="true" data-live-search="true" onChange="getpatient(this.value);" name="select_owner" required="required">
                                                                    <option value='' disabled selected hidden>Select Pet Owner</option>
                                                                    <?php
                                                                    // $query = mysqli_query($conn, "SELECT * FROM 'owner' ");
                                                                    $sql = "SELECT *
                                                                 FROM owner ORDER BY fname";
                                                                    $query = mysqli_query($conn, $sql);


                                                                    while ($row = mysqli_fetch_array($query)) {
                                                                        //Remain selected value
                                                                        $selected = '';
                                                                        if (!empty($_POST['select_owner']) and $_POST['select_owner'] == $row['id']) {
                                                                            $selected = ' selected="selected"';  // select
                                                                        }
                                                                        echo '<option value="' . $row['id'] . '"' . $selected . '>' . $row['fname'], ' ', $row['lname'] . '</option>';
                                                                    ?>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>

                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                                            <div class="form-col">
                                                                <label for="select_patient">Pet Name<span class="text-danger"> * </span> </label>
                                                                <select class="form-control placeholder js-example-basic-single" data-live-search="true" name="id" id="patient-list" required="required">
                                                                    <option value="">Select Pet</option>

                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="pet_name">
                                                            <span> Choose File</span>
                                                        </label>
                                                        <input type='file' name='file' class="form-control">

                                                    </div>
                                                    <div class="form-group mt-2 mb-2">
                                                        <label for="file_description"><span> Findings </span> </label>
                                                        <textarea class="form-control" name="findings" rows="5"></textarea>

                                                    </div>
                                                    <div class="form-group mt-2 mb-2">
                                                        <label for="file_description"><span> Prescription </span> </label>
                                                        <textarea class="form-control" name="prescription" rows="5"></textarea>

                                                    </div>
                                                    <div class="form-group mt-2 mb-2">
                                                        <label for="file_description"><span> Description </span> </label>
                                                        <textarea class="form-control" name="description" rows="5"></textarea>

                                                    </div>
                                                    <div class="mt-3 text-danger ">
                                                        <span> Please make sure all fields are filled in correctly </span>
                                                    </div>
                                                    <div class="form-group ">
                                                        <button class="mt-3 btn btn-primary " type="submit" name="add">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include 'includes/footer.php'; ?>
            </div>


            <!-- Note hindi pwede tong ilipat sa ibang folder. Dapat nandito or sa pinakang file talaga to, kasi kapag nilipat hindi gagana ang select breed -->
            <script>
                function getpatient(val) {
                    $.ajax({
                        type: "POST",
                        url: "get_patient.php",
                        data: 'patient_id=' + val,
                        success: function(data) {
                            $("#patient-list").html(data);
                        }
                    });
                }
            </script>
            <!--  SEARCH IN DROPDOWN-->
            <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
            <script>
                $(".js-example-basic-single").select2({
                    //         // width: 'resolve',
                    //         // theme: "classic"

                });
            </script>
            <!--from bootstrap-->
            <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js " integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo " crossorigin="anonymous "></script> -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js " integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1 " crossorigin="anonymous "></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js " integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM " crossorigin="anonymous "></script>
            <!--Icon-->
            <script src="https://unpkg.com/ionicons@5.2.3/dist/ionicons.js "></script>
            <!--OUR JS-->
            <script src="js/script.js"></script>
            <!--  DEPENDENT DROPDOWN/ SELECT-->
            <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
            <script src="js/bootstrap.min.js"></script>
            <!-- Note hindi pwede tong ilipat sa ibang folder. Dapat nandito or sa pinakang file talaga to, kasi kapag nilipat hindi gagana ang select breed -->
            <script>
                function getcity(val) {
                    $.ajax({
                        type: "POST",
                        url: "get_citymunicipality.php",
                        data: 'prov_id=' + val,
                        success: function(data) {
                            $("#city-list").html(data);
                        }
                    });
                }
            </script>


    </body>

    </html>
<?php } else {
    include '404.php';
} ?>