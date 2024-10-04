<?php
// Include file koneksi database
include 'db_connect.php';

// Query untuk mengambil data produk dan kategori terkait
$sql = "SELECT products.id, products.image, products.name, products.description, products.price, products.stock, products.rating, categories.name AS category_name, products.created_at 
        FROM products 
        INNER JOIN categories ON products.category_id = categories.id";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Query untuk mengambil data kategori
$sql_categories = "SELECT * FROM categories";
$stmt_categories = $pdo->prepare($sql_categories);
$stmt_categories->execute();
$categories = $stmt_categories->fetchAll(PDO::FETCH_ASSOC);
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
                    <h5 class="mb-0">Product Management</h5>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">Add Product</button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Product Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Rating</th> <!-- Kolom Rating ditambahkan di sini -->
                                <th>Category</th>
                                <th>Created at</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $product): ?>
                            <tr>
                                <td><?= $product['id'] ?></td>
                                <td><img src="uploads/<?= $product['image'] ?>" alt="Product Image" style="width: 50px;"></td>
                                <td><?= $product['name'] ?></td>
                                <td><?= $product['description'] ?></td>
                                <td><?= $product['price'] ?></td>
                                <td><?= $product['stock'] ?></td>
                                <td><?= $product['rating'] ?></td> <!-- Menampilkan rating produk -->
                                <td><?= $product['category_name'] ?></td>
                                <td><?= $product['created_at'] ?></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="tooltip" title="Edit Product"
                                        onclick="openEditModal('<?= $product['id'] ?>', '<?= $product['name'] ?>', '<?= $product['description'] ?>', '<?= $product['price'] ?>', '<?= $product['stock'] ?>', '<?= $product['rating'] ?>', '<?= $product['category_name'] ?>')">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <a href="delete_product.php?id=<?= $product['id'] ?>" class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Delete Product" 
                                    onclick="return confirm('Are you sure you want to delete this product?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Add Product Modal -->
        <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="addProductForm" action="add_product.php" method="post" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="productName" class="form-label">Product Name</label>
                                <input type="text" class="form-control" id="productName" name="productName" required>
                            </div>
                            <div class="mb-3">
                                <label for="productDescription" class="form-label">Description</label>
                                <textarea class="form-control" id="productDescription" name="productDescription" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="productPrice" class="form-label">Price</label>
                                <input type="number" class="form-control" id="productPrice" name="productPrice" required>
                            </div>
                            <div class="mb-3">
                                <label for="productStock" class="form-label">Stock</label>
                                <input type="number" class="form-control" id="productStock" name="productStock" required>
                            </div>
                            <div class="mb-3">
                                <label for="productRating" class="form-label">Rating</label>
                                <input type="number" class="form-control" id="productRating" name="productRating" step="0.1" min="0" max="5" required>
                            </div>
                            <div class="mb-3">
                                <label for="productCategory" class="form-label">Category</label>
                                <select class="form-select" id="productCategory" name="productCategory" required>
                                    <option value="">Select a Category</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?= $category['id'] ?>">
                                            <?= $category['name'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="productImage" class="form-label">Image</label>
                                <input type="file" class="form-control" id="productImage" name="productImage" accept="image/*">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Product Modal -->
        <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="editProductForm" action="edit_product.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="editProductId" id="editProductId">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="editProductName" class="form-label">Product Name</label>
                                <input type="text" class="form-control" id="editProductName" name="editProductName" required>
                            </div>
                            <div class="mb-3">
                                <label for="editProductDescription" class="form-label">Description</label>
                                <textarea class="form-control" id="editProductDescription" name="editProductDescription" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="editProductPrice" class="form-label">Price</label>
                                <input type="number" class="form-control" id="editProductPrice" name="editProductPrice" required>
                            </div>
                            <div class="mb-3">
                                <label for="editProductStock" class="form-label">Stock</label>
                                <input type="number" class="form-control" id="editProductStock" name="editProductStock" required>
                            </div>
                            <div class="mb-3">
                                <label for="editProductRating" class="form-label">Rating</label>
                                <input type="number" class="form-control" id="editProductRating" name="editProductRating" step="0.1" min="0" max="5" required>
                            </div>
                            <div class="mb-3">
                                <label for="editProductCategory" class="form-label">Category</label>
                                <select class="form-select" id="editProductCategory" name="editProductCategory" required>
                                    <option value="">Select a Category</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?= $category['id'] ?>">
                                            <?= $category['name'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="editProductImage" class="form-label">Image</label>
                                <input type="file" class="form-control" id="editProductImage" name="editProductImage" accept="image/*">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
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

    function openEditModal(id, name, description, price, stock, rating, category_id) {
        document.getElementById('editProductId').value = id;
        document.getElementById('editProductName').value = name;
        document.getElementById('editProductDescription').value = description;
        document.getElementById('editProductPrice').value = price;
        document.getElementById('editProductStock').value = stock;
        document.getElementById('editProductRating').value = rating;
        document.getElementById('editProductCategory').value = category_id;

        var myModal = new bootstrap.Modal(document.getElementById('editProductModal'), {});
        myModal.show();
    }

    document.getElementById('productImage').addEventListener('change', function(event) {
    var reader = new FileReader();
    reader.onload = function() {
        var img = document.getElementById('imagePreview');
        img.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
    });

</script>
</body>
</html>
