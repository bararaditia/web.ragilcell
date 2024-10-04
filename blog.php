<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ragil Cell - Blogs</title>
    
    <link rel="shortcut icon" type="image/x-icon" href="image/CEL.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="responif.css">
    <style>
        #blog-container {
            padding-top: 100px;
        }
        .blog-header {
            margin-bottom: 40px;
        }
        .blog-post {
            margin-bottom: 40px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .blog-post img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 10px;
            transition: opacity 0.3s ease;
            padding: 5px;
            border-radius: 10px;
        }
        .blog-post:hover img {
            opacity: 0.9;
        }
        .blog-post h3 {
            font-size: 1.3rem;
            margin-top: 15px;
            margin-bottom: 10px;
            transition: color 0.3s ease;
        }
        .blog-post:hover h3 {
            color: #DB1313;
        }
        .blog-post p {
            font-size: 0.9rem;
            color: #666;
        }
        .featured-post img {
            height: auto;
            max-height: 400px;
            object-fit: cover;
        }
        .featured-post h3 {
            font-size: 1.8rem;
        }
        .btn:hover {
            background-color: #DB1313;
            color: white;
            transition: background-color 0.3s ease;
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
                    <li class="nav-item"><a class="nav-link" href="shop.php">Shop</a></li>
                    <li class="nav-item"><a class="nav-link active" href="blog.php">Blog</a></li>
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

   <!-- Blog Section -->
   <section id="blog-container" class="container my-5">
        <div class="blog-header text-center mb-5">
            <h2 class="font-weight-bold">Our Blog</h2>
            <p>Stay updated with the latest news and trends in the mobile world</p>
        </div>
        
        <div class="row">
          <?php
            // Koneksi ke database
            include 'admin/db_connect.php';

            // Query untuk mengambil data dari tabel blogs
            $sql = "SELECT * FROM blogs ORDER BY created_at DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data dari setiap row
                $first_post = true;
                while ($row = $result->fetch_assoc()) {
                    if ($first_post) {
                        // Post pertama dianggap sebagai featured post
                        echo '
                        <div class="col-12 blog-post featured-post mb-5">
                            <img src="image/blog/' . $row['image'] . '" alt="' . $row['title'] . '" class="img-fluid">
                            <h3>' . $row['title'] . '</h3>
                            <p>' . substr($row['content'], 0, 150) . '...</p>
                            <a href="blog_detail.php?id=' . $row['id'] . '" class="btn btn-outline-dark">Read More</a>
                        </div>';
                        $first_post = false;
                    } else {
                        // Post lainnya
                        echo '
                        <div class="col-md-4 blog-post">
                            <img src="image/blog/' . $row['image'] . '" alt="' . $row['title'] . '">
                            <h3>' . $row['title'] . '</h3>
                            <p>' . substr($row['content'], 0, 100) . '...</p>
                            <a href="blog_detail.php?id=' . $row['id'] . '" class="btn btn-sm btn-outline-dark">Read More</a>
                        </div>';
                    }
                }
            } else {
                // Jika tidak ada blog yang ditemukan, tampilkan pesan ini
                echo '<p class="text-center text-muted">Belum ada blog tersedia saat ini.</p>';
            }

            // Tutup koneksi
            $conn->close();
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
  
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
