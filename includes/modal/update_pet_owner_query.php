<?php
require_once '../config.php';
session_start();
if (isset($_POST['update'])) {

	$id = filter_input(INPUT_POST, 'id');;
	$fname = ucfirst(filter_input(INPUT_POST, 'fname'));
	$lname = ucfirst(filter_input(INPUT_POST, 'lname'));
	$gender = ucfirst(filter_input(INPUT_POST, 'owner_gender'));
	$bday = filter_input(INPUT_POST, 'owner_bday');
	$citymunicipality = ucfirst(filter_input(INPUT_POST, 'select_city'));
	$prov = ucfirst(filter_input(INPUT_POST, 'select_prov'));
	$email = filter_input(INPUT_POST, 'email');
	$contactno = filter_input(INPUT_POST, 'contactno');

	// REGEX/ FORM VALIDATION
	$regexname = "/^[a-zA-Z\s\,\-]+$/";
	$regexmobileno = "/^[09|+639]+[0-9\d]{10}$/";
	$regexemail = "/^[a-zA-Z\d\._]+@[a-zA-Z\d\._]+\.[a-zA-Z\d]{2,}+$/";
	$regexaddress = "/^[a-zA-Z0-9\d\s\.\-]+$/";


	if (preg_match($regexname, $fname)) {
		if (preg_match($regexname, $lname)) {
			if (preg_match($regexmobileno, $contactno)) {
				if (preg_match($regexemail, $email)) {
					$sql = " UPDATE `owner`
								SET `fname` = '$fname',
								`lname` = '$lname',
								`gender`= '$gender',
								`bday` ='$bday',
								`city` = '$citymunicipality',
								`province` = '$prov',
								`email` = '$email',
								`contactno` = '$contactno'
								WHERE `id` = '$id'";

					$stmt = mysqli_stmt_init($conn);
					if (mysqli_stmt_prepare($stmt, $sql)) {
						if (mysqli_stmt_execute($stmt)) {

							$user_activity = "Update pet owner information";
							$details = "Update information for pet owner named '$fname $lname', id '$id'";
							include '../log.php';


							echo "<script language='javascript'>";
							echo 'alert("' . $fname . ' ' . $lname . ' information is successfully updated!");';
							echo 'window.location.replace("../../pet_owner_information.php?id=' . $id . '");';
							echo "</script>";
						}
					} else {
						echo "<script language='javascript'>";
						echo 'alert("Something went wrong, Please try again later");';
						echo 'window.location.replace("../../pet_owner_list.php?updateclient=failed");';
						echo "</script>";
					}
				} else {
					echo "<script language='javascript'>";
					echo 'alert("Please enter a valid email address");';
					echo 'window.location.replace("../../pet_owner_list.php?updateclient=failed");';
					echo "</script>";
				}
			} else {
				echo "<script language='javascript'>";
				echo 'alert("Please enter a valid mobile number or follow the format (09XXXXXXXXX or +639XXXXXXXXX)");';
				echo 'window.location.replace("../../pet_owner_list.php?updateclient=failed");';
				echo "</script>";
			}
		} else {
			echo "<script language='javascript'>";
			echo 'alert("Please enter a valid last name");';
			echo 'window.location.replace("../../pet_owner_list.php?updateclient=failed");';
			echo "</script>";
		}
	} else {
		echo "<script language='javascript'>";
		echo 'alert("Please enter a valid first name");';
		echo 'window.location.replace("../../pet_owner_list.php?updateclient=failed");';
		echo "</script>";
	}
}
