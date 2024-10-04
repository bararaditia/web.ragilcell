<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];  // Nilai "user" sudah ditetapkan dari form input hidden

    $stmt = $conn->prepare("INSERT INTO user (username, email, phone_number, address, role, password, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("ssssss", $username, $email, $phone_number, $address, $role, $password);

    if ($stmt->execute()) {
        header('Location: manage_user.php');
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
