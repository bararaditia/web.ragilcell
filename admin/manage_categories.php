<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_ragilcell"; // Sesuaikan dengan nama database Anda

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Menambah Kategori
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add') {
    $name = $_POST['name'];
    $sql = "INSERT INTO categories (name) VALUES ('$name')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('New category added successfully');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Mengedit Kategori
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'edit') {
    $category_id = $_POST['category_id'];
    $name = $_POST['name'];
    $sql = "UPDATE categories SET name='$name' WHERE id='$category_id'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Category updated successfully');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Menghapus Kategori
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'delete') {
    $category_id = $_POST['category_id'];
    $sql = "DELETE FROM categories WHERE id='$category_id'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Category deleted successfully');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Mengambil semua kategori
$sql = "SELECT * FROM categories";
$result = $conn->query($sql);
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
                    <h5 class="mb-0">Category Management</h5>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">Add Category</button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Category Name</th>
                            <th>Created at</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['created_at']; ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary me-1" onclick="openEditModal('<?php echo $row['id']; ?>', '<?php echo $row['name']; ?>')" data-bs-toggle="tooltip" title="Edit Category">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="manage_categories.php" method="POST" style="display:inline;">
                                            <input type="hidden" name="category_id" value="<?php echo $row['id']; ?>">
                                            <input type="hidden" name="action" value="delete">
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')" data-bs-toggle="tooltip" title="Delete Category">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="4">No categories found</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Add Category Modal -->
        <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="manage_categories.php" method="POST">
                            <input type="hidden" name="action" value="add">
                            <div class="mb-3">
                                <label for="categoryName" class="form-label">Category Name</label>
                                <input type="text" class="form-control" id="categoryName" name="name" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Category</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Category Modal -->
        <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="manage_categories.php" method="POST" id="editCategoryForm">
                            <input type="hidden" name="action" value="edit">
                            <input type="hidden" id="editCategoryId" name="category_id">
                            <div class="mb-3">
                                <label for="editCategoryName" class="form-label">Category Name</label>
                                <input type="text" class="form-control" id="editCategoryName" name="name" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom JS -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var sidebarCollapse = document.getElementById('sidebarCollapse');
        var sidebar = document.getElementById('sidebar');
        sidebarCollapse.addEventListener('click', function () {
            sidebar.classList.toggle('active');
        });
    });

    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function (tooltipEl) {
       new bootstrap.Tooltip(tooltipEl);
    });

    function openEditModal(id, name) {
        document.getElementById('editCategoryId').value = id;
        document.getElementById('editCategoryName').value = name;
        var editCategoryModal = new bootstrap.Modal(document.getElementById('editCategoryModal'));
        editCategoryModal.show();
    }

    document.addEventListener('DOMContentLoaded', function () {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    var sidebarCollapse = document.getElementById('sidebarCollapse');
    var sidebar = document.getElementById('sidebar');
    sidebarCollapse.addEventListener('click', function () {
        sidebar.classList.toggle('active');
    });
});

</script>

</body>
</html>
