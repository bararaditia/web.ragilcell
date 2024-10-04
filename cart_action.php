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

// Ambil ID produk dari permintaan POST
$product_id = $_POST['product_id'];

// Lakukan query untuk mendapatkan detail produk dari database
include 'admin/db_connect.php'; // Sambungkan ke database
$query = "SELECT * FROM products WHERE id = $product_id";
$result = mysqli_query($conn, $query);
$product = mysqli_fetch_assoc($result);

// Cek apakah produk ditemukan
if ($product) {
    // Inisialisasi keranjang jika belum ada
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Cek apakah produk sudah ada di keranjang
    $found = false;
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['id'] == $product['id']) {
            // Jika produk sudah ada, tambahkan jumlah
            $_SESSION['cart'][$key]['quantity'] += 1;
            $found = true;
            break;
        }
    }

    // Jika produk belum ada di keranjang, tambahkan sebagai produk baru
    if (!$found) {
        $product['quantity'] = 1;
        $_SESSION['cart'][] = $product;
    }
}

// Redirect ke halaman keranjang
header("Location: cart.php");
exit;
?>
