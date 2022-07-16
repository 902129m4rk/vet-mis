<?php
require_once '../config.php';
session_start();
if (isset($_POST['update'])) {

	$id = filter_input(INPUT_POST, 'id');
	$petid =   filter_input(INPUT_POST, 'petid');
	$patientname =  filter_input(INPUT_POST, 'pname');
	$service = filter_input(INPUT_POST, 'service');
	$date = filter_input(INPUT_POST, 'apt_date');
	$time = filter_input(INPUT_POST, 'apt_time');
	$aptstatus =   filter_input(INPUT_POST, 'status');

	$aptsched = 'Scheduled';

	$orig_aptstat =   filter_input(INPUT_POST, 'orig_aptstat');
	$orig_date =   filter_input(INPUT_POST, 'orig_date');
	$orig_time =   filter_input(INPUT_POST, 'orig_time');
	$orig_service =   filter_input(INPUT_POST, 'orig_service');
	$orig_vet =   filter_input(INPUT_POST, 'orig_vet');

	$assign_vet =   filter_input(INPUT_POST, 'assignedvet');

	//FETCH PET NAME
	$logquerypet = "SELECT * FROM pet WHERE id ='$petid';";
	$logsqlpet = mysqli_query($conn, $logquerypet);
	$logfetchpettb = mysqli_fetch_assoc($logsqlpet);
	$logpetname = $logfetchpettb['name'];

	if ($aptstatus != $aptsched) {
		$sql = " UPDATE `appointment`
		SET `service` = '$service',
		`date` = '$date',
		`time`= '$time',
		`assigned_vet` = '$assign_vet',
		`status` ='$aptstatus'
		WHERE `id` = '$id';";

		$stmt = mysqli_stmt_init($conn);
		if (mysqli_stmt_prepare($stmt, $sql)) {

			if (mysqli_stmt_execute($stmt)) {
				$user_activity = "Update appointment";
				$details = "Update appointment id '$id'";
				include '../log.php';

				echo "<script language='javascript'>";
				echo 'alert("' . $patientname . ' appointment is successfully updated!");';
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
		if ($orig_aptstat == $aptstatus and $orig_date == $date and $orig_time == $time and $orig_vet == $assign_vet) {
			$sql = " UPDATE `appointment`
			SET `service` = '$service',
			`date` = '$date',
			`time`= '$time',
			`assigned_vet` = '$assign_vet',
			`status` ='$aptstatus'
			WHERE `id` = '$id';";

			$stmt = mysqli_stmt_init($conn);
			if (mysqli_stmt_prepare($stmt, $sql)) {

				if (mysqli_stmt_execute($stmt)) {
					$user_activity = "Update appointment";
					$details = "Update appointment id '$id'";
					include '../log.php';

					echo "<script language='javascript'>";
					echo 'alert("' . $patientname . ' appointment is successfully updated!");';
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
			WHERE `date` = '$date'
			AND `time` = '$time'
			AND `assigned_vet` = '$assign_vet'
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
				SET `service` = '$service',
				`date` = '$date',
				`time`= '$time',
				`assigned_vet` = '$assign_vet',
				`status` ='$aptstatus'
				WHERE `id` = '$id';";

				$stmt = mysqli_stmt_init($conn);
				if (mysqli_stmt_prepare($stmt, $sql)) {

					if (mysqli_stmt_execute($stmt)) {
						$user_activity = "Update appointment";
						$details = "Update appointment id '$id'";
						include '../log.php';

						echo "<script language='javascript'>";
						echo 'alert("' . $patientname . ' appointment is successfully updated!");';
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
}
