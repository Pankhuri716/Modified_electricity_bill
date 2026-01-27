<?php
include_once "header.php";
if(!isset($_SESSION['admin'])) header("Location: admin_login.php");
?>

<h1>Admin Dashboard</h1>

<div class="card-container">
    <a href="add_user.php" class="card">
        <h3>Add User</h3><p>Register electricity consumer</p>
    </a>
    <a href="add_supervisor.php" class="card">
        <h3>Add Supervisor</h3><p>Create supervisor account</p>
    </a>
    <a href="view_all_bills.php" class="card">
        <h3>View All Bills</h3><p>View electricity bills of all users</p>
    </a>
    <a href="logout.php" class="card logout">
        <h3>Logout</h3><p>Exit admin panel</p>
    </a>
</div>

<?php include_once "footer.php"; ?>
