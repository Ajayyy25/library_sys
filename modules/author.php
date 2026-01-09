<?php 
include "./includes/connection.php";

if(isset($_GET['delete_id'])){
    $id = $_GET['delete_id'];
    $sql = "DELETE FROM tbl_author WHERE author_id = '$id'";
    
    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Author deleted successfully!"); window.location.href="index.php?page=author";</script>';
    }
}

if(isset($_POST["btn_save"])){
    $author_name = $_POST['author_name'];
    $author_bio = $_POST['author_bio']; 

    $sql = "INSERT INTO tbl_author (name, bio) VALUES ('$author_name','$author_bio')";

    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Author added successfully!"); window.location.href="index.php?page=author";</script>';
    }
}

if(isset($_POST["btn_update"])){
    $id = $_POST['author_id'];
    $name = $_POST['author_name'];
    $bio = $_POST['author_bio'];

    $sql = "UPDATE tbl_author SET name='$name', bio='$bio' WHERE author_id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Author updated successfully!"); window.location.href="index.php?page=author";</script>';
    }
}

$sql = "SELECT * FROM tbl_author";
$result = $conn->query($sql);
?>

<main class="content-wrapper">
    <div class="container-fluid">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark m-0">Author Directory</h2>
                <p class="text-muted">Manage the writers and creators in your library database.</p>
            </div>
            <button class="btn btn-primary px-4 py-2 shadow-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#addAuthorModal">
                <i class="fa-solid fa-plus me-2"></i> Add New Author
            </button>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="py-3" style="width: 150px;">Author ID</th>
                                <th class="py-3">Full Name</th>
                                <th class="py-3">Biography</th>
                                <th class="py-3 text-center" style="width: 150px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $result->fetch_assoc()) :?>
                            <tr>
                                <td class="fw-bold text-muted"><?php echo $row['author_id'];?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-info bg-opacity-10 p-2 rounded me-3 text-info">
                                            <i class="fa-solid fa-feather-pointed"></i>
                                        </div>
                                        <span class="fw-semibold text-dark"><?php echo $row['name'];?></span>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-muted mb-0 text-truncate" style="max-width: 300px;"><?php echo $row['bio'];?></p>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-light btn-sm border rounded-3 me-1" 
                                            style="width: 35px; height: 35px;"
                                            data-bs-toggle="modal" data-bs-target="#editAuthorModal<?php echo $row['author_id']; ?>">
                                        <i class="fa-solid fa-pen text-info"></i>
                                    </button>
                                    
                                    <a href="index.php?page=author&delete_id=<?php echo $row['author_id']; ?>" 
                                       class="btn btn-light btn-sm border rounded-3" 
                                       style="width: 35px; height: 35px; display: inline-flex; align-items: center; justify-content: center;"
                                       onclick="return confirm('Delete this author permanently?')">
                                        <i class="fa-solid fa-trash text-danger"></i>
                                    </a>
                                </td>
                            </tr>

                            <div class="modal fade" id="editAuthorModal<?php echo $row['author_id']; ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow-lg rounded-4">
                                        <div class="modal-header border-0 p-4 pb-0">
                                            <h5 class="modal-title fw-bold">Edit Author Details</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <form action="index.php?page=author" method="POST">
                                                <input type="hidden" name="author_id" value="<?php echo $row['author_id']; ?>">
                                                
                                                <div class="mb-3">
                                                    <label class="form-label small fw-bold text-muted text-uppercase">Full Name</label>
                                                    <input type="text" class="form-control bg-light border-0 py-3" name="author_name" value="<?php echo $row['name']; ?>" required>
                                                </div>

                                                <div class="mb-4">
                                                    <label class="form-label small fw-bold text-muted text-uppercase">Biography</label>
                                                    <textarea class="form-control bg-light border-0" name="author_bio" rows="4" style="resize: none;"><?php echo $row['bio']; ?></textarea>
                                                </div>

                                                <div class="d-grid">
                                                    <button type="submit" name="btn_update" class="btn btn-primary btn-lg rounded-pill fw-bold">Update Author</button>
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

<div class="modal fade" id="addAuthorModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 p-4 pb-0">
                <h5 class="modal-title fw-bold text-dark">Register New Author</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="index.php?page=author" method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase tracking-wider">Author Full Name</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-signature text-muted"></i></span>
                            <input type="text" class="form-control form-control-lg bg-light border-0" placeholder="e.g., George R.R. Martin" name="author_name" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted text-uppercase tracking-wider">Author Biography</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0 align-items-start pt-3">
                                <i class="fa-solid fa-quote-left text-muted"></i>
                            </span>
                            <textarea class="form-control bg-light border-0" name="author_bio" rows="4" placeholder="Brief background..." style="resize: none;"></textarea>
                        </div>
                    </div>
                    <div class="d-grid mt-2">
                        <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow-sm py-3 fw-bold" name="btn_save">Save Details</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php 

$conn->close(); 
?>