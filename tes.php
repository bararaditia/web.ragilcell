<?php
// Sambungan ke database
$conn = new mysqli("localhost", "root", "", "db_ragilcell");

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Periksa apakah ada parameter id produk di URL
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Query untuk mengambil data produk berdasarkan ID
    $sql = "SELECT p.* FROM products p WHERE p.id = $product_id";
    $result = $conn->query($sql);

    // Cek apakah query berhasil
    if (!$result) {
        die("Query Error: " . $conn->error);
    }

    if ($result->num_rows > 0) {
        // Mendapatkan data produk
        $product = $result->fetch_assoc();
    } else {
        echo "Produk tidak ditemukan.";
        exit;
    }
} else {
    echo "ID produk tidak ditemukan.";
    exit;
}

// Ambil kategori produk saat ini
$current_category_id = $product['category_id'];

// Query untuk mengambil produk terkait dari kategori yang sama dan mengambil nama kategori
$sql_related = "SELECT p.*, c.name AS category_name 
                FROM products p 
                JOIN categories c ON p.category_id = c.id 
                WHERE p.category_id = $current_category_id 
                AND p.id != $product_id 
                ORDER BY RAND() 
                LIMIT 8";
$result_related = $conn->query($sql_related);

// Menyiapkan array untuk menyimpan produk terkait
$related_products = [];

// Cek apakah produk terkait dari kategori yang sama ditemukan
if ($result_related->num_rows > 0) {
    while ($row = $result_related->fetch_assoc()) {
        $related_products[] = $row;
    }
}

// Jika produk terkait kurang dari 8, ambil produk dari kategori lain secara acak untuk melengkapi
if (count($related_products) < 8) {
    $remaining = 8 - count($related_products);
    $sql_fill_related = "SELECT p.*, c.name AS category_name 
                         FROM products p 
                         JOIN categories c ON p.category_id = c.id 
                         WHERE p.id != $product_id 
                         AND p.category_id != $current_category_id 
                         ORDER BY RAND() 
                         LIMIT $remaining";
    $result_fill_related = $conn->query($sql_fill_related);

    // Gabungkan produk dari kategori lain ke dalam array produk terkait
    if ($result_fill_related->num_rows > 0) {
        while ($fill_product = $result_fill_related->fetch_assoc()) {
            $related_products[] = $fill_product;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ragil Cell - Shop</title>
        
    <link rel="shortcut icon" type="image/x-icon" href="image/CEL.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" >
    <link rel="stylesheet" href="style.css">

    <style>


    /* ULASAN */
    #review-section {
        background-color: #f9f9f9;
        padding: 30px;
        border-radius: 8px;
    }
    .review-item {
        border-bottom: 1px solid #ddd;
        padding-bottom: 15px;
    }
    .review-item h5 {
        font-size: 1.1rem;
        font-weight: 600;
    }
    .review-item .rating {
        color: #ee9613;
    }
    .review-form {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    .review-form h4 {
        font-size: 1.5rem;
        margin-bottom: 20px;
    }
    .review-form .form-group {
        margin-bottom: 15px;
    }
    .review-form .btn-primary {
        background-color: #DB1313;
        border-color: #DB1313;
        transition: background-color 0.3s;
    }
    .review-form .btn-primary:hover {
        background-color: #b31010;
        border-color: #b31010;
    }

</style>

    </head>
    <body>
        
        <!-- NAVIGATION -->
        <nav class="navbar navbar-expand-lg navbar-light py-3 fixed-top">
            <div class="container">
                <img src="image/CEL.png" style="width: 55px;" alt="">
                <a class="navbar-brand ml-3" href="#" style="font-weight: bold;">ragilcell.</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span><i id="bar" class="fa-solid fa-bars"></i></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link active" href="shop.php">Shop</a></li>
                        <li class="nav-item"><a class="nav-link" href="blog.php">Blog</a></li>
                        <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                        <li class="nav-item"><a class="nav-link" href="contact.php">Contact Us</a></li>
                        <li class="nav-item">
                            <a href="cart.php"><i class="fa-solid fa-bag-shopping"></i></a>
                            <a href="profile.php"><i class="fa-solid fa-user"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>


    <!-- ULASAN -->
    <div id="review-section" class="container">
        <h2 class="font-weight-bold">Product Reviews</h2>
        <hr>
        <div id="reviews">
            <!-- Review Item -->
            <div class="review-item my-4">
                <h5><strong>John Doe</strong> <span class="text-muted">- August 30, 2024</span></h5>
                <div class="rating">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star-half-alt"></i>
                </div>
                <p>Amazing product! Totally worth the price.</p>
            </div>
        </div>
        
        <!-- Review Form -->
        <div class="review-form mt-5">
            <h4 class="font-weight-bold">Add Your Review</h4>
            <form id="review-form">
                <div class="form-group">
                    <label for="name">Your Name:</label>
                    <input type="text" class="form-control" id="name" placeholder="Enter your name" required>
                </div>
                <div class="form-group">
                    <label for="comment">Your Review:</label>
                    <textarea class="form-control" id="comment" rows="4" placeholder="Write your review" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit Review</button>
            </form>
        </div>
    </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>

    <?php
    $conn->close();
    ?>
