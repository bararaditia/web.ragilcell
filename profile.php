<?php
session_start();
include 'admin/db_connect.php'; // Koneksi ke database

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
                <a href="signin.html">Login</a> atau <a href="signup.html">Daftar</a>
            </p>
        </div>
    </body>
    </html>';
    exit;
}


// Ambil ID pengguna dari session
$userId = $_SESSION['user_id'];

// Ambil data pengguna dari database
$query = "SELECT * FROM user WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit(); // Hentikan jika pengguna tidak ditemukan
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ragil Cell - User Profile</title>
    <link rel="shortcut icon" type="image/x-icon" href="image/CEL.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        .container-fluid {
            margin-top: 80px;
        }
        .sidebar {
            height: 100vh;
            background-color: #f8f9fa;
            padding-top: 20px;
            border-right: 1px solid #dee2e6;
        }
        .sidebar a {
            padding: 15px;
            text-decoration: none;
            font-size: 18px;
            color: #333;
            display: block;
        }
        .sidebar a:hover {
            background-color: #ddd;
            color: #DB1313;
        }
        .content {
            padding: 20px;
        }
        .profile-container {
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
        }
        .profile-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .profile-header h2 {
            font-size: 24px;
            font-weight: bold;
        }
        .profile-group {
            padding: 10px;
            border: 1px solid #e2e9e1;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .profile-group label {
            font-weight: bold;
        }
        .profile-group p {
            margin: 5px 0 0 0;
        }
        .btn-container {
            text-align: center;
            margin-top: 20px;
        }
        .edit-btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        .edit-btn:hover {
            background-color: #0056b3;
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
                    <li class="nav-item"><a class="nav-link" href="blog.php">Blog</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact Us</a></li>
                    <li class="nav-item">
                        <a href="cart.php"><i class="fa-solid fa-bag-shopping"></i></a>
                        <a href="profile.php"><i class="fa-solid fa-user active"></i></a>
                    </li>
                </ul>
            </div>
        </div>
      </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- SIDEBAR -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="password.php">Change Password</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="order.php">View Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </nav>

            <!-- PROFILE CONTENT -->
            <main class="col-md-9 col-lg-10 content mt-5">
                <div class="profile-container">
                    <div class="profile-header">
                        <h2>User Profile</h2>
                    </div>

                    <div class="profile-group">
                        <label for="username">Username:</label>
                        <p id="username"><?php echo htmlspecialchars($user['username']); ?></p>
                    </div>
                    
                    <div class="profile-group">
                        <label for="email">Email:</label>
                        <p id="email"><?php echo htmlspecialchars($user['email']); ?></p>
                    </div>
                    
                    <div class="profile-group">
                        <label for="phone">Phone Number:</label>
                        <p id="phone"><?php echo htmlspecialchars($user['phone_number']); ?></p>
                    </div>
                    
                    <div class="profile-group">
                        <label for="address">Address:</label>
                        <p id="address"><?php echo htmlspecialchars($user['address']); ?></p>
                    </div>

                    <div class="btn-container">
                        <button class="edit-btn" data-toggle="modal" data-target="#editProfileModal">Edit Profile</button>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <!-- Update action to point to edit_profile.php -->
            <form method="POST" action="edit_profile.php">
            <div class="form-group">
                <label for="editUsername">Username</label>
                <input type="text" class="form-control" id="editUsername" name="username" value="<?php echo htmlspecialchars($user['username']); ?>">
            </div>
            <div class="form-group">
                <label for="editEmail">Email</label>
                <input type="email" class="form-control" id="editEmail" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">
            </div>
            <div class="form-group">
                <label for="editPhone">Phone Number</label>
                <input type="tel" class="form-control" id="editPhone" name="phone_number" value="<?php echo htmlspecialchars($user['phone_number']); ?>">
            </div>
            <div class="form-group">
                <label for="editAddress">Address</label>
                <input type="text" class="form-control" id="editAddress" name="address" value="<?php echo htmlspecialchars($user['address']); ?>">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
        </form>
        </div>
    </div>
    </div>

    <!-- FOOTER -->
    <footer class="py-5">
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

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
