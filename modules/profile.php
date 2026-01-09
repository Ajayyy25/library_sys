<?php
// We don't need session_start() or connection here because index.php already has them
$user_id = $_SESSION['user_id'];

// 1. UPDATE LOGIC: If the user clicks "Update Profile"
if (isset($_POST['btn_update_profile'])) {
    $fname = $_POST['first_name'];
    $lname = $_POST['last_name'];
    $mname = $_POST['middle_name'];
    $user  = $_POST['username'];
    $pass  = $_POST['password'];

    $sql = "UPDATE tbl_user SET 
            first_name = '$fname', 
            last_name = '$lname', 
            middle_name = '$mname', 
            username = '$user', 
            password = '$pass' 
            WHERE user_id = '$user_id'";

    if ($conn->query($sql) === TRUE) {
        // Update the session name so the sidebar refreshes immediately
        $_SESSION['user_full_name'] = $fname . " " . $lname;
        echo '<script>alert("Profile updated successfully!"); window.location.href="index.php?page=profile";</script>';
    }
}

// 2. FETCH LOGIC: Get the current data to fill the input boxes
$res = $conn->query("SELECT * FROM tbl_user WHERE user_id = '$user_id'");
$data = $res->fetch_assoc();
?>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h3 class="fw-bold text-dark"><i class="fa-solid fa-user-gear me-2 text-primary"></i> Edit Profile</h3>
                    <p class="text-muted">Keep your account information up to date.</p>
                </div>
                <div class="card-body p-4">
                    <form method="POST">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label small fw-bold text-muted text-uppercase">First Name</label>
                                <input type="text" name="first_name" class="form-control bg-light border-0 py-2" value="<?php echo $data['first_name']; ?>" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label small fw-bold text-muted text-uppercase">Middle Name</label>
                                <input type="text" name="middle_name" class="form-control bg-light border-0 py-2" value="<?php echo $data['middle_name']; ?>">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label small fw-bold text-muted text-uppercase">Last Name</label>
                                <input type="text" name="last_name" class="form-control bg-light border-0 py-2" value="<?php echo $data['last_name']; ?>" required>
                            </div>
                        </div>

                        <hr class="my-4 text-muted">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold text-muted text-uppercase">Username</label>
                                <input type="text" name="username" class="form-control bg-light border-0 py-2" value="<?php echo $data['username']; ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold text-muted text-uppercase">Password</label>
                                <input type="password" name="password" class="form-control bg-light border-0 py-2" value="<?php echo $data['password']; ?>" required>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" name="btn_update_profile" class="btn btn-primary px-5 py-2 rounded-pill shadow-sm fw-bold">
                                <i class="fa-solid fa-check me-2"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>