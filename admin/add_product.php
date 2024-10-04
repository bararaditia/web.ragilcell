<?php
include 'db_connect.php';

if (isset($_POST['productName'])) {
    $name = $_POST['productName'];
    $description = $_POST['productDescription'];
    $price = $_POST['productPrice'];
    $stock = $_POST['productStock'];
    $category_id = $_POST['productCategory'];
    
    // Upload image
    $image = $_FILES['productImage']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($image);
    move_uploaded_file($_FILES['productImage']['tmp_name'], $target_file);
    
    $sql = "INSERT INTO products (name, description, price, stock, category_id, image) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$name, $description, $price, $stock, $category_id, $image]);

    header("Location: manage_product.php");
}
?>
