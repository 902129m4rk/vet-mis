<?php
require_once '../config.php';
session_start();
if (isset($_POST['update'])) {

	$id = filter_input(INPUT_POST, 'species_id');
	$name = ucfirst(filter_input(INPUT_POST, 'species_name'));
	$status = filter_input(INPUT_POST, 'species_stat');
	// REGEX/ FORM VALIDATION
	$regexname = "/^[a-zA-Z\s\,\-]+$/";

	if (preg_match($regexname, $name)) {
		$sql = " UPDATE `species`
			SET `name` = '$name',
			`status` = '$status'
			WHERE `id` = '$id'";

		$stmt = mysqli_stmt_init($conn);
		if (mysqli_stmt_prepare($stmt, 	$sql)) {
			if (mysqli_stmt_execute($stmt)) {

				$user_activity = "Update Species";
				$details = "Updated species named '$name', id '$id'";
				include '../log.php';

				echo "<script language='javascript'>";
				echo 'alert("' . $name . ' is successfully updated!");';
				echo 'window.location.replace("../../species.php?updatespecies=success");';
				echo "</script>";
			}
		} else {
			echo "<script language='javascript'>";
			echo 'alert("Something went wrong,Please try again later");';
			echo 'window.location.replace("../../species.php?updatespecies=failed");';
			echo "</script>";
		}
	} else {
		echo "<script language='javascript'>";
		echo 'alert("Please enter a valid species name");';
		echo 'window.location.replace("../../species.php?updatespecies=failed");';
		echo "</script>";
	}
} else {
	echo "<script language='javascript'>";
	echo 'alert("Something went wrong, Please try again later");';
	echo 'window.location.replace("../../species.php?updatespecies=failed");';
	echo "</script>";
}
