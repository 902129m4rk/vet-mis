<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index.php");
    exit;
}
// Include config file
require_once "includes/config.php";

// Define variables and initialize with empty values
// mysql_real_escape_string


$username = $password = "";
$username_err = $password_err = "";

$query2 = "SELECT * FROM users";
$result2 = mysqli_query($conn, $query2);
$rows = mysqli_fetch_assoc($result2);

$_SESSION["inactive"] = ($rows['user_status'] = 'Inactive');

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT empid, username, pass FROM users WHERE username = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {

                            $query2 = "SELECT * FROM users WHERE empid='$id'";
                            $result2 = mysqli_query($conn, $query2);
                            $rows = mysqli_fetch_assoc($result2);

                            $_SESSION["loggedin"] = true;
                            $_SESSION["empid"] = $id;
                            $_SESSION["usernames"] = $username;
                            $_SESSION["password"] = $password;
                            $_SESSION["fname"] = $rows['fname'];
                            $_SESSION["lname"] = $rows['lname'];

                            // $_SESSION["usertype"] = $rows['user_type'];
                            $_SESSION["utstaff"] = ($rows['user_type'] === 'Staff');
                            $_SESSION["utadmin"] = ($rows['user_type'] === 'Admin');
                            $_SESSION["utvet"] = ($rows['user_type'] === 'Veterinarian');

                            session_start();
                            $user_activity = "Successfully login";
                            $details = "Successfully login";
                            include 'includes/log.php';

                            header('Location: dashboard.php');

                            $_SESSION["inactive"] = ($rows['user_status'] == 'Inactive');



                            if ($_SESSION["inactive"]) {
                                // if (isset($_SESSION["loggedin"]) && ($_SESSION["inactive"])) {

                                $user_activity = "Login was not successful";
                                $details = "Inactive user was trying to log-in";
                                include 'includes/log.php';
                                include 'includes/logout.php';
                            } else {
                            }
                        } else {
                            // Display an error message if password is not valid

                            $password_err = "The password you entered was not valid.";
                            $log = "login was not successful";
                            include 'includes/log.php';
                        }
                    }
                } else {
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($conn);
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/logo.png">
    <title>LOG-IN </title>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <!-- Bootstrap CDN 5.0 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>

    <!-- OUR CUSTOM CSS-->
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <div id="login-one" class="login-one">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="d-xl-flex justify-content-xl-center align-items-xl-center login-one-form">
            <div class="col">
                <div class="login-one-ico">
                    <img src="img/logo.png">
                </div>
                <div class="form-group">
                    <div>
                        <h3>LOGIN</h3>
                    </div>
                    <div class="username-pass">
                        <input type="text" name="username" id="input" class="form-control" value="<?php if (empty($username_err)) echo $username; ?>" placeholder="Username">

                    </div>

                    <div class="form-group">
                        <input type="password" name="password" id="input" class="form-control" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="type" class="form-control" value="">
                    </div>
                    <div class="form-group">
                        <small class="text-danger text-center">
                            <?php if (isset($username_err)) {
                                echo $username_err;
                            }
                            ?>

                        </small>
                        <small class="text-danger text-center">
                            <?php if (isset($password_err)) {
                                echo $password_err;
                            }
                            ?>
                        </small>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Login">

                    </div>

                </div>
        </form>
    </div>

    <!--from bootstrap-->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js " integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo " crossorigin="anonymous "></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js " integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1 " crossorigin="anonymous "></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js " integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM " crossorigin="anonymous "></script>
    <!--Icon-->
    <script src="https://unpkg.com/ionicons@5.2.3/dist/ionicons.js "></script>
    <!--OUR JS-->
    <script src="js/script.js"></script>
</body>

</html>