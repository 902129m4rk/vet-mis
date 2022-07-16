<?php
require_once '../config.php';

session_start();
if (isset($_POST['payment'])) {

    $billtotal =  $_POST['grandtotal'];

    $cashpay = $_POST['cash'];

    $transidmessage = $_POST['transidmessage'];
    $transid = $_POST['transid'];
    $cash = $_POST['cash'];
    $status = "Paid";

    date_default_timezone_set('Asia/Manila');
    $today = date("m-d-y- h:m:i a");

    $change = (($_POST['cash']) - ($_POST['grandtotal']));

    $sql = " UPDATE `transaction`
    SET `cash` = '$cash',
    `cash_change`= '$change',
    `payment_date`= NOW(),
    `status` = '$status'
    WHERE `trans_id` = '$transid'";
    if ($cashpay >= $billtotal) {



        $stmt = mysqli_stmt_init($conn);
        if (mysqli_stmt_prepare($stmt, $sql)) {

            if (mysqli_stmt_execute($stmt)) {
                $user_activity = "Process Transaction";
                $details = "Transaction id '$transid' was successfully paid";
                include '../log.php';

                echo "<script language='javascript'>";
                echo 'alert("' . $transidmessage . ' was successfully paid!");';
                // echo 'window.location.replace("../../dashboard.php?updatetransaction=success");';
                echo 'window.location.replace("../../transaction_information.php?id=' . $transid . '");';
                echo "</script>";
            }
        } else {
            echo "<script language='javascript'>";
            echo 'alert("Something went wrong,Please try again later");';
            echo 'window.location.replace("../../dashboard.php?updatetransaction=failed");';
            echo "</script>";
        }
    } else {
        // unset($_SESSION['pointofsale']);
        echo "<script language='javascript'>";
        echo 'alert("You have insufficient cash, Please try again");';
        echo 'window.location.replace("../../transaction_list.php");';
        echo "</script>";
    }
} else {
    echo "<script language='javascript'>";
    echo 'alert("Something went wrong,Please try again later");';
    echo 'window.location.replace("../../dashboard.php?updatetransaction=failed");';
    echo "</script>";
}
