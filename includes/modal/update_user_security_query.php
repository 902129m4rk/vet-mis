<?php
require_once '../config.php';
session_start();
if (isset($_POST['update'])) {

	$empid = filter_input(INPUT_POST, 'empid');
	$new_pass = filter_input(INPUT_POST, 'user_newpass');
	$confirm_pass = filter_input(INPUT_POST, 'user_confirmpass');
	$fname = filter_input(INPUT_POST, 'fname');
	$lname = filter_input(INPUT_POST, 'lname');

	//Regular Expression Variable
	$regexpassword =  "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[^\w\s]).{8,}$/";


	if (preg_match($regexpassword, $new_pass)) {
		if ($new_pass == $confirm_pass) {
			$sqlpass = "SELECT * FROM users  WHERE `empid` = '$empid'";
			$resultpass = mysqli_query($conn, $sqlpass);
			$rowpass = mysqli_fetch_object($resultpass);

			$new_pass = password_hash($new_pass, PASSWORD_DEFAULT);

			$sqlnewpass = "UPDATE users SET pass='$new_pass' WHERE `empid` = '$empid' ";
			if (mysqli_query($conn, $sqlnewpass)) {

				$user_activity = "Update User's Password";
				$details = "Updated password with name '$fname $lname', id '$empid'";
				include '../log.php';

				echo "<script language='javascript'>";
				echo 'alert("' . $fname . ' ' .  $lname . ' password has been changed");';
				echo 'window.location.replace("../../user_list.php?changepassword=success");';
				echo "</script>";
			}
		} else {
			$confirmpass_error  = "Your password did not match";
			echo "<script language='javascript'>";
			echo 'alert("Password did not match, Please try again later.");';
			echo 'window.location.replace("../../user_list.php?changepassword=failed");';
			echo "</script>";
		}
	} else {
		echo "<script language='javascript'>";
		echo 'alert("Password must contain 8 or more characters with a mix of upper and lowercase letters, numbers and symbols , Please try again later.");';
		echo 'window.location.replace("../../user_list.php?changepassword=failed");';
		echo "</script>";
	}
} else {
	echo "<script language='javascript'>";
	echo 'alert("Something went wrong, Please try again later");';
	echo 'window.location.replace("../../user_list.php?changepassword=failed");';
	echo "</script>";
}
