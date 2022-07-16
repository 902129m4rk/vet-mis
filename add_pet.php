<?php
require_once("includes/config.php");

// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}

if (!isset($pet_name)) {
    $petname = "";
}

// session_start();
?>
<?php
if (isset($_POST['submit'])) {
    include_once 'includes/config.php';

    //Pet
    $petname = ucfirst(filter_input(INPUT_POST, 'pet_name'));
    $petgender = ucfirst(filter_input(INPUT_POST, 'pet_gender'));
    $petbirthday = filter_input(INPUT_POST, 'pet_bday');
    $petweight = filter_input(INPUT_POST, 'pet_weight');
    $petspecies = ucfirst(filter_input(INPUT_POST, 'pet_species'));
    $petbreed = ucfirst(filter_input(INPUT_POST, 'pet_breed'));
    $vitalitystatus =  'Alive';

    //Client/Owner
    $ownerfname = ucfirst(filter_input(INPUT_POST, 'owner_fname'));
    $ownerlname = ucfirst(filter_input(INPUT_POST, 'owner_lname'));
    $ownerbday = filter_input(INPUT_POST, 'owner_bday');
    $ownergender = filter_input(INPUT_POST, 'owner_gender');
    $ownercity = ucfirst(filter_input(INPUT_POST, 'select_city'));
    $ownerprovince = ucfirst(filter_input(INPUT_POST, 'select_prov'));
    $ownermobileno = filter_input(INPUT_POST, 'owner_mobilenumber');
    $owneremail = filter_input(INPUT_POST, 'owner_email');

    //Regular Expression Variable
    $regexpetname = "/^[a-zA-Z0-9\d\s\.\-]+$/";
    $regexname = "/^[a-zA-Z\s\,\-]+$/";
    $regexheight = "/^[0-9\d\.\s]+$/";
    $regexweight = "/^[0-9\d\.\s]+$/";
    $regexaddress = "/^[a-zA-Z0-9\d\s\.\-]+$/";
    $regexmobileno = "/^[09|+639]+[0-9\d]{10}$/";
    $regexemail = "/^[a-zA-Z\d\._]+@[a-zA-Z\d\._]+\.[a-zA-Z\d]{2,}+$/";

    //PET NAME ERROR
    if (empty($petname)) {
        $petname_error = "Please enter a name";
        // } elseif (strlen($petname) < 3) {
        //     $petname_error = " Pet name needs to have a minimum of 2 letters";
    } elseif (!preg_match($regexpetname, $_POST['pet_name'])) {
        $petname_error = " Please enter a valid name";
    }

    //PET GENDER ERROR
    if (empty($petgender)) {
        $petgender_error = "Please select a gender";
    }

    //Pet Birthday
    if (empty($petbirthday)) {
        $petbday_error = "Please select a  birthdate";
    }

    //Pet Weight
    if (empty($petweight)) {
        $petweight_error = "Please enter a weight";
    } elseif (!preg_match($regexweight, $_POST['pet_weight'])) {
        $petweight_error  = " Please enter a valid number ";
    }

    //Pet Species
    if (empty($petspecies)) {
        $petspecies_error = "Please select a species";
    }

    //Pet Breed
    if (empty($petbreed)) {
    } elseif (!preg_match($regexname, $_POST['pet_breed'])) {
        $petbreed_error = "Please enter a valid breed name ";
    }

    //Client/Owner
    // Client First Name
    if (empty($ownerfname)) {
        $ownerfname_error = "Please enter first name";
    } elseif (!preg_match($regexname, $_POST['owner_fname'])) {
        $ownerfname_error = " Please enter a valid first name";
    }

    //Client Last Name
    if (empty($ownerlname)) {
        $ownerlname_error = "Please enter last name";
    } elseif (!preg_match($regexname, $_POST['owner_lname'])) {
        $ownerlname_error = " Please enter a valid last name";
    }

    //Client Birthday
    if (empty($ownerbday)) {
        $ownerbday_error = "Please select a birthdate";
    }

    //Client GENDER
    if (empty($ownergender)) {
        $ownergender_error = "Please select a gender";
    }

    //Client City/Municipality
    if (empty($ownercity)) {
        $ownercity_error = "Please select a city/municipality";
    }
    //Client Province
    if (empty($ownerprovince)) {
        $ownerprovince_error = "Please select a province";
    }

    //Client Mobile Number
    if (empty($ownermobileno)) {
        $ownermobileno_error = "Please enter mobile number";
    } elseif (!preg_match($regexmobileno, $_POST['owner_mobilenumber'])) {
        $ownermobileno_error = "Please enter a valid mobile number or follow the format (09XXXXXXXXX or +639XXXXXXXXX)";
    }

    //Client Mobile Number
    if (empty($owneremail)) {
        $owneremail_error = "Please enter an e-mail address";
    } elseif (!filter_var($owneremail, FILTER_VALIDATE_EMAIL) && !preg_match($regexemail, $_POST['owner_email'])) {
        $owneremail_error = "Please enter a valid email address";
    }

    if (empty($petname_error) && empty($petbreed_error) && empty($petgender_error) && empty($petbday_error)  && empty($petweight_error) && empty($petspecies_error) && empty($ownerfname_error) && empty($ownerlname_error) && empty($ownerbday_error) && empty($ownergender_error) && empty($ownermobileno_error) && empty($owneremail_error)) {

        // V3
        $sql = "INSERT INTO pet(name, gender, bday, weight, species, breed, vitality_status) VALUES (?,?,?,?,?,?,?);";

        $stmt = mysqli_stmt_init($conn);

        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, "sssssss", $petname, $petgender, $petbirthday,  $petweight, $petspecies, $petbreed, $vitalitystatus);

            if (mysqli_stmt_execute($stmt)); {
                $pet_id = mysqli_insert_id($conn);

                $sql2 = "INSERT INTO owner(fname, lname, bday, gender, city, province, contactno, email) VALUES (?,?,?,?,?,?,?,?);";
                $stmt2 = mysqli_stmt_init($conn);

                if (mysqli_stmt_prepare($stmt2, $sql2)) {

                    mysqli_stmt_bind_param($stmt2, "ssssssss",  $ownerfname, $ownerlname, $ownerbday, $ownergender, $ownercity, $ownerprovince, $ownermobileno, $owneremail);

                    if (mysqli_stmt_execute($stmt2)); {
                        $owner_id = mysqli_insert_id($conn);
                        $sql3 = "INSERT INTO pet_owner(owner_id, pet_id) VALUES (?,?);";
                        $stmt3 = mysqli_stmt_init($conn);

                        if (mysqli_stmt_prepare($stmt3, $sql3)) {

                            mysqli_stmt_bind_param($stmt3, "ii",  $owner_id, $pet_id);

                            if (mysqli_stmt_execute($stmt3)); {
                                $details = "Added Pet named '$petname', id '$pet_id' and pet owner named '$ownerfname $ownerlname', id '$owner_id'";
                                $user_activity = "Added pet and pet owner";
                                include 'includes/log.php';
                                echo "<script language='javascript'>";
                                echo 'alert("Successfully added ' . $petname . ' and ' . $ownerfname . ' ' . $ownerlname . '");';
                                echo 'window.location.replace("pet_list.php?addpet=success");';
                                echo "</script>";
                                exit();
                            }
                        }
                    }
                }
            }
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
    <title>Add Pet </title>

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
        $page = 'pet';
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

                    <h5 class="navbar-header-text">Add Pet</h5>

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
                                            <p class="text-primary m-0 font-weight-normal">Pet Information</p>
                                        </div>
                                        <div class="card-body">
                                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                                <div class="form-row">
                                                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                                        <div class="form-group">
                                                            <label for="pet_name">
                                                                <span> Name </span> <span class="text-danger"> * </span>
                                                            </label>
                                                            <input class="form-control" type="text" placeholder="Enter Pet Name" name="pet_name" value="<?php if (isset($_POST['pet_name'])) {
                                                                                                                                                            echo $_POST['pet_name'];
                                                                                                                                                        } ?>" required="required">
                                                            <small class="text-danger">
                                                                <?php if (isset($petname_error)) {
                                                                    echo $petname_error;
                                                                }
                                                                ?>
                                                            </small>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                                        <div class="form-group">
                                                            <label for="pet_gender">Gender <span class="text-danger"> * </span> </label>
                                                            <select class="form-control placeholder" name="pet_gender" required="required">
                                                                <option value="">Select Gender </option>
                                                                <option value="Male" <?php if (isset($petgender) && $petgender == "Male") echo "selected" ?>>Male </option>
                                                                <option value="Female" <?php if (isset($petgender) && $petgender == "Female") echo "selected" ?>>Female</option>
                                                                <option value="Neutral" <?php if (isset($petgender) && $petgender == "Neutral") echo "selected" ?>>Neutral</option>
                                                            </select>
                                                            <small class="text-danger">
                                                                <?php if (isset($petgender_error)) {
                                                                    echo $petgender_error;
                                                                }
                                                                ?>
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                                        <div class="form-group">
                                                            <label for="pet_bday"><span> Birthdate</span> <span class="text-danger"> * </span> </label>
                                                            <input class="form-control" type="date" placeholder="Select Birthdate" name="pet_bday" value="<?php if (isset($_POST['pet_bday'])) {
                                                                                                                                                                echo $_POST['pet_bday'];
                                                                                                                                                            } ?>" required="required">
                                                            <small class="text-danger">
                                                                <?php if (isset($petbday_error)) {
                                                                    echo $petbday_error;
                                                                }
                                                                ?>
                                                            </small>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                                        <div class="form-group">
                                                            <label for="pet_weight">
                                                                <span> Weight (kg)</span> <span class="text-danger"> * </span>
                                                            </label>
                                                            <input class="form-control" type="number" min="0" step="0.01" placeholder="Enter Pet Weight" name="pet_weight" value="<?php if (isset($_POST['pet_weight'])) {
                                                                                                                                                                                        echo $_POST['pet_weight'];
                                                                                                                                                                                    } ?>" required="required">
                                                            <small class="text-danger">
                                                                <?php if (isset($petweight_error)) {
                                                                    echo $petweight_error;
                                                                }
                                                                ?>
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                                        <div class="form-group">
                                                            <label for="pet_species">Species <span class="text-danger"> * </span> </label>
                                                            <select class="form-control placeholder" name="pet_species" required="required">
                                                                <option value="">Select Species</option>
                                                                <?php $query = mysqli_query($conn, "SELECT * FROM species WHERE status='Active' ORDER BY name asc");
                                                                while ($row = mysqli_fetch_array($query)) {
                                                                    // Remain selected value
                                                                    $selected = '';
                                                                    if (!empty($_POST['pet_species']) and $_POST['pet_species'] == $row['name']) {
                                                                        $selected = ' selected="selected"';  // select
                                                                    }
                                                                    echo '<option value="' . $row['name'] . '"' . $selected . '>' . $row['name'] . '</option>';
                                                                ?>
                                                                    <!-- <option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option> -->

                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                            <small class="text-danger">
                                                                <?php if (isset($petspecies_error)) {
                                                                    echo $petspecies_error;
                                                                }
                                                                ?>
                                                            </small>

                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                                        <div class="form-group">
                                                            <label for="pet_breed"> Breed
                                                            </label>
                                                            <input class="form-control" type="text" placeholder="Enter Pet Breed" name="pet_breed" value="<?php if (isset($_POST['pet_breed'])) {
                                                                                                                                                                echo $_POST['pet_breed'];
                                                                                                                                                            } ?>">
                                                            <small class="text-danger">
                                                                <?php if (isset($petbreed_error)) {
                                                                    echo $petbreed_error;
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
                            <p class="text-primary m-0 font-weight-normal">Pet Owner Information</p>
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="owner_fname">
                                            <span> First Name</span> <span class="text-danger"> * </span>
                                        </label>
                                        <input class="form-control" type="text" placeholder="Enter Owner First Name" name="owner_fname" value="<?php if (isset($_POST['owner_fname'])) {
                                                                                                                                                    echo $_POST['owner_fname'];
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
                                        <label for="owner_lname">
                                            <span> Last Name</span>
                                            <span class="text-danger"> * </span>
                                        </label>
                                        <input class="form-control" type="text" placeholder="Enter Owner Last Name" name="owner_lname" value="<?php if (isset($_POST['owner_lname'])) {
                                                                                                                                                    echo $_POST['owner_lname'];
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
                            <div class="form-row">
                                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="owner_bday"><span> Birthdate</span> <span class="text-danger"> * </span> </label>
                                        <input class="form-control" type="date" placeholder="Select Birthdate" name="owner_bday" value="<?php if (isset($_POST['owner_bday'])) {
                                                                                                                                            echo $_POST['owner_bday'];
                                                                                                                                        } ?>" required="required">
                                        <small class="text-danger">
                                            <?php if (isset($ownerbday_error)) {
                                                echo $ownerbday_error;
                                            }
                                            ?>
                                        </small>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="owner_gender">Gender <span class="text-danger"> * </span> </label>
                                        <select class="form-control placeholder" name="owner_gender" required="required">
                                            <option value="">Select Gender</option>
                                            <option value="Male" <?php if (isset($ownergender) && $ownergender == "Male") echo "selected" ?>>Male </option>
                                            <option value="Female" <?php if (isset($ownergender) && $ownergender == "Female") echo "selected" ?>>Female</option>
                                            <option value="LGBTQIA+" <?php if (isset($ownergender) && $ownergender == "LGBTQIA+") echo "selected" ?>>LGBTQIA+</option>
                                        </select>
                                        <small class="text-danger">
                                            <?php if (isset($ownergender_error)) {
                                                echo $ownergender_error;
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
                                        <label for="owner_mobilenumber">
                                            <span> Mobile Number</span> <span class="text-danger"> * </span>
                                        </label>
                                        <input class="form-control" type="text" placeholder="Enter Owner Mobile Number" name="owner_mobilenumber" value="<?php if (isset($_POST['owner_mobilenumber'])) {
                                                                                                                                                                echo $_POST['owner_mobilenumber'];
                                                                                                                                                            } ?>" required="required">
                                        <small class="text-danger">
                                            <?php if (isset($ownermobileno_error)) {
                                                echo $ownermobileno_error;
                                            }
                                            ?>
                                        </small>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="owner_email">
                                            <span> E-mail</span> <span class="text-danger"> * </span>
                                        </label>
                                        <input class="form-control" type="text" placeholder="Enter Owner E-mail Adress" name="owner_email" value="<?php if (isset($_POST['owner_email'])) {
                                                                                                                                                        echo $_POST['owner_email'];
                                                                                                                                                    } ?>" required="required">
                                        <small class="text-danger">
                                            <?php if (isset($owneremail_error)) {
                                                echo $owneremail_error;
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
        </script>


</body>

</html>