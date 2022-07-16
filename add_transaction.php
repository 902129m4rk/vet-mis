<?php
require_once("includes/config.php");

// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}
if (isset($_SESSION["loggedin"]) && ($_SESSION["utadmin"]) or ($_SESSION["utstaff"])) {
?>
    <?php

    // session_start();
    $product_ids = array();
    //session_destroy();

    //check if Add to Cart button has been submitted
    if (filter_input(INPUT_POST, 'addpos')) {
        if (isset($_SESSION['pointofsale'])) {

            //keep track of how mnay products are in the shopping cart
            $count = count($_SESSION['pointofsale']);

            //create sequantial array for matching array keys to products id's
            $product_ids = array_column($_SESSION['pointofsale'], 'id');

            if (!in_array(filter_input(INPUT_GET, 'id'), $product_ids)) {
                $_SESSION['pointofsale'][$count] = array(
                    'id' => filter_input(INPUT_GET, 'id'),
                    'name' => filter_input(INPUT_POST, 'name'),
                    'invoice_type' => filter_input(INPUT_POST, 'invoice_type'),
                    'price' => filter_input(INPUT_POST, 'price'),
                    'quantity' => filter_input(INPUT_POST, 'quantity')
                );
            } else { //product already exists, increase quantity
                //match array key to id of the product being added to the cart
                for ($i = 0; $i < count($product_ids); $i++) {
                    if ($product_ids[$i] == filter_input(INPUT_GET, 'id')) {
                        //add item quantity to the existing product in the array
                        $_SESSION['pointofsale'][$i]['quantity'] += filter_input(INPUT_POST, 'quantity');
                    }
                }
            }
        } else { //if shopping cart doesn't exist, create first product with array key 0
            //create array using submitted form data, start from key 0 and fill it with values
            $_SESSION['pointofsale'][0] = array(
                'id' => filter_input(INPUT_GET, 'id'),
                'name' => filter_input(INPUT_POST, 'name'),
                'invoice_type' => filter_input(INPUT_POST, 'invoice_type'),
                'price' => filter_input(INPUT_POST, 'price'),
                'quantity' => filter_input(INPUT_POST, 'quantity')
            );
        }
    }

    if (filter_input(INPUT_GET, 'action') == 'delete') {
        //loop through all products in the shopping cart until it matches with GET id variable
        foreach ($_SESSION['pointofsale'] as $key => $product) {
            if ($product['id'] == filter_input(INPUT_GET, 'name')) {
                //remove product from the shopping cart when it matches with the GET id
                unset($_SESSION['pointofsale'][$key]);
            }
        }
        //reset session array keys so they match with $product_ids numeric array
        $_SESSION['pointofsale'] = array_values($_SESSION['pointofsale']);
    }

    //pre_r($_SESSION);

    function pre_r($array)
    {
        echo '<pre>';
        print_r($array);
        echo '</pre>';
    }
    ?>
















    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="img/logo.png">
        <title>Add Transaction </title>

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css" integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK" crossorigin="anonymous">
        <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.min.js" integrity="sha384-5h4UG+6GOuV9qXh6HqOLwZMY4mnLPraeTrjT5v07o347pj6IkfuoASuGBhfDsp3d" crossorigin="anonymous"></script> -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

        <!-- Bootstrap CDN 5.0 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>


        <!--FONT AWESOME-->
        <link rel="stylesheet" href="path/to/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
        <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">

        <!-- OUR CUSTOM CSS-->
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/form.css">
        <link rel="stylesheet" href="css/tb.css">

        <!-- Latest compiled and minified CSS -->
        <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css"> -->
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

        <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"> -->

    </head>

    <body>
        <div class="wrapper ">

            <?php
            $page = 'transaction';
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

                        <h5 class="navbar-header-text">Add Transaction</h5>

                        <?php include 'includes/top_navbar.php'; ?>

                    </nav>

                    <div class="container-fluid">
                        <div class="row mb-3 my-flex-card">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col">
                                        <div class="card shadow mb-3">
                                            <div class="card-header py-3">
                                                <p class="text-primary m-0 font-weight-normal"> Select Transaction</p>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col">
                                                        <!-- Nav tabs -->
                                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                            <li class="nav-item">
                                                                <a class="nav-link " id="product-tab" data-toggle="tab" href="#product" role="tab" aria-controls="product" aria-selected="false">Product</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" id="service-tab" data-toggle="tab" href="#service" role="tab" aria-controls="service" aria-selected="false">Service</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" id="lab-tab" data-toggle="tab" href="#lab" role="tab" aria-controls="lab" aria-selected="true">Laboratory</a>
                                                            </li>
                                                        </ul>
                                                        <div class="tab-content" id="myTabContent">
                                                            <?php include 'transaction_navtab.php'; ?>
                                                        </div>
                                                        <!-- <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                        <li class="nav-item">
                                                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Home</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Profile</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact</a>
                                                        </li>
                                                    </ul>
                                                    <div class="tab-content" id="myTabContent">
                                                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">...</div>
                                                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">...</div>
                                                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
                                                    </div> -->

                                                    </div>
                                                </div>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>




                        <?php

                        if (!empty($_SESSION['pointofsale'])) {

                            $total = 0;
                        ?>
                            <div class="row mb-3 my-flex-card">
                                <div class="col-lg-12">

                                    <div class="card shadow mb-3">
                                        <div class="card-header py-3">
                                            <p class="text-primary m-0 font-weight-normal">Point of Sale</p>
                                        </div>
                                        <div class="card-body col-md-12">
                                            <div class="table-responsive">
                                                <!-- trial form lang   -->
                                                <form role="form" method="post" action="pos_transac.php?action=add">
                                                    <table id="dataTable" class="table table-bordered table-hover" style="width:100%">
                                                        <tr>
                                                            <th width="30%">Product Name</th>
                                                            <th width="15%">Invoice Type</th>
                                                            <th width="10%">Quantity</th>
                                                            <th width="15%">Price</th>
                                                            <th width="15%">Total</th>
                                                            <th width="15%">Action</th>
                                                        </tr>
                                                        <?php
                                                        foreach ($_SESSION['pointofsale'] as $key => $product) :
                                                            $prodname =  $product['id'];
                                                            $sql = "SELECT * FROM inventory 
                                                        WHERE product_name = '$prodname'
                                                        ";
                                                            $query = mysqli_query($conn, $sql);
                                                            $fetch = mysqli_fetch_assoc($query);
                                                        ?>
                                                            <tr>

                                                                <!-- <input type="hidden" name="prodid[]" value="<?php echo $product['id']; ?>">
                                        <input type="hidden" name="prodid[]" value="<?php echo $product['id']; ?>"> -->
                                                                <input type="hidden" name="quanti[]" value="<?php echo $product['quantity']; ?>">
                                                                <input type="hidden" name="prodname[]" value="<?php echo $fetch['product_name']; ?>">
                                                                <td>

                                                                    <input type="hidden" name="name[]" value="<?php echo $product['name']; ?>">
                                                                    <?php echo $product['name']; ?>
                                                                </td>
                                                                <td>
                                                                    <input type="hidden" name="invoice_type[]" value="<?php echo $product['invoice_type']; ?>">
                                                                    <?php echo $product['invoice_type']; ?>
                                                                </td>
                                                                <td>
                                                                    <input type="hidden" name="quantity[]" value="<?php echo $product['quantity']; ?>">
                                                                    <?php echo $product['quantity']; ?>
                                                                </td>
                                                                <td>
                                                                    <input type="hidden" name="price[]" value="<?php echo $product['price']; ?>">
                                                                    ₱ <?php echo number_format($product['price'], 2); ?>
                                                                </td>
                                                                <td>
                                                                    <input type="hidden" name="total" value="<?php echo $product['quantity'] * $product['price']; ?>">
                                                                    ₱ <?php echo number_format($product['quantity'] * $product['price'], 2); ?>
                                                                </td>
                                                                <td>
                                                                    <a href="add_transaction.php?action=delete&name=<?php echo $product['name']; ?>" role="button" class="btn btn-danger text-light btn-sm action-btn">
                                                                        <!-- <ion-icon name="trash-bin"></ion-icon> -->
                                                                        <i class="fa fa-trash"></i>
                                                                        <span class="mobile-icon-only">Remove</span>
                                                                    </a>
                                                                </td>
                                                            </tr>

                                                        <?php
                                                            $total = $total + ($product['quantity'] * $product['price']);
                                                        endforeach;
                                                        ?>
                                                    <?php
                                                }
                                                    ?>

                                                    </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php include 'transactionside.php'; ?>
                    </div>
                </div>
                <?php include 'includes/footer.php'; ?>
            </div>






            <!--Icon-->
            <script src="https://unpkg.com/ionicons@5.2.3/dist/ionicons.js "></script>
            <!--OUR JS-->
            <script src="js/script.js "></script>
            <!--Icon-->
            <script src="https://unpkg.com/ionicons@5.2.3/dist/ionicons.js "></script>
            <!--  DEPENDENT DROPDOWN/ SELECT-->
            <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
            <script src="js/bootstrap.min.js"></script>

            <!-- TAB -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
            <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/booy.min.css" /> -->
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

            <!-- Note hindi pwede tong ilipat sa ibang folder. Dapat nandito or sa pinakang file talaga to, kasi kapag nilipat hindi ito gagana-->
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

            <!-- search box sa add transaction -->
            <script>
                function myFunction() {
                    var input, filter, table, tr, td, i, txtValue;
                    input = document.getElementById("myInput");
                    filter = input.value.toUpperCase();
                    table = document.getElementById("myTable");
                    tr = table.getElementsByTagName("tr");
                    for (i = 0; i < tr.length; i++) {
                        td = tr[i].getElementsByTagName("td")[0];
                        if (td) {
                            txtValue = td.textContent || td.innerText;
                            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                tr[i].style.display = "";
                            } else {
                                tr[i].style.display = "none";
                            }
                        }
                    }
                }

                function myFunction7() {
                    var input, filter, table, tr, td, i, txtValue;
                    input = document.getElementById("myInput7");
                    filter = input.value.toUpperCase();
                    table = document.getElementById("myTable7");
                    tr = table.getElementsByTagName("tr");
                    for (i = 0; i < tr.length; i++) {
                        td = tr[i].getElementsByTagName("td")[0];
                        if (td) {
                            txtValue = td.textContent || td.innerText;
                            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                tr[i].style.display = "";
                            } else {
                                tr[i].style.display = "none";
                            }
                        }
                    }
                }

                function myFunction8() {
                    var input, filter, table, tr, td, i, txtValue;
                    input = document.getElementById("myInput8");
                    filter = input.value.toUpperCase();
                    table = document.getElementById("myTable8");
                    tr = table.getElementsByTagName("tr");
                    for (i = 0; i < tr.length; i++) {
                        td = tr[i].getElementsByTagName("td")[0];
                        if (td) {
                            txtValue = td.textContent || td.innerText;
                            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                tr[i].style.display = "";
                            } else {
                                tr[i].style.display = "none";
                            }
                        }
                    }
                }
                $(".js-example-basic-single").select2({
                    //         // width: 'resolve',
                    //         // theme: "classic"

                });
            </script>


    </body>

    </html>
<?php } else {
    include '404.php';
} ?>