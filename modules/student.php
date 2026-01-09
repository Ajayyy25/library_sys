<?php 
include "./includes/connection.php";

// DELETE STUDENT
if(isset($_GET['delete_id'])){
    $id = $_GET['delete_id'];
    $sql = "DELETE FROM tbl_student WHERE student_id = '$id'";
    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Student removed!"); window.location.href="index.php?page=student";</script>';
    }
}

// UPDATE STUDENT
if(isset($_POST["btn_update"])){
    $id = $_POST['student_id'];
    $fname = $_POST['first_name'];
    $mname = $_POST['middle_name'];
    $lname = $_POST['last_name'];
    $contact = $_POST['contact_number'];
    
    $sql = "UPDATE tbl_student SET first_name='$fname', middle_name='$mname', last_name='$lname', contact_number='$contact' WHERE student_id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Student updated!"); window.location.href="index.php?page=student";</script>';
    }
}

// SAVE NEW STUDENT
if(isset($_POST["btn_save"])){
    $fname = $_POST['first_name'];
    $mname = $_POST['middle_name'];
    $lname = $_POST['last_name'];
    $contact = $_POST['contact_number'];

    $sql = "INSERT INTO tbl_student (first_name, middle_name, last_name, contact_number) VALUES ('$fname', '$mname', '$lname', '$contact')";
    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Student successfully added!"); window.location.href="index.php?page=student";</script>';
    }
}

$result = $conn->query("SELECT * FROM tbl_student ORDER BY student_id");
?>

<main class="content-wrapper">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark m-0">Registered Student</h2> 
            </div>
            <button class="btn btn-primary px-4 py-2 shadow-sm rounded-pill"
                    data-bs-toggle="modal" data-bs-target="#addStudentModal">
                <i class="fa-solid fa-user-plus me-2"></i> Add New Student
            </button>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="py-3">ID</th>
                                <th class="py-3">First Name</th>
                                <th class="py-3">Middle Name</th>
                                <th class="py-3">Last Name</th>
                                <th class="py-3">Contact</th>
                                <th class="py-3 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $result->fetch_assoc()) : ?>
                            <tr>
                                <td class="text-muted fw-bold"><?php echo $row['student_id']; ?></td>
                                <td class="fw-semibold text-dark"><?php echo $row['first_name']; ?></td>
                                <td class="text-muted"><?php echo $row['middle_name']; ?></td>
                                <td class="fw-semibold text-dark"><?php echo $row['last_name']; ?></td>
                                <td><?php echo $row['contact_number']; ?></td>
                                <td class="text-center">
                                    <button class="btn btn-light btn-sm border rounded-3 me-1" 
                                            style="width: 35px; height: 35px;"
                                            data-bs-toggle="modal" data-bs-target="#editStudentModal<?php echo $row['student_id']; ?>">
                                        <i class="fa-solid fa-pen text-info"></i>
                                    </button>
                                    <a href="index.php?page=student&delete_id=<?php echo $row['student_id']; ?>" 
                                       class="btn btn-light btn-sm border rounded-3" 
                                       style="width: 35px; height: 35px; display: inline-flex; align-items: center; justify-content: center;"
                                       onclick="return confirm('Delete this student profile?')">
                                        <i class="fa-solid fa-trash text-danger"></i>
                                    </a>
                                </td>
                            </tr>

                            <div class="modal fade" id="editStudentModal<?php echo $row['student_id']; ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow-lg" style="border-radius: 25px;">
                                        <div class="modal-header border-0 p-4 pb-0">
                                            <h5 class="modal-title fw-bold">Edit Student Profile</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <form action="index.php?page=student" method="POST">
                                                <input type="hidden" name="student_id" value="<?php echo $row['student_id']; ?>">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label small fw-bold text-muted">First Name</label>
                                                        <input type="text" class="form-control bg-light border-0 py-3 rounded-3" name="first_name" value="<?php echo $row['first_name']; ?>" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label small fw-bold text-muted">Middle Name</label>
                                                        <input type="text" class="form-control bg-light border-0 py-3 rounded-3" name="middle_name" value="<?php echo $row['middle_name']; ?>">
                                                    </div>
                                                    <div class="col-12">
                                                        <label class="form-label small fw-bold text-muted">Last Name</label>
                                                        <input type="text" class="form-control bg-light border-0 py-3 rounded-3" name="last_name" value="<?php echo $row['last_name']; ?>" required>
                                                    </div>
                                                    <div class="col-12 mb-3">
                                                        <label class="form-label small fw-bold text-muted">Contact Number</label>
                                                        <input type="text" class="form-control bg-light border-0 py-3 rounded-3" name="contact" value="<?php echo $row['contact_number']; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="d-grid mt-2">
                                                    <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold" name="btn_update">Update Profile</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<div class="modal fade" id="addStudentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 25px;">
            <div class="modal-header border-0 p-4 pb-0">
                <h5 class="modal-title fw-bold">Register New Member</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form action="index.php?page=student" method="POST">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase">First Name</label>
                            <input type="text" class="form-control bg-light border-0 py-3 rounded-3" name="first_name" placeholder="John" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase">Middle Name</label>
                            <input type="text" class="form-control bg-light border-0 py-3 rounded-3" name="middle_name" placeholder="Quincy">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold text-muted text-uppercase">Last Name</label>
                            <input type="text" class="form-control bg-light border-0 py-3 rounded-3" name="last_name" placeholder="Doe" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase">Contact Number</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="fa-solid fa-phone text-muted"></i></span>
                                <input type="text" class="form-control bg-light border-0 py-3 rounded-end-3" name="contact_number" placeholder="09XX-XXX-XXXX" required>
                            </div>
                        </div>
                    </div>
                    <div class="d-grid mt-2">
                        <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow-sm py-3 fw-bold" name="btn_save">Confirm Registration</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php 

$conn->close(); 
?>