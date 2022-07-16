<?php
require_once '../config.php';
session_start();
if (isset($_POST['update'])) {

	$id = filter_input(INPUT_POST, 'id');

	//Test Group
	$testgroupname = ucfirst(filter_input(INPUT_POST, 'test_group_name'));
	$cost = filter_input(INPUT_POST, 'tg_cost');
	$status = filter_input(INPUT_POST, 'status');


	// REGEX/ FORM VALIDATION
	$regexname = "/^[a-zA-Z\s\,\-\(\)\/]+$/";

	if (preg_match($regexname, $testgroupname)) {
		$sql = " UPDATE `test_group`
			SET `test_group_name` = '$testgroupname',
			status = '$status',
			price = '$cost'
			WHERE `test_group_id` = '$id'";

		$stmt = mysqli_stmt_init($conn);
		if (mysqli_stmt_prepare($stmt, $sql)) {
			if (mysqli_stmt_execute($stmt)) {

				$user_activity = "Update Test Group";
				$details = "Updated test group named '$testgroupname', id '$id'";
				include '../log.php';

				echo "<script language='javascript'>";
				echo 'alert("' . $testgroupname . ' is successfully updated!");';
				echo 'window.location.replace("../../lab_test_group.php?updatelabtestgroup=success");';
				echo "</script>";
			}
		} else {
			echo "<script language='javascript'>";
			echo 'alert("Something went wrong, Please try again later");';
			echo 'window.location.replace("../../lab_test_group.php?updatelabtestgroup=failed");';
			echo "</script>";
		}
	} else {
		echo "<script language='javascript'>";
		echo 'alert("Please enter a valid test group name");';
		echo 'window.location.replace("../../lab_test_group.php?updatelabtestgroup=failed");';
		echo "</script>";
	}
} else {
	echo "<script language='javascript'>";
	echo 'alert("Something went wrong, Please try again later");';
	echo 'window.location.replace("../../lab_test_group.php?updatelabtestgroup=failed");';
	echo "</script>";
}
