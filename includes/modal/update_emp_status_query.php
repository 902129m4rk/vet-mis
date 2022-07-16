<?php
require_once '../config.php';
session_start();

if (isset($_POST['update'])) {

	$empid = filter_input(INPUT_POST, 'id');
	$emp_stat =   filter_input(INPUT_POST, 'user_stat');
	$fname =   filter_input(INPUT_POST, 'fname');
	$lname =   filter_input(INPUT_POST, 'lname');
	$username =   filter_input(INPUT_POST, 'username');


	$sql = " UPDATE `users`
	SET `user_status` ='$emp_stat'
	WHERE `empid` = '$empid'";



	$stmt = mysqli_stmt_init($conn);
	if (mysqli_stmt_prepare($stmt,  $sql)) {
		if (mysqli_stmt_execute($stmt)) {
			$user_activity = "Update User Status";
			$details = "Employee name '$fname $lname', id '$empid', changed user status to '$emp_stat'";
			include '../log.php';

			echo "<script language='javascript'>";
			echo 'alert("' .	$fname, ' ', $lname  . ' account status has changed to ' . $emp_stat . '");';
			echo 'window.location.replace("../..//user_list.php?updateempstatus=success");';
			// echo 'window.location.replace("../../appointment_list.php?updateappointment=success);';
			echo "</script>";
		}
	} else {
		echo "<script language='javascript'>";
		echo 'alert("Something went wrong, Please try again later");';
		// echo 'window.location.replace("../../dashboard.php?updatepatient=failed");';
		echo 'window.location.replace("../../user_list.php?updateempstatus=failed");';
		echo "</script>";
	}
}
