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

<?php
// Memulai session untuk menyimpan data pengguna
session_start();

// Koneksi ke database
include 'admin/db_connect.php';

// Ambil ID produk dari URL (misalnya dari parameter GET)
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Query untuk mengambil detail produk berdasarkan ID
$sql = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Tampilkan produk (judul, deskripsi, dll.) di sini
echo "<h1>" . $product['product_name'] . "</h1>";
echo "<p>" . $product['description'] . "</p>";
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
    /* SPRODUCT */
    .small-img-group {
        display: flex;
        justify-content: space-between;
    }
    .small-img-col {
        flex-basis: 24%;
        cursor: pointer;
    }
    .sproduct input {  
        width: 50px;
        height: 40px;
        padding-left: 10px;
        font-size: 16px;
    }
    .sproduct input:focus {
        outline: none;
    }
    .sproduct button {
        opacity: 1;
        transition: 0.3s all;
        margin: 10px 0;
        outline: none;
    }

    .sproduct form button {
        opacity: 1;
        transition: 0.3s all;
        margin: 10px 0;
        outline: none;
    }
    .sproduct .rating i {
        color: #b31010;
    }

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

    /* Produk terkait */
    .pro img {
        width: 100%;           /* Mengatur lebar gambar 100% sesuai dengan container */
        height: 200px;         /* Tentukan tinggi tetap untuk gambar */
        object-fit: cover;     /* Memastikan gambar tetap proporsional dan terpotong jika perlu */
    }

    .pro a {
        text-decoration: none; /* Menghilangkan garis bawah pada tautan */
        color: inherit; /* Mengatur warna teks agar mengikuti warna teks induk */
    }

    .pro a:hover {
        text-decoration: none; /* Menghilangkan garis bawah saat hover */
        color: inherit; /* Mengatur warna teks saat hover agar tetap */
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

        
        <!-- SPRODUCT -->
        <section class="container sproduct my-5 pt-5">
            <div class="row mt-5">
                <div class="col-lg-5 col-md-12 col-12">
                    <img class="img-fluid w-100 pb-1" src="image/<?php echo $product['image']; ?>" id="MainImg" alt="<?php echo $product['name']; ?>">
                    <div class="small-img-group">
                        <div class="small-img-col">
                            <img src="image/<?php echo $product['image']; ?>" width="100%" class="small-img" alt="">
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12 col-12">
                    <br><br>
                    <h3 class="pt-4"><?php echo $product['name']; ?></h3>
                    <div class="star mt-" style="color: #ee9613;" >
                        <?php 
                        $rating = isset($product['rating']) ? $product['rating'] : 0; // default rating to 0 if not set
                        for ($i = 1; $i <= 5; $i++) {
                            if ($i <= $rating) {
                                echo '<i class="fa-solid fa-star"></i>'; // Bintang penuh
                            } else {
                                echo '<i class="fa-regular fa-star"></i>'; // Bintang kosong
                            }
                        }
                        ?>
                    </div>
                    <h2>Rp <?php echo number_format($product['price'], 0, ',', '.'); ?></h2>
                    <input type="number" value="1" class="my-1">
                    <form action="cart_action.php" method="POST">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <button type="submit" class="btn btn-primary">Add to Cart</button>
                    </form>
                    <h4 class="mt-5 mb-3">Product Details</h4>
                    <p>Stok: <?php echo $product['stock']; ?></p>
                    <span><?php echo $product['description']; ?></span>
                </div>
            </div>
        </section>

    <!-- ULASAN -->
    <div id="review-section" class="container">
        <h2 class="font-weight-bold">Product Reviews</h2>
        <hr>
        <div class="comment-section">
    <h3>Tambahkan Komentar</h3>
    <?php if(isset($_SESSION['user_id'])): ?>
        <!-- Jika sudah login, tampilkan form komentar -->
        <form action="submit_comment.php" method="POST">
            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
            
            <div class="form-group">
                <label for="name">Nama:</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo $_SESSION['username']; ?>" readonly>
            </div>
            
            <div class="form-group">
                <label for="comment">Komentar:</label>
                <textarea id="comment" name="comment" class="form-control" rows="5" required></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary">Kirim Komentar</button>
        </form>
    <?php else: ?>
        <!-- Jika belum login, arahkan ke halaman login -->
        <p>Silakan <a href="signin.php">login</a> terlebih dahulu untuk memberikan komentar.</p>
    <?php endif; ?>
</div>

<!-- Menampilkan komentar yang ada -->
<div class="comment-list">
    <h3>Komentar:</h3>
    <?php
    // Ambil komentar berdasarkan ID produk
    $sql_comments = "SELECT c.comment, u.username, c.created_at FROM comments c JOIN user u ON c.user_id = u.id WHERE c.product_id = ? ORDER BY c.created_at DESC";
    $stmt_comments = $conn->prepare($sql_comments);
    $stmt_comments->bind_param("i", $product_id);
    $stmt_comments->execute();
    $comments = $stmt_comments->get_result();

    if ($comments->num_rows > 0) {
        while ($row = $comments->fetch_assoc()) {
            echo "<div class='comment-item'>";
            echo "<strong>" . $row['username'] . "</strong>";
            echo "<p>" . $row['comment'] . "</p>";
            echo "<small>" . $row['created_at'] . "</small>";
            echo "</div>";
        }
    } else {
        echo "<p>Belum ada komentar.</p>";
    }
    $stmt_comments->close();
    ?>
</div>
    </div>

    <!-- RELATED PRODUCTS -->
    <section id="product1" class="container my-5 pt-5">
        <h2 class="font-weight-bold">Related Products</h2>
        <div class="pro-container container">
            <?php
            if (count($related_products) > 0) {
                foreach ($related_products as $related_product) {
                    $image = !empty($related_product["image"]) ? $related_product["image"] : 'default.png';
                    $category_name = !empty($related_product["category_name"]) ? $related_product["category_name"] : 'Unknown';
                    $name = !empty($related_product["name"]) ? $related_product["name"] : 'No Name';
                    $price = !empty($related_product["price"]) ? number_format($related_product["price"], 0, ',', '.') : '0';
                    $id = $related_product["id"];
                    $rating = !empty($related_product["rating"]) ? $related_product["rating"] : 0;

                    echo '<div class="pro">';
                    echo '<a href="productdetail.php?id=' . htmlspecialchars($id) . '"><img src="image/' . htmlspecialchars($image) . '" alt="Product Image"></a>';
                    echo '<div class="des">';
                    echo '<span>' . htmlspecialchars($category_name) . '</span>'; // Menampilkan nama kategori
                    echo '<h5>' . htmlspecialchars($name) . '</h5>';
                    echo '<div class="star">';
                    // Menampilkan rating bintang
                    for ($i = 0; $i < 5; $i++) {
                        if ($i < $rating) {
                            echo '<i class="fa-solid fa-star"></i>';
                        } else {
                            echo '<i class="fa-regular fa-star"></i>';
                        }
                    }
                    echo '</div>';
                    echo '<h4>Rp ' . htmlspecialchars($price) . '</h4>';
                    echo '</div>';
                echo '<a href="productdetail.php?id=' . htmlspecialchars($id) . '"><i class="fa-solid fa-shopping-cart cart"></i></a>';
                    echo '</div>';
                }
            } else {
                echo "<p>No related products found.</p>";
            }
            ?>
        </div>
    </section>

    <!-- FOOTER -->
   <footer class="mt-5 py-5">
    <div class="row container mx-auto pt-5">
      <div class="footer-one col-lg-3 col-md-6 col-12">
        <img src="image/CEL.png" style="width: 55px;" alt="ragilcell.">
        <p class="pt-3">ragilcell offers a wide range of new and used mobile phones from top brands at competitive prices. Enjoy easy, safe, and convenient shopping with us.</p>
      </div>
  
      <div class="footer-one col-lg-3 col-md-6 col-12 mb-3">
        <h5 class="pb-2">My Account</h5>
        <ul class="text-uppercase list-unstyled">
          <li><a href="#">Sign in</a></li>
          <li><a href="#">View Cart</a></li>
          <li><a href="#">Track My Order</a></li>
          <li><a href="#">Help</a></li>
        </ul>
      </div>   
  
      <div class="footer-one col-lg-3 col-md-6 col-12 mb-3">
        <h5 class="pb-2">About</h5>
        <ul class="text-uppercase list-unstyled">
          <li><a href="home.php">Home</a></li>
          <li><a href="about.php">About Us</a></li>
          <li><a href="contact.php">Contact Us</a></li>
        </ul>
      </div>
  
      <div class="footer-one col-lg-3 col-md-6 col-12 mb-3">
        <h5 class="pb-2">Contact Us</h5>
        <div>
          <h6 class="text-uppercase">Address</h6>
          <p>MALL Sarinah Malang</p>
        </div>
        <div>
          <h6 class="text-uppercase">Phone</h6>
          <p>+6281230344825</p>
        </div>
        <div>
          <h6 class="text-uppercase">Email</h6>
          <p>ragilcell87@gmail.com</p>
        </div>
      </div>
    </div>

    <div class="copyright mt-5">
      <div class="row container mx-auto">

        <div class="col-lg-5 col-md-6 col-12 mb-4">
          <img src="image/bank/bank.png" alt="Mandiri">
        </div>
        <div class="col-lg-5 col-md-6 col-6 text-nowrap mb-2">
          <p>@2024.ragilcell. All rights reserved.</p>
        </div>
        <div class="col-lg-2 col-md-6 col-12">
          <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
          <a href="#"><i class="fa-brands fa-twitter"></i></a>
          <a href="#"><i class="fa-brands fa-instagram"></i></a>
        </div>
      </div>
    </div>
  </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>

    <?php
    $conn->close();
    ?>
