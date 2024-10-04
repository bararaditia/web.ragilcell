<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ragil Cell - Order Product</title>
    <link rel="shortcut icon" type="image/x-icon" href="image/CEL.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            padding-top: 56px;
        }
        .wrapper {
            display: flex;
            width: 100%;
            align-items: stretch;
            min-height: calc(100vh - 56px);
        }
        .sidebar {
            min-width: 250px;
            max-width: 250px;
            background-color: #f8f9fa;
            transition: all 0.3s;
        }
        .sidebar .sidebar-header {
            padding: 20px;
            background: #DB1313;
            color: #fff;
        }
        .sidebar ul.components {
            padding: 20px 0;
            border-bottom: 1px solid #DB1313;
        }
        .sidebar ul li a {
            padding: 15px;
            font-size: 18px;
            display: block;
            color: #333;
            text-decoration: none;
            transition: all 0.3s;
        }
        .sidebar ul li a:hover {
            color: #DB1313;
            background: #fff;
        }
        .sidebar ul li.active > a {
            color: #fff;
            background: #DB1313;
        }
        #content {
            width: 100%;
            padding: 20px;
            min-height: calc(100vh - 56px);
            transition: all 0.3s;
        }
        .content-container {
            max-width: 1000px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .content-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .content-header h2 {
            font-size: 24px;
            font-weight: bold;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .btn-container {
            text-align: center;
            margin-top: 20px;
        }
        .btn-container .btn {
            width: 100%;
            max-width: 200px;
        }
        .order-summary {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
        }
        @media (max-width: 768px) {
            .sidebar {
                margin-left: -250px;
            }
            .sidebar.active {
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
                <a href="cart.php"><i class="fa-solid fa-bag-shopping active"></i></a>
                <a href="profile.php"><i class="fa-solid fa-user"></i></a>
              </li>
          </div>
        </div>
      </nav>

        <!-- Page Content -->
        <div id="content" class="my-5">
            <div class="content-container">
                <div class="content-header">
                    <h2>Order Product</h2>
                </div>

                <form id="order-form">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="product">Select Product:</label>
                                <select class="form-control" id="product" required>
                                    <option value="">Choose a product...</option>
                                    <option value="iphone12">iPhone 12</option>
                                    <option value="samsungs21">Samsung Galaxy S21</option>
                                    <option value="pixel5">Google Pixel 5</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="quantity">Quantity:</label>
                                <input type="number" class="form-control" id="quantity" min="1" value="1" required>
                            </div>
                            <div class="form-group">
                                <label for="name">Full Name:</label>
                                <input type="text" class="form-control" id="name" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" id="email" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">Phone Number:</label>
                                <input type="tel" class="form-control" id="phone" required>
                            </div>
                            <div class="form-group">
                                <label for="address">Shipping Address:</label>
                                <textarea class="form-control" id="address" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="payment">Payment Method:</label>
                                <select class="form-control" id="payment" required>
                                    <option value="">Choose a payment method...</option>
                                    <option value="credit">Credit Card</option>
                                    <option value="debit">Debit Card</option>
                                    <option value="paypal">PayPal</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="order-summary">
                        <h4>Order Summary</h4>
                        <p>Product: <span id="summary-product"></span></p>
                        <p>Quantity: <span id="summary-quantity"></span></p>
                        <p>Total: <span id="summary-total"></span></p>
                    </div>

                    <div class="btn-container">
                        <button type="submit" class="btn btn-primary">Place Order</button>
                    </div>
                </form>
            </div>
        </div>

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
  
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            // Toggle sidebar on mobile
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });

            // Product prices (you might want to fetch these from a database in a real application)
            const prices = {
                'iphone12': 799,
                'samsungs21': 799,
                'pixel5': 699
            };

            // Update order summary
            function updateSummary() {
                const product = $('#product').val();
                const quantity = $('#quantity').val();
                const total = prices[product] * quantity;

                $('#summary-product').text($('#product option:selected').text());
                $('#summary-quantity').text(quantity);
                $('#summary-total').text(`$${total}`);
            }

            // Update summary when product or quantity changes
            $('#product, #quantity').on('change', updateSummary);

            // Form submission
            $('#order-form').on('submit', function(e) {
                e.preventDefault();
                alert('Order placed successfully!');
                // Here you would typically send the order data to your server
            });
        });
    </script>
</body>
</html>