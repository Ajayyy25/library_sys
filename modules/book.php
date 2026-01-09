<?php 
include "./includes/connection.php";

if(isset($_GET['delete_id'])){
    $id = $_GET['delete_id'];
    $sql = "DELETE FROM tbl_book WHERE book_id = '$id'";
    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Book deleted successfully!"); window.location.href="index.php?page=book";</script>';
    }
}

if(isset($_POST["btn_save"])){
    $book_title = $_POST['book_title'];
    $book_author = $_POST['book_author'];
    $book_category = $_POST['book_category'];
    $book_copies = $_POST['book_copies'];
    $book_available = $_POST['book_available'];

    $sql = "INSERT INTO tbl_book (title, author_id, category_id, total_copies, available_copies)
            VALUES ('$book_title','$book_author','$book_category','$book_copies','$book_available')";

    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Book added successfully!"); window.location.href="index.php?page=book";</script>';
    }
}

if(isset($_POST["btn_update"])){
    $id = $_POST['book_id'];
    $title = $_POST['book_title'];
    $author = $_POST['book_author'];
    $category = $_POST['book_category'];
    $total = $_POST['book_copies'];
    $avail = $_POST['book_available'];

    $sql = "UPDATE tbl_book SET title='$title', author_id='$author', category_id='$category', 
            total_copies='$total', available_copies='$avail' WHERE book_id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Book updated successfully!"); window.location.href="index.php?page=book";</script>';
    }
}

$sql = "SELECT tbl_book.*, tbl_author.name as author_name, tbl_category.category_name 
        FROM tbl_book 
        INNER JOIN tbl_author ON tbl_book.author_id = tbl_author.author_id 
        INNER JOIN tbl_category ON tbl_book.category_id = tbl_category.category_id
        ORDER BY tbl_book.book_id ASC";

$result = $conn->query($sql);
?>

