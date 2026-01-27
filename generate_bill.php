<?php
include_once "functions.php";
if(!isset($_SESSION['supervisor'])) header("Location: supervisor_login.php");

if($_SERVER['REQUEST_METHOD']!=='POST'){ die("Invalid Access"); }

$service=$_POST['service_number'];
$prev=$_POST['previous_reading'];
$curr=$_POST['current_reading'];

if(!is_numeric($prev)||!is_numeric($curr)||$curr<$prev){ $_SESSION['msg']="Invalid readings"; header("Location: take_reading.php"); exit(); }

$bill_data = calculateBill($prev,$curr);
$bill_number="BILL".rand(10000,99999);

mysqli_begin_transaction($conn);
try{
    $q1=mysqli_query($conn,"INSERT INTO meter_readings(service_number,previous_reading,current_reading,reading_date)
        VALUES('$service',$prev,$curr,CURDATE())");
    if(!$q1) throw new Exception("Meter insert failed");
    $meter_id=mysqli_insert_id($conn);
    $q2=mysqli_query($conn,"INSERT INTO bills(bill_number,service_number,meter_reading_id,basic_charge,rate,units,total,bill_date,due_date,due_date_fine,status)
        VALUES('$bill_number','$service',$meter_id,0,0,{$bill_data['units']},{$bill_data['total']},CURDATE(),DATE_ADD(CURDATE(),INTERVAL 15 DAY),DATE_ADD(CURDATE(),INTERVAL 25 DAY),'UNPAID')");
    if(!$q2) throw new Exception("Bill insert failed");
    mysqli_commit($conn);
    $_SESSION['msg']="Bill generated: $bill_number ₹{$bill_data['total']}";
    header("Location: take_reading.php"); exit();
}catch(Exception $e){
    mysqli_rollback($conn);
    $_SESSION['msg']="Error: ".$e->getMessage();
    header("Location: take_reading.php"); exit();
}
