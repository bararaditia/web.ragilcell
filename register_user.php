<?php
include 'admin/db_connect.php'; // Pastikan file ini berisi pengaturan koneksi

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash password for security
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];
    $role = 'user'; // Default role for new users

    // Prepare SQL statement
    $sql = "INSERT INTO user (username, email, password, phone_number, address, role) VALUES (?, ?, ?, ?, ?, ?)";

    // Validate password length
    if (strlen($_POST['password']) < 8) {
        die("Password must be at least 8 characters long.");
    }

    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters and execute
        $stmt->bind_param('ssssss', $username, $email, $password, $phone_number, $address, $role);
        
        if ($stmt->execute()) {
            // Simpan data pengguna ke dalam session
            session_start();
            $_SESSION['user_id'] = $conn->insert_id; // Misal ID pengguna
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['phone_number'] = $phone_number;
            $_SESSION['address'] = $address;
        
            // Redirect ke halaman profil
            header("Location: home.php");
            exit;
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}

// Close the connection
$conn->close();
?>

