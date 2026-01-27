<?php
include_once "header.php";
include_once "functions.php";
include_once "db.php";

if(isset($_POST['add'])){
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $pin = trim($_POST['pin']);
    $category = $_POST['category'];

    // Validation
    if(!preg_match("/^[A-Za-z ]+$/",$name)) { $_SESSION['msg']="Invalid name"; }
    elseif(!preg_match("/^[0-9]{10}$/",$phone)) { $_SESSION['msg']="Invalid phone"; }
    else {
        $service = generateServiceNumber();
        $insert = mysqli_query($conn,"INSERT INTO users(name,phone,address,pin,category,service_number)
            VALUES('$name','$phone','$address','$pin','$category','$service')");
        $_SESSION['msg'] = $insert ? "User added: $service" : "Failed to add user";
    }
    header("Location: add_user.php");
    exit();
}
?>

<h2>Add User</h2>
<form method="post">
<input type="text" name="name" placeholder="Name" required>
<input type="text" name="phone" placeholder="Phone" required>
<input type="text" name="address" placeholder="Address" required>
<input type="text" name="pin" placeholder="PIN" required>
<select name="category" required>
<option value="">--Select--</option>
<option value="household">Household</option>
<option value="commercial">Commercial</option>
<option value="industry">Industry</option>
</select>
<button name="add">Add</button>
</form>

<?php include_once "footer.php"; ?>
