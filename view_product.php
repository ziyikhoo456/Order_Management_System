<?php

require('./config/constant.php');
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || !isset($_SESSION['staffName'])) {
    header("Location: staff_login.php");
    exit();
}

$query = "SELECT p.*, c.catName FROM product p INNER JOIN category c ON p.categoryID = c.categoryID";
$products = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <link rel="stylesheet" href="css/view.css" type="text/css">
    <title>Product List</title> 
    <link rel="icon" href="img/logo2.png" type="image/png">
</head>
<body>
    <div class="product-list-container">
        <h2>Product List</h2>
        <table>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Product Stock</th>
                    <th>Product Price</th>
                    <th>Short Description</th>
                    <th>Long Description</th>
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
                        <td><div class="shortDesc"><?php echo htmlspecialchars($product['shortDesc']); ?></div></td>
                        <td><div class="longDesc"><?php echo htmlspecialchars($product['longDesc']); ?></div></td>
                        <td><?php echo htmlspecialchars($product['imageName']); ?></td>
                        <td><?php echo htmlspecialchars($product['catName']); ?></td>
                    </tr>
                <?php endwhile; ?> 
            </tbody>
        </table>
        <div class="btn-container">
            <a href="staffdashboard.php" class="button">Back to dashboard</a>
            <a href="logout.php" class="button">Logout</a>
        </div>
    </div>
</body>
</html>