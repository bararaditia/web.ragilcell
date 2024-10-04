<?php
include 'admin/db_connect.php';

// Periksa apakah kategori dipilih dari URL
$category = isset($_GET['category']) ? $_GET['category'] : '';

// Modifikasi query berdasarkan kategori yang dipilih
if (!empty($category)) {
  // Ambil produk berdasarkan kategori dan rating lebih dari 4, batasi hanya 8 produk
  $sql = "SELECT p.*, c.name AS category_name 
          FROM products p 
          LEFT JOIN categories c ON p.category_id = c.id 
          WHERE c.name = ? AND p.rating > 4 
          LIMIT 8"; // Tambahkan LIMIT
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $category);
  $stmt->execute();
  $result = $stmt->get_result();
} else {
  // Ambil semua produk dengan rating lebih dari 4 jika kategori tidak dipilih, batasi hanya 8 produk
  $sql = "SELECT p.*, c.name AS category_name 
          FROM products p 
          LEFT JOIN categories c ON p.category_id = c.id 
          WHERE p.rating > 4 
          LIMIT 8"; // Tambahkan LIMIT
  $result = $conn->query($sql);
}

// Mengambil produk yang diunggah dalam 30 hari terakhir, batasi hanya 8 produk
$sql_new_arrivals = "SELECT p.*, c.name AS category_name 
                     FROM products p 
                     LEFT JOIN categories c ON p.category_id = c.id 
                     WHERE p.created_at >= NOW() - INTERVAL 30 DAY 
                     ORDER BY p.created_at DESC 
                     LIMIT 8"; // Tambahkan LIMIT
$result_new_arrivals = $conn->query($sql_new_arrivals);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ragil Cell - Home</title>
    <link rel="shortcut icon" type="image/x-icon" href="image/CEL.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" >
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="responif.css">

</head>
<style>
  /* LANDING PAGE  */
#home{
  background-image: url(image/hd.jpg);
  background-color: #222;
  width: 100%;
  height: 100vh;
  background-size: cover;
  background-position: top 60x center;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: flex-start;
  color: #fff;
  }
  
  /* BANNER HOME */
  #banner {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  text-align: center;
  background-image: url(image/blog/banner.jpg);
  width: 100%;
  height: 40vh;
  background-size: cover;
  background-position: center;
  position: relative;
  background-blend-mode: darken; /* Untuk menggabungkan warna */
  background-color: rgba(0, 0, 0, 0.6); /* Warna hitam dengan transparansi 50% */
}

  /* #banner::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-image: inherit;
  background-size: cover;
  background-position: center;
  filter: blur(0px); /* Menambahkan efek blur 

  #banner > * {
  position: relative;
  z-index: 2; /* Supaya konten di dalam banner tetap terlihat
  } */ 

  #banner h4{
    color: #ffffff;
    font-size: 16px;
    filter: drop-shadow(0px 0px 1px #db1313);
  }
  
  #banner h2{
    color: #fff;
    font-size: 30px;
    padding: 10px 0;
    filter: drop-shadow(0px 0px 1px #db1313);
  }
  
  #banner h2 span{
    color: #DB1313;
    filter: drop-shadow(0px 0px 1px #0a0a0a);
  }

         /* Container untuk card yang bisa discroll ke samping */
         .card-container {
            display: flex;
            overflow-x: auto;
            padding: 20px;
            scroll-behavior: smooth;
            gap: 20px;
            scrollbar-width: none; /* Untuk Firefox */
            -ms-overflow-style: none;  /* Untuk Internet Explorer dan Edge */
        }

        .card-container::-webkit-scrollbar {
            display: none; /* Untuk Chrome, Safari, dan Opera */
        }

        /* Styling untuk card */
        .card {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            min-width: 300px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px;
            gap: 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            flex-shrink: 0; /* Agar card tidak mengecil saat container discroll */
        }

        /* Gambar di dalam card */
        .card img {
            filter: drop-shadow(0px 0px 3px #222);
            width: 80px;
            height: 80px;
            border-radius: 8px;
            object-fit: cover;
        }

        /* Konten di dalam card */
        .card-content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 10px;
        }

        /* Heading dan paragraf di dalam card */
        .card-content h4 {
            margin: 0;
            font-size: 1.2rem;
            color: #333;
        }

        .card-content p {
            font-size: 0.9rem;
            color: #666;
            margin: 0;
        }

        /* Tombol di dalam card */
        .card .btn {
            background-color: #DB1313;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            flex-shrink: 0;
        }

        .card .btn:hover {
            background-color: #b31010;
        }

        .pro img {
          width: 100%;           /* Mengatur lebar gambar 100% sesuai dengan container */
          height: 200px;         /* Tentukan tinggi tetap untuk gambar */
          object-fit: cover;     /* Memastikan gambar tetap proporsional dan terpotong jika perlu */
        }
