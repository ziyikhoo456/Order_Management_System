<?php

require('./config/constant.php');
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || !isset($_SESSION['staffName'])) {
    header("Location: register.php");
    exit();
}

$query = "SELECT p.*, c.catName FROM product p INNER JOIN category c ON p.categoryID = c.categoryID";
$products = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product List</title>
</head>
<body>
    <h2>Product List</h2>
    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Product Stock</th>
                <th>Product Price</th>
                <th>Description</th>
                <th>Image Name</th>
                <th>Category</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($product = mysqli_fetch_assoc($products)): ?>  
                <tr>
                    <td><?php echo htmlspecialchars($product['prodName']); ?></td>
                    <td><?php echo htmlspecialchars($product['prodStock']); ?></td>
                    <td><?php echo htmlspecialchars($product['prodPrice']); ?></td>
                    <td><?php echo htmlspecialchars($product['description']); ?></td>
                    <td><?php echo htmlspecialchars($product['imageName']); ?></td>
                    <td><?php echo htmlspecialchars($product['catName']); ?></td>
                </tr>
            <?php endwhile; ?> 
        </tbody>
    </table>
    <a href="staffdashboard.php">Back to dashboard</a>
    <a href="logout.php">Logout</a>
</body>
</html>
