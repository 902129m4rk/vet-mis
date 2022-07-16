<?php
require_once '../config.php';
session_start();
if (isset($_POST['update'])) {

	$stockid = filter_input(INPUT_POST, 'stockid');
	$name = filter_input(INPUT_POST, 'prodname');
	$quantity = filter_input(INPUT_POST, 'prod_quantity');


	$sqlvitalstat = " UPDATE `inventory`
	SET `quantity_on_hand` = '$quantity'
	WHERE `inventory_id` = '$stockid'";


	$stmt = mysqli_stmt_init($conn);
	if (mysqli_stmt_prepare($stmt,  $sqlvitalstat)) {
		if (mysqli_stmt_execute($stmt)) {
			$log = "Product id '$stockid' was successfully restocked";
			include '../log.php';
			echo "<script language='javascript'>";
			echo 'alert("' . $name . ' stock is successfully updated!");';
			echo 'window.location.replace("../../inventory_report.php?updatestock=success");';
			// echo 'window.location.replace("../../patient_information.php?id=' . $id . '");';
			echo "</script>";
		}
	} else {
		$log = "Product id '$stockid' was unsuccessfully restocked";
		include '../log.php';
		echo "<script language='javascript'>";
		echo 'alert("Something went wrong, Please try again later");';
		echo 'window.location.replace("../../inventory_report.php?updatestock=failed");';
		// echo 'window.location.replace("../../patient_information.php?id=' . $id . '");';
		echo "</script>";
	}
}
