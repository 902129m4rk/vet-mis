<?php
require_once '../config.php';
session_start();
if (isset($_POST['update'])) {

	$uid = filter_input(INPUT_POST, 'userid');
	$fname = ucfirst(filter_input(INPUT_POST, 'fname'));
	$mname = ucfirst(filter_input(INPUT_POST, 'mname'));
	$lname = ucfirst(filter_input(INPUT_POST, 'lname'));
	$gender = ucfirst(filter_input(INPUT_POST, 'gender'));
	$bday = filter_input(INPUT_POST, 'bday');
	$citymunicipality = ucfirst(filter_input(INPUT_POST, 'select_city'));
	$prov = ucfirst(filter_input(INPUT_POST, 'select_prov'));
	$email = filter_input(INPUT_POST, 'email');
	$contactno = filter_input(INPUT_POST, 'contactno');
	$usertype = filter_input(INPUT_POST, 'user_type');
	$status =  filter_input(INPUT_POST, 'user_stat');

	// REGEX/ FORM VALIDATION
	$regexname = "/^[a-zA-Z\s\,\-]+$/";
	$regexmobileno = "/^[09|+639]+[0-9\d]{10}$/";
	$regexemail = "/^[a-zA-Z\d\._]+@[a-zA-Z\d\._]+\.[a-zA-Z\d]{2,}+$/";

	if (preg_match($regexname, $fname)) {
		if (preg_match($regexname, $mname)) {
			if (preg_match($regexname, $lname)) {
				if (preg_match($regexmobileno, $contactno)) {
					if (preg_match($regexemail, $email)) {

						$sql = " UPDATE `users`
								SET `user_fname` = '$fname',
								`user_mname` = '$mname',
								`user_lname` = '$lname',
								`gender`= '$gender',
								`bday` ='$bday',
								`city` = '$citymunicipality',
								`province` = '$prov',
								`email` = '$email',
								`contact_no` = '$contactno',
								`user_status` = '$status',
								`user_type` = '$usertype'
								WHERE `empid` = '$uid'";

						$stmt = mysqli_stmt_init($conn);
						if (mysqli_stmt_prepare($stmt, $sql)) {
							if (mysqli_stmt_execute($stmt)) {

								$user_activity = "Update User's Information";
								$details = "Update user information with name '$fname $lname', id '$uid'";
								include '../log.php';

								echo "<script language='javascript'>";
								echo 'alert("' . $fname . ' ' . $lname . ' is successfully updated!");';
								echo 'window.location.replace("../../user_list.php?updateuser=success");';
								echo "</script>";
							}
						} else {
							echo "<script language='javascript'>";
							echo 'alert("Something went wrong, Please try again later");';
							echo 'window.location.replace("../../user_list.php?updateuser=failed");';
							echo "</script>";
						}
					} else {
						echo "<script language='javascript'>";
						echo 'alert("Please enter a valid email address");';
						echo 'window.location.replace("../../user_list.php?updateuser=failed");';
						echo "</script>";
					}
				} else {
					echo "<script language='javascript'>";
					echo 'alert("Please enter a valid mobile number or follow the format (09XXXXXXXXX or +639XXXXXXXXX)");';
					echo 'window.location.replace("../../user_list.php?updateuser=failed");';
					echo "</script>";
				}
			} else {
				echo "<script language='javascript'>";
				echo 'alert("Please enter a valid last name");';
				echo 'window.location.replace("../../user_list.php?updateuser=failed");';
				echo "</script>";
			}
		} else {
			echo "<script language='javascript'>";
			echo 'alert("Please enter a valid middle name");';
			echo 'window.location.replace("../../user_list.php?updateuser=failed");';
			echo "</script>";
		}
	} else {
		echo "<script language='javascript'>";
		echo 'alert("Please enter a valid first name");';
		echo 'window.location.replace("../../user_list.php?updateuser=failed");';
		echo "</script>";
	}
}
