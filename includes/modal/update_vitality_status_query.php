<?php
require_once '../config.php';
session_start();
if (isset($_POST['update'])) {

	$id = filter_input(INPUT_POST, 'id');
	$vitalitystat = filter_input(INPUT_POST, 'pet_vitality_status');
	$petname = filter_input(INPUT_POST, 'petname');


	$sqlvitalstat = " UPDATE `pet`
	SET `vitality_status` = '$vitalitystat'
	WHERE `id` = '$id'";


	$stmt = mysqli_stmt_init($conn);
	if (mysqli_stmt_prepare($stmt,  $sqlvitalstat)) {
		if (mysqli_stmt_execute($stmt)) {
			$user_activity = "Update pet vitality status";
			$details = "Update pet vitality status to '$vitalitystat'";
			include '../log.php';

			echo "<script language='javascript'>";
			echo 'alert("' . $petname . ' vitality status was successfully updated!");';
			echo 'window.location.replace("../../pet_information.php?id=' . $id . '");';
			echo "</script>";
		}
	} else {
		echo "<script language='javascript'>";
		echo 'alert("Something went wrong, Please try again later");';
		echo 'window.location.replace("../../pet_information.php?id=' . $id . '");';
		echo "</script>";
	}
}
