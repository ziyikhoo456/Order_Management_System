<?php
require('./config/constant.php');
session_start();

$status = "";

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || !isset($_SESSION['staffName'])) {
    header("Location: register.php");
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
    <title>Delete Products</title>
</head>
<body>
<h2>Delete Product</h2>
<table>
    <thead>
        <tr>
            <th>Product Name</th>
            <th>Product Stock</th>
            <th>Product Price</th>
            <th>Description</th>
            <th>Image Name</th>
            <th>Category</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php while($product = mysqli_fetch_assoc($products)): ?>
            <tr>
                <td><?php echo htmlspecialchars($product['prodName']); ?></td>
                <td><?php echo htmlspecialchars($product['prodStock']); ?></td>
                <td><?php echo htmlspecialchars($product['prodPrice']); ?></td>
                <td><?php echo htmlspecialchars($product['description']); ?></td>
                <td><?php echo htmlspecialchars($product['imageName']); ?></td>
                <td><?php echo htmlspecialchars($product['catName']); ?></td>
                <td>
                    <form method="post" enctype="multipart/form-data" action="">
                        <input type="hidden" name="ID" value="<?php echo $product['prodID']; ?>">
                        <input type="submit" name="action" value="Delete" onclick="return confirm('Are you sure you want to delete this product?');">
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
        <a href="staffdashboard.php">Back to dashboard</a>
        <a href="logout.php">Logout</a>
</body>
</html>

<?php if ($status != ""): ?>
    <p><?php echo $status; ?></p>
<?php endif; ?>
