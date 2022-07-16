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

if (isset($_POST['savepassword'])) {

    $current_pass = filter_input(INPUT_POST, 'user_currentpass');
    $new_pass = filter_input(INPUT_POST, 'user_newpass');
    $confirm_pass = filter_input(INPUT_POST, 'user_confirmpass');

    //Regular Expression Variable
    $regexpassword =  "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[^\w\s]).{8,}$/";

    //User Current Password
    if (empty($current_pass)) {
        $currentpass_error = "Please enter current password";
    }

    //User New Password
    if (empty($new_pass)) {
        $newpass_error = "Please enter new password";
    } elseif (!preg_match($regexpassword, $new_pass)) {
        $newpass_error = 'Your password must contain 8 or more characters with a mix of upper and lowercase letters, numbers & symbols';
    }

    //User Confirm Password
    if (empty($confirm_pass)) {
        $confirmpass_error  = "Please repeat password";
    } elseif ($new_pass != $confirm_pass) {
        $confirmpass_error = "Password did not match";
    }

    $sqlpass = "SELECT * FROM users  WHERE `empid` = '$currentuser'";
    $resultpass = mysqli_query($conn, $sqlpass);
    $rowpass = mysqli_fetch_object($resultpass);

    if (password_verify($current_pass, $rowpass->pass)) {
        if (preg_match($regexpassword, $new_pass)) {
            if ($new_pass == $confirm_pass) {
                if (empty($currentpass_error) && empty($newpass_error) && empty($confirmpass_error)) {

                    $new_pass = password_hash($new_pass, PASSWORD_DEFAULT);

                    $sqlnewpass = "UPDATE users SET pass='$new_pass' WHERE `empid` = '$currentuser' ";
                    if (mysqli_query($conn, $sqlnewpass)) {

                        $user_activity = "Update Account Password";
                        $details =  "User's password was successfully updated";
                        include 'includes/log.php';

                        echo "<script language='javascript'>";
                        echo 'alert("Your password has been successfully changed");';
                        echo 'window.location.replace("account_setting_security?changepassword=success");';
                        echo "</script>";
                        // exit();
                    }
                }
            } else {
                include 'includes/log.php';
                echo "<script language='javascript'>";
                echo 'alert("Your password did not match");';
                echo "</script>";
                // exit();
            }
        } else {
            echo "<script language='javascript'>";
            echo 'alert("Your password must contain 8 or more characters with a mix of upper and lowercase letters, numbers & symbols");';
            echo "</script>";
            // exit();
        }
    } else {
        $currentpass_error = "Your current password is not correct";
        echo "<script language='javascript'>";
        echo 'alert("Your current password is not correct");';
        echo "</script>";
        // exit();
    }
}

