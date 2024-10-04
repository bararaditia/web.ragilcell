<?php
include 'db_connect.php';

$id = $_POST['id'];
$username = $_POST['username'];
$email = $_POST['email'];
$phone_number = $_POST['phone_number'];
$address = $_POST['address'];
$role = $_POST['role'];
$password = $_POST['password'];

// Prepare the SQL update query
$sql = "UPDATE user SET username='$username', email='$email', phone_number='$phone_number', address='$address', role='$role'";

// Only update the password if it's set and meets the length requirement
if (!empty($password)) {
    if (strlen($password) < 8) {
        die("Password must be at least 8 characters long.");
    }
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $sql .= ", password='$hashed_password'";
}

$sql .= " WHERE id='$id'";

if ($conn->query($sql) === TRUE) {
    header('Location: manage_user.php');
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
