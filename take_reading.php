<?php
include_once "header.php";
if(!isset($_SESSION['supervisor'])) header("Location: supervisor_login.php");
?>

<h2>Meter Reading Entry</h2>
<form method="post" action="generate_bill.php">
<input type="text" name="service_number" placeholder="Service Number" required>
<input type="number" name="previous_reading" placeholder="Previous Reading" required>
<input type="number" name="current_reading" placeholder="Current Reading" required>
<button type="submit">Generate Bill</button>
</form>

<?php include_once "footer.php"; ?>
