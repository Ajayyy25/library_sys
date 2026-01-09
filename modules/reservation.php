<?php 
include "./includes/connection.php";


 // LOGIC 1: DELETE RESERVATION

if(isset($_GET['delete_id'])){
    $id = $_GET['delete_id'];
    $sql = "DELETE FROM tbl_reservation WHERE reservation_id = '$id'";
    
    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Reservation removed!"); window.location.href="index.php?page=reservation";</script>';
    }
}


 // LOGIC 2: CREATE RESERVATION (INSERT)

if(isset($_POST["btn_reserve"])){
    $student_id = $_POST['student_id'];
    $book_id = $_POST['book_id'];
    $res_date = $_POST['reservation_date'];
    $status = $_POST['status'];

    $sql = "INSERT INTO tbl_reservation (student_id, book_id, reservation_date, status)
            VALUES ('$student_id', '$book_id', '$res_date', '$status')";

    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Reservation saved!"); window.location.href="index.php?page=reservation";</script>';
    }
}


 // LOGIC 3: UPDATE RESERVATION

if(isset($_POST["btn_update_res"])){
    $id = $_POST['reservation_id'];
    $student_id = $_POST['student_id'];
    $book_id = $_POST['book_id'];
    $res_date = $_POST['reservation_date'];
    $status = $_POST['status'];

    $sql = "UPDATE tbl_reservation SET 
            student_id='$student_id', 
            book_id='$book_id', 
            reservation_date='$res_date', 
            status='$status' 
            WHERE reservation_id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Reservation updated successfully!"); window.location.href="index.php?page=reservation";</script>';
    }
}


 // FETCH DATA WITH INNER JOIN
// This joins 3 tables: Reservation, Student, and Book
$sql = "SELECT tbl_reservation.*, tbl_student.first_name, tbl_student.last_name, tbl_book.title 
        FROM tbl_reservation 
        INNER JOIN tbl_student ON tbl_reservation.student_id = tbl_student.student_id
        INNER JOIN tbl_book ON tbl_reservation.book_id = tbl_book.book_id
        ORDER BY tbl_reservation.reservation_date DESC";

$result = $conn->query($sql);
?>

