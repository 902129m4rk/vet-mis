<?php
require_once '../config.php';

if (isset($_POST['update'])) {

	$id = filter_input(INPUT_POST, 'id');
	// $oid = filter_input(INPUT_POST, 'owner_id');
	$service = filter_input(INPUT_POST, 'service');
	$date = filter_input(INPUT_POST, 'apt_date');
	$time = filter_input(INPUT_POST, 'apt_time');
	$aptstatus =   filter_input(INPUT_POST, 'status');


	$sql = " UPDATE `appointment`
	SET `service` = '$service',
	`date` = '$date',
	`time`= '$time',
	`status` ='$aptstatus'
	WHERE `id` = '$id'";

	$stmt = mysqli_stmt_init($conn);
	if (mysqli_stmt_prepare($stmt, $sql)) {
		mysqli_stmt_execute($stmt);
		echo "<script language='javascript'>";
		echo 'alert("Appointment is successfully updated!");';
		echo 'window.location.replace("../../appointment_list.php?appointment=success");';
		echo "</script>";
	} else {
		echo "<script language='javascript'>";
		echo 'alert("Something went wrong, Please try again later");';
		echo 'window.location.replace("../../appointment_list.php?appointment=failed");';
		echo "</script>";
	}
}
