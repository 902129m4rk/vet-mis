<?php
require_once 'includes/config.php';
session_start();

if (isset($_POST['payment'])) {

  $billtotal =  $_POST['total'];
  $cashpay = $_POST['cash'];

  $provider = $_SESSION["empid"];
  $customerid = $_POST['customer'];
  $patient = $_POST['select_patient'];


  if ($cashpay >= $billtotal) {

    if (empty($_POST['select_patient'])) {

      $customer = $_POST['customer'];

      if (($_POST['customer']) <= 9) {
        $clientname = "PTOWNR-000";
        $clientname .= $_POST['customer'];
      } elseif (($_POST['customer']) <= 99) {
        $clientname = "PTOWNR-00";
        $clientname .= $_POST['customer'];
      } elseif (($_POST['customer']) <= 999) {
        $clientname = "PTOWNR-0";
        $clientname .= $_POST['customer'];
      } else {
        $clientname = "PTOWNR-";
        $clientname .= $_POST['customer'];
      }

      $patient = $_POST['select_patient'];
      $total = $_POST['total'];
      $cash = $_POST['cash'];

      $invoicetype = $_POST['invoice_type'];
      $status = "Paid";

      date_default_timezone_set('Asia/Manila');
      $today = date("dmyhis");
      $today .= $patient;

      $change = ($_POST['cash']) - ($_POST['total']);
      $countID = count($_POST['name']);

      $prod = $_POST['name'];
      $quanti = $_POST['quanti'];

      if ($_GET['action'] == 'add') {

        for ($i = 1; $i <= $countID; $i++) {

          $query = "INSERT INTO `transaction_details`
              (`invoice_type`, `transaction_details_no`, `products`, `quantity`, `price`)
              VALUES ('" . $_POST['invoice_type'][$i - 1] . "', '{$today}', '" . $_POST['name'][$i - 1] . "', '" . $_POST['quantity'][$i - 1] . "', '" . $_POST['price'][$i - 1] . "')";

          mysqli_query($conn, $query) or die(mysqli_error($conn));
          $tdid = mysqli_insert_id($conn);
        }
        $query111 = "INSERT INTO `transaction`
                (`pet_owner_id`,`num_of_items`, `grand_total`, `cash`,`cash_change` , `transaction_details_no`,  `status`, `provider`, `transaction_date`, `payment_date`)
                VALUES ('{$customer}','{$countID}','{$total}','{$cash}','{$change}', '{$today}', '{$status}', $provider , NOW(), NOW())";
        mysqli_query($conn, $query111) or die(mysqli_error($conn));
        $transid = mysqli_insert_id($conn);


        foreach (array_combine($prod, $quanti) as $prodname => $qunatity) {
          $sqlinventory = "SELECT * from inventory WHERE product_name ='$prodname'";
          $queryinventory = mysqli_query($conn, $sqlinventory);

          while ($fetch = mysqli_fetch_assoc($queryinventory)) {
            $fetchqty = $fetch['quantity_on_hand'];
            $qty =  $fetchqty - $qunatity;
            $sql = "UPDATE inventory SET quantity_on_hand = '$qty' WHERE product_name = '$prodname'";
            mysqli_query($conn, $sql) or die(mysqli_error($conn));
          }
        }
        $user_activity = "Process Transaction";
        $details = "Transaction id '$transid' was successfully paid";
        include 'includes/log.php';

        unset($_SESSION['pointofsale']);
        echo "<script language='javascript'>";
        echo 'alert("Transaction for ' . $clientname . ' was successfully paid");';
        echo 'window.location.replace("transaction_information.php?id=' . $transid . '");';
        echo "</script>";
      } else {

        echo "<script language='javascript'>";
        echo 'alert("Something went wrong,Please try again later");';
        echo 'window.location.replace("add_transaction.php?addtransaction=failed");';
        echo "</script>";
      }
    } else {
      $customer = $_POST['customer'];

      if (($_POST['customer']) <= 9) {
        $clientname = "PTOWNR-000";
        $clientname .= $_POST['customer'];
      } elseif (($_POST['customer']) <= 99) {
        $clientname = "PTOWNR-00";
        $clientname .= $_POST['customer'];
      } elseif (($_POST['customer']) <= 999) {
        $clientname = "PTOWNR-0";
        $clientname .= $_POST['customer'];
      } else {
        $clientname = "PTOWNR-";
        $clientname .= $_POST['customer'];
      }

      $patient = $_POST['select_patient'];
      $total = $_POST['total'];
      $cash = $_POST['cash'];
      $invoicetype = $_POST['invoice_type'];
      $status = "Paid";

      date_default_timezone_set('Asia/Manila');
      $today = date("dmyhis");
      $today .= $patient;

      $change = (($_POST['cash']) - ($_POST['total']));
      $countID = count($_POST['name']);

      $prod = $_POST['name'];
      $quanti = $_POST['quanti'];

      if ($_GET['action'] == 'add') {

        for ($i = 1; $i <= $countID; $i++) {
          $query = "INSERT INTO `transaction_details`
                (`invoice_type`, `transaction_details_no`, `products`, `quantity`, `price`)
                VALUES ('" . $_POST['invoice_type'][$i - 1] . "', '{$today}', '" . $_POST['name'][$i - 1] . "', '" . $_POST['quantity'][$i - 1] . "', '" . $_POST['price'][$i - 1] . "')";
          mysqli_query($conn, $query) or die(mysqli_error($conn));
        }
        $query111 = "INSERT INTO `transaction`
                  (`pet_owner_id`,`pet_id`, `num_of_items`, `grand_total`, `cash`,`cash_change` , `transaction_details_no`,  `status`,`provider`, `transaction_date`, `payment_date`)
                  VALUES ('{$customer}','{$patient}','{$countID}','{$total}','{$cash}','{$change}', '{$today}', '{$status}', $provider, NOW(), NOW())";
        mysqli_query($conn, $query111) or die(mysqli_error($conn));

        $transid = mysqli_insert_id($conn);
        foreach (array_combine($prod, $quanti) as $prodname => $qunatity) {
          $sqlinventory = "SELECT * from inventory WHERE product_name ='$prodname'";
          $queryinventory = mysqli_query($conn, $sqlinventory);

          while ($fetch = mysqli_fetch_assoc($queryinventory)) {
            $fetchqty = $fetch['quantity_on_hand'];
            $qty =  $fetchqty - $qunatity;
            $sql = "UPDATE inventory SET quantity_on_hand = '$qty' WHERE product_name = '$prodname'";
            mysqli_query($conn, $sql) or die(mysqli_error($conn));
          }
        }

        $user_activity = "Process Transaction";
        $details = "Transaction id '$transid' was successfully paid";
        include 'includes/log.php';

        unset($_SESSION['pointofsale']);
        echo "<script language='javascript'>";
        echo 'alert("Transaction for ' . $clientname . ' was successfully paid");';
        // echo 'window.location.replace("dashboard.php?addtransaction=success");';
        echo 'window.location.replace("transaction_information.php?id=' . $transid . '");';
        echo "</script>";
      } else {
        echo "<script language='javascript'>";
        echo 'alert("Something went wrong,Please try again later");';
        echo 'window.location.replace("add_transaction.php?addtransaction=failed");';
        echo "</script>";
      }
    }
  } else {

    // unset($_SESSION['pointofsale']);
    echo "<script language='javascript'>";
    echo 'alert("You have insufficient cash, Please try again");';
    echo 'window.location.replace("add_transaction.php");';
    echo "</script>";
  }
} elseif (isset($_POST['save'])) {

  $customer = $_POST['customer'];
  $provider = $_SESSION["empid"];
  if (($_POST['customer']) <= 9) {
    $clientname = "PTOWNR-000";
    $clientname .= $_POST['customer'];
  } elseif (($_POST['customer']) <= 99) {
    $clientname = "PTOWNR-00";
    $clientname .= $_POST['customer'];
  } elseif (($_POST['customer']) <= 999) {
    $clientname = "PTOWNR-0";
    $clientname .= $_POST['customer'];
  } else {
    $clientname = "PTOWNR-";
    $clientname .= $_POST['customer'];
  }


  $patient = $_POST['select_patient'];
  $total = $_POST['total'];
  $cash = $_POST['cash'];
  $invoicetype = $_POST['invoice_type'];
  $status = "Unpaid";

  date_default_timezone_set('Asia/Manila');
  $today = date("dmyhis");
  $today .= $patient;

  $countID = count($_POST['name']);

  $prod = $_POST['name'];
  $quanti = $_POST['quanti'];

  if (empty($_POST['select_patient'])) {
    if ($_GET['action'] == 'add') {
      for ($i = 1; $i <= $countID; $i++) {
        $query = "INSERT INTO `transaction_details`
            (`invoice_type`, `transaction_details_no`, `products`, `quantity`, `price`)
            VALUES ('" . $_POST['invoice_type'][$i - 1] . "', '{$today}', '" . $_POST['name'][$i - 1] . "', '" . $_POST['quantity'][$i - 1] . "', '" . $_POST['price'][$i - 1] . "')";

        mysqli_query($conn, $query) or die(mysqli_error($conn));
      }
      $query111 = "INSERT INTO `transaction`
              (`pet_owner_id`, `num_of_items`, `grand_total` , `transaction_details_no`,  `status`, `provider`,`transaction_date`)
              VALUES ('{$customer}','{$countID}','{$total}', '{$today}', '{$status}', $provider, NOW())";
      mysqli_query($conn, $query111) or die(mysqli_error($conn));
      $transid = mysqli_insert_id($conn);


      foreach (array_combine($prod, $quanti) as $prodname => $qunatity) {
        $sqlinventory = "SELECT * from inventory WHERE product_name ='$prodname'";
        $queryinventory = mysqli_query($conn, $sqlinventory);

        while ($fetch = mysqli_fetch_assoc($queryinventory)) {
          $fetchqty = $fetch['quantity_on_hand'];
          $qty =  $fetchqty - $qunatity;
          $sql = "UPDATE inventory SET quantity_on_hand = '$qty' WHERE product_name = '$prodname'";
          mysqli_query($conn, $sql) or die(mysqli_error($conn));
        }
      }
      $user_activity = "Saved Transaction";
      $details = "Transaction id '$transid' was successfully saved";
      include 'includes/log.php';

      unset($_SESSION['pointofsale']);
      echo "<script language='javascript'>";
      echo 'alert("Transaction for ' . $clientname . ' was successfully saved");';
      echo 'window.location.replace(transaction_list.php?addtransaction=success");';
      echo "</script>";
    } else {

      echo "<script language='javascript'>";
      echo 'alert("Something went wrong,Please try again later");';
      echo 'window.location.replace("add_transaction.php?addtransaction=failed");';
      echo "</script>";
    }
  } else {

    if ($_GET['action'] == 'add') {

      for ($i = 1; $i <= $countID; $i++) {
        $query = "INSERT INTO `transaction_details`
            (`invoice_type`, `transaction_details_no`, `products`, `quantity`, `price`)
            VALUES ('" . $_POST['invoice_type'][$i - 1] . "', '{$today}', '" . $_POST['name'][$i - 1] . "', '" . $_POST['quantity'][$i - 1] . "', '" . $_POST['price'][$i - 1] . "')";
        mysqli_query($conn, $query) or die(mysqli_error($conn));
      }
      $query111 = "INSERT INTO `transaction`
              (`pet_owner_id`,`pet_id`, `num_of_items`, `grand_total` , `transaction_details_no`, `status`,`provider`, `transaction_date`)
              VALUES ('{$customer}','{$patient}','{$countID}','{$total}', '{$today}', '{$status}', $provider, NOW())";
      mysqli_query($conn, $query111) or die(mysqli_error($conn));
      $transid = mysqli_insert_id($conn);


      foreach (array_combine($prod, $quanti) as $prodname => $qunatity) {
        $sqlinventory = "SELECT * from inventory WHERE product_name ='$prodname'";
        $queryinventory = mysqli_query($conn, $sqlinventory);

        while ($fetch = mysqli_fetch_assoc($queryinventory)) {
          $fetchqty = $fetch['quantity_on_hand'];
          $qty =  $fetchqty - $qunatity;
          $sql = "UPDATE inventory SET quantity_on_hand = '$qty' WHERE product_name = '$prodname'";
          mysqli_query($conn, $sql) or die(mysqli_error($conn));
        }
      }
      $user_activity = "Saved Transaction";
      $details = "Transaction id '$transid' was successfully saved";
      include 'includes/log.php';

      unset($_SESSION['pointofsale']);
      echo "<script language='javascript'>";
      echo 'alert("Transaction for ' . $clientname . ' was successfully saved");';
      echo 'window.location.replace("transaction_list.php?addtransaction=success");';
      echo "</script>";
    } else {
      echo "<script language='javascript'>";
      echo 'alert("Something went wrong,Please try again later");';
      echo 'window.location.replace("add_transaction.php?addtransaction=failed");';
      echo "</script>";
    }
  }
}
