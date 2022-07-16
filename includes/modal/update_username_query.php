<?php
require_once '../config.php';

session_start();

if (isset($_POST['update'])) {
	$emloyeepid = filter_input(INPUT_POST, 'employeeid');
	$user_username = filter_input(INPUT_POST, 'username');
	$fname = filter_input(INPUT_POST, 'fname');
	$lname = filter_input(INPUT_POST, 'lname');

	$username2 = mysqli_real_escape_string($conn, $user_username);
	$check_duplicate_username = "SELECT empid FROM users WHERE username='$username2'";
	$result2 = mysqli_query($conn, $check_duplicate_username);
	if (mysqli_num_rows($result2) > 0) {
		echo "<script language='javascript'>";
		echo 'alert("Sorry, this username is already taken. Please try something different.");';
		echo 'window.location.replace("../../user_list.php?changeusername=failed");';
		echo "</script>";
		// return false;
	} else {
		$sqlusername = "UPDATE users SET username='$user_username' WHERE `empid` = '$emloyeepid'";

		$stmt2 = mysqli_stmt_init($conn);
		if (mysqli_stmt_prepare($stmt2, $sqlusername)) {
			if (mysqli_stmt_execute($stmt2)) {

				$user_activity = "Update User's Information";
				$details = "Updated username with name '$fname $lname', id '$emloyeepid'";
				include '../log.php';

				echo "<script language='javascript'>";
				echo 'alert("' . $fname . ' ' . $lname . ' username has been changed");';
				echo 'window.location.replace("../../user_list?changeusername=success");';
				echo "</script>";
			}
		} else {
			echo "<script language='javascript'>";
			echo 'alert("Something went wrong,Please try again later");';
			echo 'window.location.replace("../../user_list.php?changeusername=failed");';
			echo "</script>";
		}
	}
}
