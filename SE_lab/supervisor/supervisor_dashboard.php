
<?php
session_start();
if(!isset($_SESSION['supervisor'])) header("Location: ../authentication/login.html");
?>
<!DOCTYPE html>
<html>
<head>
<title>Supervisor Dashboard</title>
<link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="dashboard-container">

<h1>Supervisor Dashboard</h1>
<p class="welcome">Welcome, Supervisor</p>

<div class="card-container">

    <a href="../modules/take_reading.php" class="card">
        <h3>Take Meter Reading</h3>
        <p>Enter previous & current readings</p>
    </a>
    
    <a href="../authentication/logout.php" class="card logout">
        <h3>Logout</h3>
        <p>Exit supervisor panel</p>
    </a>

</div>

</div>

</body>
</html>
