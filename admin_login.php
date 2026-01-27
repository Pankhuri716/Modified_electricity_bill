<?php
include_once "header.php";
include_once "db.php";

if(isset($_POST['login'])){
    $u = $_POST['username'];
    $p = md5($_POST['password']);
    $q = mysqli_query($conn,"SELECT * FROM admin WHERE username='$u' AND password='$p'");
    if(mysqli_num_rows($q)==1){
        $_SESSION['admin']=$u;
        header("Location: admin_dashboard.php");
        exit();
    } else { echo "<p style='color:red;'>Invalid login</p>"; }
}
?>

<h2>Admin Login</h2>
<form method="post">
<input name="username" placeholder="Username" required>
<input type="password" name="password" placeholder="Password" required>
<button name="login">Login</button>
</form>

<?php include_once "footer.php"; ?>
