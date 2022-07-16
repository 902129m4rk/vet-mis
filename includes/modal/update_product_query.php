<?php
require_once '../config.php';
session_start();
if (isset($_POST['update'])) {

	$id = filter_input(INPUT_POST, 'prodid');

	//Product
	$prodcategory = filter_input(INPUT_POST, 'prod_category');
	$name = ucfirst(filter_input(INPUT_POST, 'prod_name'));
	$species1 = filter_input(INPUT_POST, 'pet_species1');
	$species2 = filter_input(INPUT_POST, 'pet_species2');
	$quantity = filter_input(INPUT_POST, 'prod_quantity');
	$price = filter_input(INPUT_POST, 'prod_price');
	$description = ucfirst(filter_input(INPUT_POST, 'prod_desc'));
	$addstock = filter_input(INPUT_POST, 'add_stock');

	if (!empty($addstock)) {
		$newstock = $quantity + $addstock;
	} else {
		$newstock = $quantity;
	}

	$regexname = "/^[a-zA-Z0-9\d\s\.\-\/\(\)\&]+$/";

	if (empty($species2)) {
		if (preg_match($regexname, $name)) {
			$sql = " UPDATE `inventory`
			SET `product_category` = '$prodcategory',
			`product_name`= '$name',
			`species1` ='$species1',
			`quantity_on_hand`= '$newstock',
			`price` = '$price',
			`description` = '$description'
			WHERE `inventory_id` = '$id'";

			$stmt = mysqli_stmt_init($conn);
			if (mysqli_stmt_prepare($stmt, $sql)) {
				if (mysqli_stmt_execute($stmt)) {

					$user_activity = "Update Product";
					$details = "Update product name '$name', id '$id'";
					include '../log.php';

					echo "<script language='javascript'>";
					echo 'alert("' . $name . ' is successfully updated!");';
					echo 'window.location.replace("../../add_stock.php?updateproduct=success");';
					echo "</script>";
				}
			} else {
				echo "<script language='javascript'>";
				echo 'alert("Something went wrong, Please try again later");';
				echo 'window.location.replace("../../add_stock.php?updateproduct=failed");';
				echo "</script>";
			}
		} else {
			echo "<script language='javascript'>";
			echo 'alert("Please enter a valid product name");';
			echo 'window.location.replace("../../add_stock.php?updateproduct=failed");';
			echo "</script>";
		}
	} else {
		if (preg_match($regexname, $name)) {
			$sql2 = " UPDATE `inventory`
			SET `product_category` = '$prodcategory',
			`product_name`= '$name',
			`species1` ='$species1',
			`species2` = '$species2',
			`quantity_on_hand`= '$newstock',
			`price` = '$price',
			`description` = '$description'
			WHERE `inventory_id` = '$id'";

			$stmt2 = mysqli_stmt_init($conn);
			if (mysqli_stmt_prepare($stmt2, $sql2)) {
				if (mysqli_stmt_execute($stmt2)) {

					$user_activity = "Update Product";
					$details = "Update product name '$name', id '$id'";
					include '../log.php';

					echo "<script language='javascript'>";
					echo 'alert("' . $name . ' is successfully updated!");';
					echo 'window.location.replace("../../add_stock.php?updateproduct=success");';
					echo "</script>";
				}
			} else {
				echo "<script language='javascript'>";
				echo 'alert("Something went wrong, Please try again later");';
				echo 'window.location.replace("../../add_stock.php?updateproduct=failed");';
				echo "</script>";
			}
		} else {
			echo "<script language='javascript'>";
			echo 'alert("Please enter a valid product name");';
			echo 'window.location.replace("../../add_stock.php?updateproduct=failed");';
			echo "</script>";
		}
	}
}
