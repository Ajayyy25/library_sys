<?php
include "./includes/connection.php";

if(isset($_POST['btn_register'])){
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $fname = $_POST['first_name'];
    $lname = $_POST['last_name'];
    $mname = $_POST['middle_name'];

    $sql = "INSERT INTO tbl_user (username, password, first_name, last_name, middle_name) 
            VALUES ('$user', '$pass', '$fname', '$lname', '$mname')";

    if($conn->query($sql) === TRUE){
        echo '<script>alert("Registration Successful!"); window.location.href="login.php";</script>';
    }
}
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow-sm" style="width: 500px;">
        <h3 class="text-center mb-4">Create Account</h3>
        <form method="POST">
            <div class="row mb-3">
                <div class="col"><input type="text" name="first_name" class="form-control" placeholder="First Name" required></div>
                <div class="col"><input type="text" name="last_name" class="form-control" placeholder="Last Name" required></div>
            </div>
            <div class="mb-3">
                <input type="text" name="middle_name" class="form-control" placeholder="Middle Name">
            </div>
            <div class="mb-3">
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <button type="submit" name="btn_register" class="btn btn-success w-100">Register</button>
            <p class="mt-3 text-center"><a href="login.php">Back to Login</a></p>
        </form>
    </div>
</div>