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

// Ambil keranjang dari session
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Update quantity jika form dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_cart'])) {
    foreach ($_POST['quantities'] as $id => $quantity) {
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = intval($quantity);
        }
    }
    $_SESSION['cart'] = $cart;
    header('Location: cart.php');
    exit;
}

$total = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ragil Cell - Contact Us</title>
    
    <link rel="shortcut icon" type="image/x-icon" href="image/CEL.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" >
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="responif.css">

</head>
 <style>

/* CART */
#cart a{
    text-decoration: none;
    color: #0a0a0a;
}

#cart{
    overflow-x: auto;
}

#cart table{
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed;
    white-space: nowrap;
}

#cart table img{
    width: 70px;
}

#cart table td:nth-child(1){
    width: 150px;
    text-align: center;
}

#cart table td:nth-child(2){
    width: 250px;
    text-align: center;
}

#cart table td:nth-child(3),
#cart table td:nth-child(4),
#cart table td:nth-child(5){
    width: 150px;
    text-align: center;
}

#cart table td:nth-child(6){
    width: 100px;
    text-align: center;
}

#cart table td:nth-child(4) input{
    width: 70px;
    padding: 10px 5px 10px 15px;
}

#cart table thead{
    border:  1px solid #e2e9e1;
    border-left: none;
    border-right: none;
}

#cart table thead tH{
    text-align: center;
}

#cart table thead td{
    font-weight: 700;
    text-transform: uppercase;
    font-size: 13px;
    padding: 18px 0;
}

#cart table tbody tr td{
    padding-top: 15px;
}

#cart table tbody td{
    font-size: 13px;
}

#cart-add{
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
}

#subtotal h3{
    padding-bottom: 15px;
}

#subtotal{
    width: 50%;
    margin-bottom: 30px;
    padding: 30px;
}

#subtotal table{
    border-collapse: collapse;
    width: 100%;
    margin-bottom: 20px;
}

#subtotal table td{
    width: 50%;
    border: 1px solid #e2e9e1;
    padding: 10px;
    font-size: 13px;
}

.fa-circle-xmark:before, .fa-times-circle:before, .fa-xmark-circle:before {
    content: "\f057";
    cursor: pointer;
}

#subtotal button {
    padding: 10px 20px;
    border: none;
    cursor: pointer;
    font-size: 14px;
    border-radius: 5px;
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
                  <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
                  <li class="nav-item"><a class="nav-link" href="shop.php">Shop</a></li>
                  <li class="nav-item"><a class="nav-link" href="blog.php">Blog</a></li>
                  <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                  <li class="nav-item"><a class="nav-link" href="contact.php">Contact Us</a></li>
                  <li class="nav-item">
                      <a href="cart.php"><i class="fa-solid fa-bag-shopping active"></i></a>
                      <a href="profile.php"><i class="fa-solid fa-user"></i></a>
                  </li>
              </ul>
          </div>
      </div>
    </nav>
    <!-- cart -->
    <section id="cart" class="container my-5 pt-5">
        <div class="mt-5 py-2">
            <h2 class="font-weight-bold">Cart</h2>
            <hr>
        </div>
        <form method="POST" action="">
            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                    <tbody>
                        <?php
                        if (empty($cart)) {
                            echo '<tr><td colspan="6" style="text-align:center;">Product does not exist</td></tr>';
                        } else {
                            foreach ($cart as $id => $item) {
                                $subtotal = $item['price'] * $item['quantity'];
                                $total += $subtotal;
                                echo '<tr>
                                        <td><img src="image/' . $item['image'] . '" alt=""></td>
                                        <td>' . $item['name'] . '</td>
                                        <td>' . number_format($item['price'], 0, ',', '.') . '</td>
                                        <td>
                                            <input type="number" name="quantities[' . $id . ']" value="' . $item['quantity'] . '" min="1" style="width: 60px;">
                                        </td>
                                        <td id="subtotal-' . $id . '">' . number_format($subtotal, 0, ',', '.') . '</td>
                                        <td>
                                            <a href="remove_from_cart.php?id=' . $id . '">
                                                <i class="far fa-times-circle" style="color: #dc3545;"></i>
                                            </a>
                                        </td>
                                    </tr>';
                            }
                        }
                        ?>
                    </tbody>
            </table>
        </form>
    </section>

    <section id="cart-add" class="container">
        <div id="subtotal">
            <h3>Cart Totals</h3>
            <table>
                <tr>
                    <td><strong>Total</strong></td>
                    <td><strong id="cart-total"><?php echo number_format($total, 0, ',', '.'); ?></strong></td>
                </tr>
            </table>
            <a href="checkout.php"><button>Proceed to checkout</button></a>
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


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT88Wxj5T4aA4jTn5E1f5F4D69GxTfIF4s84n4k3i0R0cf0G7UM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ZVP8jSK7SK0E0+KXekbL2ms0yQz4Lz7d2Df3AiYg2A2hNjnbC7bEB2Oh9hV9br9a" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Ambil semua elemen input quantity
            const quantityInputs = document.querySelectorAll('input[name^="quantities"]');

            // Loop melalui setiap input dan tambahkan event listener
            quantityInputs.forEach(function(input) {
                input.addEventListener('change', function() {
                    const id = this.name.match(/\d+/)[0]; // Ambil id produk dari nama input
                    const quantity = this.value; // Ambil nilai quantity

                    // Kirim request AJAX untuk memperbarui subtotal dan total
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', 'update_cart_quantity.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            // Ambil data yang dikembalikan dari server
                            const response = JSON.parse(xhr.responseText);
                            // Perbarui subtotal produk
                            document.querySelector(`#subtotal-${id}`).textContent = response.subtotal;
                            // Perbarui total keranjang
                            document.querySelector('#cart-total').textContent = response.total;
                        }
                    };
                    xhr.send('id=' + id + '&quantity=' + quantity);
                });
            });
        });
    </script>

</body>
</html>
