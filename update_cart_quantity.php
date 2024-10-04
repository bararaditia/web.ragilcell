<?php
session_start();

// Ambil data keranjang dari session
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

if (isset($_POST['id'], $_POST['quantity'])) {
    $id = $_POST['id'];
    $quantity = intval($_POST['quantity']);

    // Perbarui quantity dalam keranjang
    if (isset($cart[$id])) {
        $cart[$id]['quantity'] = $quantity;
    }

    // Simpan kembali keranjang ke session
    $_SESSION['cart'] = $cart;

    // Hitung subtotal dan total
    $subtotal = $cart[$id]['price'] * $cart[$id]['quantity'];
    $total = 0;
    foreach ($cart as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    // Kembalikan data sebagai JSON
    echo json_encode([
        'subtotal' => number_format($subtotal, 0, ',', '.'),
        'total' => number_format($total, 0, ',', '.')
    ]);
}
?>
