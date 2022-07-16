<?php
require_once '../config.php';
session_start();
if (isset($_POST['update'])) {

	$labid = filter_input(INPUT_POST, 'labid');

	// //Lab Details
	$testname = ucfirst(filter_input(INPUT_POST, 'test_name'));
	$testgroup = filter_input(INPUT_POST, 'test_group');
	$testunit = filter_input(INPUT_POST, 'test_unit');
	$normalmin = filter_input(INPUT_POST, 'normal_min');
	$normalmax = filter_input(INPUT_POST, 'normal_max');
	$status = filter_input(INPUT_POST, 'status');

	if (empty($testunit)) {
		$sql = " UPDATE `lab_tests_details`
			SET `test_group` = '$testgroup',
			`test_name`= '$testname',
			`normal_min` ='$normalmin',
			`lab_details_status` = '$status',
			`normal_max` = '$normalmax'
			WHERE `lab_test_details_id` = '$labid'";

		$stmt = mysqli_stmt_init($conn);
		if (mysqli_stmt_prepare($stmt, $sql)) {
			if (mysqli_stmt_execute($stmt)) {

				$user_activity = "Update lab test details";
				$details = "Updated lab test details named '$testname', id '$labid'";
				include '../log.php';

				echo "<script language='javascript'>";
				echo 'alert("' . $testname . ' is successfully updated!");';
				echo 'window.location.replace("../../lab_setting.php?updatelabtestdetails=success");';
				echo "</script>";
			}
		} else {
			echo "<script language='javascript'>";
			echo 'alert("Something went wrong, Please try again later");';
			echo 'window.location.replace("../../lab_setting.php?updatelabtestdetails=failed");';
			echo "</script>";
		}
	} else {
		$sql = "UPDATE `lab_tests_details`
		SET `test_group` = '$testgroup',
		`test_name` = '$testname',
		`normal_min` ='$normalmin',
		`normal_max` = '$normalmax',
		`unit` = '$testunit',
		`lab_details_status` = '$status'
		WHERE `lab_test_details_id` = '$labid'
		";

		$stmt = mysqli_stmt_init($conn);
		if (mysqli_stmt_prepare($stmt, $sql)) {
			if (mysqli_stmt_execute($stmt)) {

				$user_activity = "Update lab test details";
				$details = "Updated lab test details named '$testname', id '$labid'";
				include '../log.php';

				echo "<script language='javascript'>";
				echo 'alert("' . $testname . ' is successfully updated!");';
				echo 'window.location.replace("../../lab_setting.php?updatelabtestdetails=success");';
				echo "</script>";
			}
		} else {
			die(mysqli_error($conn));
			echo "<script language='javascript'>";
			echo 'alert("Something went wrong, Please try again later");';
			echo 'window.location.replace("../../lab_setting.php?updatelabtestdetails=failed");';
			echo "</script>";
		}
	}
} else {
	echo "<script language='javascript'>";
	echo 'alert("Something went wrong, Please try again later");';
	echo 'window.location.replace("../../lab_setting.php?updatelabtestdetails=failed");';
	echo "</script>";
}
