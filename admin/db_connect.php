<?php
// Definisikan parameter koneksi database
$host = 'localhost';
$dbname = 'db_ragilcell'; // Sesuaikan dengan nama database
$username = 'root'; // Sesuaikan jika ada username lain
$password = ''; // Jika ada password, tambahkan di sini

// Membuat koneksi MySQLi
$conn = new mysqli($host, $username, $password, $dbname);

// Memeriksa koneksi MySQLi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

try {
    // Inisialisasi koneksi PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set atribut PDO untuk menangani kesalahan
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Tampilkan pesan kesalahan jika koneksi gagal
    die("Koneksi ke database gagal: " . $e->getMessage());
}
?>
