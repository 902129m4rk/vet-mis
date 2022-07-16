<?php
require_once '../config.php';
session_start();
$patientno = filter_input(INPUT_POST, 'id');
$description = ucfirst(filter_input(INPUT_POST, 'file_description'));
// File upload path
$targetDir = "../../file/";
$fileName = basename($_FILES["file"]["name"]);
$targetFilePath = $targetDir . $fileName;
$fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

$provider = $_SESSION["empid"];

if (isset($_POST["add"]) && !empty($_FILES["file"]["name"])) {
	if (empty($fileName) and empty($description)) {
		echo "<script language='javascript'>";
		echo 'alert("Please input some data");';
		echo 'window.location.replace("../../add_pet_doc.php");';
		echo "</script>";
		exit();
	} else {

		// Allow certain file formats
		$allowTypes = array('jpg', 'png', 'jpeg', 'pdf', 'doc', 'docx');
		if (in_array($fileType, $allowTypes)) {
			// Upload file to server
			if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {

				$checkfile = mysqli_real_escape_string($conn, $fileName);
				$check_duplicate_file = "SELECT file_name FROM medical_records WHERE file_name='$fileName'";
				$fileresult = mysqli_query($conn, $check_duplicate_file);
				if (mysqli_num_rows($fileresult) > 0) {
					echo "<script language='javascript'>";
					echo 'alert("Sorry, this file is already uploaded. Try to rename the file or upload a new one");';
					echo 'window.location.replace("../../pet_information.php?id=' . $patientno . '");';
					echo "</script>";
				} else {

					$insert = "INSERT INTO `medical_records`(`file_name`,`pet_id`,`description`, `provider`, `date_created`) VALUES('$fileName','$patientno','$description', '$provider', NOW())";
					$query = mysqli_query($conn, $insert) or die(mysqli_error($conn));
					if ($query) {
						$logquerypet = "SELECT * FROM pet WHERE id ='$patientno';";
						$logsqlpet = mysqli_query($conn, $logquerypet);
						$logfetchpettb = mysqli_fetch_assoc($logsqlpet);
						$logpetname = $logfetchpettb['name'];

						$user_activity = "Upload File";
						$details = "Upload file for pet named '$logpetname', id '$patientno',";
						include '../log.php';


						echo "<script language='javascript'>";
						echo 'alert("The file ' . $fileName . ' has been uploaded successfully");';
						echo 'window.location.replace("../../pet_information.php?id=' . $patientno . '");';
						echo "</script>";

						$sql4 = "SELECT id FROM medical_records ORDER BY id DESC";
						$result4 = mysqli_query($conn, $sql4);
						if ($row4 = mysqli_fetch_assoc($result4)) {
							$link = $base_url . "download.php?id=" . $row4['id'];
							$link_status = "display: block;";
						}
						// exit();
					} else {
						// $statusMsg = "File upload failed, please try again.";
						echo "<script language='javascript'>";
						echo 'alert("File upload failed, please try again");';
						echo 'window.location.replace("../../pet_information.php?id=' . $patientno . '");';
						echo "</script>";
						exit();
					}
				}
			} else {
				// $statusMsg = "Sorry, there was an error uploading your file.";
				echo "<script language='javascript'>";
				echo 'alert("Sorry, there was an error uploading your file");';
				echo 'window.location.replace("../../pet_information.php?id=' . $patientno . '");';
				echo "</script>";
				exit();
			}
		} else {
			// $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, DOCS, DOCX & PDF files are allowed to upload.';
			echo "<script language='javascript'>";
			echo 'alert("Sorry, only JPG, JPEG, PNG, DOCX, DOC & PDF files are allowed to upload");';
			echo 'window.location.replace("../../pet_information.php?id=' . $patientno . '");';
			echo "</script>";
			exit();
		}
	}
}
// Display status message
// echo $statusMsg;
