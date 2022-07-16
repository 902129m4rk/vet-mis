<?php
require_once("includes/config.php");

// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}
if (isset($_SESSION["loggedin"]) && ($_SESSION["utadmin"])) {
?>
    <?php

    if (isset($_POST['submit'])) {
        include_once 'includes/config.php';

        $businessno = filter_input(INPUT_POST, 'business_number');
        $clinicname = ucfirst(filter_input(INPUT_POST, 'clinic_name'));
        $ownerfname = ucfirst(filter_input(INPUT_POST, 'clinic_owner_fname'));
        $ownerlname = ucfirst(filter_input(INPUT_POST, 'clinic_owner_lname'));
        $city = ucfirst(filter_input(INPUT_POST, 'select_city'));
        $province = ucfirst(filter_input(INPUT_POST, 'select_prov'));
        $clinicphoneno = filter_input(INPUT_POST, 'clinic_phoneno');

        //Regular Expression Variable
        $regexclinicname = "/^[a-zA-Z0-9\d\s\.\-]+$/";
        $regexname = "/^[a-zA-Z\s]+$/";
        $regexaddress = "/^[a-zA-Z0-9\d\s\.\-]+$/";
        $regexmobileno = "/^[09|+639]+[0-9\d]{10}$/";
        $regexnumber = "/^[0-9\d\s\-]+$/";
        $regexclinicphoneno = "/^[0-9\d\-\(\)\+\s]+$/";

        //Business Number ERROR
        if (empty($businessno)) {
            $businessno_error = "Please enter a business number";
            // } elseif (strlen($petname) < 3) {
            //     $petname_error = " Pet name needs to have a minimum of 2 letters";
        } elseif (!preg_match($regexnumber, $_POST['business_number'])) {
            $businessno_error = " Please enter a valid business number";
        }

        //CLINIC NAME ERROR
        if (empty($clinicname)) {
            $clinicname_error = "Please enter a name";
            // } elseif (strlen($petname) < 3) {
            //     $petname_error = " Pet name needs to have a minimum of 2 letters";
        } elseif (!preg_match($regexclinicname, $clinicname)) {
            $clinicname_error = " Please enter a valid clinic name";
        }

        //Clinic Phone Number
        if (empty($clinicphoneno)) {
            $clinicphoneno_error = "Please enter clinic phone number";
        } elseif (!preg_match($regexclinicphoneno, $clinicphoneno)) {
            $clinicphoneno_error = " Please enter a phone number";
        }

        //OWNER FIRST NAME ERROR
        if (empty($ownerfname)) {
            $ownerfname_error = "Please enter owner first name";
            // } elseif (strlen($petname) < 3) {
            //     $petname_error = " Pet name needs to have a minimum of 2 letters";
        } elseif (!preg_match($regexname, $_POST['clinic_owner_fname'])) {
            $ownerfname_error = " Please enter a valid name";
        }

        //OWNER LAST NAME ERROR
        if (empty($ownerlname)) {
            $ownerlname_error = "Please enter owner last name";
            // } elseif (strlen($petname) < 3) {
            //     $petname_error = " Pet name needs to have a minimum of 2 letters";
        } elseif (!preg_match($regexname, $_POST['clinic_owner_lname'])) {
            $ownerlname_error = " Please enter a valid name";
        }

        //City/Municipality
        if (empty($city)) {
            $city_error = "Please enter city/municipality";
        }
        //Province
        if (empty($province)) {
            $province_error = "Please enter city/address";
        }

        if (empty($businessno_error) && empty($clinicname_error)  && empty($clinicphoneno_error) && empty($city_error) && empty($province_error) && empty($ownerfname_error) && empty($ownerlname_error)) {

            // V3
            $sql = "INSERT INTO company_info(business_number, clinic_name,clinic_contactno, owner_fname, owner_lname, city, province ) VALUES (?,?,?,?,?,?,?);";
            $stmt = mysqli_stmt_init($conn);

            if (mysqli_stmt_prepare($stmt, $sql)) {
                mysqli_stmt_bind_param($stmt, "sssssss", $businessno, $clinicname, $clinicphoneno, $ownerfname, $ownerlname,  $city, $province);

                // mysqli_stmt_bind_param($stmt, "ssssssss", $ownerfname, $ownerlname, $ownerbday, $ownergender, $ownercity, $ownerprovince, $ownermobileno, $owneremail);

                if (mysqli_stmt_execute($stmt)) {

                    $user_activity = "Add Company Profile";
                    $details = "Company profile was successfully added";
                    include 'includes/log.php';

                    echo "<script language='javascript'>";
                    echo 'alert("Company profile is successfully saved!");';
                    echo 'window.location.replace("company_profile.php?companyprofile=success");';
                    echo "</script>";
                    // header("Location: add_patient.inc.php?addpatient=success");
                    exit();
                } else {
                    echo "<script language='javascript'>";
                    echo 'alert("Something went wrong, Please try again later");';
                    echo 'window.location.replace("company_profile.php?companyprofile=failed");';
                    echo "</script>";
                }
            } else {
                echo "<script language='javascript'>";
                echo 'alert("Something went wrong, Please try again later");';
                echo 'window.location.replace("company_profile.php?companyprofile=failed");';
                echo "</script>";
            }
        }
    }

    ?>
    <?php
    $sql = "SELECT *FROM company_info AS ci
    LEFT JOIN city_municipality AS cm
    ON cm.id = ci.city
    LEFT JOIN province AS prov
    ON prov.id = ci.province ;";
    $result = mysqli_query($conn, $sql);
    $fetch = mysqli_fetch_assoc($result);
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="img/logo.png">
        <title>Company Profile </title>

        <!-- Bootstrap CSS -->
        <?php if (empty($fetch['clinic_name'])) { ?>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">

        <?php } else { ?>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css" integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK" crossorigin="anonymous">
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.min.js" integrity="sha384-5h4UG+6GOuV9qXh6HqOLwZMY4mnLPraeTrjT5v07o347pj6IkfuoASuGBhfDsp3d" crossorigin="anonymous"></script>
            <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
            <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
            <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>
        <?php } ?>


        <!--FONT AWESOME-->
        <link rel="stylesheet" href="path/to/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
        <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">

        <!-- OUR CUSTOM CSS-->
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/form.css">
        <link rel="stylesheet" href="css/tb.css">
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

                        <h5 class="navbar-header-text">Company Profile</h5>

                        <?php include 'includes/top_navbar.php'; ?>
                    </nav>

                    <!--MAIN CONTENT-->
                    <div class="container-fluid">
                        <div class="row mb-3 my-flex-card">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col">
                                        <div class="card shadow mb-3">
                                            <?php if (empty($fetch['clinic_name'])) {
                                            ?>
                                                <div class="card-header py-3">
                                                    <p class="text-primary m-0 font-weight-normal">Company Information</p>
                                                </div>
                                                <div class="card-body">
                                                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="clinic_name">
                                                                        <span>Clinic Name</span>
                                                                        <span class="text-danger"> * </span>
                                                                    </label>
                                                                    <input class="form-control" type="text" placeholder="Enter Veterinary Clinic Name" name="clinic_name" value="<?php if (isset($_POST['clinic_name'])) {
                                                                                                                                                                                        echo $_POST['clinic_name'];
                                                                                                                                                                                    } ?>" required="required">
                                                                    <small class="text-danger">
                                                                        <?php if (isset($clinicname_error)) {
                                                                            echo $clinicname_error;
                                                                        }
                                                                        ?>
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                                                <div class="form-group">
                                                                    <label for="business_number">
                                                                        <span> Business Number</span>
                                                                        <span class="text-danger"> * </span>
                                                                    </label>
                                                                    <input class="form-control" type="number" placeholder="Enter Business Number" name="business_number" value="<?php if (isset($_POST['business_number'])) {
                                                                                                                                                                                    echo $_POST['business_number'];
                                                                                                                                                                                } ?>" required="required">
                                                                    <small class="text-danger">
                                                                        <?php if (isset($businessno_error)) {
                                                                            echo $businessno_error;
                                                                        }
                                                                        ?>
                                                                    </small>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                                                <div class="form-group">
                                                                    <label for="business_number">
                                                                        <span> Clinic Phone Number</span>
                                                                        <span class="text-danger"> * </span>
                                                                    </label>
                                                                    <input class="form-control" type="text" placeholder="Enter Clinic Phone Number" name="clinic_phoneno" value="<?php if (isset($_POST['clinic_phoneno'])) {
                                                                                                                                                                                        echo $_POST['clinic_phoneno'];
                                                                                                                                                                                    } ?>" required="required">
                                                                    <small class="text-danger">
                                                                        <?php if (isset($clinicphoneno_error)) {
                                                                            echo $clinicphoneno_error;
                                                                        }
                                                                        ?>
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                                                <div class="form-group">
                                                                    <label for="clinic_owner_fname">
                                                                        <span> Owner First Name</span>
                                                                        <span class="text-danger"> * </span>
                                                                    </label>
                                                                    <input class="form-control" type="text" placeholder="Enter Owner Name" name="clinic_owner_fname" value="<?php if (isset($_POST['clinic_owner_fname'])) {
                                                                                                                                                                                echo $_POST['clinic_owner_fname'];
                                                                                                                                                                            } ?>" required="required">
                                                                    <small class="text-danger">
                                                                        <?php if (isset($ownerfname_error)) {
                                                                            echo $ownerfname_error;
                                                                        }
                                                                        ?>
                                                                    </small>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                                                <div class="form-group">
                                                                    <label for="clinic_owner_lname">
                                                                        <span> Owner Last Name</span>
                                                                        <span class="text-danger"> * </span>
                                                                    </label>
                                                                    <input class="form-control" type="text" placeholder="Enter Owner Name" name="clinic_owner_lname" value="<?php if (isset($_POST['clinic_owner_lname'])) {
                                                                                                                                                                                echo $_POST['clinic_owner_lname'];
                                                                                                                                                                            } ?>" required="required">
                                                                    <small class="text-danger">
                                                                        <?php if (isset($ownerlname_error)) {
                                                                            echo $ownerlname_error;
                                                                        }
                                                                        ?>
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                                                <div class="form-group">
                                                                    <label for="select_prov">Province<span class="text-danger"> * </span>
                                                                    </label>
                                                                    <select class="form-control" onChange="getcity(this.value);" name="select_prov">

                                                                        <option value='' disabled selected hidden>Select Province</option>
                                                                        <?php
                                                                        $sql = "SELECT *FROM province ORDER BY province_name";
                                                                        $query = mysqli_query($conn, $sql);


                                                                        while ($row = mysqli_fetch_array($query)) {
                                                                            //Remain selected value
                                                                            $selected = '';
                                                                            if (!empty($_POST['select_prov']) and $_POST['select_prov'] == $row['id']) {
                                                                                $selected = ' selected="selected"';  // select
                                                                            }

                                                                            echo '<option value="' . $row['id'] . '"' . $selected . '>' . $row['province_name'] . '</option>';

                                                                        ?>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                                                <div class="form-group">
                                                                    <label for="select_city">City / Municipality<span class="text-danger"> * </span> </label>
                                                                    <!-- <select name="select_patient" id="patient-list" class="form-control"> -->
                                                                    <select class="form-control" name="select_city" id="city-list">
                                                                        <!-- <option value='' disabled selected hidden>Select City / Municipality</option> -->
                                                                        <?php
                                                                        $prov = $_POST['select_prov'];
                                                                        $city = $_POST['select_city'];

                                                                        if (isset($_POST['select_city'])) { ?>
                                                                            <option value='<?php echo $_POST['select_city']; ?>'><?php echo $_POST['select_city']; ?></option>

                                                                            <?php
                                                                            $sql = "SELECT *
                                                                    FROM city_municipality AS cm
                                                                    WHERE province_id='" . $prov . "'
                                                                    ORDER BY citymunicipality_name ASC
                                                                    ;";

                                                                            $query = mysqli_query($conn, $sql);
                                                                            while ($row = mysqli_fetch_array($query)) {
                                                                                $selected = '';
                                                                                if (!empty($_POST['select_city']) and $_POST['select_city'] == $row['id']) {
                                                                                    $selected = ' selected="selected"';  // select
                                                                                }
                                                                                echo '<option value="' . $row['id'] . '"' . $selected . '>' . $row['citymunicipality_name'] . '</option>';
                                                                            }
                                                                        } else { ?>
                                                                            <option value='' disabled selected hidden>Select City / Municipality</option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="mt-3 text-danger ">
                                                            <span> Please make sure all fields are filled in correctly </span>
                                                        </div>
                                                        <div class="form-group ">
                                                            <button class="mt-3 btn btn-primary " type="submit" name="submit">Submit</button>
                                                        </div>
                                                    </form>

                                                <?php
                                            } else {
                                                ?>
                                                    <div class="card-header py-3">
                                                        <div class="row">
                                                            <div class="col-6 ">
                                                                <p class="text-primary m-0 font-weight-normal">Company Profile </p>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class=" float-right">
                                                                    <button class="btn btn-orange text-light btn-sm " data-toggle="modal" type="button" data-target="#update_company_info" data-toggle-title="tooltip" data-placement="bottom" title="Update">
                                                                        <i class="fa fa-pencil"></i>
                                                                        <span class="mobile-icon-only">Update Company Profile</span>
                                                                    </button>
                                                                    <?php include 'includes/modal/update_company_info.php'; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col mb-4 mt-3 text-center">
                                                                <h3 class="text-center">
                                                                    <h3> <?php echo strtoupper($fetch['clinic_name']) ?></h3>
                                                                    <span class="text-center text-secondary"> Information</span>
                                                            </div>
                                                        </div>
                                                        <div class="row ml-5">
                                                            <div class="col-6">
                                                                <div class="row mb-2">
                                                                    <div class="col text-right">
                                                                        <span class="text-secondary "> Business Number </span>
                                                                    </div>
                                                                </div>
                                                                <div class="row  mb-2 ">
                                                                    <div class="col text-right">
                                                                        <span class="text-secondary"> Clinic Name </span>
                                                                    </div>
                                                                </div>
                                                                <div class="row  mb-2 ">
                                                                    <div class="col text-right">
                                                                        <span class="text-secondary"> Clinic Phone Number </span>
                                                                    </div>
                                                                </div>
                                                                <div class="row  mb-2">
                                                                    <div class="col text-right">
                                                                        <span class="text-secondary"> Owner Name </span>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-2 ">
                                                                    <div class="col text-right">
                                                                        <span class="text-secondary"> Address </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="row mb-2">
                                                                    <div class="col text-left">
                                                                        <span> <?php echo htmlspecialchars($fetch['business_number']); ?> </span>
                                                                    </div>
                                                                </div>
                                                                <div class=" row mb-2 ">
                                                                    <div class=" col text-left">
                                                                        <span> <?php echo htmlspecialchars($fetch['clinic_name']); ?> </span>
                                                                    </div>
                                                                </div>
                                                                <div class=" row mb-2 ">
                                                                    <div class=" col text-left">
                                                                        <span> <?php echo htmlspecialchars($fetch['clinic_contactno']); ?> </span>
                                                                    </div>
                                                                </div>
                                                                <div class="row  mb-2">
                                                                    <div class="col text-left">
                                                                        <span> <?php echo htmlspecialchars($fetch['owner_fname']), ' ', htmlspecialchars($fetch['owner_lname']); ?> </span>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-2 ">
                                                                    <div class="col text-left">
                                                                        <span> <?php echo $fetch['citymunicipality_name'], ', ', $fetch['province_name']; ?> </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                <?php
                                            } ?>

                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php include 'includes/footer.php'; ?>
                </div>


                <!--from bootstrap-->
                <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js " integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo " crossorigin="anonymous "></script>
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