if (isset($_POST['saveusername'])) {

    $user_username = filter_input(INPUT_POST, 'user_username');

    $username2 = mysqli_real_escape_string($conn, $user_username);

    $check_duplicate_username = "SELECT empid FROM users WHERE username='$username2'";

    $result = mysqli_query($conn, $check_duplicate_username);

    $count = mysqli_num_rows($result);

    if ($count > 0) {
        echo "<script language='javascript'>";
        echo 'alert("Sorry, this username is already taken. Please try something different.");';
        echo "</script>";
        // return false;
    } else {
        $sqlusername = "UPDATE users SET username='$user_username' WHERE `empid` = '$currentuser' ";

        $stmt = mysqli_stmt_init($conn);
        if (mysqli_stmt_prepare($stmt, $sqlusername)) {
            if (mysqli_stmt_execute($stmt)) {

                $user_activity = "Update Account Username";
                $details =  "User's username was successfully updated";
                include 'includes/log.php';

                echo "<script language='javascript'>";
                echo 'alert("Your username has been successfully changed");';
                echo 'window.location.replace("../../account_setting_security?changeusername=success");';
                echo "</script>";
            }
        } else {
            echo "<script language='javascript'>";
            echo 'alert("Something went wrong,Please try again later");';
            echo 'window.location.replace("../../account_setting_security?changeusername=failed");';
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
    <title>Account Setting - Security </title>

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
                            <a class=" nav-link text-secondary" href="account_setting_info.php">Information</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href=" account_setting_password.php">Security</a>
                        </li>
                    </ul>
                    <div class="card shadow mb-5">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 font-weight-normal">Username</p>
                        </div>
                        <div class="card-body">
                            <?php
                            $sql2 = "SELECT * FROM users WHERE empid='$currentuser'";

                            $curesult = mysqli_query($conn, $sql2);

                            if ($curesult) {
                                if (mysqli_num_rows($curesult) > 0) {
                                    while ($row = mysqli_fetch_array($curesult)) { ?>
                                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                            <div class="form-row ">
                                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                    <div class="form-group">
                                                        <label for="user_username">
                                                            <span> Username</span> <span class="text-danger"> * </span>
                                                        </label>
                                                        <input class="form-control" type="text" placeholder="Enter Username" name="user_username" value="<?php echo $row['username']; ?>" required="required">
                                                        <small class="text-danger">
                                                            <?php if (isset($username_error)) {
                                                                echo $username_error;
                                                            }
                                                            ?>
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <button class="mt-1 btn btn-primary " type="submit" name="saveusername">Change Username</button>
                                            </div>
                                        </form>
                        </div>
                    </div>

                    <div class="card shadow mb-5">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 font-weight-normal">Password</p>
                        </div>
                        <div class="card-body">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <div class="form-row">
                                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                        <div class="form-group">
                                            <label for="user_currentpass">
                                                <span> Current Password</span>
                                                <span class="text-danger"> * </span>
                                            </label>
                                            <div class="input-group" id="show_hide_password">
                                                <input class="form-control" id="user_currentpass" type="password" placeholder="Enter Current Password" name="user_currentpass" required value="<?php if (isset($_POST['user_currentpass'])) {
                                                                                                                                                                                                    echo $_POST['user_currentpass'];
                                                                                                                                                                                                } ?>">
                                                <div class="input-group-prepend input-group-addon">
                                                    <div class="input-group-text">
                                                        <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <small class="text-danger">
                                                <?php if (isset($currentpass_error)) {
                                                    echo $currentpass_error;
                                                }
                                                ?>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                        <div class="form-group">
                                            <label for="user_newpass">
                                                <span> New Password</span>
                                                <span class="text-danger"> * </span>
                                            </label>
                                            <div class="input-group" id="show_hide_password2">
                                                <input class="form-control" id="user_newpass" minlength="8" type="password" placeholder="Enter New Password" name="user_newpass" required value="<?php if (isset($_POST['user_newpass'])) {
                                                                                                                                                                                                        echo $_POST['user_newpass'];
                                                                                                                                                                                                    } ?>">
                                                <div class="input-group-prepend input-group-addon">
                                                    <div class="input-group-text">
                                                        <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <small class="text-danger">
                                                <?php if (isset($newpass_error)) {
                                                    echo $newpass_error;
                                                }
                                                ?>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                        <div class="form-group">
                                            <label for="Confirm_Password"> Confirm Password <span class="text-danger"> * </span></label>
                                            <div class="input-group" id="show_hide_password3">
                                                <input type="password" class="form-control" id="Confirm_Password" placeholder="Confirm Password" name="user_confirmpass" required>
                                                <div class="input-group-prepend input-group-addon">
                                                    <div class="input-group-text">
                                                        <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <small class="text-danger">
                                                <?php if (isset($confirmpass_error)) {
                                                    echo $confirmpass_error;
                                                }
                                                ?>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <button class="mt-1 btn btn-primary " type="submit" name="savepassword">Change Password</button>
                                </div>

                            </form>
                <?php }
                                }
                            } ?>

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
        <script>
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
                $("#show_hide_password3 a").on('click', function(event) {
                    event.preventDefault();
                    if ($('#show_hide_password3 input').attr("type") == "text") {
                        $('#show_hide_password3 input').attr('type', 'password');
                        $('#show_hide_password3 i').addClass("fa-eye-slash");
                        $('#show_hide_password3 i').removeClass("fa-eye");
                    } else if ($('#show_hide_password input').attr("type") == "password") {
                        $('#show_hide_password3 input').attr('type', 'text');
                        $('#show_hide_password3 i').removeClass("fa-eye-slash");
                        $('#show_hide_password3 i').addClass("fa-eye");
                    }
                });
            });
        </script>

</body>

</html>