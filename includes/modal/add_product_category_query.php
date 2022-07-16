<?php
require_once '../config.php';
session_start();

if (isset($_POST['add'])) {
    // $id = filter_input(INPUT_POST, 'id');

    //Product Category Name
    $name = ucfirst(filter_input(INPUT_POST, 'prod_cat_name'));
    $status = 'Active';

    // REGEX/ FORM VALIDATION
    $regexname = "/^[a-zA-Z\s\,\-]+$/";

    $sql = "SELECT * FROM product_category WHERE name = '$name'";
    $query = mysqli_query($conn, $sql);

    if (mysqli_num_rows($query) > 0) {
        echo "<script language='javascript'>";
        echo 'alert("Sorry, this product category is already existed. Please try another name");';
        echo 'window.location.replace("../../product_category.php?addproductcategory=failed");';
        echo "</script>";
    } else {
        if (preg_match($regexname, $name)) {
            $sql = "INSERT INTO product_category(name,status) VALUES (?,?);";
            $stmt = mysqli_stmt_init($conn);

            if (mysqli_stmt_prepare($stmt, $sql)) {
                mysqli_stmt_bind_param($stmt, "ss", $name, $status);

                if (mysqli_stmt_execute($stmt)); {
                    $product_category_id = mysqli_insert_id($conn);

                    $user_activity = "Add Product Category";
                    $details = "Added product category named '$name', id '$product_category_id'";
                    include '../log.php';

                    echo "<script language='javascript'>";
                    echo 'alert("' . $name . ' is successfully added!");';
                    echo 'window.location.replace("../../product_category.php?addproductcategory=success");';
                    echo "</script>";
                }
            } else {
                echo "<script language='javascript'>";
                echo 'alert(" Something went wrong, Please try again later");';
                echo 'window.location.replace("../../product_category.php?addproductcategory=failed");';
                echo "</script>";
            }
        } else {
            echo "<script language='javascript'>";
            echo 'alert("Please enter a valid product category name");';
            echo 'window.location.replace("../../product_category.php?addproductcategory=failed");';
            echo "</script>";
        }
    }
} else {
    echo "<script language='javascript'>";
    echo 'alert("Something went wrong, Please try again later");';
    echo 'window.location.replace("../../user_list.php?addproductcategory=failed");';
    echo "</script>";
}
