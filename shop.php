<?php
include 'admin/db_connect.php';

// Periksa apakah kategori dipilih dari URL
$category = isset($_GET['category']) ? $_GET['category'] : '';

// Tentukan jumlah produk per halaman
$products_per_page = 12;

// Periksa apakah parameter halaman diterima di URL, jika tidak, default ke halaman pertama
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Tentukan offset berdasarkan halaman saat ini
$offset = ($page - 1) * $products_per_page;

// Modifikasi query berdasarkan kategori yang dipilih
if (!empty($category)) {
    // Ambil produk berdasarkan kategori
    $sql = "SELECT p.*, c.name AS category_name 
            FROM products p 
            LEFT JOIN categories c ON p.category_id = c.id 
            WHERE c.name = ?
            LIMIT ?, ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii", $category, $offset, $products_per_page);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // Ambil semua produk jika kategori tidak dipilih
    $sql = "SELECT p.*, c.name AS category_name 
            FROM products p 
            LEFT JOIN categories c ON p.category_id = c.id
            LIMIT ?, ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $offset, $products_per_page);
    $stmt->execute();
    $result = $stmt->get_result();
}

// Ambil kategori dari tabel categories untuk dropdown
$sql_categories = "SELECT name FROM categories";
$categories_result = $conn->query($sql_categories);

// Dapatkan total produk untuk kategori atau semua produk
if (!empty($category)) {
    $sql_total = "SELECT COUNT(*) AS total FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE c.name = ?";
    $stmt_total = $conn->prepare($sql_total);
    $stmt_total->bind_param("s", $category);
} else {
    $sql_total = "SELECT COUNT(*) AS total FROM products";
    $stmt_total = $conn->prepare($sql_total);
}

$stmt_total->execute();
$total_result = $stmt_total->get_result();
$total_row = $total_result->fetch_assoc();
$total_products = $total_row['total'];

// Hitung total halaman
$total_pages = ceil($total_products / $products_per_page);
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
    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .filter-container {
        display: flex;
        align-items: center;
    }

    .filter-container select,
    .filter-container i {
        padding: 10px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-right: 10px;
    }

    .filter-container select {
        min-width: 150px;
    }

    /* Menyelaraskan ukuran gambar produk */
    .pro img {
        width: 100%; /* Sesuaikan lebar gambar dengan lebar elemen induknya */
        height: 200px; /* Tetapkan tinggi gambar yang konsisten */
        object-fit: cover; /* Memastikan gambar memenuhi ukuran tanpa distorsi */
    }

    /* PAGINATION */
    #pagination {
        text-align: center;
        margin-top: 20px;
    }

    #pagination a {
        text-decoration: none;
        background-color: #fff;
        color: #DB1313;
        padding: 8px 18px;
        border-radius: 4px;
        font-weight: 600;
        margin: 0 5px;
        border: 1px solid #DB1313;
    }

    #pagination a.active {
        background-color: #DB1313;
        color: #fff;
    }

    #pagination a i {
        font-size: 16px;
        font-weight: 600;
    }

    .star i {
    color: #FFD700; /* Warna emas untuk bintang yang aktif */
    font-size: 16px; /* Ukuran ikon bintang */
    margin-right: 2px; /* Jarak antar bintang */
    transition: color 0.3s ease; /* Transisi warna saat bintang diaktifkan */
    }

    .star i.fa-star-o {
        color: #DB1313; /* Warna abu-abu untuk bintang yang tidak aktif */
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

    <!-- PRODUCT "our product" -->
    <section id="product1" class="container my-5 pt-5">
    <div class="header mt-5 py-2">
    <h2 class="font-weight-bold"><?php echo !empty($category) ? htmlspecialchars($category) : 'All Products'; ?></h2>
    <div class="filter-container">
        <select onchange="filterByCategory(this.value)">
            <option value="">All Products</option>
            <?php
            if ($categories_result->num_rows > 0) {
                while ($row = $categories_result->fetch_assoc()) {
                    $selected = $category == $row['name'] ? 'selected' : '';
                    echo '<option value="' . htmlspecialchars($row['name']) . '" ' . $selected . '>' . htmlspecialchars($row['name']) . '</option>';
                }
            }
            ?>
        </select>
    </div>
</div>


<div class="pro-container container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $image = !empty($row["image"]) ? $row["image"] : 'default.png';
                $category_name = !empty($row["category_name"]) ? $row["category_name"] : 'Unknown';
                $name = !empty($row["name"]) ? $row["name"] : 'No Name';
                $price = !empty($row["price"]) ? number_format($row["price"], 0, ',', '.') : '0';
                $id = $row["id"]; // Ambil ID produk

                echo '<div class="pro">';
                echo '<a href="productdetail.php?id=' . htmlspecialchars($id) . '"><img src="image/' . htmlspecialchars($image) . '" alt="Product Image"></a>';
                echo '<div class="des">';
                echo '<span>' . htmlspecialchars($category_name) . '</span>';
                echo '<h5>' . htmlspecialchars($name) . '</h5>';
                echo '<div class="star">';
                $rating = !empty($row["rating"]) ? $row["rating"] : 0;
                for ($i = 0; $i < 5; $i++) {
                    if ($i < $rating) {
                        echo '<i class="fa-solid fa-star"></i>'; // Bintang terisi
                    } else {
                        echo '<i class="fa-regular fa-star"></i>'; // Bintang tidak terisi
                    }
                }
                echo '</div>';
                echo '<h4>Rp ' . htmlspecialchars($price) . '</h4>';
                echo '</div>';
                echo '<a href="productdetail.php?id=' . htmlspecialchars($id) . '"><i class="fa-solid fa-shopping-cart cart"></i></a>';
                echo '</div>';
            }
        } else {
            echo "<p>No products found for this category.</p>";
        }
        ?>
    </div>       

    <!-- PAGINATION -->
    <div id="pagination" class="mt-5">
        <?php if ($page > 1): ?>
            <a href="?category=<?php echo urlencode($category); ?>&page=<?php echo $page - 1; ?>"><i class="fa fa-chevron-left"></i></a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?category=<?php echo urlencode($category); ?>&page=<?php echo $i; ?>" class="<?php echo ($i == $page) ? 'active' : ''; ?>"><?php echo $i; ?></a>
        <?php endfor; ?>

        <?php if ($page < $total_pages): ?>
            <a href="?category=<?php echo urlencode($category); ?>&page=<?php echo $page + 1; ?>"><i class="fa fa-chevron-right"></i></a>
        <?php endif; ?>
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


<script>
function filterByCategory(category) {
    window.location.href = 'shop.php?category=' + encodeURIComponent(category);
}
</script>

<!-- SCRIPTS -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>

</body>
</html>
