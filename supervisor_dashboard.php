<?php
include_once "header.php";
if(!isset($_SESSION['supervisor'])) header("Location: supervisor_login.php");
?>

<h1>Supervisor Dashboard</h1>
<div class="card-container">
<a href="take_reading.php" class="card">
<h3>Take Meter Reading</h3><p>Enter readings</p></a>
<a href="logout.php" class="card logout"><h3>Logout</h3><p>Exit panel</p></a>
</div>

<?php include_once "footer.php"; ?>
