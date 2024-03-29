<?php
require('./config/constant.php');
session_start();

$status = "";

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || !isset($_SESSION['staffName'])) {
    header("Location: staff_login.php");
    exit();
}

//same as view_product.php
$query = "SELECT p.*, c.catName FROM product p INNER JOIN category c ON p.categoryID = c.categoryID";
$products = mysqli_query($conn, $query);

if (isset($_POST['action']) && $_POST['action'] == 'Delete' && isset($_POST['ID'])) {
    $productID = mysqli_real_escape_string($conn, $_POST['ID']);
    //delete the uploaded image in uploaded directory upon deletion of product
    $imgNameQuery = "SELECT imageName FROM product WHERE prodID = '$productID'"; 
    //set the image name
    $imgNameResult = mysqli_query($conn, $imgNameQuery);

    if ($imgNameRow = mysqli_fetch_assoc($imgNameResult)){

        $imageName = $imgNameRow['imageName'];
        $imagePath = 'img/product/' . $imageName;

        $deleteQuery = "DELETE FROM product WHERE prodID = '$productID'";
        if (mysqli_query($conn, $deleteQuery)) {

            if (file_exists($imagePath)) {
                unlink($imagePath); //delete the file in directory
            }
            $status = "Product deleted successfully, image uploaded removed successfully.";
        } else {
            $status = "Error deleting product: " . mysqli_error($conn);
        }
    } else {
        $status = "Product of image not found.";
    }

    $_SESSION['status'] = $status;
    header("Location: delete_product.php");
    exit();
}

if (isset($_SESSION['status'])) {
    $status = $_SESSION['status'];
    unset($_SESSION['status']);
} else {
    $status = "";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/delete.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <title>Delete Products</title>
    <link rel="icon" href="img/logo2.png" type="image/png">
</head>
<body>
<div class="table-responsive">
    <div class="title-container">
    <h2>Delete Product</h2>
    </div>
        <div class="status-message-container">
        <?php if ($status != ""): ?>
            <p class="status-message"><?php echo $status; ?></p>
        <?php endif; ?>
        </div>
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
                    <th>Actions</th>
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
                        <td>
                            <form method="post" enctype="multipart/form-data" action="">
                                <input type="hidden" name="ID" value="<?php echo $product['prodID']; ?>">
                                <input type="submit" name="action" value="Delete" class="delete-btn" onclick="return confirm('Are you sure you want to delete this product?');">
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?> 
            </tbody>
</table>
        <div class="bottom-buttons">
        <a href="staffdashboard.php">Back to dashboard</a>
        <a href="staff_logout.php">Logout</a>
        </div>
</div>
</body>
</html>

