<?php
require_once("includes/config.php");

// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}

if (!isset($user_username)) {
    $user_username = "";
}

// session_start();
?>
<?php
$currentuser = $_SESSION["empid"];

if (isset($_POST['saveinfo'])) {
    include_once 'includes/config.php';

    //USER
    $userfname = ucfirst(filter_input(INPUT_POST, 'user_fname'));
    $usermname = ucfirst(filter_input(INPUT_POST, 'user_mname'));
    $userlname = ucfirst(filter_input(INPUT_POST, 'user_lname'));
    $userbday = filter_input(INPUT_POST, 'user_bday');
    $usergender = filter_input(INPUT_POST, 'user_gender');
    $usercity = ucfirst(filter_input(INPUT_POST, 'select_city'));
    $userprovince = ucfirst(filter_input(INPUT_POST, 'select_prov'));
    $usermobileno = filter_input(INPUT_POST, 'user_mobilenumber');
    $useremail = filter_input(INPUT_POST, 'user_email');
    $usertype = filter_input(INPUT_POST, 'user_type');

    //Regular Expression Variable
    $regexname = "/^[a-zA-Z\s\,\-]+$/";
    $regexaddress = "/^[a-zA-Z0-9\d\s\.\-]+$/";
    $regexmobileno = "/^[09|+639]+[0-9\d]{10}$/";
    $regexemail = "/^[a-zA-Z\d\._]+@[a-zA-Z\d\._]+\.[a-zA-Z\d]{2,}+$/";


    //FORM VALIDATION

    // User First Name
    if (empty($userfname)) {
        $userrfname_error = "Please enter user first name";
    } elseif (!preg_match($regexname, $_POST['user_fname'])) {
        $userrfname_error = " Please enter a valid first name";
    }

    // User Middle Name
    if (!preg_match($regexname, $usermname)) {
        $userrmname_error = " Please enter a valid middle name";
    }

    //User Last Name
    if (empty($userlname)) {
        $userlname_error = "Please enter last name";
    } elseif (!preg_match($regexname, $_POST['user_lname'])) {
        $userlname_error = " Please enter a valid last name";
    }

    //User Birthday
    if (empty($userbday)) {
        $userbday_error = "Please select a birthdate";
    }

    //User GENDER
    if (empty($usergender)) {
        $usergender_error = "Please select a gender";
    }

    //User City/Municipality
    if (empty($usercity)) {
        $usercity_error = "Please enter city/municipality";
    }

    //User Province
    if (empty($userprovince)) {
        $userprovince_error = "Please enter province";
    }

    //User Mobile Number
    if (empty($usermobileno)) {
        $usermobileno_error = "Please enter mobile number";
    } elseif (!preg_match($regexmobileno, $_POST['user_mobilenumber'])) {
        $usermobileno_error = "Please enter a valid character or follow the format (09XXXXXXXXX or +639XXXXXXXXX)";
    }

    //User E-mail
    if (empty($useremail)) {
        $useremail_error = "Please enter an e-mail address";
    } elseif (!filter_var($useremail, FILTER_VALIDATE_EMAIL) && !preg_match($regexemail, $_POST['user_email'])) {
        $useremail_error = "Please enter a valid email address";
    }


    if (empty($userrfname_error)  && empty($userrmname_error) && empty($userlname_error) && empty($userbday_error) && empty($usercity_error) && empty($userprovince_error) && empty($usermobileno_error) && empty($useremail_error)) {
        $sql = " UPDATE `users`
        SET `user_fname` = '$userfname',
        `user_mname`= '$usermname',
        `user_lname` ='$userlname',
        `gender` = '$usergender',
        `bday` = '$userbday',
        `city` = '$usercity',
        `province` = '$userprovince',
        `email` = '$useremail',
        `contact_no` = '$usermobileno'
        WHERE `empid` = '$currentuser'";

        $stmt = mysqli_stmt_init($conn);
        if (mysqli_stmt_prepare($stmt, $sql)) {
            if (mysqli_stmt_execute($stmt)) {

                $user_activity = "Update Account Information";
                $details =  "User's information was successfully updated";
                include 'includes/log.php';

                echo "<script language='javascript'>";
                echo 'alert("Your account information is successfully updated!");';
                echo 'window.location.replace("account_setting_info?updateaccount=success");';
                echo "</script>";
                exit();
            }
        } else {
            echo "<script language='javascript'>";
            echo 'alert("Something went wrong,Please try again later");';
            echo 'window.location.replace("../../account_setting_info?updatepatient=failed");';
            echo "</script>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/logo.png">
    <title>Account Setting - Information </title>

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

</head>

<body>
    <div class="wrapper ">
        <?php
        $page = '';
        include_once 'includes/sidebar.php';
        ?>

        <div class="d-flex flex-column" id="content-wrapper">
            <!--CONTENT-->
            <div class="content">

                <!--TOP NAVBAR/ HEADER-->
                <nav class="navbar navbar-expand-lg navbar-light bg-light top-header">
                    <button type="button" id="sidebarCollapse" class="btn menu-btn">
                        <i class="fa fa-align-justify"> </i>
                    </button>

                    <h5 class="navbar-header-text">Account Setting</h5>

                    <?php include 'includes/top_navbar.php'; ?>

                </nav>


                <!--MAIN CONTENT-->
                <div class="container-fluid">
                    <!-- NAV -->
                    <ul class="nav topnav mb-4">
                        <li class="nav-item">
                            <a class=" nav-link active" href="account_setting_info.php">Information</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-secondary" href="account_setting_security.php">Security</a>
                        </li>
                    </ul>
                    <div class="row mb-3 my-flex-card">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col">
                                    <div class="card shadow mb-3">
                                        <div class="card-header py-3">
                                            <p class="text-primary m-0 font-weight-normal">Information</p>
                                        </div>
                                        <div class="card-body">

                                            <?php


                                            $sql2 = "SELECT * FROM users WHERE empid='$currentuser'";

                                            $curesult = mysqli_query($conn, $sql2);

                                            if ($curesult) {
                                                if (mysqli_num_rows($curesult) > 0) {
                                                    while ($row = mysqli_fetch_array($curesult)) { ?>
                                                        <!-- <form id="form1" action="add_patient.result.php" method="POST"> -->
                                                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                                                            <div class="form-row">
                                                                <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
                                                                    <div class="form-group">
                                                                        <label for="user_fname">
                                                                            <span> First Name</span> <span class="text-danger"> * </span>
                                                                        </label>
                                                                        <input class="form-control" type="text" placeholder="Enter User First Name" name="user_fname" value="<?php echo $row['user_fname']; ?>" required="required">
                                                                        <small class="text-danger">
                                                                            <?php if (isset($userrfname_error)) {
                                                                                echo $userrfname_error;
                                                                            }
                                                                            ?>
                                                                        </small>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
                                                                    <div class="form-group">
                                                                        <label for="user_mname">
                                                                            <span> Middle Name</span>
                                                                        </label>
                                                                        <input class="form-control" type="text" placeholder="Enter User Middle Name" name="user_mname" value="<?php echo $row['user_mname']; ?>">

                                                                        <small class="text-danger">
                                                                            <?php if (isset($userrmname_error)) {
                                                                                echo $userrmname_error;
                                                                            }
                                                                            ?>
                                                                        </small>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
                                                                    <div class="form-group">
                                                                        <label for="user_lname">
                                                                            <span> Last Name</span> <span class="text-danger"> * </span>
                                                                        </label>
                                                                        <input class="form-control" type="text" placeholder="Enter User Last Name" name="user_lname" value="<?php echo $row['user_lname']; ?>" required="required">
                                                                        <small class="text-danger">
                                                                            <?php if (isset($userlname_error)) {
                                                                                echo $userlname_error;
                                                                            }
                                                                            ?>
                                                                        </small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                                                    <div class="form-group">
                                                                        <label for="user_bday"><span>Birthdate</span> <span class="text-danger"> * </span> </label>
                                                                        <input class="form-control" type="date" placeholder="Select Birthdate" name="user_bday" value="<?php echo $row['bday']; ?>" required="required">
                                                                        <small class="text-danger">
                                                                            <?php if (isset($userbday_error)) {
                                                                                echo $userbday_error;
                                                                            }
                                                                            ?>
                                                                        </small>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                                                    <div class="form-group">
                                                                        <?php $usergender = $row['gender']; ?>

                                                                        <label for="user_gender">Gender <span class="text-danger"> * </span> </label>
                                                                        <select class="form-control placeholder" name="user_gender" required="required">
                                                                            <option value="">Select Gender</option>
                                                                            <option value="Male" <?php if (isset($usergender) && $usergender == "Male") echo "selected" ?>>Male </option>
                                                                            <option value="Female" <?php if (isset($usergender) && $usergender == "Female") echo "selected" ?>>Female</option>
                                                                            <option value="LGBTQIA+" <?php if (isset($usergender) && $usergender == "LGBTQIA+") echo "selected" ?>>LGBTQIA+</option>
                                                                        </select>
                                                                        <small class="text-danger">
                                                                            <?php if (isset($usergender_error)) {
                                                                                echo $usergender_error;
                                                                            }
                                                                            ?>
                                                                        </small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-row">

                                                                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                                                    <div class="form-group">
                                                                        <label for="select_prov">Province<span class="text-danger"> * </span>
                                                                        </label>
                                                                        <select class="form-control" onChange="getcity(this.value);" name="select_prov" required>
                                                                            <?php
                                                                            $provid = $row['province'];
                                                                            $sqlprov = "SELECT *FROM province WHERE id= '$provid'
                                                                             ORDER BY province_name";
                                                                            $queryprov = mysqli_query($conn, $sqlprov);
                                                                            $fetchprov = mysqli_fetch_assoc($queryprov);
                                                                            $province = $fetchprov['province_name'];

                                                                            if (!empty($row['province'])) { ?>
                                                                                <option value='<?php echo $row['province']; ?>'><?php echo $province; ?></option>
                                                                            <?php } else { ?>
                                                                                <option value='' disabled selected hidden>Select Province</option>
                                                                            <?php } ?>
                                                                            <?php
                                                                            $sql = "SELECT *FROM province ORDER BY province_name";
                                                                            $query = mysqli_query($conn, $sql);


                                                                            while ($row2 = mysqli_fetch_array($query)) {
                                                                                //Remain selected value
                                                                                $selected = '';
                                                                                if (!empty($_POST['select_prov']) and $_POST['select_prov'] == $row2['province_name']) {
                                                                                    $selected = ' selected="selected"';  // select
                                                                                }

                                                                                echo '<option value="' . $row2['id'] . '"' . $selected . '>' . $row2['province_name'] . '</option>';
                                                                            }
                                                                            ?>


                                                                        </select>

                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                                                    <div class="form-group">
                                                                        <label for="select_city">City / Municipality<span class="text-danger"> * </span> </label>
                                                                        <select class="form-control" name="select_city" id="city-list" required>

                                                                            <?php
                                                                            $cityid = $row['city'];
                                                                            $sqlcity = "SELECT *FROM city_municipality 
                                                                            WHERE id= '$cityid'
                                                                            ORDER BY citymunicipality_name;";
                                                                            $querycity = mysqli_query($conn, $sqlcity);
                                                                            $fetchprov = mysqli_fetch_assoc($querycity);
                                                                            $city = $fetchprov['citymunicipality_name'];

                                                                            if (!empty($row['city'])) { ?>
                                                                                <option value='<?php echo $row['city']; ?>'><?php echo $city; ?></option>
                                                                                <?php
                                                                                $prov = $row['province'];
                                                                                $sql = "SELECT *
                                                                                    FROM city_municipality AS cm
                                                                                    WHERE province_id='" . $prov . "'
                                                                                    ORDER BY citymunicipality_name ASC
                                                                                    ;";

                                                                                $query = mysqli_query($conn, $sql);
                                                                                while ($row2 = mysqli_fetch_array($query)) {
                                                                                    $selected = '';
                                                                                    if (!empty($_POST['select_city']) and $_POST['select_city'] == $row2['id']) {
                                                                                        $selected = ' selected="selected"';  // select
                                                                                    }
                                                                                    echo '<option value="' . $row2['id'] . '"' . $selected . '>' . $row2['citymunicipality_name'] . '</option>';
                                                                                }
                                                                            } else { ?>
                                                                                <option value='' disabled selected hidden>Select City / Municipality</option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <div class="form-row">
                                                                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                                                    <div class="form-group">
                                                                        <label for="user_mobilenumber">
                                                                            <span> Mobile Number</span> <span class="text-danger"> * </span>
                                                                        </label>
                                                                        <input class="form-control" type="text" placeholder="Enter User Mobile Number" name="user_mobilenumber" value="<?php echo $row['contact_no']; ?>" required="required">
                                                                        <small class="text-danger">
                                                                            <?php if (isset($usermobileno_error)) {
                                                                                echo $usermobileno_error;
                                                                            }
                                                                            ?>
                                                                        </small>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                                                    <div class="form-group">
                                                                        <label for="user_email">
                                                                            <span> E-mail</span> <span class="text-danger"> * </span>
                                                                        </label>
                                                                        <input class="form-control" type="text" placeholder="Enter User E-mail" name="user_email" value="<?php echo $row['email']; ?>" required="required">
                                                                        <small class="text-danger">
                                                                            <?php if (isset($useremail_error)) {
                                                                                echo $useremail_error;
                                                                            }
                                                                            ?>
                                                                        </small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group ">
                                                                <button class="mt-1 btn btn-primary " type="submit" name="saveinfo">Update Information</button>
                                                            </div>
                                                        </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



        <?php


                                                    }
                                                }
                                            }


        ?>




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