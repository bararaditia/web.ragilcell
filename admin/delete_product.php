<?php
// Include file koneksi database
include 'db_connect.php';

// Ambil ID produk dari query string
$product_id = $_GET['id'];

// Query untuk menghapus produk
$sql = "DELETE FROM products WHERE id = ?";
$stmt = $pdo->prepare($sql);

if ($stmt->execute([$product_id])) {
    // Redirect ke halaman manage_product.php setelah berhasil
    header('Location: manage_product.php');
    exit;
} else {
    // Menampilkan pesan error jika penghapusan gagal
    echo "Error deleting product: " . $stmt->errorInfo()[2];
}
?>