</style>

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
                <li class="nav-item"><a class="nav-link active" href="home.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="shop.php">Shop</a></li>
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

  <!-- LANDING PAGE -->
   <section id="home">
    <div class="container">
      <h4>latest trending</h4>
      <h1>Find Your Drem <br>Phone Here!</h1>
      <p>With the latest collection and the best prices,<br> shopping has never ben easier and faster.</p>
      <a href="#product1"><button>Shop Now</button></a>
    </div>
   </section>

   <!-- BRAND -->
   <section id="brand" class="container">
    <div class="row m-0 py-5">
      <img class="img-fluid col-lg-2 col-md-4 col-6" src="image/brand/iphone.jpg" alt="">
      <img class="img-fluid col-lg-2 col-md-4 col-6" src="image/brand/xiomi.jpg" alt="">
      <img class="img-fluid col-lg-2 col-md-4 col-6" src="image/brand/oppo.jpg" alt="">
      <img class="img-fluid col-lg-2 col-md-4 col-6" src="image/brand/samsung.jpg" alt="">
      <img class="img-fluid col-lg-2 col-md-4 col-6" src="image/brand/vivo.jpg" alt="">
      <img class="img-fluid col-lg-2 col-md-4 col-6" src="image/brand/realme.jpg" alt="">
    </div>
   </section>

   <!-- CLAIM -->

  <!-- FEATURED -->
   <section id="product1" class="container my-1 py-5">
    <div class="container mt-5 py-2">
        <h3>Featured Products</h3>
        <hr class="mx-auto">
        <p>Here You can check out our new product with fair prices on Ragil Cell.</p>
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
</section>


    <!-- BANNER -->
     <section id="banner" class="mt-5 py-5">
      <h4>Repair Services</h4>
      <h2>Enjoy Up to <span>20% off!</span>Shop Now and Get The Best Deals</h2>
      <a href="shop.php"><button>Explore More</button></a>
     </section>

<!-- PRODUCT "new arrivals" -->
<section id="product1" class="container my-1 py-5">
    <div class="container mt-5 py-2">
        <h3>New Arrivals</h3>
        <hr class="mx-auto">
        <p>Here You can check out our new product with fair price on Ragil Cell.</p>
    </div>
    <div class="pro-container container">
        <?php
        // Query untuk mengambil produk terbaru
        $sql_new_arrivals = "SELECT p.*, c.name AS category_name 
                             FROM products p 
                             LEFT JOIN categories c ON p.category_id = c.id 
                             WHERE p.created_at >= NOW() - INTERVAL 30 DAY 
                             ORDER BY p.created_at DESC 
                             LIMIT 8"; // Ambil 8 produk terbaru
        $result_new_arrivals = $conn->query($sql_new_arrivals);
        
        if ($result_new_arrivals->num_rows > 0) {
            while ($row = $result_new_arrivals->fetch_assoc()) {
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
            echo "<p>No products found for new arrivals.</p>";
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
  
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

</body>
</html>
