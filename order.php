<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - Ragil Cell</title>
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
        main {
            min-height: 100vh;
            margin-left: 220px; /* Offset by sidebar width */
        }
        .change-password-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .change-password-header h2 {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .btn-container {
            text-align: center;
        }
        .btn-container .btn {
            width: 100%;
            max-width: 200px;
        }

        /* Cart */
        #cart a {
            text-decoration: none;
            color: #0a0a0a;
        }

        #cart {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            white-space: nowrap;
        }

        #cart table img {
            width: 70px;
        }

        #cart table td:nth-child(1) {
            width: 150px;
            text-align: center;
        }

        #cart table td:nth-child(2) {
            width: 250px;
            text-align: center;
        }

        #cart table td:nth-child(3),
        #cart table td:nth-child(4),
        #cart table td:nth-child(5) {
            width: 150px;
            text-align: center;
        }

        #cart table td:nth-child(6) {
            width: 200px;
            text-align: center;
        }
        #cart table td:nth-child(7) {
            width: 200px;
            text-align: center;
        }

        #cart table td:nth-child(5) input {
            width: 70px;
            padding: 10px 5px 10px 15px;
        }

        #cart table thead {
            border: 1px solid #e2e9e1;
            border-left: none;
            border-right: none;
        }

        #cart table thead td {
            font-weight: 700;
            text-transform: uppercase;
            font-size: 13px;
            padding: 18px 0;
        }

        #cart table tbody tr td {
            padding-top: 15px;
        }

        #cart table tbody td {
            font-size: 13px;
        }

        @media only screen and (max-width:799px) {
            .navbar {
                padding: 0 50px;
            }
            hr {
                width: 30px;
                height: 2px;
                background-color: #DB1313;
            }
            .sidebar {
                margin-left: 0;
                position: relative;
                height: auto;
            }
            main {
                margin-left: 0;
            }
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
              <li class="nav-item"><a class="nav-link " href="blog.php">Blog</a></li>
              <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
              <li class="nav-item"><a class="nav-link" href="contact.php">Contact Us</a></li>
              <li class="nav-item">
                <a href="cart.php"><i class="fa-solid fa-bag-shopping"></i></a>
                <a href="profile.php"><i class="fa-solid fa-user active"></i></a>
              </li>
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

            <!-- MAIN CONTENT -->
            <main class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <!-- CART -->
                <section id="cart" class="mt-5">
                    <div class="container pt-5 pb-3">
                        <a href="order.html"><h2 class="font-weight-bold">Order</h2></a>
                    </div>
                    <table width="100%">
                        <thead>
                            <tr>
                                <td>Image</td>
                                <td>Product</td>
                                <td>Price</td>
                                <td>Quantity</td>
                                <td>Subtotal</td>
                                <td>Status</td>
                                <td>Actions</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><img src="image/ip p1.jpeg" alt="Product 1"></td>
                                <td>Cartoon A MDN Reference</td>
                                <td>$10,000.00</td>
                                <td>1x</td>
                                <td>$10,000.00</td>
                                <td>Packaging</td>
                                <td><button>View</button></td>
                            </tr>
                            <tr>
                                <td><img src="image/hp/b9.jpg" alt="Product 2"></td>
                                <td>Cartoon A MDN Reference</td>
                                <td>$10,000.00</td>
                                <td>2x</td>
                                <td>$20,000.00</td>
                                <td>Shipping</td>
                                <td><button>View</button></td>
                            </tr>
                            <tr>
                                <td><img src="image/hp/b4.jpg" alt="Product 3"></td>
                                <td>Cartoon A MDN Reference</td>
                                <td>$10,000.00</td>
                                <td>2x</td>
                                <td>$20,000.00</td>
                                <td>Canceled</td>
                                <td><button>View</button></td>
                            </tr>
                        </tbody>
                    </table>
                </section>
            </main>
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
