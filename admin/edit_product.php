<?php
include 'db_connect.php';

if (isset($_POST['editProductId'])) {
    $id = $_POST['editProductId'];
    $name = $_POST['editProductName'];
    $description = $_POST['editProductDescription'];
    $price = $_POST['editProductPrice'];
    $stock = $_POST['editProductStock'];
    $category_id = $_POST['editProductCategory'];
    $rating = $_POST['editProductRating']; // Ambil rating dari form
    
    // Update image jika ada perubahan
    if ($_FILES['editProductImage']['name']) {
        $image = $_FILES['editProductImage']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($image);
        move_uploaded_file($_FILES['editProductImage']['tmp_name'], $target_file);

        $sql = "UPDATE products SET name = ?, description = ?, price = ?, stock = ?, category_id = ?, image = ?, rating = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name, $description, $price, $stock, $category_id, $image, $rating, $id]);
    } else {
        $sql = "UPDATE products SET name = ?, description = ?, price = ?, stock = ?, category_id = ?, rating = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name, $description, $price, $stock, $category_id, $rating, $id]);
    }

    header("Location: manage_product.php");
}
?>
