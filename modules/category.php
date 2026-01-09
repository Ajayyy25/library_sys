<?php 
include "./includes/connection.php";

if(isset($_GET['delete_id'])){
    $id = $_GET['delete_id'];
    $sql = "DELETE FROM tbl_category WHERE category_id = '$id'";
    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Category deleted successfully"); window.location.href="index.php?page=category";</script>';
    }
}

if(isset($_POST["btn_update"])){
    $id = $_POST['category_id'];
    $name = $_POST['category_name'];
    $sql = "UPDATE tbl_category SET category_name = '$name' WHERE category_id = '$id'";
    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Category updated successfully"); window.location.href="index.php?page=category";</script>';
    }
}

if(isset($_POST["btn_save"])){
    $book_category = $_POST['book_category'];
    $sql = "INSERT INTO tbl_category (category_name) VALUES ('$book_category')";
    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Book category is successfully added");</script>';
    }
}

$sql = "SELECT * FROM tbl_category ORDER BY category_id ASC";
$result = $conn->query($sql);
?>

<main class="content-wrapper">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark m-0">Book Categories</h2>
                <p class="text-muted">Organize your library collection by genres and topics.</p>
            </div>
            <button class="btn btn-primary px-4 py-2 shadow-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                <i class="fa-solid fa-plus me-2"></i> Add New Category
            </button>
        </div>

        <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 p-4 pb-0">
                <h5 class="modal-title fw-bold" id="addCategoryModalLabel">Create New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="index.php?page=category" method="POST">
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted text-uppercase tracking-wider">Category Name</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-tag text-muted"></i></span>
                            <input type="text" class="form-control form-control-lg bg-light border-0" 
                                   placeholder="e.g., Science Fiction, History" name="book_category" required>
                        </div>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow-sm py-3 fw-bold" name="btn_save">
                            Save Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="py-3" style="width: 150px;">Category ID</th>
                                <th class="py-3">Category Name</th>
                                <th class="py-3 text-center" style="width: 200px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $result->fetch_assoc()) :?>
                            <tr>
                                <td class="fw-bold"><?php echo $row['category_id'];?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-warning bg-opacity-10 p-2 rounded me-3 text-warning">
                                            <i class="fa-solid fa-tags"></i>
                                        </div>
                                        <span class="fw-semibold"><?php echo $row['category_name']; ?></span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-light border rounded-3 me-1" 
                                            style="width: 35px; height: 35px;"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editModal<?php echo $row['category_id']; ?>">
                                        <i class="fa-solid fa-pen text-info"></i>
                                    </button>
                                    
                                    <a href="index.php?page=category&delete_id=<?php echo $row['category_id']; ?>" 
                                       class="btn btn-sm btn-light border rounded-3" 
                                       style="width: 35px; height: 35px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none;"
                                       onclick="return confirm('Are you sure you want to delete this category?')">
                                        <i class="fa-solid fa-trash text-danger"></i>
                                    </a>
                                </td>
                            </tr>

                            <div class="modal fade" id="editModal<?php echo $row['category_id']; ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow-lg rounded-4">
                                        <div class="modal-header border-0 p-4 pb-0">
                                            <h5 class="modal-title fw-bold">Edit Category</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <form action="index.php?page=category" method="POST">
                                                <input type="hidden" name="category_id" value="<?php echo $row['category_id']; ?>">
                                                <div class="mb-4">
                                                    <label class="form-label small fw-bold text-muted text-uppercase">Update Name</label>
                                                    <input type="text" class="form-control bg-light border-0 py-3" 
                                                           name="category_name" value="<?php echo $row['category_name']; ?>" required>
                                                </div>
                                                <div class="d-grid">
                                                    <button type="submit" name="btn_update" class="btn btn-primary btn-lg rounded-pill fw-bold">Update Category</button>
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

<?php 

$conn->close(); 
?>