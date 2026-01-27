<?php
include_once "../header.php";
include_once "../functions.php";

if(!isset($_SESSION['user'])) header("Location: ../login/admin_login.php");

$service_number = $_SESSION['user'];
$bill = getLatestBill($service_number);
$pending_charges = $bill ? getPendingAmount($service_number,$bill['bill_number']) : 0;
$today = date('Y-m-d');
$payable_with_fine = $bill ? ($bill['total']+$pending_charges) : 0;
if($bill && $bill['status']=='UNPAID' && $today>$bill['due_date']) $payable_with_fine += FINE_AMOUNT;

$history_sql = "SELECT bill_number,bill_date,total,status FROM bills WHERE service_number='$service_number' ORDER BY bill_date DESC";
$history_res = mysqli_query($conn,$history_sql);
?>

<h1>User Dashboard</h1>

<?php if($bill): ?>
<div class="table-box">
<h2>Current Bill</h2>
<p><b>Bill No:</b> <?=$bill['bill_number']?></p>
<p><b>Units:</b> <?=$bill['units']?></p>
<p><b>Total:</b> ₹<?=$bill['total']?></p>
<p><b>Pending:</b> ₹<?=$pending_charges?></p>
<p><b>Payable Now:</b> ₹<?=$payable_with_fine?></p>
<p><b>Status:</b> <?=$bill['status']?></p>
<?php if($bill['status']=='UNPAID'): ?>
<form method="post" action="pay_bill.php">
<input type="hidden" name="bill_number" value="<?=$bill['bill_number']?>">
<button type="submit">Pay Bill</button>
</form>
<?php endif; ?>
</div>
<?php else: ?>
<p>No bills generated yet.</p>
<?php endif; ?>

<div class="table-box">
<h2>Past Bills</h2>
<table>
<tr><th>Bill No</th><th>Date</th><th>Amount</th><th>Status</th></tr>
<?php while($h=mysqli_fetch_assoc($history_res)): ?>
<tr>
<td><?=$h['bill_number']?></td>
<td><?=$h['bill_date']?></td>
<td>₹<?=$h['total']?></td>
<td><?=$h['status']?></td>
</tr>
<?php endwhile; ?>
</table>
</div>

<?php include_once "../footer.php"; ?>
