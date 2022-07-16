<?php
require_once 'includes/config.php';

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

        //Product
        $prodcategory = filter_input(INPUT_POST, 'prod_category');
        $name = ucfirst(filter_input(INPUT_POST, 'prod_name'));
        $species1 = filter_input(INPUT_POST, 'pet_species1');
        $species2 = filter_input(INPUT_POST, 'pet_species2');
        $quantity = filter_input(INPUT_POST, 'prod_quantity');
        $price = filter_input(INPUT_POST, 'prod_price');
        $description = ucfirst(filter_input(INPUT_POST, 'prod_desc'));

        //Regular Expression Variable
        $regexname = "/^[a-zA-Z0-9\d\s\.\-\/\(\)\&]+$/";

        if (empty($name)) {
            $name_error = "Please enter a product name";
        } elseif (!preg_match($regexname, $_POST['prod_name'])) {
            $name_error = " Please enter a valid product name";
        }

        if (empty($name_error)) {
            if (empty($species2)) {
                $sql = "INSERT INTO inventory(product_category, species1,  product_name, quantity_on_hand, price, description) VALUES (?,?,?,?,?,?);";
                $stmt = mysqli_stmt_init($conn);

                if (mysqli_stmt_prepare($stmt, $sql)) {
                    mysqli_stmt_bind_param($stmt, "ssssss", $prodcategory, $species1,  $name, $quantity, $price, $description);

                    if (mysqli_stmt_execute($stmt)) {
                        $product_id = mysqli_insert_id($conn);

                        $user_activity = "Add Product";
                        $details = "Added Product named '$name', id '$product_id'";
                        include 'includes/log.php';

                        echo "<script language='javascript'>";
                        echo 'alert("' . $name . ' is successfully added!");';
                        echo 'window.location.replace("add_stock?addproduct=success");';
                        echo "</script>";
                        // header("Location: add_patient.inc.php?addpatient=success");
                    }
                } else {
                    echo "<script language='javascript'>";
                    echo 'alert(" Something went wrong, Please try again later");';
                    echo 'window.location.replace("dashboard.php?addproduct=failed");';
                    echo "</script>";
                }
            } else {
                $species2 = filter_input(INPUT_POST, 'pet_species2');
                $sql = "INSERT INTO inventory(product_category, species1, species2,  product_name, quantity_on_hand, price, description) VALUES (?,?,?,?,?,?,?);";
                $stmt = mysqli_stmt_init($conn);

                if (mysqli_stmt_prepare($stmt, $sql)) {
                    mysqli_stmt_bind_param($stmt, "sssssss", $prodcategory, $species1, $species2, $name, $quantity, $price, $description);

                    if (mysqli_stmt_execute($stmt)) {
                        $product_id = mysqli_insert_id($conn);

                        $user_activity = "Add Product";
                        $details = "Added product name '$name', id '$product_id'";
                        include 'includes/log.php';

                        echo "<script language='javascript'>";
                        echo 'alert("' . $name . ' was successfully added!");';
                        echo 'window.location.replace("add_stock?addproduct=success");';
                        echo "</script>";
                        // header("Location: add_patient.inc.php?addpatient=success");

                    }
                } else {
                    echo "<script language='javascript'>";
                    echo 'alert(" Something went wrong, Please try again later");';
                    echo 'window.location.replace("dashboard.php?addproduct=failed");';
                    echo "</script>";
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
        <title>Add Product </title>

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
            $page = 'product';
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
                        <h5 class="navbar-header-text">Add Product</h5>
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
                                                <p class="text-primary m-0 font-weight-normal">Product Information</p>
                                            </div>
                                            <div class="card-body">
                                                <!-- <form id="form1" action="add_patient.result.php" method="POST"> -->
                                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                                    <div class="form-row">
                                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                                            <div class="form-group">
                                                                <label for="prod_name">
                                                                    <span> Product Name </span> <span class="text-danger"> * </span>
                                                                </label>
                                                                <input class="form-control" type="text" placeholder="Enter Product Name" name="prod_name" value="<?php if (isset($_POST['prod_name'])) {
                                                                                                                                                                        echo $_POST['prod_name'];
                                                                                                                                                                    } ?>" required="required">
                                                                <small class="text-danger">
                                                                    <?php if (isset($name_error)) {
                                                                        echo $name_error;
                                                                    }
                                                                    ?>
                                                                </small>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                                            <div class="form-group">
                                                                <label for="prod_category">Product Category <span class="text-danger"> * </span> </label>
                                                                <select class="form-control placeholder" name="prod_category" required="required">
                                                                    <option value="">Select Product Category</option>
                                                                    <?php $query = mysqli_query($conn, "SELECT * FROM product_category WHERE status='Active' ORDER BY name asc");
                                                                    while ($row = mysqli_fetch_array($query)) {
                                                                        // Remain selected value
                                                                        $selected = '';
                                                                        if (!empty($_POST['prod_category']) and $_POST['prod_category'] == $row['name']) {
                                                                            $selected = ' selected="selected"';  // select
                                                                        }
                                                                        echo '<option value="' . $row['name'] . '"' . $selected . '>' . $row['name'] . '</option>';
                                                                    ?>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="col-lg-6 col-xl-6 col-md-12 col-sm-12 col-12">
                                                            <div class="form-group mt-2">
                                                                <label for="pet_species1">Species 1 <span class="text-danger"> * </span> </label>
                                                                <select class="form-control placeholder" name="pet_species1" id="species" required="required">
                                                                    <option value="">Select Species</option>
                                                                    <?php $query = mysqli_query($conn, "SELECT * FROM species WHERE status='Active' ORDER BY name asc");
                                                                    while ($row = mysqli_fetch_array($query)) {
                                                                        // Remain selected value
                                                                        $selected = '';
                                                                        if (!empty($_POST['pet_species1']) and $_POST['pet_species1'] == $row['name']) {
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
                                                        <div class="col-lg-6 col-xl-6 col-md-12 col-sm-12 col-12">
                                                            <div class="form-group mt-2">
                                                                <label for="pet_species2">Species 2 </label>
                                                                <select class="form-control placeholder" name="pet_species2">
                                                                    <option value="">Select Species</option>
                                                                    <?php $query = mysqli_query($conn, "SELECT * FROM species WHERE status='Active' ORDER BY name asc");
                                                                    while ($row = mysqli_fetch_array($query)) {
                                                                        // Remain selected value
                                                                        $selected = '';
                                                                        if (!empty($_POST['pet_species2']) and $_POST['pet_species2'] == $row['name']) {
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
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="col-lg-6 col-xl-6 col-md-12 col-sm-12 col-12">
                                                            <div class="form-group">
                                                                <label for="prod_quantity">Quantity on Hand<span class="text-danger"> * </span> </label>
                                                                <input class="form-control" type="number" min="0" placeholder="Enter Quantity on Hand" name="prod_quantity" value="<?php if (isset($_POST['prod_quantity'])) {
                                                                                                                                                                                        echo $_POST['prod_quantity'];
                                                                                                                                                                                    } ?>" required="required">

                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-xl-6 col-md-12 col-sm-12 col-12">

                                                            <div class="form-group">
                                                                <label for="test_cost">Price<span class="text-danger"> * </span> </label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">₱</span>
                                                                    </div>
                                                                    <input class="form-control" type="number" min="0" step="0.01" placeholder="Enter Product Price" name="prod_price" value="<?php if (isset($_POST['prod_price'])) {
                                                                                                                                                                                                    echo $_POST['prod_price'];
                                                                                                                                                                                                } ?>" required="required">

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <div class="form-group mt-2 mb-2">
                                                                    <label for="prod_desc"><span>Product Description </span> <span class="text-danger"> * </span> </label>
                                                                    <textarea class="form-control" name="prod_desc" rows="5" required><?php if (isset($_POST['prod_desc'])) {
                                                                                                                                            echo $_POST['prod_desc'];
                                                                                                                                        } ?></textarea>
                                                                </div>
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


    </body>

    </html>
<?php } else {
    include '404.php';
} ?>