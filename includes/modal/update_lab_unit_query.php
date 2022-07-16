<?php
require_once '../config.php';

session_start();

if (isset($_POST['update'])) {

	$id = filter_input(INPUT_POST, 'id');

	//Test Group
	$unit = filter_input(INPUT_POST, 'lab_unit');
	$status = filter_input(INPUT_POST, 'status');

	$sql = " UPDATE `units`
		SET `unit_name` = '$unit',
		`unit_status` = '$status'
		WHERE `id` = '$id'";

	$stmt = mysqli_stmt_init($conn);
	if (mysqli_stmt_prepare($stmt, $sql)) {
		if (mysqli_stmt_execute($stmt)) {

			$user_activity = "Update Lab Unit";
			$details = "Updated unit named '$unit', id '$id'";
			include '../log.php';

			echo "<script language='javascript'>";
			echo 'alert("' . $unit . ' is successfully updated!");';
			echo 'window.location.replace("../../lab_units.php?updateunit=success");';
			echo "</script>";
		}
	} else {
		echo "<script language='javascript'>";
		echo 'alert("Something went wrong, Please try again later");';
		echo 'window.location.replace("../../lab_units.php?updateunit=failed");';
		echo "</script>";
	}
}