<main class="content-wrapper">
    <div class="container-fluid">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark m-0">Book Management</h2>
                <p class="text-muted">View and manage your library's entire collection.</p>
            </div>
            <button class="btn btn-primary px-4 py-2 shadow-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#addBookModal">
                <i class="fa-solid fa-plus me-2"></i> Add New Book
            </button>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="py-3">Book ID</th>
                                <th class="py-3">Title</th>
                                <th class="py-3">Author</th>
                                <th class="py-3">Category</th>
                                <th class="py-3 text-center">Copies</th>
                                <th class="py-3 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $result->fetch_assoc()) :?>
                            <tr>
                                <td class="fw-bold text-muted"><?php echo $row['book_id']; ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 p-2 rounded me-3 text-primary">
                                            <i class="fa-solid fa-book"></i>
                                        </div>
                                        <span class="fw-semibold text-dark"><?php echo $row['title']; ?></span>
                                    </div>
                                </td>
                                <td><?php echo $row['author_name']; ?></td>
                                <td><span class="badge bg-secondary bg-opacity-10 text-secondary px-3"><?php echo $row['category_name']; ?></span></td>
                                <td class="text-center">
                                    <span class="fw-bold text-primary"><?php echo $row['available_copies']; ?></span> / 
                                    <span class="text-muted"><?php echo $row['total_copies']; ?></span>
                                </td>   
                                <td class="text-center">
                                    <button class="btn btn-light btn-sm border rounded-3 me-1" 
                                            style="width: 35px; height: 35px;"
                                            data-bs-toggle="modal" data-bs-target="#editBookModal<?php echo $row['book_id']; ?>">
                                        <i class="fa-solid fa-pen text-info"></i>
                                    </button>
                                    
                                    <a href="index.php?page=book&delete_id=<?php echo $row['book_id']; ?>" 
                                       class="btn btn-light btn-sm border rounded-3" 
                                       style="width: 35px; height: 35px; display: inline-flex; align-items: center; justify-content: center;"
                                       onclick="return confirm('Delete this book permanently?')">
                                        <i class="fa-solid fa-trash text-danger"></i>
                                    </a>
                                </td>
                            </tr>

                            <div class="modal fade" id="editBookModal<?php echo $row['book_id']; ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow-lg rounded-4">
                                        <div class="modal-header border-0 p-4 pb-0">
                                            <h5 class="modal-title fw-bold">Edit Book Details</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <form action="index.php?page=book" method="POST">
                                                <input type="hidden" name="book_id" value="<?php echo $row['book_id']; ?>">
                                                
                                                <div class="mb-3">
                                                    <label class="form-label small fw-bold text-muted text-uppercase">Book Title</label>
                                                    <input type="text" class="form-control bg-light border-0 py-3" name="book_title" value="<?php echo $row['title']; ?>" required>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label small fw-bold text-muted text-uppercase">Author</label>
                                                        <select class="form-select bg-light border-0" name="book_author" required>
                                                            <?php 
                                                            $authors_edit = mysqli_query($conn, "SELECT * FROM tbl_author ORDER BY name ASC");
                                                            while ($a = mysqli_fetch_assoc($authors_edit)) {
                                                                $sel = ($a['author_id'] == $row['author_id']) ? "selected" : "";
                                                                echo "<option value='{$a['author_id']}' $sel>{$a['name']}</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label small fw-bold text-muted text-uppercase">Category</label>
                                                        <select class="form-select bg-light border-0" name="book_category" required>
                                                            <?php 
                                                            $category_edit = mysqli_query($conn, "SELECT * FROM tbl_category ORDER BY category_name ASC");
                                                            while ($c = mysqli_fetch_assoc($category_edit)) {
                                                                $sel = ($c['category_id'] == $row['category_id']) ? "selected" : "";
                                                                echo "<option value='{$c['category_id']}' $sel>{$c['category_name']}</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label small fw-bold text-muted text-uppercase">Total Copies</label>
                                                        <input type="number" class="form-control bg-light border-0" name="book_copies" value="<?php echo $row['total_copies']; ?>" required>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label small fw-bold text-muted text-uppercase">Available</label>
                                                        <input type="number" class="form-control bg-light border-0" name="book_available" value="<?php echo $row['available_copies']; ?>" required>
                                                    </div>
                                                </div>

                                                <div class="d-grid mt-3">
                                                    <button type="submit" name="btn_update" class="btn btn-primary btn-lg rounded-pill fw-bold">Update Book</button>
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

<div class="modal fade" id="addBookModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 p-4 pb-0">
                <h5 class="modal-title fw-bold">Register New Book</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form action="index.php?page=book" method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Book Title</label>
                        <input type="text" class="form-control form-control-lg bg-light border-0" name="book_title" placeholder="Enter title..." required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase">Author</label>
                            <select class="form-select bg-light border-0" name="book_author" required>
                                <option selected disabled value="">Select Author</option>
                                <?php 
                                $authors_add = mysqli_query($conn, "SELECT * FROM tbl_author ORDER BY name ASC");
                                while($a = mysqli_fetch_assoc($authors_add)) {
                                    echo "<option value='{$a['author_id']}'>{$a['name']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase">Category</label>
                            <select class="form-select bg-light border-0" name="book_category" required>
                                <option selected disabled value="">Select Category</option>
                                <?php 
                                $category_add = mysqli_query($conn, "SELECT * FROM tbl_category ORDER BY category_name ASC");
                                while($c = mysqli_fetch_assoc($category_add)) {
                                    echo "<option value='{$c['category_id']}'>{$c['category_name']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase">Total Copies</label>
                            <input type="number" class="form-control bg-light border-0" name="book_copies" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase">Available</label>
                            <input type="number" class="form-control bg-light border-0" name="book_available" required>
                        </div>
                    </div>
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold" name="btn_save">Save Details</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php 

$conn->close(); 
?>