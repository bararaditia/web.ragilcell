<?php
// Memulai session
session_start();

// Memasukkan koneksi database
include 'admin/db_connect.php';

// Mendapatkan data dari form login
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

// Query SQL untuk mencari user berdasarkan username atau email
$sql = "SELECT * FROM user WHERE username = ? OR email = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die('Query gagal: ' . $conn->error);
}

$stmt->bind_param('ss', $username, $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Verifikasi password
    if (password_verify($password, $row['password'])) {
        
        // Simpan data pengguna ke dalam session
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['phone_number'] = $row['phone_number'];
        $_SESSION['address'] = $row['address'];

        // Cek role dan redirect
        if ($row['role'] == 'admin') {
            header("Location: admin/dashboard_utama.php");
            exit();
        } elseif ($row['role'] == 'user') {
            header("Location: home.php");
            exit();
        }

    } else {
        // Password salah
        echo "<script>alert('Username, email, atau password salah!'); window.location.href='signin.html';</script>";
    }

} else {
    // Username atau email tidak ditemukan
    echo "<script>alert('Username, email, atau password salah!'); window.location.href='signin.html';</script>";
}

// Menutup statement dan koneksi
$stmt->close();
$conn->close();
?>
