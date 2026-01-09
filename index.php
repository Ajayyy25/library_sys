<?php
session_start();
// This connects your database to the entire system
include "./includes/connection.php"; 

// SECURITY: If the user is not logged in, kick them out to login.php
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Set a default page so the main content isn't empty on first load
$page = isset($_GET['page']) ? $_GET['page'] : 'book';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LibriLink Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --sidebar-bg: #1a1d20;
            --sidebar-hover: #2c3136;
            --accent-blue: #0d6efd;
            --bg-light: #f8f9fa;
        }

        body { background-color: var(--bg-light); overflow-x: hidden; }

        /* Sidebar Styling */
        .sidebar {
            width: 260px;
            height: 100vh;
            background: var(--sidebar-bg);
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            transition: all 0.3s;
        }

        .nav-link {
            color: #949ba2;
            padding: 12px 20px;
            border-radius: 10px;
            margin-bottom: 5px;
            transition: 0.2s;
        }

        .nav-link:hover {
            background: var(--sidebar-hover);
            color: #fff;
        }

        .nav-link.active {
            background: var(--accent-blue);
            color: #fff !important;
            box-shadow: 0 4px 15px rgba(13, 110, 253, 0.3);
        }

        /* Content Area */
        .main-content {
            margin-left: 260px;
            padding: 40px;
            min-height: 100vh;
        }

        /* Cool Glass Card Effect */
        .stat-card {
            background: #fff;
            border: none;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
            transition: transform 0.3s ease;
        }

        .stat-card:hover { transform: translateY(-5px); }

        .icon-box {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }
    </style>
</head>
<body>

<aside class="sidebar p-3 shadow">
    <div class="d-flex align-items-center mb-4 px-3 text-white">
        <i class="fa-solid fa-book-bookmark fs-4 text-primary me-2"></i>
        <span class="fs-4 fw-bold">Librarysys</span>
    </div>

    <ul class="nav nav-pills flex-column px-2">
        <li><a href="index.php?page=book" class="nav-link"><i class="fa-solid fa-book me-3"></i>Books</a></li>
        <li><a href="index.php?page=author" class="nav-link"><i class="fa-solid fa-layer-group me-3"></i>Authors</a></li>
        <li><a href="index.php?page=category" class="nav-link"><i class="fa-solid fa-pen-nib me-3"></i>Categories</a></li>
        <li><a href="index.php?page=borrowed" class="nav-link"><i class="fa-solid fa-hand-holding me-3"></i>Transaction</a></li>
        <li><a href="index.php?page=returned" class="nav-link"><i class="fa-solid fa-rotate-left me-3"></i>Returned</a></li>
        <li><a href="index.php?page=reservation" class="nav-link"><i class="fa-solid fa-calendar-check me-3"></i>Reservations</a></li>
        <li><a href="index.php?page=student" class="nav-link"><i class="fa-solid fa-user-graduate me-3"></i>Students</a></li>
    </ul>
    </ul>

    <div class="mt-auto px-2 pt-4 border-top border-secondary">
        <a href="index.php?page=profile" class="nav-link"><i class="fa-solid fa-circle-user me-3"></i>Profile</a>
        <a href="logout.php" class="nav-link text-danger"><i class="fa-solid fa-right-from-bracket me-3"></i>Logout</a>
    </div>
</aside>

<main class="main-content">
    <?php
    if (isset($_GET['page'])){
      $page=$_GET['page'];
      switch ($page){
        case 'book';
        include 'modules/book.php';
        break;
            case 'author';
            include 'modules/author.php';
            break;
                case 'category';
                include 'modules/category.php';
                break;
                    case 'borrowed';
                    include 'modules/borrowed.php';
                    break;
                        case 'returned';    
                        include 'modules/returned.php';
                        break;
                            case 'reservation';
                            include 'modules/reservation.php';
                            break;
                                case 'student';
                                include 'modules/student.php';
                                break;
                                    case 'profile';
                                    include 'modules/profile.php';
                                    break;
      }
    }
    ?>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>