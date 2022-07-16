<?php
require_once '../config.php';

session_start();
if (isset($_POST['update'])) {

	$id = filter_input(INPUT_POST, 'service_id');
	$name = ucfirst(filter_input(INPUT_POST, 'service_name'));
	$price = filter_input(INPUT_POST, 'service_price');
	$status = filter_input(INPUT_POST, 'status');

	// REGEX/ FORM VALIDATION
	$regexname = "/^[a-zA-Z0-9\d\s\.\-\/\(\)\&]+$/";
	$sql = "SELECT * FROM service WHERE name = '$name'";
	$query = mysqli_query($conn, $sql);


	if (preg_match($regexname, $name)) {
		$sql = " UPDATE `service`
			SET `name` = '$name',
			price = '$price',
			status = '$status'
			WHERE `service_id` = '$id'";

		$stmt = mysqli_stmt_init($conn);
		if (mysqli_stmt_prepare($stmt, 	$sql)) {
			if (mysqli_stmt_execute($stmt)) {

				$user_activity = "Update Service";
				$details = "Updated service named '$name', id '$id'";
				include '../log.php';

				echo "<script language='javascript'>";
				echo 'alert("' . $name . ' is successfully updated!");';
				echo 'window.location.replace("../../services.php?updateservice=success");';
				echo "</script>";
			}
		} else {
			echo "<script language='javascript'>";
			echo 'alert("Something went wrong,Please try again later");';
			echo 'window.location.replace("../../services.php?updateservice=failed");';
			echo "</script>";
		}
	} else {
		echo "<script language='javascript'>";
		echo 'alert("Please enter a valid service name");';
		echo 'window.location.replace("../../services.php?updateservice=failed");';
		echo "</script>";
	}
} else {
	echo "<script language='javascript'>";
	echo 'alert("Something went wrong, Please try again later");';
	echo 'window.location.replace("../../services.php?updateservice=failed");';
	echo "</script>";
}
