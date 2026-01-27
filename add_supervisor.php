<?php
include_once "header.php";
include_once "db.php";

if(!isset($_SESSION['admin'])) header("Location: admin_login.php");

if(isset($_POST['add'])){
    $name = trim($_POST['name']);
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'],PASSWORD_DEFAULT);

    $check = mysqli_query($conn,"SELECT id FROM supervisors WHERE username='$username'");
    if(mysqli_num_rows($check)>0){ $_SESSION['msg']="Username exists"; }
    else {
        $insert = mysqli_query($conn,"INSERT INTO supervisors(name,username,password)
            VALUES('$name','$username','$password')");
        $_SESSION['msg']=$insert ? "Supervisor added: $username" : "Failed";
    }
    header("Location: add_supervisor.php"); exit();
}
?>

<h2>Add Supervisor</h2>
<form method="post">
<input type="text" name="name" placeholder="Supervisor Name" required>
<input type="text" name="username" placeholder="Username" required>
<input type="password" name="password" placeholder="Password" required>
<button name="add">Add Supervisor</button>
</form>

<?php include_once "footer.php"; ?>
