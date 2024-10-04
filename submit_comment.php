<?php
session_start();
include 'admin/db_connect.php'; // Koneksi ke database

if (isset($_POST['comment']) && isset($_SESSION['user_id'])) {
    $product_id = $_POST['product_id'];
    $user_id = $_SESSION['user_id'];
    $comment = $_POST['comment'];

    $stmt = $conn->prepare("INSERT INTO comments (product_id, user_id, comment) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $product_id, $user_id, $comment);

    if ($stmt->execute()) {
        header("Location: productdetail.php?id=" . $product_id); // Redirect kembali ke halaman produk
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    echo "Anda harus login untuk berkomentar.";
}
