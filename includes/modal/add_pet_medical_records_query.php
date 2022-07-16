<?php
require_once '../config.php';
session_start();

$patientno = filter_input(INPUT_POST, 'id');
$petname = filter_input(INPUT_POST, 'patientname');
$findings = ucfirst(filter_input(INPUT_POST, 'findings'));
$prescription = ucfirst(filter_input(INPUT_POST, 'prescription'));
$description = ucfirst(filter_input(INPUT_POST, 'description'));
$provider = $_SESSION["empid"];


// patient name
if (($patientno) <= 9) {
	$patientname = 'PTNT-000';
	$patientname .= $patientno;
} elseif (($patientno) <= 99) {
	$patientname = 'PTNT-00';
	$patientname .= $patientno;
} elseif (($patientno) <= 999) {
	$patientname = 'PTNT-0';
	$patientname .= $patientno;
} else {
	$patientname = 'PTNT-';
	$patientname .= $patientno;
}

if (isset($_POST["add"])) {
	//FETCH PET NAME
	$logquerypet = "SELECT * FROM pet WHERE id ='$patientno';";
	$logsqlpet = mysqli_query($conn, $logquerypet);
	$logfetchpettb = mysqli_fetch_assoc($logsqlpet);
	$logpetname = $logfetchpettb['name'];

	// File upload path
	$targetDir = "../../file/";
	$fileName = basename($_FILES["file"]["name"]);
	$targetFilePath = $targetDir . $fileName;
	$fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

	if (empty($fileName) and empty($findings) and empty($prescription) and empty($description)) {
		echo "<script language='javascript'>";
		echo 'alert("Please input some medical document/diagnosis");';
		echo 'window.location.replace("../../add_pet_medical_records.php");';
		echo "</script>";
		exit();
	} elseif (!empty($fileName) and !empty($findings) and !empty($prescription) and !empty($description)) {
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
					echo 'window.location.replace("../../add_pet_medical_records.php");';
					echo "</script>";
					// return false;
				} else {

					$insert = "INSERT INTO `medical_records`(`file_name`,`pet_id`,`description`,`provider`,`findings`,`prescription`,`date_created`) VALUES('$fileName','$patientno','$description','$provider','$findings','$prescription',NOW())";
					$query = mysqli_query($conn, $insert) or die(mysqli_error($conn));
					if ($query) {
						$mr_id = mysqli_insert_id($conn);

						$user_activity = "Add Medical Record";
						$details = "Added medical record for pet name '$logpetname', id '$patientno' ";
						include '../log.php';

						echo "<script language='javascript'>";
						echo 'alert("' . $logpetname . ' medical record is successfully added!");';
						if (empty($prescription) and empty($findingss)) {
							echo 'window.location.replace("../../pet_information.php?id=' . $patientno . '");';
						} else {
							echo 'window.location.replace("../../medical_records_information.php?medical_records=' . $mr_id . '");';
						}
						echo "</script>";
					} else {
						$statusMsg = "File upload failed, please try again.";
						echo "<script language='javascript'>";
						// echo 'alert("File upload failed, please try again");';
						echo 'alert("Something went wrong, Please try again later");';
						echo 'window.location.replace("../../add_pet_medical_records.php");';
						echo "</script>";
						exit();
					}
				}
			} else {
				// $statusMsg = "Sorry, there was an error uploading your file.";
				echo "<script language='javascript'>";
				echo 'alert("Sorry, there was an error uploading your file");';
				echo 'window.location.replace("../../add_pet_medical_records.php");';
				echo "</script>";
				exit();
			}
		} else {
			// $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, DOCS, DOCX & PDF files are allowed to upload.';
			echo "<script language='javascript'>";
			echo 'alert("Sorry, only JPG, JPEG, PNG, DOCX, DOC & PDF files are allowed to upload");';
			echo 'window.location.replace("../../add_pet_medical_records.php");';
			echo "</script>";
			exit();
		}
	} elseif (!empty($fileName) and !empty($findings) and !empty($prescription)) {
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
					echo 'window.location.replace("../../add_pet_medical_records.php");';
					echo "</script>";
					// return false;
				} else {

					$insert = "INSERT INTO `medical_records`(`file_name`,`pet_id`,`provider`,`findings`,`prescription`,`date_created`) VALUES('$fileName','$patientno','$provider','$findings','$prescription',NOW())";
					$query = mysqli_query($conn, $insert) or die(mysqli_error($conn));
					if ($query) {
						$mr_id = mysqli_insert_id($conn);

						$user_activity = "Add Medical Record";
						$details = "Added medical record for pet name '$logpetname', id '$patientno' ";
						include '../log.php';

						echo "<script language='javascript'>";
						echo 'alert("' . $logpetname . ' medical record is successfully added!");';
						if (empty($prescription) and empty($findingss)) {
							echo 'window.location.replace("../../pet_information.php?id=' . $patientno . '");';
						} else {
							echo 'window.location.replace("../../medical_records_information.php?medical_records=' . $mr_id . '");';
						}
						echo "</script>";
					} else {
						$statusMsg = "File upload failed, please try again.";
						echo "<script language='javascript'>";
						echo 'alert("Something went wrong, Please try again later");';
						echo 'window.location.replace("../../add_pet_medical_records.php");';
						echo "</script>";
						exit();
					}
				}
			} else {
				// $statusMsg = "Sorry, there was an error uploading your file.";
				echo "<script language='javascript'>";
				echo 'alert("Sorry, there was an error uploading your file");';
				echo 'window.location.replace("../../add_pet_medical_records.php");';
				echo "</script>";
				exit();
			}
		} else {
			// $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, DOCS, DOCX & PDF files are allowed to upload.';
			echo "<script language='javascript'>";
			echo 'alert("Sorry, only JPG, JPEG, PNG, DOCX, DOC & PDF files are allowed to upload");';
			echo 'window.location.replace("../../add_pet_medical_records.php");';
			echo "</script>";
			exit();
		}
	} elseif (!empty($fileName) and !empty($findings) and !empty($description)) {
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
					echo 'window.location.replace("../../add_pet_medical_records.php");';
					echo "</script>";
					// return false;
				} else {

					$insert = "INSERT INTO `medical_records`(`file_name`,`pet_id`,`description`,`provider`,`findings`,`date_created`) VALUES('$fileName','$patientno','$description','$provider','$findings',NOW())";
					$query = mysqli_query($conn, $insert) or die(mysqli_error($conn));
					if ($query) {
						$mr_id = mysqli_insert_id($conn);

						$user_activity = "Add Medical Record";
						$details = "Added medical record for pet name '$logpetname', id '$patientno' ";
						include '../log.php';

						echo "<script language='javascript'>";
						echo 'alert("' . $logpetname . ' medical record is successfully added!");';
						echo 'window.location.replace("../../medical_records_information.php?medical_records=' . $mr_id . '");';
						echo "</script>";
					} else {
						$statusMsg = "File upload failed, please try again.";
						echo "<script language='javascript'>";
						// echo 'alert("File upload failed, please try again");';
						echo 'alert("Something went wrong, Please try again later");';
						echo 'window.location.replace("../../add_pet_medical_records.php");';
						echo "</script>";
						exit();
					}
				}
			} else {
				// $statusMsg = "Sorry, there was an error uploading your file.";
				echo "<script language='javascript'>";
				echo 'alert("Sorry, there was an error uploading your file");';
				echo 'window.location.replace("../../add_pet_medical_records.php");';
				echo "</script>";
				exit();
			}
		} else {
			// $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, DOCS, DOCX & PDF files are allowed to upload.';
			echo "<script language='javascript'>";
			echo 'alert("Sorry, only JPG, JPEG, PNG, DOCX, DOC & PDF files are allowed to upload");';
			echo 'window.location.replace("../../add_pet_medical_records.php");';
			echo "</script>";
			exit();
		}
	} elseif (!empty($fileName) and !empty($prescription) and !empty($description)) {
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
					echo 'window.location.replace("../../add_pet_medical_records.php");';
					echo "</script>";
					// return false;
				} else {

					$insert = "INSERT INTO `medical_records`(`file_name`,`pet_id`,`description`,`provider`,`prescription`,`date_created`) VALUES('$fileName','$patientno','$description','$provider','$prescription',NOW())";
					$query = mysqli_query($conn, $insert) or die(mysqli_error($conn));
					if ($query) {
						$mr_id = mysqli_insert_id($conn);

						$user_activity = "Add Medical Record";
						$details = "Added medical record for pet name '$logpetname', id '$patientno' ";
						include '../log.php';

						echo "<script language='javascript'>";
						echo 'alert("' . $logpetname . ' medical record is successfully added!");';
						echo 'window.location.replace("../../medical_records_information.php?medical_records=' . $mr_id . '");';
						echo "</script>";
					} else {
						$statusMsg = "File upload failed, please try again.";
						echo "<script language='javascript'>";
						// echo 'alert("File upload failed, please try again");';
						echo 'alert("Something went wrong, Please try again later");';
						echo 'window.location.replace("../../add_pet_medical_records.php");';
						echo "</script>";
						exit();
					}
				}
			} else {
				// $statusMsg = "Sorry, there was an error uploading your file.";
				echo "<script language='javascript'>";
				echo 'alert("Sorry, there was an error uploading your file");';
				echo 'window.location.replace("../../add_pet_medical_records.php");';
				echo "</script>";
				exit();
			}
		} else {
			// $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, DOCS, DOCX & PDF files are allowed to upload.';
			echo "<script language='javascript'>";
			echo 'alert("Sorry, only JPG, JPEG, PNG, DOCX, DOC & PDF files are allowed to upload");';
			echo 'window.location.replace("../../add_pet_medical_records.php");';
			echo "</script>";
			exit();
		}
	} elseif (!empty($findings) and !empty($prescription) and !empty($description)) {
		$insert = "INSERT INTO `medical_records`(`pet_id`,`description`,`provider`,`findings`,`prescription`,`date_created`) VALUES('$patientno','$description','$provider','$findings','$prescription',NOW())";
		$query = mysqli_query($conn, $insert) or die(mysqli_error($conn));
		if ($query) {
			$mr_id = mysqli_insert_id($conn);

			$user_activity = "Add Medical Record";
			$details = "Added medical record for pet name '$logpetname', id '$patientno' ";
			include '../log.php';

			echo "<script language='javascript'>";
			echo 'alert("' . $logpetname . ' medical record is successfully added!");';
			echo 'window.location.replace("../../medical_records_information.php?medical_records=' . $mr_id . '");';
			echo "</script>";
		} else {
			$statusMsg = "File upload failed, please try again.";
			echo "<script language='javascript'>";
			// echo 'alert("File upload failed, please try again");';
			echo 'alert("Something went wrong, Please try again later");';
			echo 'window.location.replace("../../add_pet_medical_records.php");';
			echo "</script>";
			exit();
		}
	} elseif (!empty($fileName) and !empty($findings)) {
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
					echo 'window.location.replace("../../add_pet_medical_records.php");';
					echo "</script>";
					// return false;
				} else {

					$insert = "INSERT INTO `medical_records`(`file_name`,`pet_id`,`provider`,`findings`,`date_created`) VALUES('$fileName','$patientno','$provider','$findings',NOW())";
					$query = mysqli_query($conn, $insert) or die(mysqli_error($conn));
					if ($query) {
						$mr_id = mysqli_insert_id($conn);

						$user_activity = "Add Medical Record";
						$details = "Added medical record for pet name '$logpetname', id '$patientno' ";
						include '../log.php';

						echo "<script language='javascript'>";
						echo 'alert("' . $logpetname . ' medical record is successfully added!");';
						echo 'window.location.replace("../../medical_records_information.php?medical_records=' . $mr_id . '");';
						echo "</script>";
					} else {
						$statusMsg = "File upload failed, please try again.";
						echo "<script language='javascript'>";
						// echo 'alert("File upload failed, please try again");';
						echo 'alert("Something went wrong, Please try again later");';
						echo 'window.location.replace("../../add_pet_medical_records.php");';
						echo "</script>";
						exit();
					}
				}
			} else {
				// $statusMsg = "Sorry, there was an error uploading your file.";
				echo "<script language='javascript'>";
				echo 'alert("Sorry, there was an error uploading your file");';
				echo 'window.location.replace("../../add_pet_medical_records.php");';
				echo "</script>";
				exit();
			}
		} else {
			// $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, DOCS, DOCX & PDF files are allowed to upload.';
			echo "<script language='javascript'>";
			echo 'alert("Sorry, only JPG, JPEG, PNG, DOCX, DOC & PDF files are allowed to upload");';
			echo 'window.location.replace("../../add_pet_medical_records.php");';
			echo "</script>";
			exit();
		}
	} elseif (!empty($fileName) and !empty($prescription)) {
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
					echo 'window.location.replace("../../add_pet_medical_records.php");';
					echo "</script>";
					// return false;
				} else {

					$insert = "INSERT INTO `medical_records`(`file_name`,`pet_id`,`provider`,`prescription`,`date_created`) VALUES('$fileName','$patientno','$provider','$prescription',NOW())";
					$query = mysqli_query($conn, $insert) or die(mysqli_error($conn));
					if ($query) {
						$mr_id = mysqli_insert_id($conn);

						$user_activity = "Add Medical Record";
						$details = "Added medical record for pet name '$logpetname', id '$patientno' ";
						include '../log.php';

						echo "<script language='javascript'>";
						echo 'alert("' . $logpetname . ' medical record is successfully added!");';
						echo 'window.location.replace("../../medical_records_information.php?medical_records=' . $mr_id . '");';
						echo "</script>";
					} else {
						$statusMsg = "File upload failed, please try again.";
						echo "<script language='javascript'>";
						// echo 'alert("File upload failed, please try again");';
						echo 'alert("Something went wrong, Please try again later");';
						echo 'window.location.replace("../../add_pet_medical_records.php");';
						echo "</script>";
						exit();
					}
				}
			} else {
				// $statusMsg = "Sorry, there was an error uploading your file.";
				echo "<script language='javascript'>";
				echo 'alert("Sorry, there was an error uploading your file");';
				echo 'window.location.replace("../../add_pet_medical_records.php");';
				echo "</script>";
				exit();
			}
		} else {
			// $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, DOCS, DOCX & PDF files are allowed to upload.';
			echo "<script language='javascript'>";
			echo 'alert("Sorry, only JPG, JPEG, PNG, DOCX, DOC & PDF files are allowed to upload");';
			echo 'window.location.replace("../../add_pet_medical_records.php");';
			echo "</script>";
			exit();
		}
	} elseif (!empty($fileName) and !empty($description)) {
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
					echo 'window.location.replace("../../add_pet_medical_records.php");';
					echo "</script>";
					// return false;
				} else {

					$insert = "INSERT INTO `medical_records`(`file_name`,`pet_id`,`description`,`provider`,`date_created`) VALUES('$fileName','$patientno','$description','$provider',NOW())";
					$query = mysqli_query($conn, $insert) or die(mysqli_error($conn));
					if ($query) {
						$mr_id = mysqli_insert_id($conn);

						$user_activity = "Add Medical Record";
						$details = "Added medical record for pet name '$logpetname', id '$patientno' ";
						include '../log.php';

						echo "<script language='javascript'>";
						echo 'alert("' . $logpetname . ' medical record is successfully added!");';
						echo 'window.location.replace("../../pet_information.php?id=' . $patientno . '");';
						echo "</script>";
					} else {
						$statusMsg = "File upload failed, please try again.";
						echo "<script language='javascript'>";
						// echo 'alert("File upload failed, please try again");';
						echo 'alert("Something went wrong, Please try again later");';
						echo 'window.location.replace("../../add_pet_medical_records.php");';
						echo "</script>";
						exit();
					}
				}
			} else {
				// $statusMsg = "Sorry, there was an error uploading your file.";
				echo "<script language='javascript'>";
				echo 'alert("Sorry, there was an error uploading your file");';
				echo 'window.location.replace("../../add_pet_medical_records.php");';
				echo "</script>";
				exit();
			}
		} else {
			// $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, DOCS, DOCX & PDF files are allowed to upload.';
			echo "<script language='javascript'>";
			echo 'alert("Sorry, only JPG, JPEG, PNG, DOCX, DOC & PDF files are allowed to upload");';
			echo 'window.location.replace("../../add_pet_medical_records.php");';
			echo "</script>";
			exit();
		}
	} elseif (!empty($findings) and !empty($prescription)) {

		$insert = "INSERT INTO `medical_records`(`pet_id`,`provider`,`findings`,`prescription`,`date_created`) VALUES('$patientno','$provider','$findings','$prescription',NOW())";
		$query = mysqli_query($conn, $insert) or die(mysqli_error($conn));
		if ($query) {
			$mr_id = mysqli_insert_id($conn);

			$user_activity = "Add Medical Record";
			$details = "Added medical record for pet name '$logpetname', id '$patientno' ";
			include '../log.php';

			echo "<script language='javascript'>";
			echo 'alert("' . $logpetname . ' medical record is successfully added!");';
			echo 'window.location.replace("../../medical_records_information.php?medical_records=' . $mr_id . '");';
			echo "</script>";
		} else {
			$statusMsg = "File upload failed, please try again.";
			echo "<script language='javascript'>";
			// echo 'alert("File upload failed, please try again");';
			echo 'alert("Something went wrong, Please try again later");';
			echo 'window.location.replace("../../add_pet_medical_records.php");';
			echo "</script>";
			exit();
		}
	} elseif (!empty($findings) and !empty($description)) {
		$insert = "INSERT INTO `medical_records`(`pet_id`,`description`,`provider`,`findings`,`date_created`) VALUES('$patientno','$description','$provider','$findings',NOW())";
		$query = mysqli_query($conn, $insert) or die(mysqli_error($conn));
		if ($query) {
			$mr_id = mysqli_insert_id($conn);

			$user_activity = "Add Medical Record";
			$details = "Added medical record for pet name '$logpetname', id '$patientno' ";
			include '../log.php';

			echo "<script language='javascript'>";
			echo 'alert("' . $logpetname . ' medical record is successfully added!");';
			echo 'window.location.replace("../../medical_records_information.php?medical_records=' . $mr_id . '");';
			echo "</script>";
		} else {
			$statusMsg = "File upload failed, please try again.";
			echo "<script language='javascript'>";
			// echo 'alert("File upload failed, please try again");';
			echo 'alert("Something went wrong, Please try again later");';
			echo 'window.location.replace("../../add_pet_medical_records.php");';
			echo "</script>";
			exit();
		}
	} elseif (!empty($prescription) and !empty($description)) {
		$insert = "INSERT INTO `medical_records`(`pet_id`,`description`,`provider`,`prescription`,`date_created`) VALUES('$patientno','$description','$provider','$prescription',NOW())";
		$query = mysqli_query($conn, $insert) or die(mysqli_error($conn));
		if ($query) {
			$mr_id = mysqli_insert_id($conn);

			$user_activity = "Add Medical Record";
			$details = "Added medical record for pet name '$logpetname', id '$patientno' ";
			include '../log.php';

			echo "<script language='javascript'>";
			echo 'alert("' . $logpetname . ' medical record is successfully added!");';
			echo 'window.location.replace("../../medical_records_information.php?medical_records=' . $mr_id . '");';
			echo "</script>";
		} else {
			$statusMsg = "File upload failed, please try again.";
			echo "<script language='javascript'>";
			// echo 'alert("File upload failed, please try again");';
			echo 'alert("Something went wrong, Please try again later");';
			echo 'window.location.replace("../../add_pet_medical_records.php");';
			echo "</script>";
			exit();
		}
	} elseif (!empty($fileName)) {
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
					echo 'window.location.replace("../../add_pet_medical_records.php");';
					echo "</script>";
					// return false;
				} else {

					$insert = "INSERT INTO `medical_records`(`file_name`,`pet_id`,`provider`,`date_created`) VALUES('$fileName','$patientno','$provider',NOW())";
					$query = mysqli_query($conn, $insert) or die(mysqli_error($conn));
					if ($query) {
						$mr_id = mysqli_insert_id($conn);

						$user_activity = "Add Medical Record";
						$details = "Added medical record for pet name '$logpetname', id '$patientno' ";
						include '../log.php';

						echo "<script language='javascript'>";
						echo 'alert("' . $logpetname . ' medical record is successfully added!");';
						echo 'window.location.replace("../../pet_information.php?id=' . $patientno . '");';
						echo "</script>";
					} else {
						$statusMsg = "File upload failed, please try again.";
						echo "<script language='javascript'>";
						// echo 'alert("File upload failed, please try again");';
						echo 'alert("Something went wrong, Please try again later");';
						echo 'window.location.replace("../../add_pet_medical_records.php");';
						echo "</script>";
						exit();
					}
				}
			} else {
				// $statusMsg = "Sorry, there was an error uploading your file.";
				echo "<script language='javascript'>";
				echo 'alert("Sorry, there was an error uploading your file");';
				echo 'window.location.replace("../../add_pet_medical_records.php");';
				echo "</script>";
				exit();
			}
		} else {
			// $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, DOCS, DOCX & PDF files are allowed to upload.';
			echo "<script language='javascript'>";
			echo 'alert("Sorry, only JPG, JPEG, PNG, DOCX, DOC & PDF files are allowed to upload");';
			echo 'window.location.replace("../../add_pet_medical_records.php");';
			echo "</script>";
			exit();
		}
	} elseif (!empty($findings)) {

		$insert = "INSERT INTO `medical_records`(`pet_id`,`provider`,`findings`,`date_created`) VALUES('$patientno','$provider','$findings',NOW())";
		$query = mysqli_query($conn, $insert) or die(mysqli_error($conn));
		if ($query) {
			$mr_id = mysqli_insert_id($conn);

			$user_activity = "Add Medical Record";
			$details = "Added medical record for pet name '$logpetname', id '$patientno' ";
			include '../log.php';

			echo "<script language='javascript'>";
			echo 'alert("' . $logpetname . ' medical record is successfully added!");';
			echo 'window.location.replace("../../medical_records_information.php?medical_records=' . $mr_id . '");';
			echo "</script>";
		} else {
			$statusMsg = "File upload failed, please try again.";
			echo "<script language='javascript'>";
			// echo 'alert("File upload failed, please try again");';
			echo 'alert("Something went wrong, Please try again later");';
			echo 'window.location.replace("../../add_pet_medical_records.php");';
			echo "</script>";
			exit();
		}
	} elseif (!empty($prescription)) {

		$insert = "INSERT INTO `medical_records`(`pet_id`,`provider`,`prescription`,`date_created`) VALUES('$patientno','$provider','$prescription',NOW())";
		$query = mysqli_query($conn, $insert) or die(mysqli_error($conn));
		if ($query) {
			$mr_id = mysqli_insert_id($conn);

			$user_activity = "Add Medical Record";
			$details = "Added medical record for pet name '$logpetname', id '$patientno' ";
			include '../log.php';

			echo "<script language='javascript'>";
			echo 'alert("' . $logpetname . ' medical record is successfully added!");';
			echo 'window.location.replace("../../medical_records_information.php?medical_records=' . $mr_id . '");';
			echo "</script>";
		} else {
			$statusMsg = "File upload failed, please try again.";
			echo "<script language='javascript'>";
			// echo 'alert("File upload failed, please try again");';
			echo 'alert("Something went wrong, Please try again later");';
			echo 'window.location.replace("../../add_pet_medical_records.php");';
			echo "</script>";
			exit();
		}
	} elseif (!empty($description)) {
		echo "<script language='javascript'>";
		echo 'alert("Please input some medical document/diagnosis");';
		echo 'window.location.replace("../../add_pet_medical_records.php");';
		echo "</script>";
		exit();
	} else {
		if (!empty($fileName)) {
			$allowTypes = array('jpg', 'png', 'jpeg', 'pdf', 'doc', 'docx');
			if (in_array($fileType, $allowTypes)) {
				// Upload file to server
				if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {

					$checkfile = mysqli_real_escape_string($conn, $fileName);
					$check_duplicate_file = "SELECT file_name FROM medical_records WHERE file_name='$fileName'";
					$fileresult = mysqli_query($conn, $check_duplicate_file);
					if (mysqli_num_rows($fileresult) > 0) {
						$log = "Patient's file for patient id '$patientno' was unsuccessfully added";
						include '../log.php';
						echo "<script language='javascript'>";
						echo 'alert("Sorry, this file is already uploaded. Try to rename the file or upload a new one");';
						echo 'window.location.replace("../../add_pet_medical_records.php");';
						echo "</script>";
						// return false;
					} else {

						$insert = "INSERT INTO `medical_records`(`file_name`,`pet_id`,`description`,`provider`,`findings`,`prescription`,`date_created`) VALUES('$fileName','$patientno','$description','$provider','$findings','$prescription',NOW())";
						$query = mysqli_query($conn, $insert) or die(mysqli_error($conn));
						if ($query) {
							$mr_id = mysqli_insert_id($conn);
							$log = "The Medical Record for patient id '$patientno' was successfully added";
							include '../log.php';

							echo "<script language='javascript'>";
							echo 'alert("' . $logpetname . ' medical record is successfully added!");';
							if (empty($prescription) and empty($findingss)) {
								echo 'window.location.replace("../../pet_information.php?id=' . $patientno . '");';
							} else {
								echo 'window.location.replace("../../medical_records_information.php?medical_records=' . $mr_id . '");';
							}
							echo "</script>";

							// $sql4 = "SELECT medical_records_id FROM medical_records ORDER BY medical_records_id DESC";
							// $result4 = mysqli_query($conn, $sql4);
							// if ($row4 = mysqli_fetch_assoc($result4)) {
							// 	$link = $base_url . "download.php?id=" . $row4['medical_records_id'];
							// 	$link_status = "display: block;";
							// }
							// exit();
						} else {
							$statusMsg = "File upload failed, please try again.";
							echo "<script language='javascript'>";
							// echo 'alert("File upload failed, please try again");';
							echo 'alert("Something went wrong, Please try again later");';
							echo 'window.location.replace("../../add_pet_medical_records.php");';
							echo "</script>";
							exit();
						}
					}
				} else {
					// $statusMsg = "Sorry, there was an error uploading your file.";
					echo "<script language='javascript'>";
					echo 'alert("Sorry, there was an error uploading your file");';
					echo 'window.location.replace("../../add_pet_medical_records.php");';
					echo "</script>";
					exit();
				}
			} else {
				// $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, DOCS, DOCX & PDF files are allowed to upload.';
				echo "<script language='javascript'>";
				echo 'alert("Sorry, only JPG, JPEG, PNG, DOCX, DOC & PDF files are allowed to upload");';
				echo 'window.location.replace("../../add_pet_medical_records.php");';
				echo "</script>";
				exit();
			}
		} else {
			$sql = "INSERT INTO medical_records(pet_id, findings, prescription, description, provider, date_created) VALUES (?,?,?,?,?,NOW());";
			// $sql = "INSERT INTO owner(fname, lname, bday, gender, city, province, contactno, email) VALUES (?,?,?,?,?,?,?,?);";
			$stmt = mysqli_stmt_init($conn);

			if (mysqli_stmt_prepare($stmt, $sql)) {
				mysqli_stmt_bind_param($stmt, "sssss", $patientno, $findings, $prescription, $description, $provider);

				mysqli_stmt_execute($stmt);
				$mr_id = mysqli_insert_id($conn);

				// $log = "The Medical Record for patient id '$patientno' was successfully added";
				// include '../log.php';

				echo "<script language='javascript'>";
				echo 'alert("' . $logpetname . ' medical record is successfully added!");';
				// echo 'window.location.replace("../../patient_information.php?id=' . $patientno . '");';
				echo 'window.location.replace("../../medical_records_information.php?medical_records=' . $mr_id . '");';
				echo "</script>";
				exit();
			} else {
				echo "<script language='javascript'>";
				echo 'alert("Something went wrong, Please try again later");';
				// echo 'window.location.replace("../../dashboard.php?addpatient=failed");';
				echo 'window.location.replace("../../add_pet_medical_records.php");';
				echo "</script>";
				exit();
			}
		}
	}
}
//MODAL
elseif (isset($_POST["addmodal"])) {

	if (!empty($findings) and !empty($prescription) and !empty($description)) {
		$sql = "INSERT INTO medical_records(pet_id, findings, prescription, description, provider, date_created) VALUES (?,?,?,?,?,NOW());";
		// $sql = "INSERT INTO owner(fname, lname, bday, gender, city, province, contactno, email) VALUES (?,?,?,?,?,?,?,?);";
		$stmt = mysqli_stmt_init($conn);

		if (mysqli_stmt_prepare($stmt, $sql)) {
			mysqli_stmt_bind_param($stmt, "sssss", $patientno, $findings, $prescription, $description, $provider);

			mysqli_stmt_execute($stmt);
			$mr_id = mysqli_insert_id($conn);

			$user_activity = "Add Medical Record";
			$details = "Added medical record for pet name '$petname', id '$patientno' ";
			include '../log.php';

			echo "<script language='javascript'>";
			echo 'alert("' . $petname . ' medical record is successfully added!");';
			echo 'window.location.replace("../../medical_records_information.php?medical_records=' . $mr_id . '");';
			echo "</script>";
			exit();
		} else {
			echo "<script language='javascript'>";
			echo 'alert("Something went wrong, Please try again later");';
			// echo 'window.location.replace("../../dashboard.php?addpatient=failed");';
			echo 'window.location.replace("../../pet_information.php?id=' . $patientno . '");';
			echo "</script>";
			exit();
		}
	} elseif (!empty($findings) and !empty($prescription)) {
		$sql = "INSERT INTO medical_records(pet_id, findings, prescription, provider, date_created) VALUES (?,?,?,?,NOW());";
		// $sql = "INSERT INTO owner(fname, lname, bday, gender, city, province, contactno, email) VALUES (?,?,?,?,?,?,?,?);";
		$stmt = mysqli_stmt_init($conn);

		if (mysqli_stmt_prepare($stmt, $sql)) {
			mysqli_stmt_bind_param($stmt, "ssss", $patientno, $findings, $prescription, $provider);

			mysqli_stmt_execute($stmt);
			$mr_id = mysqli_insert_id($conn);

			$user_activity = "Add Medical Record";
			$details = "Added medical record for pet name '$petname', id '$patientno' ";
			include '../log.php';

			echo "<script language='javascript'>";
			echo 'alert("' . $petname . ' medical record is successfully added!");';
			echo 'window.location.replace("../../medical_records_information.php?medical_records=' . $mr_id . '");';
			echo "</script>";
			exit();
		} else {
			echo "<script language='javascript'>";
			echo 'alert("Something went wrong, Please try again later");';
			// echo 'window.location.replace("../../dashboard.php?addpatient=failed");';
			echo 'window.location.replace("../../pet_information.php?id=' . $patientno . '");';
			echo "</script>";
			exit();
		}
	} elseif (!empty($findings) and !empty($description)) {
		$sql = "INSERT INTO medical_records(pet_id, findings, description, provider, date_created) VALUES (?,?,?,?,NOW());";
		// $sql = "INSERT INTO owner(fname, lname, bday, gender, city, province, contactno, email) VALUES (?,?,?,?,?,?,?,?);";
		$stmt = mysqli_stmt_init($conn);

		if (mysqli_stmt_prepare($stmt, $sql)) {
			mysqli_stmt_bind_param($stmt, "ssss", $patientno, $findings, $description, $provider);

			mysqli_stmt_execute($stmt);
			$mr_id = mysqli_insert_id($conn);

			$user_activity = "Add Medical Record";
			$details = "Added medical record for pet name '$petname', id '$patientno' ";
			include '../log.php';

			echo "<script language='javascript'>";
			echo 'alert("' . $petname . ' medical record is successfully added!");';
			echo 'window.location.replace("../../medical_records_information.php?medical_records=' . $mr_id . '");';
			echo "</script>";
			exit();
		} else {
			echo "<script language='javascript'>";
			echo 'alert("Something went wrong, Please try again later");';
			// echo 'window.location.replace("../../dashboard.php?addpatient=failed");';
			echo 'window.location.replace("../../pet_information.php?id=' . $patientno . '");';
			echo "</script>";
			exit();
		}
	} else {
		$sql = "INSERT INTO medical_records(pet_id, findings,provider, date_created) VALUES (?,?,?,NOW());";
		// $sql = "INSERT INTO owner(fname, lname, bday, gender, city, province, contactno, email) VALUES (?,?,?,?,?,?,?,?);";
		$stmt = mysqli_stmt_init($conn);

		if (mysqli_stmt_prepare($stmt, $sql)) {
			mysqli_stmt_bind_param($stmt, "sss", $patientno, $findings, $provider);

			mysqli_stmt_execute($stmt);
			$mr_id = mysqli_insert_id($conn);

			$user_activity = "Add Medical Record";
			$details = "Added medical record for pet name '$petname', id '$patientno' ";
			include '../log.php';

			echo "<script language='javascript'>";
			echo 'alert("' . $petname . ' medical record is successfully added!");';
			echo 'window.location.replace("../../medical_records_information.php?medical_records=' . $mr_id . '");';
			echo "</script>";
			exit();
		} else {
			echo "<script language='javascript'>";
			echo 'alert("Something went wrong, Please try again later");';
			// echo 'window.location.replace("../../dashboard.php?addpatient=failed");';
			echo 'window.location.replace("../../pet_information.php?id=' . $patientno . '");';
			echo "</script>";
			exit();
		}
	}
} else {
	// // $statusMsg = 'Please select a file to upload.';
	echo "<script language='javascript'>";
	echo 'alert("Something went wrong, Please try again later");';
	echo 'window.location.replace("../../pet_information.php?id=' . $patientno . '");';
	echo "</script>";
	exit();
}