<main class="content-wrapper">
    <div class="container-fluid">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark m-0">Reservation Registry & Records</h2>
                <p class="text-muted">Manage book requests and reservation history.</p>
            </div>
            <button class="btn btn-primary px-4 py-2 shadow-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#addReservationModal">
                <i class="fa-solid fa-calendar-plus me-2"></i> New Reservation
            </button>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="py-3">ID</th>
                                <th class="py-3">Student</th>
                                <th class="py-3">Book Title</th>
                                <th class="py-3">Date</th>
                                <th class="py-3 text-center">Status</th>
                                <th class="py-3 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td class="fw-bold"><?php echo $row['reservation_id']; ?></td>
                                <td><?php echo $row['first_name'] . " " . $row['last_name']; ?></td>
                                <td><i class="fa-solid fa-book me-2 text-muted"></i><?php echo $row['title']; ?></td>
                                <td><?php echo date('M d, Y', strtotime($row['reservation_date'])); ?></td>
                                <td class="text-center">
                                    <?php 
                                        $status = $row['status'];
                                        $badgeColor = "info"; // Default Blue
                                        if ($status == 'Done') $badgeColor = "success"; // Green
                                        elseif ($status == 'Cancelled') $badgeColor = "danger"; // Red
                                        elseif ($status == 'Reserved') $badgeColor = "warning"; // Orange
                                    ?>
                                    <span class="badge rounded-pill bg-<?php echo $badgeColor; ?> bg-opacity-10 text-<?php echo $badgeColor; ?> px-3 py-2">
                                        <i class="fa-solid fa-circle me-1" style="font-size: 8px;"></i>
                                        <?php echo $status; ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-light btn-sm border rounded-3 me-1" style="width: 35px; height: 35px;"
                                            data-bs-toggle="modal" data-bs-target="#editResModal<?php echo $row['reservation_id']; ?>">
                                        <i class="fa-solid fa-pen text-info"></i>
                                    </button>
                                    <a href="index.php?page=reservation&delete_id=<?php echo $row['reservation_id']; ?>" 
                                       class="btn btn-light btn-sm border rounded-3" style="width: 35px; height: 35px; display: inline-flex; align-items: center; justify-content: center;"
                                       onclick="return confirm('Delete this record?')">
                                        <i class="fa-solid fa-trash text-danger"></i>
                                    </a>
                                </td>
                            </tr>

                            <div class="modal fade" id="editResModal<?php echo $row['reservation_id']; ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow-lg rounded-4">
                                        <div class="modal-header border-0 p-4 pb-0">
                                            <h5 class="modal-title fw-bold">Edit Reservation</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <form action="index.php?page=reservation" method="POST">
                                                <input type="hidden" name="reservation_id" value="<?php echo $row['reservation_id']; ?>">
                                                
                                                <div class="mb-3">
                                                    <label class="form-label small fw-bold text-muted">Student</label>
                                                    <select class="form-select bg-light border-0 py-3" name="student_id" required>
                                                        <?php 
                                                        $st_edit = mysqli_query($conn, "SELECT student_id, first_name, last_name FROM tbl_student");
                                                        while($s = mysqli_fetch_assoc($st_edit)){
                                                            $sel = ($s['student_id'] == $row['student_id']) ? "selected" : "";
                                                            echo "<option value='{$s['student_id']}' $sel>{$s['first_name']} {$s['last_name']}</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label small fw-bold text-muted">Book</label>
                                                    <select class="form-select bg-light border-0 py-3" name="book_id" required>
                                                        <?php 
                                                        $bk_edit = mysqli_query($conn, "SELECT book_id, title FROM tbl_book");
                                                        while($b = mysqli_fetch_assoc($bk_edit)){
                                                            $sel = ($b['book_id'] == $row['book_id']) ? "selected" : "";
                                                            echo "<option value='{$b['book_id']}' $sel>{$b['title']}</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>

                                                <div class="row">
                                                    <div class="col-6 mb-3">
                                                        <label class="form-label small fw-bold text-muted">Date</label>
                                                        <input type="date" class="form-control bg-light border-0" name="reservation_date" value="<?php echo $row['reservation_date']; ?>" required>
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <label class="form-label small fw-bold text-muted">Status</label>
                                                        <select class="form-select bg-light border-0" name="status">
                                                            <option value="Reserved" <?php if($row['status']=='Reserved') echo 'selected'; ?>>Reserved</option>
                                                            <option value="Done" <?php if($row['status']=='Done') echo 'selected'; ?>>Done</option>
                                                            <option value="Cancelled" <?php if($row['status']=='Cancelled') echo 'selected'; ?>>Cancelled</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="d-grid mt-3">
                                                    <button type="submit" name="btn_update_res" class="btn btn-primary btn-lg rounded-pill fw-bold">Update Record</button>
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

<div class="modal fade" id="addReservationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 p-4 pb-0">
                <h5 class="modal-title fw-bold">Create New Reservation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form action="index.php?page=reservation" method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Select Student</label>
                        <select class="form-select bg-light border-0 py-3" name="student_id" required>
                            <option selected disabled value="">Choose student...</option>
                            <?php 
                            $students = mysqli_query($conn, "SELECT student_id, first_name, last_name FROM tbl_student");
                            while($s = mysqli_fetch_assoc($students)) echo "<option value='{$s['student_id']}'>{$s['first_name']} {$s['last_name']}</option>";
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Select Book</label>
                        <select class="form-select bg-light border-0 py-3" name="book_id" required>
                            <option selected disabled value="">Choose book...</option>
                            <?php 
                            $books = mysqli_query($conn, "SELECT book_id, title FROM tbl_book");
                            while($b = mysqli_fetch_assoc($books)) echo "<option value='{$b['book_id']}'>{$b['title']}</option>";
                            ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-muted">Date</label>
                            <input type="date" class="form-control bg-light border-0 py-3" name="reservation_date" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-muted">Initial Status</label>
                            <select class="form-select bg-light border-0 py-3" name="status">
                                <option value="Reserved" selected>Reserved</option>
                            </select>
                        </div>
                    </div>
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold" name="btn_reserve">Save Reservation</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $conn->close(); ?>