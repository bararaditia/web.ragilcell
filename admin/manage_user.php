<?php
include 'db_connect.php';

// Fetch all users from the database
$sql = "SELECT * FROM user";
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
                        <h5 class="mb-0">User Management</h5>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">Add User</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Password</th> <!-- Added Password column -->
                                    <th>Phone Number</th>
                                    <th>Address</th>
                                    <th>Created at</th>
                                    <th>Role</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?= $row['id']; ?></td>
                                        <td><?= $row['username']; ?></td>
                                        <td><?= $row['email']; ?></td>
                                        <td>******</td> <!-- Menampilkan asterisk untuk password -->
                                        <td><?= $row['phone_number']; ?></td>
                                        <td><?= $row['address']; ?></td>
                                        <td><?= $row['created_at']; ?></td>
                                        <td><span class="badge bg-primary"><?= ucfirst($row['role']); ?></span></td>
                                        <td>
                                            <!-- Tombol Edit dengan Tooltip -->
                                            <button class="btn btn-sm btn-outline-primary me-1" 
                                                onclick="openEditModal('<?= $row['id']; ?>','<?= $row['username']; ?>', '<?= $row['email']; ?>', '<?= $row['phone_number']; ?>', '<?= $row['address']; ?>', '<?= $row['role']; ?>')"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Edit User">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            
                                            <!-- Tombol Delete dengan Tooltip -->
                                            <a href="delete_user.php?id=<?php echo $row['id']; ?>" 
                                                class="btn btn-sm btn-outline-danger" 
                                                onclick="return confirm('Are you sure?')" 
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Delete User">
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

            <!-- Modals for Adding and Editing Users -->
             <!-- Add User Modal -->
            <div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="addUserForm" action="add_user.php" method="POST">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required minlength="8">
                                    <small class="form-text text-muted">Minimum 8 characters.</small>
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" id="phone" name="phone_number" required>
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" class="form-control" id="address" name="address" required>
                                </div>
                                <!-- Hidden input to automatically set role as "user" -->
                                <input type="hidden" name="role" value="user">
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Add User</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit User Modal -->
            <div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editUserForm" action="edit_user.php" method="POST">
                                <input type="hidden" id="edit_id" name="id">
                                <div class="mb-3">
                                    <label for="edit_username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="edit_username" name="username" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="edit_email" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="edit_password" name="password">
                                    <small class="form-text text-muted">Leave blank if you don't want to change the password. Minimum 8 characters.</small>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_phone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" id="edit_phone" name="phone_number" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_address" class="form-label">Address</label>
                                    <input type="text" class="form-control" id="edit_address" name="address" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_role" class="form-label">Role</label>
                                    <select class="form-select" id="edit_role" name="role" required>
                                        <option value="admin">Admin</option>
                                        <option value="user">User</option>
                                    </select>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
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

        function openEditModal(id, username, email, phone_number, address, role) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_username').value = username;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_phone').value = phone_number;
            document.getElementById('edit_address').value = address;
            document.getElementById('edit_role').value = role;
            
            var editModal = new bootstrap.Modal(document.getElementById('editUserModal'));
            editModal.show();
        }

    document.addEventListener("DOMContentLoaded", function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
    </script>
</body>
</html>

<?php $conn->close(); ?>
