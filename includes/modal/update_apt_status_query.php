<?php
require_once '../config.php';
session_start();

if (isset($_POST['update'])) {

	$aptid = filter_input(INPUT_POST, 'id_update');
	$aptstatus =   filter_input(INPUT_POST, 'apt_stat_update');

	$date = filter_input(INPUT_POST, 'apt_date_update');
	$time = filter_input(INPUT_POST, 'apt_time_update');


	$scheduled =  'Scheduled';

	$orig_aptstat =   filter_input(INPUT_POST, 'orig_aptstat');
	$orig_date =   filter_input(INPUT_POST, 'orig_date');
	$orig_time =   filter_input(INPUT_POST, 'orig_time');
	$orig_service =   filter_input(INPUT_POST, 'orig_service');
	$orig_vet =   filter_input(INPUT_POST, 'orig_vet');

	if (($aptid) <= 9) {
		$appointmentid  = 'APT-000';
		$appointmentid  .= $aptid;
	} elseif (($aptid) <= 99) {
		$appointmentid  = 'APT-00';
		$appointmentid  .= $aptid;
	} elseif (($aptid) <= 999) {
		$appointmentid =  'APT-0';
		$appointmentid  .= $aptid;
	} else {
		$appointmentid  =  'APT-';
		$appointmentid  .= $aptid;
	}

	if (isset($_SESSION["utvet"])) {
		$assign_vet = $_SESSION["empid"];
	} else {
		$assign_vet =   filter_input(INPUT_POST, 'assign_vet_update');
	}


	if ($aptstatus != $scheduled) {

		$sqlsched = " UPDATE `appointment`
			SET `status` ='$aptstatus'
			WHERE `id` = '$aptid';";

		$stmtsched = mysqli_stmt_init($conn);
		if (mysqli_stmt_prepare($stmtsched, $sqlsched)) {

			if (mysqli_stmt_execute($stmtsched)) {
				$user_activity = "Update appointment status";
				$details = "Appointment id '$aptid' was successfully changed to '$aptstatus'";
				include '../log.php';

				echo "<script language='javascript'>";
				echo 'alert("' . $appointmentid  . ' is successfully updated");';
				echo 'window.location.replace("../../appointment_list.php?updateappointment=success");';
				echo "</script>";
			}
		} else {
			echo "<script language='javascript'>";
			echo 'alert("Something went wrong, Please try again later");';
			echo 'window.location.replace("../../appointment_list.php?updateappointment=failed");';
			echo "</script>";
		}
	} else {
		$sql = "SELECT * FROM appointment 
		WHERE `date` = '$orig_date'
		AND `time` = '$orig_time'
		AND `assigned_vet` = '$orig_vet'
		AND `status` = '$aptstatus'
		;";
		$query = mysqli_query($conn, $sql);

		if (mysqli_num_rows($query) > 0) {
			echo "<script language='javascript'>";
			echo 'alert("Sorry, this schedule is already occupied. Please try again");';
			echo 'window.location.replace("../../appointment_list.php?updateappointment=failed");';
			echo "</script>";
		} else {

			$sql = " UPDATE `appointment`
			SET `status` ='$aptstatus'
			WHERE `id` = '$aptid';";

			$stmt = mysqli_stmt_init($conn);
			if (mysqli_stmt_prepare($stmt, $sql)) {

				if (mysqli_stmt_execute($stmt)) {
					$user_activity = "Update appointment status";
					$details = "Appointment id '$aptid' was successfully changed to '$aptstatus'";
					include '../log.php';
					echo "<script language='javascript'>";
					echo 'alert("' . $appointmentid  . ' is successfully updated");';
					echo 'window.location.replace("../../appointment_list.php?updateappointment=success");';
					echo "</script>";
				}
			} else {
				echo "<script language='javascript'>";
				echo 'alert("Something went wrong, Please try again later");';
				echo 'window.location.replace("../../appointment_list.php?updateappointment=failed");';
				echo "</script>";
			}
		}
	}
}
