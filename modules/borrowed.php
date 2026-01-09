<?php 
include "./includes/connection.php";

// INSERT (Issue Book)
if(isset($_POST["btn_issue"])){
    $sid = $_POST['student_id'];
    $bid = $_POST['book_id'];
    $due = $_POST['due_date'];
    $today = date('Y-m-d');

    $sql = "INSERT INTO tbl_record (student_id, book_id, borrow_date, due_date, status) VALUES ('$sid', '$bid', '$today', '$due', 'Borrowed')";
    if ($conn->query($sql) === TRUE) {
        $conn->query("UPDATE tbl_book SET available_copies = available_copies - 1 WHERE book_id = '$bid'");
        echo '<script>alert("Book Issued!"); window.location.href="index.php?page=borrowed";</script>';
    }
}

// RETURN LOGIC (The Hand-off to tbl_return)
if (isset($_GET['return_id'])) {
    $rid = $_GET['return_id'];
    $today = date('Y-m-d');

    // Fetch data for the return table
    $data = $conn->query("SELECT student_id, book_id FROM tbl_record WHERE borrow_id = '$rid'")->fetch_assoc();
    $bid = $data['book_id'];

    // 1. Permanent entry in tbl_return
    $sql_ret = "INSERT INTO tbl_return (borrow_id, return_date) VALUES ('$rid', '$today')";
    
    if ($conn->query($sql_ret) === TRUE) {
        // 2. Update record status and return date
        $conn->query("UPDATE tbl_record SET status = 'Returned', return_date = '$today' WHERE borrow_id = '$rid'");
        // 3. Put book back in stock
        $conn->query("UPDATE tbl_book SET available_copies = available_copies + 1 WHERE book_id = '$bid'");

        echo '<script>alert("Book Returned successfully!"); window.location.href="index.php?page=borrowed";</script>';
    }
}

$result = $conn->query("SELECT tbl_record.*, tbl_student.first_name, tbl_student.last_name, tbl_book.title 
                        FROM tbl_record 
                        INNER JOIN tbl_student ON tbl_record.student_id = tbl_student.student_id 
                        INNER JOIN tbl_book ON tbl_record.book_id = tbl_book.book_id 
                        WHERE tbl_record.status = 'Borrowed'
                        ORDER BY tbl_record.borrow_id ASC");
?>

<main class="content-wrapper">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-dark m-0">Active Records</h2>
            <button class="btn btn-primary px-4 py-2 shadow-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#issueBookModal">
                <i class="fa-solid fa-hand-holding me-2"></i> Issue New Book
            </button>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Student Name</th>
                                <th>Book Title</th>
                                <th>Due Date</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($result->num_rows > 0): ?>
                                <?php while($row = $result->fetch_assoc()) : ?>
                                <tr>
                                    <td class="fw-bold"><?php echo $row['borrow_id']; ?></td>
                                    <td><?php echo $row['first_name'] . " " . $row['last_name']; ?></td>
                                    <td><?php echo $row['title']; ?></td>
                                    <td><span class="text-danger fw-bold"><?php echo date('M d, Y', strtotime($row['due_date'])); ?></span></td>
                                    <td class="text-center">
                                        <a href="index.php?page=borrowed&return_id=<?php echo $row['borrow_id']; ?>" 
                                           class="btn btn-sm btn-outline-success border-2 rounded-pill px-3"
                                           onclick="return confirm('Confirm book return?')">Return</a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="5" class="text-center text-muted py-4">No books are currently borrowed.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<div class="modal fade" id="issueBookModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 p-4 pb-0">
                <h5 class="modal-title fw-bold">Issue Book</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form action="index.php?page=borrowed" method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Student</label>
                        <select class="form-select bg-light border-0 py-3" name="student_id" required>
                            <option value="" disabled selected>Select Student</option>
                            <?php 
                            $students = $conn->query("SELECT student_id, first_name, last_name FROM tbl_student ORDER BY last_name ASC");
                            while($s = $students->fetch_assoc()) {
                                echo "<option value='{$s['student_id']}'>{$s['last_name']}, {$s['first_name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Book Title</label>
                        <select class="form-select bg-light border-0 py-3" name="book_id" required>
                            <option value="" disabled selected>Select Book</option>
                            <?php 
                            $books = $conn->query("SELECT book_id, title FROM tbl_book WHERE available_copies > 0 ORDER BY title ASC");
                            while($b = $books->fetch_assoc()) {
                                echo "<option value='{$b['book_id']}'>{$b['title']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Due Date</label>
                        <input type="date" class="form-control bg-light border-0 py-3" name="due_date" min="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold" name="btn_issue">Confirm Issuance</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $conn->close(); ?>