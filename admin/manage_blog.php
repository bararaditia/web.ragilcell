<?php
include 'db_connect.php';

// Fetch all blog posts from the database
$sql = "SELECT * FROM blogs";
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="shortcut icon" type="image/x-icon" href="image/CEL.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');

        :root {
            --primary-color: #db1313;
            --secondary-color: #858796;
            --success-color: #1cc88a;
            --info-color: #36b9cc;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
            --light-color: #f8f9fc;
            --dark-color: #5a5c69;
            --black-color: #222;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-color);
            color: var(--dark-color);
            overflow-x: hidden;
        }

        .wrapper {
            display: flex;
            width: 100%;
            align-items: stretch;
        }

        #sidebar {
            min-width: 250px;
            max-width: 250px;
            background: linear-gradient(180deg, #1c1c1c 0%, #292929 100%);
            color: #fff;
            transition: all 0.3s;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.3);
        }

        #sidebar.active {
            margin-left: -250px;
        }

        #sidebar .sidebar-header {
            padding: 15px 0;
            padding-left: 30px;
            background: var(--primary-color);
            font-weight: bold;
            font-size: 1.5rem;
        }

        #sidebar ul.components {
            padding: 20px 0;
        }

        #sidebar ul li a {
            margin-left: 10px;
            padding: 12px;
            font-size: 1.1em;
            display: block;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s, padding-left 0.3s;
        }

        #sidebar ul li a:hover {
            background: var(--primary-color);
            padding-left: 20px;
        }

        #content {
            width: 100%;
            padding: 20px;
            min-height: 100vh;
            transition: all 0.3s;
        }

        .navbar {
            padding: 15px 10px;
            background: #fff;
            border: none;
            border-radius: 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-header {
            background-color: white;
            border-bottom: 1px solid #e3e6f0;
            font-weight: bold;
        }

        #sidebarCollapse {
            background-color: #db1313;
            color: #fff;
            border: none;
            border-radius: 5px;
            transition: background 0.3s;
        }

        #sidebarCollapse:hover {
            background-color: #e74a3b;
        }

        @media (max-width: 768px) {
            #sidebar {
                margin-left: -250px;
            }
            #sidebar.active {
                margin-left: 0;
            }
            #sidebarCollapse span {
                display: none;
            }
        }
    </style>
</head>

<body>
<div class="wrapper">
    <!-- Sidebar -->
    <nav id="sidebar">
        <div class="sidebar-header">
            RagilCell
        </div>
        <ul class="list-unstyled components">
            <li><a href="dashboard_utama.php"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="manage_user.php"><i class="fas fa-users"></i> Users</a></li>
            <li><a href="manage_product.php"><i class="fas fa-box"></i> Products</a></li>
            <li><a href="manage_categories.php"><i class="fas fa-tags"></i> Categories</a></li>
            <li class="active"><a href="manage_blog.php"><i class="fas fa-blog"></i> Blogs</a></li>
            <li><a href="transactions.html"><i class="fas fa-exchange-alt"></i> Transactions</a></li>
            <li><a href="transaction-details.html"><i class="fas fa-file-invoice"></i> Transaction Details</a></li>
        </ul>
    </nav>

    <!-- Page Content -->
    <div id="content">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <button type="button" id="sidebarCollapse" class="btn btn-info">
                    <i class="fas fa-align-left"></i>
                    <span>Toggle Sidebar</span>
                </button>
            </div>
        </nav>
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Blog Management</h5>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBlogModal">Add Blog</button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Content</th>
                                <th>Image</th>
                                <th>Created at</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()) { ?>
                                <tr>
                                    <td><?= $row['id']; ?></td>
                                    <td><?= $row['title']; ?></td>
                                    <td><?= substr($row['content'], 0, 100) . '...'; ?></td>
                                    <td><img src="image/blog/<?= $row['image']; ?>" alt="Blog Image" style="width: 100px; height: auto;"></td>
                                    <td><?= $row['created_at']; ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Blog" onclick="openEditModal('<?= $row['id']; ?>', '<?= $row['title']; ?>', '<?= addslashes($row['content']); ?>', '<?= $row['image']; ?>')"><i class="fas fa-edit"></i></button>
                                        <a href="delete_blog.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Blog" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Add Blog Modal -->
        <div class="modal fade" id="addBlogModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Blog</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="add_blog.php" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                            <div class="mb-3">
                                <label for="content" class="form-label">Content</label>
                                <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Image</label>
                                <input type="file" class="form-control" id="image" name="image" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Blog</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Blog Modal -->
        <div class="modal fade" id="editBlogModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Blog</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="edit_blog.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id" id="edit_id" value="">
                            <div class="form-group">
                                <label for="edit_title">Title</label>
                                <input type="text" class="form-control" id="edit_title" name="title" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_content">Content</label>
                                <textarea class="form-control" id="edit_content" name="content" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="edit_image">Image</label>
                                <input type="file" class="form-control-file" id="edit_image" name="image">
                                <img id="current_image" src="" alt="Current Image" width="100" style="display: block; margin-top: 10px;">
                            </div>
                            <button type="submit" class="btn btn-primary">Update Blog</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var sidebar = document.getElementById('sidebar');
        var sidebarCollapse = document.getElementById('sidebarCollapse');
        sidebarCollapse.addEventListener('click', function () {
            sidebar.classList.toggle('active');
        });
    });

    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function (tooltipEl) {
    new bootstrap.Tooltip(tooltipEl);
    });


    function openEditModal(id, title, content, image) {
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_title').value = title;
        document.getElementById('edit_content').value = content;

        var currentImage = document.getElementById('current_image');
        currentImage.src = 'image/' + image;
        currentImage.style.display = 'block';  // Ensure the current image is shown
        
        var editModal = new bootstrap.Modal(document.getElementById('editBlogModal'));
        editModal.show();
    }
</script>
</body>
</html>

<?php $conn->close(); ?>
