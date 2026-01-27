<?php
include_once "functions.php";
if(!isset($_SESSION['user'])) header("Location: admin_login.php");

if(!isset($_POST['bill_number'])) die("Invalid request");

$bill_number = $_POST['bill_number'];
$success = markBillPaid($bill_number);
$_SESSION['msg'] = $success ? "Bill marked PAID" : "Failed or already paid";
header("Location: user_dashboard.php");
exit();
