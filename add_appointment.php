<?php
require_once 'includes/config.php';

// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}
?>
<?php
if (isset($_POST['submit'])) {

    $owner = filter_input(INPUT_POST, 'select_owner');
    $patient = filter_input(INPUT_POST, 'select_patient');
    $service = filter_input(INPUT_POST, 'service');
    $date = filter_input(INPUT_POST, 'apt_date');
    $time = filter_input(INPUT_POST, 'apt_time');
    $assign_vet = filter_input(INPUT_POST, 'assign_vet');
    $aptstatus =  'Scheduled';
    $provider = $_SESSION["empid"];

    if (($patient) <= 9) {
        $patientid = 'PT-000';
        $patientid .= $patient;
    } elseif (($patient) <= 99) {
        $patientid = 'PT-00';
        $patientid .= $patient;
    } elseif (($patient) <= 999) {
        $patientid =  'PT-0';
        $patientid .= $patient;
    } else {
        $patientid =  'PT-';
        $patientid .= $patient;
    }

    // FETCH PATIENT NAME
    $logsqlpatient = "SELECT * FROM pet
    WHERE id =  '$patient'";
    $logquerypatient = mysqli_query($conn, $logsqlpatient);
    $logfetchpatient = mysqli_fetch_assoc($logquerypatient);
    $logpatientname = $logfetchpatient['name'];

    $sql = "SELECT * FROM appointment 
    WHERE date = '$date'
    AND time = '$time'
    AND assigned_vet = '$assign_vet'
    AND status = '$aptstatus'
    ;";
    $query = mysqli_query($conn, $sql);

    if (mysqli_num_rows($query) > 0) {
        // $log = "New service was unsuccessfully added";
        // include '../log.php';
        echo "<script language='javascript'>";
        echo 'alert("Sorry, this schedule is already occupied. Please try again");';
        echo 'window.location.replace("../../add_appointment.php");';
        echo "</script>";
    } else {
        // //V1
        $sql = "INSERT INTO appointment(assigned_vet, pet_id, owner_id, service, date, time, status) VALUES (?,?,?,?,?,?,?);";
        $stmt = mysqli_stmt_init($conn);

        if (mysqli_stmt_prepare($stmt, $sql)) {

            mysqli_stmt_bind_param($stmt, "sssssss", $assign_vet, $patient, $owner, $service, $date, $time, $aptstatus);
            if (mysqli_stmt_execute($stmt)) {

                $user_activity = "Add Appointment";
                $details = "Added appointment for pet named '$logpatientname', id '$patient' ";
                include 'includes/log.php';

                echo "<script language='javascript'>";
                echo 'alert("' . $logpatientname . ' appointment is successfully added!");';
                echo 'window.location.replace("appointment_list.php?addappointment=success");';
                echo "</script>";
                exit();
            }
        } else {
            // $log = "Adding appointment for client id '$owner' was unsuccessful";
            // include 'includes/log.php';
            echo "<script language='javascript'>";
            echo 'alert("Something went wrong. Please Try Again");';
            echo 'window.location.replace("add_appointment.php");';
            echo "</script>";
            // header("Location: add_patient.inc.php?addpatient=success");
            exit();
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
    <title>Add Appointment </title>

    <!-- Bootstrap CSS CDN -->
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
        $page = 'appointment';
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

                    <h5 class="navbar-header-text">Add Appointment</h5>


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
                                            <p class="text-primary m-0 font-weight-normal">Appointment Information</p>
                                        </div>
                                        <div class="card-body">
                                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                                <div class="form-row mb-2">
                                                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                                        <div class="form-col">
                                                            <label for="select_owner">Pet Owner Name <span class="text-danger"> * </span>
                                                            </label>
                                                            <select class="form-control placeholder js-example-basic-single" title="Select Pet Owner" data-actions-box="true" data-live-search="true" onChange="getpatient(this.value);" name="select_owner" required="required">

                                                                <option value='' disabled selected hidden>Select Pet Owner</option>
                                                                <?php
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
                                                                    <!-- <option value="<?php echo $row['fname']; ?>"><?php echo $row['fname']; ?></option> -->

                                                                <?php
                                                                }
                                                                ?>
                                                            </select>

                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                                        <div class="form-col">
                                                            <label for="select_patient">Pet Name<span class="text-danger"> * </span> </label>
                                                            <!-- <select name="select_patient" id="patient-list" class="form-control"> -->
                                                            <select class="form-control placeholder js-example-basic-single" data-live-search="true" name="select_patient" id="patient-list" required="required">
                                                                <option value='' disabled selected hidden>Select Pet</option>

                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                                        <div class="form-group">
                                                            <label for="apt_date"><span> Date</span> <span class="text-danger"> * </span></label>
                                                            <input class="form-control" type="date" name="apt_date" required="required">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                                        <div class="form-group">
                                                            <label for="apt_time"><span>Time</span> <span class="text-danger"> * </span></label>
                                                            <input class="form-control" type="time" name="apt_time" required="required">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                                        <div class="form-group">
                                                            <label for="service">Service <span class="text-danger"> * </span> </label>
                                                            <select class="form-control placeholder" name="service" required="required">
                                                                <option value="">Select Service</option>
                                                                <?php $query = mysqli_query($conn, "SELECT * FROM service WHERE status='Active' ORDER BY name asc");
                                                                while ($row = mysqli_fetch_array($query)) {
                                                                    // Remain selected value
                                                                    $selected = '';
                                                                    if (!empty($_POST['service']) and $_POST['service'] == $row['name']) {
                                                                        $selected = ' selected="selected"';  // select
                                                                    }
                                                                    echo '<option value="' . $row['name'] . '"' . $selected . '>' . $row['name'] . '</option>';
                                                                ?>
                                                                    <!-- <option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option> -->

                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                                        <?php if (isset($_SESSION["loggedin"]) && ($_SESSION["utvet"])) {
                                                            $sessionvetid =  $_SESSION["empid"];
                                                        ?> <input type="hidden" name="assign_vet" value="<?php echo $sessionvetid; ?>">
                                                        <?php
                                                        } else { ?>

                                                            <div class="form-group">
                                                                <label for="assign_vet">Assign Veterinarian<span class="text-danger"> * </span> </label>
                                                                <select class="form-control placeholder" name="assign_vet" required="required">
                                                                    <option value="">Select Veterinarian</option>
                                                                    <?php $query = mysqli_query($conn, "SELECT * FROM users WHERE user_status='Active' AND user_type ='Veterinarian' ORDER BY user_fname asc");
                                                                    while ($row = mysqli_fetch_array($query)) {
                                                                        // Remain selected value
                                                                        $selected = '';
                                                                        if (!empty($_POST['assign_vet']) and $_POST['assign_vet'] == $row['empid']) {
                                                                            $selected = ' selected="selected"';  // select
                                                                        }
                                                                        echo '<option value="' . $row['empid'] . '"' . $selected . '>' . $row['user_fname'], ' ', $row['user_lname'] . '</option>';
                                                                    ?>
                                                                        <!-- <option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option> -->

                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>

                                                            </div>
                                                        <?php
                                                        } ?>
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
                        </div>
                    </div>
                </div>
            </div>
            <?php include 'includes/footer.php'; ?>
        </div>


        <!--Icon-->
        <script src="https://unpkg.com/ionicons@5.2.3/dist/ionicons.js "></script>

        <!--Icon-->
        <script src="https://unpkg.com/ionicons@5.2.3/dist/ionicons.js "></script>
        <!-- SELECT SPECIES AND BREED -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js " integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1 " crossorigin="anonymous "></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js " integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM " crossorigin="anonymous "></script>
        <!--OUR JS-->
        <script src="js/script.js "></script>
</body>

</html>