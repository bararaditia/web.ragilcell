<?php
session_start();
require_once 'admin/db_connect.php'; // Pastikan koneksi ke database sudah benar

// Validasi input
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $user_id = $_SESSION['user_id']; // Ambil user ID dari sesi

    // Cek apakah password baru dan konfirmasi password cocok
    if ($new_password !== $confirm_password) {
        $_SESSION['message'] = "Password baru dan konfirmasi password tidak cocok.";
        header("Location: password.php");
        exit;
    }

    // Cek panjang password baru (minimal 8 karakter)
    if (strlen($new_password) < 8) {
        $_SESSION['message'] = "Password baru harus memiliki setidaknya 8 karakter.";
        header("Location: password.php");
        exit;
    }

    // Ambil password lama dari database, pastikan tabelnya benar
    $stmt = $conn->prepare("SELECT password FROM user WHERE id = ?");
    
    // Debugging jika query gagal
    if (!$stmt) {
        die("Error pada query: " . $conn->error);
    }
    
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        // Verifikasi password lama
        if (password_verify($current_password, $hashed_password)) {
            // Jika password cocok, hash password baru
            $new_hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

            // Update password di database
            $update_stmt = $conn->prepare("UPDATE user SET password = ? WHERE id = ?");
            
            if (!$update_stmt) {
                die("Error pada query update: " . $conn->error);
            }

            $update_stmt->bind_param("si", $new_hashed_password, $user_id);

            if ($update_stmt->execute()) {
                $_SESSION['message'] = "Password berhasil diubah!";
            } else {
                $_SESSION['message'] = "Terjadi kesalahan saat mengubah password.";
            }
        } else {
            $_SESSION['message'] = "Password saat ini salah.";
        }
    } else {
        $_SESSION['message'] = "Pengguna tidak ditemukan.";
    }

    $stmt->close();
    $conn->close();

    // Redirect kembali ke halaman password
    header("Location: password.php");
    exit;
}
