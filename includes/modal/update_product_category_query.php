<?php
require_once '../config.php';
session_start();
if (isset($_POST['update'])) {

	$id = filter_input(INPUT_POST, 'prodcat_id');
	$name = ucfirst(filter_input(INPUT_POST, 'prod_cat_name'));
	$status = filter_input(INPUT_POST, 'status');

	$sql = " UPDATE `product_category`
	SET `name` = '$name',
	`status` = '$status'
	WHERE `id` = '$id'";

	// REGEX/ FORM VALIDATION
	$regexname = "/^[a-zA-Z\s\,\-]+$/";

	if (preg_match($regexname, $name)) {
		$stmt = mysqli_stmt_init($conn);
		if (mysqli_stmt_prepare($stmt, 	$sql)) {
			if (mysqli_stmt_execute($stmt)) {

				$user_activity = "Update Product Category";
				$details = "Updated product category named '$name', id '$id'";
				include '../log.php';

				echo "<script language='javascript'>";
				echo 'alert("' . $name . ' is successfully updated!");';
				echo 'window.location.replace("../../product_category.php?updateproductcategory=success");';
				echo "</script>";
			}
		} else {
			echo "<script language='javascript'>";
			echo 'alert("Something went wrong,Please try again later");';
			echo 'window.location.replace("../../product_category.php?updateproductcategory=failed");';
			echo "</script>";
		}
	} else {
		echo "<script language='javascript'>";
		echo 'alert("Please enter a valid product category name");';
		echo 'window.location.replace("../../product_category.php?updateproductcategory=failed");';
		echo "</script>";
	}
} else {
	echo "<script language='javascript'>";
	echo 'alert("Something went wrong, Please try again later");';
	echo 'window.location.replace("../../product_category.php?updateproductcategory=failed");';
	echo "</script>";
}
