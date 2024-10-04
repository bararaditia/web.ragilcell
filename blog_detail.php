<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    // Jika belum login, tampilkan pop-up
    echo '<!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Popup Login</title>
        <style>
            body {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
                background-color: #222;
                font-family: Arial, sans-serif;
            }
            .popup {
                background: white;
                padding: 30px;
                border-radius: 10px;
                text-align: center;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
                animation: fadeIn 0.5s;
                position: relative;
            }
            .popup h2 {
                color: #333;
                margin-bottom: 15px;
            }
            .popup p {
                margin: 10px 0;
            }
            .popup a {
                color: #db1313;
                text-decoration: none;
                font-weight: bold;
            }
            .popup a:hover {
                text-decoration: underline;
            }
            .close-btn {
                position: absolute;
                top: 10px;
                right: 10px;
                background: transparent;
                border: none;
                font-size: 20px;
                cursor: pointer;
            }
            @keyframes fadeIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }
        </style>
    </head>
    <body>
        <div class="popup">
            <button class="close-btn" onclick="window.history.back();">&times;</button>
            <h2>Anda harus login terlebih dahulu.</h2>
            <p>
                <a href="signin.html">Login</a> atau <a href="register.html">Daftar</a>
            </p>
        </div>
    </body>
    </html>';
    exit;
}

// Koneksi ke database
include 'admin/db_connect.php';

// Cek apakah ID blog tersedia di URL
if (isset($_GET['id'])) {
    $blog_id = $_GET['id'];

    // Query untuk mengambil detail blog berdasarkan ID
    $sql = "SELECT * FROM blogs WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $blog_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Cek apakah blog dengan ID tersebut ditemukan
    if ($result->num_rows > 0) {
        // Fetch data blog
        $blog = $result->fetch_assoc();
    } else {
        // Jika tidak ditemukan, redirect ke halaman blog
        header("Location: blog.php");
        exit;
    }
} else {
    // Jika ID tidak ada di URL, redirect ke halaman blog
    header("Location: blog.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ragil Cell - Blog Detail</title>
    
    <link rel="shortcut icon" type="image/x-icon" href="image/CEL.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        #blog-detail-container {
            padding-top: 100px;
        }
        .blog-detail {
            margin-bottom: 40px;
        }
        .blog-detail img {
            width: 100%;
            height: 450px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .blog-detail h2 {
            font-size: 2rem;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .blog-detail p {
            font-size: 1rem;
            color: #666;
            line-height: 1.8;
            margin-bottom: 20px;
        }
        .back-button {
            display: flex;
            justify-content: center;
            margin-bottom: 40px;
        }
        .related-posts h3 {
            font-size: 1.5rem;
            margin-bottom: 20px;
        }
        .related-post {
            margin-bottom: 30px;
        }
        .related-post img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 15px;
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

    <!-- Blog Detail Section -->
    <section id="blog-detail-container" class="container my-5">
        <div class="blog-detail">
            <h2><?php echo $blog['title']; ?></h2>
            <img src="image/blog/<?php echo $blog['image']; ?>" alt="<?php echo $blog['title']; ?>">
            <p><?php echo nl2br($blog['content']); ?></p>
        </div>

        <!-- Tombol Kembali ke Halaman Blog -->
        <div class="back-button">
            <a href="blog.php" class="btn btn-primary">Kembali ke Halaman Blog</a>
        </div>

        <!-- Related Posts Section -->
        <div class="related-posts">
            <h3>Related Posts</h3>
            <div class="row">
                <?php
                // Query untuk blog terkait
                $sql_related = "SELECT * FROM blogs WHERE id != ? ORDER BY created_at DESC LIMIT 3";
                $stmt_related = $conn->prepare($sql_related);
                $stmt_related->bind_param("i", $blog_id);
                $stmt_related->execute();
                $result_related = $stmt_related->get_result();

                while($related_blog = $result_related->fetch_assoc()):
                ?>
                <div class="col-md-4 related-post">
                    <img src="image/blog/<?php echo $related_blog['image']; ?>" alt="Related Blog Post">
                    <h4><?php echo $related_blog['title']; ?></h4>
                    <a href="blog_detail.php?id=<?php echo $related_blog['id']; ?>" class="btn btn-sm btn-outline-dark">Read More</a>
                </div>
                <?php endwhile; ?>
            </div>
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

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Tutup koneksi database
$conn->close();
?>
