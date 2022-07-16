<?php
require_once '../config.php';
session_start();
if (isset($_POST['add'])) {

	$stockid = filter_input(INPUT_POST, 'stockid');
	$name = filter_input(INPUT_POST, 'prodname');
	$quantity = filter_input(INPUT_POST, 'prod_quantity');
	$addstock = filter_input(INPUT_POST, 'add_stock');

	$newstock = $quantity + $addstock;

	$sqlvitalstat = " UPDATE `inventory`
	SET `quantity_on_hand` = '$newstock'
	WHERE `inventory_id` = '$stockid'";


	$stmt = mysqli_stmt_init($conn);
	if (mysqli_stmt_prepare($stmt,  $sqlvitalstat)) {
		if (mysqli_stmt_execute($stmt)) {

			$user_activity = "Add Stock";
			$details = "Added new '$addstock' stock for the product name '$name', id '$stockid'";
			include '../log.php';

			echo "<script language='javascript'>";
			echo 'alert("' . $name . ' stock is successfully updated!");';
			echo 'window.location.replace("../../add_stock.php?updatestock=success");';
			// echo 'window.location.replace("../../patient_information.php?id=' . $id . '");';
			echo "</script>";
		}
	} else {
		$log = "Product id '$stockid' was unsuccessfully restocked";
		include '../log.php';
		echo "<script language='javascript'>";
		echo 'alert("Something went wrong, Please try again later");';
		echo 'window.location.replace("../../add_stock.php?updatestock=failed");';
		// echo 'window.location.replace("../../patient_information.php?id=' . $id . '");';
		echo "</script>";
	}
}
