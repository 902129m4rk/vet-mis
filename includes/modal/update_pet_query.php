<?php
require_once '../config.php';
session_start();
if (isset($_POST['update'])) {

	$id = filter_input(INPUT_POST, 'id');
	$name = ucfirst(filter_input(INPUT_POST, 'pet_name'));
	$gender = ucfirst(filter_input(INPUT_POST, 'pet_gender'));
	$bday = filter_input(INPUT_POST, 'pet_bday');
	$weight = filter_input(INPUT_POST, 'weight');
	$species = ucfirst(filter_input(INPUT_POST, 'pet_species'));
	$breed = ucfirst(filter_input(INPUT_POST, 'pet_breed'));
	$vitalitystat = filter_input(INPUT_POST, 'pet_vitality_status');


	$regexpetname = "/^[a-zA-Z0-9\d\s\.\-]+$/";
	$regexname = "/^[a-zA-Z\s\,\-]+$/";

	if (preg_match($regexpetname, $name)) {
		if (!empty($breed)) {
			if (preg_match($regexname, $breed)) {
				$sql = " UPDATE `pet`
				SET `name` = '$name',
				`gender`= '$gender',
				`bday` ='$bday',
				`weight` = '$weight',
				`species` = '$species',
				`breed` = '$breed',
				`vitality_status` = '$vitalitystat'
				WHERE `id` = '$id'";

				$stmt = mysqli_stmt_init($conn);
				if (mysqli_stmt_prepare($stmt, $sql)) {

					if (mysqli_stmt_execute($stmt)) {
						$user_activity = "Update pet information";
						$details = "Update information for pet named '$name', id '$id'";
						include '../log.php';

						echo "<script language='javascript'>";
						echo 'alert("' . $name . ' is successfully updated!");';
						echo 'window.location.replace("../../pet_information.php?id=' . $id . '");';
						echo "</script>";
					}
				} else {
					echo "<script language='javascript'>";
					echo 'alert("Something went wrong,Please try again later");';
					echo 'window.location.replace("../../pet_list.php?updatepet=failed");';
					echo "</script>";
				}
			} else {
				echo "<script language='javascript'>";
				echo 'alert("Please enter a valid breed name");';
				echo 'window.location.replace("../../pet_list.php?updatepet=failed");';
				echo "</script>";
			}
		} else {
			$sql = " UPDATE `pet`
				SET `name` = '$name',
				`gender`= '$gender',
				`bday` ='$bday',
				`weight` = '$weight',
				`species` = '$species',
				`breed` = NULL,
				`vitality_status` = '$vitalitystat'
				WHERE `id` = '$id'";

			$stmt = mysqli_stmt_init($conn);
			if (mysqli_stmt_prepare($stmt, $sql)) {

				if (mysqli_stmt_execute($stmt)) {
					$user_activity = "Update pet information";
					$details = "Update information for pet named '$name', id '$id'";
					include '../log.php';

					echo "<script language='javascript'>";
					echo 'alert("' . $name . ' is successfully updated!");';
					echo 'window.location.replace("../../pet_information.php?id=' . $id . '");';
					echo "</script>";
				}
			} else {
				echo "<script language='javascript'>";
				echo 'alert("Something went wrong,Please try again later");';
				echo 'window.location.replace("../../pet_list.php?updatepet=failed");';
				echo "</script>";
			}
		}
	} else {
		echo "<script language='javascript'>";
		echo 'alert("Please enter a valid pet name");';
		echo 'window.location.replace("../../pet_list.php?updatepet=failed");';
		echo "</script>";
	}
}
mysqli_close($stmt);
