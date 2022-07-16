<?php
require_once '../config.php';
session_start();
if (isset($_POST['update'])) {

	$id = filter_input(INPUT_POST, 'id');
	$businessno = filter_input(INPUT_POST, 'business_number');
	$clinicname = ucfirst(filter_input(INPUT_POST, 'clinic_name'));
	$ownerfname = ucfirst(filter_input(INPUT_POST, 'clinic_owner_fname'));
	$ownerlname = ucfirst(filter_input(INPUT_POST, 'clinic_owner_lname'));
	$city = ucfirst(filter_input(INPUT_POST, 'select_city'));
	$province = ucfirst(filter_input(INPUT_POST, 'select_prov'));
	$clinicphoneno = filter_input(INPUT_POST, 'clinic_phoneno');

	// REGEX/ FORM VALIDATION
	$regexname = "/^[a-zA-Z\s\,\-]+$/";
	$regexclinicphoneno = "/^[0-9\d\-\(\)\+\s]+$/";

	if (preg_match($regexname, $ownerfname)) {
		if (preg_match($regexname, $ownerlname)) {
			if (preg_match($regexclinicphoneno, $clinicphoneno)) {
				$sql = " UPDATE `company_info`
						SET `business_number`= '$businessno',
						`clinic_name`= '$clinicname',
						`clinic_contactno`= '$clinicphoneno',
						`owner_fname` ='$ownerfname',
						`owner_lname` = '$ownerlname',
						`city` = '$city',
						`province` = '$province'
						WHERE `id` = '$id '";

				$stmt = mysqli_stmt_init($conn);
				if (mysqli_stmt_prepare($stmt, $sql)) {
					if (mysqli_stmt_execute($stmt)) {

						$user_activity = "Update Company Profile";
						$details = "Company profile was successfully updated";
						include '../log.php';

						echo "<script language='javascript'>";
						echo 'alert("Company profile is successfully updated!");';
						echo 'window.location.replace("../../company_profile.php?updateinfo=success");';
						echo "</script>";
					}
				} else {
					echo "<script language='javascript'>";
					echo 'alert("Something went wrong,Please try again later");';
					echo 'window.location.replace("../../company_profile.php?updateinfo=failed");';
					echo "</script>";
				}
			} else {
				echo "<script language='javascript'>";
				echo 'alert("Please enter a valid phone number");';
				echo 'window.location.replace("../../company_profile.php?updateinfo=failed");';
				echo "</script>";
			}
		} else {
			echo "<script language='javascript'>";
			echo 'alert("Please enter a valid last name");';
			echo 'window.location.replace("../../company_profile.php?updateinfo=failed");';
			echo "</script>";
		}
	} else {
		echo "<script language='javascript'>";
		echo 'alert("Please enter a valid first name");';
		echo 'window.location.replace("../../company_profile.php?updateinfo=failed");';
		echo "</script>";
	}
}
