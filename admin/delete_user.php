<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM user WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: manage_user.php?message=User deleted successfully");
    } else {
        header("Location: manage_user.php?message=Error deleting user: " . $conn->error);
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: manage_user.php?message=Invalid user ID");
}
?>