<?php
include "./includes/connection.php";

// Triple Join to get names and titles via the borrow_id bridge
$sql = "SELECT r.return_id, r.return_date, r.borrow_id, s.first_name, s.last_name, b.title 
        FROM tbl_return r
        INNER JOIN tbl_record rec ON r.borrow_id = rec.borrow_id
        INNER JOIN tbl_student s ON rec.student_id = s.student_id
        INNER JOIN tbl_book b ON rec.book_id = b.book_id
        ORDER BY r.return_date DESC";

$result = $conn->query($sql);
?>

<main class="content-wrapper">
    <div class="container-fluid">
        <h2 class="fw-bold text-dark mb-4">Returned History</h2>
        
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Return ID</th>
                                <th>Student</th>
                                <th>Book Title</th>
                                <th>Date Returned</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $result->fetch_assoc()) : ?>
                            <tr>
                                <td class="fw-bold"><?php echo $row['return_id']; ?></td>
                                <td><?php echo $row['first_name'] . " " . $row['last_name']; ?></td>
                                <td><?php echo $row['title']; ?></td>
                                <td><span class="text-success fw-bold"><?php echo date('M d, Y', strtotime($row['return_date'])); ?></span></td>
                                <td class="text-center">
                                    <span class="badge bg-success bg-opacity-10 text-success px-3 rounded-pill">Completed</span>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
<?php $conn->close(); ?>