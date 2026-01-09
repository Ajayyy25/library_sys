<?php
session_start();
include "./includes/connection.php";

if(isset($_POST['btn_login'])){
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Direct query - matching your tbl_user columns
    $sql = "SELECT * FROM tbl_user WHERE username = '$user' AND password = '$pass'";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        
        // Storing session data
        $_SESSION['user_id'] = $row['user_id'];
        
        // Combining first and last name for your sidebar display
        $_SESSION['user_full_name'] = $row['first_name'] . " " . $row['last_name'];
        
        // Redirecting to the book module inside index.php
        header("Location: index.php?page=book");
        exit(); 
    } else {
        echo '<script>alert("Invalid Username or Password!"); window.location.href="login.php";</script>';
    }
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow-sm" style="width: 400px;">
        <h3 class="text-center mb-4">Login</h3>
        <form method="POST">
            <div class="mb-3">
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <button type="submit" name="btn_login" class="btn btn-primary w-100">Login</button>
            <p class="mt-3 text-center">New here? <a href="register.php">Register</a></p>
        </form>
    </div>
</div>