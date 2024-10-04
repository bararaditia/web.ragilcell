<?php
session_start();
include 'admin/db_connect.php'; // Pastikan koneksi database sudah benar

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

// Ambil data dari form edit
$userId = $_SESSION['user_id'];
$username = $_POST['username'];
$email = $_POST['email'];
$phone_number = $_POST['phone_number'];
$address = $_POST['address'];

// Validasi input jika perlu, misalnya email yang valid, dsb.
// if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//     // Jika email tidak valid, lakukan sesuatu
// }

// Update data pengguna di database
$query = "UPDATE user SET username = ?, email = ?, phone_number = ?, address = ? WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssssi", $username, $email, $phone_number, $address, $userId);

if ($stmt->execute()) {
    // Jika update berhasil, kembali ke halaman profil
    header("Location: profile.php");
} else {
    echo "Error updating profile: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
