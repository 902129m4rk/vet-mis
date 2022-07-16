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

    if (!isset($user_username)) {
        $user_username = "";
    }


    // session_start();
?>
    <?php
    if (isset($_POST['submit'])) {
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
        $user_username = filter_input(INPUT_POST, 'user_username');
        $userpass = filter_input(INPUT_POST, 'user_pass');
        $userrpass = filter_input(INPUT_POST, 'user_rpass');
        $userstat = "Active";


        //Regular Expression Variable
        $regexname = "/^[a-zA-Z\s\,\-]+$/";
        $regexaddress = "/^[a-zA-Z0-9\d\s\.\-]+$/";
        $regexmobileno = "/^[09|+639]+[0-9\d]{10}$/";
        $regexemail = "/^[a-zA-Z\d\._]+@[a-zA-Z\d\._]+\.[a-zA-Z\d]{2,}+$/";
        $regexpassword =  "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[^\w\s]).{8,}$/";

        //FORMVALIDATION

        // User First Name
        if (empty($userfname)) {
            $userrfname_error = "Please enter user first name";
        } elseif (!preg_match($regexname, $_POST['user_fname'])) {
            $userrfname_error = " Please enter a valid first name";
        }

        // User Middle Name
        if (!preg_match($regexname, $_POST['user_mname'])) {
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
        } elseif (!preg_match($regexmobileno, $usermobileno)) {
            $usermobileno_error = "Please enter a valid character or follow the format (09XXXXXXXXX or +639XXXXXXXXX)";
        }

        //User E-mail
        if (empty($useremail)) {
            $useremail_error = "Please enter an e-mail address";
        } elseif (!filter_var($useremail, FILTER_VALIDATE_EMAIL) && !preg_match($regexemail, $_POST['user_email'])) {
            $useremail_error = "Please enter a valid email address";
        } else {
            $sql = "SELECT empid FROM users WHERE email = ?";

            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "s", $param_email);

                $param_email = trim($_POST["user_email"]);
                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_store_result($stmt);

                    if (mysqli_stmt_num_rows($stmt) == 1) {
                        $useremail_error = "This email is already taken.";
                    } else {
                        $useremail = trim($_POST["user_email"]);
                    }
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }
                mysqli_stmt_close($stmt);
            }
        }


        // User Type
        if (empty($usertype)) {
            $usertype_error = "Please select usertype ";
        }

        // User Username
        if (empty($user_username)) {
            $username_error = "Please enter username";
        } else {
            $sql = "SELECT empid FROM users WHERE username = ?";

            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "s", $param_username);

                $param_username = trim($_POST["user_username"]);
                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_store_result($stmt);

                    if (mysqli_stmt_num_rows($stmt) == 1) {
                        $username_error = "This username is already taken.";
                    } else {
                        $user_username = trim($_POST["user_username"]);
                    }
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }
                mysqli_stmt_close($stmt);
            }
        }

        //User Password
        if (empty($userpass)) {
            $pass_error = "Please enter user password";
        } elseif (!preg_match($regexpassword, $userpass)) {
            $pass_error = 'Your password must contain 8 or more characters with a mix of upper and lowercase letters, numbers & symbols';
        }

        //User  Repeat Password
        if (empty($userrpass)) {
            $rpass_error = "Please repeat password";
        } elseif ($userrpass != $userpass) {
            $rpass_error = "Password did not match";
        }



        if (empty($userrfname_error) && empty($userrmname_error) && empty($usermname_error) && empty($userlname_error) && empty($userbday_error)  && empty($usermobileno_error) && empty($useremail_error) && empty($usertype_error) && empty($username_error) && empty($pass_error) && empty($rpass_error) && empty($usercity_error) && empty($userprovince_error)) {

            // V3
            $sql = "INSERT INTO users(user_type, user_status, user_fname, user_mname, user_lname, gender, bday, city, province, email, username, pass,contact_no, created_date) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?, NOW());";
            $stmt = mysqli_stmt_init($conn);
            if (mysqli_stmt_prepare($stmt, $sql)) {
                mysqli_stmt_bind_param($stmt, "sssssssssssss", $usertype, $userstat,  $userfname, $usermname, $userlname, $usergender, $userbday, $usercity, $userprovince, $useremail, $user_username, $userpass, $usermobileno);


                $userpass = password_hash($userpass, PASSWORD_DEFAULT); // Creates a password hash (PARA DI MAKITA YUNG PASSWORD SA DATABASE TABLE)

                if (mysqli_stmt_execute($stmt)) {
                    $user_id = mysqli_insert_id($conn);

                    $user_activity = "Add User";
                    $details = "Add user named '$userfname $userlname', id '$user_id'";
                    include 'includes/log.php';

                    echo "<script language='javascript'>";
                    echo 'alert("' . $userfname, ' ', $userlname . ' is successfully added!");';
                    echo 'window.location.replace("user_list?addpatient=success");';
                    echo "</script>";
                    // header("Location: add_patient.inc.php?addpatient=success");

                }
            } else {
                echo "<script language='javascript'>";
                echo 'alert("Something went wrong, Please try again later");';
                echo 'window.location.replace("../../add_user.php?add_user=failed");';
                echo "</script>";
            }
        }
        // NOTE: dapat walang else dito kasi mag error yung code
    }


    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="img/logo.png">
        <title>Add User </title>

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
            $page = 'usermanager';
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

                        <h5 class="navbar-header-text">Add User</h5>

                        <?php include 'includes/top_navbar.php'; ?>

                    </nav>

                    <!--MAIN CONTENT-->
                    <div class="container-fluid">
                        <div class="row mb-3 my-flex-card">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col">
                                        <div class="card shadow mb-3">
                                            <div class="card-header py-3">
                                                <p class="text-primary m-0 font-weight-normal">User Information</p>
                                            </div>
                                            <div class="card-body">
                                                <!-- <form id="form1" action="add_patient.result.php" method="POST"> -->
                                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                                    <div class="form-row">
                                                        <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
                                                            <div class="form-group">
                                                                <label for="user_fname">
                                                                    <span> First Name</span> <span class="text-danger"> * </span>
                                                                </label>
                                                                <input class="form-control" type="text" placeholder="Enter User First Name" name="user_fname" value="<?php if (isset($_POST['user_fname'])) {
                                                                                                                                                                            echo $_POST['user_fname'];
                                                                                                                                                                        } ?>" required="required">
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
                                                                <input class="form-control" type="text" placeholder="Enter User Middle Name" name="user_mname" value="<?php if (isset($_POST['user_mname'])) {
                                                                                                                                                                            echo $_POST['user_mname'];
                                                                                                                                                                        } ?>">

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
                                                                <input class="form-control" type="text" placeholder="Enter User Last Name" name="user_lname" value="<?php if (isset($_POST['user_lname'])) {
                                                                                                                                                                        echo $_POST['user_lname'];
                                                                                                                                                                    } ?>" required="required">
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
                                                                <label for="user_bday"><span> Birthdate</span> <span class="text-danger"> * </span> </label>
                                                                <input class="form-control" type="date" placeholder="Select Birthdate" name="user_bday" value="<?php if (isset($_POST['user_bday'])) {
                                                                                                                                                                    echo $_POST['user_bday'];
                                                                                                                                                                } ?>" required="required">
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

                                                    <div class="form-row">
                                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                                            <div class="form-group">
                                                                <label for="user_mobilenumber">
                                                                    <span> Mobile Number</span> <span class="text-danger"> * </span>
                                                                </label>
                                                                <input class="form-control" type="text" placeholder="Enter User Mobile Number" name="user_mobilenumber" value="<?php if (isset($_POST['user_mobilenumber'])) {
                                                                                                                                                                                    echo $_POST['user_mobilenumber'];
                                                                                                                                                                                } ?>" required="required">
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
                                                                <input class="form-control" type="text" placeholder="Enter User E-mail" name="user_email" value="<?php if (isset($_POST['user_email'])) {
                                                                                                                                                                        echo $_POST['user_email'];
                                                                                                                                                                    } ?>" required="required">
                                                                <small class="text-danger">
                                                                    <?php if (isset($useremail_error)) {
                                                                        echo $useremail_error;
                                                                    }
                                                                    ?>
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card shadow mb-5">
                            <div class="card-header py-3">
                                <p class="text-primary m-0 font-weight-normal">Security</p>
                            </div>
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <label for="user_type">User Type <span class="text-danger"> * </span> </label>
                                            <select class="form-control placeholder" name="user_type" required="required">
                                                <option value="">Select User Type</option>
                                                <option value="Admin" <?php if (isset($usertype) && $usertype == "Admin") echo "selected" ?>>Admin </option>
                                                <option value="Staff" <?php if (isset($usertype) && $usertype == "Staff") echo "selected" ?>>Staff</option>
                                                <option value="Veterinarian" <?php if (isset($usertype) && $usertype == "Veterinarian") echo "selected" ?>>Veterinarian</option>
                                            </select>
                                            <small class="text-danger">
                                                <?php if (isset($usertype_error)) {
                                                    echo $usertype_error;
                                                }
                                                ?>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <label for="user_username">
                                                <span> Username</span> <span class="text-danger"> * </span>
                                            </label>
                                            <input class="form-control" type="text" placeholder="Enter Username" name="user_username" value="<?php if (isset($_POST['user_username'])) {
                                                                                                                                                    echo $_POST['user_username'];
                                                                                                                                                } ?>" required="required">
                                            <small class="text-danger">
                                                <?php if (isset($username_error)) {
                                                    echo $username_error;
                                                }
                                                ?>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <label for="user_pass">
                                                <span> Password</span>
                                                <span class="text-danger"> * </span>
                                            </label>
                                            <!-- <input class="form-control" type="password" minlength="8" placeholder="Enter User Password" name="user_pass" value="<?php if (isset($_POST['user_pass'])) {
                                                                                                                                                                            echo $_POST['user_pass'];
                                                                                                                                                                        } ?>" required="required"> -->

                                            <div class="input-group" id="show_hide_password">
                                                <input class="form-control" type="password" minlength="8" placeholder="Enter User Password" name="user_pass" value="<?php if (isset($_POST['user_pass'])) {
                                                                                                                                                                        echo $_POST['user_pass'];
                                                                                                                                                                    } ?>" required="required">
                                                <div class="input-group-prepend input-group-addon">
                                                    <div class="input-group-text">
                                                        <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <small class="text-danger">
                                                <?php if (isset($pass_error)) {
                                                    echo $pass_error;
                                                }
                                                ?>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <label for="user_rpass">
                                                <span> Repeat Password</span>
                                                <span class="text-danger"> * </span>
                                            </label>
                                            <div class="input-group" id="show_hide_password2">
                                                <input class="form-control" type="password" placeholder="Repeat Password" name="user_rpass" value="<?php if (isset($_POST['user_rpass'])) {
                                                                                                                                                        echo $_POST['user_rpass'];
                                                                                                                                                    } ?>" required="required">
                                                <div class="input-group-prepend input-group-addon">
                                                    <div class="input-group-text">
                                                        <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                                    </div>
                                                </div>
                                            </div>

                                            <small class="text-danger">
                                                <?php if (isset($rpass_error)) {
                                                    echo $rpass_error;
                                                }
                                                ?>
                                            </small>
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
                $(document).ready(function() {
                    $("#show_hide_password a").on('click', function(event) {
                        event.preventDefault();
                        if ($('#show_hide_password input').attr("type") == "text") {
                            $('#show_hide_password input').attr('type', 'password');
                            $('#show_hide_password i').addClass("fa-eye-slash");
                            $('#show_hide_password i').removeClass("fa-eye");
                        } else if ($('#show_hide_password input').attr("type") == "password") {
                            $('#show_hide_password input').attr('type', 'text');
                            $('#show_hide_password i').removeClass("fa-eye-slash");
                            $('#show_hide_password i').addClass("fa-eye");
                        }
                    });
                    $("#show_hide_password2 a").on('click', function(event) {
                        event.preventDefault();
                        if ($('#show_hide_password2 input').attr("type") == "text") {
                            $('#show_hide_password2 input').attr('type', 'password');
                            $('#show_hide_password2 i').addClass("fa-eye-slash");
                            $('#show_hide_password2 i').removeClass("fa-eye");
                        } else if ($('#show_hide_password2 input').attr("type") == "password") {
                            $('#show_hide_password2 input').attr('type', 'text');
                            $('#show_hide_password2 i').removeClass("fa-eye-slash");
                            $('#show_hide_password2 i').addClass("fa-eye");
                        }
                    });
                });
            </script>

    </body>

    </html>
<?php } else {
    include '404.php';
} ?>