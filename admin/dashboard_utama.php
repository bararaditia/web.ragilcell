<?php
include 'db_connect.php';

// Fetch total users
$sqlUsers = "SELECT COUNT(*) as count FROM user";
$totalUsersResult = $conn->query($sqlUsers);
if (!$totalUsersResult) {
    die("Query failed: " . $conn->error . " | Query: " . $sqlUsers);
}
$totalUsers = $totalUsersResult->fetch_assoc()['count'];

// Fetch total products
$sqlProducts = "SELECT COUNT(*) as count FROM products";
$totalProductsResult = $conn->query($sqlProducts);
if (!$totalProductsResult) {
    die("Query failed: " . $conn->error . " | Query: " . $sqlProducts);
}
$totalProducts = $totalProductsResult->fetch_assoc()['count'];

// Fetch total blogs
$sqlBlogs = "SELECT COUNT(*) as count FROM blogs";
$totalBlogsResult = $conn->query($sqlBlogs);
if (!$totalBlogsResult) {
    die("Query failed: " . $conn->error . " | Query: " . $sqlBlogs);
}
$totalBlogs = $totalBlogsResult->fetch_assoc()['count'];

// Fetch total transactions
$sqlTransactions = "SELECT COUNT(*) as count FROM transactions";
$totalTransactionsResult = $conn->query($sqlTransactions);
if (!$totalTransactionsResult) {
    die("Query failed: " . $conn->error . " | Query: " . $sqlTransactions);
}
$totalTransactions = $totalTransactionsResult->fetch_assoc()['count'];
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
            border-radius: 15px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .card-header {
            background-color: rgba(255, 255, 255, 0.1);
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            font-weight: bold;
            font-size: 1.25rem;
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

        <div class="container">
            <h1 class="text-center mb-4">Dashboard Admin</h1>
            <div class="row">
                <div class="col-md-3">
                    <div class="card text-white bg-primary mb-4 shadow">
                        <div class="card-header">Total Users</div>
                        <div class="card-body text-center">
                            <h5 class="card-title" style="font-size: 2rem;"><?= $totalUsers; ?></h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-success mb-4 shadow">
                        <div class="card-header">Total Products</div>
                        <div class="card-body text-center">
                            <h5 class="card-title" style="font-size: 2rem;"><?= $totalProducts; ?></h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-warning mb-4 shadow">
                        <div class="card-header">Total Blogs</div>
                        <div class="card-body text-center">
                            <h5 class="card-title" style="font-size: 2rem;"><?= $totalBlogs; ?></h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-danger mb-4 shadow">
                        <div class="card-header">Total Transactions</div>
                        <div class="card-body text-center">
                            <h5 class="card-title" style="font-size: 2rem;"><?= $totalTransactions; ?></h5>
                        </div>
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
</script>
</body>
</html>

<?php $conn->close(); ?>
